<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Plan;
use App\Models\Location;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'users_count' => User::count(),
            'plans_count' => Plan::count(),
            'locations_count' => Location::count(),
            // On pourrait ajouter des stats de serveurs ici si on avait un modèle local ou via Pterodactyl
        ];

        return view('admin.index', compact('stats'));
    }
}
