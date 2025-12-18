@extends('layout')

@section('content')
    <!-- HERO -->
    <section class="relative overflow-hidden py-16 md:py-24">
        <div class="absolute inset-0 bg-gradient-to-b from-[var(--primary)]/20 to-transparent -z-10"></div>
        <div class="mx-auto px-4" style="max-width: 65%;">
            <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-12">
                <div class="space-y-8">
                    <div class="inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-[var(--primary-foreground)] bg-[var(--primary)]/50 px-3 py-1 rounded-full border border-[var(--primary-foreground)]/10">
                        <span>Hébergement Minecraft</span>
                    </div>
                    <h1 class="text-4xl md:text-6xl font-extrabold leading-tight tracking-tight">
                        Ton serveur <span class="text-[var(--accent-foreground)]">Minecraft</span> prêt en un instant
                    </h1>
                    <p class="text-base md:text-lg max-w-2xl text-muted-foreground leading-relaxed">
                        Crée ton monde, ajoute des plugins ou des mods et joue sans compromis.
                        Profite d'une interface élégante et de performances optimales dès le premier plan gratuit.
                    </p>
                    <div class="flex flex-wrap items-center gap-4">
                        <x-ui.button href="{{ route('auth.login') }}" size="lg" class="shadow-lg shadow-[var(--primary)]/20 px-10">Commencer</x-ui.button>
                        <x-ui.button href="{{ route('home') }}#plans" variant="outline" size="lg" class="px-8">Voir les plans</x-ui.button>
                    </div>

                    <div class="flex flex-wrap items-center gap-6 pt-4 text-xs font-medium text-muted-foreground/80">
                        <div class="flex items-center gap-2">
                            <x-heroicon-o-bolt class="size-4 text-[var(--success-foreground)]" />
                            <span>Mise en ligne instantanée</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-heroicon-o-cpu-chip class="size-4 text-[var(--accent-foreground)]" />
                            <span>Propulsé par Pterodactyl</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-heroicon-o-gift class="size-4 text-[var(--primary-foreground)]" />
                            <span>Plan gratuit inclus</span>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block relative">
                    <div class="absolute -inset-4 bg-[var(--accent)]/20 blur-3xl rounded-full -z-10 animate-pulse"></div>
                    <div class="glass-card p-2 rounded-[var(--radius-xl)] rotate-1 hover:rotate-0 transition-transform duration-500 overflow-hidden">
                        <img
                            src="/images/hero_image.png"
                            alt="Aperçu du panneau"
                            loading="lazy"
                            class="w-full h-full object-cover rounded-[var(--radius-lg)]"
                        />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- POURQUOI NOUS -->
    <section class="py-20">
        <div class="mx-auto px-4" style="max-width: 65%;">
            <div class="mb-12 text-center">
                <h2 class="text-3xl font-bold tracking-tight">Pourquoi nous ?</h2>
                <p class="mt-3 text-muted-foreground">Une expérience d'hébergement pensée pour la simplicité.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <x-card.info-card
                    variant="primary"
                    icon="heroicon-o-rocket-launch"
                    title="Pterodactyl"
                    description="Gère ton serveur avec le panel le plus puissant et intuitif du marché."
                />
                <x-card.info-card
                    variant="success"
                    icon="heroicon-o-sparkles"
                    title="Gratuit"
                    description="Démarre ton aventure sans dépenser un centime. Sans engagement."
                />
                <x-card.info-card
                    variant="accent"
                    icon="heroicon-o-swatch"
                    title="Moderne"
                    description="Une interface claire, rapide et optimisée pour tous tes appareils."
                />
                <x-card.info-card
                    variant="warning"
                    icon="heroicon-o-shield-check"
                    title="Sécurité"
                    description="Sauvegardes automatiques et protection DDoS pour ton esprit tranquille."
                />
            </div>
        </div>
    </section>

    <!-- COMMENT ÇA MARCHE -->
    <section class="py-20 bg-[var(--secondary)]/30">
        <div class="mx-auto px-4" style="max-width: 65%;">
            <div class="mb-12 text-center text-balance">
                <h2 class="text-3xl font-bold tracking-tight">Prêt en 3 étapes</h2>
                <p class="mt-3 text-muted-foreground">Lancer ton serveur n'a jamais été aussi facile.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white border card-primary rounded-[var(--radius-lg)] p-8 text-center transition-all duration-300 shadow-sm">
                    <div class="size-14 rounded-2xl bg-[var(--primary)] text-[var(--primary-foreground)] border border-[var(--primary-foreground)]/10 flex items-center justify-center mx-auto mb-6 text-2xl font-black shadow-sm">1</div>
                    <h3 class="text-xl font-bold mb-3">Compte</h3>
                    <p class="text-sm text-muted-foreground leading-relaxed">Inscris-toi en quelques secondes, sans carte bancaire requise.</p>
                </div>
                <div class="bg-white border card-accent rounded-[var(--radius-lg)] p-8 text-center transition-all duration-300 shadow-sm">
                    <div class="size-14 rounded-2xl bg-[var(--accent)] text-[var(--accent-foreground)] border border-[var(--accent-foreground)]/10 flex items-center justify-center mx-auto mb-6 text-2xl font-black shadow-sm">2</div>
                    <h3 class="text-xl font-bold mb-3">Déploiement</h3>
                    <p class="text-sm text-muted-foreground leading-relaxed">Choisis ton plan et ton serveur se configure automatiquement.</p>
                </div>
                <div class="bg-white border card-success rounded-[var(--radius-lg)] p-8 text-center transition-all duration-300 shadow-sm">
                    <div class="size-14 rounded-2xl bg-[var(--success)] text-[var(--success-foreground)] border border-[var(--success-foreground)]/10 flex items-center justify-center mx-auto mb-6 text-2xl font-black shadow-sm">3</div>
                    <h3 class="text-xl font-bold mb-3">Aventure</h3>
                    <p class="text-sm text-muted-foreground leading-relaxed">Rejoins ton serveur avec tes amis et commence à bâtir ton monde.</p>
                </div>
            </div>
        </div>
    </section>

    @isset($plans)
        @if($plans->count() > 0)
            <section id="plans" class="py-24 scroll-mt-24">
                <div class="mx-auto px-4" style="max-width: 75%;">
                    <div class="mb-12 text-center">
                        <h2 class="text-3xl font-bold tracking-tight">Choisis ton plan</h2>
                        <p class="mt-3 text-muted-foreground">Une tarification transparente pour tous les besoins.</p>
                        <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                            <x-ui.badge variant="subtle" class="px-3 py-1 text-[10px] uppercase font-bold tracking-widest">Sans engagement</x-ui.badge>
                            <x-ui.badge variant="subtle" class="px-3 py-1 text-[10px] uppercase font-bold tracking-widest">Support inclus</x-ui.badge>
                            <x-ui.badge variant="subtle" class="px-3 py-1 text-[10px] uppercase font-bold tracking-widest">Paiement sécurisé</x-ui.badge>
                        </div>
                    </div>
                    <div class="flex flex-wrap justify-center gap-6">
                        @foreach($plans as $plan)
                            <div class="w-full sm:w-[calc(50%-1.5rem)] md:w-[calc(33.33%-1.5rem)] lg:w-[calc(20%-1.5rem)] min-w-[240px] max-w-[300px]">
                                <x-card.pricing-card
                                    :title="$plan->name"
                                    :price="$stripePrices[$plan->id]['price'] ?? null"
                                    :period="$stripePrices[$plan->id]['period'] ?? null"
                                    :description="$plan->description"
                                    :features="$plan->getFormattedFeatures()"
                                    :isPopular="$loop->index === 1"
                                >
                                    @php($canBuy = !empty($plan->price_stripe_id))

                                    <div class="flex flex-col gap-2">
                                        @auth
                                            @if($canBuy)
                                                <form action="{{ route('billing.choose') }}" method="POST" class="w-full">
                                                    @csrf
                                                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                                    <x-ui.button type="submit" class="w-full justify-center font-bold" variant="accent">
                                                        Choisir
                                                    </x-ui.button>
                                                </form>
                                            @else
                                                <x-ui.button href="{{ route('dashboard.index') }}" class="w-full justify-center font-bold" variant="accent">
                                                    Mon Dashboard
                                                </x-ui.button>
                                            @endif
                                        @else
                                            <x-ui.button href="{{ route('auth.register') }}" class="w-full justify-center font-bold" variant="accent">
                                                Commencer
                                            </x-ui.button>
                                        @endauth
                                    </div>
                                </x-card.pricing-card>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-16 text-center">
                        <p class="text-sm text-muted-foreground">
                            Tous nos plans payants bénéficient d'une garantie <a href="{{ route('legal.refund') }}" class="underline hover:text-primary transition">Satisfait ou Remboursé de 72h</a>.
                        </p>
                    </div>
                </div>
            </section>

            <!-- FAQ -->
            <section class="py-24 bg-[var(--secondary)]/20">
                <div class="mx-auto px-4" style="max-width: 50%;">
                    <div class="mb-12 text-center">
                        <h2 class="text-3xl font-bold tracking-tight">Questions fréquentes</h2>
                        <p class="mt-3 text-muted-foreground">Tout ce que tu dois savoir sur Eternom.</p>
                    </div>

                    <div class="grid gap-4">
                        <details class="group bg-white border card-primary rounded-[var(--radius-lg)] p-6 cursor-pointer overflow-hidden transition-all duration-300 shadow-sm hover:shadow-md">
                            <summary class="list-none font-bold text-lg flex items-center justify-between">
                                Le plan gratuit est-il vraiment gratuit ?
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5 transition-transform group-open:rotate-45">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </summary>
                            <div class="mt-4 text-muted-foreground leading-relaxed border-t pt-4 border-[var(--primary-foreground)]/10">
                                Oui, absolument. Le plan gratuit est conçu pour te permettre de tester notre infrastructure sans aucun frais caché ni limite de temps. Tu peux passer à un plan supérieur à tout moment.
                            </div>
                        </details>
                        <details class="group bg-white border card-accent rounded-[var(--radius-lg)] p-6 cursor-pointer overflow-hidden transition-all duration-300 shadow-sm hover:shadow-md">
                            <summary class="list-none font-bold text-lg flex items-center justify-between">
                                Puis-je importer mes serveurs existants ?
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5 transition-transform group-open:rotate-45">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </summary>
                            <div class="mt-4 text-muted-foreground leading-relaxed border-t pt-4 border-[var(--accent-foreground)]/10">
                                Bien sûr ! Notre interface te permet de téléverser tes fichiers via le gestionnaire de fichiers intégré ou via SFTP. Tes mondes et configurations seront prêts en quelques minutes.
                            </div>
                        </details>
                        <details class="group bg-white border card-success rounded-[var(--radius-lg)] p-6 cursor-pointer overflow-hidden transition-all duration-300 shadow-sm hover:shadow-md">
                            <summary class="list-none font-bold text-lg flex items-center justify-between">
                                Quel est le délai de mise en ligne ?
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5 transition-transform group-open:rotate-45">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </summary>
                            <div class="mt-4 text-muted-foreground leading-relaxed border-t pt-4 border-[var(--success-foreground)]/10">
                                Le déploiement est instantané. Dès que ton plan est activé, ton serveur commence à s'installer automatiquement et est prêt à l'emploi en moins de 60 secondes.
                            </div>
                        </details>
                    </div>
                </div>
            </section>

            <section class="py-24 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-t from-[var(--accent)]/10 to-transparent -z-10"></div>
                <div class="mx-auto px-4" style="max-width: 65%;">
                    <div class="bg-white border card-accent rounded-[var(--radius-xl)] p-12 md:p-20 text-center relative overflow-hidden shadow-2xl">
                        <div class="absolute top-0 right-0 -mr-20 -mt-20 size-64 bg-[var(--accent)]/20 blur-3xl rounded-full"></div>
                        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 size-64 bg-[var(--primary)]/20 blur-3xl rounded-full"></div>

                        <h2 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-6 leading-tight">
                            Prêt à lancer ton <span class="text-[var(--accent-foreground)]">aventure</span> ?
                        </h2>
                        <p class="text-lg text-muted-foreground max-w-2xl mx-auto mb-10">
                            Rejoins des centaines de joueurs qui nous font déjà confiance pour leur hébergement Minecraft.
                        </p>
                        <div class="flex flex-wrap items-center justify-center gap-4">
                            <x-ui.button href="{{ route('auth.login') }}" size="lg" class="px-12 shadow-xl shadow-[var(--accent)]/20 font-bold">Créer mon compte</x-ui.button>
                            <x-ui.button href="/contact" variant="outline" size="lg" class="px-12 font-bold bg-white/50 backdrop-blur-sm">Contactez-nous</x-ui.button>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endisset
@endsection
