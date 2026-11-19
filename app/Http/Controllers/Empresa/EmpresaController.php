<?php

namespace App\Http\Controllers\Empresa;

use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Convenio;
use App\Models\Proyecto;
use App\Models\Solicitud;
use App\Models\UnidadReceptora;
use App\Support\Sesiones;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

/**
 * Páginas de consulta de la unidad receptora (empresa). Todo se limita a las
 * unidades receptoras ligadas a la cuenta que inició sesión.
 */
class EmpresaController extends Controller
{
    private const ESTATUS_PRACTICANTE = ['aprobada', 'en_proceso', 'finalizada'];

    public function dashboard()
    {
        if (auth()->user()->rol_id != 4) {
            return redirect('/');
        }

        $unidades = $this->unidades();
        $solicitudes = $this->practicantes($unidades);
        $convenio = $this->convenioVigente($unidades);

        $enCurso = $solicitudes->whereIn('estatus', ['aprobada', 'en_proceso']);

        return view('empresa.dashboard', [
            'empresa' => $unidades->first()?->nombre_empresa ?? 'Mi empresa',
            'unidades' => $unidades,
            'practicantesEnCurso' => $enCurso->count(),
            'practicantesConcluidos' => $solicitudes->where('estatus', 'finalizada')->count(),
            'horasRegistradas' => $solicitudes->sum(fn ($s) => $s->horasCompletadas()),
            'proyectosCount' => Proyecto::whereIn('unidad_receptora_id', $unidades->pluck('id'))->count(),
            'convenio' => $convenio,
            'folio' => $convenio ? (Convenio::folios()[$convenio->codigo_convenio] ?? $convenio->codigo_convenio) : null,
            'recientes' => $enCurso->take(5),
        ]);
    }

    public function proyectos()
    {
        if (auth()->user()->rol_id != 4) {
            return redirect('/');
        }

        $proyectos = Proyecto::with(['estudiante', 'empresa'])
            ->whereIn('unidad_receptora_id', $this->unidades()->pluck('id'))
            ->orderByDesc('activo')
            ->orderBy('titulo')
            ->get();

        return view('empresa.proyectos', compact('proyectos'));
    }

    public function convenio()
    {
        if (auth()->user()->rol_id != 4) {
            return redirect('/');
        }

        $unidades = $this->unidades();
        $convenio = $this->convenioVigente($unidades);

        return view('empresa.convenios', [
            'empresa' => $unidades->first()?->nombre_empresa ?? 'Mi empresa',
            'unidades' => $unidades,
            'convenio' => $convenio,
            'folio' => $convenio ? (Convenio::folios()[$convenio->codigo_convenio] ?? $convenio->codigo_convenio) : null,
        ]);
    }

    public function reportes(Request $request)
    {
        if (auth()->user()->rol_id != 4) {
            return redirect('/');
        }

        $unidades = $this->unidades();
        $solicitudes = $this->practicantes($unidades);

        // Datos por alumno: Alumno tiene el accessor de sexo; el proyecto asignado da el título
        $alumnos = Alumno::whereIn('id', $solicitudes->pluck('estudiante_id'))->get()->keyBy('id');
        $proyectoPorAlumno = Proyecto::whereIn('estudiante_id', $solicitudes->pluck('estudiante_id'))->pluck('titulo', 'estudiante_id');

        $filas = $solicitudes->map(function (Solicitud $s) use ($alumnos, $proyectoPorAlumno) {
            $alumno = $alumnos->get($s->estudiante_id);
            $meta = $s->horasMeta();
            $horas = $s->horasCompletadas();

            return [
                'alumno' => $s->estudiante?->nombre_completo ?? '—',
                'matricula' => $s->estudiante?->matricula ?? '',
                'carrera' => $s->estudiante?->carrera ?? 'Sin carrera',
                'genero' => $alumno?->sexo === 'FEMENINO' ? 'Femenino' : 'Masculino',
                'periodo' => $this->periodo($s->fecha_inicio),
                'proyecto' => $proyectoPorAlumno[$s->estudiante_id] ?? 'Sin proyecto asignado',
                'unidad' => $s->unidadReceptora?->unidad_receptora ?: 'General',
                'horas' => $horas,
                'meta' => $meta,
                'avance' => $meta > 0 ? (int) min(100, round($horas / $meta * 100)) : 0,
                'estatus' => match ($s->estatus) {
                    'aprobada' => 'Por iniciar',
                    'en_proceso' => 'En curso',
                    'finalizada' => 'Concluida',
                    default => $s->estatus,
                },
            ];
        });

        $opciones = [
            'carreras' => $filas->pluck('carrera')->unique()->sort()->values(),
            'periodos' => $filas->pluck('periodo')->unique()->sort()->values(),
            'proyectos' => $filas->pluck('proyecto')->unique()->sort()->values(),
        ];

        $filtros = $request->only(['carrera', 'genero', 'periodo', 'proyecto']);
        $filtradas = $filas->filter(fn ($f) => (empty($filtros['carrera']) || $f['carrera'] === $filtros['carrera'])
            && (empty($filtros['genero']) || $f['genero'] === $filtros['genero'])
            && (empty($filtros['periodo']) || $f['periodo'] === $filtros['periodo'])
            && (empty($filtros['proyecto']) || $f['proyecto'] === $filtros['proyecto']))->values();

        if ($request->query('formato') === 'csv') {
            return $this->descargarCsv($filtradas);
        }

        $total = $filtradas->count();
        $estadisticas = [
            'total' => $total,
            'horas' => $filtradas->sum('horas'),
            'avancePromedio' => $total ? (int) round($filtradas->avg('avance')) : 0,
            'concluidos' => $filtradas->where('estatus', 'Concluida')->count(),
            'porCarrera' => $filtradas->countBy('carrera')->sortDesc(),
            'porGenero' => $filtradas->countBy('genero'),
        ];

        return view('empresa.reportes', compact('filtradas', 'opciones', 'filtros', 'estadisticas'));
    }

