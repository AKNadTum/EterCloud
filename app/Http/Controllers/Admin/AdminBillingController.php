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
        $stats = $this->stripeService->getGlobalStats();

        return view('admin.billing.index', compact('stats'));
    }
}
