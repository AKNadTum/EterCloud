@php
    $sections = [
        [
            'title' => 'Général',
            'items' => [
                [
                    'label' => 'Vue d\'ensemble',
                    'route' => 'admin.index',
                    'icon' => 'M3 10.5A7.5 7.5 0 0 1 10.5 3v5.25H18A7.5 7.5 0 0 1 10.5 18v-5.25H3Z',
                ],
            ],
        ],
        [
            'title' => 'Utilisateurs',
            'items' => [
                [
                    'label' => 'Utilisateurs',
                    'route' => 'admin.users.index',
                    'icon' => 'M10.5 10.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm0 1.5c-3.037 0-5.5 2.014-5.5 4.5V18h11v-1.5c0-2.486-2.463-4.5-5.5-4.5Z',
                ],
                [
                    'label' => 'Rôles & Permissions',
                    'route' => 'admin.roles.index',
                    'icon' => 'M9 4.5a.75.75 0 0 1 .721.544l.84 2.52a.75.75 0 0 0 .712.513H13.8a.75.75 0 0 1 .441 1.354l-2.13 1.547a.75.75 0 0 0-.272.838l.84 2.52a.75.75 0 0 1-1.154.838l-2.13-1.547a.75.75 0 0 0-.882 0l-2.13 1.547a.75.75 0 0 1-1.154-.838l.84-2.52a.75.75 0 0 0-.272-.838l-2.13-1.547a.75.75 0 0 1 .441-1.354h2.527a.75.75 0 0 0 .712-.513l.84-2.52A.75.75 0 0 1 9 4.5Z',
                ],
                [
                    'label' => 'Permissions',
                    'route' => 'admin.permissions.index',
                    'icon' => 'M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25',
                ],
            ],
        ],
        [
            'title' => 'Infrastructure',
            'items' => [
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
            ],
        ],
        [
            'title' => 'Commercial',
            'items' => [
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
            ],
        ],
        [
            'title' => 'Assistance',
            'items' => [
                [
                    'label' => 'Panel Support',
                    'route' => 'support.index',
                    'icon' => 'M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25',
                ],
            ],
        ],
    ];
@endphp

<aside class="bg-[var(--control-background)] border border-[var(--border)] rounded-[var(--radius-lg)] shadow-sm p-4 sticky top-24">
    <div class="mb-6 px-2 flex items-center gap-3">
        <div class="size-8 rounded-lg bg-[var(--primary-foreground)]/10 flex items-center justify-center text-[var(--primary-foreground)]">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                <path d="M16.5 7.5h-9v9h9v-9Z" />
                <path fill-rule="evenodd" d="M8.25 2.25A.75.75 0 0 1 9 3v.75h2.25V3a.75.75 0 0 1 1.5 0v.75H15V3a.75.75 0 0 1 1.5 0v.75h.75a3 3 0 0 1 3 3v.75H21a.75.75 0 0 1 0 1.5h-.75V11.25H21a.75.75 0 0 1 0 1.5h-.75V15H21a.75.75 0 0 1 0 1.5h-.75v.75a3 3 0 0 1-3 3h-.75V21a.75.75 0 0 1-1.5 0v-.75H12.75V21a.75.75 0 0 1-1.5 0v-.75H9V21a.75.75 0 0 1-1.5 0v-.75h-.75a3 3 0 0 1-3-3v-.75H3a.75.75 0 0 1 0-1.5h.75V12.75H3a.75.75 0 0 1 0-1.5h.75V9H3a.75.75 0 0 1 0-1.5h.75v-.75a3 3 0 0 1 3-3h.75V3a.75.75 0 0 1 .75-.75ZM6 6.75A.75.75 0 0 1 6.75 6h10.5a.75.75 0 0 1 .75.75v10.5a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V6.75Z" clip-rule="evenodd" />
            </svg>
        </div>
        <h2 class="text-sm font-bold uppercase tracking-widest text-[var(--foreground)]">Administration</h2>
    </div>

    <nav class="space-y-6">
        @foreach ($sections as $section)
            <div>
                @if($section['title'])
                    <div class="px-3 mb-2 flex items-center gap-2">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-[var(--muted-foreground)]">{{ $section['title'] }}</span>
                        <div class="h-px flex-1 bg-[var(--border)]"></div>
                    </div>
                @endif
                <ul class="flex flex-col gap-1">
                    @foreach ($section['items'] as $item)
                        @php
                            $active = request()->routeIs($item['route'] . '*');
                        @endphp
                        <li>
                            <a href="{{ route($item['route']) }}"
                               class="group flex items-center justify-between gap-3 rounded-[var(--radius)] px-3 py-2 text-sm transition-all duration-200
                                      {{ $active ? 'bg-[var(--primary-foreground)]/10 text-[var(--primary-foreground)] font-bold shadow-sm' : 'text-[var(--muted-foreground)] hover:bg-[var(--secondary)] hover:text-[var(--foreground)]' }}">
                                <span class="inline-flex items-center gap-3">
                                    <div class="size-8 rounded-lg flex items-center justify-center transition-colors {{ $active ? 'bg-[var(--primary-foreground)]/20 text-[var(--primary-foreground)]' : 'bg-[var(--secondary)] group-hover:bg-[var(--control-background)] border border-[var(--border)]/50' }}">
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
            </div>
        @endforeach
    </nav>
</aside>
