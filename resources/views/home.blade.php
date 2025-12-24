@extends('layout')

@section('content')
    <!-- HERO -->
    <section class="relative overflow-hidden pt-20 pb-12 md:pt-32 md:pb-24 -mt-[88px]">
        <div class="absolute inset-0 bg-gradient-to-b from-[var(--primary)]/20 to-transparent -z-10"></div>
        <x-layout.container>
            <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-12">
                <div class="space-y-8 text-center md:text-left">
                    <div class="inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-[var(--primary-foreground)] bg-[var(--primary)]/50 px-3 py-1 rounded-full border border-[var(--primary-foreground)]/10">
                        <span>Hébergement Minecraft Gratuit</span>
                    </div>
                    <h1 class="text-4xl md:text-6xl font-extrabold leading-tight tracking-tight">
                        Hébergement <span class="text-[var(--accent-foreground)]">Minecraft Gratuit</span> : Performance & Simplicité
                    </h1>
                    <p class="text-base md:text-lg max-w-2xl mx-auto md:mx-0 text-muted-foreground leading-relaxed">
                        Découvrez la meilleure <strong>alternative à Aternos</strong>.
                        Un plan gratuit avec de vraies performances en phase de lancement : <strong>sans file d'attente</strong> et <strong>sans lag</strong>.
                        Crée ton serveur Minecraft gratuit avec des performances optimales dès maintenant.
                    </p>
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-4">
                        <x-ui.button href="{{ route('auth.login') }}" size="lg" class="w-full sm:w-auto shadow-lg shadow-[var(--primary)]/20 px-10">Commencer</x-ui.button>
                        <x-ui.button href="{{ route('home') }}#plans" variant="outline" size="lg" class="w-full sm:w-auto px-8">Voir les plans</x-ui.button>
                    </div>

                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-6 pt-4 text-xs font-medium text-muted-foreground/80">
                        <div class="flex items-center gap-2">
                            <x-heroicon-o-bolt class="size-4 text-[var(--success-foreground)]" />
                            <span>Instantanné</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-heroicon-o-cpu-chip class="size-4 text-[var(--accent-foreground)]" />
                            <span>Pterodactyl</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-heroicon-o-gift class="size-4 text-[var(--primary-foreground)]" />
                            <span>Plan gratuit</span>
                        </div>
                    </div>
                </div>
                <div class="relative mt-8 md:mt-0">
                    <div class="absolute -inset-4 bg-[var(--accent)]/20 blur-3xl rounded-full -z-10 animate-pulse"></div>
                    <div class="glass-card p-2 rounded-[var(--radius-xl)] rotate-1 hover:rotate-0 transition-transform duration-500 overflow-hidden max-w-md mx-auto md:max-w-none">
                        <img
                            src="/images/hero_image.png"
                            alt="Aperçu du panneau"
                            loading="lazy"
                            class="w-full h-auto object-cover rounded-[var(--radius-lg)]"
                        />
                    </div>
                </div>
            </div>
        </x-layout.container>
    </section>

    <!-- POURQUOI NOUS -->
    <x-ui.section title="Pourquoi nous ?" subtitle="Une expérience d'hébergement pensée pour la simplicité.">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($features as $feature)
                <x-cards.info-card
                    :variant="$feature['variant']"
                    :icon="$feature['icon']"
                    :title="$feature['title']"
                    :description="$feature['description']"
                />
            @endforeach
        </div>
    </x-ui.section>

    <!-- COMMENT ÇA MARCHE -->
    <x-ui.section class="bg-[var(--secondary)]/30" title="Prêt en 3 étapes" subtitle="Lancer ton serveur n'a jamais été aussi facile.">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($steps as $step)
                <x-ui.step-card
                    :step="$step['step']"
                    :title="$step['title']"
                    :description="$step['description']"
                    :variant="$step['variant']"
                />
            @endforeach
        </div>
    </x-ui.section>

    @if(isset($plans) && $plans->count() > 0)
        <x-ui.section id="plans" class="scroll-mt-24" title="Choisis ton plan" subtitle="Une tarification transparente pour tous les besoins." containerClass="container-custom">
            <div class="flex flex-wrap items-center justify-center gap-2 mb-8 -mt-4">
                <x-ui.badge variant="subtle" class="px-2 py-0.5 text-[9px] uppercase font-bold tracking-widest">Sans engagement</x-ui.badge>
                <x-ui.badge variant="subtle" class="px-2 py-0.5 text-[9px] uppercase font-bold tracking-widest">Support inclus</x-ui.badge>
                <x-ui.badge variant="subtle" class="px-2 py-0.5 text-[9px] uppercase font-bold tracking-widest">Paiement sécurisé</x-ui.badge>
            </div>

            <x-features.plan-carousel :plans="$plans" :stripe-prices="$stripePrices" />

            <div class="mt-8 text-center">
                <p class="text-sm text-muted-foreground">
                    Tous nos plans payants bénéficient d'une garantie <a href="{{ route('legal.refund') }}" class="underline hover:text-primary transition">Satisfait ou Remboursé de 72h</a>.
                </p>
            </div>
        </x-ui.section>

        <!-- FAQ -->
        <x-ui.section class="bg-[var(--secondary)]/20" title="Questions fréquentes" subtitle="Tout ce que tu dois savoir sur Etercloud." containerClass="max-w-[75%]">
            <x-ui.accordion :items="$faqItems" />
        </x-ui.section>

        <x-layout.cta-block
            title='Prêt à lancer ton <span class="text-[var(--accent-foreground)]">aventure</span> ?'
            subtitle="Rejoins des centaines de joueurs qui nous font déjà confiance pour leur hébergement Minecraft."
            buttonText="Créer mon compte"
            :buttonHref="route('auth.login')"
            secondaryButtonText="Contactez-nous"
            secondaryButtonHref="/contact"
        />
    @endif
@endsection








