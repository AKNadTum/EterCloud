<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    protected function prepareForValidation(): void
    {
        $normalize = static function (?string $value): string {
            $value = trim((string) $value);
            return (string) preg_replace('/\s+/u', ' ', $value);
        };

        $firstProvided = $this->has('first_name');
        $lastProvided = $this->has('last_name');

        $first = $firstProvided ? $normalize($this->input('first_name')) : null;
        $last = $lastProvided ? $normalize($this->input('last_name')) : null;

        $name = $this->input('name');
        $name = is_string($name) ? $normalize($name) : '';

        // Composer le nom si prénom/nom fournis et que name est vide
        if (($firstProvided || $lastProvided) && $name === '') {
            $composed = trim(($first ?? $this->user()?->first_name ?? '') . ' ' . ($last ?? $this->user()?->last_name ?? ''));
            $name = (string) preg_replace('/\s+/u', ' ', $composed);
        }

        $toMerge = [];
        if ($firstProvided) { $toMerge['first_name'] = $first; }
        if ($lastProvided) { $toMerge['last_name'] = $last; }
        if ($name !== '') { $toMerge['name'] = $name; }

        if ($toMerge) {
            $this->merge($toMerge);
        }
    }

    public function rules(): array
    {
        $userId = $this->user()?->id;

        return [
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'name' => [
                'nullable', 'string', 'max:255',
                Rule::unique('users', 'name')->ignore($userId),
            ],
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
        ];
    }
}
