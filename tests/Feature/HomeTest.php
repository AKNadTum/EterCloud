<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\Plan;
use App\Services\Pterodactyl\PterodactylLocations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_displays_plans_and_enriched_locations()
    {
        $plan = Plan::create([
            'name' => 'Premium Plan',
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

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Premium Plan');
        $response->assertSee('Localisation: BE - Belgique - Bruxelles');
    }
}
