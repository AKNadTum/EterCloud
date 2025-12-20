<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\Plan;
use App\Models\User;
use App\Services\Pterodactyl\PterodactylLocations;
use App\Services\Pterodactyl\PterodactylNests;
use App\Services\Pterodactyl\PterodactylNodes;
use App\Services\Pterodactyl\PterodactylServers;
use App\Services\StripeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class ServerDeploymentAutoDeployTest extends TestCase
{
    use RefreshDatabase;

    public function test_server_creation_uses_auto_deploy()
    {
        $user = User::factory()->create([
            'pterodactyl_user_id' => 123
        ]);

        $plan = Plan::create([
            'name' => 'Premium',
            'price_stripe_id' => 'price_123',
            'server_limit' => 5,
            'disk' => 10240,
            'memory' => 2048,
            'cpu' => 100,
            'backups_limit' => 2,
            'databases_limit' => 2,
        ]);

        $location = Location::create([
            'ptero_id_location' => 10,
            'name' => 'Houyet',
        ]);
        $plan->locations()->attach($location);

        $this->actingAs($user);

        // Mock Stripe
        $this->mock(StripeService::class, function (MockInterface $mock) use ($plan) {
            $mock->shouldReceive('getCustomerDetails')->andReturn([
                'plan' => $plan,
            ]);
        });

        // Mock PterodactylNests
        $this->mock(PterodactylNests::class, function (MockInterface $mock) {
            $mock->shouldReceive('egg')->andReturn([
                'attributes' => [
                    'docker_image' => 'quay.io/pterodactyl/core:java',
                    'startup' => 'java -Xms128M -Xmx{{SERVER_MEMORY}}M -jar {{executable}}',
                ]
            ]);
            $mock->shouldReceive('getEggEnvironmentDefaults')->andReturn([
                'executable' => 'server.jar'
            ]);
        });

        $this->mock(PterodactylLocations::class, function (MockInterface $mock) {
            $mock->shouldReceive('list')->andReturn(['data' => [['attributes' => ['id' => 10, 'short' => 'BE', 'long' => 'Belgium']]]]);
        });

        $this->mock(PterodactylNodes::class, function (MockInterface $mock) {
            $mock->shouldReceive('list')->andReturn(['data' => [['attributes' => ['location_id' => 10]]]]);
        });

        // Mock PterodactylServers pour vérifier le payload
        $this->mock(PterodactylServers::class, function (MockInterface $mock) {
            $mock->shouldReceive('list')->andReturn(['data' => []]);
            $mock->shouldReceive('create')->with(Mockery::on(function ($payload) {
                // On vérifie la présence de 'deploy' au lieu de 'allocation'
                return isset($payload['deploy']) &&
                       $payload['deploy']['locations'] === [10] &&
                       $payload['deploy']['dedicated_ip'] === false &&
                       !isset($payload['allocation']);
            }))->once()->andReturn(['attributes' => ['id' => 1]]);
        });

        $response = $this->post(route('dashboard.servers.store'), [
            'name' => 'Mon Super Serveur',
            'location_id' => 10,
            'nest_id' => 1,
            'egg_id' => 5,
        ]);

        $response->assertRedirect(route('dashboard.servers'));
        $response->assertSessionHas('status', 'Le serveur est en cours de création.');
    }
}
