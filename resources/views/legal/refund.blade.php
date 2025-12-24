@extends('layout')

@section('content')
<div class="py-12 bg-[var(--background)]">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center size-16 rounded-2xl bg-green-500/10 text-green-400 mb-4 shadow-sm border border-green-500/20">
                <x-heroicon-o-currency-euro class="size-8" />
            </div>
            <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl">
                Politique de Remboursement
            </h1>
            <p class="mt-4 text-lg text-muted-foreground">
                Nos engagements pour votre satisfaction et les conditions de retour.
            </p>
        </div>

        <div class="glass-card overflow-hidden">
            <div class="p-8 sm:p-12 space-y-12">
                <!-- 1. Droit de rétractation -->
                <section>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="size-8 rounded-lg bg-[var(--primary)]/20 flex items-center justify-center text-[var(--primary-foreground)]">
                            <x-heroicon-o-scale class="size-5" />
                        </div>
                        <h2 class="text-2xl font-bold">1. Droit de rétractation</h2>
                    </div>
                    <p class="text-muted-foreground leading-relaxed pl-11">
                        Conformément à la législation européenne, vous disposez d'un délai de 14 jours pour exercer votre droit de rétractation après l'achat d'un service numérique, à condition que l'exécution du service n'ait pas commencé.
                    </p>
                </section>

                <!-- 2. Conditions Etercloud -->
                <section>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="size-8 rounded-lg bg-green-500/10 flex items-center justify-center text-green-400">
                            <x-heroicon-o-sparkles class="size-5" />
                        </div>
                        <h2 class="text-2xl font-bold">2. Garantie Satisfait ou Remboursé</h2>
                    </div>
                    <div class="pl-11 space-y-4">
                        <div class="p-6 rounded-2xl bg-green-500/10 border border-green-500/20 border-l-4">
                            <p class="text-green-400 font-bold text-lg mb-2">Période de 72 heures</p>
                            <p class="text-green-400/80 leading-relaxed">
                                Si vous n'êtes pas satisfait dans les 3 premiers jours suivant votre premier achat, vous pouvez demander un remboursement intégral, sans justification.
                            </p>
                        </div>
                        <p class="text-muted-foreground leading-relaxed text-sm font-medium uppercase tracking-wider">Exceptions à la garantie :</p>
                        <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <li class="flex items-center gap-3 p-3 rounded-xl bg-[var(--secondary)]/20 border border-[var(--border)] text-sm text-muted-foreground">
                                <x-heroicon-o-minus-circle class="size-4 opacity-50" />
                                Renouvellements
                            </li>
                            <li class="flex items-center gap-3 p-3 rounded-xl bg-[var(--secondary)]/20 border border-[var(--border)] text-sm text-muted-foreground">
                                <x-heroicon-o-minus-circle class="size-4 opacity-50" />
                                Violation des CGU
                            </li>
                            <li class="flex items-center gap-3 p-3 rounded-xl bg-[var(--secondary)]/20 border border-[var(--border)] text-sm text-muted-foreground">
                                <x-heroicon-o-minus-circle class="size-4 opacity-50" />
                                Utilisation excessive
                            </li>
                            <li class="flex items-center gap-3 p-3 rounded-xl bg-[var(--secondary)]/20 border border-[var(--border)] text-sm text-muted-foreground">
                                <x-heroicon-o-minus-circle class="size-4 opacity-50" />
                                Services sur mesure
                            </li>
                        </ul>
                    </div>
                </section>

                <!-- 3. Processus -->
                <section>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="size-8 rounded-lg bg-indigo-500/10 flex items-center justify-center text-indigo-400">
                            <x-heroicon-o-ticket class="size-5" />
                        </div>
                        <h2 class="text-2xl font-bold">3. Processus de demande</h2>
                    </div>
                    <div class="pl-11 space-y-4">
                        <p class="text-muted-foreground leading-relaxed">
                            Pour demander un remboursement, vous devez ouvrir un ticket de support via votre tableau de bord ou envoyer un email.
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <a href="mailto:eternom@icloud.com" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[var(--primary)] text-[var(--primary-foreground)] font-medium hover:bg-[var(--primary-hover)] transition-colors text-sm">
                                <x-heroicon-o-envelope class="size-4" />
                                eternom@icloud.com
                            </a>
                            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[var(--secondary)]/50 text-muted-foreground font-medium text-sm border border-[var(--border)]">
                                <x-heroicon-o-clock class="size-4" />
                                Délai : 5-10 jours ouvrables
                            </div>
                        </div>
                    </div>
                </section>

                <!-- 4. Crédits -->
                <section>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="size-8 rounded-lg bg-sky-500/10 flex items-center justify-center text-sky-400">
                            <x-heroicon-o-banknotes class="size-5" />
                        </div>
                        <h2 class="text-2xl font-bold">4. Crédits en compte</h2>
                    </div>
                    <p class="text-muted-foreground leading-relaxed pl-11">
                        Dans certains cas, nous pouvons proposer un remboursement sous forme de crédits ajoutés à votre compte Etercloud pour une utilisation future.
                    </p>
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




