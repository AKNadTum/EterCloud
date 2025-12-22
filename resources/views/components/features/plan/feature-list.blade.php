<ul {{ $attributes->merge(['class' => 'space-y-3']) }}>
    <li class="flex items-center gap-3 text-sm text-gray-600">
        <x-heroicon-o-cpu-chip class="size-4 text-[var(--primary)]" />
        <span>{{ $plan->cpu > 0 ? $plan->cpu . '%' : 'CPU illimité' }}</span>
    </li>
    <li class="flex items-center gap-3 text-sm text-gray-600">
        <x-heroicon-o-square-3-stack-3d class="size-4 text-[var(--primary)]" />
        <span>{{ $plan->memory > 0 ? ($plan->memory / 1024) . ' GB' : 'RAM illimitée' }} RAM</span>
    </li>
    <li class="flex items-center gap-3 text-sm text-gray-600">
        <x-heroicon-o-server-stack class="size-4 text-[var(--primary)]" />
        <span>{{ ($plan->disk / 1024) }} GB Stockage</span>
    </li>
    <li class="flex items-center gap-3 text-sm text-gray-600">
        <x-heroicon-o-server class="size-4 text-[var(--primary)]" />
        <span>{{ $plan->server_limit }} Instance{{ $plan->server_limit > 1 ? 's' : '' }}</span>
    </li>
    <li class="flex items-center gap-3 text-sm text-gray-600">
        <x-heroicon-o-circle-stack class="size-4 text-[var(--primary)]" />
        <span>{{ $plan->databases_limit }} Base{{ $plan->databases_limit > 1 ? 's' : '' }} de données</span>
    </li>
    <li class="flex items-center gap-3 text-sm text-gray-600">
        <x-heroicon-o-cloud-arrow-up class="size-4 text-[var(--primary)]" />
        <span>{{ $plan->backups_limit }} Backup{{ $plan->backups_limit > 1 ? 's' : '' }}</span>
    </li>

    @if($showLocations && $plan->locations->count() > 0)
        <li class="pt-2">
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Localisations disponibles</div>
            <div class="flex flex-wrap gap-2">
                @foreach($plan->locations as $loc)
                    <x-ui.feedback.badge variant="subtle" size="sm">
                        {{ $loc->display_name ?? $loc->name ?? $loc->ptero_id_location }}
                    </x-ui.feedback.badge>
                @endforeach
            </div>
        </li>
    @endif
</ul>




