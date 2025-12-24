<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Services\SupportService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function __construct(
        private readonly SupportService $supportService
    ) {}

    public function index(Request $request)
    {
        $tickets = $this->supportService->listForUser($request->user());

        return view('dashboard.tickets.index', compact('tickets'));
    }

    public function create(Request $request)
    {
        $reasons = Ticket::REASONS;
        $preselectedReason = $request->query('reason');
        return view('contact', compact('reasons', 'preselectedReason'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reason' => 'required|string|in:' . implode(',', array_keys(Ticket::REASONS)),
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $reason = Ticket::REASONS[$validated['reason']];

        $ticketData = [
            'subject' => $validated['subject'] ?: $reason['label'],
            'priority' => $reason['priority'],
            'message' => $validated['message'],
        ];

        $ticket = $this->supportService->createTicket($request->user(), $ticketData);

        return redirect()->route('home')
            ->with('status', 'Votre question a été envoyée avec succès.');
    }

    public function show(Ticket $ticket)
    {
        $this->authorizeTicket($ticket);

        $ticket->load(['messages.user', 'assignedTo']);

        return view('dashboard.tickets.show', compact('ticket'));
    }

    public function reply(Request $request, Ticket $ticket)
    {
        $this->authorizeTicket($ticket);

        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        $this->supportService->addMessage($ticket, $request->user(), $validated['message']);

        return back()->with('status', 'Votre réponse a été envoyée.');
    }

    public function reopen(Ticket $ticket)
    {
        $this->authorizeTicket($ticket);

        $this->supportService->reopenTicket($ticket);

        return back()->with('status', 'Votre ticket a été réouvert.');
    }

    private function authorizeTicket(Ticket $ticket)
    {
        if ($ticket->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
