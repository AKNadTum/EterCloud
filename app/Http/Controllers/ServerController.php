<?php

namespace App\Http\Controllers;

use App\Services\Pterodactyl\PterodactylNests;
use App\Services\ServerService;
use App\Services\StripeService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    public function __construct(
        private readonly ServerService $servers,
        private readonly StripeService $stripeService,
        private readonly PterodactylNests $pteroNests,
        private readonly \App\Services\Pterodactyl\PterodactylLocations $pteroLocations,
    ) {
    }

    public function index(Request $request): View
    {
        $user = $request->user();
        $linked = $this->servers->hasPterodactylLink($user);
        $demoEnabled = $this->servers->isDemoEnabled();

        $list = $linked ? $this->servers->listForUser($user) : [];

        // Récupérer les détails du plan pour afficher les limites
        $details = $this->stripeService->getCustomerDetails($user);
        $plan = $details['plan'];

        // Fusion avec les serveurs démo conservés en session (lecture seule)
        $demoList = (array) $request->session()->get('demo_servers', []);
        $servers = array_merge($list, $demoList);

        return view('dashboard.servers.index', [
            'servers' => $servers,
            'linked' => $linked,
            'demoEnabled' => $demoEnabled,
            'plan' => $plan,
            'realServersCount' => count($list),
        ]);
    }

    public function create(Request $request)
    {
        $user = $request->user();
        $details = $this->stripeService->getCustomerDetails($user);
        $plan = $details['plan'];

        if (!$plan) {
            return redirect()->to(route('home') . '#plans')->with('error', 'Vous devez avoir un abonnement actif.');
        }

        // Récupérer les localisations de Pterodactyl pour enrichir l'affichage
        $pteroLocations = collect($this->pteroLocations->list()['data'] ?? []);
        $locations = $plan->locations->map(function ($location) use ($pteroLocations) {
            $ptero = $pteroLocations->firstWhere('attributes.id', $location->ptero_id_location);
            if ($ptero) {
                // On utilise le short code et le nom long (description)
                $location->display_name = $ptero['attributes']['short'] . ' - ' . $ptero['attributes']['long'];
            } else {
                $location->display_name = $location->name ?? $location->ptero_id_location;
            }
            return $location;
        });

        $nests = $this->pteroNests->list();

        return view('dashboard.servers.create', compact('plan', 'locations', 'nests'));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        $demoEnabled = $this->servers->isDemoEnabled();

        // Si l'utilisateur n'est pas lié à Pterodactyl, on ne peut que faire de la démo
        if (!$this->servers->hasPterodactylLink($user)) {
            if (!$demoEnabled) {
                return back()->with('status', 'Création de serveur désactivée (Liez votre compte Pterodactyl).');
            }

            return $this->storeDemo($request);
        }

        $details = $this->stripeService->getCustomerDetails($user);
        $plan = $details['plan'];

        if (!$plan) {
            return redirect()->to(route('home') . '#plans')->with('error', 'Vous devez avoir un abonnement actif pour créer un serveur.');
        }

        // Vérifier la limite de serveurs
        $currentServers = $this->servers->listForUser($user);
        if (count($currentServers) >= $plan->server_limit) {
            return back()->with('error', "Vous avez atteint la limite de serveurs de votre plan ({$plan->server_limit}).");
        }

        $validated = $request->validate([
            'name' => 'required|string|max:80',
            'location_id' => 'required|integer',
            'nest_id' => 'required|integer',
            'egg_id' => 'required|integer',
        ]);

        try {
            $this->servers->createServerForUser($user, $plan, $validated);
            return redirect()->route('dashboard.servers')->with('status', 'Le serveur est en cours de création.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    private function storeDemo(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        // Simule un serveur côté UI, stocké en session
        $demo = [
            'id' => 'demo-' . substr(bin2hex(random_bytes(5)), 0, 10),
            'name' => (string) $validated['name'],
            'description' => (string) ($validated['description'] ?? ''),
            'identifier' => '',
            'uuid' => '',
            'is_demo' => true,
        ];

        $list = (array) $request->session()->get('demo_servers', []);
        array_unshift($list, $demo);
        $request->session()->put('demo_servers', $list);

        return redirect()->route('dashboard.servers')
            ->with('status', 'Serveur (démo) créé.');
    }

    public function destroy(Request $request, string $id): RedirectResponse
    {
        if (str_starts_with($id, 'demo-')) {
            $list = (array) $request->session()->get('demo_servers', []);
            $list = array_values(array_filter($list, fn ($s) => ($s['id'] ?? '') !== $id));
            $request->session()->put('demo_servers', $list);

            return redirect()->route('dashboard.servers')
                ->with('status', 'Serveur (démo) supprimé.');
        }

        if (str_starts_with($id, 'ptero-')) {
            $pteroId = (int) str_replace('ptero-', '', $id);
            try {
                $this->servers->deleteServer($pteroId);
                return redirect()->route('dashboard.servers')
                    ->with('status', 'Le serveur a été supprimé avec succès.');
            } catch (\Exception $e) {
                return back()->with('error', 'Erreur lors de la suppression du serveur : ' . $e->getMessage());
            }
        }

        return back()->with('error', 'ID de serveur invalide.');
    }
}
