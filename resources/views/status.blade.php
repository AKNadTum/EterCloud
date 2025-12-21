@extends('layout')

@section('content')
    <div class="pt-24 pb-12">
        <div class="mx-auto max-w-[1400px] px-4 sm:px-6 lg:px-8">
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
                    <x-ui.alert-description>
                        {{ $error }}
                    </x-ui.alert-description>
                </x-ui.alert>
            @else
                <!-- État Global -->
                <div class="mb-12">
                    <div class="bg-[var(--control-background)] rounded-[var(--radius-lg)] shadow-sm border border-[var(--border)] p-8 flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="flex items-center gap-6">
                            <div class="size-16 rounded-full bg-[var(--success)] flex items-center justify-center">
                                <x-heroicon-o-check-circle class="size-10 text-[var(--success-foreground)]" />
                            </div>
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
                        <div class="size-12 rounded-xl bg-[var(--primary)] flex items-center justify-center">
                            <x-heroicon-o-server-stack class="size-6 text-[var(--primary-foreground)]" />
                        </div>
                        <div>
                            <div class="text-muted-foreground text-xs font-bold uppercase tracking-wider">Nodes Actifs</div>
                            <div class="text-2xl font-black">{{ $stats['total_nodes'] }}</div>
                        </div>
                    </div>
                    <div class="bg-[var(--control-background)] border border-[var(--border)] rounded-[var(--radius-lg)] p-6 shadow-sm flex items-center gap-4">
                        <div class="size-12 rounded-xl bg-[var(--accent)] flex items-center justify-center">
                            <x-heroicon-o-cpu-chip class="size-6 text-[var(--accent-foreground)]" />
                        </div>
                        <div>
                            <div class="text-muted-foreground text-xs font-bold uppercase tracking-wider">Serveurs Hébergés</div>
                            <div class="text-2xl font-black">{{ $stats['total_servers'] }}</div>
                        </div>
                    </div>
                    <div class="bg-[var(--control-background)] border border-[var(--border)] rounded-[var(--radius-lg)] p-6 shadow-sm flex items-center gap-4">
                        <div class="size-12 rounded-xl bg-[var(--success)] flex items-center justify-center">
                            <x-heroicon-o-circle-stack class="size-6 text-[var(--success-foreground)]" />
                        </div>
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
                                @php
                                    $attr = $node['attributes'] ?? [];
                                    $location = $attr['relationships']['location']['attributes'] ?? ['short' => 'Unknown', 'long' => 'Unknown'];
                                    $isMaintenance = $attr['maintenance_mode'] ?? false;

                                    // Calcul cohérent du nombre de serveurs
                                    $serversRel = $attr['relationships']['servers'] ?? null;
                                    $totalServers = $serversRel ? ($serversRel['meta']['pagination']['total'] ?? count($serversRel['data'] ?? [])) : 0;

                                    $diskUsed = $attr['allocated_resources']['disk'] ?? 0;
                                    $diskTotal = $attr['disk'] ?? 0;
                                    $diskPercent = ($diskTotal > 0) ? min(($diskUsed / $diskTotal) * 100, 100) : 0;

                                    $cpuUsed = $attr['allocated_resources']['cpu'] ?? 0;
                                    $cpuTotal = $attr['cpu'] ?? 0;
                                    $isCpuUnlimited = $cpuTotal <= 0;
                                    $cpuPercent = !$isCpuUnlimited ? min(($cpuUsed / $cpuTotal) * 100, 100) : 0;
                                @endphp

                                <div class="bg-[var(--control-background)] border border-[var(--border)] rounded-[var(--radius-lg)] shadow-sm overflow-hidden flex flex-col">
                                    <div class="p-5 border-b border-[var(--border)] bg-muted/20 flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="size-8 rounded-lg bg-[var(--primary)] flex items-center justify-center border border-[var(--primary)]/30">
                                                <x-heroicon-o-server class="size-5 text-[var(--primary-foreground)]" />
                                            </div>
                                            <div>
                                                <div class="font-black text-sm text-[var(--foreground)]">{{ $attr['name'] ?? 'Unknown Node' }}</div>
                                                <div class="text-[10px] text-muted-foreground uppercase tracking-widest font-bold">{{ $location['long'] }} ({{ $location['short'] }}) — {{ $attr['fqdn'] ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                        @if($isMaintenance)
                                            <x-ui.badge variant="warning" size="sm" class="font-bold">Maintenance</x-ui.badge>
                                        @else
                                            <x-ui.badge variant="success" size="sm" class="font-bold">Online</x-ui.badge>
                                        @endif
                                    </div>
                                    <div class="p-5 space-y-4 flex-grow">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="space-y-1.5">
                                                <div class="flex justify-between text-[10px] font-black uppercase text-muted-foreground tracking-tighter">
                                                    <span>Stockage</span>
                                                    <span>{{ round($diskPercent) }}%</span>
                                                </div>
                                                <div class="h-2 w-full bg-[var(--secondary)] rounded-full overflow-hidden border border-[var(--border)]">
                                                    <div class="h-full bg-[var(--primary-foreground)] transition-all duration-500" style="width: {{ $diskPercent }}%"></div>
                                                </div>
                                            </div>
                                            <div class="space-y-1.5">
                                                <div class="flex justify-between text-[10px] font-black uppercase text-muted-foreground tracking-tighter">
                                                    <span>CPU</span>
                                                    <span>{{ $isCpuUnlimited ? 'Illimité' : round($cpuPercent) . '%' }}</span>
                                                </div>
                                                <div class="h-2 w-full bg-[var(--secondary)] rounded-full overflow-hidden border border-[var(--border)]">
                                                    <div class="h-full bg-[var(--accent-foreground)] transition-all duration-500" style="width: {{ $isCpuUnlimited ? 100 : $cpuPercent }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between pt-2 border-t border-[var(--border)]/50">
                                            <div class="text-xs font-bold text-[var(--foreground)] flex items-center gap-1.5">
                                                <x-heroicon-o-cpu-chip class="size-3.5 text-[var(--primary-foreground)]" />
                                                <span>{{ $totalServers }} serveurs</span>
                                            </div>
                                            <div class="text-[10px] font-black text-muted-foreground uppercase tracking-tighter">
                                                {{ round($diskTotal/1024) }}GB Stockage
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
