<?php

namespace App\Services;

use App\Mail\WelcomeMail;
use App\Mail\SystemAlertMail;
use App\Mail\GenericMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class MailService
{
    /**
     * Envoie un email de bienvenue à un nouvel utilisateur.
     */
    public function sendWelcomeEmail(User $user): void
    {
        Mail::to($user->email)->send(new WelcomeMail($user));
    }

    /**
     * Envoie une alerte système aux administrateurs.
     */
    public function sendSystemAlert(string $message): void
    {
        Mail::to(config('mail.from.address'))
            ->send(new SystemAlertMail($message));
    }

    /**
     * Envoi d'un email générique.
     */
    public function sendGenericEmail(string $to, string $subject, string $content): void
    {
        Mail::to($to)->send(new GenericMail($subject, $content));
    }
}
