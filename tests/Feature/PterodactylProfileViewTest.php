<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PterodactylProfileViewTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Config minimale pour le client Pterodactyl
        config()->set('services.pterodactyl.url', 'https://panel.test');
        config()->set('services.pterodactyl.key', 'test-token');
    }

    public function test_profile_shows_pterodactyl_readonly_info_when_linked(): void
    {
        $user = User::factory()->create([
            'email' => 'view@example.com',
            'name' => 'View User',
            'pterodactyl_user_id' => 77,
        ]);

        Http::fake([
            'https://panel.test/api/application/users/77' => Http::response([
                'object' => 'user',
                'attributes' => [
                    'id' => 77,
                    'email' => 'view@example.com',
                    'username' => 'view-user',
                    'first_name' => 'View',
                    'last_name' => 'User',
                ],
            ], 200),
        ]);

        $this->actingAs($user);

        $res = $this->get('/dashboard/profile');

        $res->assertStatus(200);
        $res->assertSee('Compte lié (ID: 77)');
        $res->assertSee('view-user');
        $res->assertSee('view@example.com');
        $res->assertSee('View');
        $res->assertSee('User');
    }
}
