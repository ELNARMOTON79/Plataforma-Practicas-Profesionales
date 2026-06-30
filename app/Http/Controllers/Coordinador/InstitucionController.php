<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\CredentialsNotification;
use App\Mail\NewAssociationNotification;

class InstitucionController extends Controller
{
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

        // Fetch all fields of each unidad_receptora per empresa for the modal, including latest convenio expiration date
        $unidades = DB::table('unidades_receptoras')
            ->whereIn('nombre_empresa', $nombres)
            ->select([
                'unidades_receptoras.*',
                DB::raw('(SELECT fecha_termino FROM convenios WHERE convenios.ur_id = unidades_receptoras.id ORDER BY convenios.id DESC LIMIT 1) as fecha_vencimiento')
            ])
            ->orderBy('unidad_receptora')
            ->get()
            ->groupBy('nombre_empresa');

        return view('coordinador.instituciones', compact('instituciones', 'convenios', 'unidades'));
    }

    /**
     * Register a new institution manually.
     */
    public function storeInstitucion(Request $request)
    {
        if (auth()->user()->rol_id != 2) {
            return redirect('/');
        }

        $request->validate([
            'correo'            => ['required', 'email', 'max:255'],
            'institucion'       => ['required', 'string', 'max:255'],
            'direccion'         => ['required', 'string', 'max:500'],
            'sistema'           => ['nullable', 'string', 'max:50'],
            'sector'            => ['nullable', 'string', 'max:50'],
            'unidad_receptora'  => ['nullable', 'string', 'max:100'],
            'titular'           => ['required', 'string', 'max:100'],
            'cargo'             => ['required', 'string', 'max:100'],
            'colonia'           => ['nullable', 'string', 'max:50'],
            'cp'                => ['nullable', 'integer'],
            'estado'            => ['nullable', 'string', 'max:20'],
            'municipio'         => ['nullable', 'string', 'max:100'],
            'telefono'          => ['nullable', 'string', 'max:50'],
        ], [
            'correo.required'       => 'El correo electrónico es obligatorio.',
            'correo.email'          => 'El formato del correo electrónico es inválido.',
            'institucion.required'  => 'El nombre de la institución es obligatorio.',
            'direccion.required'    => 'La dirección es obligatoria.',
            'titular.required'      => 'El nombre del titular es obligatorio.',
            'cargo.required'        => 'El cargo es obligatorio.',
            'cp.integer'            => 'El código postal debe ser un número entero.',
        ]);

        $correo = strtolower(trim($request->input('correo')));
        $nombreEmpresa = trim($request->input('institucion'));
        $unidadReceptoraName = trim($request->input('unidad_receptora') ?? '');

        // Check if the combination already exists in DB
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
            return back()->withErrors(['institucion' => 'Esta Unidad Receptora ya se encuentra registrada para la institución.'])->withInput();
        }

        DB::beginTransaction();
        try {
            $user = User::where('correo', $correo)->first();
            $isNewUser = false;
            $randomPassword = null;

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

            // Create UnidadReceptora
            $ur = new \App\Models\UnidadReceptora();
            $ur->usuario_id = $user->id;
            $ur->nombre_empresa = $nombreEmpresa;
            $ur->direccion = trim($request->input('direccion'));
            $ur->tipo_persona = 'Moral'; // Default standard value
            $ur->sistema = trim($request->input('sistema') ?? '');
            $ur->sector = trim($request->input('sector') ?? '');
            $ur->unidad_receptora = $unidadReceptoraName;
            $ur->titular = trim($request->input('titular'));
            $ur->cargo = trim($request->input('cargo'));
            $ur->colonia = trim($request->input('colonia') ?? '');
            $ur->cp = intval($request->input('cp') ?? 0);
            $ur->estado = trim($request->input('estado') ?? '');
            $ur->municipio = trim($request->input('municipio') ?? '');
            $ur->telefono = trim($request->input('telefono') ?? '');
            $ur->convenio = 'Con Convenio';
            $ur->save();

            $unitsAdded = [[
                'nombre_empresa' => $ur->nombre_empresa,
                'unidad_receptora' => $ur->unidad_receptora ?: 'General'
            ]];

            // Send Credentials or Association Notification Email
            if (\App\Helpers\SystemSettings::get('send_emails', true)) {
                try {
                    if ($isNewUser) {
                        Mail::to($user->correo)->send(new CredentialsNotification($user, $randomPassword, $ur->titular, $unitsAdded));
                    } else {
                        Mail::to($user->correo)->send(new NewAssociationNotification($user, $ur->titular, $unitsAdded));
                    }
                } catch (\Exception $e) {
                    \Log::error("Error al enviar correo de notificación en registro manual de institución: " . $e->getMessage());
                }
            }

            DB::commit();

            // Log activity
            \App\Helpers\ActivityLogger::log(
                'Instituciones',
                'Registro Manual',
                "Se registró exitosamente la institución '{$ur->nombre_empresa}' - Unidad: '" . ($ur->unidad_receptora ?: 'General') . "'.",
                'success'
            );

            return redirect()->route('coordinador.instituciones')
                ->with('success', "Institución \"{$ur->nombre_empresa}\" (" . ($ur->unidad_receptora ?: 'General') . ") registrada correctamente.");

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Error al guardar registro manual de institución: " . $e->getMessage());
            return back()->withErrors(['error' => 'Ocurrió un error inesperado al registrar la institución: ' . $e->getMessage()])->withInput();
        }
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
        DB::beginTransaction();
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

            DB::commit();

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
            DB::rollBack();
            \Log::error("Error al procesar importación masiva de instituciones: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'errors' => ['Ocurrió un error inesperado en el servidor al guardar los registros: ' . $e->getMessage()]
            ], 500);
        }
    }
}
