@extends('admin.layout')

@section('title', 'Gestion de la Facturation')

@section('content')
    <div class="bg-white p-6 rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm">
        <p class="text-gray-600">La gestion détaillée de la facturation sera bientôt disponible ici.</p>
        <p class="mt-4">Vous pouvez actuellement consulter les transactions via le tableau de bord Stripe.</p>
        <div class="mt-6">
            <x-ui.button href="https://dashboard.stripe.com" target="_blank" variant="outline">
                Accéder au Dashboard Stripe
                <x-heroicon-o-arrow-top-right-on-square class="size-4 ml-2" />
            </x-ui.button>
        </div>
    </div>
@endsection
