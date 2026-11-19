<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PendingValidationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $tipo;
    public $estudiante;
    public $matricula;
    public $detalles;

    /**
     * Create a new message instance.
     *
     * @param  string  $tipo        Tipo de trámite, p. ej. "Solicitud de prácticas" o "Documento".
     * @param  array   $detalles    Pares etiqueta => valor que se muestran en la tarjeta del correo.
     */
    public function __construct(string $tipo, string $estudiante, ?string $matricula, array $detalles = [])
    {
        $this->tipo = $tipo;
        $this->estudiante = $estudiante;
        $this->matricula = $matricula;
        $this->detalles = $detalles;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Nuevo trámite pendiente de validación: {$this->tipo} - Plataforma de Prácticas Profesionales UdeC",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.pending_validation',
        );
    }
}
