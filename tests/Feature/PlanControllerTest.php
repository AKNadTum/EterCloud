<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\Plan;
use App\Services\Pterodactyl\PterodactylLocations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class PlanControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_redirects_to_home_with_hash()
    {
        $response = $this->get(route('plans.index'));
        $response->assertRedirect(route('home') . '#plans');
    }

    public function test_show_redirects_to_home_with_hash()
    {
        $response = $this->get(route('plans.show', 1));
        $response->assertRedirect(route('home') . '#plans');
    }
}
