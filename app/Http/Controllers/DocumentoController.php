<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    /**
     * Muestra el archivo de un documento solo a quien tiene permiso:
     * administradores, coordinadores y el estudiante dueño de la solicitud.
     */
    public function archivo($id)
    {
        $user = Auth::user();
        $documento = Documento::with('solicitud.estudiante')->findOrFail($id);

        $esPersonal = in_array((int) $user->rol_id, [1, 2], true);
        $esDueno = (int) $user->rol_id === 3
            && (int) ($documento->solicitud?->estudiante?->usuario_id) === (int) $user->id;

        if (! $esPersonal && ! $esDueno) {
            abort(403, 'No tienes permiso para ver este documento.');
        }

        $disco = Documento::discoDeArchivo($documento->ruta_archivo);

        if (! $disco) {
            abort(404, 'El archivo no se encuentra en el servidor.');
        }

        // inline: el coordinador lo previsualiza en un iframe
        return Storage::disk($disco)->response($documento->ruta_archivo, basename($documento->ruta_archivo), [], 'inline');
    }
}
