<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\User;
use App\Services\Pterodactyl\PterodactylNests;
use App\Services\Pterodactyl\PterodactylServers;
use App\Services\Pterodactyl\PterodactylLocations;
use App\Services\Pterodactyl\PterodactylNodes;

class ServerService
{
    public function __construct(
        private readonly PterodactylServers $pteroServers,
        private readonly PterodactylNests $pteroNests,
        private readonly PterodactylLocations $pteroLocations,
        private readonly PterodactylNodes $pteroNodes,
        private readonly UserService $users,
    ) {
    }

    public function isDemoEnabled(): bool
    {
        // Active en environnement de dev/debug, ou via env SERVERS_DEMO=true
        return (bool) (config('app.debug') || env('SERVERS_DEMO'));
    }

    public function hasPterodactylLink(User $user): bool
    {
        return (int) ($user->pterodactyl_user_id ?? 0) > 0;
    }

    /**
     * Retourne les localisations enrichies pour un plan donné,
     * en filtrant celles qui n'ont aucun node sur Pterodactyl.
     */
    public function getAvailableLocationsForPlan(Plan $plan): \Illuminate\Support\Collection
    {
        $pteroLocations = collect($this->pteroLocations->list()['data'] ?? []);
        $pteroNodes = collect($this->pteroNodes->list()['data'] ?? []);

        // On récupère les IDs des localisations qui ont au moins un node
        $locationIdsWithNodes = $pteroNodes->pluck('attributes.location_id')->unique();

        return $plan->locations
            ->filter(function ($location) use ($locationIdsWithNodes) {
                return $locationIdsWithNodes->contains($location->ptero_id_location);
            })
            ->map(function ($location) use ($pteroLocations) {
                $ptero = $pteroLocations->firstWhere('attributes.id', $location->ptero_id_location);
                if ($ptero) {
                    // On utilise le short code et le nom long (description)
                    $location->display_name = $ptero['attributes']['short'] . ' - ' . $ptero['attributes']['long'];
                } else {
                    $location->display_name = $location->name ?? $location->ptero_id_location;
                }
                return $location;
            });
    }

    /**
     * Vérifie si l'utilisateur peut créer un nouveau serveur selon son plan.
     */
    public function canCreateServer(User $user, Plan $plan): bool
    {
        $currentServers = $this->listForUser($user);
        return count($currentServers) < $plan->server_limit;
    }

    /**
     * Crée un serveur réel pour un utilisateur basé sur son plan.
     */
    public function createServerForUser(User $user, Plan $plan, array $data): array
    {
        // 1. Récupérer l'Egg et ses détails
        $egg = $this->pteroNests->egg($data['nest_id'], $data['egg_id']);

        // 2. Préparer le payload avec les limites du Plan et l'auto-déploiement
        $payload = [
            'name' => $data['name'],
            'user' => (int) $user->pterodactyl_user_id,
            'egg' => (int) $data['egg_id'],
            'docker_image' => $egg['attributes']['docker_image'],
            'startup' => $egg['attributes']['startup'],
            'environment' => $this->pteroNests->getEggEnvironmentDefaults($data['nest_id'], (int) $data['egg_id']),
            'limits' => [
                'memory' => $plan->memory,
                'swap' => 0,
                'disk' => $plan->disk,
                'io' => 500,
                'cpu' => $plan->cpu,
            ],
            'feature_limits' => [
                'databases' => $plan->databases_limit,
                'backups' => $plan->backups_limit,
            ],
            'deploy' => [
                'locations' => [(int) $data['location_id']],
                'dedicated_ip' => false,
                'port_range' => [],
            ],
            'start_on_completion' => true,
        ];

        return $this->pteroServers->create($payload);
    }

    /**
     * Crée un serveur démo simulé en session.
     */
    public function createDemoServer(array $data): array
    {
        return [
            'id' => 'demo-' . substr(bin2hex(random_bytes(5)), 0, 10),
            'name' => (string) $data['name'],
            'description' => (string) ($data['description'] ?? ''),
            'identifier' => '',
            'uuid' => '',
            'is_demo' => true,
        ];
    }

    /**
     * Supprime un serveur réel sur Pterodactyl.
     */
    public function deleteServer(int $serverId): bool
    {
        try {
            $this->pteroServers->delete($serverId);
            return true;
        } catch (\Throwable $e) {
            // On pourrait logger l'erreur ici
            throw $e;
        }
    }

    /**
     * Retourne l'URL du panel Pterodactyl pour un serveur.
     */
    public function getServerPanelUrl(array $server): string
    {
        $baseUrl = rtrim((string) config('services.pterodactyl.url'), '/');
        $identifier = $server['identifier'] ?? '';

        return $identifier ? "{$baseUrl}/server/{$identifier}" : $baseUrl;
    }

    /**
     * Récupère les serveurs (Pterodactyl Application API) appartenant à l'utilisateur.
     * Retourne un tableau normalisé prêt pour l'affichage.
     *
     * En cas d'absence de lien Pterodactyl → tableau vide.
     */
    public function listForUser(User $user): array
    {
        if (! $this->hasPterodactylLink($user)) {
            return [];
        }

        $pteroUserId = (int) $user->pterodactyl_user_id;

        try {
            // On récupère la liste des serveurs.
            // Note: Si le nombre de serveurs est très élevé, il faudrait gérer la pagination ou un filtre valide.
            $res = $this->pteroServers->list(['include' => 'node,location']);
        } catch (\Throwable) {
            return [];
        }

        $data = (array) ($res['data'] ?? []);
        $servers = [];
        foreach ($data as $row) {
            if (($row['attributes']['user'] ?? null) == $pteroUserId) {
                $servers[] = $this->normalizePteroServer($row);
            }
        }

        return $servers;
    }

    /**
     * Normalise une entrée server renvoyée par l'API Pterodactyl (data[].attributes...)
     */
    private function normalizePteroServer(array $row): array
    {
        $attr = (array) ($row['attributes'] ?? []);
        $id = $attr['id'] ?? $row['id'] ?? null;
        $identifier = $attr['identifier'] ?? null; // court
        $uuid = $attr['uuid'] ?? null; // complet

        $rel = $attr['relationships'] ?? [];
        $nodeName = $rel['node']['attributes']['name'] ?? null;
        $locationName = $rel['location']['attributes']['short'] ?? $rel['location']['attributes']['name'] ?? null;

        return [
            'id' => $id !== null ? 'ptero-' . $id : ($identifier ? 'ptero-' . $identifier : 'ptero-unknown'),
            'ptero_id' => $id,
            'name' => (string) ($attr['name'] ?? 'Serveur'),
            'description' => (string) ($attr['description'] ?? ''),
            'identifier' => (string) ($identifier ?? ''),
            'uuid' => (string) ($uuid ?? ''),
            'is_demo' => false,
            'node_name' => $nodeName,
            'location_name' => $locationName,
            'panel_url' => $this->getServerPanelUrl(['identifier' => $identifier]),
        ];
    }
}
