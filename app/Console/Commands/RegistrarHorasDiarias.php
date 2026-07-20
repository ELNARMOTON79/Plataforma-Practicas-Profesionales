<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Solicitud;
use App\Models\Hora;
use Carbon\Carbon;
use App\Http\Controllers\Estudiante\DashboardController;

#[Signature('app:registrar-horas-diarias')]
#[Description('Registra 6 horas diarias automáticamente a los alumnos activos')]
class RegistrarHorasDiarias extends Command
{
    /**
     * Días festivos fijos (Mes-Día) y dinámicos (calculados).
     * Puedes agregar más fechas aquí.
     */
    private function esDiaFestivo(Carbon $fecha): bool
    {
        $festivos = [
            '01-01', // Año Nuevo
            '02-05', // Día de la Constitución (Referencia, usualmente 1er lunes de febrero)
            '03-21', // Natalicio de Benito Juárez (Referencia, usualmente 3er lunes de marzo)
            '05-01', // Día del Trabajo
            '09-16', // Día de la Independencia
            '11-20', // Revolución Mexicana (Referencia, usualmente 3er lunes de noviembre)
            '12-25', // Navidad
        ];

        // Festivos dinámicos de México
        // 1er lunes de febrero
        $primerLunesFebrero = Carbon::parse('first monday of February ' . $fecha->year);
        if ($fecha->isSameDay($primerLunesFebrero)) return true;

        // 3er lunes de marzo
        $tercerLunesMarzo = Carbon::parse('third monday of March ' . $fecha->year);
        if ($fecha->isSameDay($tercerLunesMarzo)) return true;

        // 3er lunes de noviembre
        $tercerLunesNoviembre = Carbon::parse('third monday of November ' . $fecha->year);
        if ($fecha->isSameDay($tercerLunesNoviembre)) return true;

        return in_array($fecha->format('m-d'), $festivos);
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hoy = Carbon::now();

        // 1. Validar fin de semana
        if ($hoy->isWeekend()) {
            $this->info("Hoy es fin de semana ({$hoy->format('Y-m-d')}). No se registran horas.");
            return;
        }

        // 2. Validar día festivo
        if ($this->esDiaFestivo($hoy)) {
            $this->info("Hoy es día festivo ({$hoy->format('Y-m-d')}). No se registran horas.");
            return;
        }

        $this->info("Iniciando registro de horas diarias para el día {$hoy->format('Y-m-d')}.");

        // 3. Obtener solicitudes activas
        $solicitudesActivas = Solicitud::whereIn('estatus', ['aprobada', 'en_proceso'])
            ->where('fecha_inicio', '<=', $hoy->toDateString())
            ->where('fecha_fin', '>=', $hoy->toDateString())
            ->get();

        $metaHoras = DashboardController::HORAS_META;
        $horasDiarias = 6;
        $countRegistros = 0;

        foreach ($solicitudesActivas as $solicitud) {
            $horasAcumuladas = Hora::where('solicitud_id', $solicitud->id)->sum('cantidad_horas');

            if ($horasAcumuladas >= $metaHoras) {
                // Ya completó sus horas
                if ($solicitud->estatus !== 'finalizada') {
                    $solicitud->estatus = 'finalizada';
                    $solicitud->save();
                    $this->info("Solicitud ID {$solicitud->id} marcada como finalizada al alcanzar {$metaHoras} horas.");
                }
                continue;
            }

            // Calcular cuántas horas puede registrar sin pasarse de la meta
            $horasFaltantes = $metaHoras - $horasAcumuladas;
            $horasARegistrar = min($horasDiarias, $horasFaltantes);

            if ($horasARegistrar > 0) {
                Hora::create([
                    'solicitud_id' => $solicitud->id,
                    'fecha_registro' => $hoy->toDateString(),
                    'cantidad_horas' => $horasARegistrar,
                ]);
                $countRegistros++;
            }
        }

        $this->info("Proceso completado. Se registraron horas para {$countRegistros} estudiantes activos.");
    }
}
