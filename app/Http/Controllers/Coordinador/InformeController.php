<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Proyecto;

class InformeController extends Controller
{
    public function informes()
    {
        if (auth()->user()->rol_id != 2) return redirect('/');

        $alumnos = Alumno::all();
        $proyectos = Proyecto::all();

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

        // Distribución por Género 
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

        foreach ($alumnos as $alumno) {

            $ciclo = $alumno->ciclo_escolar ?? 'N/A';
            if ($ciclo !== 'N/A' && !in_array($ciclo, $ciclosEscolares)) {
                $ciclosEscolares[] = $ciclo;
            }
            
            $databaseData['estudiantes']['rows'][] = [
                $alumno->nombre_completo . '<br><span class="text-[9px] text-gray-400 font-semibold">' . $alumno->numero_cuenta . '</span>',
                $alumno->carrera ?? 'Sin asignar',
                $alumno->sexo == 'FEMENINO' ? 'Femenino' : 'Masculino',
                $ciclo,
                '<span class="px-2 py-0.5 rounded text-[9px] font-bold ' . $alumno->estatus_class . '">' . $alumno->estatus . '</span>'
            ];
        }

        $instituciones = \App\Models\UnidadReceptora::all();
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
                ($inst->titular ?? 'Sin titular') . '<br><span class="text-[9px] text-gray-400 font-semibold">' . ($inst->cargo ?? 'Sin cargo') . '</span>',
                $sector,
                ($inst->municipio ?? 'Colima') . ', ' . ($inst->estado ?? 'Col.'),
                '<span class="px-2 py-0.5 rounded text-[9px] font-bold bg-green-50 text-green-700 border border-green-100">VIGENTE</span>' // Mocking convenio status for now
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

        $dbDataJson = json_encode($databaseData);

        return view('coordinador.informes', compact(
            'carreras',
            'carrerasStats', 'totalAlumnos',
            'generosStats',
            'modalidadesStats', 'totalProyectos',
            'dbDataJson',
            'ciclosEscolares'
        ));
    }
}
