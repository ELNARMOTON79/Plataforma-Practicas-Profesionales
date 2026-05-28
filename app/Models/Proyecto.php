<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $table = 'proyectos';

    protected $fillable = [
        'unidad_receptora_id',
        'titulo',
        'objetivo',
        'justificacion',
        'actividades',
        'impacto_social',
        'tipo_proyecto',
        'tipo_modalidad',
        'plan',
        'ciclo_escolar',
        'cupos_totales',
        'cupos_ocupados',
        'publico_internet',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'cupos_totales' => 'integer',
        'cupos_ocupados' => 'integer',
    ];

    /**
     * Get the receptor unit associated with the project.
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'unidad_receptora_id');
    }
}
