<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class BillingController extends Controller
{
    public function __construct(private StripeService $stripe)
    {
        $this->middleware('auth');
    }

    // Page de facturation du dashboard → redirection vers le Portail Stripe
    public function index(Request $request): RedirectResponse
    {
        $url = $this->stripe->createPortalSession($request->user(), route('billing.portal.return'));
        return redirect()->away($url);
    }

    // Choix d’une offre: si pas d’abonnement → Checkout, sinon → Portail
    public function choose(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'plan_id' => ['required', 'integer', 'exists:plans,id'],
        ]);

        $plan = Plan::query()->findOrFail((int) $validated['plan_id']);

        $user = $request->user();
        $customerId = $this->stripe->getOrCreateCustomer($user);
        $currentSub = $this->stripe->getActiveSubscription($customerId, 0);

        if (!$currentSub) {
            $url = $this->stripe->createCheckoutSession(
                $user,
                $plan->price_stripe_id,
                route('checkout.success'),
                route('checkout.cancel')
            );
            return redirect()->away($url);
        }

        // Déjà abonné → déléguer au Portail Stripe pour upgrade/downgrade
        $url = $this->stripe->createPortalSession($user, route('billing.portal.return'));
        return redirect()->away($url);
    }

    public function portal(Request $request): RedirectResponse
    {
        $url = $this->stripe->createPortalSession($request->user(), route('billing.portal.return'));
        return redirect()->away($url);
    }

    public function portalReturn(): RedirectResponse
    {
        // Redirige directement vers la page des serveurs dans le dashboard
        return redirect()
            ->route('dashboard.servers')
            ->with('status', 'Retour du portail Stripe.');
    }
}
