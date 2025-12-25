@php
    $sections = [
        [
            'title' => 'Tickets',
            'items' => [
                [
                    'label' => 'Mes Tickets',
                    'route' => 'support.index',
                    'icon' => 'M3 10.5A7.5 7.5 0 0 1 10.5 3v5.25H18A7.5 7.5 0 0 1 10.5 18v-5.25H3Z',
                ],
            ],
        ],
    ];

    if (auth()->user()->hasPermission('support.assign')) {
        $sections[0]['items'][] = [
            'label' => 'Tickets non assignés',
            'route' => 'support.tickets.unassigned',
            'icon' => 'M10.5 10.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm0 1.5c-3.037 0-5.5 2.014-5.5 4.5V18h11v-1.5c0-2.486-2.463-4.5-5.5-4.5Z',
        ];
    }

    if (auth()->user()->hasRole('admin')) {
        $sections[] = [
            'title' => 'Navigation',
            'items' => [
                [
                    'label' => 'Administration',
                    'route' => 'admin.index',
                    'icon' => 'M9 4.5a.75.75 0 0 1 .721.544l.84 2.52a.75.75 0 0 0 .712.513H13.8a.75.75 0 0 1 .441 1.354l-2.13 1.547a.75.75 0 0 0-.272.838l.84 2.52a.75.75 0 0 1-1.154.838l-2.13-1.547a.75.75 0 0 0-.882 0l-2.13 1.547a.75.75 0 0 1-1.154-.838l.84-2.52a.75.75 0 0 0-.272-.838l-2.13-1.547a.75.75 0 0 1 .441-1.354h2.527a.75.75 0 0 0 .712-.513l.84-2.52A.75.75 0 0 1 9 4.5Z',
                ],
            ],
        ];
    }
@endphp

<aside class="bg-[var(--control-background)] border border-[var(--border)] rounded-[var(--radius-lg)] shadow-sm p-4 sticky top-24">
    <div class="mb-6 px-2 flex items-center gap-3">
        <div class="size-8 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-400">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                 <path fill-rule="evenodd" d="M4.804 21.644A6.707 6.707 0 006 21.75a6.721 6.721 0 003.583-1.029c.774.182 1.584.279 2.417.279 5.322 0 9.75-3.97 9.75-9 0-5.03-4.428-9-9.75-9s-9.75 3.97-9.75 9c0 2.409 1.012 4.587 2.674 6.192.232.226.277.428.178.715a3.375 3.375 0 01-1.464 1.787.75.75 0 00.419 1.396zM7.5 12.75a.75.75 0 100-1.5.75.75 0 000 1.5zm3.75 0a.75.75 0 100-1.5.75.75 0 000 1.5zm4.5 0a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
            </svg>
        </div>
        <h2 class="text-sm font-bold uppercase tracking-widest text-[var(--foreground)]">Staff Support</h2>
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
                                      {{ $active ? 'bg-blue-500/10 text-blue-400 font-bold shadow-sm' : 'text-[var(--muted-foreground)] hover:bg-[var(--secondary)] hover:text-[var(--foreground)]' }}">
                                <span class="inline-flex items-center gap-3">
                                    <div class="size-8 rounded-lg flex items-center justify-center transition-colors {{ $active ? 'bg-blue-500/20 text-blue-400' : 'bg-[var(--secondary)] group-hover:bg-[var(--control-background)] border border-[var(--border)]/50' }}">
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









