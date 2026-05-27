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
     * List, search, filter and paginate institutions.
     */
    public function instituciones(Request $request)
    {
        if (auth()->user()->rol_id != 2) {
            return redirect('/');
        }

        $search = $request->input('search');
        if ($search) {
            $search = preg_replace('/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s@.]/u', '', $search);
        }
        $perPage = $request->input('per_page', 5);

        if (!in_array($perPage, [5, 10, 25, 50, 100])) {
            $perPage = 5;
        }

        $query = DB::table('unidades_receptoras');

        // Apply Search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nombre_empresa', 'like', "%{$search}%")
                  ->orWhere('direccion', 'like', "%{$search}%")
                  ->orWhere('tipo_persona', 'like', "%{$search}%");
            });
        }

        // Apply Sector Filter (Public / Private keywords matching the UI heuristics)
        $sector = $request->input('sector');
        if ($sector === 'publico') {
            $query->where(function($q) {
                $q->where('nombre_empresa', 'like', '%Ayuntamiento%')
                  ->orWhere('nombre_empresa', 'like', '%Secretaria%')
                  ->orWhere('nombre_empresa', 'like', '%Secretaría%')
                  ->orWhere('nombre_empresa', 'like', '%IMSS%')
                  ->orWhere('nombre_empresa', 'like', '%DIF%')
                  ->orWhere('nombre_empresa', 'like', '%Gobierno%')
                  ->orWhere('nombre_empresa', 'like', '%Universidad%')
                  ->orWhere('nombre_empresa', 'like', '%Facultad%');
            });
        } elseif ($sector === 'privado') {
            $query->where(function($q) {
                $q->where('nombre_empresa', 'not like', '%Ayuntamiento%')
                  ->where('nombre_empresa', 'not like', '%Secretaria%')
                  ->where('nombre_empresa', 'not like', '%Secretaría%')
                  ->where('nombre_empresa', 'not like', '%IMSS%')
                  ->where('nombre_empresa', 'not like', '%DIF%')
                  ->where('nombre_empresa', 'not like', '%Gobierno%')
                  ->where('nombre_empresa', 'not like', '%Universidad%')
                  ->where('nombre_empresa', 'not like', '%Facultad%');
            });
        }

        // Apply Tipo Persona Filter (Física / Moral)
        $tipoPersona = $request->input('tipo_persona');
        if ($tipoPersona === 'moral') {
            $query->where(function($q) {
                $q->where('tipo_persona', 'Moral')
                  ->orWhere('tipo_persona', 'moral')
                  ->orWhere('tipo_persona', 'like', '%moral%');
            });
        } elseif ($tipoPersona === 'fisica') {
            $query->where(function($q) {
                $q->where('tipo_persona', 'Física')
                  ->orWhere('tipo_persona', 'Fisica')
                  ->orWhere('tipo_persona', 'fisica')
                  ->orWhere('tipo_persona', 'like', '%fis%')
                  ->orWhere('tipo_persona', 'like', '%fís%');
            });
        }

        // Apply Convenio Filter (Con convenio / Sin convenio)
        $convenio = $request->input('convenio');
        if ($convenio === 'con') {
            $query->whereExists(function($q) {
                $q->select(DB::raw(1))
                  ->from('convenios')
                  ->whereColumn('convenios.ur_id', 'unidades_receptoras.id');
            });
        } elseif ($convenio === 'sin') {
            $query->whereNotExists(function($q) {
                $q->select(DB::raw(1))
                  ->from('convenios')
                  ->whereColumn('convenios.ur_id', 'unidades_receptoras.id');
            });
        }

        $instituciones = $query->paginate($perPage);

        // Fetch related data
        $urIds = $instituciones->pluck('id')->toArray();
        
        $convenios = DB::table('convenios')
            ->whereIn('ur_id', $urIds)
            ->get()
            ->groupBy('ur_id');
            
        $solicitudesCounts = DB::table('solicitudes')
            ->whereIn('ur_id', $urIds)
            ->select('ur_id', DB::raw('count(*) as count'))
            ->groupBy('ur_id')
            ->pluck('count', 'ur_id')
            ->toArray();

        return view('coordinador.instituciones', compact('instituciones', 'convenios', 'solicitudesCounts'));
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

        return redirect()->back()
            ->with('success', "Alumno \"{$request->input('nombre')}\" registrado correctamente. Se enviaron las credenciales a {$request->input('correo')}.");
    }
}
