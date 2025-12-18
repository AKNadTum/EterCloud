<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PterodactylUserLinkTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Config minimale pour le client Pterodactyl
        config()->set('services.pterodactyl.url', 'https://panel.test');
        config()->set('services.pterodactyl.key', 'test-token');
    }

    public function test_ensure_account_retrieves_existing_by_email(): void
    {
        $user = User::factory()->create([
            'email' => 'foo@example.com',
            'name' => 'Foo Bar',
        ]);

        // Réponse de liste filtrée par email avec un élément
        Http::fake([
            'https://panel.test/api/application/users*' => Http::response([
                'object' => 'list',
                'data' => [
                    [
                        'object' => 'user',
                        'attributes' => [
                            'id' => 123,
                            'email' => 'foo@example.com',
                            'username' => 'foo',
                            'first_name' => 'Foo',
                            'last_name' => 'Bar',
                        ],
                    ],
                ],
            ], 200),
        ]);

        $service = app(UserService::class);
        $id = $service->ensurePterodactylAccount($user);

        $this->assertSame(123, $id);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'pterodactyl_user_id' => 123,
        ]);
    }

    public function test_ensure_account_creates_when_missing(): void
    {
        $user = User::factory()->create([
            'email' => 'new@example.com',
            'name' => 'New User',
        ]);

        Http::fake(function ($request) {
            $url = $request->url();
            $method = strtoupper($request->method());

            if ($url === 'https://panel.test/api/application/users' && $method === 'GET') {
                // Aucun résultat pour l'email => le service tentera une création
                return Http::response([
                    'object' => 'list',
                    'data' => [],
                ], 200);
            }

            if ($url === 'https://panel.test/api/application/users' && $method === 'POST') {
                return Http::response([
                    'object' => 'user',
                    'attributes' => [
                        'id' => 456,
                        'email' => 'new@example.com',
                        'username' => 'new-user',
                        'first_name' => 'New',
                        'last_name' => 'User',
                    ],
                ], 201);
            }

            return Http::response([], 404);
        });

        $service = app(UserService::class);
        $id = $service->ensurePterodactylAccount($user);

        $this->assertSame(456, $id);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'pterodactyl_user_id' => 456,
        ]);
    }

    public function test_ensure_account_creation_with_password(): void
    {
        $user = User::factory()->create([
            'email' => 'bar@example.com',
            'name' => 'Bar Baz',
        ]);

        $self = $this;

        Http::fake(function ($request) use ($self) {
            $url = $request->url();
            $method = strtoupper($request->method());

            if ($url === 'https://panel.test/api/application/users' && $method === 'GET') {
                return Http::response([
                    'object' => 'list',
                    'data' => [],
                ], 200);
            }

            if ($url === 'https://panel.test/api/application/users' && $method === 'POST') {
                $data = (array) $request->data();
                $self->assertArrayHasKey('password', $data, 'Le champ password doit être transmis à Pterodactyl');
                $self->assertSame('Secret123!', $data['password']);

                return Http::response([
                    'object' => 'user',
                    'attributes' => [
                        'id' => 789,
                        'email' => 'bar@example.com',
                        'username' => 'bar-baz',
                        'first_name' => 'Bar',
                        'last_name' => 'Baz',
                    ],
                ], 201);
            }

            return Http::response([], 404);
        });

        $service = app(UserService::class);
        $id = $service->ensurePterodactylAccount($user, 'Secret123!');

        $this->assertSame(789, $id);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'pterodactyl_user_id' => 789,
        ]);
    }
}
