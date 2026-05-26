<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CredentialsNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;
    public $name;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, string $password, string $name)
    {
        $this->user = $user;
        $this->password = $password;
        $this->name = $name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tus credenciales de acceso - Plataforma de Prácticas Profesionales UdeC',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.credentials',
        );
    }
}
