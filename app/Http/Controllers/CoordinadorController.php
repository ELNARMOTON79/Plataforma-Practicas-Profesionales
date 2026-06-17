<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Alumno;
use App\Models\Proyecto;
use App\Mail\CredentialsNotification;
use App\Mail\NewAssociationNotification;

class CoordinadorController extends Controller
{
    public function dashboard()
    {
        if (auth()->check() && auth()->user()->rol_id != 2) {
            return redirect('/');
        }

        $estudiantesActivos = DB::table('estudiantes')->count();
        $instituciones = DB::table('unidades_receptoras')->count();
        $tramitesPendientes = DB::table('solicitudes')->where('estatus', 'pendiente')->count();
        $proyectosActivos = DB::table('convenios')->where('estatus', 'activo')->count();

        // Fetch recent students and logs for the dashboard
        $recentAlumnos = \App\Models\Alumno::with('user')->orderBy('id', 'desc')->take(3)->get();
        $recentLogs = \App\Models\Bitacora::orderBy('timestamp', 'desc')->take(5)->get();

        return view('coordinador.dashboard', compact(
            'estudiantesActivos',
            'instituciones',
            'tramitesPendientes',
            'proyectosActivos',
            'recentAlumnos',
            'recentLogs'
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
     * Each company appears once with a COUNT of its reception units.
     * Equivalent to: SELECT nombre_empresa, COUNT(*) as ur_count ... GROUP BY nombre_empresa
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

        $query = DB::table('unidades_receptoras')
            ->select([
                DB::raw('nombre_empresa'),
                DB::raw('MIN(id) as id'),
                DB::raw('MIN(usuario_id) as usuario_id'),
                DB::raw('MIN(direccion) as direccion'),
                DB::raw('MIN(tipo_persona) as tipo_persona'),
                DB::raw('MAX(convenio) as convenio'),
                DB::raw('COUNT(nombre_empresa) as ur_count'),
            ])
            ->groupBy('nombre_empresa');

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

        // Apply Convenio Filter — checks the convenio field and the convenios table
        $convenio = $request->input('convenio');
        if ($convenio === 'con') {
            $query->where(function($q) {
                $q->where('convenio', '!=', '')
                  ->orWhereExists(function($sub) {
                      $sub->select(DB::raw(1))
                          ->from('convenios')
                          ->whereColumn('convenios.ur_id', 'unidades_receptoras.id');
                  });
            });
        } elseif ($convenio === 'sin') {
            $query->where(function($q) {
                $q->where(function($inner) {
                    $inner->whereNull('convenio')->orWhere('convenio', '');
                })->whereNotExists(function($sub) {
                    $sub->select(DB::raw(1))
                        ->from('convenios')
                        ->whereColumn('convenios.ur_id', 'unidades_receptoras.id');
                });
            });
        }

        $instituciones = $query->paginate($perPage);

        // Fetch convenios keyed by nombre_empresa for the badge lookup
        $nombres = $instituciones->pluck('nombre_empresa')->toArray();

        $convenios = DB::table('convenios')
            ->join('unidades_receptoras', 'convenios.ur_id', '=', 'unidades_receptoras.id')
            ->whereIn('unidades_receptoras.nombre_empresa', $nombres)
            ->select('convenios.*', 'unidades_receptoras.nombre_empresa')
            ->get()
            ->groupBy('nombre_empresa');

        // Fetch all fields of each unidad_receptora per empresa for the modal
        $unidades = DB::table('unidades_receptoras')
            ->whereIn('nombre_empresa', $nombres)
            ->orderBy('unidad_receptora')
            ->get()
            ->groupBy('nombre_empresa');

        return view('coordinador.instituciones', compact('instituciones', 'convenios', 'unidades'));
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

    /**
     * Show the coordinator profile configuration page.
     */
    public function perfil()
    {
        if (auth()->user()->rol_id != 2) {
            return redirect('/');
        }

        $user = auth()->user();
        $coordinadorName = $user->coordinador->nombre_completo ?? '';

        return view('coordinador.perfil', compact('user', 'coordinadorName'));
    }


    /**
     * Update the coordinator password.
     */
    public function updatePassword(Request $request)
    {
        if (auth()->user()->rol_id != 2) {
            return redirect('/');
        }

        $user = auth()->user();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed|different:current_password',
        ], [
            'current_password.required' => 'La contraseña actual es obligatoria.',
            'password.required' => 'La nueva contraseña es obligatoria.',
            'password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'password.different' => 'La nueva contraseña debe ser diferente a la contraseña actual.',
        ]);

        // Verify current password
        if (!Hash::check($request->input('current_password'), $user->contraseña)) {
            return back()->withErrors(['current_password' => 'La contraseña actual ingresada no es correcta.']);
        }

        // Save new password
        $user->contraseña = Hash::make($request->input('password'));
        $user->save();

        \App\Helpers\ActivityLogger::log(
            'Configuración',
            'Contraseña Cambiada',
            "El coordinador cambió su contraseña de acceso.",
            'warning'
        );

        return redirect()->route('coordinador.perfil')->with('success', 'Contraseña actualizada correctamente.');
    }

    /**
     * Store bulk uploaded institutions in the database.
     */
    public function bulkStoreInstituciones(Request $request)
    {
        if (auth()->user()->rol_id != 2) {
            return response()->json(['success' => false, 'errors' => ['No autorizado']], 403);
        }

        $request->validate([
            'instituciones' => 'required|array|min:1',
            'instituciones.*.correo' => 'required|email|max:255',
            'instituciones.*.institucion' => 'required|string|max:255',
            'instituciones.*.direccion' => 'required|string|max:500',
            'instituciones.*.sistema' => 'nullable|string|max:50',
            'instituciones.*.sector' => 'nullable|string|max:50',
            'instituciones.*.unidad_receptora' => 'nullable|string|max:100',
            'instituciones.*.titular' => 'required|string|max:100',
            'instituciones.*.cargo' => 'required|string|max:100',
            'instituciones.*.colonia' => 'nullable|string|max:50',
            'instituciones.*.cp' => 'nullable|integer',
            'instituciones.*.estado' => 'nullable|string|max:20',
            'instituciones.*.municipio' => 'nullable|string|max:100',
            'instituciones.*.telefono' => 'nullable|string|max:50',
        ], [
            'instituciones.*.correo.required' => 'El correo electrónico es obligatorio.',
            'instituciones.*.correo.email' => 'El formato del correo electrónico es inválido.',
            'instituciones.*.correo.max' => 'El correo electrónico no debe superar los 255 caracteres.',
            'instituciones.*.institucion.required' => 'El nombre de la institución es obligatorio.',
            'instituciones.*.institucion.max' => 'El nombre de la institución no debe superar los 255 caracteres.',
            'instituciones.*.direccion.required' => 'La dirección es obligatoria.',
            'instituciones.*.direccion.max' => 'La dirección no debe superar los 500 caracteres.',
            'instituciones.*.sistema.max' => 'El campo sistema no debe superar los 50 caracteres.',
            'instituciones.*.sector.max' => 'El campo sector no debe superar los 50 caracteres.',
            'instituciones.*.unidad_receptora.max' => 'La unidad receptora no debe superar los 100 caracteres.',
            'instituciones.*.titular.required' => 'El nombre del titular es obligatorio.',
            'instituciones.*.titular.max' => 'El nombre del titular no debe superar los 100 caracteres.',
            'instituciones.*.cargo.required' => 'El cargo es obligatorio.',
            'instituciones.*.cargo.max' => 'El cargo no debe superar los 100 caracteres.',
            'instituciones.*.colonia.max' => 'La colonia no debe superar los 50 caracteres.',
            'instituciones.*.cp.integer' => 'El código postal debe ser un número entero.',
            'instituciones.*.estado.max' => 'El estado no debe superar los 20 caracteres.',
            'instituciones.*.municipio.max' => 'El municipio no debe superar los 100 caracteres.',
            'instituciones.*.telefono.max' => 'El teléfono no debe superar los 50 caracteres.',
        ]);

        $instituciones = $request->input('instituciones');

        // Group institutions by email (case-insensitive) to handle duplicates together
        $grouped = [];
        foreach ($instituciones as $inst) {
            $correo = strtolower(trim($inst['correo']));
            if (!isset($grouped[$correo])) {
                $grouped[$correo] = [];
            }
            $grouped[$correo][] = $inst;
        }

        // Database transaction
        \DB::beginTransaction();
        try {
            $createdCount = 0;
            $skippedCount = 0;
            $seenInBatch = []; // Track seen combinations in the current request to prevent duplicates in the batch

            foreach ($grouped as $correo => $rows) {
                // Find if the user already exists in the database
                $user = User::where('correo', $correo)->first();
                $isNewUser = false;
                $randomPassword = null;

                // Validate and filter rows that are already in the DB to avoid duplicates
                $validRowsToRegister = [];
                foreach ($rows as $inst) {
                    $nombreEmpresa = trim($inst['institucion']);
                    $unidadReceptoraName = trim($inst['unidad_receptora'] ?? '');

                    // Create key for batch checking
                    $normEmpresa = strtolower(preg_replace('/\s+/', ' ', trim($nombreEmpresa)));
                    $normUr = strtolower(preg_replace('/\s+/', ' ', trim($unidadReceptoraName)));
                    $batchKey = $normEmpresa . '|' . $normUr;

                    if (in_array($batchKey, $seenInBatch)) {
                        $skippedCount++;
                        continue;
                    }

                    $exists = \App\Models\UnidadReceptora::where(DB::raw('LOWER(TRIM(nombre_empresa))'), strtolower($nombreEmpresa))
                        ->where(function($q) use ($unidadReceptoraName) {
                            if ($unidadReceptoraName === '') {
                                $q->whereNull('unidad_receptora')
                                  ->orWhere(DB::raw('TRIM(unidad_receptora)'), '');
                            } else {
                                $q->where(DB::raw('LOWER(TRIM(unidad_receptora))'), strtolower($unidadReceptoraName));
                            }
                        })
                        ->exists();

                    if ($exists) {
                        $skippedCount++;
                    } else {
                        $seenInBatch[] = $batchKey;
                        $validRowsToRegister[] = $inst;
                    }
                }

                // If all units for this email already exist, we skip user creation / association.
                if (empty($validRowsToRegister)) {
                    continue;
                }

                if (!$user) {
                    $randomPassword = Str::random(10);
                    $user = new User();
                    $user->correo = $correo;
                    $user->contraseña = Hash::make($randomPassword);
                    $user->rol_id = 4; // Empresa/Institución
                    $user->activo = true;
                    $user->save();
                    $isNewUser = true;
                }

                // Collect units registered for this email to include in the notification
                $unitsAdded = [];

                foreach ($validRowsToRegister as $inst) {
                    // Create UnidadReceptora
                    $ur = new \App\Models\UnidadReceptora();
                    $ur->usuario_id = $user->id;
                    $ur->nombre_empresa = trim($inst['institucion']);
                    $ur->direccion = trim($inst['direccion']);
                    $ur->tipo_persona = 'Moral'; // Default standard value for Mexican institutions/companies
                    $ur->sistema = trim($inst['sistema'] ?? '');
                    $ur->sector = trim($inst['sector'] ?? '');
                    $ur->unidad_receptora = trim($inst['unidad_receptora'] ?? '');
                    $ur->titular = trim($inst['titular'] ?? '');
                    $ur->cargo = trim($inst['cargo'] ?? '');
                    $ur->colonia = trim($inst['colonia'] ?? '');
                    $ur->cp = intval($inst['cp'] ?? 0);
                    $ur->estado = trim($inst['estado'] ?? '');
                    $ur->municipio = trim($inst['municipio'] ?? '');
                    $ur->telefono = trim($inst['telefono'] ?? '');
                    $ur->convenio = 'Con Convenio';
                    $ur->save();

                    $unitsAdded[] = [
                        'nombre_empresa' => $ur->nombre_empresa,
                        'unidad_receptora' => $ur->unidad_receptora ?: 'General'
                    ];

                    $createdCount++;
                }

                // Use the titular name of the first entry in this email group
                $titularName = trim($validRowsToRegister[0]['titular']);

                // Send Credentials or Association Notification Email
                if (\App\Helpers\SystemSettings::get('send_emails', true)) {
                    try {
                        if ($isNewUser) {
                            // Send access credentials and list of units
                            Mail::to($user->correo)->send(new CredentialsNotification($user, $randomPassword, $titularName, $unitsAdded));
                        } else {
                            // Send new association notification to existing user
                            Mail::to($user->correo)->send(new NewAssociationNotification($user, $titularName, $unitsAdded));
                        }
                    } catch (\Exception $e) {
                        \Log::error("Error al enviar correo de notificación a {$user->correo} en carga masiva de instituciones: " . $e->getMessage());
                    }
                }
            }

            \DB::commit();

            // Log activity
            \App\Helpers\ActivityLogger::log(
                'Instituciones',
                'Importación Masiva',
                "Se registraron exitosamente {$createdCount} instituciones mediante importación masiva. Omitidas: {$skippedCount}.",
                'success',
                ['cantidad_importada' => $createdCount, 'cantidad_omitida' => $skippedCount]
            );

            if ($createdCount > 0) {
                $msg = "Se han registrado {$createdCount} instituciones correctamente.";
                if ($skippedCount > 0) {
                    $msg .= " ({$skippedCount} fueron omitidas por estar registradas previamente).";
                }
                session()->flash('success', $msg);
            } else {
                session()->flash('info', "No se importó ningún registro nuevo. Todas las {$skippedCount} unidades receptoras del archivo ya estaban registradas.");
            }

            return response()->json([
                'success' => true,
                'message' => "Importación exitosa. Creadas: {$createdCount}, Omitidas: {$skippedCount}."
            ]);

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error("Error al procesar importación masiva de instituciones: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'errors' => ['Ocurrió un error inesperado en el servidor al guardar los registros: ' . $e->getMessage()]
            ], 500);
        }
    }

