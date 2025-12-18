<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminPlanController extends Controller
{
    public function index(): View
    {
        $plans = Plan::all();
        return view('admin.plans.index', compact('plans'));
    }

    public function create(): View
    {
        return view('admin.plans.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:plans,slug',
            'description' => 'nullable|string',
            'price_monthly' => 'required|numeric',
            'stripe_id' => 'required|string',
            'cpu' => 'required|integer',
            'memory' => 'required|integer',
            'disk' => 'required|integer',
            'databases' => 'required|integer',
            'backups' => 'required|integer',
            'extra_ports' => 'required|integer',
        ]);

        Plan::create($validated);

        return redirect()->route('admin.plans.index')->with('success', 'Plan créé.');
    }

    public function edit(Plan $plan): View
    {
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_monthly' => 'required|numeric',
            'stripe_id' => 'required|string',
            'cpu' => 'required|integer',
            'memory' => 'required|integer',
            'disk' => 'required|integer',
            'databases' => 'required|integer',
            'backups' => 'required|integer',
            'extra_ports' => 'required|integer',
        ]);

        $plan->update($validated);

        return redirect()->route('admin.plans.index')->with('success', 'Plan mis à jour.');
    }

    public function destroy(Plan $plan): RedirectResponse
    {
        $plan->delete();
        return redirect()->route('admin.plans.index')->with('success', 'Plan supprimé.');
    }
}
