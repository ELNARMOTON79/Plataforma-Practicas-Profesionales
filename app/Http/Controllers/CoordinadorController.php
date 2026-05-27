<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Alumno;
use App\Mail\CredentialsNotification;

class CoordinadorController extends Controller
{
    public function dashboard()
    {
        if (auth()->check() && auth()->user()->rol_id != 2) {
            return redirect('/');
        }

        $estudiantesActivos = DB::table('estudiantes')->count();
        $instituciones = DB::table('unidades_receptoras')->count();
        $tramitesPendientes = DB::table('solicitudes')->count();
        $proyectosActivos = DB::table('convenios')->count();

        return view('coordinador.dashboard', compact(
            'estudiantesActivos',
            'instituciones',
            'tramitesPendientes',
            'proyectosActivos'
        ));
    }

    /**
     * List, search, filter and paginate students.
     */
    public function alumnos(Request $request)
    {
        if (auth()->user()->rol_id != 2) {
            return redirect('/');
        }

        $search = $request->input('search');
        if ($search) {
            // Strip any invalid characters
            $search = preg_replace('/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s@.]/u', '', $search);
        }
        $carrera = $request->input('carrera');
        $estatus = $request->input('estatus');
        $perPage = $request->input('per_page', 5);

        if (!in_array($perPage, [5, 10, 25, 50, 100])) {
            $perPage = 5;
        }

        $query = Alumno::with('user');

        // Search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nombre_completo', 'like', "%{$search}%")
                  ->orWhere('matricula', 'like', "%{$search}%")
                  ->orWhere('carrera', 'like', "%{$search}%")
                  ->orWhereHas('user', function($qu) use ($search) {
                      $qu->where('correo', 'like', "%{$search}%");
                  });
            });
        }

        // Carrera filter
        if ($carrera) {
            $query->where('carrera', $carrera);
        }

        // Estatus filter
        if ($estatus) {
            if ($estatus === 'activo') {
                $query->where('activo_practica', 1)
                      ->whereHas('user', function($qu) {
                          $qu->where('activo', 1);
                      });
            } elseif ($estatus === 'inactivo') {
                $query->whereHas('user', function($qu) {
                    $qu->where('activo', 0);
                });
            } elseif ($estatus === 'asignado') {
                $query->where('activo_practica', 0)
                      ->whereHas('user', function($qu) {
                          $qu->where('activo', 1);
                      })
                      ->whereExists(function ($qex) {
                          $qex->select(\DB::raw(1))
                              ->from('solicitudes')
                              ->whereColumn('solicitudes.estudiante_id', 'estudiantes.id')
                              ->whereIn('solicitudes.estatus', ['aprobada', 'en_proceso', 'finalizada']);
                      });
            } elseif ($estatus === 'pendiente') {
                $query->where('activo_practica', 0)
                      ->whereHas('user', function($qu) {
                          $qu->where('activo', 1);
                      })
                      ->where(function ($qor) {
                          $qor->whereNotExists(function ($qex) {
                              $qex->select(\DB::raw(1))
                                  ->from('solicitudes')
                                  ->whereColumn('solicitudes.estudiante_id', 'estudiantes.id')
                                  ->whereIn('solicitudes.estatus', ['aprobada', 'en_proceso', 'finalizada']);
                          });
                      });
            }
        }

        $alumnos = $query->paginate($perPage);

        // Get unique careers for dynamic select
        $carrerasDisponibles = Alumno::distinct()->pluck('carrera')->filter()->values();

        return view('coordinador.alumnos', compact('alumnos', 'carrerasDisponibles'));
    }


    /**
     * Register a new student (alumno) from the coordinator dashboard.
     */
    public function storeAlumno(Request $request)
    {
        if (auth()->user()->rol_id != 2) {
            return redirect('/');
        }

        $request->validate([
            'nombre'    => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/u'],
            'correo'    => ['required', 'email', 'max:255', 'unique:usuarios,correo'],
            'matricula' => ['required', 'string', 'max:50', 'unique:estudiantes,matricula', 'regex:/^[0-9]+$/'],
            'carrera'   => ['required', 'string', 'max:150'],
            'semestre'  => ['required', 'integer', 'min:1', 'max:12'],
            'grupo'     => ['required', 'string', 'max:20', 'regex:/^[a-zA-Z]$/'],
        ], [
            'nombre.required'       => 'El nombre completo es requerido.',
            'nombre.regex'          => 'El nombre solo debe contener letras y espacios.',
            'correo.required'       => 'El correo electrónico es requerido.',
            'correo.email'          => 'El formato del correo es inválido.',
            'correo.unique'         => 'Este correo ya está registrado en el sistema.',
            'matricula.required'    => 'La matrícula es requerida.',
            'matricula.unique'      => 'Esta matrícula ya está registrada.',
            'matricula.regex'       => 'La matrícula solo debe contener números.',
            'semestre.min'          => 'El semestre debe ser entre 1 y 12.',
            'semestre.max'          => 'El semestre debe ser entre 1 y 12.',
            'grupo.regex'           => 'El grupo debe ser exactamente una letra.',
        ]);

        // Generate a random secure password
        $randomPassword = Str::random(10);

        // Create the user account
        $user = new User();
        $user->correo     = $request->input('correo');
        $user->contraseña = Hash::make($randomPassword);
        $user->rol_id     = 3; // Alumno
        $user->activo     = true;
        $user->save();

        // Create the alumno profile
        $alumno = new Alumno();
        $alumno->usuario_id      = $user->id;
        $alumno->nombre_completo = $request->input('nombre');
        $alumno->matricula       = $request->input('matricula');
        $alumno->carrera         = $request->input('carrera');
        $alumno->semestre        = $request->input('semestre');
        $alumno->grupo           = strtoupper($request->input('grupo'));
        $alumno->activo_practica = 0;
        $alumno->save();

        // Send credentials email
        try {
            Mail::to($user->correo)->send(
                new CredentialsNotification($user, $randomPassword, $request->input('nombre'))
            );
        } catch (\Exception $e) {
            \Log::error("Error al enviar correo de credenciales al alumno {$user->correo}: " . $e->getMessage());
        }

        return redirect()->route('coordinador.dashboard')
            ->with('success', "Alumno \"{$request->input('nombre')}\" registrado correctamente. Se enviaron las credenciales a {$request->input('correo')}.");
    }
}
