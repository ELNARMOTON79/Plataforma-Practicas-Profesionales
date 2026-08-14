<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SolicitudSoporteAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $coordinador;
    public $tipoRegistro;
    public $nombreRegistro;
    public $mensajeSoporte;

    /**
     * Create a new message instance.
     */
    public function __construct($coordinador, $tipoRegistro, $nombreRegistro, $mensajeSoporte)
    {
        $this->coordinador = $coordinador;
        $this->tipoRegistro = $tipoRegistro;
        $this->nombreRegistro = $nombreRegistro;
        $this->mensajeSoporte = $mensajeSoporte;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Solicitud de Soporte de Coordinador - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.solicitud-soporte',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
