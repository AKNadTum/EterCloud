@extends('support.layout')

@section('title', 'Mes Tickets Assignés')

@section('content')
    <div class="space-y-6">
        @if($unassignedCount > 0)
            <div class="bg-amber-500/10 border border-amber-500/20 p-6 rounded-[var(--radius-lg)] flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="size-12 rounded-full bg-amber-500/20 text-amber-500 flex items-center justify-center">
                        <x-heroicon-o-exclamation-triangle class="size-6" />
                    </div>
                    <div>
                        <h3 class="font-bold text-amber-500">Tickets non assignés</h3>
                        <p class="text-sm text-amber-500/80">Il y a actuellement {{ $unassignedCount }} ticket(s) en attente d'attribution.</p>
                    </div>
                </div>
                <x-ui.button href="{{ route('support.tickets.unassigned') }}" variant="primary" class="bg-amber-600 hover:bg-amber-700 text-white">
                    Voir les tickets
                </x-ui.button>
            </div>
        @endif

        <div class="bg-[var(--control-background)] border border-[var(--border)] rounded-[var(--radius-lg)] shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-[var(--border)]">
                <h2 class="font-bold text-[var(--foreground)]">Mes Tickets</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[var(--secondary)]/50 border-b border-[var(--border)]">
                            <th class="px-6 py-4 text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">Auteur</th>
                            <th class="px-6 py-4 text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">Sujet</th>
                            <th class="px-6 py-4 text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-4 text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--border)]">
                        @forelse($assignedTickets as $ticket)
                            <tr class="hover:bg-[var(--secondary)]/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-[var(--foreground)]">{{ $ticket->user->display_name }}</div>
                                    <div class="text-[10px] text-[var(--muted-foreground)]">{{ $ticket->user->email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-[var(--foreground)]">{{ $ticket->subject }}</div>
                                    <div class="text-[10px] text-[var(--muted-foreground)]">Dernière activité: {{ $ticket->last_reply_at ? \Carbon\Carbon::parse($ticket->last_reply_at)->diffForHumans() : $ticket->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'open' => 'bg-emerald-500/10 text-emerald-500',
                                            'pending' => 'bg-amber-500/10 text-amber-500',
                                            'user_replied' => 'bg-blue-500/10 text-blue-500',
                                            'closed' => 'bg-[var(--secondary)]0/10 text-[var(--muted-foreground)]',
                                            'suspended' => 'bg-purple-500/10 text-purple-500',
                                        ];
                                        $statusLabels = [
                                            'open' => 'Ouvert',
                                            'pending' => 'En attente',
                                            'user_replied' => 'Réponse client',
                                            'closed' => 'Fermé',
                                            'suspended' => 'Suspendu',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $statusColors[$ticket->status] ?? 'bg-[var(--secondary)]0/10 text-[var(--muted-foreground)]' }}">
                                        {{ $statusLabels[$ticket->status] ?? $ticket->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <x-ui.button href="{{ route('support.tickets.show', $ticket) }}" variant="outline" size="sm">
                                        Répondre
                                    </x-ui.button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-[var(--muted-foreground)]">
                                    Aucun ticket ne vous est assigné pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

