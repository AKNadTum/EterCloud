<header
    id="main-header"
    x-data="{ scrolled: false, mobileMenuOpen: false }"
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
                <div class="size-8 md:size-9 rounded-xl bg-[var(--accent)] flex items-center justify-center group-hover:scale-110 transition-all shadow-lg shadow-[var(--accent)]/20 group-data-[scrolled=true]/header:size-8">
                    <x-heroicon-o-cloud class="size-5 md:size-6 text-[var(--accent-foreground)] group-data-[scrolled=true]/header:size-5 transition-all" />
                </div>
                <span class="font-black text-xl md:text-2xl tracking-tighter transition-all group-data-[scrolled=true]/header:text-xl">Etercloud</span>
            </a>
        </div>

        <ul class="hidden md:flex items-center gap-1">
            @foreach($navLinks as $link)
                <li><x-ui.button :href="$link['href']" variant="ghost" class="font-medium">{{ $link['label'] }}</x-ui.button></li>
            @endforeach
        </ul>

        <div class="flex-1 flex items-center justify-end gap-3">
            <div class="hidden md:flex items-center gap-3">
                @auth
                    <x-layout.user-menu />
                @else
                    <x-ui.button href="{{ route('auth.login') }}" variant="outline" class="rounded-full px-6">Connexion</x-ui.button>
                    <x-ui.button href="{{ route('auth.register') ?? '#' }}" class="rounded-full px-6 shadow-md shadow-[var(--primary)]/20">S'inscrire</x-ui.button>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <button
                @click="mobileMenuOpen = !mobileMenuOpen"
                class="md:hidden p-2 text-muted-foreground hover:text-primary transition-colors"
                aria-label="Toggle menu"
            >
                <x-heroicon-o-bars-3 x-show="!mobileMenuOpen" class="size-7" />
                <x-heroicon-o-x-mark x-show="mobileMenuOpen" class="size-7" x-cloak />
            </button>
        </div>
    </nav>

    <!-- Mobile Menu Drawer -->
    <div
        x-show="mobileMenuOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="fixed inset-0 z-40 md:hidden pt-24 px-4 pb-8 bg-background/95 backdrop-blur-md"
        x-cloak
    >
        <div class="flex flex-col h-full gap-8">
            <ul class="flex flex-col gap-2">
                @foreach($navLinks as $link)
                    <li>
                        <a
                            href="{{ $link['href'] }}"
                            @click="mobileMenuOpen = false"
                            class="block px-4 py-3 text-lg font-semibold rounded-xl hover:bg-secondary transition-colors"
                        >
                            {{ $link['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="mt-auto flex flex-col gap-4">
                @auth
                    <div class="px-4 py-3 bg-secondary rounded-2xl flex items-center justify-between">
                        <span class="font-medium text-muted-foreground">Mon compte</span>
                        <x-layout.user-menu />
                    </div>
                @else
                    <x-ui.button href="{{ route('auth.login') }}" variant="outline" class="w-full justify-center text-lg py-6 rounded-2xl">Connexion</x-ui.button>
                    <x-ui.button href="{{ route('auth.register') ?? '#' }}" class="w-full justify-center text-lg py-6 rounded-2xl shadow-lg shadow-[var(--primary)]/20">S'inscrire</x-ui.button>
                @endauth
            </div>
        </div>
    </div>
</header>








