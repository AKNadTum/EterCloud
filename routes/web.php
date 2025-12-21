<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\StripeWebhookController;
use App\Services\Pterodactyl\PterodactylNests;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/status', [StatusController::class, 'index'])->name('status');

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
Route::prefix('auth')->group(function () {
    // Pages (GET)
    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');

    // Actions (POST)
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login.submit');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Email Verification (Standard Laravel names)
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (\Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('dashboard.index');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Page de contact (gérée par le TicketController pour création de ticket)
Route::get('/contact', [App\Http\Controllers\TicketController::class, 'create'])->name('contact');
Route::post('/contact', [App\Http\Controllers\TicketController::class, 'store'])->name('contact.submit');

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
    Route::post('/profile/stripe/link', [UserController::class, 'linkStripe'])->name('profile.stripe.link');
    // Servers dashboard
    Route::get('/servers', [ServerController::class, 'index'])->name('servers');
    Route::get('/servers/create', [ServerController::class, 'create'])->middleware('verified')->name('servers.create');
    Route::post('/servers', [ServerController::class, 'store'])->middleware('verified')->name('servers.store');
    Route::delete('/servers/{id}', [ServerController::class, 'destroy'])->name('servers.destroy');
    // La page de facturation du dashboard redirige vers le portail Stripe
    Route::get('/billing', function () {
        return redirect()->route('billing.overview');
    })->name('billing');

    // Tickets dashboard
    Route::prefix('tickets')->name('tickets.')->group(function () {
        Route::get('/', [App\Http\Controllers\TicketController::class, 'index'])->name('index');
        Route::get('/{ticket}', [App\Http\Controllers\TicketController::class, 'show'])->name('show');
        Route::post('/{ticket}/reply', [App\Http\Controllers\TicketController::class, 'reply'])->name('reply');
        Route::post('/{ticket}/reopen', [App\Http\Controllers\TicketController::class, 'reopen'])->name('reopen');
    });

    // API interne pour le dashboard
    Route::get('/api/pterodactyl/nests/{nestId}/eggs', function ($nestId, PterodactylNests $pteroNests) {
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

// Administration
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('index');

    Route::resource('users', App\Http\Controllers\Admin\AdminUserController::class);

    Route::get('servers', [App\Http\Controllers\Admin\AdminServerController::class, 'index'])->name('servers.index');
    Route::get('servers/{id}', [App\Http\Controllers\Admin\AdminServerController::class, 'show'])->name('servers.show');
    Route::post('servers/{id}/suspend', [App\Http\Controllers\Admin\AdminServerController::class, 'suspend'])->name('servers.suspend');
    Route::post('servers/{id}/unsuspend', [App\Http\Controllers\Admin\AdminServerController::class, 'unsuspend'])->name('servers.unsuspend');
    Route::delete('servers/{id}', [App\Http\Controllers\Admin\AdminServerController::class, 'destroy'])->name('servers.destroy');

    Route::resource('nodes', App\Http\Controllers\Admin\AdminNodeController::class)->only(['index', 'show']);
    Route::resource('locations', App\Http\Controllers\Admin\AdminLocationController::class);
    Route::resource('plans', App\Http\Controllers\Admin\AdminPlanController::class);
    Route::resource('roles', App\Http\Controllers\Admin\AdminRoleController::class);
    Route::resource('permissions', App\Http\Controllers\Admin\AdminPermissionController::class);

    Route::get('billing', [App\Http\Controllers\Admin\AdminBillingController::class, 'index'])->name('billing.index');
});

// Panel Support
Route::prefix('support')->name('support.')->middleware(['auth', 'support'])->group(function () {
    Route::get('/', [App\Http\Controllers\Support\SupportDashboardController::class, 'index'])->name('index');
    Route::get('/tickets/unassigned', [App\Http\Controllers\Support\SupportTicketController::class, 'unassigned'])->name('tickets.unassigned');
    Route::get('/tickets/{ticket}', [App\Http\Controllers\Support\SupportTicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticket}/reply', [App\Http\Controllers\Support\SupportTicketController::class, 'reply'])->name('tickets.reply');
    Route::post('/tickets/{ticket}/assign', [App\Http\Controllers\Support\SupportTicketController::class, 'assign'])->name('tickets.assign');
    Route::post('/tickets/{ticket}/close', [App\Http\Controllers\Support\SupportTicketController::class, 'close'])->name('tickets.close');
    Route::post('/tickets/{ticket}/reopen', [App\Http\Controllers\Support\SupportTicketController::class, 'reopen'])->name('tickets.reopen');
    Route::post('/tickets/{ticket}/suspend', [App\Http\Controllers\Support\SupportTicketController::class, 'suspend'])->name('tickets.suspend');
});

