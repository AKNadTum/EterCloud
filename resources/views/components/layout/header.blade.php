<header
    id="main-header"
    class="group/header sticky top-0 z-50 flex justify-center py-4 transition-all duration-500 ease-in-out data-[scrolled=true]:py-2"
    data-scrolled="false"
>
    <nav
        id="main-nav"
        class="w-full px-6 py-3 flex items-center bg-transparent border border-transparent rounded-[2rem] shadow-none transition-all duration-500 ease-in-out mx-4 backdrop-blur-none
               group-data-[scrolled=true]/header:max-w-[90%] group-data-[scrolled=true]/header:bg-[var(--control-background)]/80 group-data-[scrolled=true]/header:backdrop-blur-xl group-data-[scrolled=true]/header:border-[var(--border)] group-data-[scrolled=true]/header:shadow-2xl group-data-[scrolled=true]/header:rounded-[var(--radius-lg)] group-data-[scrolled=true]/header:scale-[1.02]"
        style="max-width: 85%;"
    >
        <div class="flex-1">
            <a href="/" class="flex items-center gap-2 group w-fit transition-all duration-500">
                <div class="size-9 rounded-xl bg-[var(--accent)] flex items-center justify-center group-hover:scale-110 transition-all shadow-lg shadow-[var(--accent)]/20 group-data-[scrolled=true]/header:size-8">
                    <x-heroicon-o-cloud class="size-6 text-[var(--accent-foreground)] group-data-[scrolled=true]/header:size-5 transition-all" />
                </div>
                <span class="font-black text-2xl tracking-tighter transition-all group-data-[scrolled=true]/header:text-xl">Etercloud</span>
            </a>
        </div>

        <ul class="hidden md:flex items-center gap-1">
            <li><x-ui.button href="/" variant="ghost" class="font-medium">Accueil</x-ui.button></li>
            <li><x-ui.button href="{{ route('home') }}#plans" variant="ghost" class="font-medium">Plans</x-ui.button></li>
            <li><x-ui.button href="/contact" variant="ghost" class="font-medium">Contact</x-ui.button></li>
        </ul>

        <div class="flex-1 flex items-center justify-end gap-3">
            @auth
                <details class="group relative">
                    <summary class="list-none cursor-pointer">
                        <div class="flex items-center gap-2 pl-3 pr-2 py-1.5 border border-[var(--border)] rounded-full bg-[var(--control-background)]/50 backdrop-blur-sm hover:bg-[var(--secondary)] transition-colors shadow-sm">
                            <span class="text-sm font-semibold truncate max-w-[10rem]">
                                {{ auth()->user()->name ?? auth()->user()->email }}
                            </span>
                            <div class="size-7 rounded-full bg-[var(--primary)] flex items-center justify-center text-[var(--primary-foreground)] text-xs font-bold shadow-inner">
                                {{ strtoupper(substr(auth()->user()->name ?? auth()->user()->email, 0, 1)) }}
                            </div>
                        </div>
                    </summary>
                    <div class="absolute right-0 mt-2 w-60 bg-[var(--control-background)] border border-[var(--border)] rounded-[var(--radius-lg)] p-1.5 z-50 shadow-2xl animate-in fade-in zoom-in-95 duration-200">
                        <div class="px-3 py-2 mb-1">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-muted-foreground">Menu Utilisateur</p>
                        </div>

                        <a href="{{ route('dashboard.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-[var(--radius)] hover:bg-[var(--secondary)] transition-colors text-sm font-medium">
                            <x-heroicon-o-squares-2x2 class="size-4 opacity-70" />
                            Tableau de bord
                        </a>

                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-[var(--radius)] hover:bg-[var(--primary)]/20 text-[var(--primary-foreground)] transition-colors text-sm font-bold">
                                <x-heroicon-o-shield-check class="size-4" />
                                Administration
                            </a>
                        @endif

                        @if(auth()->user()->hasPermission('support.access'))
                            <a href="{{ route('support.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-[var(--radius)] hover:bg-blue-500/10 text-blue-400 transition-colors text-sm font-bold">
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
                                <a href="{{ route($link['route']) }}" class="flex items-center gap-3 px-3 py-2 rounded-[var(--radius)] hover:bg-[var(--secondary)] transition-colors text-sm text-muted-foreground hover:text-foreground">
                                    <x-dynamic-component :component="$link['icon']" class="size-4 opacity-70" />
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
                </details>
            @else
                <x-ui.button href="{{ route('auth.login') }}" variant="outline" class="rounded-full px-6">Connexion</x-ui.button>
                <x-ui.button href="{{ route('auth.register') ?? '#' }}" class="rounded-full px-6 shadow-md shadow-[var(--primary)]/20">S'inscrire</x-ui.button>
            @endauth
        </div>
    </nav>
</header>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const header = document.getElementById('main-header');
        const userMenu = header.querySelector('details');

        const updateHeader = () => {
            const isScrolled = window.scrollY > 20;
            if (header.dataset.scrolled !== String(isScrolled)) {
                header.dataset.scrolled = isScrolled;
            }
        };

        // Fermer le menu utilisateur au clic extérieur
        document.addEventListener('click', (e) => {
            if (userMenu && !userMenu.contains(e.target)) {
                userMenu.removeAttribute('open');
            }
        });

        window.addEventListener('scroll', updateHeader, { passive: true });
        updateHeader();
    });
</script>
