<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Services\SupportService;
use Illuminate\Http\Request;

class SupportDashboardController extends Controller
{
    public function __construct(
        private readonly SupportService $supportService
    ) {}

    public function index(Request $request)
    {
        $user = $request->user();
        $assignedTickets = $this->supportService->listForAgent($user);
        $unassignedCount = 0;

        if ($user->hasPermission('support.assign')) {
            $unassignedCount = $this->supportService->listUnassigned()->count();
        }

        return view('support.index', compact('assignedTickets', 'unassignedCount'));
    }
}
