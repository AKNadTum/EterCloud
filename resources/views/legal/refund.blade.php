@extends('layout')

@section('content')
<div class="py-12 bg-[var(--background)]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center size-16 rounded-2xl bg-green-50 text-green-600 mb-4 shadow-sm border border-green-100">
                <x-heroicon-o-currency-euro class="size-8" />
            </div>
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">
                Politique de Remboursement
            </h1>
            <p class="mt-4 text-lg text-gray-500">
                Nos engagements pour votre satisfaction et les conditions de retour.
            </p>
        </div>

        <div class="glass-card overflow-hidden">
            <div class="p-8 sm:p-12 space-y-12">
                <!-- 1. Droit de rétractation -->
                <section>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="size-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                            <x-heroicon-o-scale class="size-5" />
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">1. Droit de rétractation</h2>
                    </div>
                    <p class="text-gray-600 leading-relaxed pl-11">
                        Conformément à la législation européenne, vous disposez d'un délai de 14 jours pour exercer votre droit de rétractation après l'achat d'un service numérique, à condition que l'exécution du service n'ait pas commencé.
                    </p>
                </section>

                <!-- 2. Conditions Etercloud -->
                <section>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="size-8 rounded-lg bg-green-50 flex items-center justify-center text-green-600">
                            <x-heroicon-o-sparkles class="size-5" />
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">2. Garantie Satisfait ou Remboursé</h2>
                    </div>
                    <div class="pl-11 space-y-4">
                        <div class="p-6 rounded-2xl bg-green-50 border border-green-100 border-l-4">
                            <p class="text-green-800 font-bold text-lg mb-2">Période de 72 heures</p>
                            <p class="text-green-700 leading-relaxed">
                                Si vous n'êtes pas satisfait dans les 3 premiers jours suivant votre premier achat, vous pouvez demander un remboursement intégral, sans justification.
                            </p>
                        </div>
                        <p class="text-gray-600 leading-relaxed text-sm font-medium uppercase tracking-wider">Exceptions à la garantie :</p>
                        <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <li class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100 text-sm text-gray-600">
                                <x-heroicon-o-minus-circle class="size-4 text-gray-400" />
                                Renouvellements
                            </li>
                            <li class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100 text-sm text-gray-600">
                                <x-heroicon-o-minus-circle class="size-4 text-gray-400" />
                                Violation des CGU
                            </li>
                            <li class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100 text-sm text-gray-600">
                                <x-heroicon-o-minus-circle class="size-4 text-gray-400" />
                                Utilisation excessive
                            </li>
                            <li class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100 text-sm text-gray-600">
                                <x-heroicon-o-minus-circle class="size-4 text-gray-400" />
                                Services sur mesure
                            </li>
                        </ul>
                    </div>
                </section>

                <!-- 3. Processus -->
                <section>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="size-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <x-heroicon-o-ticket class="size-5" />
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">3. Processus de demande</h2>
                    </div>
                    <div class="pl-11 space-y-4">
                        <p class="text-gray-600 leading-relaxed">
                            Pour demander un remboursement, vous devez ouvrir un ticket de support via votre tableau de bord ou envoyer un email.
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <a href="mailto:eternom@icloud.com" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[var(--primary)] text-[var(--primary-foreground)] font-medium hover:bg-[var(--primary-hover)] transition-colors text-sm">
                                <x-heroicon-o-envelope class="size-4" />
                                eternom@icloud.com
                            </a>
                            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-100 text-gray-600 font-medium text-sm">
                                <x-heroicon-o-clock class="size-4" />
                                Délai : 5-10 jours ouvrables
                            </div>
                        </div>
                    </div>
                </section>

                <!-- 4. Crédits -->
                <section>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="size-8 rounded-lg bg-sky-50 flex items-center justify-center text-sky-600">
                            <x-heroicon-o-banknotes class="size-5" />
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">4. Crédits en compte</h2>
                    </div>
                    <p class="text-gray-600 leading-relaxed pl-11">
                        Dans certains cas, nous pouvons proposer un remboursement sous forme de crédits ajoutés à votre compte Etercloud pour une utilisation future.
                    </p>
                </section>
            </div>

            <div class="px-8 py-6 bg-gray-50 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-400">
                    Dernière mise à jour : {{ date('d/m/Y') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
