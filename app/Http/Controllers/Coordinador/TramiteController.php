<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use App\Models\Documento;
use App\Models\Proyecto;
use App\Models\Solicitud;
use App\Support\NotificadorAlumno;
use Illuminate\Http\Request;

class TramiteController extends Controller
{
    /**
     * Display the coordinator tramites dashboard (solicitudes & documentos).
     */
    public function tramites(Request $request)
    {
        if (auth()->check() && auth()->user()->rol_id != 2) {
            return redirect('/');
        }

        // Solo se consulta y pinta la pestaña activa, paginada en el servidor
        $tabsValidas = ['solicitudes', 'solicitudes-todas', 'proyectos-pendientes', 'doc-pendientes', 'doc-validados'];
        $activeTab = in_array($request->input('tab'), $tabsValidas, true) ? $request->input('tab') : 'solicitudes';
        $search = trim((string) ($request->input('search') ?? $request->input('search_solicitudes') ?? $request->input('search_documentos') ?? ''));
        $porPagina = 10;

        $solicitudes = collect();
        $proyectosPendientes = collect();
        $documentosPendientes = collect();
        $documentosValidados = collect();

        if (in_array($activeTab, ['solicitudes', 'solicitudes-todas'], true)) {
            $solicitudesQuery = Solicitud::with(['estudiante', 'unidadReceptora'])
                ->when($activeTab === 'solicitudes',
                    fn ($q) => $q->where('estatus', 'pendiente'),
                    fn ($q) => $q->whereIn('estatus', ['aprobada', 'en_proceso', 'finalizada']))
                ->orderBy('id', 'desc');

            if ($search !== '') {
                $solicitudesQuery->where(function ($q) use ($search) {
                    $q->whereHas('estudiante', function ($qEst) use ($search) {
                        $qEst->where('nombre_completo', 'like', "%{$search}%")
                             ->orWhere('matricula', 'like', "%{$search}%");
                    })
                    ->orWhereHas('unidadReceptora', function ($qUr) use ($search) {
                        $qUr->where('nombre_empresa', 'like', "%{$search}%");
                    });
                });
            }

            $solicitudes = $solicitudesQuery->paginate($porPagina)->withQueryString();
        } elseif ($activeTab === 'proyectos-pendientes') {
            // Propuestas de proyecto de estudiantes pendientes de revisión
            $proyectosQuery = Proyecto::with(['estudiante', 'empresa'])
                ->where('estatus', 'pendiente')
                ->orderBy('id', 'desc');

            if ($search !== '') {
                $proyectosQuery->where(function ($q) use ($search) {
                    $q->where('titulo', 'like', "%{$search}%")
                      ->orWhereHas('estudiante', function ($qEst) use ($search) {
                          $qEst->where('nombre_completo', 'like', "%{$search}%")
                               ->orWhere('matricula', 'like', "%{$search}%");
                      })
                      ->orWhereHas('empresa', function ($qEmp) use ($search) {
                          $qEmp->where('nombre_empresa', 'like', "%{$search}%");
                      });
                });
            }

            $proyectosPendientes = $proyectosQuery->paginate($porPagina)->withQueryString();
        } else {
            $documentosQuery = Documento::with(['solicitud.estudiante'])
                ->when($activeTab === 'doc-pendientes',
                    fn ($q) => $q->where('estatus', 'pendiente'),
                    fn ($q) => $q->whereIn('estatus', ['validado', 'aprobado']))
                ->orderBy('id', 'desc');

            if ($search !== '') {
                $documentosQuery->where(function ($q) use ($search) {
                    $q->where('nombre_doc', 'like', "%{$search}%")
                      ->orWhereHas('solicitud.estudiante', function ($qEst) use ($search) {
                          $qEst->where('nombre_completo', 'like', "%{$search}%")
                               ->orWhere('matricula', 'like', "%{$search}%");
                      });
                });
            }

            $paginados = $documentosQuery->paginate($porPagina)->withQueryString();
            if ($activeTab === 'doc-pendientes') {
                $documentosPendientes = $paginados;
            } else {
                $documentosValidados = $paginados;
            }
        }

        // Calculate counts
        $solicitudesPendientesCount = Solicitud::where('estatus', 'pendiente')->count();
        $proyectosPendientesCount   = Proyecto::where('estatus', 'pendiente')->count();
        $documentosPendientesCount  = Documento::where('estatus', 'pendiente')->count();
        $documentosValidadosCount   = Documento::whereIn('estatus', ['validado', 'aprobado'])->count();
        $solicitudesAprobadasCount  = Solicitud::whereIn('estatus', ['aprobada', 'en_proceso', 'finalizada'])->count();

        return view('coordinador.tramites', compact(
            'activeTab',
            'search',
            'solicitudes',
            'proyectosPendientes',
            'proyectosPendientesCount',
            'documentosPendientes',
            'documentosValidados',
            'solicitudesPendientesCount',
            'documentosPendientesCount',
            'documentosValidadosCount',
            'solicitudesAprobadasCount'
        ));
    }

