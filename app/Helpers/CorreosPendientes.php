<?php

namespace App\Helpers;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Acumula correos durante una transacción y los envía solo después del commit.
 * Así nunca sale un correo con credenciales de una cuenta que terminó en rollback,
 * y el tiempo de SMTP no mantiene abierta la transacción.
 */
class CorreosPendientes
{
    /** @var array<int, array{0: string, 1: Mailable}> */
    private array $correos = [];

    public function agregar(string $destinatario, Mailable $correo): void
    {
        $this->correos[] = [$destinatario, $correo];
    }

    /**
     * Envía los correos acumulados. Respeta la opción "send_emails" del administrador.
     *
     * @return int Cantidad de correos que no se pudieron enviar.
     */
    public function enviar(): int
    {
        if (! SystemSettings::get('send_emails', true)) {
            $this->correos = [];
            return 0;
        }

        $fallidos = 0;

        foreach ($this->correos as [$destinatario, $correo]) {
            try {
                Mail::to($destinatario)->send($correo);
            } catch (\Throwable $e) {
                $fallidos++;
                Log::error("Error al enviar correo a {$destinatario}: " . $e->getMessage());
            }
        }

        $this->correos = [];

        return $fallidos;
    }

    /**
     * Texto para el mensaje de éxito según si los correos se enviaron, fallaron o están desactivados.
     */
    public static function resumen(int $fallidos): string
    {
        if (! self::enviosHabilitados()) {
            return 'El envío de correos está desactivado; no se notificó por correo.';
        }

        return $fallidos > 0
            ? "Atención: {$fallidos} correo(s) no se pudieron enviar."
            : 'Se envió la notificación por correo.';
    }

    public static function enviosHabilitados(): bool
    {
        return (bool) SystemSettings::get('send_emails', true);
    }
}
