<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Documento extends Model
{
    /** Disco privado donde se guardan los archivos de los estudiantes (no accesible por URL directa). */
    public const DISCO = 'local';

    /** Disco donde se guardaban los archivos antes; se sigue leyendo para registros antiguos. */
    public const DISCO_LEGADO = 'public';

    /** Estatus en los que el estudiante ya no puede reemplazar ni eliminar el documento. */
    public const ESTATUS_VALIDADOS = ['validado', 'aprobado'];

    protected $table = 'documentos';

    public $timestamps = false;

    protected $fillable = [
        'solicitud_id',
        'ur_id',
        'nombre_doc',
        'ruta_archivo',
        'fecha_carga',
        'estatus',
        'observaciones',
    ];

    protected $casts = [
        'fecha_carga' => 'datetime',
    ];

    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(Solicitud::class, 'solicitud_id');
    }

    public function estaValidado(): bool
    {
        return in_array($this->estatus, self::ESTATUS_VALIDADOS, true);
    }

    /**
     * Disco en el que realmente existe el archivo (privado primero, luego el público heredado).
     */
    public static function discoDeArchivo(?string $ruta): ?string
    {
        if (! $ruta) {
            return null;
        }

        foreach ([self::DISCO, self::DISCO_LEGADO] as $disco) {
            if (Storage::disk($disco)->exists($ruta)) {
                return $disco;
            }
        }

        return null;
    }

    public static function eliminarArchivo(?string $ruta): void
    {
        if (! $ruta) {
            return;
        }

        foreach ([self::DISCO, self::DISCO_LEGADO] as $disco) {
            if (Storage::disk($disco)->exists($ruta)) {
                Storage::disk($disco)->delete($ruta);
            }
        }
    }

    /** URL autenticada para ver/descargar el archivo. */
    public static function urlArchivo(int $id): string
    {
        return route('documentos.archivo', $id);
    }

    public function getUrlArchivoAttribute(): string
    {
        return self::urlArchivo($this->id);
    }
}
