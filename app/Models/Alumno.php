<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'estudiantes';

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Get dynamic status of the student.
     */
    public function getEstatusAttribute()
    {
        if (!$this->user || !$this->user->activo) {
            return 'INACTIVO';
        }
        if ($this->activo_practica == 1) {
            return 'ACTIVO';
        }
        
        $solicitud = \DB::table('solicitudes')
            ->where('estudiante_id', $this->id)
            ->orderBy('id', 'desc')
            ->first();
            
        if ($solicitud) {
            if (in_array($solicitud->estatus, ['aprobada', 'en_proceso', 'finalizada'])) {
                return 'ASIGNADO';
            } elseif ($solicitud->estatus == 'pendiente') {
                return 'PENDIENTE';
            }
        }
        
        return 'PENDIENTE';
    }

    /**
     * Get premium color classes for each status.
     */
    public function getEstatusClassAttribute()
    {
        $estatus = $this->estatus;
        if ($estatus == 'ACTIVO') {
            return 'bg-green-50 text-green-700 border-green-200';
        } elseif ($estatus == 'ASIGNADO') {
            return 'bg-blue-50 text-blue-700 border-blue-200';
        } elseif ($estatus == 'PENDIENTE') {
            return 'bg-yellow-50 text-yellow-700 border-yellow-200';
        } else {
            return 'bg-red-50 text-red-700 border-red-200';
        }
    }
}

