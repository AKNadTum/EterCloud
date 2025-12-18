<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Stripe\StripeClient;
use Stripe\Subscription;
use Stripe\Customer;

class StripeService
{
    public function __construct(private StripeClient $stripe)
    {
    }

    // 1) Customer: via email la 1ère fois, puis par ID
    public function getOrCreateCustomer(User $user): string
    {
        if (!empty($user->stripe_customer_id)) {
            return $user->stripe_customer_id;
        }

        $existing = $this->stripe->customers->all([
            'email' => $user->email,
            'limit' => 1,
        ]);
        $customer = $existing->data[0] ?? $this->stripe->customers->create([
            'email' => $user->email,
            'name' => $user->name,
        ]);

        $user->stripe_customer_id = $customer->id; // seule donnée stockée
        $user->save();

        return $customer->id;
    }

    // 2) Checkout pour premier abonnement
    public function createCheckoutSession(User $user, string $priceId, string $successUrl, string $cancelUrl): string
    {
        $customerId = $this->getOrCreateCustomer($user);
        $session = $this->stripe->checkout->sessions->create([
            'mode' => 'subscription',
            'customer' => $customerId,
            'line_items' => [[ 'price' => $priceId, 'quantity' => 1 ]],
            'allow_promotion_codes' => true,
            'success_url' => $successUrl . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $cancelUrl,
        ]);

        return $session->url; // redirection
    }

    // 3) Portail de facturation
    public function createPortalSession(User $user, string $returnUrl): string
    {
        $customerId = $this->getOrCreateCustomer($user);
        $session = $this->stripe->billingPortal->sessions->create([
            'customer' => $customerId,
            'return_url' => $returnUrl,
        ]);
        return $session->url;
    }

    // 4) Abonnement courant par customer (lecture seule)
    public function getActiveSubscription(string $customerId, int $ttlSeconds = 120): ?Subscription
    {
        $key = 'stripe:active_sub:' . $customerId;
        return Cache::remember($key, $ttlSeconds, function () use ($customerId) {
            $subs = $this->stripe->subscriptions->all([
                'customer' => $customerId,
                'status' => 'all',
                'limit' => 5,
            ]);
            foreach ($subs->data as $s) {
                if (in_array($s->status, ['active','trialing','past_due','unpaid'])) {
                    return $s;
                }
            }
            return null;
        });
    }

    // 5) Mapper l’abonnement Stripe vers un Plan local via price_stripe_id
    public function mapSubscriptionToPlan(?Subscription $sub): ?Plan
    {
        $priceId = $sub->items->data[0]->price->id ?? null;
        if (!$priceId) return null;
        return Plan::where('price_stripe_id', $priceId)->first();
    }

    /**
     * Retourne quelques informations de facturation pour affichage profil.
     * - customer (Stripe\Customer)
     * - subscription (Stripe\Subscription|null)
     * - plan (App\Models\Plan|null)
     * - payment_method (array|null): brand, last4, exp_month, exp_year
     */
    public function getCustomerDetails(User $user): array
    {
        $customerId = $user->stripe_customer_id;

        if (!$customerId) {
            return [
                'customer' => null,
                'subscription' => null,
                'plan' => null,
                'payment_method' => null,
            ];
        }

        // Récup client avec PM par défaut expandée si possible
        /** @var Customer $customer */
        $customer = $this->stripe->customers->retrieve(
            $customerId,
            ['expand' => ['invoice_settings.default_payment_method']]
        );

        $subscription = $this->getActiveSubscription($customerId, 0);
        $plan = $this->mapSubscriptionToPlan($subscription);

        $pm = null;
        // Priorité: PM par défaut sur le client, sinon première carte attachée
        $defaultPm = $customer->invoice_settings->default_payment_method ?? null;
        if ($defaultPm && ($defaultPm->card ?? null)) {
            $pm = [
                'brand' => $defaultPm->card->brand,
                'last4' => $defaultPm->card->last4,
                'exp_month' => $defaultPm->card->exp_month,
                'exp_year' => $defaultPm->card->exp_year,
            ];
        } else {
            $list = $this->stripe->paymentMethods->all([
                'customer' => $customerId,
                'type' => 'card',
                'limit' => 1,
            ]);
            $first = $list->data[0] ?? null;
            if ($first && ($first->card ?? null)) {
                $pm = [
                    'brand' => $first->card->brand,
                    'last4' => $first->card->last4,
                    'exp_month' => $first->card->exp_month,
                    'exp_year' => $first->card->exp_year,
                ];
            }
        }

        return [
            'customer' => $customer,
            'subscription' => $subscription,
            'plan' => $plan,
            'payment_method' => $pm,
        ];
    }

