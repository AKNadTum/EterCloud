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
        $nodes = $this->pteroNodes->list([
            'page' => $page,
            'include' => 'servers'
        ]);
        return view('admin.nodes.index', compact('nodes'));
    }

    public function show(int $id): View
    {
        $node = $this->pteroNodes->get($id);
        return view('admin.nodes.show', compact('node'));
    }
}
