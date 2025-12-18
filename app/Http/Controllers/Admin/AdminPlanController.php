<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Location;
use App\Services\StripeService;
use App\Http\Requests\Admin\StorePlanRequest;
use App\Http\Requests\Admin\UpdatePlanRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminPlanController extends Controller
{
    protected StripeService $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    public function index(): View
    {
        $plans = Plan::paginate(15);
        return view('admin.plans.index', compact('plans'));
    }

    public function create(): View
    {
        $locations = Location::all();
        return view('admin.plans.create', compact('locations'));
    }

    public function store(StorePlanRequest $request): RedirectResponse
    {
        $plan = Plan::create($request->validated());

        if ($request->has('locations')) {
            $plan->locations()->sync($request->input('locations'));
        }

        return redirect()->route('admin.plans.index')->with('success', 'Plan créé.');
    }

    public function edit(Plan $plan): View
    {
        $locations = Location::all();
        $stripeDetails = null;
        try {
            if ($plan->price_stripe_id) {
                $details = $this->stripeService->getPriceDetailsForPlan($plan);
                $stripeDetails = $this->stripeService->formatPriceLabels($details);
            }
        } catch (\Exception $e) {
            // Stripe ID invalide ou erreur API
        }

        return view('admin.plans.edit', compact('plan', 'locations', 'stripeDetails'));
    }

    public function update(UpdatePlanRequest $request, Plan $plan): RedirectResponse
    {
        $plan->update($request->validated());

        $plan->locations()->sync($request->input('locations', []));

        return redirect()->route('admin.plans.index')->with('success', 'Plan mis à jour.');
    }

    public function destroy(Plan $plan): RedirectResponse
    {
        $plan->delete();
        return redirect()->route('admin.plans.index')->with('success', 'Plan supprimé.');
    }
}
