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
use Illuminate\Http\Request;
use App\Models\User;

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
        $porcentajeDocumentos = 0;
        $expediente = [];

        if ($estudiante) {
            $solicitud = Solicitud::where('estudiante_id', $estudiante->id)
                ->orderByDesc('id')
                ->first();

            if ($solicitud && in_array($solicitud->estatus, ['pendiente', 'aprobada', 'en_proceso', 'finalizada'])) {
                $solicitudesActivas = 1;
                $horasCompletadas = (float) Hora::where('solicitud_id', $solicitud->id)->sum('cantidad_horas');
                
                // Mapear el expediente digital de documentos del alumno
                $documentosCargados = Documento::where('solicitud_id', $solicitud->id)->get()->keyBy('nombre_doc');

                // 1. Carta de Presentación (Generada por sistema)
                $isApprovedSolicitud = in_array($solicitud->estatus, ['aprobada', 'en_proceso', 'finalizada']);
                $statusPres = $isApprovedSolicitud ? 'system' : 'pending';
                
                $expediente[] = [
                    'title' => 'Carta de Presentación',
                    'status' => $statusPres,
                    'label' => $statusPres === 'system' ? 'Listo para Generar' : 'Bloqueado',
                    'badgeClass' => $statusPres === 'system' ? 'text-blue-700 bg-blue-50/80 border-blue-150' : 'text-gray-500 bg-gray-50 border-gray-200',
                    'iconBg' => $statusPres === 'system' ? 'bg-blue-50 text-blue-600' : 'bg-gray-50 text-gray-400',
                ];

                // Los otros 5 documentos a subir por el estudiante
                $docsALoad = [
                    'Carta de Aceptación',
                    'Plan de Trabajo',
                    'Memoria de Prácticas',
                    'Evaluación de Desempeño',
                    'Carta de Término',
                ];

                $aprobadosCount = ($statusPres === 'approved') ? 1 : 0;
                $previousAprobada = ($statusPres === 'approved');

                foreach ($docsALoad as $docName) {
                    $dbDoc = $documentosCargados->get($docName);
                    
                    if ($dbDoc) {
                        if ($dbDoc->estatus === 'aprobado') {
                            $status = 'approved';
                            $label = 'Aprobado';
                            $badgeClass = 'text-green-700 bg-green-50 border-green-200';
                            $iconBg = 'bg-green-50 text-green-600';
                            $aprobadosCount++;
                        } elseif ($dbDoc->estatus === 'pendiente') {
                            $status = 'review';
                            $label = 'En Revisión';
                            $badgeClass = 'text-yellow-700 bg-yellow-50 border-yellow-100';
                            $iconBg = 'bg-yellow-50 text-yellow-600';
                        } else {
                            // rechazado
                            $status = 'rejected';
                            $label = 'Rechazado';
                            $badgeClass = 'text-red-700 bg-red-50 border-red-200';
                            $iconBg = 'bg-red-50 text-red-600';
                        }
                    } else {
                        if (!$previousAprobada) {
                            $status = 'locked';
                            $label = 'Bloqueado';
                            $badgeClass = 'text-gray-400 bg-gray-100 border-gray-200';
                            $iconBg = 'bg-gray-100 text-gray-400';
                        } else {
                            if ($docName === 'Plan de Trabajo' && $isApprovedSolicitud) {
                                $status = 'system';
                                $label = 'Listo para Generar';
                                $badgeClass = 'text-blue-700 bg-blue-50/80 border-blue-150';
                                $iconBg = 'bg-blue-50 text-blue-600';
                            } else {
                                $status = 'pending';
                                $label = 'Sin Subir';
                                $badgeClass = 'text-gray-500 bg-gray-50 border-gray-200';
                                $iconBg = 'bg-gray-50 text-gray-400';
                            }
                        }
                    }

                    $expediente[] = [
                        'title' => $docName,
                        'status' => $status,
                        'label' => $label,
                        'badgeClass' => $badgeClass,
                        'iconBg' => $iconBg,
                    ];
                    
                    $previousAprobada = ($dbDoc && $dbDoc->estatus === 'aprobado');
                }

                // Cálculo exacto de pendientes y porcentaje total
                $docsAprobadosCount = Documento::where('solicitud_id', $solicitud->id)
                    ->where('estatus', 'aprobado')
                    ->count();
                $documentosPendientes = max(0, 5 - $docsAprobadosCount);
                $porcentajeDocumentos = (int) round(($aprobadosCount / 6) * 100);
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
            'documentosPendientes' => $documentosPendientes,
            'porcentajeDocumentos' => $porcentajeDocumentos,
            'expediente' => $expediente,
            'solicitud' => $solicitud,
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

        $solicitud = Solicitud::create([
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
            'observaciones' => '',
        ]);

        \App\Helpers\ActivityLogger::log(
            'Solicitudes',
            'Nueva Solicitud',
            "El estudiante {$estudiante->nombre_completo} ha registrado una nueva solicitud de prácticas.",
            'info',
            ['solicitud_id' => $solicitud->id]
        );

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

    public function cartaPresentacion($id)
    {
        if (Auth::user()?->rol_id != 3 && Auth::user()?->rol_id != 2) {
            return redirect('/');
        }

        $user = Auth::user();
        $solicitud = Solicitud::with(['estudiante', 'unidadReceptora'])->findOrFail($id);

        // Security ownership check for student role
        if ($user->rol_id == 3) {
            $estudiante = Estudiante::where('usuario_id', $user->id)->first();
            if (!$estudiante || $solicitud->estudiante_id != $estudiante->id) {
                abort(403, 'No autorizado.');
            }
        }

        // Check if solicitud is approved
        if (!in_array($solicitud->estatus, ['aprobada', 'en_proceso', 'finalizada'])) {
            return redirect()->back()->with('error', 'La solicitud debe estar aprobada para generar la carta de presentación.');
        }

        return view('estudiante.carta_presentacion', compact('solicitud'));
    }

    public function planTrabajo($id)
    {
        if (Auth::user()?->rol_id != 3 && Auth::user()?->rol_id != 2) {
            return redirect('/');
        }

        $user = Auth::user();
        $solicitud = Solicitud::with(['estudiante', 'unidadReceptora'])->findOrFail($id);

        // Security ownership check for student role
        if ($user->rol_id == 3) {
            $estudiante = Estudiante::where('usuario_id', $user->id)->first();
            if (!$estudiante || $solicitud->estudiante_id != $estudiante->id) {
                abort(403, 'No autorizado.');
            }
        }

        // Check if solicitud is approved
        if (!in_array($solicitud->estatus, ['aprobada', 'en_proceso', 'finalizada'])) {
            return redirect()->back()->with('error', 'La solicitud debe estar aprobada para generar el plan de trabajo.');
        }

        // Get coordinator details
        $coordinador = User::where('rol_id', 2)->first();
        $coordinadorName = $coordinador?->coordinador?->nombre_completo ?? 'Coordinador de Prácticas Profesionales';
        $coordinadorEmail = $coordinador?->correo ?? 'correo@ucol.mx';

        return view('estudiante.plan_trabajo', compact('solicitud', 'coordinadorName', 'coordinadorEmail'));
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

        $expediente = [];
        if ($solicitud) {
            $documentosCargados = $solicitud->documentos->keyBy('nombre_doc');

            // 1. Carta de Presentación
            $isApprovedSolicitud = in_array($solicitud->estatus, ['aprobada', 'en_proceso', 'finalizada']);
            $dbPres = $documentosCargados->get('Carta de Presentación');
            if ($dbPres) {
                if ($dbPres->estatus === 'aprobado') {
                    $statusCartaPres = 'approved';
                } elseif ($dbPres->estatus === 'pendiente') {
                    $statusCartaPres = 'review';
                } else {
                    $statusCartaPres = 'rejected';
                }
            } else {
                $statusCartaPres = $isApprovedSolicitud ? 'system' : 'pending';
            }
            $expediente['Carta de Presentación'] = $statusCartaPres;

            // Los otros 5 documentos
            $docsALoad = [
                'Carta de Aceptación',
                'Plan de Trabajo',
                'Memoria de Prácticas',
                'Evaluación de Desempeño',
                'Carta de Término',
            ];

            $previousAprobada = ($statusCartaPres === 'approved');

            foreach ($docsALoad as $docName) {
                $dbDoc = $documentosCargados->get($docName);
                if ($dbDoc) {
                    if ($dbDoc->estatus === 'aprobado') {
                        $status = 'approved';
                    } elseif ($dbDoc->estatus === 'pendiente') {
                        $status = 'review';
                    } else {
                        $status = 'rejected';
                    }
                } else {
                    if (!$previousAprobada) {
                        $status = 'locked';
                    } else {
                        if ($docName === 'Plan de Trabajo' && $isApprovedSolicitud) {
                            $status = 'system';
                        } else {
                            $status = 'pending';
                        }
                    }
                }
                $expediente[$docName] = $status;
                
                $previousAprobada = ($dbDoc && $dbDoc->estatus === 'aprobado');
            }
        } else {
            $expediente = [
                'Carta de Presentación' => 'pending',
                'Carta de Aceptación'   => 'pending',
                'Plan de Trabajo'       => 'pending',
                'Memoria de Prácticas'  => 'pending',
                'Evaluación de Desempeño' => 'pending',
                'Carta de Término'      => 'pending',
            ];
        }

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
            'expediente' => $expediente,
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

    public function subirDocumento(Request $request)
    {
        if (Auth::user()?->rol_id != 3) {
            return redirect('/');
        }

        $request->validate([
            'solicitud_id' => 'required|exists:solicitudes,id',
            'nombre_doc' => 'required|string',
            'archivo' => 'required|file|mimes:pdf|max:5120', // max 5MB PDF
        ], [
            'archivo.required' => 'Debes seleccionar un archivo PDF.',
            'archivo.mimes' => 'El archivo debe estar en formato PDF.',
            'archivo.max' => 'El archivo no debe pesar más de 5MB.',
        ]);

        $user = Auth::user();
        $estudiante = Estudiante::where('usuario_id', $user->id)->first();
        if (!$estudiante) {
            return back()->with('error', 'No se encontró el perfil de estudiante.');
        }

        $solicitud = Solicitud::where('id', $request->input('solicitud_id'))
            ->where('estudiante_id', $estudiante->id)
            ->firstOrFail();

        // Save file in public/documentos
        $file = $request->file('archivo');
        $fileName = 'solicitud_' . $solicitud->id . '_' . Str::slug($request->input('nombre_doc')) . '_' . time() . '.pdf';
        
        $dbPath = '';
        $uploadedToDrive = false;

        // Intentar subir a Google Drive
        try {
            $driveService = new \App\Services\GoogleDriveService();
            $driveResult = $driveService->uploadFile($file->getRealPath(), $fileName, $file->getMimeType());
            if ($driveResult) {
                $dbPath = $driveResult['link'];
                $uploadedToDrive = true;
            }
        } catch (\Exception $driveEx) {
            \Log::error('Carga fallida a Google Drive, usando respaldo local: ' . $driveEx->getMessage());
        }

        // Si la carga a Drive no está configurada o falló, usar almacenamiento local
        if (!$uploadedToDrive) {
            $file->storeAs('documentos', $fileName, 'public');
            $dbPath = 'storage/documentos/' . $fileName;
        }

        // Check if document already exists
        $documento = Documento::where('solicitud_id', $solicitud->id)
            ->where('nombre_doc', $request->input('nombre_doc'))
            ->first();

        if ($documento) {
            // Eliminar el archivo local anterior si existía y no era un link de Drive
            if ($documento->ruta_archivo && !str_starts_with($documento->ruta_archivo, 'http')) {
                $oldPath = str_replace('storage/documentos/', 'documentos/', $documento->ruta_archivo);
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
            }

            $documento->update([
                'ruta_archivo' => $dbPath,
                'fecha_carga' => now(),
                'estatus' => 'pendiente',
                'observaciones' => null,
            ]);
        } else {
            Documento::create([
                'solicitud_id' => $solicitud->id,
                'ur_id' => $solicitud->ur_id,
                'nombre_doc' => $request->input('nombre_doc'),
                'ruta_archivo' => $dbPath,
                'fecha_carga' => now(),
                'estatus' => 'pendiente',
            ]);
        }

        \App\Helpers\ActivityLogger::log(
            'Documentos',
            'Carga Documento',
            "El estudiante cargó el documento '{$request->input('nombre_doc')}' para su revisión.",
            'info',
            ['solicitud_id' => $solicitud->id, 'documento' => $request->input('nombre_doc')]
        );

        return redirect()->route('estudiante.proyecto')->with('success', "El documento '{$request->input('nombre_doc')}' se ha subido correctamente para verificación.");
    }
}
