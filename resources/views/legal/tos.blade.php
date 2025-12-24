@extends('layout')

@section('content')
<div class="py-12 bg-[var(--background)]">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center size-16 rounded-2xl bg-amber-500/10 text-amber-400 mb-4 shadow-sm border border-amber-500/20">
                <x-heroicon-o-document-text class="size-8" />
            </div>
            <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl">
                Conditions Générales d'Utilisation
            </h1>
            <p class="mt-4 text-lg text-muted-foreground">
                Les règles et engagements pour l'utilisation de nos services.
            </p>
        </div>

        <div class="glass-card overflow-hidden">
            <div class="p-8 sm:p-12 space-y-12">
                <!-- 1. Acceptation -->
                <section>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="size-8 rounded-lg bg-amber-500/10 flex items-center justify-center text-amber-400">
                            <x-heroicon-o-check-badge class="size-5" />
                        </div>
                        <h2 class="text-2xl font-bold">1. Acceptation des conditions</h2>
                    </div>
                    <p class="text-muted-foreground leading-relaxed pl-11">
                        L'utilisation des services d'Etercloud implique l'acceptation pleine et entière des présentes conditions générales d'utilisation. Si vous n'acceptez pas ces conditions, vous ne devez pas utiliser nos services.
                    </p>
                </section>

                <!-- 2. Création de compte -->
                <section>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="size-8 rounded-lg bg-[var(--primary)]/20 flex items-center justify-center text-[var(--primary-foreground)]">
                            <x-heroicon-o-user-plus class="size-5" />
                        </div>
                        <h2 class="text-2xl font-bold">2. Création de compte</h2>
                    </div>
                    <p class="text-muted-foreground leading-relaxed pl-11">
                        Pour utiliser nos services, vous devez créer un compte. Vous êtes responsable de la confidentialité de vos identifiants et de toutes les activités effectuées sous votre compte.
                    </p>
                </section>

                <!-- 3. Services et Paiements -->
                <section>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="size-8 rounded-lg bg-green-500/10 flex items-center justify-center text-green-400">
                            <x-heroicon-o-credit-card class="size-5" />
                        </div>
                        <h2 class="text-2xl font-bold">3. Services et Paiements</h2>
                    </div>
                    <p class="text-muted-foreground leading-relaxed pl-11">
                        Etercloud fournit des services d'hébergement sous forme d'abonnements ou de crédits. Les tarifs sont indiqués sur notre site. Le paiement est dû au début de chaque période.
                    </p>
                </section>

                <!-- 4. Utilisation acceptable -->
                <section>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="size-8 rounded-lg bg-red-500/10 flex items-center justify-center text-red-400">
                            <x-heroicon-o-no-symbol class="size-5" />
                        </div>
                        <h2 class="text-2xl font-bold">4. Utilisation acceptable</h2>
                    </div>
                    <div class="pl-11 space-y-4">
                        <p class="text-sm font-medium uppercase tracking-wider text-red-400">Activités strictement interdites :</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="flex items-center gap-3 p-3 rounded-xl bg-red-500/5 border border-red-500/10 text-sm text-muted-foreground">
                                <x-heroicon-o-x-mark class="size-4 text-red-400" />
                                Activités illégales
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-xl bg-red-500/5 border border-red-500/10 text-sm text-muted-foreground">
                                <x-heroicon-o-x-mark class="size-4 text-red-400" />
                                Envoi de SPAM
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-xl bg-red-500/5 border border-red-500/10 text-sm text-muted-foreground">
                                <x-heroicon-o-x-mark class="size-4 text-red-400" />
                                Attaques DDoS
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-xl bg-red-500/5 border border-red-500/10 text-sm text-muted-foreground">
                                <x-heroicon-o-x-mark class="size-4 text-red-400" />
                                Minage non autorisé
                            </div>
                        </div>
                        <p class="text-sm text-muted-foreground/60 italic mt-2">Tout manquement entraînera la résiliation immédiate du compte sans remboursement.</p>
                    </div>
                </section>

                <!-- 5. Responsabilité -->
                <section>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="size-8 rounded-lg bg-sky-500/10 flex items-center justify-center text-sky-400">
                            <x-heroicon-o-shield-exclamation class="size-5" />
                        </div>
                        <h2 class="text-2xl font-bold">5. Responsabilité et Garantie</h2>
                    </div>
                    <p class="text-muted-foreground leading-relaxed pl-11">
                        Etercloud s'efforce de maintenir une disponibilité maximale. Cependant, nous ne pouvons garantir une absence totale d'interruptions. Il appartient à l'utilisateur d'effectuer ses propres sauvegardes.
                    </p>
                </section>

                <!-- 6. Modification -->
                <section>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="size-8 rounded-lg bg-purple-500/10 flex items-center justify-center text-purple-400">
                            <x-heroicon-o-arrow-path class="size-5" />
                        </div>
                        <h2 class="text-2xl font-bold">6. Modification des conditions</h2>
                    </div>
                    <div class="pl-11">
                        <div class="p-6 rounded-2xl bg-amber-500/5 border border-amber-500/10">
                            <p class="text-amber-400 font-bold mb-3 flex items-center gap-2">
                                <x-heroicon-o-bell class="size-5" />
                                Modalités de notification :
                            </p>
                            <ul class="space-y-3 text-sm text-muted-foreground">
                                <li class="flex items-start gap-2">
                                    <span class="font-bold text-amber-400">•</span>
                                    <span>Notification au moins <strong>30 jours</strong> avant l'entrée en vigueur.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="font-bold text-amber-400">•</span>
                                    <span>Par e-mail ou via le tableau de bord.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>
            </div>

            <div class="px-8 py-6 bg-[var(--secondary)]/20 border-t border-[var(--border)] text-center">
                <p class="text-sm text-muted-foreground/60">
                    Dernière mise à jour : {{ date('d/m/Y') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection




