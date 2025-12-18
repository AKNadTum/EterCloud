<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Plan Dirt (Free)',
                'description' => 'Idéal pour découvrir nos services et débuter votre aventure.',
                'price_stripe_id' => 'price_1SfTJ8BMs74rsJn7okDLUQ8q',
                'server_limit' => 1,
                'disk' => 5120, // 5 Go
                'cpu' => 3,
                'ram' => 1,
                'backup' => 0,
                'database' => 0,
            ],
            [
                'name' => 'Plan Stone',
                'description' => 'Une offre équilibrée pour les petits groupes de joueurs.',
                'price_stripe_id' => 'price_1SfTR7BMs74rsJn7LjWAEvpq',
                'server_limit' => 1,
                'disk' => 10240, // 10 Go
                'cpu' => 3,
                'ram' => 1,
                'backup' => 0,
                'database' => 0,
            ],
            [
                'name' => 'Plan Iron',
                'description' => 'Plus de puissance et de serveurs pour vos projets.',
                'price_stripe_id' => 'price_1SfTRTBMs74rsJn725cmYYgL',
                'server_limit' => 2,
                'disk' => 20480, // 20 Go
                'cpu' => 3,
                'ram' => 1,
                'backup' => 0,
                'database' => 0,
            ],
            [
                'name' => 'Plan Diamond',
                'description' => 'Performances supérieures pour une expérience fluide.',
                'price_stripe_id' => 'price_1SfTRmBMs74rsJn7DBwui2jZ',
                'server_limit' => 5,
                'disk' => 35840, // 35 Go
                'cpu' => 3,
                'ram' => 1,
                'backup' => 0,
                'database' => 0,
            ],
            [
                'name' => 'Plan Netherite',
                'description' => 'L\'offre ultime pour les communautés les plus exigeantes.',
                'price_stripe_id' => 'price_1SfTS3BMs74rsJn78OIs71U7',
                'server_limit' => 10,
                'disk' => 51200, // 50 Go
                'cpu' => 3,
                'ram' => 1,
                'backup' => 0,
                'database' => 0,
            ],
        ];

        foreach ($plans as $index => $planData) {
            $plan = Plan::updateOrCreate(
                ['name' => $planData['name']],
                $planData
            );

            // Link to locations (just an example of linking)
            if ($index === 0) { // Dirt
                $plan->locations()->sync([1]);
            } elseif ($index === 1) { // Stone
                $plan->locations()->sync([1, 2]);
            } elseif ($index === 2) { // Iron
                $plan->locations()->sync([1, 2, 3]);
            } elseif ($index === 3) { // Diamond
                $plan->locations()->sync([1, 2, 3, 4]);
            } else { // Netherite
                $plan->locations()->sync([1, 2, 3, 4]);
            }
        }
    }
}
