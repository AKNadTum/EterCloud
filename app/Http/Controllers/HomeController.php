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

        return view('home', array_merge(compact('plans', 'stripePrices'), [
            'features' => $this->getFeatures(),
            'faqItems' => $this->getFaqItems(),
            'steps' => $this->getSteps(),
        ]));
    }

    private function getFeatures(): array
    {
        return [
            ['variant' => 'primary', 'icon' => 'heroicon-o-rocket-launch', 'title' => 'Pterodactyl', 'description' => 'Gère ton serveur avec le panel le plus puissant et intuitif du marché.'],
            ['variant' => 'success', 'icon' => 'heroicon-o-sparkles', 'title' => 'Gratuit & Performant', 'description' => 'Une alternative à Aternos sans file d\'attente.'],
            ['variant' => 'accent', 'icon' => 'heroicon-o-swatch', 'title' => 'Moderne', 'description' => 'Une interface claire, rapide et optimisée pour tous tes appareils.'],
            ['variant' => 'warning', 'icon' => 'heroicon-o-shield-check', 'title' => 'Sécurité', 'description' => 'Sauvegardes automatiques et protection DDoS pour ton esprit tranquille.'],
        ];
    }

    private function getFaqItems(): array
    {
        return [
            [
                'variant' => 'card-primary',
                'question' => 'Pourquoi choisir EterCloud comme alternative à Aternos ?',
                'answer' => 'Contrairement à d\'autres hébergeurs gratuits comme Aternos, EterCloud mise sur de vraies performances dès le plan gratuit. Nous garantissons une expérience <strong>sans file d\'attente</strong> et <strong>sans lag</strong>, idéale pour jouer avec tes amis dans les meilleures conditions.'
            ],
            [
                'variant' => 'card-success',
                'question' => 'Le plan gratuit est-il vraiment gratuit ?',
                'answer' => 'Oui, absolument. Le plan gratuit est conçu pour te permettre de tester notre infrastructure sans aucun frais caché ni limite de temps. Tu peux passer à un plan supérieur à tout moment.'
            ],
            [
                'variant' => 'card-accent',
                'question' => 'Puis-je importer mes serveurs existants ?',
                'answer' => 'Bien sûr ! Notre interface te permet de téléverser tes fichiers via le gestionnaire de fichiers intégré ou via SFTP. Tes mondes et configurations seront prêts en quelques minutes.'
            ],
            [
                'variant' => 'card-success',
                'question' => 'Quel est le délai de mise en ligne ?',
                'answer' => 'Une fois qu\'on déploie un serveur, celui-ci est en ligne en quelques secondes.'
            ],
        ];
    }

    private function getSteps(): array
    {
        return [
            [
                'step' => 1,
                'title' => 'Compte',
                'description' => 'Inscris-toi en quelques secondes, sans carte bancaire requise.',
                'variant' => 'primary'
            ],
            [
                'step' => 2,
                'title' => 'Déploiement',
                'description' => 'Choisis ton plan et ton serveur se configure automatiquement.',
                'variant' => 'accent'
            ],
            [
                'step' => 3,
                'title' => 'Aventure',
                'description' => 'Rejoins ton serveur avec tes amis et commence à bâtir ton monde.',
                'variant' => 'success'
            ],
        ];
    }
}
