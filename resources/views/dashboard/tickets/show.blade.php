@extends('dashboard.layout')

@section('title', 'Ticket #' . $ticket->id)

@section('dashboard')
    <div class="space-y-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard.tickets.index') }}" class="p-2 rounded-lg bg-[var(--secondary)] text-[var(--muted-foreground)] hover:bg-gray-200 transition-colors">
                    <x-heroicon-o-arrow-left class="size-5" />
                </a>
                <div>
                    <h2 class="text-xl font-bold text-[var(--foreground)]">{{ $ticket->subject }}</h2>
                    <p class="text-[var(--muted-foreground)] mt-1">Ticket #{{ $ticket->id }} &bull; Créé le {{ $ticket->created_at->format('d/m/Y à H:i') }}</p>
                </div>
            </div>
            <div>
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
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold {{ $statusColors[$ticket->status] ?? 'bg-[var(--secondary)] text-[var(--foreground)]' }}">
                    {{ $statusLabels[$ticket->status] ?? $ticket->status }}
                </span>
            </div>
        </div>

        @if(session('status'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-500 px-4 py-3 rounded-xl text-sm">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                {{-- Messages --}}
                <div class="space-y-6">
                    @foreach($ticket->messages as $message)
                        <div class="flex {{ $message->is_support_reply ? 'justify-start' : 'justify-end' }}">
                            <div class="max-w-[85%] {{ $message->is_support_reply ? 'bg-[var(--control-background)] border border-[var(--border)] text-[var(--foreground)]' : 'bg-blue-600 text-white' }} rounded-2xl px-6 py-4 shadow-sm">
                                <div class="flex items-center justify-between gap-4 mb-2">
                                    <span class="text-xs font-bold uppercase tracking-wider {{ $message->is_support_reply ? 'text-[var(--link)]' : 'text-blue-100' }}">
                                        {{ $message->is_support_reply ? 'Support EterCloud' : $message->user->display_name }}
                                    </span>
                                    <span class="text-[10px] {{ $message->is_support_reply ? 'text-gray-400' : 'text-blue-200' }}">
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
                        <form action="{{ route('dashboard.tickets.reply', $ticket) }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="space-y-2">
                                <label for="message" class="text-sm font-bold text-[var(--foreground)]">Votre réponse</label>
                                <textarea id="message" name="message" rows="4"
                                          class="w-full rounded-xl border border-[var(--border)] bg-[var(--secondary)] px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all resize-none"
                                          placeholder="Écrivez votre message ici..." required></textarea>
                                @error('message')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex justify-end">
                                <x-ui.button type="submit" variant="primary">
                                    Envoyer la réponse
                                </x-ui.button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="bg-[var(--secondary)] border border-[var(--border)] rounded-2xl p-8 text-center">
                        <x-heroicon-o-lock-closed class="size-8 text-gray-400 mx-auto mb-3" />
                        <h4 class="font-bold text-[var(--foreground)]">Ce ticket est fermé</h4>
                        <p class="text-sm text-[var(--muted-foreground)] mt-1 mb-4">Vous ne pouvez plus envoyer de messages sur ce ticket.</p>
                        <form action="{{ route('dashboard.tickets.reopen', $ticket) }}" method="POST">
                            @csrf
                            <x-ui.button type="submit" variant="outline" size="sm">
                                Réouvrir le ticket
                            </x-ui.button>
                        </form>
                    </div>
                @endif
            </div>

            {{-- Sidebar Info --}}
            <div class="space-y-6">
                <div class="bg-[var(--control-background)] rounded-2xl p-6 shadow-sm border border-[var(--border)]">
                    <h3 class="font-bold text-[var(--foreground)] mb-4 flex items-center gap-2">
                        <x-heroicon-o-information-circle class="size-5 text-[var(--link)]" />
                        Informations
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Priorité</p>
                            <p class="mt-1">
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
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold border {{ $priorityColors[$ticket->priority] ?? 'bg-[var(--secondary)] text-[var(--foreground)]' }}">
                                    {{ $priorityLabels[$ticket->priority] ?? $ticket->priority }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Agent assigné</p>
                            <p class="text-sm font-semibold text-[var(--foreground)]">
                                {{ $ticket->assignedTo ? $ticket->assignedTo->display_name : 'En attente...' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Dernière mise à jour</p>
                            <p class="text-sm font-semibold text-[var(--foreground)]">
                                {{ $ticket->last_reply_at ? \Carbon\Carbon::parse($ticket->last_reply_at)->diffForHumans() : $ticket->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-600 rounded-2xl p-6 text-white shadow-lg shadow-blue-200">
                    <h3 class="font-bold mb-2">Besoin d'aide urgente ?</h3>
                    <p class="text-xs text-blue-100 leading-relaxed mb-4">
                        Nos agents font de leur mieux pour vous répondre rapidement. Le délai moyen est de moins de 24h.
                    </p>
                    <x-ui.button href="#" variant="outline" size="sm" class="w-full justify-center bg-[var(--control-background)]/10 border-white/20 text-white hover:bg-[var(--control-background)]/20">
                        Documentation
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
@endsection

