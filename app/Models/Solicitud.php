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
        'practica_integrativa' => 'Práctica profesional',
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

    /**
     * Horas acumuladas: la suma de las horas semanales que registró la unidad receptora.
     * Las semanas sin registrar no cuentan, y nada cuenta hasta que el coordinador
     * valida los documentos iniciales. El total se limita a la meta del programa.
     */
    public function horasCompletadas(): float
    {
        if (! $this->documentosInicialesValidados()) {
            return 0.0;
        }

        $total = $this->relationLoaded('horas')
            ? $this->horas->sum('cantidad_horas')
            : $this->horas()->sum('cantidad_horas');

        return (float) min($this->horasMeta(), (float) $total);
    }

    /** Horas por día que eligió el alumno (6 u 8). */
    public function horasPorDia(): int
    {
        return (int) ($this->horas_por_dia ?: 8);
    }

    /**
     * Semanas (de lunes a domingo) en las que la unidad receptora puede registrar horas:
     * desde la semana de inicio hasta la semana actual. Para cada una se sugiere
     * días hábiles × horas por día y se indica lo ya registrado (null = sin registrar).
     *
     * @return \Illuminate\Support\Collection<int, array{inicio: CarbonImmutable, fin: CarbonImmutable, dias: int, sugeridas: int, registradas: ?float}>
     */
    public function semanasDeRegistro(?CarbonImmutable $hoy = null): \Illuminate\Support\Collection
    {
        $hoy = $hoy ?? CarbonImmutable::today();
        $semanas = collect();

        if (! $this->fecha_inicio) {
            return $semanas;
        }

        $inicioPractica = CarbonImmutable::parse($this->fecha_inicio);
        $registros = $this->horas()->get(['fecha_registro', 'cantidad_horas']);

        for ($lunes = $inicioPractica->startOfWeek(CarbonImmutable::MONDAY); $lunes->lte($hoy->startOfWeek(CarbonImmutable::MONDAY)); $lunes = $lunes->addWeek()) {
            $domingo = $lunes->endOfWeek(CarbonImmutable::SUNDAY)->startOfDay();
            $desde = $lunes->lt($inicioPractica) ? $inicioPractica : $lunes;
            $dias = CalendarioPracticas::diasLaborablesEntre($desde, $domingo);

            $deLaSemana = $registros->filter(fn ($r) => CarbonImmutable::parse($r->fecha_registro)->between($lunes, $domingo));

            $semanas->push([
                'inicio' => $lunes,
                'fin' => $domingo,
                'dias' => $dias,
                'sugeridas' => $dias * $this->horasPorDia(),
                'registradas' => $deLaSemana->isEmpty() ? null : (float) $deLaSemana->sum('cantidad_horas'),
            ]);
        }

        return $semanas;
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

        // Termina cuando las horas registradas por la empresa alcanzan la meta (ya no por fecha)
        if ($nuevoEstatus === 'en_proceso' && $this->documentosInicialesValidados() && $this->horasCompletadas() >= $this->horasMeta()) {
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
