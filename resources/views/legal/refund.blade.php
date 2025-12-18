@extends('layout')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-slate max-w-none">
            <h1 class="text-3xl font-bold mb-8">Politique de Remboursement</h1>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4 text-[var(--primary-foreground)]">1. Droit de rétractation</h2>
                <p>Conformément à la législation européenne, vous disposez d'un délai de 14 jours pour exercer votre droit de rétractation après l'achat d'un service numérique, à condition que l'exécution du service n'ait pas commencé.</p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4 text-[var(--primary-foreground)]">2. Conditions de remboursement Etercloud</h2>
                <p>Chez Etercloud, nous offrons une garantie "Satisfait ou Remboursé" de <strong>72 heures</strong>. Si vous n'êtes pas satisfait de nos services dans les 3 premiers jours suivant votre premier achat, vous pouvez demander un remboursement intégral, sans justification.</p>
                <p>Cette garantie ne s'applique pas dans les cas suivants :</p>
                <ul class="list-disc pl-5">
                    <li>Renouvellements d'abonnement.</li>
                    <li>Violation de nos Conditions Générales d'Utilisation.</li>
                    <li>Utilisation excessive de ressources ou de bande passante avant la demande.</li>
                    <li>Services sur mesure ou noms de domaine.</li>
                </ul>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4 text-[var(--primary-foreground)]">3. Processus de demande</h2>
                <p>Pour demander un remboursement, vous devez ouvrir un ticket de support via votre tableau de bord ou envoyer un email à <a href="mailto:support@etercloud.fr" class="text-[var(--primary-foreground)] hover:underline font-medium">support@etercloud.fr</a> avec vos informations de commande.</p>
                <p>Les remboursements sont généralement traités sous 5 à 10 jours ouvrables via le mode de paiement initial (Stripe).</p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4 text-[var(--primary-foreground)]">4. Crédits en compte</h2>
                <p>Dans certains cas, nous pouvons proposer un remboursement sous forme de crédits ajoutés à votre compte Etercloud pour une utilisation future. Ces crédits ne sont pas remboursables en argent réel une fois acceptés.</p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4 text-[var(--primary-foreground)]">5. Modification de la politique</h2>
                <p>Etercloud se réserve le droit de modifier cette politique de remboursement à tout moment. Les nouvelles conditions s'appliqueront uniquement aux achats effectués après la date de modification.</p>
            </section>

            <p class="text-sm text-gray-500 mt-12 pt-6 border-t">Dernière mise à jour : {{ date('d/m/Y') }}</p>
        </div>
    </div>
</div>
@endsection
