<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\Plan;
use App\Models\User;
use App\Services\Pterodactyl\PterodactylLocations;
use App\Services\Pterodactyl\PterodactylNests;
use App\Services\Pterodactyl\PterodactylNodes;
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

        $this->mock(PterodactylNodes::class, function (MockInterface $mock) {
            $mock->shouldReceive('list')->andReturn([
                'data' => [
                    [
                        'attributes' => [
                            'id' => 101,
                            'location_id' => 1,
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

    public function test_create_view_filters_locations_without_nodes()
    {
        $user = User::factory()->create();
        $plan = Plan::create([
            'name' => 'Premium',
            'price_stripe_id' => 'price_123',
            'server_limit' => 1,
            'disk' => 10240,
            'backups_limit' => 2,
            'databases_limit' => 2,
            'memory' => 1024,
            'cpu' => 100,
        ]);

        // Location 1: Has nodes
        $locationWithNodes = Location::create([
            'ptero_id_location' => 1,
            'name' => 'Location With Nodes',
        ]);

        // Location 2: No nodes
        $locationWithoutNodes = Location::create([
            'ptero_id_location' => 2,
            'name' => 'Location Without Nodes',
        ]);

        $plan->locations()->attach([$locationWithNodes->id, $locationWithoutNodes->id]);

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
                            'short' => 'L1',
                            'long' => 'Location 1',
                        ]
                    ],
                    [
                        'attributes' => [
                            'id' => 2,
                            'short' => 'L2',
                            'long' => 'Location 2',
                        ]
                    ]
                ]
            ]);
        });

        $this->mock(PterodactylNodes::class, function (MockInterface $mock) {
            $mock->shouldReceive('list')->andReturn([
                'data' => [
                    [
                        'attributes' => [
                            'id' => 101,
                            'location_id' => 1, // Points to Location 1
                            'name' => 'Node 1',
                        ]
                    ]
                    // No node for Location 2
                ]
            ]);
        });

        $response = $this->get(route('dashboard.servers.create'));

        $response->assertStatus(200);
        $response->assertSee('L1 - Location 1');
        $response->assertDontSee('L2 - Location 2');
    }

    public function test_create_view_redirects_if_no_locations_available()
    {
        $user = User::factory()->create();
        $plan = Plan::create([
            'name' => 'Premium',
            'price_stripe_id' => 'price_123',
            'server_limit' => 1,
            'disk' => 10240,
            'backups_limit' => 2,
            'databases_limit' => 2,
            'memory' => 1024,
            'cpu' => 100,
        ]);

        $this->actingAs($user);

        $this->mock(StripeService::class, function (MockInterface $mock) use ($plan) {
            $mock->shouldReceive('getCustomerDetails')->andReturn([
                'plan' => $plan,
            ]);
        });

        $this->mock(PterodactylLocations::class, function (MockInterface $mock) {
            $mock->shouldReceive('list')->andReturn(['data' => []]);
        });

        $this->mock(PterodactylNodes::class, function (MockInterface $mock) {
            $mock->shouldReceive('list')->andReturn(['data' => []]);
        });

        $response = $this->get(route('dashboard.servers.create'));

        $response->assertRedirect(route('dashboard.servers'));
        $response->assertSessionHas('error', 'Aucune localisation disponible pour votre offre actuellement. Veuillez contacter le support.');
    }

    public function test_store_fails_if_no_locations_available()
    {
        $user = User::factory()->create(['pterodactyl_user_id' => 123]);
        $plan = Plan::create([
            'name' => 'Premium',
            'price_stripe_id' => 'price_123',
            'server_limit' => 1,
            'disk' => 10240,
            'backups_limit' => 2,
            'databases_limit' => 2,
            'memory' => 1024,
            'cpu' => 100,
        ]);

        $this->actingAs($user);

        $this->mock(StripeService::class, function (MockInterface $mock) use ($plan) {
            $mock->shouldReceive('getCustomerDetails')->andReturn([
                'plan' => $plan,
            ]);
        });

        // Pas de locations disponibles
        $this->mock(PterodactylLocations::class, function (MockInterface $mock) {
            $mock->shouldReceive('list')->andReturn(['data' => []]);
        });
        $this->mock(PterodactylNodes::class, function (MockInterface $mock) {
            $mock->shouldReceive('list')->andReturn(['data' => []]);
        });

        $response = $this->post(route('dashboard.servers.store'), [
            'name' => 'My Server',
            'location_id' => 1,
            'nest_id' => 1,
            'egg_id' => 1,
        ]);

        $response->assertRedirect(route('dashboard.servers'));
        $response->assertSessionHas('error', 'Aucune localisation disponible pour votre offre actuellement.');
    }

    public function test_store_fails_if_selected_location_not_available_for_plan()
    {
        $user = User::factory()->create(['pterodactyl_user_id' => 123]);
        $plan = Plan::create([
            'name' => 'Premium',
            'price_stripe_id' => 'price_123',
            'server_limit' => 1,
            'disk' => 10240,
            'backups_limit' => 2,
            'databases_limit' => 2,
            'memory' => 1024,
            'cpu' => 100,
        ]);

        // Location 1: Attachée au plan
        $location1 = Location::create([
            'ptero_id_location' => 1,
            'name' => 'Location 1',
        ]);
        $plan->locations()->attach($location1);

        // Location 2: Pas attachée au plan
        $location2 = Location::create([
            'ptero_id_location' => 2,
            'name' => 'Location 2',
        ]);

        $this->actingAs($user);

        $this->mock(StripeService::class, function (MockInterface $mock) use ($plan) {
            $mock->shouldReceive('getCustomerDetails')->andReturn([
                'plan' => $plan,
            ]);
        });

        // Pterodactyl dit que les deux locations ont des nodes
        $this->mock(PterodactylLocations::class, function (MockInterface $mock) {
            $mock->shouldReceive('list')->andReturn([
                'data' => [
                    ['attributes' => ['id' => 1, 'short' => 'L1', 'long' => 'L1']],
                    ['attributes' => ['id' => 2, 'short' => 'L2', 'long' => 'L2']],
                ]
            ]);
        });
        $this->mock(PterodactylNodes::class, function (MockInterface $mock) {
            $mock->shouldReceive('list')->andReturn([
                'data' => [
                    ['attributes' => ['location_id' => 1]],
                    ['attributes' => ['location_id' => 2]],
                ]
            ]);
        });

        $response = $this->post(route('dashboard.servers.store'), [
            'name' => 'My Server',
            'location_id' => 2, // L'utilisateur essaie de choisir la location 2 qui n'est pas dans son plan
            'nest_id' => 1,
            'egg_id' => 1,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'La localisation sélectionnée n\'est pas disponible pour votre offre.');
    }
}
