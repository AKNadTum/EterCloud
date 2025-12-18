<?php

namespace App\Services\Pterodactyl;

/**
 * Pterodactyl Application API — Locations endpoints.
 * Docs: /api/application/locations
 */
class PterodactylLocations
{
    public function __construct(private readonly PterodactylApplication $api)
    {
    }

    public function list(array $query = []): array
    {
        return $this->api->get('/locations', $query);
    }

    public function get(int $locationId, array $query = []): array
    {
        return $this->api->get("/locations/{$locationId}", $query);
    }

    public function create(array $payload): array
    {
        // { short: string, long: string }
        return $this->api->post('/locations', $payload);
    }

    public function update(int $locationId, array $payload): array
    {
        return $this->api->patch("/locations/{$locationId}", $payload);
    }

    public function delete(int $locationId): array
    {
        return $this->api->delete("/locations/{$locationId}");
    }
}
