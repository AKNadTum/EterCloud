<?php

namespace App\Services\Pterodactyl;

/**
 * Pterodactyl Application API — Nodes & Allocations endpoints.
 * Docs: /api/application/nodes
 */
class PterodactylNodes
{
    public function __construct(private readonly PterodactylApplication $api)
    {
    }

    public function list(array $query = []): array
    {
        return $this->api->get('/nodes', $query);
    }

    public function get(int $nodeId, array $query = []): array
    {
        return $this->api->get("/nodes/{$nodeId}", $query);
    }

    public function create(array $payload): array
    {
        return $this->api->post('/nodes', $payload);
    }

    public function update(int $nodeId, array $payload): array
    {
        return $this->api->patch("/nodes/{$nodeId}", $payload);
    }

    public function delete(int $nodeId): array
    {
        return $this->api->delete("/nodes/{$nodeId}");
    }

    // Allocations
    public function listAllocations(int $nodeId, array $query = []): array
    {
        return $this->api->get("/nodes/{$nodeId}/allocations", $query);
    }

    public function createAllocations(int $nodeId, array $payload): array
    {
        // Payload: { ip: string, ports: array<int|string>, alias?: string } (selon la config du node)
        return $this->api->post("/nodes/{$nodeId}/allocations", $payload);
    }

    public function deleteAllocation(int $allocationId): array
    {
        // DELETE /api/application/allocations/{id}
        return $this->api->delete("/allocations/{$allocationId}");
    }
}