    /**
     * Store bulk uploaded students in the database.
     */
    public function bulkStoreAlumnos(Request $request)
    {
        if (auth()->user()->rol_id != 2) {
            return response()->json(['success' => false, 'errors' => ['No autorizado']], 403);
        }

        $request->validate([
            'students'           => 'required|array|min:1',
            'students.*.correo'  => 'required|email|max:255',
            'students.*.matricula' => 'required|string|max:50',
            'students.*.nombre'  => 'required|string|max:255',
            'students.*.carrera' => 'required|string|max:150',
            'students.*.semestre' => 'required|integer|min:1|max:12',
            'students.*.grupo'   => 'required|string|max:20',
        ]);

        $students   = $request->input('students');
        $errors     = [];
        $emails     = [];
        $matriculas = [];

        // Validate uniqueness and duplicates within the file
        foreach ($students as $index => $student) {
            $rowNum   = $index + 1;
            $correo   = trim($student['correo']);
            $matricula = trim($student['matricula']);

            if (in_array(strtolower($correo), $emails)) {
                $errors[] = "Fila {$rowNum}: El correo '{$correo}' está duplicado en el archivo.";
            } else {
                $emails[] = strtolower($correo);
            }

            if (in_array(strtolower($matricula), $matriculas)) {
                $errors[] = "Fila {$rowNum}: La matrícula '{$matricula}' está duplicada en el archivo.";
            } else {
                $matriculas[] = strtolower($matricula);
            }

            if (User::where('correo', $correo)->exists()) {
                $errors[] = "Fila {$rowNum}: El correo '{$correo}' ya está registrado en el sistema.";
            }

            if (Alumno::where('matricula', $matricula)->exists()) {
                $errors[] = "Fila {$rowNum}: La matrícula '{$matricula}' ya está registrada en el sistema.";
            }
        }

        if (!empty($errors)) {
            return response()->json(['success' => false, 'errors' => $errors], 422);
        }

        // Insert inside a transaction
        DB::beginTransaction();
        try {
            $createdCount = 0;
            foreach ($students as $student) {
                $randomPassword = Str::random(10);

                $user = new User();
                $user->correo    = trim($student['correo']);
                $user->contraseña = Hash::make($randomPassword);
                $user->rol_id    = 3; // Alumno
                $user->activo    = true;
                $user->save();

                $alumno = new Alumno();
                $alumno->usuario_id      = $user->id;
                $alumno->nombre_completo = trim($student['nombre']);
                $alumno->matricula       = trim($student['matricula']);
                $alumno->carrera         = trim($student['carrera']);
                $alumno->semestre        = intval($student['semestre']);
                $alumno->grupo           = strtoupper(trim($student['grupo']));
                $alumno->activo_practica = 0;
                $alumno->save();

                if (\App\Helpers\SystemSettings::get('send_emails', true)) {
                    try {
                        Mail::to($user->correo)->send(new CredentialsNotification($user, $randomPassword, trim($student['nombre'])));
                    } catch (\Exception $e) {
                        \Log::error("Error al enviar correo de credenciales a {$user->correo} en carga masiva: " . $e->getMessage());
                    }
                }

                $createdCount++;
            }

            DB::commit();

            \App\Helpers\ActivityLogger::log(
                'Alumnos',
                'Importación Masiva',
                "Se registraron exitosamente {$createdCount} estudiantes mediante importación masiva.",
                'success',
                ['cantidad_importada' => $createdCount]
            );

            session()->flash('success', "Se han registrado {$createdCount} estudiantes correctamente y se enviaron sus accesos por correo.");

            return response()->json([
                'success' => true,
                'message' => "Importación exitosa de {$createdCount} estudiantes."
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Error al procesar importación masiva de estudiantes (coordinador): " . $e->getMessage());
            return response()->json([
                'success' => false,
                'errors'  => ['Ocurrió un error inesperado en el servidor al guardar los registros: ' . $e->getMessage()]
            ], 500);
        }
    }
}
