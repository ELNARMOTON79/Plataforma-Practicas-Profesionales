<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SeguimientoController extends Controller
{
    private function getInitialData()
    {
        return [
            1 => [
                'id' => 1,
                'matricula' => '20201919',
                'nombre_completo' => 'VISOSO FLORES OLIVER GABRIEL',
                'fecha_inicio' => '08/01/2024',
                'fecha_termino' => '06/06/2024',
                'institucion' => 'BRIGHTCODERS CONSULTING S.A. DE C.V.',
                'unidad_receptora' => 'BRIGHTCODERS CONSULTING S.A. DE C.V.',
                'titulo_proyecto' => 'BrightCoders React Native Mobile Developer',
                'responsable' => 'Dr. Carlos Alberto Flores Cortés',
                'cargo' => 'Director Académico',
                'correo_destino' => 'carlos.flores@brightcoders.mx',
                'estatus' => 'ACREDITADO',
                'proyecto_detalle' => [
                    'descripcion' => 'El proyecto se estructura en 2 etapas: React Native (2 meses). En esta etapa los participantes se preparan para trabajar con react native mediante el desarrollo de pequeñas aplicaciones móviles presentadas en formato de Code Katas. Los principales temas que se trabajan durante esta etapa son: Programación con React Native o Desarrollo basado en Pruebas o Administración avanzada de repositorios remotos y locales o Calidad del código o Acceso a bases de datos o Trabajo en equipo o Comunicación efectiva • Proyecto (2 meses). En esta etapa los participantes deberán de desarrollar una aplicación móvil completa, desde la definición de requerimientos hasta la publicación y entrega del producto final. Los principales temas de esta etapa son: Programación con React Native o Desarrollo basado en Pruebas o Administración avanzada de repositorios remotos y locales o Calidad del código o Acceso a bases de datos o La metodología ágil o Planeación del proyecto o Administración del proyecto o Publicación de la aplicación móvil o Trabajo en equipo o Comunicación efectiva',
                    'objetivo' => 'Contribuir al generación de talento mediante el desarrollo de habilidades técnicas e interpersonales para formar profesionales capacitados en el desarrollo de aplicaciones móviles utilizando React Native, para satisfacer la demanda del mercado, aumentar la eficiencia y productividad, promover la adaptabilidad y flexibilidad, y desarrollar habilidades complementarias que impulsen el éxito profesional.',
                    'justificacion' => 'Es indispensable dotar al alumno de competencias tecnológicas avanzadas para que pueda integrarse directamente en proyectos de software del sector global.',
                    'actividades' => 'Desarrollo de katas, configuración de entornos de pruebas Jest, implementación de persistencia local con SQLite, creación de layouts fluidos y responsive en iOS y Android, control de versiones y entregas de sprint bajo metodología Scrum.',
                    'titular' => 'MTRO. CARLOS FRANCISCO ROCHA CUEVAS',
                    'domicilio' => 'Prol. Miguel de la Madrid Hurtado 25, Residencia Bosque Real, Colima'
                ],
                'referencias_bancarias' => [
                    'referencia' => 'A1062020191957518302',
                    'fecha_referencia' => '10/06/2024',
                    'recibo' => '21339',
                    'fecha_recibo' => '10/06/2024',
                    'folio' => '89351',
                    'estatus_pago' => 'PAGADA'
                ],
                'folio_observaciones' => 'Folio: 6E.1.1/703000/857/2024  DOCS. REVISADOS Y APROBADOS. 20/06/2024. VMH',
                'documentos' => [
                    'carta_presentacion' => 'Aceptada',
                    'carta_aceptacion' => 'Aceptada',
                    'plan_trabajo' => 'Aceptada',
                    'memoria' => 'Aceptada',
                    'evaluacion' => 'Aceptada',
                    'carta_terminacion' => 'Aceptada'
                ]
            ],
            2 => [
                'id' => 2,
                'matricula' => '20171485',
                'nombre_completo' => 'GUZMAN LOZA OSCAR AXEL',
                'fecha_inicio' => '15/01/2024',
                'fecha_termino' => '20/06/2024',
                'institucion' => 'BRIGHTCODERS CONSULTING S.A. DE C.V.',
                'unidad_receptora' => 'BRIGHTCODERS CONSULTING S.A. DE C.V.',
                'titulo_proyecto' => 'BrightCoders React Native Mobile Developer',
                'responsable' => 'Dr. Carlos Alberto Flores Cortés',
                'cargo' => 'Director Académico',
                'correo_destino' => 'carlos.flores@brightcoders.mx',
                'estatus' => 'ACREDITADO',
                'proyecto_detalle' => [
                    'descripcion' => 'Desarrollo móvil avanzado empleando metodologías ágiles y entornos de simulación real en la nube.',
                    'objetivo' => 'Diseño y programación de aplicaciones dinámicas utilizando componentes híbridos.',
                    'justificacion' => 'Crecimiento y fomento del ecosistema de desarrollo tecnológico en la región de Colima.',
                    'actividades' => 'Pruebas unitarias, control de calidad, programación orientada a objetos en JavaScript y TypeScript.',
                    'titular' => 'MTRO. CARLOS FRANCISCO ROCHA CUEVAS',
                    'domicilio' => 'Prol. Miguel de la Madrid Hurtado 25, Residencia Bosque Real, Colima'
                ],
                'referencias_bancarias' => [
                    'referencia' => 'A1062017148557518420',
                    'fecha_referencia' => '18/06/2024',
                    'recibo' => '21450',
                    'fecha_recibo' => '19/06/2024',
                    'folio' => '89540',
                    'estatus_pago' => 'PAGADA'
                ],
                'folio_observaciones' => 'Folio: 6E.1.1/703000/890/2024  DOCS. REVISADOS Y APROBADOS. 24/06/2024.',
                'documentos' => [
                    'carta_presentacion' => 'Aceptada',
                    'carta_aceptacion' => 'Aceptada',
                    'plan_trabajo' => 'Aceptada',
                    'memoria' => 'Aceptada',
                    'evaluacion' => 'Aceptada',
                    'carta_terminacion' => 'Aceptada'
                ]
            ],
            3 => [
                'id' => 3,
                'matricula' => '20215896',
                'nombre_completo' => 'RAMÍREZ MENDOZA SOFÍA',
                'fecha_inicio' => '01/02/2026',
                'fecha_termino' => '01/07/2026',
                'institucion' => 'TERNIUM MÉXICO S.A. DE C.V.',
                'unidad_receptora' => 'TERNIUM MÉXICO S.A. DE C.V.',
                'titulo_proyecto' => 'Desarrollo de Módulo de Seguimiento de Egresados',
                'responsable' => 'Ing. Roberto Garza Martínez',
                'cargo' => 'Gerente de TI',
                'correo_destino' => 'roberto.garza@ternium.com.mx',
                'estatus' => 'EN PROCESO',
                'proyecto_detalle' => [
                    'descripcion' => 'Implementación de encuestas en tiempo real para medir la inserción laboral de alumnos egresados.',
                    'objetivo' => 'Garantizar el cumplimiento del indicador de seguimiento de egresados para las evaluaciones de calidad.',
                    'justificacion' => 'Obtención de retroalimentación relevante de las empresas sobre el perfil del egresado.',
                    'actividades' => 'Diseño de base de datos, envío de correos automatizados, generación de PDF dinámicos.',
                    'titular' => 'ING. JORGE EDUARDO ALONSO TORRES',
                    'domicilio' => 'Av. Universidad 333, Colima'
                ],
                'referencias_bancarias' => [
                    'referencia' => 'A1062021589657519102',
                    'fecha_referencia' => '02/02/2026',
                    'recibo' => '22987',
                    'fecha_recibo' => '03/02/2026',
                    'folio' => '91080',
                    'estatus_pago' => 'PAGADA'
                ],
                'folio_observaciones' => 'En espera de primer informe mensual.',
                'documentos' => [
                    'carta_presentacion' => 'Aceptada',
                    'carta_aceptacion' => 'Aceptada',
                    'plan_trabajo' => 'Pendiente',
                    'memoria' => 'Pendiente',
                    'evaluacion' => 'Pendiente',
                    'carta_terminacion' => 'Pendiente'
                ]
            ],
            4 => [
                'id' => 4,
                'matricula' => '20213094',
                'nombre_completo' => 'FLORES SILVA MARIANA',
                'fecha_inicio' => '10/02/2026',
                'fecha_termino' => '10/08/2026',
                'institucion' => 'IMSS - DELEGACIÓN COLIMA',
                'unidad_receptora' => 'IMSS - DELEGACIÓN COLIMA',
                'titulo_proyecto' => 'Análisis y Optimización de Eficiencia Energética en Edificios',
                'responsable' => 'Arq. Patricia Orozco Vega',
                'cargo' => 'Coordinadora de Infraestructura',
                'correo_destino' => 'patricia.orozco@imss.gob.mx',
                'estatus' => 'EN PROCESO',
                'proyecto_detalle' => [
                    'descripcion' => 'Revisión y auditoría del consumo de energía en las oficinas delegacionales.',
                    'objetivo' => 'Reducir el consumo de energía en un 15% mediante sensores inteligentes y políticas de concientización.',
                    'justificacion' => 'Fomento a la sustentabilidad y el cuidado ambiental dentro de los servicios de salud.',
                    'actividades' => 'Muestreo de equipos encendidos, diagramación de horarios de consumo de aire acondicionado, análisis de tableros.',
                    'titular' => 'DR. ENRIQUE JAVIER RUIZ SANDOVAL',
                    'domicilio' => 'Av. de los Maestros 140, Colima'
                ],
                'referencias_bancarias' => [
                    'referencia' => 'A1062021309457519156',
                    'fecha_referencia' => '10/02/2026',
                    'recibo' => '22999',
                    'fecha_recibo' => '11/02/2026',
                    'folio' => '91100',
                    'estatus_pago' => 'PAGADA'
                ],
                'folio_observaciones' => 'Documentos iniciales aprobados.',
                'documentos' => [
                    'carta_presentacion' => 'Aceptada',
                    'carta_aceptacion' => 'Aceptada',
                    'plan_trabajo' => 'Aceptada',
                    'memoria' => 'Pendiente',
                    'evaluacion' => 'Pendiente',
                    'carta_terminacion' => 'Pendiente'
                ]
            ],
            5 => [
                'id' => 5,
                'matricula' => '20184752',
                'nombre_completo' => 'PEREZ LOPEZ JUAN',
                'fecha_inicio' => '12/01/2026',
                'fecha_termino' => '12/06/2026',
                'institucion' => 'H. AYUNTAMIENTO DE COLIMA',
                'unidad_receptora' => 'H. AYUNTAMIENTO DE COLIMA',
                'titulo_proyecto' => 'Sistema de Monitoreo Climático y Controles Automatizados con IoT',
                'responsable' => 'Lic. Alejandro Silva Domínguez',
                'cargo' => 'Director de Ecología',
                'correo_destino' => 'alejandro.silva@ayuntamiento.gob.mx',
                'estatus' => 'ACREDITADO',
                'proyecto_detalle' => [
                    'descripcion' => 'Configuración de red de sensores de temperatura y humedad en camellones principales.',
                    'objetivo' => 'Monitorear en tiempo real la calidad microclimática en zonas arboladas urbanas.',
                    'justificacion' => 'Brindar datos abiertos a la población de Colima sobre el clima urbano.',
                    'actividades' => 'Montaje de microcontroladores ESP32, programación de envíos vía protocolo MQTT, desarrollo de dashboard web.',
                    'titular' => 'LIC. ALEJANDRA FLORES GUTIÉRREZ',
                    'domicilio' => 'Torres Quintero 85, Centro, Colima'
                ],
                'referencias_bancarias' => [
                    'referencia' => 'A1062018475257519010',
                    'fecha_referencia' => '12/01/2026',
                    'recibo' => '22501',
                    'fecha_recibo' => '12/01/2026',
                    'folio' => '90450',
                    'estatus_pago' => 'PAGADA'
                ],
                'folio_observaciones' => 'Acreditación autorizada por el comité.',
                'documentos' => [
                    'carta_presentacion' => 'Aceptada',
                    'carta_aceptacion' => 'Aceptada',
                    'plan_trabajo' => 'Aceptada',
                    'memoria' => 'Aceptada',
                    'evaluacion' => 'Aceptada',
                    'carta_terminacion' => 'Aceptada'
                ]
            ]
        ];
    }

    private function getSessionData()
    {
        if (!session()->has('seguimiento_data')) {
            session()->put('seguimiento_data', $this->getInitialData());
        }
        return session()->get('seguimiento_data');
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

        return redirect()->back()->with('success', 'Datos del responsable actualizados correctamente.');
    }
}
