<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
        ]);

        // Create a test user without factory
        User::create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role_id' => \App\Models\Role::where('slug', 'user')->first()?->id,
        ]);

        // Seed locations first, then plans (plans link to locations)
        $this->call([
            LocationSeeder::class,
            PlanSeeder::class,
        ]);
    }
}
