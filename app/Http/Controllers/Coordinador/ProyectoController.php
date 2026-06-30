<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Proyecto;

class ProyectoController extends Controller
{
    /**
     * Display projects catalog.
     */
    public function proyectos(Request $request)
    {
        if (auth()->user()->rol_id != 2) {
            return redirect('/');
        }

        $search = $request->input('search');
        if ($search) {
            // Strip any invalid characters
            $search = preg_replace('/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s@.]/u', '', $search);
        }
        $plan = $request->input('plan');
        $cupo = $request->input('cupo');
        $acceso = $request->input('acceso');
        $perPage = $request->input('per_page', 5);

        if (!in_array($perPage, [5, 10, 25, 50, 100])) {
            $perPage = 5;
        }

        $query = Proyecto::with('empresa');

        // Apply Search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%")
                  ->orWhereHas('empresa', function($qe) use ($search) {
                      $qe->where('nombre_empresa', 'like', "%{$search}%");
                  });
            });
        }

        // Apply Plan Filter
        if ($plan) {
            $query->where('plan', $plan);
        }

        // Apply Cupo Filter
        if ($cupo === 'disponible') {
            $query->whereRaw('cupos_ocupados < cupos_totales');
        } elseif ($cupo === 'lleno') {
            $query->whereRaw('cupos_ocupados >= cupos_totales');
        }

        // Apply Acceso (activo) Filter
        if ($acceso) {
            $query->where('activo', $acceso === 'activo');
        }

        $proyectos = $query->paginate($perPage);

        $unidadesReceptoras = DB::table('unidades_receptoras')
            ->select('id', 'nombre_empresa')
            ->orderBy('nombre_empresa', 'asc')
            ->get();

        return view('coordinador.proyectos', compact('proyectos', 'unidadesReceptoras'));
    }

    /**
     * Stores a new project in the database.
     */
    public function storeProyecto(Request $request)
    {
        if (auth()->user()->rol_id != 2) {
            return redirect('/');
        }

        $request->validate([
            'unidad_receptora_id' => ['required', 'integer', 'exists:unidades_receptoras,id'],
            'titulo'              => ['required', 'string', 'max:255'],
            'objetivo'            => ['required', 'string'],
            'justificacion'       => ['required', 'string'],
            'actividades'         => ['required', 'string'],
            'impacto_social'      => ['required', 'string'],
            'tipo_proyecto'       => ['required', 'string', 'max:150'],
            'tipo_modalidad'      => ['required', 'string', 'max:150'],
            'publico_internet'    => ['required', 'in:SI,NO'],
        ], [
            'unidad_receptora_id.required' => 'La unidad receptora es requerida.',
            'unidad_receptora_id.exists'   => 'La unidad receptora seleccionada no es válida.',
            'titulo.required'              => 'El título del proyecto es requerido.',
            'objetivo.required'            => 'El objetivo es requerido.',
            'justificacion.required'       => 'La justificación es requerida.',
            'actividades.required'         => 'Las actividades son requeridas.',
            'impacto_social.required'      => 'El impacto social es requerido.',
            'tipo_proyecto.required'       => 'El tipo de proyecto es requerido.',
            'tipo_modalidad.required'      => 'El tipo de modalidad es requerido.',
            'publico_internet.required'    => 'Especifica si es público para internet.',
        ]);

        $proyecto = Proyecto::create([
            'unidad_receptora_id' => $request->input('unidad_receptora_id'),
            'titulo'              => $request->input('titulo'),
            'objetivo'            => $request->input('objetivo'),
            'justificacion'       => $request->input('justificacion'),
            'actividades'         => $request->input('actividades'),
            'impacto_social'      => $request->input('impacto_social'),
            'tipo_proyecto'       => $request->input('tipo_proyecto'),
            'tipo_modalidad'      => $request->input('tipo_modalidad'),
            'publico_internet'    => $request->input('publico_internet'),
            'plan'                => 'E906', // Default plan
            'ciclo_escolar'       => 'AGO-2026/ENE-2027', // Default cycle
            'cupos_totales'       => 3, // Default total spots
            'cupos_ocupados'      => 0, // Default filled spots
            'activo'              => true, // Default active status
        ]);

        $urName = DB::table('unidades_receptoras')
            ->where('id', $proyecto->unidad_receptora_id)
            ->value('nombre_empresa');

        return redirect()->back()
            ->with('success', "Proyecto \"{$proyecto->titulo}\" (ID #{$proyecto->id}) registrado correctamente para la unidad receptora \"{$urName}\" en la base de datos.");
    }

    /**
     * Updates an existing project in the database.
     */
    public function updateProyecto(Request $request, $id)
    {
        if (auth()->user()->rol_id != 2) {
            return redirect('/');
        }

        $proyecto = Proyecto::findOrFail($id);

        try {
            $request->validate([
                'unidad_receptora_id' => ['required', 'integer', 'exists:unidades_receptoras,id'],
                'titulo'              => ['required', 'string', 'max:255'],
                'objetivo'            => ['required', 'string'],
                'justificacion'       => ['required', 'string'],
                'actividades'         => ['required', 'string'],
                'impacto_social'      => ['required', 'string'],
                'tipo_proyecto'       => ['required', 'string', 'max:150'],
                'tipo_modalidad'      => ['required', 'string', 'max:150'],
                'publico_internet'    => ['required', 'in:SI,NO'],
            ], [
                'unidad_receptora_id.required' => 'La unidad receptora es requerida.',
                'unidad_receptora_id.exists'   => 'La unidad receptora seleccionada no es válida.',
                'titulo.required'              => 'El título del proyecto es requerido.',
                'objetivo.required'            => 'El objetivo es requerido.',
                'justificacion.required'       => 'La justificación es requerida.',
                'actividades.required'         => 'Las actividades son requeridas.',
                'impacto_social.required'      => 'El impacto social es requerido.',
                'tipo_proyecto.required'       => 'El tipo de proyecto es requerido.',
                'tipo_modalidad.required'      => 'El tipo de modalidad es requerido.',
                'publico_internet.required'    => 'Especifica si es público para internet.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('edit_proyecto_id', $id);
        }

        $proyecto->update([
            'unidad_receptora_id' => $request->input('unidad_receptora_id'),
            'titulo'              => $request->input('titulo'),
            'objetivo'            => $request->input('objetivo'),
            'justificacion'       => $request->input('justificacion'),
            'actividades'         => $request->input('actividades'),
            'impacto_social'      => $request->input('impacto_social'),
            'tipo_proyecto'       => $request->input('tipo_proyecto'),
            'tipo_modalidad'      => $request->input('tipo_modalidad'),
            'publico_internet'    => $request->input('publico_internet'),
        ]);

        $urName = DB::table('unidades_receptoras')
            ->where('id', $proyecto->unidad_receptora_id)
            ->value('nombre_empresa');

        return redirect()->back()
            ->with('success', "Proyecto ID #{$proyecto->id} (\"{$proyecto->titulo}\") actualizado correctamente para la unidad receptora \"{$urName}\" en la base de datos.");
    }

    /**
     * Toggles the active status of a project.
     */
    public function toggleProyectoStatus($id)
    {
        if (auth()->user()->rol_id != 2) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $proyecto = Proyecto::findOrFail($id);
        $proyecto->activo = !$proyecto->activo;
        $proyecto->save();

        return response()->json([
            'success' => true,
            'id' => $proyecto->id,
            'activo' => $proyecto->activo
        ]);
    }
}
