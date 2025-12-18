<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\StripeWebhookController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Alias sans préfixe pour compatibilité (tests / URLs directes)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

// Regroupement sous le préfixe "plans"
Route::prefix('plans')->name('plans.')->group(function () {
    // Routes publiques redirigeant vers la home section plans
    Route::get('/', function () {
        return redirect()->to(route('home') . '#plans');
    })->name('index');

    Route::get('/{id}', function ($id) {
        return redirect()->to(route('home') . '#plans');
    })->name('show');
});

// Auth: regrouper sous le préfixe "auth"
Route::prefix('auth')->name('auth.')->group(function () {
    // Pages (GET)
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');

    // Actions (POST)
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Stub conservé pour la demande de lien de réinitialisation (non implémentée)
    Route::post('/forgot-password', function (Request $request) {
        return back()->with('status', 'Envoi du lien non implémenté');
    })->name('password.email');
});

// Page de contact
Route::view('/contact', 'contact')->name('contact');

// Pages Légales
Route::prefix('legal')->name('legal.')->group(function () {
    Route::view('/tos', 'legal.tos')->name('tos');
    Route::view('/privacy', 'legal.privacy')->name('privacy');
    Route::view('/refund', 'legal.refund')->name('refund');
    Route::view('/mentions', 'legal.mentions')->name('mentions');
});

// Dashboard (protégé)
Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [UserController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/pterodactyl/link', [UserController::class, 'linkPterodactyl'])->name('profile.pterodactyl.link');
    // Servers dashboard
    Route::get('/servers', [ServerController::class, 'index'])->name('servers');
    Route::get('/servers/create', [ServerController::class, 'create'])->name('servers.create');
    Route::post('/servers', [ServerController::class, 'store'])->name('servers.store');
    Route::delete('/servers/{id}', [ServerController::class, 'destroy'])->name('servers.destroy');
    // La page de facturation du dashboard redirige vers le portail Stripe
    Route::get('/billing', function () {
        return redirect()->route('billing.overview');
    })->name('billing');

    // API interne pour le dashboard
    Route::get('/api/pterodactyl/nests/{nestId}/eggs', function ($nestId, \App\Services\Pterodactyl\PterodactylNests $pteroNests) {
        $eggs = $pteroNests->eggs($nestId);
        return collect($eggs['data'] ?? [])->map(fn($e) => [
            'id' => $e['attributes']['id'],
            'name' => $e['attributes']['name'],
        ]);
    })->name('api.eggs');
});

// Facturation / Stripe (protégé)
Route::middleware('auth')->group(function () {
    // Redirection directe vers le portail Stripe
    Route::get('/billing', [BillingController::class, 'index'])->name('billing.overview');
    Route::get('/billing/portal', [BillingController::class, 'portal'])->name('billing.portal');
    Route::get('/billing/portal/return', [BillingController::class, 'portalReturn'])->name('billing.portal.return');

    // Choisir une offre (depuis la page plans)
    Route::post('/billing/choose', [BillingController::class, 'choose'])->name('billing.choose');

    // Pages de retour Checkout
    Route::get('/checkout/success', fn () => view('checkout.success'))->name('checkout.success');
    Route::get('/checkout/cancel', fn () => view('checkout.cancel'))->name('checkout.cancel');
});

// Webhook Stripe (optionnel). Désactive la vérification CSRF uniquement pour cette route.
Route::post('/stripe/webhook', StripeWebhookController::class)
    ->name('stripe.webhook')
    ->withoutMiddleware([VerifyCsrfToken::class]);

