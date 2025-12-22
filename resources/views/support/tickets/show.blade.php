@extends('support.layout')

@section('title', 'Ticket #' . $ticket->id)

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('support.index') }}" class="p-2 rounded-lg bg-[var(--secondary)] text-[var(--muted-foreground)] hover:text-[var(--foreground)] transition-colors">
                    <x-heroicon-o-arrow-left class="size-5" />
                </a>
                <div>
                    <h2 class="text-xl font-bold text-[var(--foreground)]">{{ $ticket->subject }}</h2>
                    <p class="text-[var(--muted-foreground)] text-sm">Par {{ $ticket->user->display_name }} ({{ $ticket->user->email }}) &bull; #{{ $ticket->id }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @if($ticket->status !== 'closed' && $ticket->status !== 'suspended')
                    <form action="{{ route('support.tickets.suspend', $ticket) }}" method="POST">
                        @csrf
                        <x-ui.button type="submit" variant="outline" size="sm" class="text-amber-600 border-amber-200 hover:bg-amber-50">
                            Suspendre
                        </x-ui.button>
                    </form>
                @endif
                @if($ticket->status === 'closed' || $ticket->status === 'suspended')
                    <form action="{{ route('support.tickets.reopen', $ticket) }}" method="POST">
                        @csrf
                        <x-ui.button type="submit" variant="outline" size="sm" class="text-emerald-600 border-emerald-200 hover:bg-emerald-50">
                            {{ $ticket->status === 'suspended' ? 'Reprendre' : 'Réouvrir' }}
                        </x-ui.button>
                    </form>
                @endif
                @if($ticket->status !== 'closed')
                    <form action="{{ route('support.tickets.close', $ticket) }}" method="POST">
                        @csrf
                        <x-ui.button type="submit" variant="outline" size="sm" class="text-rose-600 border-rose-200 hover:bg-rose-50">
                            Fermer
                        </x-ui.button>
                    </form>
                @endif
                @php
                    $statusColors = [
                        'open' => 'bg-emerald-500/10 text-emerald-500',
                        'pending' => 'bg-amber-500/10 text-amber-500',
                        'user_replied' => 'bg-blue-500/10 text-blue-500',
                        'closed' => 'bg-[var(--secondary)] text-[var(--foreground)]',
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
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $statusColors[$ticket->status] ?? 'bg-[var(--secondary)] text-[var(--foreground)]' }}">
                    {{ $statusLabels[$ticket->status] ?? $ticket->status }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                {{-- Messages --}}
                <div class="space-y-6">
                    @foreach($ticket->messages as $message)
                        <div class="flex {{ $message->is_support_reply ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[85%] {{ $message->is_support_reply ? 'bg-blue-600 text-white' : 'bg-[var(--control-background)] border border-[var(--border)] text-[var(--foreground)]' }} rounded-2xl px-6 py-4 shadow-sm">
                                <div class="flex items-center justify-between gap-4 mb-2">
                                    <span class="text-xs font-bold uppercase tracking-wider {{ $message->is_support_reply ? 'text-blue-100' : 'text-[var(--link)]' }}">
                                        {{ $message->is_support_reply ? 'Moi (Support)' : $message->user->display_name }}
                                    </span>
                                    <span class="text-[10px] {{ $message->is_support_reply ? 'text-blue-200' : 'text-[var(--muted-foreground)]' }}">
                                        {{ $message->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <div class="text-sm leading-relaxed whitespace-pre-wrap">{{ $message->message }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Reply Form --}}
                @if($ticket->status !== 'closed')
                    <div class="bg-[var(--control-background)] rounded-2xl p-6 shadow-sm border border-[var(--border)]">
                        <form action="{{ route('support.tickets.reply', $ticket) }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="space-y-2">
                                <label for="message" class="text-sm font-bold text-[var(--foreground)]">Réponse au client</label>
                                <textarea id="message" name="message" rows="4"
                                          class="w-full rounded-xl border border-[var(--border)] bg-[var(--secondary)]/50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all resize-none"
                                          placeholder="Écrivez votre réponse ici..." required></textarea>
                            </div>
                            <div class="flex justify-end">
                                <x-ui.button type="submit" variant="primary">
                                    Envoyer la réponse
                                </x-ui.button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>

            {{-- Sidebar Info --}}
            <div class="space-y-6">
                <div class="bg-[var(--control-background)] rounded-2xl p-6 shadow-sm border border-[var(--border)]">
                    <h3 class="font-bold text-[var(--foreground)] mb-4 flex items-center gap-2">
                        <x-heroicon-o-information-circle class="size-5 text-[var(--link)]" />
                        Détails
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-[10px] font-bold text-[var(--muted-foreground)] uppercase tracking-widest">Priorité</p>
                            <p class="text-sm font-semibold text-[var(--foreground)] capitalize">{{ $ticket->priority }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-[var(--muted-foreground)] uppercase tracking-widest">Client</p>
                            <p class="text-sm font-semibold text-[var(--foreground)]">{{ $ticket->user->display_name }}</p>
                            <p class="text-xs text-[var(--muted-foreground)]">{{ $ticket->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-[var(--muted-foreground)] uppercase tracking-widest">Dernière activité</p>
                            <p class="text-sm font-semibold text-[var(--foreground)]">
                                {{ $ticket->last_reply_at ? \Carbon\Carbon::parse($ticket->last_reply_at)->diffForHumans() : $ticket->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>

                @if(auth()->user()->hasPermission('support.assign'))
                    <div class="bg-blue-500/10 border border-blue-500/20 rounded-2xl p-6">
                        <h3 class="font-bold text-blue-500 mb-2">Assignation</h3>
                        <p class="text-xs text-[var(--muted-foreground)] mb-4">Attribuez ce ticket à un membre de l'équipe support.</p>
                        <form action="{{ route('support.tickets.assign', $ticket) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <select name="agent_id" class="w-full rounded-xl border border-blue-500/30 bg-[var(--control-background)] px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all text-[var(--foreground)]">
                                    <option value="">Sélectionner un agent</option>
                                    @foreach($supportMembers as $member)
                                        <option value="{{ $member->id }}" {{ $ticket->assigned_to == $member->id ? 'selected' : '' }}>
                                            {{ $member->display_name }} ({{ $member->role->name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <x-ui.button type="submit" variant="primary" class="w-full justify-center">
                                {{ $ticket->assigned_to ? 'Réassigner' : 'Assigner' }}
                            </x-ui.button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection





