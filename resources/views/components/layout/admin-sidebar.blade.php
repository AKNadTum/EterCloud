@php
    $items = [
        [
            'label' => 'Vue d\'ensemble',
            'route' => 'admin.index',
            'icon' => 'M3 10.5A7.5 7.5 0 0 1 10.5 3v5.25H18A7.5 7.5 0 0 1 10.5 18v-5.25H3Z',
        ],
        [
            'label' => 'Utilisateurs',
            'route' => 'admin.users.index',
            'icon' => 'M10.5 10.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm0 1.5c-3.037 0-5.5 2.014-5.5 4.5V18h11v-1.5c0-2.486-2.463-4.5-5.5-4.5Z',
        ],
        [
            'label' => 'Serveurs',
            'route' => 'admin.servers.index',
            'icon' => 'M3 7.5A2.5 2.5 0 0 1 5.5 5h10A2.5 2.5 0 0 1 18 7.5v1A2.5 2.5 0 0 1 15.5 11h-10A2.5 2.5 0 0 1 3 8.5v-1Zm0 7A2.5 2.5 0 0 1 5.5 12h10a2.5 2.5 0 0 1 2.5 2.5v1A2.5 2.5 0 0 1 15.5 18h-10A2.5 2.5 0 0 1 3 15.5v-1Z',
        ],
        [
            'label' => 'Nodes',
            'route' => 'admin.nodes.index',
            'icon' => 'M3 7.5A2.5 2.5 0 0 1 5.5 5h10A2.5 2.5 0 0 1 18 7.5v1A2.5 2.5 0 0 1 15.5 11h-10A2.5 2.5 0 0 1 3 8.5v-1Zm0 7A2.5 2.5 0 0 1 5.5 12h10a2.5 2.5 0 0 1 2.5 2.5v1A2.5 2.5 0 0 1 15.5 18h-10A2.5 2.5 0 0 1 3 15.5v-1Z',
        ],
        [
            'label' => 'Locations',
            'route' => 'admin.locations.index',
            'icon' => 'M10.5 3a7.5 7.5 0 1 0 0 15 7.5 7.5 0 0 0 0-15Zm0 1.5a6 6 0 1 1 0 12 6 6 0 0 1 0-12Z',
        ],
        [
            'label' => 'Plans',
            'route' => 'admin.plans.index',
            'icon' => 'M3 6.75A1.75 1.75 0 0 1 4.75 5h10.5A1.75 1.75 0 0 1 17 6.75v6.5A1.75 1.75 0 0 1 15.25 15H4.75A1.75 1.75 0 0 1 3 13.25v-6.5Zm2 1.75h10v1.5H5V8.5Z',
        ],
        [
            'label' => 'Facturation',
            'route' => 'admin.billing.index',
            'icon' => 'M3 6.75A1.75 1.75 0 0 1 4.75 5h10.5A1.75 1.75 0 0 1 17 6.75v6.5A1.75 1.75 0 0 1 15.25 15H4.75A1.75 1.75 0 0 1 3 13.25v-6.5Zm2 1.75h10v1.5H5V8.5Z',
        ],
    ];
@endphp

<aside class="bg-white border border-[var(--border)] rounded-[var(--radius-lg)] shadow-sm p-4 sticky top-24">
    <div class="mb-6 px-2">
        <h2 class="text-xs font-bold uppercase tracking-widest text-muted-foreground opacity-50">Administration</h2>
    </div>
    <nav>
        <ul class="flex flex-col gap-1">
            @foreach ($items as $item)
                @php
                    $active = request()->routeIs($item['route'] . '*');
                @endphp
                <li>
                    <a href="{{ route($item['route']) }}"
                       class="group flex items-center justify-between gap-3 rounded-[var(--radius)] px-3 py-2.5 text-sm transition-all duration-200
                              {{ $active ? 'bg-[var(--primary)] text-[var(--primary-foreground)] font-bold shadow-sm shadow-[var(--primary)]/20' : 'text-muted-foreground hover:bg-[var(--secondary)] hover:text-foreground' }}">
                        <span class="inline-flex items-center gap-3">
                            <div class="size-8 rounded-lg flex items-center justify-center transition-colors {{ $active ? 'bg-white/50' : 'bg-[var(--secondary)] group-hover:bg-white' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21 21" fill="currentColor" class="size-4.5">
                                    <path d="{{ $item['icon'] }}" />
                                </svg>
                            </div>
                            {{ $item['label'] }}
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
</aside>
