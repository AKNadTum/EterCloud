<?php

namespace App\Http\Controllers;

use App\Services\Pterodactyl\PterodactylNodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StatusController extends Controller
{
    public function __construct(
        private readonly PterodactylNodes $nodes
    ) {}

    public function index()
    {
        // On cache les résultats pendant 1 minute pour éviter de saturer l'API de Pterodactyl
        $data = Cache::remember('infrastructure_status', 60, function () {
            try {
                $nodesList = $this->nodes->list(['include' => 'servers,location']);
                $nodes = $nodesList['data'] ?? [];

                // Statistiques globales
                $stats = [
                    'total_nodes' => count($nodes),
                    'total_servers' => 0,
                    'total_memory' => 0,
                    'used_memory' => 0,
                    'total_disk' => 0,
                    'used_disk' => 0,
                ];

                foreach ($nodes as $node) {
                    $attr = $node['attributes'] ?? [];

                    // Calcul du nombre de serveurs sur ce node
                    $nodeServersCount = 0;
                    if (isset($attr['relationships']['servers'])) {
                        $serversRel = $attr['relationships']['servers'];
                        $nodeServersCount = $serversRel['meta']['pagination']['total'] ?? count($serversRel['data'] ?? []);
                    }

                    $stats['total_servers'] += $nodeServersCount;
                    $stats['total_memory'] += $attr['memory'] ?? 0;
                    $stats['used_memory'] += ($attr['allocated_resources']['memory'] ?? 0);
                    $stats['total_disk'] += $attr['disk'] ?? 0;
                    $stats['used_disk'] += ($attr['allocated_resources']['disk'] ?? 0);
                }

                // État des composants
                $components = [
                    [
                        'name' => 'Site Web',
                        'status' => 'operational',
                        'description' => 'Le site principal et l\'espace client.'
                    ],
                    [
                        'name' => 'Panel Pterodactyl',
                        'status' => 'operational',
                        'description' => 'L\'interface de gestion des serveurs.'
                    ],
                    [
                        'name' => 'API Gateway',
                        'status' => 'operational',
                        'description' => 'Services de communication interne.'
                    ],
                    [
                        'name' => 'Base de données',
                        'status' => 'operational',
                        'description' => 'Stockage des données utilisateur.'
                    ],
                ];

                return [
                    'nodes' => $nodes,
                    'stats' => $stats,
                    'components' => $components,
                    'last_updated' => now(),
                    'error' => null
                ];
            } catch (\Exception $e) {
                return [
                    'nodes' => [],
                    'stats' => [],
                    'components' => [],
                    'last_updated' => now(),
                    'error' => 'Impossible de récupérer l\'état de l\'infrastructure pour le moment.'
                ];
            }
        });

        return view('status', $data);
    }
}
