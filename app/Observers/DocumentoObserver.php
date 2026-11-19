<?php

namespace App\Observers;

use App\Mail\PendingValidationNotification;
use App\Models\Documento;
use App\Support\NotificadorCoordinador;

class DocumentoObserver
{
    /**
     * Notify the coordinator when a student uploads (or replaces) a document.
     * Coordinator validations/rejections change only the status, so they are ignored.
     */
    public function saved(Documento $documento): void
    {
        if ($documento->estatus !== 'pendiente') {
            return;
        }

        if (! $documento->wasRecentlyCreated && ! $documento->wasChanged('ruta_archivo')) {
            return;
        }

        $documento->loadMissing('solicitud.estudiante');
        $estudiante = $documento->solicitud?->estudiante;

        NotificadorCoordinador::tramitePendiente(new PendingValidationNotification(
            'Documento: ' . $documento->nombre_doc,
            $estudiante?->nombre_completo ?? 'Estudiante',
            $estudiante?->matricula,
            array_filter([
                'Documento'      => $documento->nombre_doc,
                'Fecha de carga' => $documento->fecha_carga?->format('d/m/Y H:i'),
                'Tipo de envío'  => $documento->wasChanged('ruta_archivo') ? 'Reemplazo de archivo' : 'Primera entrega',
            ])
        ));
    }
}
