<?php

namespace Tests\Feature;

use App\Models\Plan;
use App\Models\User;
use App\Services\Pterodactyl\PterodactylServers;
use App\Services\StripeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class ServerManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_delete_a_real_server()
    {
        $user = User::factory()->create(['pterodactyl_user_id' => 123]);
        $this->actingAs($user);

        // On mocke PterodactylServers pour la suppression
        $this->mock(PterodactylServers::class, function (MockInterface $mock) {
            $mock->shouldReceive('delete')->with(456)->once()->andReturn([]);
        });

        $response = $this->delete(route('dashboard.servers.destroy', 'ptero-456'));

        $response->assertRedirect(route('dashboard.servers'));
        $response->assertSessionHas('status', 'Le serveur a été supprimé avec succès.');
    }

    public function test_server_creation_is_blocked_when_limit_reached()
    {
        $user = User::factory()->create(['pterodactyl_user_id' => 123]);
        $this->actingAs($user);

        $plan = Plan::create([
            'name' => 'Free',
            'price_stripe_id' => 'price_free',
            'server_limit' => 1,
            'disk' => 1024,
            'memory' => 512,
            'cpu' => 50,
            'backups_limit' => 1,
            'databases_limit' => 0,
        ]);

        // Mock Stripe pour renvoyer le plan
        $this->mock(StripeService::class, function (MockInterface $mock) use ($plan) {
            $mock->shouldReceive('getCustomerDetails')->andReturn([
                'plan' => $plan,
            ]);
        });

        // Mock PterodactylServers pour simuler qu'il y a déjà 1 serveur
        $this->mock(PterodactylServers::class, function (MockInterface $mock) {
            $mock->shouldReceive('list')->andReturn([
                'data' => [
                    [
                        'attributes' => [
                            'id' => 1,
                            'user' => 123,
                            'name' => 'Existing Server',
                            'identifier' => 'abc12345',
                        ]
                    ]
                ]
            ]);
        });

        $response = $this->post(route('dashboard.servers.store'), [
            'name' => 'New Server',
            'location_id' => 1,
            'nest_id' => 1,
            'egg_id' => 1,
        ]);

        $response->assertSessionHas('error', "Vous avez atteint la limite de serveurs de votre plan (1).");
    }

    public function test_dashboard_shows_server_usage()
    {
        $user = User::factory()->create(['pterodactyl_user_id' => 123]);
        $this->actingAs($user);

        $plan = Plan::create([
            'name' => 'Premium',
            'price_stripe_id' => 'price_premium',
            'server_limit' => 5,
            'disk' => 10240,
            'memory' => 2048,
            'cpu' => 100,
            'backups_limit' => 5,
            'databases_limit' => 5,
        ]);

        $this->mock(StripeService::class, function (MockInterface $mock) use ($plan) {
            $mock->shouldReceive('getCustomerDetails')->andReturn(['plan' => $plan]);
        });

        $this->mock(PterodactylServers::class, function (MockInterface $mock) {
            $mock->shouldReceive('list')->andReturn([
                'data' => [
                    ['attributes' => ['id' => 1, 'user' => 123, 'identifier' => 'id1', 'name' => 'S1']],
                    ['attributes' => ['id' => 2, 'user' => 123, 'identifier' => 'id2', 'name' => 'S2']],
                ]
            ]);
        });

        $response = $this->get(route('dashboard.servers'));

        $response->assertStatus(200);
        $response->assertSee('Utilisation :');
        $response->assertSee('2');
        $response->assertSee('/ 5');
        $response->assertSee('serveurs');
        $response->assertSee('Plan Premium');
    }
}
