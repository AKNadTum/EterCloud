@extends('admin.layout')

@section('title', "Détails du Serveur: " . $server['attributes']['name'])

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-[var(--control-background)] rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm p-6">
            <h3 class="text-lg font-bold mb-6 text-[var(--foreground)] border-b border-[var(--border)] pb-2">Informations Générales</h3>
            <dl class="grid grid-cols-2 gap-x-4 gap-y-4">
                <dt class="text-sm font-medium text-[var(--muted-foreground)]">ID Pterodactyl</dt>
                <dd class="text-sm text-[var(--foreground)] font-bold">{{ $server['attributes']['id'] }}</dd>

                <dt class="text-sm font-medium text-[var(--muted-foreground)]">Identifier</dt>
                <dd class="text-sm text-[var(--foreground)] font-bold">{{ $server['attributes']['identifier'] }}</dd>

                <dt class="text-sm font-medium text-[var(--muted-foreground)]">Nom</dt>
                <dd class="text-sm text-[var(--foreground)] font-bold">{{ $server['attributes']['name'] }}</dd>

                <dt class="text-sm font-medium text-[var(--muted-foreground)]">Propriétaire</dt>
                <dd class="text-sm text-[var(--foreground)] font-bold">
                    {{ $server['attributes']['relationships']['user']['attributes']['username'] ?? 'Inconnu' }}
                    <span class="text-xs font-normal text-[var(--muted-foreground)]">(ID: {{ $server['attributes']['user'] }})</span>
                </dd>

                <dt class="text-sm font-medium text-[var(--muted-foreground)]">Node ID</dt>
                <dd class="text-sm text-[var(--foreground)] font-bold">{{ $server['attributes']['node'] }}</dd>

                <dt class="text-sm font-medium text-[var(--muted-foreground)]">Statut</dt>
                <dd class="text-sm">
                    @if($server['attributes']['suspended'])
                        <x-ui.badge variant="destructive">Suspendu</x-ui.badge>
                    @else
                        <x-ui.badge variant="success">Actif</x-ui.badge>
                    @endif
                </dd>
            </dl>
        </div>

        <div class="bg-[var(--control-background)] rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm p-6">
            <h3 class="text-lg font-bold mb-6 text-[var(--foreground)] border-b border-[var(--border)] pb-2">Limites de Ressources</h3>
            <dl class="grid grid-cols-2 gap-x-4 gap-y-4">
                <dt class="text-sm font-medium text-[var(--muted-foreground)]">CPU</dt>
                <dd class="text-sm text-[var(--foreground)] font-bold">{{ $server['attributes']['limits']['cpu'] }}%</dd>

                <dt class="text-sm font-medium text-[var(--muted-foreground)]">Mémoire</dt>
                <dd class="text-sm text-[var(--foreground)] font-bold">{{ $server['attributes']['limits']['memory'] }} MB</dd>

                <dt class="text-sm font-medium text-[var(--muted-foreground)]">Disque</dt>
                <dd class="text-sm text-[var(--foreground)] font-bold">{{ $server['attributes']['limits']['disk'] }} MB</dd>

                <dt class="text-sm font-medium text-[var(--muted-foreground)]">Bases de données</dt>
                <dd class="text-sm text-[var(--foreground)] font-bold">{{ $server['attributes']['feature_limits']['databases'] }}</dd>

                <dt class="text-sm font-medium text-[var(--muted-foreground)]">Backups</dt>
                <dd class="text-sm text-[var(--foreground)] font-bold">{{ $server['attributes']['feature_limits']['backups'] }}</dd>
            </dl>
        </div>
    </div>

    <div class="mt-6 flex justify-end gap-3 pt-6 border-t border-[var(--border)]">
        <x-ui.button href="{{ route('admin.servers.index') }}" variant="outline">Retour à la liste</x-ui.button>

        @if($server['attributes']['suspended'])
            <form action="{{ route('admin.servers.unsuspend', $server['attributes']['id']) }}" method="POST">
                @csrf
                <x-ui.button type="submit" variant="success">
                    <x-heroicon-o-play class="size-4 mr-1" />
                    Réactiver
                </x-ui.button>
            </form>
        @else
            <form action="{{ route('admin.servers.suspend', $server['attributes']['id']) }}" method="POST">
                @csrf
                <x-ui.button type="submit" variant="warning">
                    <x-heroicon-o-pause class="size-4 mr-1" />
                    Suspendre
                </x-ui.button>
            </form>
        @endif

        <form action="{{ route('admin.servers.destroy', $server['attributes']['id']) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce serveur ? Cette action est irréversible.')">
            @csrf
            @method('DELETE')
            <x-ui.button type="submit" variant="destructive">
                <x-heroicon-o-trash class="size-4 mr-1" />
                Supprimer le Serveur
            </x-ui.button>
        </form>
    </div>
@endsection









