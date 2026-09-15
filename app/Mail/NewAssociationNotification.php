<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewAssociationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $name;
    public $units;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, string $name, array $units)
    {
        $this->user = $user;
        $this->name = $name;
        $this->units = $units;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nueva unidad receptora asociada a tu cuenta - Plataforma de Prácticas Profesionales UdeC',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.new_association',
        );
    }
}
