@props(['server'])

@php($s = $server)

<div {{ $attributes->merge(['class' => 'bg-[var(--control-background)] border border-[var(--border)] rounded-[var(--radius-lg)] p-4 flex items-center justify-between shadow-sm hover:shadow-md transition-shadow']) }}>
    <div class="flex items-center gap-4">
        <div class="size-10 rounded bg-[var(--secondary)] flex items-center justify-center text-[var(--muted-foreground)] border border-[var(--border)]">
            <x-heroicon-o-server class="size-5" />
        </div>
        <div>
            <div class="flex items-center gap-2">
                <span class="font-bold text-[var(--foreground)]">{{ $s['name'] }}</span>
                @if (!empty($s['is_demo']))
                    <x-ui.badge variant="accent" size="sm">DÉMO</x-ui.badge>
                @endif
            </div>
            <div class="text-xs text-[var(--muted-foreground)] flex items-center gap-2">
                <span>{{ $s['location_name'] ?? 'Localisation inconnue' }}</span>
                <span class="size-1 rounded-full bg-[var(--border)]"></span>
                <span>{{ $s['node_name'] ?? 'Node' }}</span>
            </div>
        </div>
    </div>
    <div class="flex items-center gap-2">
        @if(!empty($s['panel_url']))
            <x-ui.button href="{{ $s['panel_url'] }}" target="_blank" variant="outline" size="sm">
                <x-heroicon-o-arrow-top-right-on-square class="size-4 mr-1" />
                Panel
            </x-ui.button>
        @endif

        <x-ui.button href="{{ route('dashboard.servers') }}" variant="ghost" size="sm" class="text-[var(--muted-foreground)] hover:text-[var(--foreground)]">
            <x-heroicon-o-cog-6-tooth class="size-4" />
        </x-ui.button>
    </div>
</div>
