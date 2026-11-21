<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Aviso al alumno sobre sus trámites: aprobación o rechazo de su solicitud, documentos o proyecto,
 * y horas semanales registradas por la empresa.
 */
class NotificacionAlumno extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  string       $titulo         Encabezado y asunto, p. ej. "Tu solicitud de prácticas fue aprobada".
     * @param  string       $resultado      aprobado | rechazado | informativo (define el color de la etiqueta).
     * @param  string       $nombreAlumno   Nombre del alumno para el saludo.
     * @param  string       $mensaje        Párrafo principal.
     * @param  array        $detalles       Pares etiqueta => valor que se muestran en la tarjeta.
     * @param  string|null  $observaciones  Comentario o motivo del coordinador.
     * @param  string|null  $siguientePaso  Qué debe hacer el alumno ahora.
     * @param  string|null  $urlAccion      Página de la plataforma a la que lleva el botón.
     * @param  string       $textoBoton     Texto del botón.
     */
    public function __construct(
        public string $titulo,
        public string $resultado,
        public string $nombreAlumno,
        public string $mensaje,
        public array $detalles = [],
        public ?string $observaciones = null,
        public ?string $siguientePaso = null,
        public ?string $urlAccion = null,
        public string $textoBoton = 'Ir a la plataforma',
    ) {
        $this->urlAccion = $urlAccion ?: url('/');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "{$this->titulo} - Plataforma de Prácticas Profesionales UdeC",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.notificacion_alumno',
        );
    }
}
