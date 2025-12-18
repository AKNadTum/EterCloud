@extends('dashboard.layout')

@section('title', 'Tableau de bord')

@section('dashboard')
    <div class="space-y-4">
        <p class="text-gray-600">Bienvenue dans votre espace Eternom.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="rounded-lg border border-border bg-white p-4">
                <div class="text-sm text-gray-500">Statut du compte</div>
                <div class="mt-2 text-lg font-medium text-gray-900">Actif</div>
            </div>
            <div class="rounded-lg border border-border bg-white p-4">
                <div class="text-sm text-gray-500">Serveurs</div>
                <div class="mt-2 text-lg font-medium text-gray-900">Bientôt disponible</div>
            </div>
            <div class="rounded-lg border border-border bg-white p-4">
                <div class="text-sm text-gray-500">Facturation</div>
                <div class="mt-2 text-lg font-medium text-gray-900">Bientôt disponible</div>
            </div>
        </div>
    </div>
@endsection
