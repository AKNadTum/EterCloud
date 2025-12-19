<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_ticket_with_reason()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('contact.submit'), [
            'reason' => 'technical_issue',
            'message' => 'I have a technical problem.',
        ]);

        $ticket = Ticket::first();

        $this->assertNotNull($ticket);
        $this->assertEquals($user->id, $ticket->user_id);
        $this->assertEquals(Ticket::REASONS['technical_issue']['label'], $ticket->subject);
        $this->assertEquals(Ticket::REASONS['technical_issue']['priority'], $ticket->priority);
        $this->assertEquals('open', $ticket->status);

        $this->assertCount(1, $ticket->messages);
        $this->assertEquals('I have a technical problem.', $ticket->messages->first()->message);

        $response->assertRedirect(route('dashboard.tickets.show', $ticket));
    }

    public function test_user_cannot_create_ticket_with_invalid_reason()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('contact.submit'), [
            'reason' => 'invalid_reason',
            'message' => 'This should fail.',
        ]);

        $response->assertSessionHasErrors('reason');
        $this->assertCount(0, Ticket::all());
    }
}
