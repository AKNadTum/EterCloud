@extends('layout')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-slate max-w-none">
            <h1 class="text-3xl font-bold mb-8">Politique de Confidentialité</h1>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4 text-[var(--primary-foreground)]">1. Introduction</h2>
                <p>Etercloud s'engage à protéger la vie privée de ses utilisateurs. Cette politique explique comment nous collectons, utilisons et protégeons vos données personnelles dans le cadre de nos services d'hébergement.</p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4 text-[var(--primary-foreground)]">2. Données collectées</h2>
                <p>Nous collectons les données suivantes :</p>
                <ul class="list-disc pl-5">
                    <li><strong>Informations d'identification :</strong> Nom, adresse e-mail, adresse IP.</li>
                    <li><strong>Informations de paiement :</strong> Gérées de manière sécurisée par notre partenaire <strong>Stripe</strong>. Nous ne stockons pas vos numéros de carte bancaire.</li>
                    <li><strong>Données de service :</strong> Logs de connexion, configurations de serveurs nécessaires au bon fonctionnement technique.</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4 text-[var(--primary-foreground)]">3. Utilisation des données</h2>
                <p>Vos données sont utilisées exclusivement pour :</p>
                <ul class="list-disc pl-5">
                    <li>Fournir et gérer vos services d'hébergement.</li>
                    <li>Traiter vos paiements et la facturation.</li>
                    <li>Vous informer sur l'état de vos services ou les mises à jour importantes.</li>
                    <li>Améliorer la sécurité de notre plateforme.</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4 text-[var(--primary-foreground)]">4. Partage des données</h2>
                <p>Etercloud ne vend jamais vos données personnelles. Nous partageons vos informations uniquement avec des tiers de confiance nécessaires à l'exécution de nos services :</p>
                <ul class="list-disc pl-5">
                    <li><strong>Stripe :</strong> Pour le traitement sécurisé des paiements.</li>
                    <li><strong>Fournisseurs d'infrastructure :</strong> Pour le provisionnement de vos serveurs.</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4 text-[var(--primary-foreground)]">5. Vos droits (RGPD)</h2>
                <p>Conformément au RGPD, vous disposez d'un droit d'accès, de rectification, de suppression et de portabilité de vos données. Vous pouvez exercer ces droits depuis votre tableau de bord ou en nous contactant directement par email.</p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4 text-[var(--primary-foreground)]">6. Modification de la politique</h2>
                <p>Nous pouvons mettre à jour cette politique de confidentialité pour refléter les changements dans nos pratiques de données ou pour répondre à de nouvelles exigences légales.</p>
                <div class="mt-4 p-4 rounded-lg bg-slate-50 border-l-4 border-[var(--primary)] text-sm">
                    <p>En cas de modification importante, nous vous en informerons :</p>
                    <ul class="list-disc pl-5 mt-2 space-y-1">
                        <li>Par courrier électronique (à l'adresse associée à votre compte).</li>
                        <li>Via une notification visible sur le tableau de bord de la plateforme.</li>
                    </ul>
                </div>
            </section>

            <p class="text-sm text-gray-500 mt-12 pt-6 border-t">Dernière mise à jour : {{ date('d/m/Y') }}</p>
        </div>
    </div>
</div>
@endsection
