<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Services\StripeService;
use App\Services\Pterodactyl\PterodactylLocations;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function __construct(
        private StripeService $stripe,
        private PterodactylLocations $pteroLocations
    ) {
    }

    public function index(): View
    {
        // Rendre la page d'accueil tolérante en environnement sans base ou sans table
        $plans = collect();
        $stripePrices = [];

        if (Schema::hasTable('plans')) {
            $plans = Plan::with('locations')->orderBy('id')->limit(5)->get();

            // Enrichissement des localisations avec les données Pterodactyl
            try {
                $pteroLocations = collect($this->pteroLocations->list()['data'] ?? []);
                foreach ($plans as $plan) {
                    foreach ($plan->locations as $location) {
                        $ptero = $pteroLocations->firstWhere('attributes.id', $location->ptero_id_location);
                        if ($ptero) {
                            $location->display_name = $ptero['attributes']['short'] . ' - ' . $ptero['attributes']['long'];
                        } else {
                            $location->display_name = $location->name ?? $location->ptero_id_location;
                        }
                    }
                }
            } catch (\Throwable $e) {
                // En cas d'erreur API, on garde les noms par défaut
                foreach ($plans as $plan) {
                    foreach ($plan->locations as $location) {
                        $location->display_name = $location->name ?? $location->ptero_id_location;
                    }
                }
            }

            foreach ($plans as $plan) {
                $stripePrices[$plan->id] = null;
                if (!empty($plan->price_stripe_id)) {
                    try {
                        $details = $this->stripe->getPriceDetailsById($plan->price_stripe_id);
                        $stripePrices[$plan->id] = $this->stripe->formatPriceLabels($details);
                    } catch (\Throwable $e) {
                        // Silencieux
                    }
                }
            }
        }

        return view('home', compact('plans', 'stripePrices'));
    }
}
