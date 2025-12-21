@extends('layout')

@section('content')
<div class="py-12 bg-[var(--background)]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center size-16 rounded-2xl bg-indigo-50 text-indigo-600 mb-4 shadow-sm border border-indigo-100">
                <x-heroicon-o-lock-closed class="size-8" />
            </div>
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">
                Politique de Confidentialité
            </h1>
            <p class="mt-4 text-lg text-gray-500">
                Comment nous protégeons et gérons vos données personnelles.
            </p>
        </div>

        <div class="glass-card overflow-hidden">
            <div class="p-8 sm:p-12 space-y-12">
                <!-- 1. Introduction -->
                <section>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="size-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <x-heroicon-o-information-circle class="size-5" />
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">1. Introduction</h2>
                    </div>
                    <p class="text-gray-600 leading-relaxed pl-11">
                        Etercloud s'engage à protéger la vie privée de ses utilisateurs. Cette politique explique comment nous collectons, utilisons et protégeons vos données personnelles dans le cadre de nos services d'hébergement.
                    </p>
                </section>

                <!-- 2. Données collectées -->
                <section>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="size-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                            <x-heroicon-o-document-magnifying-glass class="size-5" />
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">2. Données collectées</h2>
                    </div>
                    <div class="pl-11 space-y-4">
                        <p class="text-gray-600 leading-relaxed">Nous collectons les données suivantes :</p>
                        <ul class="space-y-3">
                            <li class="flex gap-3 text-gray-600">
                                <x-heroicon-o-check-circle class="size-5 text-green-500 shrink-0 mt-0.5" />
                                <span><strong>Informations d'identification :</strong> Nom, adresse e-mail, adresse IP.</span>
                            </li>
                            <li class="flex gap-3 text-gray-600">
                                <x-heroicon-o-check-circle class="size-5 text-green-500 shrink-0 mt-0.5" />
                                <span><strong>Informations de paiement :</strong> Gérées de manière sécurisée par notre partenaire <strong>Stripe</strong>. Nous ne stockons pas vos numéros de carte bancaire.</span>
                            </li>
                            <li class="flex gap-3 text-gray-600">
                                <x-heroicon-o-check-circle class="size-5 text-green-500 shrink-0 mt-0.5" />
                                <span><strong>Données de service :</strong> Logs de connexion, configurations de serveurs nécessaires au bon fonctionnement technique.</span>
                            </li>
                        </ul>
                    </div>
                </section>

                <!-- 3. Utilisation des données -->
                <section>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="size-8 rounded-lg bg-green-50 flex items-center justify-center text-green-600">
                            <x-heroicon-o-cpu-chip class="size-5" />
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">3. Utilisation des données</h2>
                    </div>
                    <div class="pl-11 space-y-4">
                        <p class="text-gray-600 leading-relaxed">Vos données sont utilisées exclusivement pour :</p>
                        <ul class="grid sm:grid-cols-2 gap-3">
                            <li class="p-3 rounded-xl bg-gray-50 border border-gray-100 text-sm text-gray-600">Fournir et gérer vos services d'hébergement.</li>
                            <li class="p-3 rounded-xl bg-gray-50 border border-gray-100 text-sm text-gray-600">Traiter vos paiements et la facturation.</li>
                            <li class="p-3 rounded-xl bg-gray-50 border border-gray-100 text-sm text-gray-600">Vous informer sur l'état de vos services.</li>
                            <li class="p-3 rounded-xl bg-gray-50 border border-gray-100 text-sm text-gray-600">Améliorer la sécurité de notre plateforme.</li>
                        </ul>
                    </div>
                </section>

                <!-- 4. Partage des données -->
                <section>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="size-8 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600">
                            <x-heroicon-o-share class="size-5" />
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">4. Partage des données</h2>
                    </div>
                    <p class="text-gray-600 leading-relaxed pl-11">
                        Etercloud ne vend jamais vos données personnelles. Nous partageons vos informations uniquement avec des tiers de confiance nécessaires à l'exécution de nos services (Stripe, Fournisseurs d'infrastructure).
                    </p>
                </section>

                <!-- 5. Vos droits (RGPD) -->
                <section>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="size-8 rounded-lg bg-purple-50 flex items-center justify-center text-purple-600">
                            <x-heroicon-o-user-circle class="size-5" />
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">5. Vos droits (RGPD)</h2>
                    </div>
                    <p class="text-gray-600 leading-relaxed pl-11">
                        Conformément au RGPD, vous disposez d'un droit d'accès, de rectification, de suppression et de portabilité de vos données. Vous pouvez exercer ces droits depuis votre tableau de bord ou en nous contactant directement par email.
                    </p>
                </section>

                <!-- 6. Modification de la politique -->
                <section>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="size-8 rounded-lg bg-sky-50 flex items-center justify-center text-sky-600">
                            <x-heroicon-o-pencil-square class="size-5" />
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">6. Modification de la politique</h2>
                    </div>
                    <div class="pl-11">
                        <div class="p-6 rounded-2xl bg-[var(--primary)]/10 border border-[var(--primary)]/20">
                            <p class="text-[var(--primary-foreground)] font-medium mb-3 flex items-center gap-2">
                                <x-heroicon-o-bell class="size-5" />
                                Modalités de notification :
                            </p>
                            <ul class="space-y-2 text-sm text-gray-600">
                                <li class="flex items-center gap-2">
                                    <div class="size-1.5 rounded-full bg-[var(--primary-foreground)]"></div>
                                    Par courrier électronique.
                                </li>
                                <li class="flex items-center gap-2">
                                    <div class="size-1.5 rounded-full bg-[var(--primary-foreground)]"></div>
                                    Via une notification sur le tableau de bord.
                                </li>
                            </ul>
                        </div>
                    </div>
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
