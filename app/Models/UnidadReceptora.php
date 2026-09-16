<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnidadReceptora extends Model
{
    protected $table = 'unidades_receptoras';

    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'nombre_empresa',
        'direccion',
        'tipo_persona',
        'sistema',
        'sector',
        'unidad_receptora',
        'titular',
        'cargo',
        'colonia',
        'cp',
        'estado',
        'municipio',
        'telefono',
        'convenio',
    ];

    public function solicitudes(): HasMany
    {
        return $this->hasMany(\App\Models\Solicitud::class, 'ur_id');
    }

    public function convenios(): HasMany
    {
        return $this->hasMany(\App\Models\Convenio::class, 'ur_id');
    }
}
