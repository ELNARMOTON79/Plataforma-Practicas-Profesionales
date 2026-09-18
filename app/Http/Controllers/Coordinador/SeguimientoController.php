<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SeguimientoController extends Controller
{
    private function getInitialData()
    {
        return [];
    }

    private function getSessionData()
    {
        $sessionData = session()->get('seguimiento_data', []);

        // 1. Initial mock data
        $data = $this->getInitialData();

        // 2. Query all database students
        $dbAlumnos = \App\Models\Alumno::with(['user'])->get();

        foreach ($dbAlumnos as $alumno) {
            $solicitud = \DB::table('solicitudes')
                ->where('estudiante_id', $alumno->id)
                ->orderBy('id', 'desc')
                ->first();

            // Only include students who have been accepted / approved for practice
            $isAceptado = ($solicitud && in_array($solicitud->estatus, ['aprobada', 'en_proceso', 'finalizada', 'acreditado'])) || $alumno->activo_practica == 1;

            if (!$isAceptado) {
                continue;
            }

            // Status determination
            $estatus = 'EN PROCESO';
            if ($solicitud && in_array($solicitud->estatus, ['finalizada', 'acreditado'])) {
                $estatus = 'ACREDITADO';
            }

            $urNombre = 'INSTITUCIÓN NO ASIGNADA';
            $responsable = !empty($alumno->asesor) ? $alumno->asesor : 'Dr. Coordinador de Prácticas';
            $cargo = 'Asesor Académico / Responsable';
            $correoDestino = $alumno->user->correo ?? '';
            $fechaInicio = '01/02/2026';
            $fechaTermino = '01/07/2026';
            $observaciones = 'Sin observaciones registradas.';
            $tituloProyecto = 'Prácticas Profesionales - ' . ($alumno->carrera ?: 'Ingeniería');

            $proyectoReal = null;
            $urModel = null;
            if ($solicitud) {
                if (!empty($solicitud->responsable)) {
                    $responsable = $solicitud->responsable;
                }
                if (!empty($solicitud->observaciones)) {
                    $observaciones = $solicitud->observaciones;
                }
                if (!empty($solicitud->fecha_inicio)) {
                    $fechaInicio = \Carbon\Carbon::parse($solicitud->fecha_inicio)->format('d/m/Y');
                }
                if (!empty($solicitud->fecha_fin)) {
                    $fechaTermino = \Carbon\Carbon::parse($solicitud->fecha_fin)->format('d/m/Y');
                }
                if (!empty($solicitud->ur_id)) {
                    $urModel = \App\Models\UnidadReceptora::find($solicitud->ur_id);
                    if ($urModel) {
                        $urNombre = $urModel->nombre_empresa ?? $urModel->nombre ?? $urNombre;
                    }
                }
            }

            // 1. First look for a project directly assigned to this student (estudiante_id)
            $proyectoReal = \App\Models\Proyecto::where('estudiante_id', $alumno->id)->first();

            // 2. Otherwise look for a project of the student's receptor unit
            if (!$proyectoReal && $solicitud && !empty($solicitud->ur_id)) {
                $proyectoReal = \App\Models\Proyecto::where('unidad_receptora_id', $solicitud->ur_id)->first();
            }

            // Prioritize the project's specific Unidad Receptora if set
            if ($proyectoReal && !empty($proyectoReal->unidad_receptora_id)) {
                $projUr = \App\Models\UnidadReceptora::find($proyectoReal->unidad_receptora_id);
                if ($projUr) {
                    $urModel = $projUr;
                }
            }

            $institucionNombre = 'INSTITUCIÓN NO ASIGNADA';
            $unidadReceptoraNombre = 'INSTITUCIÓN NO ASIGNADA';
            if ($urModel) {
                $institucionNombre = $urModel->nombre_empresa ?? $urModel->nombre ?? 'INSTITUCIÓN NO ASIGNADA';
                $unidadReceptoraNombre = !empty($urModel->unidad_receptora) ? $urModel->unidad_receptora : $institucionNombre;
            }

            if ($proyectoReal) {
                $tituloProyecto = $proyectoReal->titulo;
                $descripcion = $proyectoReal->tipo_proyecto . ' (' . $proyectoReal->tipo_modalidad . ') - ' . $proyectoReal->impacto_social;
                $objetivo = $proyectoReal->objetivo;
                $justificacion = $proyectoReal->justificacion;
                $actividades = $proyectoReal->actividades;
            } else {
                $descripcion = 'Proyecto de prácticas profesionales en la carrera de ' . ($alumno->carrera ?: 'Ingeniería') . ' (' . $alumno->semestre . '° Semestre).';
                $objetivo = 'Aplicar conocimientos académicos teóricos y prácticos en un entorno profesional real.';
                $justificacion = 'Fomentar la formación integral y el desarrollo de habilidades técnicas e interpersonales en los alumnos.';
                $actividades = 'Desarrollo de actividades asignadas en el plan de trabajo, reporte de horas y entregas de expedientes oficiales.';
            }

            $titular = !empty($urModel?->titular) ? $urModel->titular : (!empty($alumno->asesor) ? $alumno->asesor : 'ASESOR ACADÉMICO');
            $domicilio = !empty($urModel?->direccion) ? $urModel->direccion : 'Facultad de Ingeniería Electromecánica, Universidad de Colima';

            // Documents list status dynamically resolved from DB
            $docsList = [
                'carta_presentacion' => [
                    'label' => 'Carta Presentación',
                    'estatus' => 'Sin Subir',
                    'url' => null,
                    'fecha' => null,
                ],
                'carta_aceptacion' => [
                    'label' => 'Carta Aceptación',
                    'estatus' => 'Sin Subir',
                    'url' => null,
                    'fecha' => null,
                ],
                'plan_trabajo' => [
                    'label' => 'Plan de Trabajo',
                    'estatus' => 'Sin Subir',
                    'url' => null,
                    'fecha' => null,
                ],
                'memoria' => [
                    'label' => 'Memoria',
                    'estatus' => 'Sin Subir',
                    'url' => null,
                    'fecha' => null,
                ],
                'evaluacion' => [
                    'label' => 'Evaluación',
                    'estatus' => 'Sin Subir',
                    'url' => null,
                    'fecha' => null,
                ],
                'carta_terminacion' => [
                    'label' => 'Carta Terminación',
                    'estatus' => 'Sin Subir',
                    'url' => null,
                    'fecha' => null,
                ],
            ];

            if ($solicitud) {
                $docsInDb = \DB::table('documentos')->where('solicitud_id', $solicitud->id)->get();
                foreach ($docsInDb as $doc) {
                    $nameLower = strtolower($doc->nombre_doc ?? '');
                    $keyMap = null;
                    if (str_contains($nameLower, 'presentac')) $keyMap = 'carta_presentacion';
                    elseif (str_contains($nameLower, 'aceptac')) $keyMap = 'carta_aceptacion';
                    elseif (str_contains($nameLower, 'plan')) $keyMap = 'plan_trabajo';
                    elseif (str_contains($nameLower, 'memoria')) $keyMap = 'memoria';
                    elseif (str_contains($nameLower, 'evaluac')) $keyMap = 'evaluacion';
                    elseif (str_contains($nameLower, 'terminac') || str_contains($nameLower, 'término') || str_contains($nameLower, 'termino')) $keyMap = 'carta_terminacion';

                    if ($keyMap) {
                        $rawEstatus = strtolower($doc->estatus ?? '');
                        $estatusClean = match(true) {
                            in_array($rawEstatus, ['validado', 'validada', 'aprobado', 'aprobada', 'aceptado', 'aceptada']) => 'Aceptada',
                            in_array($rawEstatus, ['rechazado', 'rechazada']) => 'Rechazada',
                            default => !empty($doc->ruta_archivo) ? 'Pendiente' : 'Sin Subir',
                        };

                        $fileUrl = !empty($doc->ruta_archivo) ? asset('storage/' . ltrim($doc->ruta_archivo, '/')) : null;
                        $fechaFormat = !empty($doc->fecha_carga) ? \Carbon\Carbon::parse($doc->fecha_carga)->format('d/m/Y') : null;

                        $docsList[$keyMap] = [
                            'label'   => $docsList[$keyMap]['label'],
                            'estatus' => $estatusClean,
                            'url'     => $fileUrl,
                            'fecha'   => $fechaFormat,
                        ];
                    }
                }
            }

            $key = $alumno->id;

            // If session already has custom modifications for this student, respect them
            if (isset($sessionData[$key])) {
                $data[$key] = $sessionData[$key];
            } else {
                $data[$key] = [
                    'id' => $key,
                    'matricula' => $alumno->matricula,
                    'nombre_completo' => mb_strtoupper($alumno->nombre_completo, 'UTF-8'),
                    'fecha_inicio' => $fechaInicio,
                    'fecha_termino' => $fechaTermino,
                    'institucion' => $institucionNombre,
                    'unidad_receptora' => $unidadReceptoraNombre,
                    'titulo_proyecto' => $tituloProyecto,
                    'responsable' => $responsable,
                    'cargo' => $cargo,
                    'correo_destino' => $correoDestino,
                    'estatus' => $estatus,
                    'proyecto_detalle' => [
                        'descripcion' => $descripcion,
                        'objetivo' => $objetivo,
                        'justificacion' => $justificacion,
                        'actividades' => $actividades,
                        'titular' => $titular,
                        'domicilio' => $domicilio
                    ],
                    'folio_observaciones' => $observaciones,
                    'documentos' => $docsList
                ];
            }
        }

        return $data;
    }

    public function index()
    {
        if (auth()->user()->rol_id != 2) return redirect('/');

        $data = $this->getSessionData();

        return view('coordinador.seguimiento.index', compact('data'));
    }

    public function show($id)
    {
        if (auth()->user()->rol_id != 2) return redirect('/');

        $data = $this->getSessionData();

        if (!isset($data[$id])) {
            return redirect()->route('coordinador.seguimiento')->with('error', 'Estudiante no encontrado.');
        }

        $student = $data[$id];

        return view('coordinador.seguimiento.show', compact('student'));
    }

    public function saveNotes(Request $request, $id)
    {
        if (auth()->user()->rol_id != 2) return redirect('/');

        $data = $this->getSessionData();

        if (!isset($data[$id])) {
            return redirect()->back()->with('error', 'Estudiante no encontrado.');
        }

        $data[$id]['folio_observaciones'] = $request->input('notes', '');
        session()->put('seguimiento_data', $data);

        $solicitud = \DB::table('solicitudes')->where('estudiante_id', $id)->orderBy('id', 'desc')->first();
        if ($solicitud) {
            \DB::table('solicitudes')->where('id', $solicitud->id)->update([
                'observaciones' => $request->input('notes', '')
            ]);
        }

        return redirect()->back()->with('success', 'Observaciones guardadas correctamente.');
    }

    public function saveResponsable(Request $request, $id)
    {
        if (auth()->user()->rol_id != 2) return redirect('/');

        $data = $this->getSessionData();

        if (!isset($data[$id])) {
            return redirect()->back()->with('error', 'Estudiante no encontrado.');
        }

        $data[$id]['responsable'] = $request->input('responsable', '');
        $data[$id]['cargo'] = $request->input('cargo', '');
        $data[$id]['correo_destino'] = $request->input('correo_destino', '');
        session()->put('seguimiento_data', $data);

        $solicitud = \DB::table('solicitudes')->where('estudiante_id', $id)->orderBy('id', 'desc')->first();
        if ($solicitud) {
            \DB::table('solicitudes')->where('id', $solicitud->id)->update([
                'responsable' => $request->input('responsable', '')
            ]);
        }

        return redirect()->back()->with('success', 'Datos del responsable actualizados correctamente.');
    }
}
