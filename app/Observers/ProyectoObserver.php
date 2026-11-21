<?php

namespace App\Observers;

use App\Mail\PendingValidationNotification;
use App\Models\Proyecto;
use App\Support\NotificadorCoordinador;

class ProyectoObserver
{
    /**
     * Notify the coordinator when a student submits or resubmits a project proposal.
     */
    public function saved(Proyecto $proyecto): void
    {
        // Only notify if project is pending review
        if ($proyecto->estatus !== 'pendiente') {
            return;
        }

        // Only notify when created or when estatus changed to pendiente (resubmission)
        if (! $proyecto->wasRecentlyCreated && ! $proyecto->wasChanged('estatus')) {
            return;
        }

        // Only notify if a student is linked to this project
        if (! $proyecto->estudiante_id) {
            return;
        }

        $proyecto->loadMissing(['estudiante', 'empresa']);
        $estudiante = $proyecto->estudiante;
        $empresa    = $proyecto->empresa;

        $detalles = array_filter([
            'Título del Proyecto' => $proyecto->titulo,
            'Empresa'             => $empresa?->nombre_empresa ?? null,
            'Tipo de Proyecto'    => $proyecto->tipo_proyecto,
            'Modalidad'           => $proyecto->tipo_modalidad,
            'Tipo de envío'       => $proyecto->wasRecentlyCreated ? 'Primera propuesta' : 'Corrección y reenvío',
        ]);

        NotificadorCoordinador::tramitePendiente(new PendingValidationNotification(
            'Propuesta de Proyecto: ' . $proyecto->titulo,
            $estudiante?->nombre_completo ?? 'Estudiante',
            $estudiante?->matricula,
            $detalles,
            route('coordinador.tramites', ['tab' => 'proyectos-pendientes'])
        ));
    }
}
