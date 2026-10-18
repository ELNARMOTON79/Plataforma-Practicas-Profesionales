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

    /**
     * Folio a mostrar de cada convenio, indexado por codigo_convenio: se reemplaza el número final
     * del código por un consecutivo según el orden en que se registró (CONV-2024-118 → CONV-2024-01).
     */
    public static function folios()
    {
        return static::selectRaw('codigo_convenio, MIN(id) as primer_id')
            ->groupBy('codigo_convenio')
            ->orderBy('primer_id')
            ->pluck('codigo_convenio')
            ->values()
            ->mapWithKeys(fn ($codigo, $indice) => [
                $codigo => preg_replace('/\d+$/', str_pad($indice + 1, 2, '0', STR_PAD_LEFT), $codigo),
            ]);
    }
}
