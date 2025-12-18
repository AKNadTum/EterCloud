<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Services\UserService;
use App\Services\StripeService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct(private readonly UserService $users, private readonly StripeService $stripe)
    {
    }

    public function showProfile(): View
    {
        $user = auth()->user();
        $ptero = null;
        if ($user && $user->pterodactyl_user_id) {
            $ptero = $this->users->getPterodactylAccount($user);
        }

        // Prépare des informations basiques de facturation Stripe (lecture seule)
        $billing = null;
        try {
            if ($user) {
                $billing = $this->stripe->getCustomerDetails($user);
            }
        } catch (\Throwable $e) {
            // En cas d'erreur Stripe (mauvaise clé, réseau, etc.), on masque et on continue
            $billing = null;
        }

        return view('dashboard.profile', [
            'ptero' => $ptero,
            'billing' => $billing,
        ]);
    }

    public function updateProfile(UpdateProfileRequest $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validated();

        $this->users->updateProfile($user, $validated);

        return back()->with('status', 'Profil mis à jour avec succès.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $ok = $this->users->changePassword($user, $validated['current_password'], $validated['password']);

        if (! $ok) {
            return back()
                ->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.'])
                ->withInput($request->except(['current_password', 'password', 'password_confirmation']));
        }

        return back()->with('status', 'Mot de passe mis à jour avec succès.');
    }

    public function linkPterodactyl(Request $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validate([
            'ptero_password' => ['nullable', 'string', 'min:8'],
        ]);

        $password = $validated['ptero_password'] ?? null;

        try {
            $id = $this->users->ensurePterodactylAccount($user, $password);
        } catch (\Throwable $e) {
            return back()->withErrors([
                'pterodactyl' => 'Échec de la liaison Pterodactyl: ' . $e->getMessage(),
            ]);
        }

        return back()->with('status', 'Compte Pterodactyl lié (ID: ' . $id . ').');
    }
}
