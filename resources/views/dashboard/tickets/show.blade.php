@extends('dashboard.layout')

@section('title', 'Ticket #' . $ticket->id)

@section('dashboard')
    <div class="space-y-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard.tickets.index') }}" class="p-2 rounded-lg bg-[var(--secondary)] text-[var(--muted-foreground)] hover:text-[var(--foreground)] transition-colors border border-[var(--border)]">
                    <x-heroicon-o-arrow-left class="size-5" />
                </a>
                <div>
                    <h2 class="text-xl font-bold text-[var(--foreground)]">{{ $ticket->subject }}</h2>
                    <p class="text-[var(--muted-foreground)] mt-1">Ticket #{{ $ticket->id }} &bull; Créé le {{ $ticket->created_at->format('d/m/Y à H:i') }}</p>
                </div>
            </div>
            <div>
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
                <x-ui.badge :variant="$statusVariants[$ticket->status] ?? 'subtle'" size="lg" class="font-bold">
                    {{ $statusLabels[$ticket->status] ?? $ticket->status }}
                </x-ui.badge>
            </div>
        </div>

        <x-layout.notifications />

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                {{-- Messages --}}
                <div class="space-y-6">
                    @foreach($ticket->messages as $message)
                        <x-features.ticket-message-bubble
                            :message="$message->message"
                            :is-support="$message->is_support_reply"
                            :user-name="$message->user->display_name"
                            :date="$message->created_at->diffForHumans()"
                        />
                    @endforeach
                </div>

                {{-- Reply Form --}}
                @if($ticket->status !== 'closed')
                    <x-ui.card>
                        <form action="{{ route('dashboard.tickets.reply', $ticket) }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="space-y-2">
                                <label for="message" class="text-sm font-bold text-[var(--foreground)]">Votre réponse</label>
                                <textarea id="message" name="message" rows="4"
                                          class="w-full rounded-xl border border-[var(--border)] bg-[var(--secondary)] px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--ring)] transition-all resize-none text-[var(--foreground)]"
                                          placeholder="Écrivez votre message ici..." required></textarea>
                                @error('message')
                                    <p class="text-xs text-[var(--destructive-foreground)] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex justify-end">
                                <x-ui.button type="submit" variant="primary">
                                    Envoyer la réponse
                                </x-ui.button>
                            </div>
                        </form>
                    </x-ui.card>
                @else
                    <div class="bg-[var(--secondary)]/50 border border-[var(--border)] border-dashed rounded-2xl p-8 text-center">
                        <x-heroicon-o-lock-closed class="size-8 text-[var(--muted-foreground)] mx-auto mb-3" />
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
                <x-ui.card>
                    <h3 class="font-bold text-[var(--foreground)] mb-4 flex items-center gap-2">
                        <x-ui.icon-circle variant="accent" icon="heroicon-o-information-circle" size="xs" />
                        Informations
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-[10px] font-bold text-[var(--muted-foreground)] uppercase tracking-widest">Priorité</p>
                            <p class="mt-1">
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
                                <x-ui.badge :variant="$priorityVariants[$ticket->priority] ?? 'subtle'" size="sm" class="font-bold">
                                    {{ $priorityLabels[$ticket->priority] ?? $ticket->priority }}
                                </x-ui.badge>
                            </p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-[var(--muted-foreground)] uppercase tracking-widest">Agent assigné</p>
                            <p class="text-sm font-semibold text-[var(--foreground)]">
                                {{ $ticket->assignedTo ? $ticket->assignedTo->display_name : 'En attente...' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-[var(--muted-foreground)] uppercase tracking-widest">Dernière mise à jour</p>
                            <p class="text-sm font-semibold text-[var(--foreground)]">
                                {{ $ticket->last_reply_at ? \Carbon\Carbon::parse($ticket->last_reply_at)->diffForHumans() : $ticket->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </x-ui.card>

                <div class="card-accent border rounded-2xl p-6 text-[var(--foreground)] shadow-lg shadow-[var(--accent)]/10 relative overflow-hidden group">
                    <div class="relative z-10">
                        <h3 class="font-bold mb-2">Besoin d'aide urgente ?</h3>
                        <p class="text-xs text-[var(--muted-foreground)] leading-relaxed mb-4">
                            Nos agents font de leur mieux pour vous répondre rapidement. Le délai moyen est de moins de 24h.
                        </p>
                        <x-ui.button href="#" variant="outline" size="sm" class="w-full justify-center">
                            Documentation
                        </x-ui.button>
                    </div>
                    <x-heroicon-o-bolt class="absolute -right-4 -bottom-4 size-24 text-[var(--accent-foreground)]/5 group-hover:scale-110 transition-transform duration-500" />
                </div>
            </div>
        </div>
    </div>
@endsection









