<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /**
     * Inscription d'un nouvel utilisateur.
     *
     * @param array{name:string,email:string,password:string} $data
     */
    public function register(array $data): User
    {
        // Le cast "password" => "hashed" dans le modèle User s'occupe du hash
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        event(new Registered($user));

        return $user;
    }

    /**
     * Tentative de connexion d'un utilisateur.
     *
     * @param array{email:string,password:string} $credentials
     */
    public function login(array $credentials, bool $remember = false): bool
    {
        return Auth::attempt($credentials, $remember);
    }

    /**
     * Récupère l'utilisateur courant.
     */
    public function user(): ?AuthenticatableContract
    {
        return Auth::user();
    }

    /**
     * Déconnexion de l'utilisateur courant.
     */
    public function logout(): void
    {
        Auth::logout();
    }
}
