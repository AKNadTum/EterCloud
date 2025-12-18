<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService)
    {
    }

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function showForgetPassword(): View
    {
        return view('auth.forgot-password');
    }

    public function register(\App\Http\Requests\RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = $this->authService->register($validated);

        // Login auto après inscription
        auth()->login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('home'))
            ->with('status', 'Bienvenue, votre compte a été créé.');
    }

    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable'],
        ]);

        $remember = $request->boolean('remember');

        $ok = $this->authService->login([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ], $remember);

        if (!$ok) {
            return back()
                ->withErrors(['email' => 'Identifiants invalides.'])
                ->withInput($request->only('email', 'remember'));
        }

        $request->session()->regenerate();

        return redirect()->intended(route('home'))
            ->with('status', 'Connexion réussie.');
    }

    public function logout(Request $request): RedirectResponse
    {
        $this->authService->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('status', 'Vous êtes déconnecté.');
    }
}