    /**
     * Récupère les informations du Price Stripe à partir de son ID (price_...).
     * Retourne un tableau simple prêt à afficher (montant, devise, récurrence, produit associé).
     * Aucun état n'est persisté.
     *
     * @return array{
     *   id:string,
     *   currency:string,
     *   unit_amount:int|null,
     *   amount:float|null,
     *   recurring:array{interval: ?string, interval_count: ?int},
     *   product:array{id: string|null, name: string|null}
     * }
     */
    public function getPriceDetailsById(string $priceId): array
    {
        $price = $this->stripe->prices->retrieve($priceId, [
            'expand' => ['product'],
        ]);

        $unitAmount = $price->unit_amount ?? null; // minor units (ex: cents)
        $amount = is_null($unitAmount) ? null : ($unitAmount / 100);

        // Product peut être une chaîne (id) ou un objet étendu
        $productId = is_object($price->product) ? ($price->product->id ?? null) : (string) $price->product;
        $productName = is_object($price->product) && property_exists($price->product, 'name')
            ? ($price->product->name ?? null)
            : null;

        return [
            'id' => $price->id,
            'currency' => strtoupper((string) $price->currency),
            'unit_amount' => $unitAmount,
            'amount' => $amount, // major units (ex: euros)
            'recurring' => [
                'interval' => $price->recurring->interval ?? null,
                'interval_count' => $price->recurring->interval_count ?? null,
            ],
            'product' => [
                'id' => $productId,
                'name' => $productName,
            ],
        ];
    }

    /**
     * Raccourci: récupère le Price Stripe d'un Plan local.
     */
    public function getPriceDetailsForPlan(Plan $plan): array
    {
        return $this->getPriceDetailsById($plan->price_stripe_id);
    }

    /**
     * Transforme les détails Stripe en libellés affichables (prix et période en FR).
     * @param array{id:string,currency:string,unit_amount:int|null,amount:float|null,recurring:array{interval:?string,interval_count:?int}} $details
     * @return array{price:?string,period:?string}
     */
    public function formatPriceLabels(array $details): array
    {
        $priceLabel = null;
        if (!is_null($details['amount'])) {
            $amountVal = (float) $details['amount'];

            if ($amountVal <= 0) {
                $priceLabel = 'Gratuit';
            } else {
                $amount = number_format($amountVal, 2, ',', ' ');
                $cur = strtoupper($details['currency'] ?? '');
                $symbol = match ($cur) {
                    'EUR' => '€',
                    'USD' => '$',
                    'GBP' => '£',
                    default => $cur,
                };
                // Position du symbole: avant pour $, £ — après pour € et codes
                if (in_array($symbol, ['$', '£'], true)) {
                    $priceLabel = $symbol . ' ' . $amount;
                } elseif ($symbol === '€') {
                    $priceLabel = $amount . ' ' . $symbol;
                } else {
                    $priceLabel = $amount . ' ' . $symbol;
                }
            }
        }

        $periodLabel = null;
        $interval = $details['recurring']['interval'] ?? null;
        $count = $details['recurring']['interval_count'] ?? null;
        if ($interval) {
            $map = [
                'day' => 'jour',
                'week' => 'semaine',
                'month' => 'mois',
                'year' => 'an',
            ];
            $base = $map[$interval] ?? $interval;
            $count = (int) ($count ?: 1);
            if ($count <= 1) {
                $periodLabel = $base;
            } else {
                // pluriel naïf
                $plural = match ($base) {
                    'jour' => 'jours',
                    'semaine' => 'semaines',
                    'mois' => 'mois',
                    'an' => 'ans',
                    default => $base . 's',
                };
                $periodLabel = $count . ' ' . $plural;
            }
        }

        return [
            'price' => $priceLabel,
            'period' => ($priceLabel === 'Gratuit') ? null : $periodLabel,
        ];
    }
}
