<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use App\Services\SupportService;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    public function __construct(
        private readonly SupportService $supportService
    ) {}

    public function unassigned()
    {
        if (!auth()->user()->hasPermission('support.assign')) {
            abort(403);
        }

        $tickets = $this->supportService->listUnassigned();
        $supportMembers = $this->supportService->getSupportMembers();

        return view('support.tickets.unassigned', compact('tickets', 'supportMembers'));
    }

    public function show(Ticket $ticket)
    {
        $user = auth()->user();

        // Autoriser si assigné à moi OU si j'ai la permission d'assigner (voir tous les tickets)
        if ($ticket->assigned_to !== $user->id && !$user->hasPermission('support.assign')) {
            abort(403);
        }

        $ticket->load(['messages.user', 'user']);

        $supportMembers = $this->supportService->getSupportMembers();

        return view('support.tickets.show', compact('ticket', 'supportMembers'));
    }

    public function reply(Request $request, Ticket $ticket)
    {
        if ($ticket->assigned_to !== auth()->id() && !auth()->user()->hasPermission('support.assign')) {
            abort(403);
        }

        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        $this->supportService->addMessage($ticket, auth()->user(), $validated['message'], true);

        return back()->with('status', 'Réponse envoyée.');
    }

    public function assign(Request $request, Ticket $ticket)
    {
        if (!auth()->user()->hasPermission('support.assign')) {
            abort(403);
        }

        $validated = $request->validate([
            'agent_id' => 'nullable|exists:users,id',
        ]);

        $agentId = $validated['agent_id'] ?? auth()->id();
        $agent = User::findOrFail($agentId);

        // Vérifier si l'agent est bien un membre du support/admin
        if (!$agent->hasPermission('support.access')) {
            return back()->with('error', 'Cet utilisateur n\'est pas un membre du support.');
        }

        $this->supportService->assignTicket($ticket, $agent);

        return back()->with('status', $validated['agent_id'] ? 'Ticket assigné avec succès.' : 'Ticket assigné à vous-même.');
    }

    public function close(Ticket $ticket)
    {
        if ($ticket->assigned_to !== auth()->id() && !auth()->user()->hasPermission('support.assign')) {
            abort(403);
        }

        $this->supportService->closeTicket($ticket);

        return back()->with('status', 'Ticket fermé.');
    }

    public function reopen(Ticket $ticket)
    {
        if ($ticket->assigned_to !== auth()->id() && !auth()->user()->hasPermission('support.assign')) {
            abort(403);
        }

        $this->supportService->reopenTicket($ticket);

        return back()->with('status', 'Ticket réouvert.');
    }

    public function suspend(Ticket $ticket)
    {
        if ($ticket->assigned_to !== auth()->id() && !auth()->user()->hasPermission('support.assign')) {
            abort(403);
        }

        $this->supportService->suspendTicket($ticket);

        return back()->with('status', 'Ticket suspendu.');
    }
}
