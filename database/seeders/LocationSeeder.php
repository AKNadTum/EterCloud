<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            ['ptero_id_location' => '1', 'name' => 'L1'],
            ['ptero_id_location' => '2', 'name' => 'L2'],
            ['ptero_id_location' => '3', 'name' => 'L3'],
            ['ptero_id_location' => '4', 'name' => 'L4'],
        ];

        foreach ($locations as $loc) {
            Location::updateOrCreate(
                ['ptero_id_location' => $loc['ptero_id_location']],
                $loc
            );
        }
    }
}
