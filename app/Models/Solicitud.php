<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Solicitud extends Model
{
    protected $table = 'solicitudes';

    public $timestamps = false;

    protected $fillable = [
        'estudiante_id',
        'ur_id',
        'responsable',
        'fecha_inicio',
        'fecha_fin',
        'estatus',
        'observaciones',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    public function unidadReceptora(): BelongsTo
    {
        return $this->belongsTo(\App\Models\UnidadReceptora::class, 'ur_id');
    }

    public function horas(): HasMany
    {
        return $this->hasMany(Hora::class, 'solicitud_id');
    }

    public function documentos(): HasMany
    {
        return $this->hasMany(Documento::class, 'solicitud_id');
    }
}
