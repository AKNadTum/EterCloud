@extends('layout')

@section('content')
    <!-- HERO -->
    <section class="relative overflow-hidden pt-24 pb-16 md:pt-32 md:pb-24 -mt-[88px]">
        <div class="absolute inset-0 bg-gradient-to-b from-[var(--primary)]/20 to-transparent -z-10"></div>
        <div class="mx-auto px-4" style="max-width: 85%;">
            <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-12">
                <div class="space-y-8">
                    <div class="inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-[var(--primary-foreground)] bg-[var(--primary)]/50 px-3 py-1 rounded-full border border-[var(--primary-foreground)]/10">
                        <span>Hébergement Minecraft Gratuit</span>
                    </div>
                    <h1 class="text-4xl md:text-6xl font-extrabold leading-tight tracking-tight">
                        Hébergement <span class="text-[var(--accent-foreground)]">Minecraft Gratuit</span> : Performance & Simplicité
                    </h1>
                    <p class="text-base md:text-lg max-w-2xl text-muted-foreground leading-relaxed">
                        Découvrez la meilleure <strong>alternative à Aternos</strong>.
                        Un plan gratuit avec de vraies performances en phase de lancement : <strong>sans file d'attente</strong> et <strong>sans lag</strong>.
                        Crée ton serveur Minecraft gratuit avec des performances optimales dès maintenant.
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
    <section class="py-12">
        <div class="mx-auto px-4" style="max-width: 85%;">
            <div class="mb-8 text-center">
                <h2 class="text-2xl font-bold tracking-tight">Pourquoi nous ?</h2>
                <p class="mt-2 text-sm text-muted-foreground">Une expérience d'hébergement pensée pour la simplicité.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <x-card.info-card
                    variant="primary"
                    icon="heroicon-o-rocket-launch"
                    title="Pterodactyl"
                    description="Gère ton serveur avec le panel le plus puissant et intuitif du marché."
                />
                <x-card.info-card
                    variant="success"
                    icon="heroicon-o-sparkles"
                    title="Gratuit & Performant"
                    description="Une alternative à Aternos sans file d'attente."
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
    <section class="py-12 bg-[var(--secondary)]/30">
        <div class="mx-auto px-4" style="max-width: 85%;">
            <div class="mb-8 text-center text-balance">
                <h2 class="text-2xl font-bold tracking-tight">Prêt en 3 étapes</h2>
                <p class="mt-2 text-sm text-muted-foreground">Lancer ton serveur n'a jamais été aussi facile.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-[var(--control-background)] border card-primary rounded-[var(--radius-lg)] p-6 text-center transition-all duration-300 shadow-sm">
                    <div class="size-12 rounded-2xl bg-[var(--primary)] text-[var(--primary-foreground)] border border-[var(--primary-foreground)]/10 flex items-center justify-center mx-auto mb-4 text-xl font-black shadow-sm">1</div>
                    <h3 class="text-lg font-bold mb-2">Compte</h3>
                    <p class="text-xs text-muted-foreground leading-relaxed">Inscris-toi en quelques secondes, sans carte bancaire requise.</p>
                </div>
                <div class="bg-[var(--control-background)] border card-accent rounded-[var(--radius-lg)] p-6 text-center transition-all duration-300 shadow-sm">
                    <div class="size-12 rounded-2xl bg-[var(--accent)] text-[var(--accent-foreground)] border border-[var(--accent-foreground)]/10 flex items-center justify-center mx-auto mb-4 text-xl font-black shadow-sm">2</div>
                    <h3 class="text-lg font-bold mb-2">Déploiement</h3>
                    <p class="text-xs text-muted-foreground leading-relaxed">Choisis ton plan et ton serveur se configure automatiquement.</p>
                </div>
                <div class="bg-[var(--control-background)] border card-success rounded-[var(--radius-lg)] p-6 text-center transition-all duration-300 shadow-sm">
                    <div class="size-12 rounded-2xl bg-[var(--success)] text-[var(--success-foreground)] border border-[var(--success-foreground)]/10 flex items-center justify-center mx-auto mb-4 text-xl font-black shadow-sm">3</div>
                    <h3 class="text-lg font-bold mb-2">Aventure</h3>
                    <p class="text-xs text-muted-foreground leading-relaxed">Rejoins ton serveur avec tes amis et commence à bâtir ton monde.</p>
                </div>
            </div>
        </div>
    </section>

    @if(isset($plans) && $plans->count() > 0)
        <section id="plans" class="py-16 scroll-mt-24">
                <div class="mx-auto px-4" style="max-width: 90%;">
                    <div class="mb-8 text-center">
                        <h2 class="text-2xl font-bold tracking-tight">Choisis ton plan</h2>
                        <p class="mt-2 text-sm text-muted-foreground">Une tarification transparente pour tous les besoins.</p>
                        <div class="mt-4 flex flex-wrap items-center justify-center gap-2">
                            <x-ui.badge variant="subtle" class="px-2 py-0.5 text-[9px] uppercase font-bold tracking-widest">Sans engagement</x-ui.badge>
                            <x-ui.badge variant="subtle" class="px-2 py-0.5 text-[9px] uppercase font-bold tracking-widest">Support inclus</x-ui.badge>
                            <x-ui.badge variant="subtle" class="px-2 py-0.5 text-[9px] uppercase font-bold tracking-widest">Paiement sécurisé</x-ui.badge>
                        </div>
                    </div>
                    <div class="relative group">
                        <div id="plans-carousel" class="flex overflow-x-auto gap-4 no-scrollbar pt-6 pb-6 mx-auto mask-horizontal" style="max-width: 1400px;">
                            @for($r = 0; $r < 3; $r++)
                                @foreach($plans as $plan)
                                    <div class="flex-shrink-0 w-full sm:w-[calc(50%-1rem)] md:w-[calc(33.33%-1.25rem)] lg:w-[calc(25%-1.25rem)] min-w-[240px] max-w-[280px]">
                                        <x-card.pricing-card
                                            :title="$plan->name"
                                            :price="$stripePrices[$plan->id]['price'] ?? null"
                                            :period="$stripePrices[$plan->id]['period'] ?? null"
                                            :description="$plan->description"
                                            :features="$plan->getFormattedFeatures()"
                                            :isPopular="$loop->index === 1"
                                        >
                                            <div class="flex flex-col gap-2">
                                                @auth
                                                    @php $canBuy = !empty($plan->price_stripe_id); @endphp
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
                                                @endauth
                                                @guest
                                                    <x-ui.button href="{{ route('auth.register') }}" class="w-full justify-center font-bold" variant="accent">
                                                        Commencer
                                                    </x-ui.button>
                                                @endguest
                                            </div>
                                        </x-card.pricing-card>
                                    </div>
                                @endforeach

                                @php
                                    $realPlansCount = $plans->count();
                                    $customCardsToAdd = max(1, 3 - $realPlansCount);
                                @endphp

                                @for($i = 0; $i < $customCardsToAdd; $i++)
                                    <div class="flex-shrink-0 w-full sm:w-[calc(50%-1rem)] md:w-[calc(33.33%-1.25rem)] lg:w-[calc(25%-1.25rem)] min-w-[240px] max-w-[280px]">
                                        <x-card.pricing-card
                                            title="Sur mesure"
                                            price="Sur devis"
                                            description="Besoin d'une puissance supérieure ou d'une configuration spécifique ?"
                                            :features="['Ressources illimitées', 'Support prioritaire 24/7', 'Infrastructure dédiée', 'SLA garanti']"
                                            :isPopular="false"
                                        >
                                            <div class="flex flex-col gap-2">
                                                <x-ui.button href="{{ route('contact', ['reason' => 'quote_request']) }}" class="w-full justify-center font-bold" variant="outline">
                                                    Contactez-nous
                                                </x-ui.button>
                                            </div>
                                        </x-card.pricing-card>
                                    </div>
                                @endfor
                            @endfor
                        </div>

                        <button id="carousel-prev" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 lg:-translate-x-12 z-10 size-12 rounded-full bg-[var(--control-background)] border border-[var(--border)] flex items-center justify-center text-muted-foreground hover:text-primary hover:border-primary transition-all opacity-0 group-hover:opacity-100 hidden md:flex shadow-xl" aria-label="Précédent">
                            <x-heroicon-o-chevron-left class="size-6" />
                        </button>
                        <button id="carousel-next" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 lg:translate-x-12 z-10 size-12 rounded-full bg-[var(--control-background)] border border-[var(--border)] flex items-center justify-center text-muted-foreground hover:text-primary hover:border-primary transition-all opacity-0 group-hover:opacity-100 hidden md:flex shadow-xl" aria-label="Suivant">
                            <x-heroicon-o-chevron-right class="size-6" />
                        </button>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const carousel = document.getElementById('plans-carousel');
                            const prevBtn = document.getElementById('carousel-prev');
                            const nextBtn = document.getElementById('carousel-next');

                            if (!carousel || !carousel.firstElementChild) return;

                            let isPaused = false;
                            let isManual = false;
                            const speed = 0.5; // Vitesse de défilement (pixels par frame)
                            let animationId = null;

                            // Calcul des dimensions
                            const getDimensions = () => {
                                const firstItem = carousel.firstElementChild;
                                if (!firstItem) return { itemWidth: 0, totalItems: 0, setWidth: 0 };
                                const style = window.getComputedStyle(carousel);
                                const gap = parseFloat(style.gap) || 24;
                                const itemWidth = firstItem.offsetWidth + gap;
                                const totalItems = carousel.children.length / 3;
                                const setWidth = itemWidth * totalItems;
                                return { itemWidth, totalItems, setWidth };
                            };

                            let dims = getDimensions();

                            const setInitialPosition = () => {
                                dims = getDimensions();
                                if (dims.setWidth > 0) {
                                    carousel.scrollLeft = dims.setWidth;
                                }
                            };

                            // Attendre que le layout soit stabilisé
                            setTimeout(setInitialPosition, 100);

                            const animate = () => {
                                if (!isPaused && !isManual) {
                                    carousel.scrollLeft += speed;

                                    // Saut invisible pour l'infini
                                    if (carousel.scrollLeft >= dims.setWidth * 2) {
                                        carousel.scrollLeft -= dims.setWidth;
                                    } else if (carousel.scrollLeft <= 0) {
                                        carousel.scrollLeft += dims.setWidth;
                                    }
                                }
                                animationId = requestAnimationFrame(animate);
                            };

                            // Lancer l'animation
                            animationId = requestAnimationFrame(animate);

                            // Pause au survol (incluant les boutons)
                            const container = carousel.closest('.group');
                            if (container) {
                                container.addEventListener('mouseenter', () => { isPaused = true; });
                                container.addEventListener('mouseleave', () => {
                                    isPaused = false;
                                    isManual = false;
                                });
                            }

                            // Navigation manuelle
                            prevBtn.addEventListener('click', () => {
                                isManual = true;
                                carousel.scrollBy({ left: -400, behavior: 'smooth' });
                            });

                            nextBtn.addEventListener('click', () => {
                                isManual = true;
                                carousel.scrollBy({ left: 400, behavior: 'smooth' });
                            });

                            // Re-calculer au redimensionnement
                            window.addEventListener('resize', () => {
                                setInitialPosition();
                            });

                            // Gérer le repositionnement lors du scroll manuel ou interaction
                            carousel.addEventListener('scroll', () => {
                                if (isPaused || isManual) {
                                    if (carousel.scrollLeft <= 10) {
                                        carousel.scrollLeft = dims.setWidth + carousel.scrollLeft;
                                    } else if (carousel.scrollLeft >= dims.setWidth * 2 - 10) {
                                        carousel.scrollLeft = carousel.scrollLeft - dims.setWidth;
                                    }
                                }
                            });
                        });
                    </script>

                    <div class="mt-16 text-center">
                        <p class="text-sm text-muted-foreground">
                            Tous nos plans payants bénéficient d'une garantie <a href="{{ route('legal.refund') }}" class="underline hover:text-primary transition">Satisfait ou Remboursé de 72h</a>.
                        </p>
                    </div>
                </div>
            </section>

            <!-- FAQ -->
            <section class="py-16 bg-[var(--secondary)]/20">
                <div class="mx-auto px-4" style="max-width: 75%;">
                    <div class="mb-8 text-center">
                        <h2 class="text-2xl font-bold tracking-tight">Questions fréquentes</h2>
                        <p class="mt-2 text-sm text-muted-foreground">Tout ce que tu dois savoir sur Etercloud.</p>
                    </div>

                    <div class="grid gap-3">
                        <details class="group bg-[var(--control-background)] border card-primary rounded-[var(--radius-lg)] p-5 cursor-pointer overflow-hidden transition-all duration-300 shadow-sm hover:shadow-md">
                            <summary class="list-none font-bold text-base flex items-center justify-between">
                                Pourquoi choisir EterCloud comme alternative à Aternos ?
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4 transition-transform group-open:rotate-45">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </summary>
                            <div class="mt-3 text-sm text-muted-foreground leading-relaxed border-t pt-3 border-[var(--primary-foreground)]/10">
                                Contrairement à d'autres hébergeurs gratuits comme Aternos, EterCloud mise sur de vraies performances dès le plan gratuit. Nous garantissons une expérience <strong>sans file d'attente</strong> et <strong>sans lag</strong>, idéale pour jouer avec tes amis dans les meilleures conditions.
                            </div>
                        </details>
                        <details class="group bg-[var(--control-background)] border card-success rounded-[var(--radius-lg)] p-5 cursor-pointer overflow-hidden transition-all duration-300 shadow-sm hover:shadow-md">
                            <summary class="list-none font-bold text-base flex items-center justify-between">
                                Le plan gratuit est-il vraiment gratuit ?
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4 transition-transform group-open:rotate-45">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </summary>
                            <div class="mt-3 text-sm text-muted-foreground leading-relaxed border-t pt-3 border-[var(--success-foreground)]/10">
                                Oui, absolument. Le plan gratuit est conçu pour te permettre de tester notre infrastructure sans aucun frais caché ni limite de temps. Tu peux passer à un plan supérieur à tout moment.
                            </div>
                        </details>
                        <details class="group bg-[var(--control-background)] border card-accent rounded-[var(--radius-lg)] p-5 cursor-pointer overflow-hidden transition-all duration-300 shadow-sm hover:shadow-md">
                            <summary class="list-none font-bold text-base flex items-center justify-between">
                                Puis-je importer mes serveurs existants ?
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4 transition-transform group-open:rotate-45">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </summary>
                            <div class="mt-3 text-sm text-muted-foreground leading-relaxed border-t pt-3 border-[var(--accent-foreground)]/10">
                                Bien sûr ! Notre interface te permet de téléverser tes fichiers via le gestionnaire de fichiers intégré ou via SFTP. Tes mondes et configurations seront prêts en quelques minutes.
                            </div>
                        </details>
                        <details class="group bg-[var(--control-background)] border card-success rounded-[var(--radius-lg)] p-5 cursor-pointer overflow-hidden transition-all duration-300 shadow-sm hover:shadow-md">
                            <summary class="list-none font-bold text-base flex items-center justify-between">
                                Quel est le délai de mise en ligne ?
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4 transition-transform group-open:rotate-45">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </summary>
                            <div class="mt-3 text-sm text-muted-foreground leading-relaxed border-t pt-3 border-[var(--success-foreground)]/10">
                                Une fois qu'on déploie un serveur, celui-ci est en ligne en quelques secondes.
                            </div>
                        </details>
                    </div>
                </div>
            </section>

            <section class="py-16 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-t from-[var(--accent)]/10 to-transparent -z-10"></div>
                <div class="mx-auto px-4" style="max-width: 85%;">
                    <div class="bg-[var(--control-background)] border card-accent rounded-[var(--radius-xl)] p-10 md:p-16 text-center relative overflow-hidden shadow-2xl">
                        <div class="absolute top-0 right-0 -mr-20 -mt-20 size-64 bg-[var(--accent)]/20 blur-3xl rounded-full"></div>
                        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 size-64 bg-[var(--primary)]/20 blur-3xl rounded-full"></div>

                        <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-4 leading-tight">
                            Prêt à lancer ton <span class="text-[var(--accent-foreground)]">aventure</span> ?
                        </h2>
                        <p class="text-base text-muted-foreground max-w-2xl mx-auto mb-8">
                            Rejoins des centaines de joueurs qui nous font déjà confiance pour leur hébergement Minecraft.
                        </p>
                        <div class="flex flex-wrap items-center justify-center gap-3">
                            <x-ui.button href="{{ route('auth.login') }}" size="default" class="px-8 shadow-xl shadow-[var(--accent)]/20 font-bold">Créer mon compte</x-ui.button>
                            <x-ui.button href="/contact" variant="outline" size="default" class="px-8 font-bold bg-[var(--control-background)]/50 backdrop-blur-sm">Contactez-nous</x-ui.button>
                        </div>
                    </div>
                </div>
            </section>
    @endif
@endsection
