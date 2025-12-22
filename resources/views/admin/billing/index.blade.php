@extends('admin.layout')

@section('title', 'Gestion de la Facturation')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-[var(--control-background)] p-6 rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-[var(--foreground)]">Abonnements Actifs</h3>
                <x-heroicon-o-credit-card class="size-6 text-[var(--primary-foreground)]" />
            </div>
            <p class="text-3xl font-bold text-[var(--foreground)]">{{ $stats['active_subscriptions_count'] }}</p>
            <p class="text-sm text-[var(--muted-foreground)] mt-1">Abonnements actuellement en cours</p>
        </div>

        <div class="bg-[var(--control-background)] p-6 rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-[var(--foreground)]">Volume (30j)</h3>
                <x-heroicon-o-banknotes class="size-6 text-[var(--success-foreground)]" />
            </div>
            <p class="text-3xl font-bold text-[var(--foreground)]">
                {{ number_format($stats['recent_volume'], 2, ',', ' ') }} {{ $stats['currency'] }}
            </p>
            <p class="text-sm text-[var(--muted-foreground)] mt-1">Revenus bruts sur les 30 derniers jours</p>
        </div>
    </div>

    <div class="bg-[var(--control-background)] rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm overflow-hidden mb-8">
        <div class="p-6 border-b border-[var(--border)]">
            <h3 class="text-lg font-semibold text-[var(--foreground)]">Dernières Factures</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[var(--secondary)] text-[var(--muted-foreground)] text-sm uppercase tracking-wider">
                        <th class="px-6 py-3 font-semibold">Client</th>
                        <th class="px-6 py-3 font-semibold">Montant</th>
                        <th class="px-6 py-3 font-semibold">Statut</th>
                        <th class="px-6 py-3 font-semibold">Date</th>
                        <th class="px-6 py-3 font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--border)]">
                    @forelse($stats['latest_invoices'] as $invoice)
                        <tr class="hover:bg-[var(--secondary)] transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-[var(--foreground)]">{{ $invoice->customer->name ?? $invoice->customer_email }}</div>
                                <div class="text-xs text-[var(--muted-foreground)]">{{ $invoice->customer_email }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-[var(--foreground)]">
                                {{ number_format($invoice->amount_paid / 100, 2, ',', ' ') }} {{ strtoupper($invoice->currency) }}
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = match($invoice->status) {
                                        'paid' => 'bg-green-100 text-green-700',
                                        'open' => 'bg-blue-500/10 text-blue-500',
                                        'void' => 'bg-[var(--secondary)] text-[var(--foreground)]',
                                        'uncollectible' => 'bg-red-500/10 text-red-500',
                                        default => 'bg-[var(--secondary)] text-[var(--foreground)]'
                                    };
                                    $statusLabel = match($invoice->status) {
                                        'paid' => 'Payée',
                                        'open' => 'Ouverte',
                                        'void' => 'Annulée',
                                        'uncollectible' => 'Impayée',
                                        default => $invoice->status
                                    };
                                @endphp
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-[var(--muted-foreground)]">
                                {{ date('d/m/Y H:i', $invoice->created) }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ $invoice->invoice_pdf ?? $invoice->hosted_invoice_url }}" target="_blank" class="inline-flex items-center text-[var(--link)] hover:text-[var(--link-hover)] font-medium">
                                    <x-heroicon-o-document-arrow-down class="size-4 mr-1.5" />
                                    PDF
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-[var(--muted-foreground)]">Aucune facture récente.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-[var(--control-background)] p-6 rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm">
        <h3 class="text-lg font-semibold text-[var(--foreground)] mb-4">Actions Stripe</h3>
        <p class="text-[var(--muted-foreground)] mb-6 text-sm">
            Pour une gestion complète (remboursements, litiges, configuration des prix), accédez directement au tableau de bord officiel Stripe.
        </p>
        <x-ui.button href="https://dashboard.stripe.com" target="_blank" variant="outline">
            Accéder au Dashboard Stripe
            <x-heroicon-o-arrow-top-right-on-square class="size-4 ml-2" />
        </x-ui.button>
    </div>
@endsection





