<?php

namespace App\Services;

use App\Models\User;
use App\Services\Pterodactyl\PterodactylUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService
{
    public function __construct(private readonly PterodactylUsers $pteroUsers)
    {
    }

    /**
     * Met à jour le profil utilisateur.
     */
    public function updateProfile(User $user, array $data): void
    {
        // Si l'email est présent dans les données et qu'il est différent de l'actuel
        if (isset($data['email']) && $data['email'] !== $user->email) {
            $user->email_verified_at = null; // Invalide la vérification actuelle

            // On remplit les données avant d'envoyer la notification pour que l'email soit à jour
            $user->fill($data);
            $user->save();

            // Envoie le nouveau lien de vérification à la nouvelle adresse
            $user->sendEmailVerificationNotification();
            return;
        }

        $user->fill($data);
        $user->save();
    }

    /**
     * Change le mot de passe si le mot de passe courant est correct.
     * Retourne true si succès, false sinon.
     */
    public function changePassword(User $user, string $current, string $new): bool
    {
        if (! Hash::check($current, $user->password)) {
            return false;
        }

        $user->password = Hash::make($new);
        $user->save();

        return true;
    }

    /**
     * Assure la présence d'un compte Pterodactyl pour l'utilisateur.
     * - Si déjà lié: retourne l'id.
     * - Sinon: tente de récupérer par email, puis crée si absent.
     * Enregistre et retourne l'identifiant Pterodactyl.
     *
     * Optionnel: mot de passe lors de la création (non stocké localement).
     */
    public function ensurePterodactylAccount(User $user, ?string $password = null): int
    {
        if ($user->pterodactyl_user_id) {
            return (int) $user->pterodactyl_user_id;
        }

        // 1) Essayer de retrouver par email
        $foundId = null;
        try {
            $byEmail = $this->pteroUsers->getByEmail($user->email);
            $foundId = (int) (($byEmail['attributes']['id'] ?? null) ?: ($byEmail['id'] ?? null));
        } catch (\Throwable) {
            // ignore: non trouvé
        }

        // 2) Sinon créer l'utilisateur
        if (! $foundId) {
            $username = $this->buildPterodactylUsername($user);

            // Tente une création, avec fallback si username déjà pris
            $attempts = 0;
            do {
                $payload = [
                    'email' => $user->email,
                    'username' => $username,
                    'first_name' => (string) ($user->first_name ?: ($user->name ?: 'User')),
                    'last_name' => (string) ($user->last_name ?: '.'),
                ];
                if ($password !== null && $password !== '') {
                    $payload['password'] = $password;
                }

                try {
                    $created = $this->pteroUsers->create($payload);
                    $foundId = (int) ($created['attributes']['id'] ?? 0);
                } catch (\Illuminate\Http\Client\RequestException $e) {
                    // Conflit d'unicité (email/username) côté Pterodactyl
                    $status = $e->response?->status();
                    $body = (array) ($e->response?->json() ?? []);

                    // Si email déjà pris, on tente de récupérer par email à nouveau
                    if ($status === 422 || $status === 409) {
                        try {
                            $byEmail = $this->pteroUsers->getByEmail($user->email);
                            $foundId = (int) (($byEmail['attributes']['id'] ?? null) ?: ($byEmail['id'] ?? null));
                            if ($foundId > 0) {
                                break;
                            }
                        } catch (\Throwable) {
                            // ignore: non trouvé par email
                        }

                        // Vérifier si c'est un conflit de username dans les erreurs renvoyées
                        $bodyString = (string) json_encode($body);
                        if (str_contains($bodyString, 'username') &&
                            (str_contains($bodyString, 'taken') || str_contains($bodyString, 'already exists'))) {
                            $username = $this->mutateUsername($username, ++$attempts);
                        } else {
                            // C'est une autre erreur de validation (ex: mot de passe trop court, etc.)
                            throw $e;
                        }
                    } else {
                        throw $e;
                    }
                }
            } while (! $foundId && $attempts < 3);

            if (! $foundId) {
                throw new \RuntimeException('Impossible de créer/récupérer le compte Pterodactyl.');
            }
        }

        $user->pterodactyl_user_id = $foundId;
        $user->save();

        return $foundId;
    }

    /**
     * Retourne les informations du compte Pterodactyl lié (attributes) ou null.
     */
    public function getPterodactylAccount(User $user): ?array
    {
        $id = (int) ($user->pterodactyl_user_id ?? 0);
        if ($id <= 0) {
            return null;
        }

        try {
            $res = $this->pteroUsers->get($id);
            return (array) ($res['attributes'] ?? null);
        } catch (\Throwable) {
            return null;
        }
    }

    private function buildPterodactylUsername(User $user): string
    {
        $base = $user->name ?: ($user->first_name ?: 'user');
        $base = strtolower($base);
        // Contrainte simple: caractères autorisés a-z0-9_-. et limite raisonnable
        $base = preg_replace('/[^a-z0-9_\.\-]+/i', '-', $base) ?: 'user';
        $base = trim($base, '-_.');
        $base = $base !== '' ? $base : 'user';
        return substr($base, 0, 32);
    }

    private function mutateUsername(string $username, int $attempt): string
    {
        $suffix = '-' . dechex(random_int(0, 0xFFF));
        $maxBase = max(1, 32 - strlen($suffix));
        $base = substr($username, 0, $maxBase);
        $candidate = rtrim($base, '-_.') . $suffix;
        return $candidate;
    }
}
