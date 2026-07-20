<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estudiante extends Model
{
    protected $table = 'estudiantes';

    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'nombre_completo',
        'primer_nombre',
        'apellidos',
        'matricula',
        'carrera',
        'semestre',
        'grupo',
        'direccion',
        'telefono',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function solicitudes(): HasMany
    {
        return $this->hasMany(Solicitud::class, 'estudiante_id');
    }

    // Alias for usuario() to avoid breaking existing code
    public function user(): BelongsTo
    {
        return $this->usuario();
    }

    /**
     * Get dynamic status of the student.
     */
    public function getEstatusAttribute()
    {
        if (!$this->usuario || !$this->usuario->activo) {
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
