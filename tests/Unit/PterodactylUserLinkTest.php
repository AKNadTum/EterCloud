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

    public function test_ensure_account_fails_with_request_exception_if_validation_fails(): void
    {
        $user = User::factory()->create([
            'email' => 'fail@example.com',
            'name' => 'Fail',
        ]);

        Http::fake([
            'https://panel.test/api/application/users?filter%5Bemail%5D=fail%40example.com&per_page=1' => Http::response([
                'object' => 'list',
                'data' => [],
            ], 200),
            'https://panel.test/api/application/users' => Http::response([
                'errors' => [
                    [
                        'code' => 'ValidationException',
                        'detail' => 'The last name field is required.',
                    ]
                ]
            ], 422),
        ]);

        $service = app(UserService::class);

        $this->expectException(\Illuminate\Http\Client\RequestException::class);
        $this->expectExceptionMessage('422');

        $service->ensurePterodactylAccount($user);
    }

    public function test_ensure_account_mutes_username_on_conflict(): void
    {
        $user = User::factory()->create([
            'email' => 'conflict@example.com',
            'name' => 'taken',
        ]);

        Http::fake([
            'https://panel.test/api/application/users?filter%5Bemail%5D=conflict%40example.com&per_page=1' => Http::response([
                'object' => 'list',
                'data' => [],
            ], 200),
            // Première tentative : conflit de username
            'https://panel.test/api/application/users' => Http::sequence()
                ->push([
                    'errors' => [
                        [
                            'code' => 'ValidationException',
                            'detail' => 'The username has already been taken.',
                        ]
                    ]
                ], 422)
                // Deuxième tentative : succès (après mutation)
                ->push([
                    'object' => 'user',
                    'attributes' => ['id' => 888]
                ], 201),
        ]);

        $service = app(UserService::class);
        $id = $service->ensurePterodactylAccount($user);

        $this->assertSame(888, $id);
    }

    public function test_ensure_account_creates_with_default_names_if_missing(): void
    {
        $user = User::factory()->create([
            'email' => 'defaults@example.com',
            'name' => 'OnlyName',
            'first_name' => null,
            'last_name' => null,
        ]);

        Http::fake([
            'https://panel.test/api/application/users?filter%5Bemail%5D=defaults%40example.com&per_page=1' => Http::response([
                'object' => 'list',
                'data' => [],
            ], 200),
            'https://panel.test/api/application/users' => function ($request) {
                $data = $request->data();
                if ($data['first_name'] === 'OnlyName' && $data['last_name'] === '.') {
                    return Http::response([
                        'object' => 'user',
                        'attributes' => ['id' => 999]
                    ], 201);
                }
                return Http::response(['errors' => [['detail' => 'Invalid data']]], 422);
            }
        ]);

        $service = app(UserService::class);
        $id = $service->ensurePterodactylAccount($user);

        $this->assertSame(999, $id);
    }
}
