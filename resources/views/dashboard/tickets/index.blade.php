@extends('dashboard.layout')

@section('title', 'Mes Tickets Support')

@section('dashboard')
    <div class="space-y-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-[var(--foreground)]">Mes Tickets Support</h2>
                <p class="text-[var(--muted-foreground)] mt-1">Gérez vos demandes d'assistance technique.</p>
            </div>
            <div class="flex items-center gap-3">
                <x-ui.button href="{{ route('contact') }}" variant="primary">
                    <x-heroicon-o-plus class="size-4 mr-2" />
                    Nouveau ticket
                </x-ui.button>
            </div>
        </div>

        @if(session('status'))
            <x-ui.feedback.alert variant="success" class="mb-6">
                <x-heroicon-o-check-circle class="size-5" />
                <x-ui.feedback.alert-description>
                    {{ session('status') }}
                </x-ui.feedback.alert-description>
            </x-ui.feedback.alert>
        @endif

        <x-ui.table>
            <x-slot name="head">
                <th class="px-6 py-4 text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">Sujet</th>
                <th class="px-6 py-4 text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">Statut</th>
                <th class="px-6 py-4 text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">Priorité</th>
                <th class="px-6 py-4 text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">Dernière activité</th>
                <th class="px-6 py-4 text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider text-right">Action</th>
            </x-slot>

            @forelse($tickets as $ticket)
                <tr class="hover:bg-[var(--secondary)]/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-semibold text-[var(--foreground)]">{{ $ticket->subject }}</div>
                        <div class="text-xs text-[var(--muted-foreground)]">#{{ $ticket->id }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $statusVariants = [
                                'open' => 'success-subtle',
                                'pending' => 'primary-subtle',
                                'user_replied' => 'warning-subtle',
                                'closed' => 'subtle',
                                'suspended' => 'destructive-subtle',
                            ];
                            $statusLabels = [
                                'open' => 'Ouvert',
                                'pending' => 'Réponse Support',
                                'user_replied' => 'Attente Support',
                                'closed' => 'Fermé',
                                'suspended' => 'Suspendu',
                            ];
                        @endphp
                        <x-ui.feedback.badge :variant="$statusVariants[$ticket->status] ?? 'subtle'" size="sm" class="font-bold uppercase tracking-tighter">
                            {{ $statusLabels[$ticket->status] ?? $ticket->status }}
                        </x-ui.feedback.badge>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $priorityVariants = [
                                'high' => 'destructive-subtle',
                                'medium' => 'warning-subtle',
                                'low' => 'subtle',
                            ];
                            $priorityLabels = [
                                'high' => 'Haute',
                                'medium' => 'Moyenne',
                                'low' => 'Basse',
                            ];
                        @endphp
                        <x-ui.feedback.badge :variant="$priorityVariants[$ticket->priority] ?? 'subtle'" size="sm" class="font-bold">
                            {{ $priorityLabels[$ticket->priority] ?? $ticket->priority }}
                        </x-ui.feedback.badge>
                    </td>
                    <td class="px-6 py-4 text-sm text-[var(--muted-foreground)]">
                        {{ $ticket->last_reply_at ? \Carbon\Carbon::parse($ticket->last_reply_at)->diffForHumans() : $ticket->created_at->diffForHumans() }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <x-ui.button href="{{ route('dashboard.tickets.show', $ticket) }}" variant="outline" size="sm">
                            Voir
                        </x-ui.button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <x-ui.icon-circle variant="secondary" icon="heroicon-o-chat-bubble-left-right" size="lg" class="mb-4" />
                            <p class="text-[var(--muted-foreground)]">Vous n'avez pas encore de ticket support.</p>
                            <x-ui.button href="{{ route('contact') }}" variant="primary" size="sm" class="mt-4">
                                Créer mon premier ticket
                            </x-ui.button>
                        </div>
                    </td>
                </tr>
            @endforelse
        </x-ui.table>
    </div>
@endsection





