@extends('admin.layout')

@section('title', 'Gestion des Plans')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold tracking-tight">Liste des plans</h2>
            <p class="text-sm text-[var(--muted-foreground)]">Gérez les offres d'hébergement et leurs limitations.</p>
        </div>
        <x-ui.button href="{{ route('admin.plans.create') }}" size="sm">
            <x-heroicon-o-plus class="size-4 mr-1.5" />
            Nouveau Plan
        </x-ui.button>
    </div>

    <x-ui.table>
        <x-slot name="head">
            <th class="px-6 py-4 text-left text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">Plan & Identifiant</th>
            <th class="px-6 py-4 text-left text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">Ressources</th>
            <th class="px-6 py-4 text-left text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">Limites</th>
            <th class="px-6 py-4 text-left text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">Localisations</th>
            <th class="px-6 py-4 text-right text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">Actions</th>
        </x-slot>

        @foreach ($plans as $plan)
            <tr class="hover:bg-[var(--secondary)]/10 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-[var(--foreground)]">{{ $plan->name }}</span>
                        @if($plan->price_stripe_id)
                            <span class="text-[10px] font-mono text-[var(--muted-foreground)] flex items-center gap-1 mt-0.5">
                                <x-heroicon-s-credit-card class="size-3" />
                                {{ $plan->price_stripe_id }}
                            </span>
                        @else
                            <span class="text-[10px] font-bold text-[var(--success-foreground)] uppercase flex items-center gap-1 mt-0.5">
                                <x-heroicon-s-gift class="size-3" />
                                Gratuit / Manuel
                            </span>
                        @endif
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-4">
                        <div class="flex flex-col">
                            <div class="flex items-center gap-1.5 text-sm">
                                <x-heroicon-o-cpu-chip class="size-4 text-[var(--primary)]" />
                                <span class="font-semibold">{{ $plan->cpu > 0 ? $plan->cpu . '%' : '∞' }}</span>
                            </div>
                            <span class="text-[10px] text-[var(--muted-foreground)] font-bold uppercase tracking-tighter">CPU</span>
                        </div>
                        <div class="flex flex-col">
                            <div class="flex items-center gap-1.5 text-sm">
                                <x-heroicon-o-square-3-stack-3d class="size-4 text-[var(--primary)]" />
                                <span class="font-semibold">{{ $plan->memory > 0 ? ($plan->memory / 1024) . 'GB' : '∞' }}</span>
                            </div>
                            <span class="text-[10px] text-[var(--muted-foreground)] font-bold uppercase tracking-tighter">RAM</span>
                        </div>
                        <div class="flex flex-col">
                            <div class="flex items-center gap-1.5 text-sm">
                                <x-heroicon-o-server-stack class="size-4 text-[var(--primary)]" />
                                <span class="font-semibold">{{ ($plan->disk / 1024) }}GB</span>
                            </div>
                            <span class="text-[10px] text-[var(--muted-foreground)] font-bold uppercase tracking-tighter">Disque</span>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="flex flex-col gap-1.5">
                        <div class="flex flex-wrap gap-1">
                            <x-ui.badge variant="outline" size="sm" class="font-bold border-[var(--primary)]/20 bg-[var(--primary)]/5">
                                {{ $plan->server_limit }} Instance{{ $plan->server_limit > 1 ? 's' : '' }}
                            </x-ui.badge>
                        </div>
                        <div class="flex flex-wrap gap-1">
                            <span class="text-[10px] text-[var(--muted-foreground)] font-medium">
                                {{ $plan->databases_limit }} DB • {{ $plan->backups_limit }} Backup{{ $plan->backups_limit > 1 ? 's' : '' }}
                            </span>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="flex flex-wrap gap-1 max-w-[200px]">
                        @forelse($plan->locations as $loc)
                            <x-ui.badge variant="subtle" size="sm" class="text-[10px]">
                                {{ $loc->display_name ?? $loc->name ?? $loc->ptero_id_location }}
                            </x-ui.badge>
                        @empty
                            <span class="text-[10px] text-[var(--muted-foreground)] italic">Aucune</span>
                        @endforelse
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex justify-end gap-2">
                        <x-ui.button href="{{ route('admin.plans.edit', $plan) }}" variant="ghost" size="sm" title="Modifier">
                            <x-heroicon-o-pencil-square class="size-4" />
                        </x-ui.button>
                        <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr ?')">
                            @csrf
                            @method('DELETE')
                            <x-ui.button type="submit" variant="ghost" size="sm" class="text-[var(--destructive)] hover:bg-[var(--destructive)]/10" title="Supprimer">
                                <x-heroicon-o-trash class="size-4" />
                            </x-ui.button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach

        <x-slot name="foot">
            <td colspan="5" class="px-6 py-4">
                {{ $plans->links() }}
            </td>
        </x-slot>
    </x-ui.table>
@endsection










