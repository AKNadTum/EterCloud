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
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-500 px-4 py-3 rounded-xl text-sm">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-[var(--control-background)] rounded-xl shadow-sm border border-[var(--border)] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[var(--secondary)] border-b border-[var(--border)]">
                            <th class="px-6 py-4 text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">Sujet</th>
                            <th class="px-6 py-4 text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-4 text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">Priorité</th>
                            <th class="px-6 py-4 text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">Dernière activité</th>
                            <th class="px-6 py-4 text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($tickets as $ticket)
                            <tr class="hover:bg-[var(--secondary)] transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-[var(--foreground)]">{{ $ticket->subject }}</div>
                                    <div class="text-xs text-gray-400">#{{ $ticket->id }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'open' => 'bg-emerald-500/10 text-emerald-500',
                                            'pending' => 'bg-blue-500/10 text-blue-500',
                                            'user_replied' => 'bg-amber-500/10 text-amber-500',
                                            'closed' => 'bg-[var(--secondary)] text-[var(--foreground)]',
                                            'suspended' => 'bg-purple-500/10 text-purple-500',
                                        ];
                                        $statusLabels = [
                                            'open' => 'Ouvert',
                                            'pending' => 'Réponse Support',
                                            'user_replied' => 'Attente Support',
                                            'closed' => 'Fermé',
                                            'suspended' => 'Suspendu',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$ticket->status] ?? 'bg-[var(--secondary)] text-[var(--foreground)]' }}">
                                        {{ $statusLabels[$ticket->status] ?? $ticket->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $priorityColors = [
                                            'high' => 'bg-rose-100 text-rose-700 border-rose-200',
                                            'medium' => 'bg-amber-500/10 text-amber-500 border-amber-200',
                                            'low' => 'bg-slate-100 text-slate-700 border-slate-200',
                                        ];
                                        $priorityLabels = [
                                            'high' => 'Haute',
                                            'medium' => 'Moyenne',
                                            'low' => 'Basse',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $priorityColors[$ticket->priority] ?? 'bg-[var(--secondary)] text-[var(--foreground)]' }}">
                                        {{ $priorityLabels[$ticket->priority] ?? $ticket->priority }}
                                    </span>
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
                                        <div class="size-12 rounded-full bg-[var(--secondary)] flex items-center justify-center text-gray-300 mb-4">
                                            <x-heroicon-o-chat-bubble-left-right class="size-6" />
                                        </div>
                                        <p class="text-[var(--muted-foreground)]">Vous n'avez pas encore de ticket support.</p>
                                        <x-ui.button href="{{ route('contact') }}" variant="primary" size="sm" class="mt-4">
                                            Créer mon premier ticket
                                        </x-ui.button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection





