<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Documento;
use App\Models\Estudiante;
use App\Models\Hora;
use App\Models\Solicitud;
use App\Models\UnidadReceptora;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

        $nombre = $estudiante?->nombre_completo ?? Str::before($user->correo, '@');
        $matricula = $estudiante?->matricula ?? '—';
        $carrera = $estudiante?->carrera ?? '—';
        $iniciales = $this->iniciales($nombre);

        $horasCompletadas = 0;
        $solicitudesActivas = 0;
        $documentosPendientes = 0;

        if ($estudiante) {
            $solicitudIds = Solicitud::where('estudiante_id', $estudiante->id)
                ->whereIn('estatus', ['pendiente', 'aprobada', 'en_proceso'])
                ->pluck('id');

            $solicitudesActivas = $solicitudIds->count();

            $horasCompletadas = (float) Hora::whereIn('solicitud_id', $solicitudIds)->sum('cantidad_horas');

            $totalDocs = Documento::whereIn('solicitud_id', $solicitudIds)->count();
            $documentosPendientes = max(0, ($solicitudesActivas * self::DOCS_REQUERIDOS) - $totalDocs);
        }

        $porcentajeHoras = self::HORAS_META > 0
            ? min(100, (int) round(($horasCompletadas / self::HORAS_META) * 100))
            : 0;

        return view('estudiante.dashboard', [
            'nombre' => $nombre,
            'matricula' => $matricula,
            'carrera' => $carrera,
            'iniciales' => $iniciales,
            'horasCompletadas' => (int) $horasCompletadas,
            'horasMeta' => self::HORAS_META,
            'porcentajeHoras' => $porcentajeHoras,
            'solicitudesActivas' => $solicitudesActivas,
            'documentosPendientes' => $documentosPendientes,
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

        $search = request('q');

        $query = UnidadReceptora::query();
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre_empresa', 'like', "%{$search}%")
                  ->orWhere('direccion', 'like', "%{$search}%");
            });
        }

        $unidades = $query->orderBy('nombre_empresa')->get();

        return view('estudiante.convenios', [
            'unidades' => $unidades,
            'search'   => $search ?? '',
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

        $nombrePartes = preg_split('/\s+/', trim($nombre), 2, PREG_SPLIT_NO_EMPTY);
        $primerNombre = $nombrePartes[0] ?? $nombre;
        $apellidos = $nombrePartes[1] ?? '';

        return view('estudiante.mi_perfil', [
            'nombre' => $nombre,
            'matricula' => $matricula,
            'carrera' => $carrera,
            'iniciales' => $iniciales,
            'correo' => $user->correo,
            'primerNombre' => $primerNombre,
            'apellidos' => $apellidos,
            'direccion' => $estudiante?->direccion ?? '',
            'telefono' => $estudiante?->telefono ?? '',
        ]);
    }

    public function updatePerfil(\Illuminate\Http\Request $request)
    {
        if (Auth::user()?->rol_id != 3) {
            return redirect('/');
        }

        $user = Auth::user();
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

        $estudiante->nombre_completo = $nombreCompleto;
        // set optional fields (migration ensures columns exist when applied)
        $estudiante->direccion = $data['direccion'] ?? null;
        $estudiante->telefono = $data['telefono'] ?? null;
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
