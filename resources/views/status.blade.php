@extends('layout')

@section('content')
    <div class="pt-24 pb-12">
        <div class="container-custom">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl">
                    État de l'infrastructure
                </h1>
                <p class="mt-4 text-lg text-muted-foreground">
                    Suivez en temps réel l'état de nos services et de nos serveurs de jeux.
                </p>
            </div>

            @if(isset($error) && $error)
                <x-ui.alert variant="destructive" class="mb-8">
                    <x-heroicon-o-exclamation-triangle class="size-5" />
                    
                        {{ $error }}
                    
                </x-ui.alert>
            @else
                <!-- État Global -->
                <div class="mb-12">
                    <div class="bg-[var(--control-background)] rounded-[var(--radius-lg)] shadow-sm border border-[var(--border)] p-8 flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="flex items-center gap-6">
                            <x-ui.icon-circle variant="success" icon="heroicon-o-check-circle" size="lg" />
                            <div>
                                <h2 class="text-2xl font-bold">Tous les systèmes sont opérationnels</h2>
                                <p class="text-sm text-muted-foreground font-medium">Dernière vérification : {{ $last_updated->diffForHumans() }}</p>
                            </div>
                        </div>
                        <x-ui.badge variant="success" size="lg" class="px-6 py-2 text-sm uppercase tracking-wider font-black">Opérationnel</x-ui.badge>
                    </div>
                </div>

                <!-- Statistiques Globales -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                    <div class="bg-[var(--control-background)] border border-[var(--border)] rounded-[var(--radius-lg)] p-6 shadow-sm flex items-center gap-4">
                        <x-ui.icon-circle variant="primary" icon="heroicon-o-server-stack" size="md" />
                        <div>
                            <div class="text-muted-foreground text-xs font-bold uppercase tracking-wider">Nodes Actifs</div>
                            <div class="text-2xl font-black">{{ $stats['total_nodes'] }}</div>
                        </div>
                    </div>
                    <div class="bg-[var(--control-background)] border border-[var(--border)] rounded-[var(--radius-lg)] p-6 shadow-sm flex items-center gap-4">
                        <x-ui.icon-circle variant="accent" icon="heroicon-o-cpu-chip" size="md" />
                        <div>
                            <div class="text-muted-foreground text-xs font-bold uppercase tracking-wider">Serveurs Hébergés</div>
                            <div class="text-2xl font-black">{{ $stats['total_servers'] }}</div>
                        </div>
                    </div>
                    <div class="bg-[var(--control-background)] border border-[var(--border)] rounded-[var(--radius-lg)] p-6 shadow-sm flex items-center gap-4">
                        <x-ui.icon-circle variant="success" icon="heroicon-o-circle-stack" size="md" />
                        <div>
                            <div class="text-muted-foreground text-xs font-bold uppercase tracking-wider">Disque Occupé</div>
                            <div class="text-2xl font-black">{{ round($stats['used_disk'] / 1024, 1) }} <span class="text-sm font-normal text-muted-foreground">/ {{ round($stats['total_disk'] / 1024, 1) }} GB</span></div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <!-- Services & Composants -->
                    <div class="lg:col-span-1 space-y-6">
                        <h2 class="text-xl font-bold flex items-center gap-2">
                            <x-heroicon-o-cpu-chip class="size-5 text-[var(--primary)]" />
                            Services
                        </h2>
                        <div class="bg-[var(--control-background)] border border-[var(--border)] rounded-[var(--radius-lg)] divide-y divide-[var(--border)] shadow-sm">
                            @foreach($components as $component)
                                <div class="p-4 flex items-center justify-between">
                                    <div>
                                        <div class="font-bold text-sm text-[var(--foreground)]">{{ $component['name'] }}</div>
                                        <div class="text-[10px] text-muted-foreground font-medium">{{ $component['description'] }}</div>
                                    </div>
                                    @if($component['status'] === 'operational')
                                        <div class="flex items-center gap-1.5 text-[var(--success-foreground)] font-black text-[10px] uppercase tracking-tighter">
                                            <span class="relative flex h-2 w-2">
                                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[var(--success-foreground)] opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-2 w-2 bg-[var(--success-foreground)]"></span>
                                            </span>
                                            Opérationnel
                                        </div>
                                    @else
                                        <x-ui.badge variant="warning" size="sm">Incident</x-ui.badge>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="bg-[var(--primary)]/5 border border-[var(--primary)]/10 rounded-[var(--radius-lg)] p-6">
                            <h3 class="font-bold text-sm mb-2">Besoin d'aide ?</h3>
                            <p class="text-xs text-muted-foreground mb-4">Si vous remarquez un problème qui n'est pas répertorié ici, n'hésitez pas à nous contacter.</p>
                            <x-ui.button href="{{ route('contact') }}" variant="outline" size="sm" class="w-full">Ouvrir un ticket</x-ui.button>
                        </div>
                    </div>

                    <!-- Nodes Grid -->
                    <div class="lg:col-span-2 space-y-6">
                        <h2 class="text-xl font-bold flex items-center gap-2">
                            <x-heroicon-o-server-stack class="size-5 text-[var(--primary)]" />
                            Nodes de calcul
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($nodes as $node)
                                <x-status.node-card :node="$node" />
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Historique (Simulé) -->
                <div class="mt-12">
                    <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                        <x-heroicon-o-clock class="size-5 text-[var(--primary-foreground)]" />
                        Historique des incidents
                    </h2>
                    <div class="bg-[var(--control-background)] border border-[var(--border)] rounded-[var(--radius-lg)] p-8 italic text-center text-muted-foreground text-sm font-medium shadow-sm">
                        Aucun incident majeur n'a été signalé au cours des 90 derniers jours.
                    </div>
                </div>
            @endif

            <div class="mt-16 text-center border-t border-[var(--border)] pt-8">
                <p class="text-sm text-muted-foreground">
                    Vous rencontrez un problème non listé ici ?
                    <a href="{{ route('contact') }}" class="text-[var(--primary)] font-semibold hover:underline">Contactez notre support</a>.
                </p>
            </div>
        </div>
    </div>
@endsection









