<?php

namespace App\Services\Pterodactyl;

/**
 * Pterodactyl Application API — Users endpoints.
 * Docs: /api/application/users
 */
class PterodactylUsers
{
    public function __construct(private readonly PterodactylApplication $api)
    {
    }

    public function list(array $query = []): array
    {
        return $this->api->get('/users', $query);
    }

    public function get(int $userId, array $query = []): array
    {
        return $this->api->get("/users/{$userId}", $query);
    }

    public function getByExternalId(string $externalId, array $query = []): array
    {
        return $this->api->get("/users/external/{$externalId}", $query);
    }

    /**
     * Resolve a user by email using the filter param.
     * Returns the first matching item in the same shape as get()/create() (i.e. with 'attributes').
     */
    public function getByEmail(string $email): array
    {
        // Pterodactyl supports filter[email]
        $res = $this->list([
            'filter[email]' => $email,
            'per_page' => 1,
        ]);
        $first = $res['data'][0] ?? null;
        if (!$first) {
            throw new \RuntimeException('Pterodactyl user not found for email');
        }
        return (array) $first;
    }

    public function create(array $payload): array
    {
        // Expected keys: email, username, first_name, last_name, password?, language?, external_id?
        return $this->api->post('/users', $payload);
    }

    public function update(int $userId, array $payload): array
    {
        return $this->api->patch("/users/{$userId}", $payload);
    }

    public function delete(int $userId): array
    {
        return $this->api->delete("/users/{$userId}");
    }
}
