<?php

namespace App\Http\Controllers;

use App\Services\ServerService;
use App\Services\StripeService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function __construct(
        private readonly ServerService $serverService,
        private readonly StripeService $stripeService,
    ) {
    }

    public function index(Request $request): View
    {
        $user = $request->user();
        $servers = $this->serverService->listForUser($user);
        $subscription = null;
        $plan = null;

        try {
            $customerDetails = $this->stripeService->getCustomerDetails($user);
            $subscription = $customerDetails['subscription'] ?? null;
            $plan = $customerDetails['plan'] ?? null;
        } catch (\Throwable) {
            // Silently fail if Stripe is not reachable
        }

        return view('dashboard.index', [
            'serversCount' => count($servers),
            'servers' => array_slice($servers, 0, 3), // Show only top 3
            'subscription' => $subscription,
            'plan' => $plan,
        ]);
    }

    public function profile(): View
    {
        return view('dashboard.profile');
    }

    public function servers(): View
    {
        return view('dashboard.servers');
    }

    public function billing(): View
    {
        return view('dashboard.billing');
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
        ]);

        $user->update($validated);

        return back()->with('status', 'Profil mis à jour avec succès.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (! Hash::check($validated['current_password'], $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.'])
                ->withInput($request->except(['current_password', 'password', 'password_confirmation']));
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        return back()->with('status', 'Mot de passe mis à jour avec succès.');
    }
}
