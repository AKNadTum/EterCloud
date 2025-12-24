@extends('layout')

@section('content')
<div class="pt-24 pb-12 bg-[var(--background)]">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center size-16 rounded-2xl bg-[var(--primary)] text-[var(--primary-foreground)] mb-4 shadow-sm">
                <x-heroicon-o-scale class="size-8" />
            </div>
            <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl">
                Mentions Légales
            </h1>
            <p class="mt-4 text-lg text-muted-foreground">
                Informations obligatoires concernant l'éditeur et l'hébergeur du site.
            </p>
        </div>

        <div class="grid gap-8">
            <!-- 1. Éditeur du site -->
            <div class="glass-card p-8">
                <div class="flex items-start gap-4">
                    <div class="shrink-0 size-10 rounded-xl bg-[var(--primary)]/20 flex items-center justify-center text-[var(--primary-foreground)]">
                        <x-heroicon-o-building-office class="size-6" />
                    </div>
                    <div>
                        <h2 class="text-xl font-bold mb-3">1. Éditeur du site</h2>
                        <p class="text-muted-foreground leading-relaxed">
                            Le site <strong>Etercloud</strong> est édité par la société <strong>Eternom</strong>,
                            dont le siège social est situé rue de l'Ardoise, Houyet, Belgique.
                        </p>
                    </div>
                </div>
            </div>

            <!-- 2. Directeur de la publication -->
            <div class="glass-card p-8">
                <div class="flex items-start gap-4">
                    <div class="shrink-0 size-10 rounded-xl bg-purple-500/10 flex items-center justify-center text-purple-400">
                        <x-heroicon-o-user-circle class="size-6" />
                    </div>
                    <div>
                        <h2 class="text-xl font-bold mb-3">2. Directeur de la publication</h2>
                        <p class="text-muted-foreground leading-relaxed">
                            Le Directeur de la publication est <strong>Alexandre Ernotte</strong>.
                        </p>
                    </div>
                </div>
            </div>

            <!-- 3. Hébergement -->
            <div class="glass-card p-8">
                <div class="flex items-start gap-4">
                    <div class="shrink-0 size-10 rounded-xl bg-sky-500/10 flex items-center justify-center text-sky-400">
                        <x-heroicon-o-cloud class="size-6" />
                    </div>
                    <div>
                        <h2 class="text-xl font-bold mb-3">3. Hébergement</h2>
                        <p class="text-muted-foreground leading-relaxed">
                            Le site est hébergé par la société <strong>Laravel Cloud</strong>.
                        </p>
                    </div>
                </div>
            </div>

            <!-- 4. Propriété intellectuelle -->
            <div class="glass-card p-8">
                <div class="flex items-start gap-4">
                    <div class="shrink-0 size-10 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-400">
                        <x-heroicon-o-shield-check class="size-6" />
                    </div>
                    <div>
                        <h2 class="text-xl font-bold mb-3">4. Propriété intellectuelle</h2>
                        <p class="text-muted-foreground leading-relaxed">
                            L'ensemble du contenu de ce site (textes, images, logos, icônes) est la propriété exclusive de
                            <strong>Eternom</strong> ou de ses partenaires. Toute reproduction, représentation, modification ou
                            adaptation de tout ou partie du site est strictement interdite sans autorisation écrite préalable.
                        </p>
                    </div>
                </div>
            </div>

            <!-- 5. Contact -->
            <div class="glass-card p-8">
                <div class="flex items-start gap-4">
                    <div class="shrink-0 size-10 rounded-xl bg-[var(--primary)]/20 flex items-center justify-center text-[var(--primary-foreground)]">
                        <x-heroicon-o-envelope class="size-6" />
                    </div>
                    <div>
                        <h2 class="text-xl font-bold mb-3">5. Contact</h2>
                        <p class="text-muted-foreground leading-relaxed mb-4">
                            Pour toute question ou réclamation, vous pouvez nous contacter :
                        </p>
                        <a href="mailto:eternom@icloud.com" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[var(--primary)] text-[var(--primary-foreground)] font-medium hover:bg-[var(--primary-hover)] transition-colors">
                            <x-heroicon-o-envelope class="size-4" />
                            eternom@icloud.com
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-12 text-center">
            <p class="text-sm text-muted-foreground/60">
                Dernière mise à jour : {{ date('d/m/Y') }}
            </p>
        </div>
    </div>
</div>
@endsection








