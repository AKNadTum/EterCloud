<header
    id="main-header"
    x-data="{ scrolled: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
    :data-scrolled="scrolled"
    class="group/header sticky top-0 z-50 flex justify-center py-4 transition-all duration-500 ease-in-out data-[scrolled=true]:py-2"
>
    @php
        $navLinks = [
            ['href' => '/', 'label' => 'Accueil'],
            ['href' => route('home') . '#plans', 'label' => 'Plans'],
            ['href' => '/contact', 'label' => 'Contact'],
        ];
    @endphp

    <nav
        id="main-nav"
        class="container-custom py-3 flex items-center bg-transparent border border-transparent rounded-[2rem] shadow-none transition-all duration-500 ease-in-out backdrop-blur-none
               group-data-[scrolled=true]/header:max-w-[90%] group-data-[scrolled=true]/header:bg-[var(--control-background)]/80 group-data-[scrolled=true]/header:backdrop-blur-xl group-data-[scrolled=true]/header:border-[var(--border)] group-data-[scrolled=true]/header:shadow-2xl group-data-[scrolled=true]/header:rounded-[var(--radius-lg)] group-data-[scrolled=true]/header:scale-[1.02]"
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
            @foreach($navLinks as $link)
                <li><x-ui.button :href="$link['href']" variant="ghost" class="font-medium">{{ $link['label'] }}</x-ui.button></li>
            @endforeach
        </ul>

        <div class="flex-1 flex items-center justify-end gap-3">
            @auth
                <x-layout.user-menu />
            @else
                <x-ui.button href="{{ route('auth.login') }}" variant="outline" class="rounded-full px-6">Connexion</x-ui.button>
                <x-ui.button href="{{ route('auth.register') ?? '#' }}" class="rounded-full px-6 shadow-md shadow-[var(--primary)]/20">S'inscrire</x-ui.button>
            @endauth
        </div>
    </nav>
</header>




