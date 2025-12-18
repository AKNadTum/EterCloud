@extends('layout')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-slate max-w-none">
            <h1 class="text-3xl font-bold mb-8">Conditions Générales d'Utilisation</h1>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4 text-[var(--primary-foreground)]">1. Acceptation des conditions</h2>
                <p>L'utilisation des services d'Eternom implique l'acceptation pleine et entière des présentes conditions générales d'utilisation. Si vous n'acceptez pas ces conditions, vous ne devez pas utiliser nos services.</p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4 text-[var(--primary-foreground)]">2. Création de compte</h2>
                <p>Pour utiliser nos services, vous devez créer un compte. Vous êtes responsable de la confidentialité de vos identifiants et de toutes les activités effectuées sous votre compte. Vous devez nous informer immédiatement de toute utilisation non autorisée de votre compte.</p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4 text-[var(--primary-foreground)]">3. Services et Paiements</h2>
                <p>Eternom fournit des services d'hébergement sous forme d'abonnements ou de crédits. Les tarifs sont indiqués sur notre site. Le paiement est dû au début de chaque période. En cas de défaut de paiement, nous nous réservons le droit de suspendre ou de résilier vos services.</p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4 text-[var(--primary-foreground)]">4. Utilisation acceptable</h2>
                <p>Il est strictement interdit d'utiliser nos serveurs pour :</p>
                <ul class="list-disc pl-5">
                    <li>Des activités illégales (hacking, phishing, distribution de contenus illégaux).</li>
                    <li>L'envoi de SPAM ou de courriels non sollicités.</li>
                    <li>Des attaques par déni de service (DDoS).</li>
                    <li>Le minage de cryptomonnaies (sauf autorisation explicite sur certains plans).</li>
                </ul>
                <p>Tout manquement à ces règles entraînera la résiliation immédiate du compte sans remboursement.</p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4 text-[var(--primary-foreground)]">5. Responsabilité et Garantie</h2>
                <p>Eternom s'efforce de maintenir une disponibilité maximale de ses services. Cependant, nous ne pouvons garantir une absence totale d'interruptions. Eternom ne pourra être tenu responsable des pertes de données ou des pertes de revenus liées à l'utilisation de nos services. Il appartient à l'utilisateur d'effectuer ses propres sauvegardes.</p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4 text-[var(--primary-foreground)]">6. Modification des conditions</h2>
                <p>Eternom se réserve le droit de modifier les présentes Conditions Générales d'Utilisation à tout moment afin de s'adapter aux évolutions législatives, réglementaires ou techniques de la plateforme.</p>
                <div class="mt-4 p-4 rounded-lg bg-slate-50 border-l-4 border-[var(--primary)]">
                    <p class="font-medium mb-2">Modalités de notification :</p>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Les utilisateurs seront informés de toute modification substantielle au moins <strong>30 jours</strong> avant leur entrée en vigueur.</li>
                        <li>La notification sera effectuée par courrier électronique à l'adresse renseignée lors de l'inscription ou via une alerte sur le tableau de bord.</li>
                        <li>Toute utilisation du service après l'entrée en vigueur des modifications vaut acceptation des nouvelles conditions.</li>
                    </ul>
                </div>
                <p class="mt-4 italic text-sm text-gray-600">En cas de désaccord avec les modifications apportées, vous disposez du droit de résilier votre compte ou vos services sans pénalité avant la date d'entrée en vigueur des nouvelles conditions.</p>
            </section>

            <p class="text-sm text-gray-500 mt-12 pt-6 border-t">Dernière mise à jour : {{ date('d/m/Y') }}</p>
        </div>
    </div>
</div>
@endsection
