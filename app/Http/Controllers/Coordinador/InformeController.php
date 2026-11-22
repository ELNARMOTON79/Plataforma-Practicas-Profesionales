<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Proyecto;
use App\Models\UnidadReceptora;
use Barryvdh\DomPDF\Facade\Pdf;

class InformeController extends Controller
{
    // ─────────────────────────────────────────────
    //  Helper: build filtered rows for each report type
    // ─────────────────────────────────────────────
    private function buildRows(string $tipo, array $filtros): array
    {
        $carrera   = $filtros['carrera']   ?? '';
        $genero    = $filtros['genero']    ?? '';
        $ciclo     = $filtros['ciclo']     ?? '';
        $modalidad = $filtros['modalidad'] ?? '';

        $filas   = [];
        $columnas = [];

        if ($tipo === 'estudiantes') {
            $columnas = ['Alumno', 'Matrícula', 'Carrera', 'Género', 'Semestre', 'Estatus'];

            $query = Alumno::with('user');
            if ($carrera)   $query->where('carrera', $carrera);
            if ($genero)    $query->whereRaw('UPPER(COALESCE(sexo, ?)) = ?', [
                                    $genero === 'femenino' ? 'femenino' : 'masculino',
                                    strtoupper($genero)
                                ]);

            foreach ($query->get() as $alumno) {
                // Apply ciclo filter if present (Alumno doesn't have ciclo_escolar directly, skip if absent)
                $sexoRaw = $alumno->attributes['sexo'] ?? null;
                $sexoDisplay = $sexoRaw ? ucfirst(strtolower($sexoRaw)) : ($alumno->sexo === 'FEMENINO' ? 'Femenino' : 'Masculino');

                if ($genero) {
                    if ($genero === 'femenino'  && strtoupper($sexoRaw ?? $alumno->sexo) !== 'FEMENINO')  continue;
                    if ($genero === 'masculino' && strtoupper($sexoRaw ?? $alumno->sexo) !== 'MASCULINO') continue;
                }

                $filas[] = [
                    $alumno->nombre_completo,
                    $alumno->matricula,
                    $alumno->carrera ?? '—',
                    $sexoDisplay,
                    ($alumno->semestre ?? '—') . '°',
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
            if ($modalidad) $query->whereRaw('LOWER(tipo_modalidad) = ?', [strtolower($modalidad)]);
            if ($ciclo)     $query->where('ciclo_escolar', $ciclo);

            foreach ($query->get() as $proyecto) {
                $filas[] = [
                    $proyecto->titulo ?? '—',
                    $proyecto->empresa->nombre_empresa ?? '—',
                    ucfirst(strtolower($proyecto->tipo_modalidad ?? '—')),
                    ($proyecto->cupos_ocupados ?? 0) . ' / ' . ($proyecto->cupos_totales ?? 0),
                    $proyecto->ciclo_escolar ?? '—',
                    ucfirst(strtolower($proyecto->estatus ?? '—')),
                ];
            }
        }

        return compact('columnas', 'filas');
    }

    // ─────────────────────────────────────────────
    //  Main view
    // ─────────────────────────────────────────────
    public function informes()
    {
        if (auth()->user()->rol_id != 2) return redirect('/');

        $alumnos   = Alumno::with('user')->get();
        $proyectos = Proyecto::with('empresa')->get();

        // --- Distribución por Carrera ---
        $carrerasStats = [];
        $totalAlumnos  = $alumnos->count();
        foreach ($alumnos as $alumno) {
            $c = $alumno->carrera ?? 'Sin asignar';
            $carrerasStats[$c] = ($carrerasStats[$c] ?? 0) + 1;
        }

        // --- Distribución por Género ---
        $generosStats = ['FEMENINO' => 0, 'MASCULINO' => 0];
        foreach ($alumnos as $alumno) {
            $g = $alumno->sexo; // uses accessor (real column first, then fallback)
            if (isset($generosStats[$g])) $generosStats[$g]++;
        }

        // --- Distribución por Modalidad ---
        $modalidadesStats = [];
        $totalProyectos   = $proyectos->count();
        $ciclosEscolares  = [];
        foreach ($proyectos as $p) {
            $m = $p->tipo_modalidad ?? 'Sin definir';
            $modalidadesStats[$m] = ($modalidadesStats[$m] ?? 0) + 1;
            if ($p->ciclo_escolar && !in_array($p->ciclo_escolar, $ciclosEscolares)) {
                $ciclosEscolares[] = $p->ciclo_escolar;
            }
        }
        sort($ciclosEscolares);

        $carreras = Alumno::distinct()->pluck('carrera')->filter()->values();

        // --- Build data for JS preview table ---
        $colors = ['bg-[#4E7D24]', 'bg-[#6BA53A]', 'bg-blue-500', 'bg-orange-500', 'bg-purple-500'];

        $databaseData = [
            'estudiantes'  => ['headers' => ['Alumno / Matrícula', 'Carrera', 'Género', 'Semestre', 'Estatus'], 'rows' => [], 'stats' => []],
            'instituciones'=> ['headers' => ['Institución', 'Titular', 'Sector', 'Municipio', 'Convenio'],      'rows' => [], 'stats' => []],
            'proyectos'    => ['headers' => ['Título del Proyecto', 'Empresa / UR', 'Modalidad', 'Cupos', 'Ciclo Escolar'], 'rows' => [], 'stats' => []],
        ];

        // Alumnos rows
        foreach ($alumnos as $alumno) {
            $sexoRaw  = $alumno->attributes['sexo'] ?? null;
            $genero   = $sexoRaw ? ucfirst(strtolower($sexoRaw)) : ($alumno->sexo === 'FEMENINO' ? 'Femenino' : 'Masculino');
            $databaseData['estudiantes']['rows'][] = [
                addslashes($alumno->nombre_completo) . '|' . addslashes($alumno->matricula),
                addslashes($alumno->carrera ?? '—'),
                $genero,
                ($alumno->semestre ?? '—') . '°',
                $alumno->estatus,
            ];
        }

        $i = 0;
        foreach ($carrerasStats as $c => $cnt) {
            $databaseData['estudiantes']['stats'][] = [
                'label'      => $c,
                'percentage' => $totalAlumnos > 0 ? round(($cnt / $totalAlumnos) * 100) : 0,
                'colorClass' => $colors[$i % count($colors)],
            ];
            $i++;
        }

        // Instituciones rows
        foreach (UnidadReceptora::all() as $ur) {
            $sector = $ur->sector ?? 'Privado';
            $databaseData['instituciones']['rows'][] = [
                addslashes($ur->nombre_empresa ?? $ur->unidad_receptora ?? '—'),
                addslashes($ur->titular ?? '—'),
                $sector,
                addslashes(($ur->municipio ?? 'Colima') . ', ' . ($ur->estado ?? 'Col.')),
                'VIGENTE',
            ];
            if (!isset($sectoresStats[$sector])) $sectoresStats[$sector] = 0;
            $sectoresStats[$sector]++;
        }
        $totalInstituciones = count($databaseData['instituciones']['rows']);
        $i = 0;
        foreach (($sectoresStats ?? []) as $s => $cnt) {
            $databaseData['instituciones']['stats'][] = [
                'label'      => 'Sector ' . $s,
                'percentage' => $totalInstituciones > 0 ? round(($cnt / $totalInstituciones) * 100) : 0,
                'colorClass' => $colors[$i % count($colors)],
            ];
            $i++;
        }

        // Proyectos rows
        foreach ($proyectos as $p) {
            $databaseData['proyectos']['rows'][] = [
                addslashes($p->titulo ?? '—'),
                addslashes($p->empresa->nombre_empresa ?? '—'),
                ucfirst(strtolower($p->tipo_modalidad ?? '—')),
                ($p->cupos_ocupados ?? 0) . ' / ' . ($p->cupos_totales ?? 0),
                $p->ciclo_escolar ?? '—',
            ];
        }
        $i = 0;
        foreach ($modalidadesStats as $m => $cnt) {
            $databaseData['proyectos']['stats'][] = [
                'label'      => 'Modalidad ' . $m,
                'percentage' => $totalProyectos > 0 ? round(($cnt / $totalProyectos) * 100) : 0,
                'colorClass' => $colors[$i % count($colors)],
            ];
            $i++;
        }

        $dbDataJson = json_encode($databaseData, JSON_UNESCAPED_UNICODE);

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
    //  Export Excel (CSV compatible with xlsx)
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

        $callback = function() use ($columnas, $filas, $tipo, $filtros) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM so Excel opens it correctly
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // Meta header
            fputcsv($handle, ['Plataforma de Prácticas Profesionales — UCOL']);
            fputcsv($handle, ['Generado el: ' . now()->format('d/m/Y H:i')]);
            fputcsv($handle, ['Filtros: ' . implode(', ', array_filter(array_map(
                fn($k,$v) => $v ? "$k: $v" : '', array_keys($filtros), $filtros
            )))]);
            fputcsv($handle, []); // blank row

            // Column headers
            fputcsv($handle, $columnas);

            // Data rows — strip HTML tags
            foreach ($filas as $fila) {
                fputcsv($handle, array_map(fn($cell) => strip_tags(str_replace(['<br>', '<br/>'], ' ', $cell)), $fila));
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
