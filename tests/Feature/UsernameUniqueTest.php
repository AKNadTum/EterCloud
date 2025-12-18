<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsernameUniqueTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_requires_unique_name(): void
    {
        // Existing user with a name
        User::factory()->create([
            'name' => 'john.doe',
            'email' => 'john@example.com',
        ]);

        // Try to register with the same name
        $response = $this->post('/auth/register', [
            'name' => 'john.doe',
            'email' => 'jane@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseMissing('users', [
            'email' => 'jane@example.com',
        ]);
    }

    public function test_update_profile_validates_unique_name_on_explicit_name(): void
    {
        $alice = User::factory()->create([
            'name' => 'Alice Cooper',
            'email' => 'alice@example.com',
        ]);
        $bob = User::factory()->create([
            'name' => 'Bob Marley',
            'email' => 'bob@example.com',
        ]);

        $this->actingAs($bob);

        $response = $this->put('/dashboard/profile', [
            'name' => $alice->name, // duplicate
            'email' => $bob->email, // required by validation
        ]);

        $response->assertSessionHasErrors('name');

        // Keeping same own name should be allowed
        $ok = $this->put('/dashboard/profile', [
            'name' => $bob->name,
            'email' => $bob->email,
        ]);
        $ok->assertSessionHasNoErrors();
    }

    public function test_update_profile_validates_unique_name_when_composed_from_first_last(): void
    {
        // Existing user with a given composed name
        User::factory()->create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);

        // Another user updates first/last which would compose to the same name
        $john = User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Smith',
            'name' => 'John Smith',
            'email' => 'john@example.com',
        ]);

        $this->actingAs($john);

        // Do not send explicit name; service/controller will compose it for validation
        $response = $this->put('/dashboard/profile', [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => $john->email,
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_register_name_normalization_prevents_duplicates_with_spaces(): void
    {
        User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);

        $response = $this->post('/auth/register', [
            'name' => '  Jane   Doe  ', // espaces multiples/trim
            'email' => 'jane2@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_update_profile_rejects_name_with_only_space_variation(): void
    {
        $exists = User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);

        $bob = User::factory()->create([
            'name' => 'Bob Marley',
            'email' => 'bob@example.com',
        ]);

        $this->actingAs($bob);

        $res = $this->put('/dashboard/profile', [
            'name' => '  Jane   Doe  ',
            'email' => $bob->email,
        ]);

        $res->assertSessionHasErrors('name');
    }
}
