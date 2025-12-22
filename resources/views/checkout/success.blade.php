@extends('layout')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-[60vh] px-4 text-center">
        <div class="mb-6 p-4 rounded-full bg-green-50 border border-green-100">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-500">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
        </div>

        <h1 class="text-3xl font-semibold mb-2">Paiement réussi !</h1>
        <p class="text-muted-foreground max-w-md mb-8">
            Merci pour votre confiance. Votre abonnement a été activé avec succès.
            Vous pouvez maintenant commencer à configurer vos serveurs.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-4">
            <x-ui.button href="{{ route('dashboard.servers') }}">
                Gérer mes serveurs
            </x-ui.button>
            <x-ui.button href="{{ route('dashboard.index') }}" variant="outline">
                Aller au tableau de bord
            </x-ui.button>
        </div>
    </div>
@endsection




