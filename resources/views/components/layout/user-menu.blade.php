<div x-data="{ open: false }" @click.away="open = false" {{ $attributes->merge(['class' => 'relative']) }}>
    <button @click="open = !open" class="list-none cursor-pointer focus:outline-none">
        <div class="flex items-center gap-2 pl-3 pr-2 py-1.5 border border-[var(--border)] rounded-full bg-[var(--control-background)]/50 backdrop-blur-sm hover:bg-[var(--secondary)] transition-colors shadow-sm">
            <span class="text-sm font-semibold truncate max-w-[10rem]">
                {{ auth()->user()->name ?? auth()->user()->email }}
            </span>
            <div class="size-7 rounded-full bg-[var(--primary)] flex items-center justify-center text-[var(--primary-foreground)] text-xs font-bold shadow-inner">
                {{ strtoupper(substr(auth()->user()->name ?? auth()->user()->email, 0, 1)) }}
            </div>
        </div>
    </button>
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 w-60 bg-[var(--control-background)] border border-[var(--border)] rounded-[var(--radius-lg)] p-1.5 z-50 shadow-2xl"
         style="display: none;"
    >
        <div class="px-3 py-2 mb-1">
            <p class="text-[10px] font-bold uppercase tracking-widest text-muted-foreground">Menu Utilisateur</p>
        </div>

        <a href="{{ route('dashboard.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-[var(--radius)] hover:bg-[var(--secondary)] transition-colors text-sm font-medium group">
            <x-heroicon-o-squares-2x2 class="size-4 text-[var(--muted-foreground)] group-hover:text-[var(--foreground)]" />
            Tableau de bord
        </a>

        @if(auth()->user()->hasRole('admin'))
            <a href="{{ route('admin.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-[var(--radius)] hover:bg-[var(--primary-foreground)]/10 text-[var(--primary-foreground)] transition-colors text-sm font-bold">
                <x-heroicon-o-shield-check class="size-4" />
                Administration
            </a>
        @endif

        @if(auth()->user()->hasPermission('support.access'))
            <a href="{{ route('support.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-[var(--radius)] hover:bg-[var(--primary)]/20 text-[var(--primary-foreground)] transition-colors text-sm font-bold">
                <x-heroicon-o-chat-bubble-left-right class="size-4" />
                Panel Support
            </a>
        @endif

        <div class="my-1.5 border-t border-[var(--border)]/50"></div>

        <div class="grid grid-cols-1 gap-0.5">
            @php
                $links = [
                    ['route' => 'dashboard.profile', 'icon' => 'heroicon-o-user', 'label' => 'Mon Profil'],
                    ['route' => 'dashboard.servers', 'icon' => 'heroicon-o-server-stack', 'label' => 'Mes Serveurs'],
                    ['route' => 'dashboard.tickets.index', 'icon' => 'heroicon-o-chat-bubble-left-right', 'label' => 'Mes Tickets'],
                    ['route' => 'dashboard.billing', 'icon' => 'heroicon-o-credit-card', 'label' => 'Facturation'],
                ];
            @endphp
            @foreach($links as $link)
                <a href="{{ route($link['route']) }}" class="flex items-center gap-3 px-3 py-2 rounded-[var(--radius)] hover:bg-[var(--secondary)] transition-colors text-sm text-[var(--muted-foreground)] hover:text-[var(--foreground)] group">
                    <x-dynamic-component :component="$link['icon']" class="size-4 text-[var(--muted-foreground)] group-hover:text-[var(--foreground)]" />
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>

        <div class="my-1.5 border-t border-[var(--border)]/50"></div>

        <form method="POST" action="{{ route('auth.logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-[var(--radius)] hover:bg-red-500/10 text-red-400 transition-colors text-sm font-medium">
                <x-heroicon-o-arrow-left-on-rectangle class="size-4" />
                Déconnexion
            </button>
        </form>
    </div>
</div>




