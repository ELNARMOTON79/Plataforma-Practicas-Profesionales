<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Alumno;
use App\Mail\CredentialsNotification;
use Illuminate\Validation\Rule;

class AlumnoController extends Controller
{
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
            'asesor'    => ['nullable', 'string', 'max:255'],
            'coasesor'  => ['nullable', 'string', 'max:255'],
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
        $alumno->asesor          = $request->input('asesor');
        $alumno->coasesor        = $request->input('coasesor');
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
                ['custom_payload' => ['cantidad_importada' => $createdCount]]
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

    /**
     * Update an existing student (alumno) from the coordinator dashboard.
     */
    public function updateAlumno(Request $request, $id)
    {
        if (auth()->user()->rol_id != 2) {
            return redirect('/');
        }

        $alumno = Alumno::findOrFail($id);
        $user = $alumno->user;

        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'No se encontró la cuenta del usuario asociada a este alumno.']);
        }

        $request->validate([
            'nombre'    => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/u'],
            'correo'    => ['required', 'email', 'max:255', Rule::unique('usuarios', 'correo')->ignore($user->id)],
            'matricula' => ['required', 'string', 'max:50', Rule::unique('estudiantes', 'matricula')->ignore($alumno->id), 'regex:/^[0-9]+$/'],
            'carrera'   => ['required', 'string', 'max:150'],
            'semestre'  => ['required', 'integer', 'min:1', 'max:12'],
            'grupo'     => ['required', 'string', 'max:20', 'regex:/^[a-zA-Z]$/'],
            'asesor'    => ['nullable', 'string', 'max:255'],
            'coasesor'  => ['nullable', 'string', 'max:255'],
        ], [
            'nombre.required'       => 'El nombre completo es requerido.',
            'nombre.regex'          => 'El nombre solo debe contener letras y espacios.',
            'correo.required'       => 'El correo electrónico es requerido.',
            'correo.email'          => 'El formato del correo es inválido.',
            'correo.unique'         => 'Este correo ya está registrado por otro usuario.',
            'matricula.required'    => 'La matrícula es requerida.',
            'matricula.unique'      => 'Esta matrícula ya está registrada por otro alumno.',
            'matricula.regex'       => 'La matrícula solo debe contener números.',
            'semestre.min'          => 'El semestre debe ser entre 1 y 12.',
            'semestre.max'          => 'El semestre debe ser entre 1 y 12.',
            'grupo.regex'           => 'El grupo debe ser exactamente una letra.',
        ]);

        // Update user account
        $user->correo = $request->input('correo');
        $user->save();

        // Update student profile
        $alumno->nombre_completo = $request->input('nombre');
        $alumno->matricula       = $request->input('matricula');
        $alumno->carrera         = $request->input('carrera');
        $alumno->semestre        = $request->input('semestre');
        $alumno->grupo           = strtoupper($request->input('grupo'));
        $alumno->asesor          = $request->input('asesor');
        $alumno->coasesor        = $request->input('coasesor');
        $alumno->save();

        // Log action in activity bitacora
        \App\Helpers\ActivityLogger::log(
            'Alumnos',
            'Alumno Modificado',
            "El coordinador actualizó los datos del alumno '{$alumno->nombre_completo}' (Matrícula: {$alumno->matricula}).",
            'info'
        );

        return redirect()->back()->with('success', "Alumno \"{$alumno->nombre_completo}\" actualizado correctamente.");
    }
}
