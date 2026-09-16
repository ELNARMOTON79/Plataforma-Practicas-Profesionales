<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Convenio extends Model
{
    protected $table = 'convenios';

    public $timestamps = false;

    protected $fillable = [
        'ur_id',
        'codigo_convenio',
        'fecha_inicio',
        'fecha_termino',
        'estatus',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_termino' => 'date',
    ];

    public function unidadReceptora(): BelongsTo
    {
        return $this->belongsTo(UnidadReceptora::class, 'ur_id');
    }
}
