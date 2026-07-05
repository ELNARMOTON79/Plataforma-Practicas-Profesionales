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
use Illuminate\Support\Facades\Hash;
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

        $nombre    = $estudiante?->nombre_completo ?? Str::before($user->correo, '@');
        $matricula = $estudiante?->matricula ?? '—';
        $carrera   = $estudiante?->carrera   ?? '—';
        $semestre  = $estudiante?->semestre  ?? null;
        $grupo     = $estudiante?->grupo     ?? null;
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

        if ($estudiante && $estudiante->solicitudes()->exists()) {
            return redirect()->route('estudiante.misSolicitudes')->with('error', 'Ya cuentas con una solicitud registrada. Solo se permite una por estudiante.');
        }

        $nombre = $estudiante?->nombre_completo ?? Str::before($user->correo, '@');
        $matricula = $estudiante?->matricula ?? '—';
        $carrera = $estudiante?->carrera ?? '—';
        $iniciales = $this->iniciales($nombre);

        $unidades = UnidadReceptora::with('user')->orderBy('nombre_empresa')->get();
        $urId = request('ur_id');
        $unidadSelected = null;

        if ($urId && is_numeric($urId)) {
            $unidadSelected = UnidadReceptora::with('user')->find($urId);
        } elseif (request('empresa_nombre')) {
            $unidadSelected = new UnidadReceptora([
                'nombre_empresa' => request('empresa_nombre'),
                'direccion'      => request('empresa_direccion'),
                'titular'        => request('supervisor_nombre'),
                'telefono'       => request('supervisor_telefono'),
            ]);
        }

        return view('estudiante.nueva_solicitud', [
            'nombre'         => $nombre,
            'matricula'      => $matricula,
            'carrera'        => $carrera,
            'iniciales'      => $iniciales,
            'unidades'       => $unidades,
            'unidadSelected' => $unidadSelected,
        ]);
    }

    public function detallesSolicitud()
    {
        if (Auth::user()?->rol_id != 3) {
            return redirect('/');
        }

        $user = Auth::user();
        $estudiante = Estudiante::where('usuario_id', $user->id)->first();

        if ($estudiante && $estudiante->solicitudes()->exists()) {
            return redirect()->route('estudiante.misSolicitudes')->with('error', 'Ya cuentas con una solicitud registrada. Solo se permite una por estudiante.');
        }

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

    public function storeSolicitud(\Illuminate\Http\Request $request)
    {
        if (Auth::user()?->rol_id != 3) {
            return redirect('/');
        }

        $user = Auth::user();
        $estudiante = Estudiante::where('usuario_id', $user->id)->first();

        if (! $estudiante) {
            return redirect()->route('estudiante.dashboard')->with('error', 'No se encontró el perfil de estudiante.');
        }

        if ($estudiante->solicitudes()->exists()) {
            return redirect()->route('estudiante.misSolicitudes')->with('error', 'Ya cuentas con una solicitud registrada. Solo se permite una por estudiante.');
        }

        $request->validate([
            'ur_id'        => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date',
            'titulo'       => 'required|string|max:255',
            'objetivo'     => 'required|string',
            'justificacion'=> 'required|string',
            'actividades'  => 'required|string',
            'impacto_social' => 'required|string',
        ]);

        Solicitud::create([
            'estudiante_id' => $estudiante->id,
            'ur_id'         => $request->input('ur_id'),
            'responsable'   => $request->input('supervisor_nombre', 'Supervisor de práctica'),
            'fecha_inicio'  => $request->input('fecha_inicio'),
            'fecha_fin'     => $request->input('fecha_fin'),
            'estatus'       => 'pendiente',
            'titulo'        => $request->input('titulo'),
            'objetivo'      => $request->input('objetivo'),
            'justificacion' => $request->input('justificacion'),
            'actividades'   => $request->input('actividades'),
            'impacto_social'=> $request->input('impacto_social'),
        ]);

        return redirect()->route('estudiante.misSolicitudes')->with('solicitud_registrada', true);
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

        $user = Auth::user();
        $estudiante = Estudiante::where('usuario_id', $user->id)->first();
        $tieneSolicitud = $estudiante?->solicitudes()->exists() ?? false;

        return view('estudiante.convenios', [
            'unidades' => $unidades,
            'search'   => $search ?? '',
            'tieneSolicitud' => $tieneSolicitud,
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

        $user = Auth::user();

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

    public function proyecto()
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

        $solicitud = $estudiante ? $estudiante->solicitudes()->with(['unidadReceptora', 'horas', 'documentos'])->orderByDesc('id')->first() : null;

        $horasCompletadas = $solicitud ? (float) $solicitud->horas()->sum('cantidad_horas') : 0;
        $horasMeta = self::HORAS_META;
        $porcentajeHoras = $horasMeta > 0 ? min(100, (float) round(($horasCompletadas / $horasMeta) * 100, 1)) : 0;
        $horasFaltantes = max(0, $horasMeta - $horasCompletadas);

        $diasTranscurridos = 0;
        $diasTotales = 80;
        if ($solicitud && $solicitud->fecha_inicio) {
            $inicio = Carbon::parse($solicitud->fecha_inicio);
            $hoy = Carbon::now();
            if ($hoy->greaterThanOrEqualTo($inicio)) {
                $diasTranscurridos = min($diasTotales, (int) $inicio->diffInWeekdays($hoy));
            }
        }

        $documentos = $solicitud ? $solicitud->documentos : collect([]);
        $totalDocsSubidos = $documentos->count();
        $totalDocsMeta = 6;

        $objetivosTexto = $solicitud?->objetivo
            ?? 'Desarrollo de actividades del plan de trabajo institucional en la unidad receptora.';

        $actividadesLista = $solicitud?->actividades
            ? array_filter(array_map('trim', preg_split('/[\r\n]+/', $solicitud->actividades)))
            : ['Actividades afines al perfil de egreso y lineamientos de la institución'];

        return view('estudiante.proyecto', [
            'nombre' => $nombre,
            'matricula' => $matricula,
            'carrera' => $carrera,
            'iniciales' => $iniciales,
            'solicitud' => $solicitud,
            'horasCompletadas' => $horasCompletadas,
            'horasMeta' => $horasMeta,
            'porcentajeHoras' => $porcentajeHoras,
            'horasFaltantes' => $horasFaltantes,
            'diasTranscurridos' => $diasTranscurridos,
            'diasTotales' => $diasTotales,
            'documentos' => $documentos,
            'totalDocsSubidos' => $totalDocsSubidos,
            'totalDocsMeta' => $totalDocsMeta,
            'objetivosTexto' => $objetivosTexto,
            'actividadesLista' => $actividadesLista,
        ]);
    }

    public function notificaciones()
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

        return view('estudiante.notificaciones', [
            'nombre' => $nombre,
            'matricula' => $matricula,
            'carrera' => $carrera,
            'iniciales' => $iniciales,
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
