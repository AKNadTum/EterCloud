<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Plan;
use App\Models\Location;
use App\Services\Pterodactyl\PterodactylServers;
use App\Services\Pterodactyl\PterodactylNodes;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __construct(
        private readonly PterodactylServers $pteroServers,
        private readonly PterodactylNodes $pteroNodes
    ) {
    }

    public function index(): View
    {
        $servers = $this->pteroServers->list();
        $nodes = $this->pteroNodes->list();

        $stats = [
            'users_count' => User::count(),
            'plans_count' => Plan::count(),
            'locations_count' => Location::count(),
            'servers_count' => $servers['meta']['pagination']['total'] ?? 0,
            'nodes_count' => $nodes['meta']['pagination']['total'] ?? 0,
        ];

        $recentUsers = User::latest()->limit(5)->get();

        return view('admin.index', compact('stats', 'recentUsers'));
    }
}
