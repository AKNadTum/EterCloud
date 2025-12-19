<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\User;
use App\Notifications\TicketReplyNotification;
use App\Notifications\TicketUserRepliedNotification;
use Illuminate\Support\Facades\DB;

class SupportService
{
    /**
     * Crée un nouveau ticket avec son premier message.
     */
    public function createTicket(User $user, array $data): Ticket
    {
        return DB::transaction(function () use ($user, $data) {
            $ticket = Ticket::create([
                'user_id' => $user->id,
                'subject' => $data['subject'],
                'priority' => $data['priority'] ?? 'medium',
                'status' => 'open',
                'last_reply_at' => now(),
            ]);

            $ticket->messages()->create([
                'user_id' => $user->id,
                'message' => $data['message'],
                'is_support_reply' => false,
            ]);

            // Optionnel : Notifier le support qu'un nouveau ticket a été créé
            // $this->notifySupport(new TicketCreatedNotification($ticket));

            return $ticket;
        });
    }

    /**
     * Ajoute un message à un ticket existant.
     */
    public function addMessage(Ticket $ticket, User $user, string $message, bool $isSupportReply = false): TicketMessage
    {
        $ticketMessage = DB::transaction(function () use ($ticket, $user, $message, $isSupportReply) {
            $ticketMessage = $ticket->messages()->create([
                'user_id' => $user->id,
                'message' => $message,
                'is_support_reply' => $isSupportReply,
            ]);

            $ticket->update([
                'last_reply_at' => now(),
                'status' => $isSupportReply ? Ticket::STATUS_PENDING : Ticket::STATUS_USER_REPLIED,
            ]);

            return $ticketMessage;
        });

        if ($isSupportReply) {
            // Notifier l'auteur du ticket
            $ticket->user->notify(new TicketReplyNotification($ticket));
        } else {
            // Notifier l'agent assigné ou le support qu'un utilisateur a répondu
            if ($ticket->assignedTo) {
                $ticket->assignedTo->notify(new TicketUserRepliedNotification($ticket));
            }
        }

        return $ticketMessage;
    }

    /**
     * Assigne un ticket à un agent du support.
     */
    public function assignTicket(Ticket $ticket, User|int $agent): void
    {
        $agentId = $agent instanceof User ? $agent->id : $agent;

        $ticket->update([
            'assigned_to' => $agentId,
        ]);
    }

    /**
     * Ferme un ticket.
     */
    public function closeTicket(Ticket $ticket): void
    {
        $ticket->update([
            'status' => Ticket::STATUS_CLOSED,
        ]);
    }

    /**
     * Réouvre un ticket.
     */
    public function reopenTicket(Ticket $ticket): void
    {
        $ticket->update([
            'status' => Ticket::STATUS_OPEN,
        ]);
    }

    /**
     * Suspend un ticket.
     */
    public function suspendTicket(Ticket $ticket): void
    {
        $ticket->update([
            'status' => Ticket::STATUS_SUSPENDED,
        ]);
    }

    /**
     * Liste les tickets pour un utilisateur.
     */
    public function listForUser(User $user)
    {
        return Ticket::where('user_id', $user->id)
            ->with(['assignedTo'])
            ->orderBy('last_reply_at', 'desc')
            ->get();
    }

    /**
     * Liste les tickets assignés à un agent.
     */
    public function listForAgent(User $agent)
    {
        return Ticket::where('assigned_to', $agent->id)
            ->with(['user'])
            ->orderBy('last_reply_at', 'desc')
            ->get();
    }

    /**
     * Liste les membres du support (support et admin).
     */
    public function getSupportMembers()
    {
        return User::whereHas('role', function ($q) {
            $q->whereIn('slug', ['support', 'admin']);
        })->with('role')->get();
    }

    /**
     * Liste les tickets non assignés.
     */
    public function listUnassigned()
    {
        return Ticket::whereNull('assigned_to')
            ->with(['user'])
            ->orderBy('created_at', 'asc')
            ->get();
    }
}
