<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Al aprobar una solicitud, el sistema no lograba marcar al alumno como activo
 * (activo_practica no era asignable en el modelo). Esta migración corrige los
 * alumnos que ya tienen una solicitud aprobada, en proceso o finalizada.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('estudiantes')
            ->where('activo_practica', 0)
            ->whereExists(function ($q) {
                $q->select(DB::raw(1))
                    ->from('solicitudes')
                    ->whereColumn('solicitudes.estudiante_id', 'estudiantes.id')
                    ->whereIn('solicitudes.estatus', ['aprobada', 'en_proceso', 'finalizada']);
            })
            ->update(['activo_practica' => 1]);
    }

    public function down(): void
    {
        // Corrección de datos: no se revierte.
    }
};
