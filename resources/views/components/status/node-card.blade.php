<div {{ $attributes->merge(['class' => 'bg-[var(--control-background)] border border-[var(--border)] rounded-[var(--radius-lg)] shadow-sm overflow-hidden flex flex-col']) }}>
    <div class="p-5 border-b border-[var(--border)] bg-muted/20 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <x-ui.icon-circle variant="primary" icon="heroicon-o-server" size="sm" />
            <div>
                <div class="font-black text-sm text-[var(--foreground)]">{{ $name }}</div>
                <div class="text-[10px] text-muted-foreground uppercase tracking-widest font-bold">{{ $locationLong }} ({{ $locationShort }}) — {{ $fqdn }}</div>
            </div>
        </div>
        @if($isMaintenance)
            <x-ui.badge variant="warning" size="sm" class="font-bold">Maintenance</x-ui.badge>
        @else
            <x-ui.badge variant="success" size="sm" class="font-bold">Online</x-ui.badge>
        @endif
    </div>
    <div class="p-5 space-y-4 flex-grow">
        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-1.5">
                <div class="flex justify-between text-[10px] font-black uppercase text-muted-foreground tracking-tighter">
                    <span>Stockage</span>
                    <span>{{ round($diskPercent) }}%</span>
                </div>
                <div class="h-2 w-full bg-[var(--secondary)] rounded-full overflow-hidden border border-[var(--border)]">
                    <div class="h-full bg-[var(--primary-foreground)] transition-all duration-500" style="width: {{ $diskPercent }}%"></div>
                </div>
            </div>
            <div class="space-y-1.5">
                <div class="flex justify-between text-[10px] font-black uppercase text-muted-foreground tracking-tighter">
                    <span>CPU</span>
                    <span>{{ $isCpuUnlimited ? 'Illimité' : round($cpuPercent) . '%' }}</span>
                </div>
                <div class="h-2 w-full bg-[var(--secondary)] rounded-full overflow-hidden border border-[var(--border)]">
                    <div class="h-full bg-[var(--accent-foreground)] transition-all duration-500" style="width: {{ $isCpuUnlimited ? 100 : $cpuPercent }}%"></div>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-between pt-2 border-t border-[var(--border)]/50">
            <div class="text-xs font-bold text-[var(--foreground)] flex items-center gap-1.5">
                <x-heroicon-o-cpu-chip class="size-3.5 text-[var(--primary-foreground)]" />
                <span>{{ $totalServers }} serveurs</span>
            </div>
            <div class="text-[10px] font-black text-muted-foreground uppercase tracking-tighter">
                {{ round($diskTotal/1024) }}GB Stockage
            </div>
        </div>
    </div>
</div>





