<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // L'autorisation est gérée par le middleware auth et la logique du contrôleur
    }

    public function rules(): array
    {
        // Si c'est un serveur démo (utilisateur non lié), les règles sont plus souples
        // Mais idéalement on veut que l'UI envoie toujours la même chose ou on gère ici.

        $rules = [
            'name' => 'required|string|max:80',
            'description' => 'nullable|string|max:255',
        ];

        // Si l'utilisateur est lié, on exige les IDs Pterodactyl
        if ($this->user() && $this->user()->pterodactyl_user_id) {
            $rules = array_merge($rules, [
                'location_id' => 'required|integer',
                'nest_id' => 'required|integer',
                'egg_id' => 'required|integer',
            ]);
        }

        return $rules;
    }
}
