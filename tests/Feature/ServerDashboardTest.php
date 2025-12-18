<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\Pterodactyl\PterodactylServers;
use App\Services\StripeService;
use App\Services\ServerService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class ServerDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_server_index_displays_location_and_node()
    {
        $user = User::factory()->create(['pterodactyl_user_id' => 123]);
        $this->actingAs($user);

        $this->mock(StripeService::class, function (MockInterface $mock) {
            $mock->shouldReceive('getCustomerDetails')->andReturn([
                'plan' => null,
            ]);
        });

        $this->mock(PterodactylServers::class, function (MockInterface $mock) {
            $mock->shouldReceive('list')
                ->with(['include' => 'node,location'])
                ->andReturn([
                    'data' => [
                        [
                            'attributes' => [
                                'id' => 1,
                                'user' => 123,
                                'name' => 'Mon Serveur',
                                'description' => 'Ma description',
                                'identifier' => 'abc123',
                                'uuid' => 'uuid-123',
                                'relationships' => [
                                    'node' => [
                                        'attributes' => [
                                            'name' => 'Node 1'
                                        ]
                                    ],
                                    'location' => [
                                        'attributes' => [
                                            'short' => 'FR'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]);
        });

        $response = $this->get(route('dashboard.servers'));

        $response->assertStatus(200);
        $response->assertSee('Mon Serveur');
        $response->assertSee('FR');
        $response->assertSee('Node 1');
    }

    public function test_server_index_handles_demo_servers()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->mock(StripeService::class, function (MockInterface $mock) {
            $mock->shouldReceive('getCustomerDetails')->andReturn([
                'plan' => null,
            ]);
        });

        // Simuler un serveur de démo en session
        session(['demo_servers' => [
            [
                'id' => 'demo-123',
                'name' => 'Serveur Démo',
                'description' => 'Démo',
                'is_demo' => true,
            ]
        ]]);

        $response = $this->get(route('dashboard.servers'));

        $response->assertStatus(200);
        $response->assertSee('Serveur Démo');
        $response->assertSee('DÉMO');
        // Ne devrait pas afficher de localisation ou node pour la démo
        $response->assertDontSee('text-[10px] font-bold uppercase tracking-wider text-gray-400');
    }
}
