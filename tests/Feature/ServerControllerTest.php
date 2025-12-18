<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\Plan;
use App\Models\User;
use App\Services\Pterodactyl\PterodactylLocations;
use App\Services\Pterodactyl\PterodactylNests;
use App\Services\StripeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class ServerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_view_displays_pterodactyl_location_details()
    {
        $user = User::factory()->create();
        $plan = Plan::create([
            'name' => 'Premium',
            'price_stripe_id' => 'price_123',
            'server_limit' => 1,
            'disk' => 10240,
            'backups_limit' => 2,
            'databases_limit' => 2,
        ]);

        $location = Location::create([
            'ptero_id_location' => 1,
            'name' => 'Internal Name',
        ]);
        $plan->locations()->attach($location);

        $this->actingAs($user);

        $this->mock(StripeService::class, function (MockInterface $mock) use ($plan) {
            $mock->shouldReceive('getCustomerDetails')->andReturn([
                'plan' => $plan,
            ]);
        });

        $this->mock(PterodactylNests::class, function (MockInterface $mock) {
            $mock->shouldReceive('list')->andReturn(['data' => []]);
        });

        $this->mock(PterodactylLocations::class, function (MockInterface $mock) {
            $mock->shouldReceive('list')->andReturn([
                'data' => [
                    [
                        'attributes' => [
                            'id' => 1,
                            'short' => 'BE',
                            'long' => 'Belgique - Bruxelles',
                        ]
                    ]
                ]
            ]);
        });

        $response = $this->get(route('dashboard.servers.create'));

        $response->assertStatus(200);
        // On s'attend à voir le short code et le nom long (description)
        $response->assertSee('BE');
        $response->assertSee('Belgique - Bruxelles');
        // On ne devrait plus voir le nom interne "Internal Name" s'il est remplacé
        $response->assertDontSee('Internal Name');
    }
}
