<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Alumno;
use App\Models\Proyecto;
use App\Models\UnidadReceptora;
use Barryvdh\DomPDF\Facade\Pdf;

class InformeController extends Controller
{
    public function informes()
    {
        if (auth()->user()->rol_id != 2) return redirect('/');

        // user y ultimaSolicitud se cargan por adelantado: el estatus de cada alumno los usa
        $alumnos = Alumno::with(['user', 'ultimaSolicitud'])->get();
        $proyectos = Proyecto::with('empresa')->get();

        // Distribución por Carrera
        $carrerasStats = [];
        $totalAlumnos = $alumnos->count();

        foreach ($alumnos as $alumno) {
            $carrera = $alumno->carrera ?? 'Sin asignar';
            if (!isset($carrerasStats[$carrera])) {
                $carrerasStats[$carrera] = 0;
            }
            $carrerasStats[$carrera]++;
        }

        // Distribución por Género (columna sexo; los registros antiguos se deducen del nombre)
        $generosStats = [
            'FEMENINO' => 0,
            'MASCULINO' => 0
        ];

        foreach ($alumnos as $alumno) {
            $genero = $alumno->sexo;
            if (isset($generosStats[$genero])) {
                $generosStats[$genero]++;
            }
        }

        // Distribución por Modalidad
        $modalidadesStats = [];
        $totalProyectos = $proyectos->count();
        $ciclosEscolares = [];

        foreach ($proyectos as $proyecto) {
            $modalidad = $proyecto->tipo_modalidad ?? 'Sin definir';
            if (!isset($modalidadesStats[$modalidad])) {
                $modalidadesStats[$modalidad] = 0;
            }
            $modalidadesStats[$modalidad]++;

            if ($proyecto->ciclo_escolar && !in_array($proyecto->ciclo_escolar, $ciclosEscolares)) {
                $ciclosEscolares[] = $proyecto->ciclo_escolar;
            }
        }

        $carreras = Alumno::distinct()->pluck('carrera')->filter()->values();

        $databaseData = [
            'estudiantes' => [
                'headers' => ['Alumno / Matrícula', 'Carrera', 'Género', 'Ciclo Escolar', 'Estatus'],
                'rows' => [],
                'stats' => []
            ],
            'instituciones' => [
                'headers' => ['Institución de Vinculación', 'Contacto Principal', 'Sector', 'Ubicación', 'Estatus Convenio'],
                'rows' => [],
                'stats' => []
            ],
            'proyectos' => [
                'headers' => ['Título del Proyecto', 'Unidad Receptora', 'Modalidad', 'Cupos Disponibles', 'Ciclo Escolar'],
                'rows' => [],
                'stats' => []
            ]
        ];

        $colors = ['bg-[#4E7D24]', 'bg-[#6BA53A]', 'bg-blue-500', 'bg-orange-500', 'bg-purple-500'];
        $i = 0;
        foreach ($carrerasStats as $c => $count) {
            $databaseData['estudiantes']['stats'][] = [
                'label' => $c,
                'percentage' => $totalAlumnos > 0 ? round(($count / $totalAlumnos) * 100) : 0,
                'colorClass' => $colors[$i % count($colors)]
            ];
            $i++;
        }

        // El alumno no guarda ciclo escolar: se toma del proyecto que tiene asignado
        $cicloPorAlumno = $proyectos->whereNotNull('estudiante_id')->pluck('ciclo_escolar', 'estudiante_id');

        foreach ($alumnos as $alumno) {

            $ciclo = $cicloPorAlumno[$alumno->id] ?? 'N/A';
            if ($ciclo !== 'N/A' && !in_array($ciclo, $ciclosEscolares)) {
                $ciclosEscolares[] = $ciclo;
            }

            // Las celdas se envían como texto plano; la vista las escapa al construir la tabla
            $databaseData['estudiantes']['rows'][] = [
                ['texto' => $alumno->nombre_completo, 'subtexto' => $alumno->matricula],
                $alumno->carrera ?? 'Sin asignar',
                $alumno->sexo == 'FEMENINO' ? 'Femenino' : 'Masculino',
                $ciclo,
                ['badge' => $alumno->estatus, 'clase' => $alumno->estatus_class],
            ];
        }

        $instituciones = UnidadReceptora::all();
        $totalInstituciones = $instituciones->count();
        $sectoresStats = [];

        foreach ($instituciones as $inst) {
            $sector = $inst->sector ?? 'Privado';
            if (!isset($sectoresStats[$sector])) {
                $sectoresStats[$sector] = 0;
            }
            $sectoresStats[$sector]++;

            $databaseData['instituciones']['rows'][] = [
                $inst->nombre_empresa ?? $inst->unidad_receptora,
                ['texto' => $inst->titular ?? 'Sin titular', 'subtexto' => $inst->cargo ?? 'Sin cargo'],
                $sector,
                ($inst->municipio ?? 'Colima') . ', ' . ($inst->estado ?? 'Col.'),
                ['badge' => 'APROBADO', 'clase' => 'bg-green-50 text-green-700 border border-green-100'], // Registrada por el coordinador = convenio aprobado
            ];
        }

        $i = 0;
        foreach ($sectoresStats as $s => $count) {
            $databaseData['instituciones']['stats'][] = [
                'label' => 'Sector ' . $s,
                'percentage' => $totalInstituciones > 0 ? round(($count / $totalInstituciones) * 100) : 0,
                'colorClass' => $colors[$i % count($colors)]
            ];
            $i++;
        }

        $i = 0;
        foreach ($modalidadesStats as $m => $count) {
            $databaseData['proyectos']['stats'][] = [
                'label' => 'Modalidad ' . $m,
                'percentage' => $totalProyectos > 0 ? round(($count / $totalProyectos) * 100) : 0,
                'colorClass' => $colors[$i % count($colors)]
            ];
            $i++;
        }

        foreach ($proyectos as $proyecto) {
            $urName = $proyecto->empresa->nombre_empresa ?? 'UR No Definida';
            $databaseData['proyectos']['rows'][] = [
                $proyecto->titulo ?? 'Sin Título',
                $urName,
                $proyecto->tipo_modalidad ?? 'Sin definir',
                ($proyecto->cupos_ocupados ?? 0) . ' de ' . ($proyecto->cupos_totales ?? 0),
                $proyecto->ciclo_escolar ?? 'N/A'
            ];
        }

        $dbDataJson = json_encode($databaseData, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);

        return view('coordinador.informes', compact(
            'carreras',
            'carrerasStats', 'totalAlumnos',
            'generosStats',
            'modalidadesStats', 'totalProyectos',
            'dbDataJson',
            'ciclosEscolares'
        ));
    }

