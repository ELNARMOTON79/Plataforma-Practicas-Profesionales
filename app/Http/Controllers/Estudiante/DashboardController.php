<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Documento;
use App\Models\Estudiante;
use App\Models\Hora;
use App\Models\Solicitud;
use App\Models\UnidadReceptora;
use App\Models\Convenio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public const HORAS_META = 480;

    private const DOCS_REQUERIDOS = 4;

    public function index()
    {
        if (Auth::user()?->rol_id != 3) {
            return redirect('/');
        }

        $user = Auth::user();
        $estudiante = Estudiante::where('usuario_id', $user->id)->first();

        $nombre    = $estudiante?->nombre_completo ?? Str::before($user->correo, '@');
        $matricula = $estudiante?->matricula ?? '—';
        $carrera   = $estudiante?->carrera   ?? '—';
        $semestre  = $estudiante?->semestre  ?? null;
        $grupo     = $estudiante?->grupo     ?? null;
        $iniciales = $this->iniciales($nombre);

        $horasCompletadas = 0;
        $solicitudesActivas = 0;
        $solicitudesPendientes = 0;
        $documentosPendientes = 0;
        $documentosStatus = [];
        $activeSolicitud = null;
        $hasPracticaActiva = false;

        if ($estudiante) {
            $solicitudesActivas = Solicitud::where('estudiante_id', $estudiante->id)
                ->whereIn('estatus', ['aprobada', 'en_proceso'])
                ->count();

            $solicitudesPendientes = Solicitud::where('estudiante_id', $estudiante->id)
                ->where('estatus', 'pendiente')
                ->count();

            $activeSolicitud = Solicitud::where('estudiante_id', $estudiante->id)
                ->whereIn('estatus', ['aprobada', 'en_proceso'])
                ->with('documentos')
                ->latest('id')
                ->first();

            if ($activeSolicitud) {
                $hasPracticaActiva = true;
                $horasCompletadas = (float) $activeSolicitud->horas()->sum('cantidad_horas');

                $requiredDocuments = [
                    'Carta de Presentación',
                    'Carta de Aceptación',
                    'Memoria de Prácticas',
                    'Carta de Término',
                ];

                $documentosStatus = collect($requiredDocuments)->map(function ($required) use ($activeSolicitud) {
                    $document = $activeSolicitud->documentos->first(function ($doc) use ($required) {
                        return mb_strtolower(trim($doc->nombre_doc)) === mb_strtolower(trim($required));
                    });

                    $uploaded = $document !== null;

                    return [
                        'nombre' => $required,
                        'status' => $uploaded ? 'subido' : 'pendiente',
                        'label' => $uploaded ? 'Subido' : 'Sin subir',
                        'color' => $uploaded ? 'green' : 'gray',
                        'fecha' => $uploaded && $document->fecha_carga ? $document->fecha_carga->format('d M Y') : null,
                    ];
                })->all();

                $documentosPendientes = collect($documentosStatus)->where('status', 'pendiente')->count();
            }
        }

        $porcentajeHoras = self::HORAS_META > 0
            ? min(100, (int) round(($horasCompletadas / self::HORAS_META) * 100))
            : 0;

        return view('estudiante.dashboard', [
            'nombre'    => $nombre,
            'matricula' => $matricula,
            'carrera'   => $carrera,
            'semestre'  => $semestre,
            'grupo'     => $grupo,
            'iniciales' => $iniciales,
            'horasCompletadas' => (int) $horasCompletadas,
            'horasMeta' => self::HORAS_META,
            'porcentajeHoras' => $porcentajeHoras,
            'solicitudesActivas' => $solicitudesActivas,
            'solicitudesPendientes' => $solicitudesPendientes,
            'documentosPendientes' => $documentosPendientes,
            'documentosStatus' => $documentosStatus,
            'activeSolicitud' => $activeSolicitud,
            'hasPracticaActiva' => $hasPracticaActiva,
            'actividadReciente' => $this->actividadReciente($estudiante),
            'proximosVencimientos' => $this->proximosVencimientos($estudiante),
        ]);
    }

    public function createSolicitud()
    {
        if (Auth::user()?->rol_id != 3) {
            return redirect('/');
        }

        $user = Auth::user();
        $estudiante = Estudiante::where('usuario_id', $user->id)->first();

        $nombre = $estudiante?->nombre_completo ?? Str::before($user->correo, '@');
        $matricula = $estudiante?->matricula ?? '—';
        $carrera = $estudiante?->carrera ?? '—';
        $iniciales = $this->iniciales($nombre);

        return view('estudiante.nueva_solicitud', [
            'nombre' => $nombre,
            'matricula' => $matricula,
            'carrera' => $carrera,
            'iniciales' => $iniciales,
        ]);
    }

    public function detallesSolicitud()
    {
        if (Auth::user()?->rol_id != 3) {
            return redirect('/');
        }

        $user = Auth::user();
        $estudiante = Estudiante::where('usuario_id', $user->id)->first();

        $nombre = $estudiante?->nombre_completo ?? Str::before($user->correo, '@');
        $matricula = $estudiante?->matricula ?? '—';
        $carrera = $estudiante?->carrera ?? '—';
        $iniciales = $this->iniciales($nombre);

        return view('estudiante.nueva_solicitud_detalles', [
            'nombre' => $nombre,
            'matricula' => $matricula,
            'carrera' => $carrera,
            'iniciales' => $iniciales,
        ]);
    }

    public function documentacionSolicitud()
    {
        if (Auth::user()?->rol_id != 3) {
            return redirect('/');
        }

        $user = Auth::user();
        $estudiante = Estudiante::where('usuario_id', $user->id)->first();

        $nombre = $estudiante?->nombre_completo ?? Str::before($user->correo, '@');
        $matricula = $estudiante?->matricula ?? '—';
        $carrera = $estudiante?->carrera ?? '—';
        $iniciales = $this->iniciales($nombre);

        return view('estudiante.documentacion', [
            'nombre' => $nombre,
            'matricula' => $matricula,
            'carrera' => $carrera,
            'iniciales' => $iniciales,
        ]);
    }

    public function convenios()
    {
        if (Auth::user()?->rol_id != 3) {
            return redirect('/');
        }

        $search        = trim(request('q', ''));
        $carreraFilter = trim(request('carrera', ''));

        $query = UnidadReceptora::with('convenios');

        if (strlen($search) >= 2) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre_empresa', 'like', "%{$search}%")
                  ->orWhere('direccion', 'like', "%{$search}%");
            });
        }

        if ($carreraFilter) {
            $query->whereHas('solicitudes', function ($q) use ($carreraFilter) {
                $q->whereHas('estudiante', fn ($q2) => $q2->where('carrera', $carreraFilter));
            });
        }

        $unidades = $query->orderBy('nombre_empresa')->get();

        $carreras = Estudiante::whereNotNull('carrera')
            ->where('carrera', '!=', '')
            ->distinct()
            ->orderBy('carrera')
            ->pluck('carrera');

        return view('estudiante.convenios', [
            'unidades'      => $unidades,
            'search'        => $search,
            'carreraFilter' => $carreraFilter,
            'carreras'      => $carreras,
        ]);
    }

    public function miProyecto()
    {
        if (Auth::user()?->rol_id != 3) {
            return redirect('/');
        }

        $user       = Auth::user();
        $estudiante = Estudiante::where('usuario_id', $user->id)->first();

        $nombre    = $estudiante?->nombre_completo ?? Str::before($user->correo, '@');
        $matricula = $estudiante?->matricula ?? '—';
        $carrera   = $estudiante?->carrera   ?? '—';
        $iniciales = $this->iniciales($nombre);

        $solicitudActiva  = null;
        $horasCompletadas = 0;
        $documentos       = collect();

        if ($estudiante) {
            $solicitudActiva = Solicitud::where('estudiante_id', $estudiante->id)
                ->whereIn('estatus', ['aprobada', 'en_proceso'])
                ->with(['unidadReceptora', 'documentos'])
                ->latest('id')
                ->first();

            if ($solicitudActiva) {
                $horasCompletadas = (float) $solicitudActiva->horas()->sum('cantidad_horas');
                $documentos       = $solicitudActiva->documentos;
            }
        }

        $porcentajeHoras = self::HORAS_META > 0
            ? min(100, round(($horasCompletadas / self::HORAS_META) * 100, 1))
            : 0;

        return view('estudiante.proyecto', [
            'nombre'           => $nombre,
            'matricula'        => $matricula,
            'carrera'          => $carrera,
            'iniciales'        => $iniciales,
            'solicitudActiva'  => $solicitudActiva,
            'horasCompletadas' => (int) $horasCompletadas,
            'horasMeta'        => self::HORAS_META,
            'porcentajeHoras'  => $porcentajeHoras,
            'documentos'       => $documentos,
        ]);
    }

    public function subirDocumento(Request $request)
    {
        if (Auth::user()?->rol_id != 3) {
            return response()->json(['error' => 'No autorizado.'], 403);
        }

        $user = Auth::user();
        $estudiante = Estudiante::where('usuario_id', $user->id)->first();

        if (! $estudiante) {
            return response()->json(['error' => 'Estudiante no encontrado.'], 404);
        }

        $solicitudActiva = Solicitud::where('estudiante_id', $estudiante->id)
            ->whereIn('estatus', ['aprobada', 'en_proceso'])
            ->latest('id')
            ->first();

        if (! $solicitudActiva) {
            return response()->json(['error' => 'No hay una solicitud de prácticas activa.'], 404);
        }

        $allowedDocs = [
            'Carta de Presentación',
            'Carta de Aceptación',
            'Plan de Trabajo',
            'Memoria de Prácticas',
            'Evaluación de Desempeño',
            'Carta de Término',
        ];

        $validated = $request->validate([
            'nombre_doc' => ['required', 'string', Rule::in($allowedDocs)],
            'archivo' => ['required', 'file', 'mimes:pdf', 'max:5120'],
        ], [
            'nombre_doc.required' => 'El nombre del documento es requerido.',
            'nombre_doc.in' => 'El tipo de documento no es válido.',
            'archivo.required' => 'Debes seleccionar un archivo PDF.',
            'archivo.file' => 'El archivo seleccionado no es válido.',
            'archivo.mimes' => 'Solo se permiten archivos PDF.',
            'archivo.max' => 'El archivo no puede exceder 5 MB.',
        ]);

        $archivo = $request->file('archivo');
        $filename = time() . '_' . Str::slug(pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $archivo->getClientOriginalExtension();
        $storagePath = 'documentos/estudiante_' . $user->id;
        $path = $archivo->storeAs($storagePath, $filename, 'public');

        if (! $path) {
            return response()->json(['error' => 'No se pudo guardar el archivo en el servidor.'], 500);
        }

        $documento = $solicitudActiva->documentos()->firstOrNew([
            'nombre_doc' => $validated['nombre_doc'],
        ]);

        if ($documento->exists && $documento->ruta_archivo && Storage::disk('public')->exists($documento->ruta_archivo)) {
            Storage::disk('public')->delete($documento->ruta_archivo);
        }

        $documento->solicitud_id = $solicitudActiva->id;
        $documento->ur_id = $solicitudActiva->ur_id;
        $documento->ruta_archivo = $path;
        $documento->fecha_carga = Carbon::now()->toDateString();
        $documento->save();

        return response()->json([
            'success' => true,
            'message' => 'Documento subido correctamente.',
            'documento' => [
                'nombre_doc' => $documento->nombre_doc,
                'ruta_archivo' => asset('storage/' . $path),
                'fecha_carga' => Carbon::parse($documento->fecha_carga)->format('d/m/Y'),
            ],
        ]);
    }

    public function miPerfil()
    {
        if (Auth::user()?->rol_id != 3) {
            return redirect('/');
        }

        $user = Auth::user();
        $estudiante = Estudiante::where('usuario_id', $user->id)->first();

        $nombre = $estudiante?->nombre_completo ?? Str::before($user->correo, '@');
        $matricula = $estudiante?->matricula ?? '—';
        $carrera = $estudiante?->carrera ?? '—';
        $iniciales = $this->iniciales($nombre);

        // Use dedicated columns; fall back to splitting nombre_completo for legacy records
        if ($estudiante?->primer_nombre !== null) {
            $primerNombre = $estudiante->primer_nombre;
            $apellidos    = $estudiante->apellidos ?? '';
        } else {
            $partes       = preg_split('/\s+/', trim($nombre), 2, PREG_SPLIT_NO_EMPTY);
            $primerNombre = $partes[0] ?? $nombre;
            $apellidos    = $partes[1] ?? '';
        }

        return view('estudiante.mi_perfil', [
            'nombre'      => $nombre,
            'matricula'   => $matricula,
            'carrera'     => $carrera,
            'iniciales'   => $iniciales,
            'correo'      => $user->correo,
            'primerNombre'=> $primerNombre,
            'apellidos'   => $apellidos,
            'direccion'   => $estudiante?->direccion ?? '',
            'telefono'    => $estudiante?->telefono ?? '',
        ]);
    }

    public function updatePerfil(\Illuminate\Http\Request $request)
    {
        if (Auth::user()?->rol_id != 3) {
            return redirect('/');
        }

        $authUser = Auth::user();
        if (! $authUser instanceof \App\Models\User) {
            return redirect('/');
        }

        $user = $authUser;
        $estudiante = Estudiante::where('usuario_id', $user->id)->first();
        if (! $estudiante) {
            $estudiante = new Estudiante();
            $estudiante->usuario_id = $user->id;
        }

        $data = $request->validate([
            'primerNombre' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\pL\s\'\-]+$/u'],
            'apellidos'    => ['nullable', 'string', 'min:2', 'max:100', 'regex:/^[\pL\s\'\-]+$/u'],
            'telefono'     => ['nullable', 'digits:10'],
            'direccion'    => ['nullable', 'string', 'max:500'],
        ], [
            'primerNombre.required' => 'El nombre es obligatorio.',
            'primerNombre.min'      => 'El nombre debe tener al menos 2 caracteres.',
            'primerNombre.max'      => 'El nombre no puede superar los 100 caracteres.',
            'primerNombre.regex'    => 'El nombre solo puede contener letras y espacios.',
            'apellidos.min'         => 'Los apellidos deben tener al menos 2 caracteres.',
            'apellidos.max'         => 'Los apellidos no pueden superar los 100 caracteres.',
            'apellidos.regex'       => 'Los apellidos solo pueden contener letras y espacios.',
            'telefono.digits'       => 'El teléfono debe tener exactamente 10 dígitos.',
            'direccion.max'         => 'La dirección no puede superar los 500 caracteres.',
        ]);

        $nombreCompleto = trim($data['primerNombre'] . ' ' . ($data['apellidos'] ?? ''));

        $estudiante->primer_nombre   = $data['primerNombre'];
        $estudiante->apellidos       = $data['apellidos'] ?? null;
        $estudiante->nombre_completo = $nombreCompleto;
        $estudiante->direccion       = $data['direccion'] ?? null;
        $estudiante->telefono        = $data['telefono'] ?? null;
        $estudiante->save();

        // If request is AJAX, return JSON so client can update the UI without reload
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'nombre' => $nombreCompleto,
                'iniciales' => $this->iniciales($nombreCompleto),
            ]);
        }

        return redirect()->route('estudiante.miPerfil')->with('success', 'Perfil actualizado correctamente.');
    }

    public function changePassword(\Illuminate\Http\Request $request)
    {
        if (Auth::user()?->rol_id != 3) {
            return redirect('/');
        }

        $request->validate([
            'current_password' => ['required'],
            'new_password'     => ['required', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'La contraseña actual es obligatoria.',
            'new_password.required'     => 'La nueva contraseña es obligatoria.',
            'new_password.min'          => 'La contraseña debe tener al menos 8 caracteres.',
            'new_password.confirmed'    => 'Las contraseñas no coinciden.',
        ]);

        $authUser = Auth::user();
        if (! $authUser instanceof \App\Models\User) {
            return redirect('/');
        }

        $user = $authUser;

        if (! Hash::check($request->current_password, $user->getAuthPassword())) {
            return response()->json([
                'errors' => ['current_password' => ['La contraseña actual es incorrecta.']],
            ], 422);
        }

        $user->contraseña = $request->new_password;
        $user->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('estudiante.miPerfil')->with('success', 'Contraseña actualizada correctamente.');
    }

    public function misSolicitudes()
    {
        if (Auth::user()?->rol_id != 3) {
            return redirect('/');
        }

        $user = Auth::user();
        $estudiante = Estudiante::where('usuario_id', $user->id)->first();

        if (! $estudiante) {
            return redirect('/estudiante/dashboard');
        }

        $search = request('q');

        $solicitudesQuery = $estudiante->solicitudes()
            ->with('unidadReceptora')
            ->orderByDesc('id');

        if ($search) {
            $solicitudesQuery->whereHas('unidadReceptora', function ($query) use ($search) {
                $query->where('nombre_empresa', 'like', "%{$search}%");
            });
        }

        $solicitudes = $solicitudesQuery->get();

        return view('estudiante.mi_solicitud', [
            'nombre' => $estudiante->nombre_completo,
            'matricula' => $estudiante->matricula,
            'carrera' => $estudiante->carrera,
            'iniciales' => $this->iniciales($estudiante->nombre_completo),
            'solicitudes' => $solicitudes,
        ]);
    }

    private function iniciales(string $nombre): string
    {
        $partes = preg_split('/\s+/', trim($nombre)) ?: [];
        $iniciales = collect($partes)
            ->filter()
            ->take(2)
            ->map(fn ($p) => Str::upper(Str::substr($p, 0, 1)))
            ->implode('');

        return $iniciales !== '' ? $iniciales : 'E';
    }

    private function actividadReciente(?Estudiante $estudiante): array
    {
        if (! $estudiante) {
            return [];
        }

        $solicitudIds = Solicitud::where('estudiante_id', $estudiante->id)->pluck('id');

        $horas = Hora::whereIn('solicitud_id', $solicitudIds)
            ->orderByDesc('fecha_registro')
            ->limit(5)
            ->get();

        $actividad = $horas->map(function (Hora $hora) {
            $fecha = Carbon::parse($hora->fecha_registro);

            return [
                'color' => 'green',
                'titulo' => 'Registro de '.(int) $hora->cantidad_horas.' horas registrado',
                'tiempo' => $fecha->diffForHumans(),
            ];
        })->all();

        $solicitudes = Solicitud::where('estudiante_id', $estudiante->id)
            ->orderByDesc('fecha_inicio')
            ->limit(3)
            ->get();

        foreach ($solicitudes as $solicitud) {
            $color = match ($solicitud->estatus) {
                'aprobada', 'en_proceso' => 'green',
                'pendiente' => 'blue',
                'rechazada' => 'orange',
                default => 'blue',
            };

            $actividad[] = [
                'color' => $color,
                'titulo' => 'Solicitud '.$this->estatusLabel($solicitud->estatus),
                'tiempo' => Carbon::parse($solicitud->fecha_inicio)->diffForHumans(),
            ];
        }

        return array_slice($actividad, 0, 5);
    }

    private function proximosVencimientos(?Estudiante $estudiante): array
    {
        if (! $estudiante) {
            return [];
        }

        return Solicitud::where('estudiante_id', $estudiante->id)
            ->where('fecha_fin', '>=', now()->toDateString())
            ->orderBy('fecha_fin')
            ->limit(5)
            ->get()
            ->map(function (Solicitud $solicitud) {
                $fecha = Carbon::parse($solicitud->fecha_fin);
                $dias = (int) now()->diffInDays($fecha, false);

                return [
                    'titulo' => 'Fin de prácticas — '.$solicitud->responsable,
                    'fecha' => $fecha->translatedFormat('d M Y'),
                    'dias' => max(0, $dias),
                    'urgente' => $dias <= 7,
                ];
            })
            ->all();
    }

    private function estatusLabel(string $estatus): string
    {
        return match ($estatus) {
            'pendiente' => 'enviada — en revisión',
            'aprobada' => 'aprobada',
            'rechazada' => 'rechazada',
            'en_proceso' => 'en proceso',
            'finalizada' => 'finalizada',
            default => $estatus,
        };
    }
}
