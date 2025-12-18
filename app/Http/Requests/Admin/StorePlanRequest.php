<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('admin');
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_stripe_id' => 'required|string',
            'server_limit' => 'required|integer|min:1',
            'cpu' => 'required|integer|min:0',
            'memory' => 'required|integer|min:0',
            'disk' => 'required|integer|min:0',
            'databases_limit' => 'required|integer|min:0',
            'backups_limit' => 'required|integer|min:0',
            'locations' => 'nullable|array',
            'locations.*' => 'exists:locations,id',
        ];
    }
}
