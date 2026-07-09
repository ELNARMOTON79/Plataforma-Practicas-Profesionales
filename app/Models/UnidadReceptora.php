<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
