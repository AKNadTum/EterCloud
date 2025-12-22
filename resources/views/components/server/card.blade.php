@props(['server'])

@php
    $s = $server;
@endphp

<div class="rounded-lg border border-[var(--border)] bg-[var(--control-background)] p-4 space-y-2">
    <div class="flex items-start justify-between gap-3">
        <div>
            <div class="font-medium">{{ $s['name'] ?? 'Serveur' }}</div>
            @if (!empty($s['description']))
                <div class="text-sm text-[var(--muted-foreground)]">{{ $s['description'] }}</div>
            @endif
        </div>
        <div class="shrink-0 flex flex-col items-end gap-2">
            @if (!empty($s['is_demo']))
                <x-ui.badge variant="accent" size="sm">DÉMO</x-ui.badge>
            @endif
            @if (!empty($s['location_name']))
                <div class="text-[10px] font-bold uppercase tracking-wider text-gray-400 bg-[var(--secondary)] px-1.5 py-0.5 rounded">
                    {{ $s['location_name'] }}
                </div>
            @endif
        </div>
    </div>
    @if (!empty($s['node_name']))
        <div class="text-xs text-[var(--muted-foreground)] flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3 opacity-50">
                <path fill-rule="evenodd" d="M2 4.75A.75.75 0 0 1 2.75 4h14.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 4.75ZM2 10a.75.75 0 0 1 .75-.75h14.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 10Zm0 5.25a.75.75 0 0 1 .75-.75h14.5a.75.75 0 0 1 0 1.5H2.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
            </svg>
            {{ $s['node_name'] }}
        </div>
    @endif
    <div class="text-xs text-[var(--muted-foreground)]">
        @if (!empty($s['identifier']))
            identifiant: {{ $s['identifier'] }}
        @elseif (!empty($s['uuid']))
            uuid: {{ Str::limit($s['uuid'], 18) }}
        @else
            id: {{ $s['id'] ?? '-' }}
        @endif
    </div>
    <div class="pt-2 flex gap-2">
        @if(!empty($s['panel_url']))
            <x-ui.button variant="outline" size="sm" href="{{ $s['panel_url'] }}" target="_blank">Gérer</x-ui.button>
        @endif
        <form method="POST" action="{{ route('dashboard.servers.destroy', $s['id']) }}" onsubmit="return confirm('Supprimer ce serveur {{ !empty($s['is_demo']) ? '(démo) ' : '' }}? Cette action est irréversible.')">
            @csrf
            @method('DELETE')
            <x-ui.button variant="destructive" size="sm" type="submit">Supprimer</x-ui.button>
        </form>
    </div>
</div>

