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

    public static function enviosHabilitados(): bool
    {
        return (bool) SystemSettings::get('send_emails', true);
    }
}
