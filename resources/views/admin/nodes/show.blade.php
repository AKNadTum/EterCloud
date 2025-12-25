@extends('admin.layout')

@section('title', "Détails du Node: " . $node['attributes']['name'])

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-[var(--control-background)] rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm p-6">
            <h3 class="text-lg font-bold mb-6 text-[var(--foreground)] border-b border-[var(--border)] pb-2">Informations Générales</h3>
            <dl class="grid grid-cols-2 gap-x-4 gap-y-4">
                <dt class="text-sm font-medium text-[var(--muted-foreground)]">ID Pterodactyl</dt>
                <dd class="text-sm text-[var(--foreground)] font-bold">{{ $node['attributes']['id'] }}</dd>

                <dt class="text-sm font-medium text-[var(--muted-foreground)]">Nom</dt>
                <dd class="text-sm text-[var(--foreground)] font-bold">{{ $node['attributes']['name'] }}</dd>

                <dt class="text-sm font-medium text-[var(--muted-foreground)]">FQDN / IP</dt>
                <dd class="text-sm text-[var(--foreground)] font-bold">{{ $node['attributes']['fqdn'] }}</dd>

                <dt class="text-sm font-medium text-[var(--muted-foreground)]">Schéma</dt>
                <dd class="text-sm text-[var(--foreground)] font-bold">{{ strtoupper($node['attributes']['scheme']) }}</dd>

                <dt class="text-sm font-medium text-[var(--muted-foreground)]">Maintenance</dt>
                <dd class="text-sm">
                    @if($node['attributes']['maintenance_mode'])
                        <x-ui.badge variant="warning">Activé</x-ui.badge>
                    @else
                        <x-ui.badge variant="success">Désactivé</x-ui.badge>
                    @endif
                </dd>
            </dl>
        </div>

        <div class="bg-[var(--control-background)] rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm p-6">
            <h3 class="text-lg font-bold mb-6 text-[var(--foreground)] border-b border-[var(--border)] pb-2">Ressources</h3>
            <dl class="grid grid-cols-2 gap-x-4 gap-y-4">
                <dt class="text-sm font-medium text-[var(--muted-foreground)]">Mémoire</dt>
                <dd class="text-sm text-[var(--foreground)] font-bold">{{ $node['attributes']['memory'] }} MB</dd>

                <dt class="text-sm font-medium text-[var(--muted-foreground)] pl-4 italic">Sur-allocation</dt>
                <dd class="text-sm text-[var(--muted-foreground)]">{{ $node['attributes']['memory_overallocate'] }}%</dd>

                <dt class="text-sm font-medium text-[var(--muted-foreground)] border-t border-[var(--border)] pt-4">Disque</dt>
                <dd class="text-sm text-[var(--foreground)] font-bold border-t border-[var(--border)] pt-4">{{ $node['attributes']['disk'] }} MB</dd>

                <dt class="text-sm font-medium text-[var(--muted-foreground)] pl-4 italic">Sur-allocation</dt>
                <dd class="text-sm text-[var(--muted-foreground)]">{{ $node['attributes']['disk_overallocate'] }}%</dd>
            </dl>
        </div>
    </div>

    <div class="mt-6 flex justify-end">
        <x-ui.button href="{{ route('admin.nodes.index') }}" variant="outline">Retour à la liste</x-ui.button>
    </div>
@endsection









