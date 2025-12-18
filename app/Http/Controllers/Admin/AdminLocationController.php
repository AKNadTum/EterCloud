<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Services\Pterodactyl\PterodactylLocations;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminLocationController extends Controller
{
    public function __construct(private readonly PterodactylLocations $pteroLocations)
    {
    }

    public function index(): View
    {
        $locations = Location::all();
        // On pourrait aussi lister celles de Pterodactyl pour synchroniser
        return view('admin.locations.index', compact('locations'));
    }

    public function create(): View
    {
        return view('admin.locations.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'short' => 'required|string|max:10|unique:locations,short',
            'long' => 'required|string|max:255',
            'name' => 'required|string|max:255',
        ]);

        // Création dans Pterodactyl d'abord
        $pteroLocation = $this->pteroLocations->create([
            'short' => $validated['short'],
            'long' => $validated['long'],
        ]);

        // Puis en local
        Location::create([
            'short' => $validated['short'],
            'long' => $validated['long'],
            'name' => $validated['name'],
        ]);

        return redirect()->route('admin.locations.index')->with('success', 'Location créée.');
    }

    public function destroy(Location $location): RedirectResponse
    {
        // On devrait aussi supprimer dans Pterodactyl si possible, mais attention aux nodes liés
        $location->delete();
        return redirect()->route('admin.locations.index')->with('success', 'Location supprimée localement.');
    }
}
