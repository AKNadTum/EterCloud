<?php

namespace App\Services\Pterodactyl;

/**
 * Pterodactyl Application API — Servers endpoints & operations.
 * Docs: /api/application/servers
 */
class PterodactylServers
{
    public function __construct(private readonly PterodactylApplication $api)
    {
    }

    // Listing & retrieval
    public function list(array $query = []): array
    {
        return $this->api->get('/servers', $query);
    }

    public function get(int $serverId, array $query = []): array
    {
        return $this->api->get("/servers/{$serverId}", $query);
    }

    public function getByExternalId(string $externalId, array $query = []): array
    {
        return $this->api->get("/servers/external/{$externalId}", $query);
    }

    // Create & delete
    public function create(array $payload): array
    {
        // Voir la doc Pterodactyl pour le payload attendu (name, user, egg, docker_image, limits, allocation, environment, etc.)
        return $this->api->post('/servers', $payload);
    }

    public function delete(int $serverId): array
    {
        return $this->api->delete("/servers/{$serverId}");
    }

    public function deleteForce(int $serverId): array
    {
        return $this->api->delete("/servers/{$serverId}/force");
    }

    // Server management
    public function updateDetails(int $serverId, array $payload): array
    {
        // ex: name, user (transfer ownership), description
        return $this->api->patch("/servers/{$serverId}/details", $payload);
    }

    public function updateBuild(int $serverId, array $payload): array
    {
        // ex: limits (memory, disk, cpu), feature_limits, allocation(s)
        return $this->api->patch("/servers/{$serverId}/build", $payload);
    }

    public function updateStartup(int $serverId, array $payload): array
    {
        // ex: startup, egg, image, environment
        return $this->api->patch("/servers/{$serverId}/startup", $payload);
    }

    public function suspend(int $serverId): array
    {
        return $this->api->post("/servers/{$serverId}/suspend");
    }

    public function unsuspend(int $serverId): array
    {
        return $this->api->post("/servers/{$serverId}/unsuspend");
    }

    public function reinstall(int $serverId): array
    {
        return $this->api->post("/servers/{$serverId}/reinstall");
    }

    public function rebuild(int $serverId): array
    {
        return $this->api->post("/servers/{$serverId}/rebuild");
    }

    public function triggerTransfer(int $serverId, array $payload): array
    {
        // ex: { node: int, allocations: { default: int, additional?: int[] } }
        return $this->api->post("/servers/{$serverId}/transfer", $payload);
    }

    // Databases management for a server
    public function databases(int $serverId, array $query = []): array
    {
        return $this->api->get("/servers/{$serverId}/databases", $query);
    }

    public function database(int $serverId, int $databaseId, array $query = []): array
    {
        return $this->api->get("/servers/{$serverId}/databases/{$databaseId}", $query);
    }

    public function createDatabase(int $serverId, array $payload): array
    {
        // ex: { database: string, remote: string, host: int } selon la version
        return $this->api->post("/servers/{$serverId}/databases", $payload);
    }

    public function resetDatabasePassword(int $serverId, int $databaseId): array
    {
        return $this->api->post("/servers/{$serverId}/databases/{$databaseId}/reset-password");
    }

    public function deleteDatabase(int $serverId, int $databaseId): array
    {
        return $this->api->delete("/servers/{$serverId}/databases/{$databaseId}");
    }
}
