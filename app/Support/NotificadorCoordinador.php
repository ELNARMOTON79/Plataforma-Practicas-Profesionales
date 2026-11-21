<?php

namespace App\Support;

use App\Mail\PendingValidationNotification;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificadorCoordinador
{
    /**
     * Send a "pending validation" email to the coordinator (rol_id = 2).
     * Failures are logged and never interrupt the student's request.
     */
    public static function tramitePendiente(PendingValidationNotification $mail): void
    {
        // Skip seeders, migrations and other artisan commands.
        if (app()->runningInConsole() && ! app()->runningUnitTests()) {
            return;
        }

        // Todos los coordinadores activos reciben el aviso (cada uno por separado, sin ver a los demás)
        $correos = User::where('rol_id', 2)->where('activo', true)->whereNotNull('correo')->pluck('correo')->unique();

        if ($correos->isEmpty()) {
            Log::warning('No se encontró un coordinador activo para notificar el trámite: ' . $mail->tipo);
            return;
        }

        foreach ($correos as $correo) {
            try {
                Mail::to($correo)->send(clone $mail);
                Log::info("Correo de trámite pendiente ({$mail->tipo}) enviado al coordinador {$correo}");
            } catch (\Throwable $e) {
                Log::error("Error al enviar correo de trámite pendiente al coordinador {$correo}: " . $e->getMessage());
            }
        }
    }
}
