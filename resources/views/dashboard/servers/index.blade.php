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
                    <p class="text-sm text-gray-500">
                        Utilisation : <strong>{{ $realServersCount }}</strong> / {{ $plan->server_limit }} serveurs (Plan {{ $plan->name }})
                    </p>
                @endif
            </div>
            <x-ui.button href="{{ route('dashboard.servers.create') }}" size="sm" :disabled="$plan && $realServersCount >= $plan->server_limit">
                Créer un serveur
            </x-ui.button>
        </div>

        @php($list = $servers ?? [])
        @if (empty($list))
            <x-ui.alert variant="default" class="p-6">
                <x-heroicon-o-information-circle class="size-5" />
                <x-ui.alert-description>
                    Aucun serveur à afficher.
                </x-ui.alert-description>
            </x-ui.alert>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($list as $s)
                    <div class="rounded-lg border border-gray-200 bg-white p-4 space-y-2">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="font-medium">{{ $s['name'] ?? 'Serveur' }}</div>
                                @if (!empty($s['description']))
                                    <div class="text-sm text-gray-600">{{ $s['description'] }}</div>
                                @endif
                            </div>
                            <div class="shrink-0 flex flex-col items-end gap-2">
                                @if (!empty($s['is_demo']))
                                    <x-ui.badge variant="accent" size="sm">DÉMO</x-ui.badge>
                                @endif
                                @if (!empty($s['location_name']))
                                    <div class="text-[10px] font-bold uppercase tracking-wider text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded">
                                        {{ $s['location_name'] }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        @if (!empty($s['node_name']))
                            <div class="text-xs text-gray-500 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3 opacity-50">
                                    <path fill-rule="evenodd" d="M2 4.75A.75.75 0 0 1 2.75 4h14.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 4.75ZM2 10a.75.75 0 0 1 .75-.75h14.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 10Zm0 5.25a.75.75 0 0 1 .75-.75h14.5a.75.75 0 0 1 0 1.5H2.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                                </svg>
                                {{ $s['node_name'] }}
                            </div>
                        @endif
                        <div class="text-xs text-gray-500">
                            @if (!empty($s['identifier']))
                                identifiant: {{ $s['identifier'] }}
                            @elseif (!empty($s['uuid']))
                                uuid: {{ Str::limit($s['uuid'], 18) }}
                            @else
                                id: {{ $s['id'] ?? '-' }}
                            @endif
                        </div>
                        <div class="pt-2 flex gap-2">
                            <x-ui.button variant="outline" size="sm" href="{{ $s['panel_url'] ?? '#' }}" target="_blank">Gérer</x-ui.button>
                            <form method="POST" action="{{ route('dashboard.servers.destroy', $s['id']) }}" onsubmit="return confirm('Supprimer ce serveur {{ !empty($s['is_demo']) ? '(démo) ' : '' }}? Cette action est irréversible.')">
                                @csrf
                                @method('DELETE')
                                <x-ui.button variant="destructive" size="sm" type="submit">Supprimer</x-ui.button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
