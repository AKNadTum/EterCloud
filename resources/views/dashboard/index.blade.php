@extends('dashboard.layout')

@section('title', 'Tableau de bord')

@section('dashboard')
    <div class="space-y-8">
        {{-- Section Bienvenue --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-[var(--foreground)]">Ravi de vous revoir, {{ auth()->user()->first_name ?? auth()->user()->name }} ! 👋</h2>
                <p class="text-[var(--muted-foreground)] mt-1">Voici un aperçu de vos services et de votre activité récente.</p>
            </div>
            <div class="flex items-center gap-3">
                <x-ui.button href="{{ route('dashboard.servers.create') }}" variant="primary">
                    <x-heroicon-o-plus class="size-4 mr-2" />
                    Créer un serveur
                </x-ui.button>
            </div>
        </div>

        {{-- Cartes de statistiques --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <x-cards.stat-card
                title="Serveurs actifs"
                :value="$serversCount"
                icon="heroicon-o-server"
                color="blue"
                :href="route('dashboard.servers')"
                link-text="Gérer mes serveurs"
                :badge-text="$serversCount > 0 ? 'Actifs' : null"
            />

            <x-cards.stat-card
                title="Abonnement actuel"
                :value="$plan ? $plan->name : 'Aucun abonnement'"
                icon="heroicon-o-credit-card"
                color="purple"
                :href="route('dashboard.billing')"
                link-text="Gérer la facturation"
                :badge-text="$plan ? 'Premium' : 'Gratuit'"
            />

            <x-cards.stat-card
                title="Besoin d'aide ?"
                value="Support technique"
                icon="heroicon-o-question-mark-circle"
                color="emerald"
                :href="route('contact')"
                link-text="Contactez-nous"
            />
        </div>

        {{-- Section Serveurs Récents --}}
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-[var(--foreground)]">Serveurs récents</h3>
                <a href="{{ route('dashboard.servers') }}" class="text-sm font-medium text-[var(--primary-foreground)] hover:underline">Voir tout</a>
            </div>

            <div class="grid grid-cols-1 gap-4">
                @forelse($servers as $server)
                    <x-features.server-list-item :server="$server" />
                @empty
                    <div class="bg-[var(--muted)] border-2 border-dashed border-[var(--border)] rounded-xl p-8 text-center">
                        <div class="mx-auto size-12 rounded-full bg-[var(--secondary)] flex items-center justify-center text-[var(--muted-foreground)] mb-4">
                            <x-heroicon-o-server class="size-6" />
                        </div>
                        <h4 class="text-base font-semibold text-[var(--foreground)]">Aucun serveur pour le moment</h4>
                        <p class="text-sm text-[var(--muted-foreground)] mt-1">Commencez par créer votre premier serveur de jeu en quelques clics.</p>
                        <x-ui.button href="{{ route('dashboard.servers.create') }}" variant="primary" size="sm" class="mt-4">
                            <x-heroicon-o-plus class="size-4 mr-2" />
                            Créer un serveur
                        </x-ui.button>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Liens Utiles / Doc --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-ui.card class="card-primary border-none group overflow-hidden" padded="true">
                <div class="relative z-10">
                    <h3 class="text-lg font-bold">Consultez notre documentation</h3>
                    <p class="text-[var(--muted-foreground)] mt-2 text-sm max-w-[250px]">Apprenez à configurer vos serveurs et à optimiser vos performances.</p>
                    <x-ui.button href="#" variant="outline" size="sm" class="mt-4">
                        Explorer la doc
                    </x-ui.button>
                </div>
                <x-heroicon-o-book-open class="absolute -right-4 -bottom-4 size-32 text-[var(--primary-foreground)]/5 group-hover:scale-110 transition-transform duration-500" />
            </x-ui.card>

            <x-ui.card class="card-accent border-none group overflow-hidden" padded="true">
                <div class="relative z-10">
                    <h3 class="text-lg font-bold">Besoin d'un plan supérieur ?</h3>
                    <p class="text-[var(--muted-foreground)] mt-2 text-sm max-w-[250px]">Découvrez nos offres haute performance pour vos projets les plus ambitieux.</p>
                    <x-ui.button href="{{ route('plans.index') }}" variant="outline" size="sm" class="mt-4">
                        Voir les tarifs
                    </x-ui.button>
                </div>
                <x-heroicon-o-sparkles class="absolute -right-4 -bottom-4 size-32 text-[var(--accent-foreground)]/5 group-hover:scale-110 transition-transform duration-500" />
            </x-ui.card>
        </div>
    </div>
@endsection









