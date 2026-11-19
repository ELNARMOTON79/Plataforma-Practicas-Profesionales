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

        $coordinador = User::where('rol_id', 2)->where('activo', true)->first();

        if (! $coordinador || ! $coordinador->correo) {
            Log::warning('No se encontró un coordinador activo para notificar el trámite: ' . $mail->tipo);
            return;
        }

        try {
            Mail::to($coordinador->correo)->send($mail);
            Log::info("Correo de trámite pendiente ({$mail->tipo}) enviado al coordinador {$coordinador->correo}");
        } catch (\Exception $e) {
            Log::error("Error al enviar correo de trámite pendiente al coordinador {$coordinador->correo}: " . $e->getMessage());
        }
    }
}
