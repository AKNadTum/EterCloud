<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Pterodactyl\PterodactylNodes;
use App\Services\Pterodactyl\PterodactylLocations;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminNodeController extends Controller
{
    public function __construct(
        private readonly PterodactylNodes $pteroNodes,
        private readonly PterodactylLocations $pteroLocations
    ) {
    }

    public function index(Request $request): View
    {
        $page = $request->get('page', 1);
        $nodes = $this->pteroNodes->list(['page' => $page]);
        return view('admin.nodes.index', compact('nodes'));
    }

    public function show(int $id): View
    {
        $node = $this->pteroNodes->get($id);
        return view('admin.nodes.show', compact('node'));
    }

    public function create(): View
    {
        $locations = $this->pteroLocations->list();
        return view('admin.nodes.create', compact('locations'));
    }

    public function store(Request $request): RedirectResponse
    {
        // Validation basique (à adapter selon les besoins de Pterodactyl)
        $payload = $request->validate([
            'name' => 'required|string',
            'location_id' => 'required|integer',
            'fqdn' => 'required|string',
            'scheme' => 'required|string',
            'memory' => 'required|integer',
            'memory_overallocate' => 'required|integer',
            'disk' => 'required|integer',
            'disk_overallocate' => 'required|integer',
        ]);

        $this->pteroNodes->create($payload);

        return redirect()->route('admin.nodes.index')->with('success', 'Node créé.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->pteroNodes->delete($id);
        return redirect()->route('admin.nodes.index')->with('success', 'Node supprimé.');
    }
}
