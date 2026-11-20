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
    public $urlAccion;

    /**
     * Create a new message instance.
     *
     * @param  string       $tipo        Tipo de trámite, p. ej. "Solicitud de prácticas" o "Documento".
     * @param  string       $estudiante  Nombre del alumno.
     * @param  string|null  $matricula   Matrícula o cuenta del alumno.
     * @param  array        $detalles    Pares etiqueta => valor que se muestran en la tarjeta del correo.
     * @param  string|null  $urlAccion   URL a la que apunta el botón del correo.
     */
    public function __construct(string $tipo, string $estudiante, ?string $matricula, array $detalles = [], ?string $urlAccion = null)
    {
        $this->tipo = $tipo;
        $this->estudiante = $estudiante;
        $this->matricula = $matricula;
        $this->detalles = $detalles;
        $this->urlAccion = $urlAccion ?: route('coordinador.tramites');
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