    // ─────────────────────────────────────────────
    //  Export PDF
    // ─────────────────────────────────────────────
    public function exportarPDF(Request $request)
    {
        if (auth()->user()->rol_id != 2) return redirect('/');

        $tipo    = $request->input('tipo', 'estudiantes');
        $filtros = $request->only(['carrera', 'genero', 'ciclo', 'modalidad']);

        $titulos = [
            'estudiantes'   => 'Reporte de Estudiantes',
            'instituciones' => 'Reporte de Instituciones Vinculadas',
            'proyectos'     => 'Reporte de Catálogo de Proyectos',
        ];

        $data = $this->buildRows($tipo, $filtros);
        $data['titulo']  = $titulos[$tipo] ?? 'Reporte';
        $data['filtros'] = $filtros;

        $pdf = Pdf::loadView('coordinador.informes-pdf', $data)
                  ->setPaper('a4', 'landscape');

        $filename = 'reporte-' . $tipo . '-' . now()->format('Ymd-His') . '.pdf';
        return $pdf->download($filename);
    }

    // ─────────────────────────────────────────────
    //  Export Excel (CSV que Excel abre directamente)
    // ─────────────────────────────────────────────
    public function exportarExcel(Request $request)
    {
        if (auth()->user()->rol_id != 2) return redirect('/');

        $tipo    = $request->input('tipo', 'estudiantes');
        $filtros = $request->only(['carrera', 'genero', 'ciclo', 'modalidad']);

        $data     = $this->buildRows($tipo, $filtros);
        $columnas = $data['columnas'];
        $filas    = $data['filas'];

        $filename = 'reporte-' . $tipo . '-' . now()->format('Ymd-His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate',
            'Expires'             => '0',
        ];

        // Una celda que empieza con = + - @ Excel la ejecuta como fórmula: se antepone un apóstrofo
        $celdaSegura = fn ($valor) => preg_match('/^[=+\-@\t\r]/', (string) $valor) ? "'" . $valor : (string) $valor;

        $callback = function () use ($columnas, $filas, $filtros, $celdaSegura) {
            $handle = fopen('php://output', 'w');
            $csv = fn (array $fila) => fputcsv($handle, array_map($celdaSegura, $fila), ',', '"', '');

            // UTF-8 BOM so Excel opens it correctly
            fwrite($handle, "\xEF\xBB\xBF");

            // Meta header
            $csv(['Plataforma de Prácticas Profesionales — UCOL']);
            $csv(['Generado el: ' . now()->format('d/m/Y H:i')]);
            $csv(['Filtros: ' . implode(', ', array_filter(array_map(
                fn ($k, $v) => $v ? "$k: $v" : '', array_keys($filtros), $filtros
            )))]);
            $csv([]); // blank row

            $csv($columnas);
            foreach ($filas as $fila) {
                $csv($fila);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ─────────────────────────────────────────────
    //  Filas de cada reporte con los filtros aplicados (las usan PDF y CSV).
    //  Los filtros se comportan igual que en la vista previa de la pantalla.
    // ─────────────────────────────────────────────
    private function buildRows(string $tipo, array $filtros): array
    {
        $carrera   = $filtros['carrera'] ?? '';
        $genero    = $this->normalizar($filtros['genero'] ?? '');
        $ciclo     = $filtros['ciclo'] ?? '';
        $modalidad = $this->normalizar($filtros['modalidad'] ?? '');

        $filas    = [];
        $columnas = [];

        if ($tipo === 'estudiantes') {
            $columnas = ['Alumno', 'Matrícula', 'Carrera', 'Género', 'Semestre', 'Ciclo Escolar', 'Estatus'];

            // El alumno no guarda ciclo escolar: se toma del proyecto que tiene asignado
            $cicloPorAlumno = Proyecto::whereNotNull('estudiante_id')->pluck('ciclo_escolar', 'estudiante_id');

            $query = Alumno::with(['user', 'ultimaSolicitud']);
            if ($carrera) $query->where('carrera', $carrera);

            foreach ($query->get() as $alumno) {
                // El accessor usa la columna sexo y, en registros antiguos, lo deduce del nombre
                $sexo = $alumno->sexo === 'FEMENINO' ? 'Femenino' : 'Masculino';
                if ($genero && $this->normalizar($sexo) !== $genero) continue;

                $cicloAlumno = $cicloPorAlumno[$alumno->id] ?? 'N/A';
                if ($ciclo && $cicloAlumno !== $ciclo) continue;

                $filas[] = [
                    $alumno->nombre_completo,
                    $alumno->matricula,
                    $alumno->carrera ?? '—',
                    $sexo,
                    ($alumno->semestre ?? '—') . '°',
                    $cicloAlumno,
                    $alumno->estatus,
                ];
            }

        } elseif ($tipo === 'instituciones') {
            $columnas = ['Institución', 'Titular', 'Cargo', 'Sector', 'Municipio'];

            foreach (UnidadReceptora::all() as $ur) {
                $filas[] = [
                    $ur->nombre_empresa ?? $ur->unidad_receptora ?? '—',
                    $ur->titular   ?? '—',
                    $ur->cargo     ?? '—',
                    $ur->sector    ?? 'Privado',
                    ($ur->municipio ?? 'Colima') . ', ' . ($ur->estado ?? 'Col.'),
                ];
            }

        } elseif ($tipo === 'proyectos') {
            $columnas = ['Título del Proyecto', 'Empresa / UR', 'Modalidad', 'Cupos', 'Ciclo Escolar', 'Estatus'];

            $query = Proyecto::with('empresa');
            if ($ciclo) $query->where('ciclo_escolar', $ciclo);

            foreach ($query->get() as $proyecto) {
                // Se compara sin acentos ni mayúsculas: "hibrido" coincide con "Híbrido"
                if ($modalidad && $this->normalizar($proyecto->tipo_modalidad ?? '') !== $modalidad) continue;

                $filas[] = [
                    $proyecto->titulo ?? '—',
                    $proyecto->empresa->nombre_empresa ?? '—',
                    $proyecto->tipo_modalidad ?? '—',
                    ($proyecto->cupos_ocupados ?? 0) . ' / ' . ($proyecto->cupos_totales ?? 0),
                    $proyecto->ciclo_escolar ?? '—',
                    ucfirst(strtolower($proyecto->estatus ?? '—')),
                ];
            }
        }

        return compact('columnas', 'filas');
    }

    private function normalizar(?string $valor): string
    {
        return Str::lower(Str::ascii(trim($valor ?? '')));
    }
}
