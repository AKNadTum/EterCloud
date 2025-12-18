@extends('layout')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-slate max-w-none">
            <h1 class="text-3xl font-bold mb-8">Mentions Légales</h1>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4 text-[var(--primary-foreground)]">1. Éditeur du site</h2>
                <p>Le site <strong>Eternom</strong> est édité par <strong>Eternom</strong>, dont le siège social est situé rue de l'Ardoise, Houyet, Belgique.</p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4 text-[var(--primary-foreground)]">2. Directeur de la publication</h2>
                <p>Le Directeur de la publication est <strong>Alexandre Ernotte</strong>.</p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4 text-[var(--primary-foreground)]">3. Hébergement</h2>
                <p>Le site est hébergé par la société <strong>Hetzner</strong>.</p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4 text-[var(--primary-foreground)]">4. Propriété intellectuelle</h2>
                <p>L'ensemble du contenu de ce site (textes, images, logos, icônes) est la propriété exclusive de <strong>Eternom</strong> ou de ses partenaires. Toute reproduction, représentation, modification ou adaptation de tout ou partie du site est strictement interdite sans autorisation écrite préalable.</p>
            </section>

            <section class="mb-8">
                <h2 class="text-2xl font-semibold mb-4 text-[var(--primary-foreground)]">5. Contact</h2>
                <p>Pour toute question ou réclamation, vous pouvez nous contacter :</p>
                <ul class="list-disc pl-5">
                    <li>Par email : <a href="mailto:contact@eternom.fr" class="text-[var(--primary-foreground)] hover:underline font-medium">contact@eternom.fr</a></li>
                    <li>Par courrier : Eternom, rue de l'Ardoise, Houyet, Belgique.</li>
                </ul>
            </section>

            <p class="text-sm text-gray-500 mt-12 pt-6 border-t">Dernière mise à jour : {{ date('d/m/Y') }}</p>
        </div>
    </div>
</div>
@endsection
