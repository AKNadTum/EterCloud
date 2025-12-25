@extends('admin.layout')

@section('title', 'Vue d\'ensemble')

@section('content')
    <div class="space-y-8">
        <!-- Statistiques rapides -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            <!-- Utilisateurs -->
            <div class="bg-[var(--control-background)] p-6 rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm group hover:border-[var(--primary)]/50 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-blue-500/10 rounded-lg">
                        <x-heroicon-o-users class="size-6 text-blue-500" />
                    </div>
                    <span class="text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">Total</span>
                </div>
                <h3 class="text-sm font-medium text-[var(--muted-foreground)]">Utilisateurs</h3>
                <p class="mt-1 text-3xl font-extrabold text-[var(--foreground)]">{{ number_format($stats['users_count']) }}</p>
            </div>

            <!-- Serveurs -->
            <div class="bg-[var(--control-background)] p-6 rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm group hover:border-[var(--primary)]/50 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-purple-500/10 rounded-lg">
                        <x-heroicon-o-server class="size-6 text-purple-500" />
                    </div>
                    <span class="text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">Ptero</span>
                </div>
                <h3 class="text-sm font-medium text-[var(--muted-foreground)]">Serveurs</h3>
                <p class="mt-1 text-3xl font-extrabold text-[var(--foreground)]">{{ number_format($stats['servers_count']) }}</p>
            </div>

            <!-- Nœuds -->
            <div class="bg-[var(--control-background)] p-6 rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm group hover:border-[var(--primary)]/50 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-green-500/10 rounded-lg">
                        <x-heroicon-o-cpu-chip class="size-6 text-green-500" />
                    </div>
                    <span class="text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">Actifs</span>
                </div>
                <h3 class="text-sm font-medium text-[var(--muted-foreground)]">Nœuds</h3>
                <p class="mt-1 text-3xl font-extrabold text-[var(--foreground)]">{{ number_format($stats['nodes_count']) }}</p>
            </div>

            <!-- Plans -->
            <div class="bg-[var(--control-background)] p-6 rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm group hover:border-[var(--primary)]/50 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-orange-500/10 rounded-lg">
                        <x-heroicon-o-credit-card class="size-6 text-orange-500" />
                    </div>
                    <span class="text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">Offres</span>
                </div>
                <h3 class="text-sm font-medium text-[var(--muted-foreground)]">Plans</h3>
                <p class="mt-1 text-3xl font-extrabold text-[var(--foreground)]">{{ number_format($stats['plans_count']) }}</p>
            </div>

            <!-- Locations -->
            <div class="bg-[var(--control-background)] p-6 rounded-[var(--radius-lg)] border border-[var(--border)] shadow-sm group hover:border-[var(--primary)]/50 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-pink-500/10 rounded-lg">
                        <x-heroicon-o-map-pin class="size-6 text-pink-500" />
                    </div>
                    <span class="text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">Géo</span>
                </div>
                <h3 class="text-sm font-medium text-[var(--muted-foreground)]">Locations</h3>
                <p class="mt-1 text-3xl font-extrabold text-[var(--foreground)]">{{ number_format($stats['locations_count']) }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Derniers Utilisateurs -->
            <div class="bg-[var(--control-background)] border border-[var(--border)] rounded-[var(--radius-lg)] shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-[var(--border)] flex items-center justify-between bg-[var(--background)]/50">
                    <h3 class="font-bold text-[var(--foreground)] flex items-center gap-2">
                        <x-heroicon-o-user-plus class="size-5 text-[var(--muted-foreground)]" />
                        Derniers Inscrits
                    </h3>
                    <x-ui.button href="{{ route('admin.users.index') }}" variant="outline" size="sm" class="text-xs h-8">
                        Voir tout
                    </x-ui.button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-[var(--background)]/30 text-[var(--muted-foreground)] font-bold uppercase text-[10px] tracking-widest">
                            <tr>
                                <th class="px-6 py-3">Utilisateur</th>
                                <th class="px-6 py-3 text-center">Date</th>
                                <th class="px-6 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[var(--border)]">
                            @foreach($recentUsers as $user)
                                <tr class="hover:bg-[var(--primary)]/5 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-[var(--foreground)]">{{ $user->name }}</span>
                                            <span class="text-xs text-[var(--muted-foreground)]">{{ $user->email }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center text-[var(--muted-foreground)]">
                                        {{ $user->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <x-ui.button href="{{ route('admin.users.edit', $user) }}" variant="ghost" size="sm" class="size-8 p-0">
                                            <x-heroicon-o-pencil-square class="size-4" />
                                        </x-ui.button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Liens Rapides / Actions -->
            <div class="space-y-6">
                <div class="bg-[var(--control-background)] border border-[var(--border)] rounded-[var(--radius-lg)] shadow-sm p-6">
                    <h3 class="font-bold text-[var(--foreground)] mb-4 flex items-center gap-2">
                        <x-heroicon-o-rocket-launch class="size-5 text-[var(--muted-foreground)]" />
                        Actions Rapides
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <x-ui.button href="{{ route('admin.plans.create') }}" variant="outline" class="w-full justify-start gap-2 h-auto py-3">
                            <x-heroicon-o-plus-circle class="size-5 text-blue-500" />
                            <div class="flex flex-col items-start text-left">
                                <span class="text-sm font-bold">Nouveau Plan</span>
                                <span class="text-[10px] text-[var(--muted-foreground)] uppercase">Facturation</span>
                            </div>
                        </x-ui.button>
                        <x-ui.button href="{{ route('admin.locations.create') }}" variant="outline" class="w-full justify-start gap-2 h-auto py-3">
                            <x-heroicon-o-map-pin class="size-5 text-pink-500" />
                            <div class="flex flex-col items-start text-left">
                                <span class="text-sm font-bold">Nouvelle Location</span>
                                <span class="text-[10px] text-[var(--muted-foreground)] uppercase">Infrastructure</span>
                            </div>
                        </x-ui.button>
                        <x-ui.button href="{{ route('admin.billing.index') }}" variant="outline" class="w-full justify-start gap-2 h-auto py-3">
                            <x-heroicon-o-banknotes class="size-5 text-green-500" />
                            <div class="flex flex-col items-start text-left">
                                <span class="text-sm font-bold">Revenus</span>
                                <span class="text-[10px] text-[var(--muted-foreground)] uppercase">Stripe</span>
                            </div>
                        </x-ui.button>
                        <x-ui.button href="{{ route('admin.servers.index') }}" variant="outline" class="w-full justify-start gap-2 h-auto py-3">
                            <x-heroicon-o-server-stack class="size-5 text-purple-500" />
                            <div class="flex flex-col items-start text-left">
                                <span class="text-sm font-bold">Serveurs</span>
                                <span class="text-[10px] text-[var(--muted-foreground)] uppercase">Gestion</span>
                            </div>
                        </x-ui.button>
                    </div>
                </div>

                <div class="bg-blue-600 rounded-[var(--radius-lg)] p-6 text-white shadow-lg shadow-blue-500/20 relative overflow-hidden group">
                    <div class="relative z-10">
                        <h3 class="text-lg font-extrabold mb-1">Documentation Admin</h3>
                        <p class="text-blue-100 text-sm mb-4">Besoin d'aide pour gérer votre infrastructure ?</p>
                        <x-ui.button variant="secondary" size="sm" class="bg-[var(--control-background)] text-[var(--link)] hover:bg-blue-50 font-bold">
                            Consulter les guides
                        </x-ui.button>
                    </div>
                    <x-heroicon-o-book-open class="absolute -right-4 -bottom-4 size-32 text-white/10 group-hover:scale-110 transition-transform duration-500" />
                </div>
            </div>
        </div>
    </div>
@endsection










