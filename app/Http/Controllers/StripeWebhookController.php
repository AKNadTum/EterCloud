<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StripeWebhookController
{
    public function __invoke(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Signature invalide'], 400);
        }

        if (str_starts_with($event->type, 'customer.subscription.')) {
            /** @var \Stripe\Subscription $sub */
            $sub = $event->data->object;
            Cache::forget('stripe:active_sub:' . $sub->customer);
        }

        return response()->json(['ok' => true]);
    }
}
