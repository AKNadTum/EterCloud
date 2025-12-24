@extends('support.layout')

@section('title', 'Tickets non assignés')

@section('content')
    <div class="space-y-6">
        <div class="bg-[var(--control-background)] border border-[var(--border)] rounded-[var(--radius-lg)] shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-[var(--border)] flex items-center justify-between">
                <h2 class="font-bold text-[var(--foreground)]">File d'attente</h2>
                <span class="px-3 py-1 bg-amber-500/10 text-amber-500 text-xs font-bold rounded-full">
                    {{ $tickets->count() }} ticket(s) en attente
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[var(--secondary)]/50 border-b border-[var(--border)]">
                            <th class="px-6 py-4 text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">Auteur</th>
                            <th class="px-6 py-4 text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">Sujet</th>
                            <th class="px-6 py-4 text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">Priorité</th>
                            <th class="px-6 py-4 text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider">Créé le</th>
                            <th class="px-6 py-4 text-xs font-bold text-[var(--muted-foreground)] uppercase tracking-wider text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[var(--border)]">
                        @forelse($tickets as $ticket)
                            <tr class="hover:bg-[var(--secondary)]/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-[var(--foreground)]">{{ $ticket->user->display_name }}</div>
                                    <div class="text-[10px] text-[var(--muted-foreground)]">{{ $ticket->user->email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-[var(--foreground)]">{{ $ticket->subject }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $priorityColors = [
                                            'low' => 'text-[var(--muted-foreground)]',
                                            'medium' => 'text-blue-500',
                                            'high' => 'text-rose-500 font-bold',
                                        ];
                                    @endphp
                                    <span class="text-xs capitalize {{ $priorityColors[$ticket->priority] }}">
                                        {{ $ticket->priority }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-[var(--muted-foreground)]">
                                    {{ $ticket->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('support.tickets.assign', $ticket) }}" method="POST" class="flex items-center gap-2 justify-end">
                                        @csrf
                                        <select name="agent_id" class="text-xs rounded-[var(--radius)] border border-[var(--border)] bg-[var(--control-background)] px-3 py-1.5 focus:ring-2 focus:ring-[var(--ring)] outline-none transition-all">
                                            <option value="" disabled selected>Choisir un agent</option>
                                            @foreach($supportMembers as $member)
                                                <option value="{{ $member->id }}" {{ auth()->id() == $member->id ? 'selected' : '' }}>
                                                    {{ $member->display_name }} ({{ $member->role->name }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-ui.button type="submit" variant="primary" size="sm">
                                            Assigner
                                        </x-ui.button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-[var(--muted-foreground)]">
                                    Aucun ticket n'est en attente d'assignation. Félicitations !
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection





