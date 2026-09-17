<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        if (auth()->check() && auth()->user()->rol_id != 2) {
            return redirect('/');
        }

        $estudiantesActivos = DB::table('estudiantes')->count();

        // Calcular porcentaje dinámico de estudiantes con práctica o trámite registrado
        $estudiantesConPractica = DB::table('estudiantes')
            ->where('activo_practica', 1)
            ->orWhereExists(function ($q) {
                $q->select(DB::raw(1))
                    ->from('solicitudes')
                    ->whereColumn('solicitudes.estudiante_id', 'estudiantes.id');
            })
            ->count();

        $porcentajeActivos = $estudiantesActivos > 0 ? round(($estudiantesConPractica / $estudiantesActivos) * 100) : 0;

        $instituciones = DB::table('unidades_receptoras')->count();
        $tramitesPendientes = DB::table('solicitudes')->where('estatus', 'pendiente')->count();
        $proyectosActivos = DB::table('proyectos')->where('activo', 1)->count();

        // Fetch recent documents uploaded by students
        $ultimosDocumentos = \App\Models\Documento::with(['solicitud.estudiante', 'solicitud.unidadReceptora'])
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();
        
        // Fetch pending solicitudes (applications)
        $pendingSolicitudes = \App\Models\Solicitud::with(['estudiante', 'unidadReceptora'])
            ->where('estatus', 'pendiente')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        // Fetch pending documents (documentos)
        $pendingDocumentos = \App\Models\Documento::with(['solicitud.estudiante'])
            ->where('estatus', 'pendiente')
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        // Merge them into a single collection of pending tasks
        $pendientes = collect();

        foreach ($pendingSolicitudes as $solicitud) {
            $pendientes->push((object)[
                'id' => 'sol-' . $solicitud->id,
                'estudiante' => $solicitud->estudiante,
                'tipo' => 'solicitud',
                'detalle' => $solicitud->unidadReceptora->nombre_empresa ?? 'No especificada',
                'badge_text' => 'Solicitud Prácticas',
                'badge_class' => 'bg-amber-50 text-amber-700 border-amber-200',
                'link' => route('coordinador.tramites'),
                'accion_label' => 'Revisar',
                'fecha' => $solicitud->fecha_inicio
            ]);
        }

        foreach ($pendingDocumentos as $documento) {
            $pendientes->push((object)[
                'id' => 'doc-' . $documento->id,
                'estudiante' => $documento->solicitud->estudiante ?? null,
                'tipo' => 'documento',
                'detalle' => 'Validar: ' . $documento->nombre_doc,
                'badge_text' => 'Documento Pendiente',
                'badge_class' => 'bg-blue-50 text-blue-700 border-blue-200',
                'link' => route('coordinador.tramites'),
                'accion_label' => 'Validar',
                'fecha' => $documento->fecha_carga
            ]);
        }

        // Sort by date/timestamp descending to get the most recent ones first
        $pendientesPorAtender = $pendientes->sortByDesc(function($item) {
            return $item->fecha ? $item->fecha->timestamp : 0;
        })->take(5);

        return view('coordinador.dashboard', compact(
            'estudiantesActivos',
            'porcentajeActivos',
            'instituciones',
            'tramitesPendientes',
            'proyectosActivos',
            'ultimosDocumentos',
            'pendientesPorAtender'
        ));
    }
}