    /**
     * Approve a student's project proposal.
     */
    public function aprobarProyecto(Request $request, $id)
    {
        if (auth()->check() && auth()->user()->rol_id != 2) {
            return redirect('/');
        }

        $proyecto = Proyecto::findOrFail($id);
        $proyecto->estatus = 'aprobado';

        if ($request->filled('observaciones')) {
            $request->validate(['observaciones' => 'nullable|string|max:500']);
            $proyecto->observaciones = strip_tags(trim($request->input('observaciones')));
        } else {
            $proyecto->observaciones = null;
        }

        $proyecto->save();

        if ($proyecto->wasChanged('estatus')) {
            NotificadorAlumno::proyecto($proyecto);
        }

        return redirect()->back()->with('success', "Proyecto \"{$proyecto->titulo}\" aprobado correctamente e incorporado al catálogo.");
    }

    /**
     * Reject a student's project proposal.
     */
    public function rechazarProyecto(Request $request, $id)
    {
        if (auth()->check() && auth()->user()->rol_id != 2) {
            return redirect('/');
        }

        $proyecto = Proyecto::findOrFail($id);
        $proyecto->estatus = 'rechazado';

        $request->validate([
            'observaciones' => 'required|string|max:500'
        ], [
            'observaciones.required' => 'Indica el motivo del rechazo para que el alumno pueda corregir su proyecto.',
            'observaciones.max'      => 'El motivo no debe superar los 500 caracteres.'
        ]);

        $proyecto->observaciones = strip_tags(trim($request->input('observaciones')));
        $proyecto->save();

        if ($proyecto->wasChanged('estatus')) {
            NotificadorAlumno::proyecto($proyecto);
        }

        return redirect()->back()->with('success', "Proyecto \"{$proyecto->titulo}\" rechazado. El alumno podrá corregirlo y reenviarlo.");
    }

    /**
     * Approve a student's practice solicitud.
     */
    public function aprobarSolicitud(Request $request, $id)
    {
        if (auth()->check() && auth()->user()->rol_id != 2) {
            return redirect('/');
        }

        $solicitud = Solicitud::findOrFail($id);
        $solicitud->estatus = 'aprobada';
        
        if ($request->filled('observaciones')) {
            $request->validate(['observaciones' => 'string|max:500']);
            $solicitud->observaciones = strip_tags(trim($request->input('observaciones')));
        }
        
        $solicitud->save();

        // Mark student as active in practices
        if ($solicitud->estudiante) {
            $solicitud->estudiante->update(['activo_practica' => 1]);
        }

        if ($solicitud->wasChanged('estatus')) {
            NotificadorAlumno::solicitud($solicitud);
        }

        return redirect()->back()->with('success', 'Solicitud aprobada correctamente.');
    }

    /**
     * Reject a student's practice solicitud.
     */
    public function rechazarSolicitud(Request $request, $id)
    {
        if (auth()->check() && auth()->user()->rol_id != 2) {
            return redirect('/');
        }

        $solicitud = Solicitud::findOrFail($id);
        $solicitud->estatus = 'rechazada';

        // Siempre se reemplaza: así el estudiante no ve su propio texto como motivo de rechazo
        $request->validate(['observaciones' => 'nullable|string|max:500']);
        $solicitud->observaciones = $request->filled('observaciones')
            ? strip_tags(trim($request->input('observaciones')))
            : null;

        $solicitud->save();

        if ($solicitud->wasChanged('estatus')) {
            NotificadorAlumno::solicitud($solicitud);
        }

        return redirect()->back()->with('success', 'Solicitud rechazada correctamente.');
    }

    /**
     * Validate/Approve a student's document.
     */
    public function validarDocumento(Request $request, $id)
    {
        if (auth()->check() && auth()->user()->rol_id != 2) {
            return redirect('/');
        }

        $documento = Documento::findOrFail($id);
        $documento->estatus = 'validado';

        if ($request->filled('observaciones')) {
            $request->validate(['observaciones' => 'string|max:500']);
            $documento->observaciones = strip_tags(trim($request->input('observaciones')));
        }

        $documento->save();

        if ($documento->wasChanged('estatus')) {
            NotificadorAlumno::documento($documento);
        }

        return redirect()->back()->with('success', 'Documento validado correctamente.');
    }

    /**
     * Reject a student's document.
     */
    public function rechazarDocumento(Request $request, $id)
    {
        if (auth()->check() && auth()->user()->rol_id != 2) {
            return redirect('/');
        }

        $documento = Documento::findOrFail($id);
        $documento->estatus = 'rechazado';

        if ($request->filled('observaciones')) {
            $request->validate(['observaciones' => 'string|max:500']);
            $documento->observaciones = strip_tags(trim($request->input('observaciones')));
        }

        $documento->save();

        if ($documento->wasChanged('estatus')) {
            NotificadorAlumno::documento($documento);
        }

        return redirect()->back()->with('success', 'Documento rechazado.');
    }
}
