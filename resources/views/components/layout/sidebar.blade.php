@php
    $sections = [
        [
            'title' => 'Général',
            'items' => [
                [
                    'label' => 'Tableau de bord',
                    'route' => 'dashboard.index',
                    'icon' => 'M3 10.5A7.5 7.5 0 0 1 10.5 3v5.25H18A7.5 7.5 0 0 1 10.5 18v-5.25H3Z',
                ],
                [
                    'label' => 'Profil',
                    'route' => 'dashboard.profile',
                    'icon' => 'M10.5 10.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm0 1.5c-3.037 0-5.5 2.014-5.5 4.5V18h11v-1.5c0-2.486-2.463-4.5-5.5-4.5Z',
                ],
            ],
        ],
        [
            'title' => 'Services',
            'items' => [
                [
                    'label' => 'Serveurs',
                    'route' => 'dashboard.servers',
                    'icon' => 'M3 7.5A2.5 2.5 0 0 1 5.5 5h10A2.5 2.5 0 0 1 18 7.5v1A2.5 2.5 0 0 1 15.5 11h-10A2.5 2.5 0 0 1 3 8.5v-1Zm0 7A2.5 2.5 0 0 1 5.5 12h10a2.5 2.5 0 0 1 2.5 2.5v1A2.5 2.5 0 0 1 15.5 18h-10A2.5 2.5 0 0 1 3 15.5v-1Z',
                ],
                [
                    'label' => 'Facturation',
                    'route' => 'dashboard.billing',
                    'icon' => 'M3 6.75A1.75 1.75 0 0 1 4.75 5h10.5A1.75 1.75 0 0 1 17 6.75v6.5A1.75 1.75 0 0 1 15.25 15H4.75A1.75 1.75 0 0 1 3 13.25v-6.5Zm2 1.75h10v1.5H5V8.5Z',
                ],
            ],
        ],
        [
            'title' => 'Assistance',
            'items' => [
                [
                    'label' => 'Mes Tickets',
                    'route' => 'dashboard.tickets.index',
                    'icon' => 'M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25',
                ],
            ],
        ],
    ];

    if (auth()->user()->hasPermission('support.access')) {
        $sections[2]['items'][] = [
            'label' => 'Panel Support',
            'route' => 'support.index',
            'icon' => 'M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z',
        ];
    }
@endphp

<aside class="bg-[var(--control-background)] border border-[var(--border)] rounded-[var(--radius-lg)] shadow-sm p-4 sticky top-24">
    <div class="mb-6 px-2 flex items-center gap-3">
        <div class="size-8 rounded-lg bg-[var(--primary-foreground)]/10 flex items-center justify-center text-[var(--primary-foreground)]">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                <path d="M11.47 3.84a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.06l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 0 0 1.061 1.06l8.69-8.69Z" />
                <path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.43Z" />
            </svg>
        </div>
        <h2 class="text-sm font-bold uppercase tracking-widest text-[var(--foreground)]">Espace Client</h2>
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

                                @isset($item['wip'])
                                    @if($item['wip'])
                                        <x-ui.badge variant="accent" size="sm" class="text-[9px] px-1.5 py-0 uppercase font-bold tracking-tighter">WIP</x-ui.badge>
                                    @endif
                                @endisset
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </nav>
</aside>









