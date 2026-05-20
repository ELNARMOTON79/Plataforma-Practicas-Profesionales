<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Documento extends Model
{
    protected $table = 'documentos';

    public $timestamps = false;

    protected $fillable = [
        'solicitud_id',
        'ur_id',
        'nombre_doc',
        'ruta_archivo',
        'fecha_carga',
    ];

    protected $casts = [
        'fecha_carga' => 'date',
    ];

    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(Solicitud::class, 'solicitud_id');
    }
}
