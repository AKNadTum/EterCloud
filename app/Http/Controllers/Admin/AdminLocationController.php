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
        $locations = Location::paginate(20);
        $pteroLocations = $this->pteroLocations->list()['data'] ?? [];

        $locations->getCollection()->each(function ($location) use ($pteroLocations) {
            $ptero = collect($pteroLocations)->firstWhere('attributes.id', $location->ptero_id_location);
            if ($ptero) {
                $location->ptero_short = $ptero['attributes']['short'];
                $location->ptero_long = $ptero['attributes']['long'];
            }
        });

        return view('admin.locations.index', compact('locations'));
    }

    public function create(): View
    {
        $pteroLocations = $this->pteroLocations->list()['data'] ?? [];
        return view('admin.locations.create', compact('pteroLocations'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ptero_id_location' => 'required|integer|unique:locations,ptero_id_location',
            'name' => 'required|string|max:255',
        ]);

        Location::create($validated);

        return redirect()->route('admin.locations.index')->with('success', 'Location liée avec succès.');
    }

    public function edit(Location $location): View
    {
        $pteroLocations = $this->pteroLocations->list()['data'] ?? [];
        return view('admin.locations.edit', compact('location', 'pteroLocations'));
    }

    public function update(Request $request, Location $location): RedirectResponse
    {
        $validated = $request->validate([
            'ptero_id_location' => 'required|integer|unique:locations,ptero_id_location,' . $location->id,
            'name' => 'required|string|max:255',
        ]);

        $location->update($validated);

        return redirect()->route('admin.locations.index')->with('success', 'Location mise à jour.');
    }

    public function destroy(Location $location): RedirectResponse
    {
        // On devrait aussi supprimer dans Pterodactyl si possible, mais attention aux nodes liés
        $location->delete();
        return redirect()->route('admin.locations.index')->with('success', 'Location supprimée localement.');
    }
}
