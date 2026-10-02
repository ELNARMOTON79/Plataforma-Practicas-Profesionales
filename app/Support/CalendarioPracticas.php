<?php

namespace App\Support;

use Carbon\CarbonImmutable;

/**
 * Working-day math for practice tracking: Mexico's official holidays (LFT art. 74,
 * fixed dates only — the once-every-6-years transition of power day is not included)
 * plus weekends are treated as non-working days.
 */
class CalendarioPracticas
{
    public static function esDiaLaborable(CarbonImmutable $fecha): bool
    {
        if ($fecha->isWeekend()) {
            return false;
        }

        return ! in_array($fecha->toDateString(), self::festivos($fecha->year), true);
    }

    /** @return string[] Y-m-d dates */
    public static function festivos(int $year): array
    {
        return [
            CarbonImmutable::create($year, 1, 1)->toDateString(),
            self::nEsimoDiaSemanaDelMes($year, 2, CarbonImmutable::MONDAY, 1)->toDateString(),
            self::nEsimoDiaSemanaDelMes($year, 3, CarbonImmutable::MONDAY, 3)->toDateString(),
            CarbonImmutable::create($year, 5, 1)->toDateString(),
            CarbonImmutable::create($year, 9, 16)->toDateString(),
            self::nEsimoDiaSemanaDelMes($year, 11, CarbonImmutable::MONDAY, 3)->toDateString(),
            CarbonImmutable::create($year, 12, 25)->toDateString(),
        ];
    }

    private static function nEsimoDiaSemanaDelMes(int $year, int $month, int $diaSemana, int $n): CarbonImmutable
    {
        $fecha = CarbonImmutable::create($year, $month, 1);
        $offset = ($diaSemana - $fecha->dayOfWeekIso + 7) % 7;

        return $fecha->addDays($offset)->addWeeks($n - 1);
    }

    /**
     * Counts elapsed working days from fecha_inicio up to $hasta (inclusive) and returns
     * the resulting hours, capped at $metaHoras.
     */
    public static function horasAvance(CarbonImmutable $fechaInicio, CarbonImmutable $fechaFin, int $horasPorDia, int $metaHoras, ?CarbonImmutable $hoy = null): float
    {
        $hoy = $hoy ?? CarbonImmutable::today();

        if ($hoy->lt($fechaInicio)) {
            return 0.0;
        }

        $limite = $hoy->gt($fechaFin) ? $fechaFin : $hoy;

        $diasLaborables = 0;
        $fecha = $fechaInicio;
        while ($fecha->lte($limite)) {
            if (self::esDiaLaborable($fecha)) {
                $diasLaborables++;
            }
            $fecha = $fecha->addDay();
        }

        return (float) min($metaHoras, $diasLaborables * $horasPorDia);
    }

    /**
     * Finds the date on which the hours goal is reached, counting only working days
     * starting from (and including, if it's a working day) fecha_inicio.
     */
    public static function calcularFechaFin(CarbonImmutable $fechaInicio, int $horasPorDia, int $metaHoras): CarbonImmutable
    {
        $diasNecesarios = (int) ceil($metaHoras / $horasPorDia);

        $fecha = $fechaInicio;
        $contador = 0;

        while (true) {
            if (self::esDiaLaborable($fecha)) {
                $contador++;

                if ($contador >= $diasNecesarios) {
                    return $fecha;
                }
            }

            $fecha = $fecha->addDay();
        }
    }
}
