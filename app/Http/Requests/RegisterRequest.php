<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $name = (string) $this->input('name', '');
        $email = (string) $this->input('email', '');

        $normalize = static function (string $value): string {
            $value = trim($value);
            // Compresse les espaces multiples
            $value = (string) preg_replace('/\s+/u', ' ', $value);
            return $value;
        };

        $this->merge([
            'name' => $normalize($name),
            'email' => strtolower(trim($email)),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:users,name'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            // facultatif mais doit être accepté si présent
            'terms' => ['sometimes', 'accepted'],
        ];
    }
}
