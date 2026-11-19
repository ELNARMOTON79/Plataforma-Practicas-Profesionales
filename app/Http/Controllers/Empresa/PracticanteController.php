<?php

namespace App\Http\Controllers\Empresa;

use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Models\Hora;
use App\Models\Solicitud;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * La unidad receptora consulta a sus practicantes y registra sus horas semanales.
 * Solo ve las solicitudes de las unidades receptoras ligadas a su cuenta.
 */
class PracticanteController extends Controller
{
    private const ESTATUS_VISIBLES = ['aprobada', 'en_proceso', 'finalizada'];

    public function index()
    {
        if (auth()->user()->rol_id != 4) {
            return redirect('/');
        }

        $solicitudes = $this->solicitudesDeLaEmpresa()
            ->with(['estudiante', 'unidadReceptora', 'documentos', 'horas'])
            ->orderByRaw("FIELD(estatus, 'en_proceso', 'aprobada', 'finalizada')")
            ->orderBy('fecha_inicio')
            ->get();

        $solicitudes->each->sincronizarEstatus();

        return view('empresa.practicantes', compact('solicitudes'));
    }

    public function show($id)
    {
        if (auth()->user()->rol_id != 4) {
            return redirect('/');
        }

        $solicitud = $this->solicitudesDeLaEmpresa()
            ->with(['estudiante', 'unidadReceptora', 'documentos'])
            ->findOrFail($id);

        $solicitud->sincronizarEstatus();

        return view('empresa.practicante', [
            'solicitud' => $solicitud,
            'semanas' => $solicitud->semanasDeRegistro()->reverse()->values(),
            'puedeRegistrar' => $this->puedeRegistrar($solicitud),
        ]);
    }

    /**
     * Registra (o corrige) las horas de una semana. Reemplaza lo que hubiera en esa semana.
     */
    public function registrarHoras(Request $request, $id)
    {
        if (auth()->user()->rol_id != 4) {
            return redirect('/');
        }

        $solicitud = $this->solicitudesDeLaEmpresa()->with('documentos')->findOrFail($id);

        if (! $this->puedeRegistrar($solicitud)) {
            return back()->with('error', 'Aún no se pueden registrar horas: el coordinador debe validar los documentos iniciales del alumno.');
        }

        $data = $request->validate([
            'semana' => ['required', 'date_format:Y-m-d'],
            'horas'  => ['required', 'numeric', 'min:0', 'max:60', 'decimal:0,2'],
        ], [
            'horas.required' => 'Indica las horas de la semana.',
            'horas.numeric'  => 'Las horas deben ser un número.',
            'horas.min'      => 'Las horas no pueden ser negativas.',
            'horas.max'      => 'Una semana no puede tener más de 60 horas.',
            'horas.decimal'  => 'Usa como máximo dos decimales.',
        ]);

        $lunes = CarbonImmutable::parse($data['semana'])->startOfWeek(CarbonImmutable::MONDAY);
        $semana = $solicitud->semanasDeRegistro()->first(fn ($s) => $s['inicio']->equalTo($lunes));

        if (! $semana) {
            return back()->with('error', 'Esa semana está fuera del periodo de prácticas del alumno.');
        }

        DB::transaction(function () use ($solicitud, $semana, $data) {
            // Una sola fila por semana: se reemplazan los registros previos de esos días
            Hora::where('solicitud_id', $solicitud->id)
                ->whereBetween('fecha_registro', [$semana['inicio']->toDateString(), $semana['fin']->toDateString()])
                ->delete();

            Hora::create([
                'solicitud_id'   => $solicitud->id,
                'fecha_registro' => $semana['inicio']->toDateString(),
                'cantidad_horas' => $data['horas'],
            ]);
        });

        $solicitud->unsetRelation('horas');

        // Si una corrección baja las horas por debajo de la meta, la práctica vuelve a estar en proceso
        if ($solicitud->estatus === 'finalizada' && $solicitud->horasCompletadas() < $solicitud->horasMeta()) {
            $solicitud->estatus = 'en_proceso';
            $solicitud->save();
        }

        $solicitud->sincronizarEstatus();

        $alumno = $solicitud->estudiante?->nombre_completo ?? 'alumno';
        $rango = $semana['inicio']->format('d/m/Y') . ' - ' . $semana['fin']->format('d/m/Y');

        ActivityLogger::log(
            'Horas',
            $semana['registradas'] === null ? 'Horas Registradas' : 'Horas Corregidas',
            "Se registraron {$data['horas']} horas para {$alumno} en la semana {$rango}.",
            'info',
            ['solicitud_id' => $solicitud->id, 'semana' => $semana['inicio']->toDateString(), 'horas' => (float) $data['horas'], 'anteriores' => $semana['registradas']]
        );

        return back()->with('success', "Horas de la semana {$rango} guardadas: {$data['horas']} h.");
    }

    private function solicitudesDeLaEmpresa()
    {
        return Solicitud::query()
            ->whereIn('estatus', self::ESTATUS_VISIBLES)
            ->whereHas('unidadReceptora', fn ($q) => $q->where('usuario_id', auth()->id()));
    }

    private function puedeRegistrar(Solicitud $solicitud): bool
    {
        return in_array($solicitud->estatus, ['en_proceso', 'finalizada'], true)
            && $solicitud->documentosInicialesValidados();
    }
}
