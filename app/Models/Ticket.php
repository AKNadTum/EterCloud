<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    const STATUS_OPEN = 'open';
    const STATUS_PENDING = 'pending';
    const STATUS_USER_REPLIED = 'user_replied';
    const STATUS_CLOSED = 'closed';
    const STATUS_SUSPENDED = 'suspended';

    const REASONS = [
        'technical_issue' => ['label' => 'Problème technique', 'priority' => 'high'],
        'billing_issue' => ['label' => 'Problème de facturation', 'priority' => 'medium'],
        'quote_request' => ['label' => 'Demande de devis / Plan sur mesure', 'priority' => 'medium'],
        'bug_report' => ['label' => 'Signalement de bug', 'priority' => 'low'],
        'partnership' => ['label' => 'Demande de partenariat', 'priority' => 'low'],
        'other' => ['label' => 'Autre demande', 'priority' => 'medium'],
    ];

    protected $fillable = [
        'user_id',
        'assigned_to',
        'subject',
        'status',
        'priority',
        'last_reply_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function messages()
    {
        return $this->hasMany(TicketMessage::class);
    }
}
