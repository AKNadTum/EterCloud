<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Services\Pterodactyl\PterodactylLocations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class AdminLocationTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Créer les rôles et permissions nécessaires
        $adminRole = Role::create(['name' => 'Admin', 'slug' => 'admin']);
        Role::create(['name' => 'User', 'slug' => 'user']);

        $permission = Permission::create(['name' => 'Admin Access', 'slug' => 'admin.access']);
        $adminRole->permissions()->attach($permission);

        $this->admin = User::factory()->create([
            'role_id' => $adminRole->id
        ]);
    }

    public function test_admin_can_list_locations()
    {
        Location::create(['ptero_id_location' => 1, 'name' => 'Paris']);

        $this->mock(PterodactylLocations::class, function (MockInterface $mock) {
            $mock->shouldReceive('list')->once()->andReturn([
                'data' => [
                    [
                        'attributes' => [
                            'id' => 1,
                            'short' => 'FR-1',
                            'long' => 'Paris, France'
                        ]
                    ]
                ]
            ]);
        });

        $response = $this->actingAs($this->admin)->get(route('admin.locations.index'));

        $response->assertStatus(200);
        $response->assertSee('Paris');
        $response->assertSee('FR-1');
        $response->assertSee('Paris, France');
    }

    public function test_admin_can_see_create_page()
    {
        $this->mock(PterodactylLocations::class, function (MockInterface $mock) {
            $mock->shouldReceive('list')->once()->andReturn([
                'data' => [
                    [
                        'attributes' => [
                            'id' => 5,
                            'short' => 'US-1',
                            'long' => 'New York'
                        ]
                    ]
                ]
            ]);
        });

        $response = $this->actingAs($this->admin)->get(route('admin.locations.create'));

        $response->assertStatus(200);
        $response->assertSee('New York');
        $response->assertSee('5');
    }

    public function test_admin_can_store_location()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.locations.store'), [
            'name' => 'London',
            'ptero_id_location' => 10,
        ]);

        $response->assertRedirect(route('admin.locations.index'));
        $this->assertDatabaseHas('locations', [
            'name' => 'London',
            'ptero_id_location' => 10,
        ]);
    }

    public function test_admin_can_update_location()
    {
        $location = Location::create(['ptero_id_location' => 1, 'name' => 'Paris']);

        $response = $this->actingAs($this->admin)->put(route('admin.locations.update', $location), [
            'name' => 'Paris Updated',
            'ptero_id_location' => 2,
        ]);

        $response->assertRedirect(route('admin.locations.index'));
        $this->assertDatabaseHas('locations', [
            'id' => $location->id,
            'name' => 'Paris Updated',
            'ptero_id_location' => 2,
        ]);
    }
}
