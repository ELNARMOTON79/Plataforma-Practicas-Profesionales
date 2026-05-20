<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hora extends Model
{
    protected $table = 'horas';

    public $timestamps = false;

    protected $fillable = [
        'solicitud_id',
        'fecha_registro',
        'cantidad_horas',
    ];

    protected $casts = [
        'fecha_registro' => 'date',
        'cantidad_horas' => 'decimal:2',
    ];

    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(Solicitud::class, 'solicitud_id');
    }
}
