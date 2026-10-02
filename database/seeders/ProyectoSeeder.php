<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProyectoSeeder extends Seeder
{
    public function run(): void
    {
        // Usar updateOrInsert para no borrar datos existentes
        $proyectos = [
            [
                'id'                  => 1,
                'unidad_receptora_id' => 4,
                'estudiante_id'       => null,
                'titulo'              => 'PLATAFORMA WEB PARA ADMINISTRACIÓN DE PRÁCTICAS',
                'objetivo'            => 'Desarrollar una aplicación web interactiva que permita digitalizar y automatizar el control, recepción y aprobación de las prácticas profesionales de los estudiantes de manera eficiente.',
                'justificacion'       => 'El sistema actual basado en papel y hojas de cálculo genera retrasos, pérdidas de información y duplicidad de tareas en la coordinación.',
                'actividades'         => "1. Diseñar la arquitectura de base de datos relacional.\n2. Programar controladores y vistas en Laravel con TailwindCSS.\n3. Implementar pruebas unitarias y de integración.\n4. Documentar el código y manual de usuario.",
                'impacto_social'      => 'Facilita la vinculación rápida de los jóvenes con el sector productivo local, agilizando su titulación y acceso a empleos.',
                'tipo_proyecto'       => 'Desarrollo Tecnológico',
                'tipo_modalidad'      => 'Virtual',
                'plan'                => 'E906',
                'ciclo_escolar'       => 'AGO-2026/ENE-2027',
                'cupos_totales'       => 1,
                'cupos_ocupados'      => 1,
                'publico_internet'    => 'SI',
                'activo'              => 1,
                'created_at'          => '2026-10-01 23:51:14',
                'updated_at'          => '2026-10-01 23:51:14',
            ],
            [
                'id'                  => 2,
                'unidad_receptora_id' => 4,
                'estudiante_id'       => null,
                'titulo'              => 'DESARROLLO DE MÓDULO DE SEGUIMIENTO DE EGRESADOS',
                'objetivo'            => 'Crear un módulo complementario para dar seguimiento profesional a los egresados y medir la efectividad de los planes de estudio en su inserción laboral.',
                'justificacion'       => 'Es un requisito de acreditación para la facultad mantener contacto con los egresados y conocer su estatus laboral actual.',
                'actividades'         => "1. Elaborar encuestas de satisfacción y recopilación de datos.\n2. Diseñar reportes gráficos en tiempo real con librerías Chart.js.\n3. Programar sistema de mensajería automatizada por correo electrónico.",
                'impacto_social'      => 'Aumenta la tasa de titulación y mejora los planes académicos según las necesidades actuales que demanda el sector empresarial.',
                'tipo_proyecto'       => 'Desarrollo Tecnológico',
                'tipo_modalidad'      => 'Híbrido',
                'plan'                => 'E906',
                'ciclo_escolar'       => 'AGO-2026/ENE-2027',
                'cupos_totales'       => 2,
                'cupos_ocupados'      => 2,
                'publico_internet'    => 'SI',
                'activo'              => 1,
                'created_at'          => '2026-10-01 23:51:14',
                'updated_at'          => '2026-10-01 23:51:14',
            ],

            [
                'id'                  => 4,
                'unidad_receptora_id' => 4,
                'estudiante_id'       => null,
                'titulo'              => 'ANÁLISIS Y OPTIMIZACIÓN DE EFICIENCIA ENERGÉTICA EN EDIFICIOS',
                'objetivo'            => 'Evaluar el consumo de energía eléctrica y térmica en las instalaciones edilicias de la constructora para proponer estrategias y tecnologías sustentables de ahorro.',
                'justificacion'       => 'El incremento de costos y la huella ecológica de la empresa exigen un rediseño bajo criterios de eficiencia e impacto ambiental.',
                'actividades'         => "1. Instalar sensores de medición de consumo en áreas clave.\n2. Recopilar y analizar históricos de facturación eléctrica.\n3. Diseñar plan de sustitución tecnológica y aislamiento térmico.",
                'impacto_social'      => 'Fomenta la cultura de ahorro energético y combate el cambio climático mediante la disminución activa de emisiones de carbono corporativas.',
                'tipo_proyecto'       => 'Investigación',
                'tipo_modalidad'      => 'Híbrido',
                'plan'                => 'E908',
                'ciclo_escolar'       => 'AGO-2026/ENE-2027',
                'cupos_totales'       => 2,
                'cupos_ocupados'      => 1,
                'publico_internet'    => 'SI',
                'activo'              => 1,
                'created_at'          => '2026-10-01 23:51:14',
                'updated_at'          => '2026-10-01 23:51:14',
            ],

            [
                'id'                  => 6,
                'unidad_receptora_id' => 4,
                'estudiante_id'       => null,
                'titulo'              => 'SISTEMA INTEGRAL DE CONTROL DE INVENTARIOS POR CÓDIGO QR',
                'objetivo'            => 'Implementar un sistema digital integrado que registre entradas y salidas de material de almacén mediante el escaneo rápido de etiquetas con códigos QR.',
                'justificacion'       => 'El registro manual en bitácoras físicas propicia errores constantes en existencias, pérdidas de herramientas y demoras operativas.',
                'actividades'         => "1. Generar códigos QR únicos vinculados a registros de artículos.\n2. Desarrollar lector de códigos QR multiplataforma responsivo.\n3. Programar módulo de control de stock y reabastecimiento mínimo.",
                'impacto_social'      => 'Optimiza los recursos materiales del sector productivo, minimizando desperdicios y fugas financieras.',
                'tipo_proyecto'       => 'Desarrollo Tecnológico',
                'tipo_modalidad'      => 'Virtual',
                'plan'                => 'E906',
                'ciclo_escolar'       => 'AGO-2026/ENE-2027',
                'cupos_totales'       => 3,
                'cupos_ocupados'      => 2,
                'publico_internet'    => 'SI',
                'activo'              => 1,
                'created_at'          => '2026-10-01 23:51:14',
                'updated_at'          => '2026-10-01 23:51:14',
            ],
        ];

        foreach ($proyectos as $p) {
            DB::table('proyectos')->updateOrInsert(['id' => $p['id']], $p);
        }
    }
}
