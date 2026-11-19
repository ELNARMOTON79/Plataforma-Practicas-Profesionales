<?php

namespace App\Observers;

use App\Mail\PendingValidationNotification;
use App\Models\Solicitud;
use App\Support\NotificadorCoordinador;

class SolicitudObserver
{
    /**
     * Notify the coordinator when a student submits a new practice request.
     */
    public function created(Solicitud $solicitud): void
    {
        if ($solicitud->estatus !== 'pendiente') {
            return;
        }

        $solicitud->loadMissing(['estudiante', 'unidadReceptora']);
        $ur = $solicitud->unidadReceptora;

        $detalles = array_filter([
            'Unidad receptora' => $ur ? trim(($ur->unidad_receptora ?? '') . ' - ' . ($ur->nombre_empresa ?? ''), ' -') : null,
            'Modalidad'        => Solicitud::MODALIDADES[$solicitud->modalidad] ?? $solicitud->modalidad,
            'Fecha de inicio'  => $solicitud->fecha_inicio?->format('d/m/Y'),
            'Fecha de término' => $solicitud->fecha_fin?->format('d/m/Y'),
        ]);

        NotificadorCoordinador::tramitePendiente(new PendingValidationNotification(
            'Solicitud de prácticas',
            $solicitud->estudiante?->nombre_completo ?? 'Estudiante',
            $solicitud->estudiante?->matricula,
            $detalles
        ));
    }
}
