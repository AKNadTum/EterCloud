@extends('dashboard.layout')

@section('title', 'Serveurs')

@section('dashboard')
    <div class="space-y-6">
        @if (!($linked ?? false))
            <x-ui.alert variant="warning" dismissible="true" class="mb-6">
                <x-heroicon-o-exclamation-triangle class="size-5" />
                <x-ui.alert-title>Aucun compte Pterodactyl lié</x-ui.alert-title>
                <x-ui.alert-description class="space-y-4">
                    <p>Pour récupérer vos serveurs, liez votre compte Pterodactyl depuis votre profil.</p>
                    <x-ui.button variant="outline" size="sm" href="{{ route('dashboard.profile') }}">
                        Aller au profil
                    </x-ui.button>
                </x-ui.alert-description>
            </x-ui.alert>
        @endif

        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <h2 class="text-lg font-semibold">Vos serveurs</h2>
                @if ($plan)
                    <p class="text-sm text-[var(--muted-foreground)]">
                        Utilisation : <x-ui.badge variant="subtle" size="sm">{{ $realServersCount }} / {{ $plan->server_limit }}</x-ui.badge> serveurs (Plan {{ $plan->name }})
                    </p>
                @endif
            </div>
            <x-ui.button href="{{ route('dashboard.servers.create') }}" size="sm" :disabled="$plan && $realServersCount >= $plan->server_limit">
                <x-heroicon-o-plus class="size-4 mr-1" />
                Créer un serveur
            </x-ui.button>
        </div>

        @php($list = $servers ?? [])
        @if (empty($list))
            <x-ui.card padded="true" class="text-center py-12">
                <div class="mx-auto size-12 rounded-full bg-[var(--secondary)] flex items-center justify-center text-gray-400 mb-4">
                    <x-heroicon-o-server class="size-6" />
                </div>
                <h3 class="text-lg font-semibold text-[var(--foreground)]">Aucun serveur</h3>
                <p class="text-[var(--muted-foreground)] mt-1 max-w-sm mx-auto">Vous n'avez pas encore de serveur. Commencez par en créer un pour lancer votre projet.</p>
                <x-ui.button href="{{ route('dashboard.servers.create') }}" class="mt-6" size="sm">
                    Créer mon premier serveur
                </x-ui.button>
            </x-ui.card>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($list as $s)
                    <x-server.card :server="$s" />
                @endforeach
            </div>
        @endif
    </div>
@endsection