    public function perfil()
    {
        if (auth()->user()->rol_id != 4) {
            return redirect('/');
        }

        $unidades = $this->unidades();

        return view('empresa.perfil', [
            'empresa' => $unidades->first()?->nombre_empresa ?? 'Mi empresa',
            'unidades' => $unidades,
        ]);
    }

    public function actualizarContrasena(Request $request)
    {
        if (auth()->user()->rol_id != 4) {
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
            'password.different' => 'La nueva contraseña debe ser diferente a la actual.',
        ]);

        if (! Hash::check($request->input('current_password'), $user->contraseña)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
        }

        $user->contraseña = Hash::make($request->input('password'));
        $user->save();

        Sesiones::cerrarOtras($user);

        ActivityLogger::log('Configuración', 'Contraseña Cambiada', 'La empresa cambió su contraseña de acceso.', 'warning');

        return redirect()->route('empresa.perfil')->with('success', 'Contraseña actualizada correctamente. Se cerró tu sesión en otros dispositivos.');
    }

    /** Unidades receptoras de la cuenta actual. */
    private function unidades(): Collection
    {
        return UnidadReceptora::where('usuario_id', auth()->id())->orderBy('unidad_receptora')->get();
    }

    /** Solicitudes aprobadas, en curso o concluidas de las unidades de la empresa. */
    private function practicantes(Collection $unidades): Collection
    {
        $solicitudes = Solicitud::with(['estudiante', 'unidadReceptora', 'documentos', 'horas'])
            ->whereIn('ur_id', $unidades->pluck('id'))
            ->whereIn('estatus', self::ESTATUS_PRACTICANTE)
            ->orderBy('fecha_inicio')
            ->get();

        $solicitudes->each->sincronizarEstatus();

        return $solicitudes;
    }

    /** Convenio más reciente de la empresa (el que se muestra como vigente). */
    private function convenioVigente(Collection $unidades): ?Convenio
    {
        return Convenio::whereIn('ur_id', $unidades->pluck('id'))->orderByDesc('fecha_termino')->first();
    }

    /** Periodo escolar según la fecha de inicio: AGO–ENE o FEB–JUL. */
    private function periodo($fecha): string
    {
        if (! $fecha) {
            return 'Sin periodo';
        }

        $f = Carbon::parse($fecha);

        if ($f->month >= 8) {
            return "AGO-{$f->year}/ENE-" . ($f->year + 1);
        }
        if ($f->month === 1) {
            return 'AGO-' . ($f->year - 1) . "/ENE-{$f->year}";
        }

        return "FEB-{$f->year}/JUL-{$f->year}";
    }

    private function descargarCsv(Collection $filas)
    {
        $nombre = 'reporte_practicantes_' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($filas) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // BOM para que Excel respete los acentos
            fputcsv($out, ['Alumno', 'Matrícula', 'Carrera', 'Género', 'Periodo', 'Proyecto', 'Unidad receptora', 'Horas', 'Meta', 'Avance %', 'Estatus']);
            foreach ($filas as $f) {
                // Evita que Excel interprete como fórmula un valor que empiece con = + - @
                $fila = array_map(fn ($v) => is_string($v) && preg_match('/^[=+\-@]/', $v) ? "'" . $v : $v, [
                    $f['alumno'], $f['matricula'], $f['carrera'], $f['genero'], $f['periodo'], $f['proyecto'],
                    $f['unidad'], $f['horas'], $f['meta'], $f['avance'], $f['estatus'],
                ]);
                fputcsv($out, $fila);
            }
            fclose($out);
        }, $nombre, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
