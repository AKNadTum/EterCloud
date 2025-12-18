<?php

namespace App\Http\Controllers;

use App\Services\PlanService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class PlanController extends Controller
{
    protected PlanService $planService;

    public function __construct(
        PlanService $planService
    ) {
        $this->planService = $planService;
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_stripe_id' => 'required|string|max:255',
            'server_limit' => 'nullable|integer|min:0',
        ]);

        $plan = $this->planService->createPlan($validated);

        return redirect()->to(route('home') . '#plans')
            ->with('success', 'Plan créé avec succès');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price_stripe_id' => 'sometimes|required|string|max:255',
            'server_limit' => 'nullable|integer|min:0',
        ]);

        $plan = $this->planService->updatePlan($id, $validated);

        if (!$plan) {
            abort(404, 'Plan non trouvé');
        }

        return redirect()->to(route('home') . '#plans')
            ->with('success', 'Plan mis à jour avec succès');
    }

    public function destroy(int $id): RedirectResponse
    {
        $deleted = $this->planService->deletePlan($id);

        if (!$deleted) {
            abort(404, 'Plan non trouvé');
        }

        return redirect()->to(route('home') . '#plans')
            ->with('success', 'Plan supprimé avec succès');
    }

}
