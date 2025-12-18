<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminBillingController extends Controller
{
    public function __construct(private readonly StripeService $stripeService)
    {
    }

    public function index(): View
    {
        // On pourrait lister les derniers paiements ou abonnements via Stripe
        // Pour l'instant on fait une vue simple
        return view('admin.billing.index');
    }
}
