<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class CoordinadorController extends Controller
{
    public function dashboard()
    {
        if (auth()->check() && auth()->user()->rol_id != 2) {
            return redirect('/');
        }

        // Al no tener datos aún, estas consultas devolverán 0, ¡lo cual es correcto!
        // Estamos usando la fachada DB (Query Builder) que consulta directamente a la tabla sin necesidad de modelos por ahora.
        
        $estudiantesActivos = DB::table('estudiantes')->count();
        $instituciones = DB::table('unidades_receptoras')->count();
        $tramitesPendientes = DB::table('solicitudes')->count(); // Puedes ajustar esta tabla luego
        $proyectosActivos = DB::table('convenios')->count(); // Ajusta según la tabla correcta

        return view('coordinador.dashboard', compact(
            'estudiantesActivos', 
            'instituciones', 
            'tramitesPendientes', 
            'proyectosActivos'
        ));
    }
}
