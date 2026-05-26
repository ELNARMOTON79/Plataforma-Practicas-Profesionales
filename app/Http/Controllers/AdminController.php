<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\CredentialsNotification;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        if (auth()->user()->rol_id != 1) {
            return redirect('/');
        }

        $recentLogs = \App\Models\Bitacora::orderBy('timestamp', 'desc')->take(5)->get();
        $recentUsers = \App\Models\User::with(['alumno', 'coordinador', 'empresa'])
            ->where('rol_id', '!=', 1)
            ->orderBy('id', 'desc')
            ->take(2)
            ->get();

        // Calculate KPI Metrics from database
        $totalAlumnos = \DB::table('estudiantes')->where('activo_practica', 1)->count();
        $conveniosActivos = \DB::table('convenios')->where('estatus', 'activo')->count();
        $solicitudesPendientes = \DB::table('solicitudes')->where('estatus', 'pendiente')->count();
        
        // System alerts (Convenios expiring in the next 30 days)
        $alertasSistema = \DB::table('convenios')
            ->where('estatus', 'activo')
            ->whereBetween('fecha_termino', [
                \Carbon\Carbon::now()->toDateString(), 
                \Carbon\Carbon::now()->addDays(30)->toDateString()
            ])
            ->count();

        return view('admin.dashboard', compact(
            'recentLogs', 
            'recentUsers', 
            'totalAlumnos', 
            'conveniosActivos', 
            'solicitudesPendientes', 
            'alertasSistema'
        ));
    }

    /**
     * List and filter users in the admin dashboard.
     */
    public function usuarios(Request $request)
    {
        if (auth()->user()->rol_id != 1) {
            return redirect('/');
        }

        $search = $request->input('search');
        if ($search) {
            // Strip any character that is not a letter, number, space, @ or .
            $search = preg_replace('/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s@.]/u', '', $search);
        }
        $rol = $request->input('rol');
        $estado = $request->input('estado');
        $perPage = $request->input('per_page', 5);
        
        // Ensure per_page is a supported value
        if (!in_array($perPage, [5, 10, 25, 50, 100])) {
            $perPage = 5;
        }

        // Eager load relationships to prevent N+1 query issue
        $query = User::with(['alumno', 'coordinador', 'empresa'])->where('rol_id', '!=', 1);

        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('correo', 'like', "%{$search}%")
                  ->orWhereHas('alumno', function($q) use ($search) {
                      $q->where('nombre_completo', 'like', "%{$search}%")
                        ->orWhere('matricula', 'like', "%{$search}%");
                  })
                  ->orWhereHas('coordinador', function($q) use ($search) {
                      $q->where('nombre_completo', 'like', "%{$search}%");
                  })
                  ->orWhereHas('empresa', function($q) use ($search) {
                      $q->where('nombre_empresa', 'like', "%{$search}%");
                  });
            });
        }

        // Apply role filter
        if ($rol) {
            $query->where('rol_id', $rol);
        }

        // Apply status filter
        if ($estado !== null && $estado !== '') {
            $activoVal = ($estado === 'activo') ? 1 : 0;
            $query->where('activo', $activoVal);
        }

        // Paginate users with requested page size
        $usuarios = $query->paginate($perPage);

        return view('admin.usuarios', compact('usuarios'));
    }

    /**
     * Store a newly created user in the database.
     */
    public function storeUsuario(Request $request)
    {
        if (auth()->user()->rol_id != 1) {
            return redirect('/');
        }

        // Base validation rules
        $rules = [
            'name' => 'required|string|max:255|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/',
            'email' => 'required|email|max:255|unique:usuarios,correo',
            'role' => 'required|in:1,2,3,4',
        ];

        // Dynamic validation rules based on role
        if ($request->input('role') == 3) { // Alumno
            $rules['matricula'] = 'required|string|max:50|unique:estudiantes,matricula|regex:/^[0-9]+$/';
            $rules['carrera'] = 'required|string|max:150';
            $rules['semestre'] = 'required|integer|min:1|max:12';
            $rules['grupo'] = 'required|string|max:20|regex:/^[a-zA-Z]$/';
        } elseif ($request->input('role') == 4) { // Empresa
            $rules['nombre_empresa'] = 'required|string|max:255|regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s.,&-]+$/';
            $rules['direccion'] = 'required|string|max:500|regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s.,#\/\s-]+$/';
            $rules['tipo_persona'] = 'required|string|in:Física,Moral';
        }

        $messages = [
            'name.regex' => 'El nombre completo solo debe contener letras y espacios.',
            'nombre_empresa.regex' => 'El nombre de la empresa solo debe contener letras, números, espacios y caracteres permitidos (.,&-).',
            'matricula.regex' => 'La matrícula solo debe contener números.',
            'grupo.regex' => 'El grupo debe ser exactamente una letra.',
            'direccion.regex' => 'La dirección contiene caracteres no permitidos.',
        ];

        $request->validate($rules, $messages);

        // Generate random secure password (10 characters)
        $randomPassword = Str::random(10);

        // Create the user
        $user = new User();
        $user->correo = $request->input('email');
        $user->contraseña = Hash::make($randomPassword);
        $user->rol_id = $request->input('role');
        $user->activo = true;
        $user->save();

        // Create the associated profile model
        if ($user->rol_id == 1 || $user->rol_id == 2) { // Admin / Coordinador
            $coordinador = new \App\Models\Coordinador();
            $coordinador->usuario_id = $user->id;
            $coordinador->nombre_completo = $request->input('name');
            $coordinador->save();
        } elseif ($user->rol_id == 3) { // Alumno
            $alumno = new \App\Models\Alumno();
            $alumno->usuario_id = $user->id;
            $alumno->nombre_completo = $request->input('name');
            $alumno->matricula = $request->input('matricula');
            $alumno->carrera = $request->input('carrera');
            $alumno->semestre = $request->input('semestre');
            $alumno->grupo = $request->input('grupo');
            $alumno->activo_practica = 0;
            $alumno->save();
        } elseif ($user->rol_id == 4) { // Empresa
            $empresa = new \App\Models\Empresa();
            $empresa->usuario_id = $user->id;
            $empresa->nombre_empresa = $request->input('nombre_empresa');
            $empresa->direccion = $request->input('direccion');
            $empresa->tipo_persona = $request->input('tipo_persona');
            $empresa->save();
        }

        // Send credentials email
        Mail::to($user->correo)->send(new CredentialsNotification($user, $randomPassword, $request->input('name')));

        // Log user creation
        $roleNames = [1 => 'Administrador', 2 => 'Coordinador', 3 => 'Alumno', 4 => 'Empresa'];
        $roleName = $roleNames[$user->rol_id] ?? 'Desconocido';
        \App\Helpers\ActivityLogger::log(
            'Usuarios',
            'Usuario Creado',
            "Se creó el usuario '{$request->input('name')}' con el rol '{$roleName}' y correo '{$user->correo}'.",
            'success',
            [
                'correo' => $user->correo,
                'nombre' => $request->input('name'),
                'rol' => $roleName
            ]
        );

        return redirect()->route('admin.usuarios')->with('success', 'Usuario registrado correctamente. Se han enviado las credenciales por correo electrónico.');
    }

    /**
     * Store bulk uploaded students in the database.
     */
    public function bulkStoreUsuarios(Request $request)
    {
        if (auth()->user()->rol_id != 1) {
            return response()->json(['success' => false, 'errors' => ['No autorizado']], 403);
        }

        $request->validate([
            'students' => 'required|array|min:1',
            'students.*.correo' => 'required|email|max:255',
            'students.*.matricula' => 'required|string|max:50',
            'students.*.nombre' => 'required|string|max:255',
            'students.*.carrera' => 'required|string|max:150',
            'students.*.semestre' => 'required|integer|min:1|max:12',
            'students.*.grupo' => 'required|string|max:20',
        ]);

        $students = $request->input('students');
        $errors = [];
        $emails = [];
        $matriculas = [];

        // 1. Validaciones de unicidad y duplicados
        foreach ($students as $index => $student) {
            $rowNum = $index + 1;
            $correo = trim($student['correo']);
            $matricula = trim($student['matricula']);

            // Validar correos duplicados en el mismo archivo
            if (in_array(strtolower($correo), $emails)) {
                $errors[] = "Fila {$rowNum}: El correo '{$correo}' está duplicado en el archivo.";
            } else {
                $emails[] = strtolower($correo);
            }

            // Validar matrículas duplicadas en el mismo archivo
            if (in_array(strtolower($matricula), $matriculas)) {
                $errors[] = "Fila {$rowNum}: La matrícula '{$matricula}' está duplicada en el archivo.";
            } else {
                $matriculas[] = strtolower($matricula);
            }

            // Validar contra la base de datos
            if (User::where('correo', $correo)->exists()) {
                $errors[] = "Fila {$rowNum}: El correo '{$correo}' ya está registrado en el sistema.";
            }

            if (\App\Models\Alumno::where('matricula', $matricula)->exists()) {
                $errors[] = "Fila {$rowNum}: La matrícula '{$matricula}' ya está registrada en el sistema.";
            }
        }

        if (!empty($errors)) {
            return response()->json([
                'success' => false,
                'errors' => $errors
            ], 422);
        }

        // 2. Proceso de inserción en transacción
        \DB::beginTransaction();
        try {
            $createdCount = 0;
            foreach ($students as $student) {
                $randomPassword = Str::random(10);

                // Crear Usuario
                $user = new User();
                $user->correo = trim($student['correo']);
                $user->contraseña = Hash::make($randomPassword);
                $user->rol_id = 3; // Alumno/Estudiante
                $user->activo = true;
                $user->save();

                // Crear Alumno
                $alumno = new \App\Models\Alumno();
                $alumno->usuario_id = $user->id;
                $alumno->nombre_completo = trim($student['nombre']);
                $alumno->matricula = trim($student['matricula']);
                $alumno->carrera = trim($student['carrera']);
                $alumno->semestre = intval($student['semestre']);
                $alumno->grupo = trim($student['grupo']);
                $alumno->activo_practica = 0;
                $alumno->save();

                // Enviar Correo
                try {
                    Mail::to($user->correo)->send(new CredentialsNotification($user, $randomPassword, trim($student['nombre'])));
                } catch (\Exception $e) {
                    \Log::error("Error al enviar correo de credenciales a {$user->correo} en carga masiva: " . $e->getMessage());
                }

                $createdCount++;
            }

            \DB::commit();

            // Registrar en la bitácora
            \App\Helpers\ActivityLogger::log(
                'Usuarios',
                'Importación Masiva',
                "Se registraron exitosamente {$createdCount} estudiantes mediante importación masiva.",
                'success',
                ['cantidad_importada' => $createdCount]
            );

            // Guardar mensaje en sesión para mostrar la alerta bonita de redirección
            session()->flash('success', "Se han registrado {$createdCount} estudiantes correctamente y se enviaron sus accesos por correo.");

            return response()->json([
                'success' => true,
                'message' => "Importación exitosa de {$createdCount} estudiantes."
            ]);

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error("Error al procesar importación masiva de estudiantes: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'errors' => ['Ocurrió un error inesperado en el servidor al guardar los registros: ' . $e->getMessage()]
            ], 500);
        }
    }

    /**
     * Update the specified user in the database.
     */
    public function updateUsuario(Request $request, $id)
    {
        if (auth()->user()->rol_id != 1) {
            return redirect('/');
        }

        $user = User::findOrFail($id);

        // Validation
        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
                $user->rol_id == 4 
                    ? 'regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s.,&-]+$/'
                    : 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/'
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('usuarios', 'correo')->ignore($user->id),
            ],
            'role' => 'required|in:1,2,3,4',
        ];

        // Dynamic validation based on role
        if ($user->rol_id == 3) { // Alumno
            $rules['matricula'] = [
                'required',
                'string',
                'max:50',
                Rule::unique('estudiantes', 'matricula')->ignore($user->alumno->id ?? 0),
                'regex:/^[0-9]+$/',
            ];
            $rules['carrera'] = 'required|string|max:150';
            $rules['semestre'] = 'required|integer|min:1|max:12';
            $rules['grupo'] = [
                'required',
                'string',
                'max:20',
                'regex:/^[a-zA-Z]$/',
            ];
        } elseif ($user->rol_id == 4) { // Empresa
            $rules['direccion'] = [
                'required',
                'string',
                'max:500',
                'regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s.,#\/\s-]+$/',
            ];
            $rules['tipo_persona'] = 'required|string|in:Física,Moral';
        }

        $messages = [
            'name.regex' => $user->rol_id == 4 
                ? 'El nombre de la empresa solo debe contener letras, números, espacios y caracteres permitidos (.,&-).'
                : 'El nombre completo solo debe contener letras y espacios.',
            'matricula.regex' => 'La matrícula solo debe contener números.',
            'grupo.regex' => 'El grupo debe ser exactamente una letra.',
            'direccion.regex' => 'La dirección contiene caracteres no permitidos.',
        ];

        $request->validate($rules, $messages);

        // Update user (basic info)
        $user->correo = $request->input('email');
        $user->save();

        // Update related tables
        if ($user->rol_id == 1 || $user->rol_id == 2) { // Admin / Coordinador
            $coordinador = $user->coordinador;
            if (!$coordinador) {
                $coordinador = new \App\Models\Coordinador();
                $coordinador->usuario_id = $user->id;
            }
            $coordinador->nombre_completo = $request->input('name');
            $coordinador->save();
        } elseif ($user->rol_id == 3) { // Alumno
            $alumno = $user->alumno;
            if (!$alumno) {
                $alumno = new \App\Models\Alumno();
                $alumno->usuario_id = $user->id;
                $alumno->activo_practica = 0;
            }
            $alumno->nombre_completo = $request->input('name');
            $alumno->matricula = $request->input('matricula');
            $alumno->carrera = $request->input('carrera');
            $alumno->semestre = $request->input('semestre');
            $alumno->grupo = $request->input('grupo');
            $alumno->save();
        } elseif ($user->rol_id == 4) { // Empresa
            $empresa = $user->empresa;
            if (!$empresa) {
                $empresa = new \App\Models\Empresa();
                $empresa->usuario_id = $user->id;
            }
            $empresa->nombre_empresa = $request->input('name');
            $empresa->direccion = $request->input('direccion');
            $empresa->tipo_persona = $request->input('tipo_persona');
            $empresa->save();
        }

        // Log user update
        $roleNames = [1 => 'Administrador', 2 => 'Coordinador', 3 => 'Alumno', 4 => 'Empresa'];
        $roleName = $roleNames[$user->rol_id] ?? 'Desconocido';
        \App\Helpers\ActivityLogger::log(
            'Usuarios',
            'Usuario Modificado',
            "Se actualizaron los datos del usuario '{$request->input('name')}' ({$roleName}) con correo '{$user->correo}'.",
            'info',
            [
                'correo' => $user->correo,
                'nombre' => $request->input('name'),
                'rol' => $roleName
            ]
        );

        return redirect()->route('admin.usuarios')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Toggle the active status of the specified user.
     */
    public function toggleStatus($id)
    {
        if (auth()->user()->rol_id != 1) {
            return redirect('/');
        }

        $user = User::findOrFail($id);

        // Do not allow deactivating the main administrator
        if ($user->rol_id == 1) {
            return redirect()->route('admin.usuarios')->with('error', 'No se puede modificar el estado de un administrador del sistema.');
        }

        $user->activo = !$user->activo;
        $user->save();

        // Log user status toggle
        $estadoLog = $user->activo ? 'Habilitado' : 'Deshabilitado';
        \App\Helpers\ActivityLogger::log(
            'Usuarios',
            $user->activo ? 'Usuario Habilitado' : 'Usuario Deshabilitado',
            "Se cambió el estado del usuario '{$user->correo}' a '{$estadoLog}'.",
            'warning',
            [
                'correo' => $user->correo,
                'nuevo_estado' => $estadoLog
            ]
        );

        $estado = $user->activo ? 'habilitado' : 'deshabilitado';
        return redirect()->route('admin.usuarios')->with('success', "Usuario {$estado} correctamente.");
    }

    /**
     * Show the system activity logs.
     */
    public function bitacora(Request $request)
    {
        if (auth()->user()->rol_id != 1) {
            return redirect('/');
        }

        $search = $request->input('search');
        if ($search) {
            // Strip any character that is not a letter or space
            $search = preg_replace('/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/u', '', $search);
        }
        $level = $request->input('level');
        $module = $request->input('module');
        $date = $request->input('date');

        $query = \App\Models\Bitacora::query();

        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('user', 'like', "%{$search}%")
                  ->orWhere('user_email', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%")
                  ->orWhere('ip', 'like', "%{$search}%");
            });
        }

        // Apply level filter
        if ($level) {
            $query->where('level', $level);
        }

        // Apply module filter
        if ($module) {
            $query->where('module', $module);
        }

        // Apply quick date filter
        if ($date) {
            if ($date === 'today') {
                $query->whereDate('timestamp', \Carbon\Carbon::today());
            } elseif ($date === 'yesterday') {
                $query->whereDate('timestamp', \Carbon\Carbon::yesterday());
            } elseif ($date === 'older') {
                $query->whereDate('timestamp', '<', \Carbon\Carbon::today()->subDays(1));
            }
        }

        $logs = $query->orderBy('timestamp', 'desc')->paginate(10);

        $totalEventsToday = \App\Models\Bitacora::whereDate('timestamp', \Carbon\Carbon::today())->count();
        $warningsCount = \App\Models\Bitacora::where('level', 'warning')->count();
        $errorsCount = \App\Models\Bitacora::where('level', 'danger')->count();
        $activeUsersCount = User::where('activo', 1)->count();

        return view('admin.bitacora', compact(
            'logs',
            'totalEventsToday',
            'warningsCount',
            'errorsCount',
            'activeUsersCount'
        ));
    }

    /**
     * Clear all logs from the bitacora.
     */
    public function clearBitacora()
    {
        if (auth()->user()->rol_id != 1) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        \DB::table('bitacora')->truncate();

        \App\Helpers\ActivityLogger::log(
            'Sistema',
            'Limpieza de Bitácora',
            'El administrador vació todos los registros de la bitácora del sistema.',
            'warning'
        );

        return response()->json(['success' => true]);
    }

    /**
     * Export bitacora logs in CSV format.
     */
    public function exportBitacora(Request $request)
    {
        if (auth()->user()->rol_id != 1) {
            return redirect('/');
        }

        $format = strtoupper($request->query('format', 'CSV'));
        
        $search = $request->input('search');
        if ($search) {
            // Strip any character that is not a letter or space
            $search = preg_replace('/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/u', '', $search);
        }
        $level = $request->input('level');
        $module = $request->input('module');
        $date = $request->input('date');

        $query = \App\Models\Bitacora::query();

        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('user', 'like', "%{$search}%")
                  ->orWhere('user_email', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%")
                  ->orWhere('ip', 'like', "%{$search}%");
            });
        }

        // Apply level filter
        if ($level) {
            $query->where('level', $level);
        }

        // Apply module filter
        if ($module) {
            $query->where('module', $module);
        }

        // Apply quick date filter
        if ($date) {
            if ($date === 'today') {
                $query->whereDate('timestamp', \Carbon\Carbon::today());
            } elseif ($date === 'yesterday') {
                $query->whereDate('timestamp', \Carbon\Carbon::yesterday());
            } elseif ($date === 'older') {
                $query->whereDate('timestamp', '<', \Carbon\Carbon::today()->subDays(1));
            }
        }

        $logs = $query->orderBy('timestamp', 'desc')->get();

        if ($format === 'CSV') {
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="bitacora_' . date('Y-m-d_H-i-s') . '.csv"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0'
            ];

            $callback = function() use ($logs) {
                $file = fopen('php://output', 'w');
                
                fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
                
                fputcsv($file, [
                    'ID',
                    'Fecha y Hora',
                    'Nivel de Severidad',
                    'Usuario',
                    'Rol',
                    'Email de Usuario',
                    'Módulo',
                    'Acción',
                    'Descripción de Actividad',
                    'Navegador / User Agent'
                ]);

                foreach ($logs as $log) {
                    fputcsv($file, [
                        $log->id,
                        $log->timestamp ? $log->timestamp->toDateTimeString() : '',
                        $log->level_name,
                        $log->user,
                        $log->user_role,
                        $log->user_email,
                        $log->module,
                        $log->action,
                        $log->description,
                        $log->user_agent,
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        if ($format === 'PDF') {
            $user = auth()->user();
            $userName = 'Sistema';
            if ($user) {
                if ($user->rol_id == 1 || $user->rol_id == 2) {
                    $userName = $user->coordinador->nombre_completo ?? $user->correo;
                } elseif ($user->rol_id == 3) {
                    $userName = $user->alumno->nombre_completo ?? $user->correo;
                } elseif ($user->rol_id == 4) {
                    $userName = $user->empresa->nombre_empresa ?? $user->correo;
                } else {
                    $userName = $user->correo;
                }
            }

            // Summary stats for export
            $summary = [
                'total' => $logs->count(),
                'success' => $logs->where('level', 'success')->count(),
                'info' => $logs->where('level', 'info')->count(),
                'warning' => $logs->where('level', 'warning')->count(),
                'danger' => $logs->where('level', 'danger')->count(),
            ];

            // Build human-friendly filters description
            $filterLabels = [];
            if ($search) $filterLabels[] = "Búsqueda: '{$search}'";
            if ($level) {
                $levels = ['success' => 'Éxito', 'info' => 'Info', 'warning' => 'Advertencia', 'danger' => 'Error'];
                $filterLabels[] = "Severidad: " . ($levels[$level] ?? $level);
            }
            if ($module) $filterLabels[] = "Módulo: {$module}";
            if ($date) {
                $dates = ['today' => 'Hoy', 'yesterday' => 'Ayer', 'older' => 'Más de 2 días'];
                $filterLabels[] = "Fecha: " . ($dates[$date] ?? $date);
            }
            $filterText = empty($filterLabels) ? 'Ninguno (Todos los registros)' : implode(' | ', $filterLabels);

            return view('admin.bitacora.pdf', compact('logs', 'userName', 'summary', 'filterText'));
        }

        return back()->with('error', 'Formato no soportado.');
    }
}
