<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use App\Models\Documento;
use App\Models\Solicitud;
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

        $searchSolicitudes = $request->input('search_solicitudes');
        $searchDocumentos  = $request->input('search_documentos');

        // Solicitudes Query
        $solicitudesQuery = Solicitud::with(['estudiante.usuario', 'unidadReceptora'])
            ->orderBy('id', 'desc');

        if ($searchSolicitudes) {
            $solicitudesQuery->where(function($q) use ($searchSolicitudes) {
                $q->whereHas('estudiante', function($qEst) use ($searchSolicitudes) {
                    $qEst->where('nombre_completo', 'like', "%{$searchSolicitudes}%")
                         ->orWhere('matricula', 'like', "%{$searchSolicitudes}%");
                })
                ->orWhereHas('unidadReceptora', function($qUr) use ($searchSolicitudes) {
                    $qUr->where('nombre_empresa', 'like', "%{$searchSolicitudes}%");
                });
            });
        }

        $solicitudes = $solicitudesQuery->get();

        // Documentos Query
        $documentosPendientesQuery = Documento::with(['solicitud.estudiante.usuario'])
            ->where('estatus', 'pendiente')
            ->orderBy('id', 'desc');

        if ($searchDocumentos) {
            $documentosPendientesQuery->where(function($q) use ($searchDocumentos) {
                $q->where('nombre_doc', 'like', "%{$searchDocumentos}%")
                  ->orWhereHas('solicitud.estudiante', function($qEst) use ($searchDocumentos) {
                      $qEst->where('nombre_completo', 'like', "%{$searchDocumentos}%")
                           ->orWhere('matricula', 'like', "%{$searchDocumentos}%");
                  });
            });
        }

        $documentosPendientes = $documentosPendientesQuery->get();

        $documentosValidados = Documento::with(['solicitud.estudiante.usuario'])
            ->where('estatus', 'validado')
            ->orderBy('id', 'desc')
            ->get();

        // Calculate counts
        $solicitudesPendientesCount = Solicitud::where('estatus', 'pendiente')->count();
        $documentosPendientesCount  = Documento::where('estatus', 'pendiente')->count();
        $documentosValidadosCount   = Documento::where('estatus', 'validado')->count();
        $totalTramitesCount         = Solicitud::count() + Documento::count();

        return view('coordinador.tramites', compact(
            'solicitudes',
            'documentosPendientes',
            'documentosValidados',
            'solicitudesPendientesCount',
            'documentosPendientesCount',
            'documentosValidadosCount',
            'totalTramitesCount'
        ));
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
            $solicitud->observaciones = $request->input('observaciones');
        }
        
        $solicitud->save();

        // Mark student as active in practices
        if ($solicitud->estudiante) {
            $solicitud->estudiante->update(['activo_practica' => 1]);
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

        if ($request->filled('observaciones')) {
            $solicitud->observaciones = $request->input('observaciones');
        }

        $solicitud->save();

        return redirect()->back()->with('success', 'Solicitud rechazada correctamente.');
    }
}
