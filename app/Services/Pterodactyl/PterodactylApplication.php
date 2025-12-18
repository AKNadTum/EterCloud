<?php

namespace App\Services\Pterodactyl;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

/**
 * Lightweight integration for Pterodactyl Application API.
 *
 * Scope: infrastructure-only (no controllers/actions yet). This service
 * provides a prepared HTTP client and simple helpers for future features.
 */
class PterodactylApplication
{
    protected string $baseUrl;
    protected string $token;

    public function __construct()
    {
        $this->baseUrl = rtrim((string) config('services.pterodactyl.url'), '/');
        $this->token   = (string) config('services.pterodactyl.key');
    }

    protected function apiPrefix(): string
    {
        return '/api/application';
    }

    /**
     * Prepared HTTP client for Pterodactyl Application API.
     */
    protected function client(): PendingRequest
    {
        if ($this->baseUrl === '' || $this->token === '') {
            throw new \RuntimeException('Missing Pterodactyl config. Set PTERO_URL and PTERO_API_KEY in .env');
        }

        return Http::timeout(20)
            ->baseUrl($this->baseUrl)
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
            ->withToken($this->token);
    }

    /**
     * Generic GET helper.
     */
    public function get(string $path, array $query = []): array
    {
        $res = $this->client()->get($this->fullPath($path), $query);
        $res->throw();
        return (array) $res->json();
    }

    /**
     * Generic POST helper.
     */
    public function post(string $path, array $payload = []): array
    {
        $res = $this->client()->post($this->fullPath($path), $payload);
        $res->throw();
        return (array) $res->json();
    }

    /**
     * Generic PATCH helper.
     */
    public function patch(string $path, array $payload = []): array
    {
        $res = $this->client()->patch($this->fullPath($path), $payload);
        $res->throw();
        return (array) $res->json();
    }

    /**
     * Generic DELETE helper. Returns response JSON if provided, otherwise an empty array.
     */
    public function delete(string $path): array
    {
        $res = $this->client()->delete($this->fullPath($path));
        $res->throw();
        return (array) ($res->json() ?? []);
    }

    /**
     * Build full API path including the application API prefix.
     */
    protected function fullPath(string $path): string
    {
        $trimmed = '/' . ltrim($path, '/');
        // Avoid double prefixing if full path already includes /api/application
        if (str_starts_with($trimmed, $this->apiPrefix() . '/')) {
            return $trimmed;
        }
        return $this->apiPrefix() . $trimmed;
    }
}
