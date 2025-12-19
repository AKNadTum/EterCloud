<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VerificationRequiredTest extends TestCase
{
    use RefreshDatabase;

    public function test_unverified_user_cannot_access_server_creation_page()
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get(route('dashboard.servers.create'));

        $response->assertRedirect(route('verification.notice'));
    }

    public function test_unverified_user_cannot_store_server()
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->post(route('dashboard.servers.store'), [
            'name' => 'My Server',
            'location_id' => 1,
            'nest_id' => 1,
            'egg_id' => 1,
        ]);

        $response->assertRedirect(route('verification.notice'));
    }

    public function test_verified_user_can_access_server_creation_page()
    {
        $user = User::factory()->create(); // verified par défaut

        // On simule un plan pour éviter la redirection vers l'accueil
        $plan = \App\Models\Plan::create([
            'name' => 'Premium',
            'price_stripe_id' => 'price_123',
            'server_limit' => 1,
            'disk' => 1024,
            'memory' => 512,
            'cpu' => 50,
            'backups_limit' => 1,
            'databases_limit' => 1,
        ]);

        $this->mock(\App\Services\StripeService::class, function ($mock) use ($plan) {
            $mock->shouldReceive('getCustomerDetails')->andReturn(['plan' => $plan]);
        });

        $this->mock(\App\Services\Pterodactyl\PterodactylNests::class, function ($mock) {
            $mock->shouldReceive('list')->andReturn(['data' => []]);
        });

        $response = $this->actingAs($user)->get(route('dashboard.servers.create'));

        $response->assertStatus(200);
    }

    public function test_email_change_resets_verification()
    {
        $user = User::factory()->create(['email' => 'old@example.com']);
        $this->assertTrue($user->hasVerifiedEmail());

        $response = $this->actingAs($user)->put(route('dashboard.profile.update'), [
            'name' => $user->name,
            'email' => 'new@example.com',
        ]);

        $user->refresh();
        $this->assertFalse($user->hasVerifiedEmail());
        $this->assertNull($user->email_verified_at);
        $this->assertEquals('new@example.com', $user->email);
    }

    public function test_name_change_does_not_reset_verification()
    {
        $user = User::factory()->create(['name' => 'Old Name']);
        $this->assertTrue($user->hasVerifiedEmail());

        $response = $this->actingAs($user)->put(route('dashboard.profile.update'), [
            'name' => 'New Name',
            'email' => $user->email,
        ]);

        $user->refresh();
        $this->assertTrue($user->hasVerifiedEmail());
        $this->assertEquals('New Name', $user->name);
    }
}
