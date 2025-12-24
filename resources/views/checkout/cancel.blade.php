@extends('layout')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-[60vh] px-4 text-center">
        <div class="mb-6 p-4 rounded-full bg-red-50 border border-red-100">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-500">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="15" y1="9" x2="9" y2="15"></line>
                <line x1="9" y1="9" x2="15" y2="15"></line>
            </svg>
        </div>

        <h1 class="text-3xl font-semibold mb-2">Paiement annulé</h1>
        <p class="text-muted-foreground max-w-md mb-8">
            Le processus de paiement a été interrompu. Aucun montant n'a été débité de votre compte.
            Si vous avez rencontré un problème, n'hésitez pas à nous contacter.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-4">
            <x-ui.button href="{{ route('home') }}#plans" variant="outline">
                Voir les offres
            </x-ui.button>
            <x-ui.button href="{{ route('dashboard.index') }}">
                Retour au tableau de bord
            </x-ui.button>
        </div>
    </div>
@endsection








