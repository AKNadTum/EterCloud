<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Pterodactyl\PterodactylServers;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminServerController extends Controller
{
    public function __construct(private readonly PterodactylServers $pteroServers)
    {
    }

    public function index(Request $request): View
    {
        $page = $request->get('page', 1);
        $servers = $this->pteroServers->list(['page' => $page, 'include' => 'user']);
        return view('admin.servers.index', compact('servers'));
    }

    public function show(int $id): View
    {
        $server = $this->pteroServers->get($id, ['include' => 'user']);
        return view('admin.servers.show', compact('server'));
    }

    public function suspend(int $id): RedirectResponse
    {
        $this->pteroServers->suspend($id);
        return back()->with('success', 'Serveur suspendu.');
    }

    public function unsuspend(int $id): RedirectResponse
    {
        $this->pteroServers->unsuspend($id);
        return back()->with('success', 'Serveur réactivé.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->pteroServers->delete($id);
        return redirect()->route('admin.servers.index')->with('success', 'Serveur supprimé.');
    }
}
