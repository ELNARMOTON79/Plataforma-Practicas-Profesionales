<?php

namespace App\Models;

use App\Support\CalendarioPracticas;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Solicitud extends Model
{
    /** Fallback used only when the practice has no linked estudiante to read the program from. */
    public const HORAS_META = 480;

    /** Documents the coordinator must validate before practice hours start counting. */
    public const DOCUMENTOS_INICIALES = [
        'Carta de Presentación',
        'Carta de Aceptación',
        'Plan de Trabajo',
    ];

    public const MODALIDADES = [
        'practica_integrativa' => 'Práctica integrativa',
        'estancia_profesional' => 'Estancia profesional',
    ];

    protected $table = 'solicitudes';

    public $timestamps = false;

    protected $fillable = [
        'estudiante_id',
        'ur_id',
        'responsable',
        'fecha_inicio',
        'fecha_fin',
        'horas_por_dia',
        'modalidad',
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

    public function horasMeta(): int
    {
        return $this->estudiante?->horasMetaPractica() ?? self::HORAS_META;
    }

    public function documentosInicialesValidados(): bool
    {
        $validados = $this->documentos
            ->filter(fn ($doc) => in_array($doc->estatus, ['validado', 'aprobado']))
            ->map(fn ($doc) => mb_strtolower(trim($doc->nombre_doc)));

        foreach (self::DOCUMENTOS_INICIALES as $requerido) {
            if (! $validados->contains(mb_strtolower($requerido))) {
                return false;
            }
        }

        return true;
    }

    public function horasCompletadas(): float
    {
        if (! $this->fecha_inicio || ! $this->fecha_fin || ! $this->documentosInicialesValidados()) {
            return 0.0;
        }

        return CalendarioPracticas::horasAvance(
            CarbonImmutable::parse($this->fecha_inicio),
            CarbonImmutable::parse($this->fecha_fin),
            (int) ($this->horas_por_dia ?: 8),
            $this->horasMeta()
        );
    }

    public static function calcularFechaFin(CarbonImmutable $fechaInicio, int $horasPorDia, int $metaHoras): CarbonImmutable
    {
        return CalendarioPracticas::calcularFechaFin($fechaInicio, $horasPorDia, $metaHoras);
    }

    public function sincronizarEstatus(): bool
    {
        if (! in_array($this->estatus, ['aprobada', 'en_proceso', 'finalizada'], true)) {
            return false;
        }

        $hoy = Carbon::today();
        $nuevoEstatus = $this->estatus;

        if ($nuevoEstatus === 'finalizada' && ! $this->documentosInicialesValidados()) {
            $nuevoEstatus = 'en_proceso';
        }

        if ($nuevoEstatus === 'aprobada' && $this->fecha_inicio && $hoy->gte($this->fecha_inicio)) {
            $nuevoEstatus = 'en_proceso';
        }

        if ($nuevoEstatus === 'en_proceso' && $this->fecha_fin && $hoy->gt($this->fecha_fin) && $this->documentosInicialesValidados()) {
            $nuevoEstatus = 'finalizada';
        }

        if ($nuevoEstatus !== $this->estatus) {
            $this->estatus = $nuevoEstatus;
            $this->save();

            return true;
        }

        return false;
    }
}
