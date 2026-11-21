<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use App\Models\Solicitud;
use App\Models\UnidadReceptora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitudController extends Controller
{
    /**
     * Solicitudes page. Lists the students who already work at the company so it can
     * set the dates and daily hours written in their project document.
     */
    public function index()
    {
        if (Auth::user()->rol_id != 4) {
            return redirect('/');
        }

        $alumnosLaborando = $this->solicitudesYaLabora()
            ->with(['estudiante', 'unidadReceptora'])
            ->orderByRaw('fecha_inicio IS NOT NULL')
            ->orderByDesc('id')
            ->get();

        $proyectos = Proyecto::whereIn('estudiante_id', $alumnosLaborando->pluck('estudiante_id'))
            ->get()
            ->keyBy('estudiante_id');

        return view('empresa.solicitudes', [
            'alumnosLaborando' => $alumnosLaborando,
            'proyectosAlumnos' => $proyectos,
        ]);
    }

    /**
     * Saves the start/end dates and daily hours defined by the company.
     */
    public function definirPeriodo(Request $request, $id)
    {
        if (Auth::user()->rol_id != 4) {
            return redirect('/');
        }

        $solicitud = $this->solicitudesYaLabora()->findOrFail($id);

        $validated = $request->validate([
            'fecha_inicio'  => ['required', 'date'],
            'fecha_fin'     => ['required', 'date', 'after:fecha_inicio'],
            'horas_por_dia' => ['required', 'integer', 'min:1', 'max:12'],
        ], [
            'fecha_inicio.required'  => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date'      => 'La fecha de inicio no es válida.',
            'fecha_fin.required'     => 'La fecha de fin es obligatoria.',
            'fecha_fin.date'         => 'La fecha de fin no es válida.',
            'fecha_fin.after'        => 'La fecha de fin debe ser posterior a la fecha de inicio.',
            'horas_por_dia.required' => 'Indica las horas por día.',
            'horas_por_dia.min'      => 'Las horas por día deben ser al menos 1.',
            'horas_por_dia.max'      => 'Las horas por día no pueden ser más de 12.',
        ]);

        $solicitud->update($validated);
        $solicitud->sincronizarEstatus();

        $nombre = $solicitud->estudiante?->nombre_completo ?? 'el alumno';

        return redirect()->route('empresa.solicitudes')
            ->with('success', "Fechas y horario de {$nombre} guardados correctamente.");
    }

    /**
     * Requests from students who already work at one of this company's receiving units.
     */
    private function solicitudesYaLabora()
    {
        $urIds = UnidadReceptora::where('usuario_id', Auth::id())->pluck('id');

        return Solicitud::whereIn('ur_id', $urIds)
            ->where('ya_labora', true)
            ->whereIn('estatus', ['pendiente', 'aprobada', 'en_proceso', 'finalizada']);
    }
}
