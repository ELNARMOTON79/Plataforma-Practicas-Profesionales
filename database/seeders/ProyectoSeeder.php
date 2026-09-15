<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProyectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first available receptive unit ID (normally 4) to prevent foreign key errors
        $urId = DB::table('unidades_receptoras')->value('id') ?? 4;

        DB::table('proyectos')->truncate();

        DB::table('proyectos')->insert([
            [
                'id' => 1,
                'unidad_receptora_id' => $urId,
                'titulo' => 'PLATAFORMA WEB PARA ADMINISTRACIÓN DE PRÁCTICAS',
                'tipo_proyecto' => 'Desarrollo Tecnológico',
                'tipo_modalidad' => 'Virtual',
                'objetivo' => 'Desarrollar una aplicación web interactiva que permita digitalizar y automatizar el control, recepción y aprobación de las prácticas profesionales de los estudiantes de manera eficiente.',
                'justificacion' => 'El sistema actual basado en papel y hojas de cálculo genera retrasos, pérdidas de información y duplicidad de tareas en la coordinación.',
                'actividades' => "1. Diseñar la arquitectura de base de datos relacional.\n2. Programar controladores y vistas en Laravel con TailwindCSS.\n3. Implementar pruebas unitarias y de integración.\n4. Documentar el código y manual de usuario.",
                'impacto_social' => 'Facilita la vinculación rápida de los jóvenes con el sector productivo local, agilizando su titulación y acceso a empleos.',
                'publico_internet' => 'SI',
                'plan' => 'E906',
                'ciclo_escolar' => 'AGO-2026/ENE-2027',
                'cupos_totales' => 1,
                'cupos_ocupados' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'unidad_receptora_id' => $urId,
                'titulo' => 'DESARROLLO DE MÓDULO DE SEGUIMIENTO DE EGRESADOS',
                'tipo_proyecto' => 'Desarrollo Tecnológico',
                'tipo_modalidad' => 'Híbrido',
                'objetivo' => 'Crear un módulo complementario para dar seguimiento profesional a los egresados y medir la efectividad de los planes de estudio en su inserción laboral.',
                'justificacion' => 'Es un requisito de acreditación para la facultad mantener contacto con los egresados y conocer su estatus laboral actual.',
                'actividades' => "1. Elaborar encuestas de satisfacción y recopilación de datos.\n2. Diseñar reportes gráficos en tiempo real con librerías Chart.js.\n3. Programar sistema de mensajería automatizada por correo electrónico.",
                'impacto_social' => 'Aumenta la tasa de titulación y mejora los planes académicos según las necesidades actuales que demanda el sector empresarial.',
                'publico_internet' => 'SI',
                'plan' => 'E906',
                'ciclo_escolar' => 'AGO-2026/ENE-2027',
                'cupos_totales' => 2,
                'cupos_ocupados' => 2,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'unidad_receptora_id' => $urId,
                'titulo' => 'IMPLEMENTACIÓN DE REDES E INFRAESTRUCTURA DE TELECOMUNICACIONES',
                'tipo_proyecto' => 'Infraestructura',
                'tipo_modalidad' => 'Presencial',
                'objetivo' => 'Rediseñar e implementar la infraestructura física y lógica de telecomunicaciones en las nuevas oficinas del cliente para asegurar un servicio estable.',
                'justificacion' => 'La falta de segmentación de red y el cableado obsoleto producen constantes caídas de red y brechas críticas de seguridad en la empresa.',
                'actividades' => "1. Realizar levantamiento físico y diagrama de topología de red.\n2. Instalar y configurar routers, switches y access points administrables.\n3. Segmentar redes mediante VLANs y configurar firewalls de seguridad.",
                'impacto_social' => 'Garantiza la conectividad continua para los servicios públicos de atención al ciudadano que ofrece la institución.',
                'publico_internet' => 'NO',
                'plan' => 'E907',
                'ciclo_escolar' => 'AGO-2026/ENE-2027',
                'cupos_totales' => 3,
                'cupos_ocupados' => 0,
                'activo' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'unidad_receptora_id' => $urId,
                'titulo' => 'ANÁLISIS Y OPTIMIZACIÓN DE EFICIENCIA ENERGÉTICA EN EDIFICIOS',
                'tipo_proyecto' => 'Investigación',
                'tipo_modalidad' => 'Híbrido',
                'objetivo' => 'Evaluar el consumo de energía eléctrica y térmica en las instalaciones edilicias de la constructora para proponer estrategias y tecnologías sustentables de ahorro.',
                'justificacion' => 'El incremento de costos y la huella ecológica de la empresa exigen un rediseño bajo criterios de eficiencia e impacto ambiental.',
                'actividades' => "1. Instalar sensores de medición de consumo en áreas clave.\n2. Recopilar y analizar históricos de facturación eléctrica.\n3. Diseñar plan de sustitución tecnológica y aislamiento térmico.",
                'impacto_social' => 'Fomenta la cultura de ahorro energético y combate el cambio climático mediante la disminución activa de emisiones de carbono corporativas.',
                'publico_internet' => 'SI',
                'plan' => 'E908',
                'ciclo_escolar' => 'AGO-2026/ENE-2027',
                'cupos_totales' => 2,
                'cupos_ocupados' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'unidad_receptora_id' => $urId,
                'titulo' => 'SISTEMA DE MONITOREO CLIMÁTICO Y CONTROLES AUTOMATIZADOS CON IOT',
                'tipo_proyecto' => 'Desarrollo Tecnológico',
                'tipo_modalidad' => 'Presencial',
                'objetivo' => 'Diseñar un prototipo basado en microcontroladores y sensores IoT que permita monitorear variables climáticas como humedad y temperatura en invernaderos de forma remota.',
                'justificacion' => 'Las pérdidas agrícolas en la región se deben en gran parte al deficiente control de temperatura e irrigación dentro de los plantíos.',
                'actividades' => "1. Programar sensores en microcontroladores ESP32 usando C++.\n2. Crear dashboard de control remoto usando protocolos MQTT.\n3. Configurar alertas SMS/Telegram en caso de anomalías climáticas.",
                'impacto_social' => 'Incrementa la eficiencia y sustentabilidad en la producción de alimentos por parte de los pequeños productores agrícolas locales.',
                'publico_internet' => 'NO',
                'plan' => 'E906',
                'ciclo_escolar' => 'AGO-2026/ENE-2027',
                'cupos_totales' => 1,
                'cupos_ocupados' => 1,
                'activo' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'unidad_receptora_id' => $urId,
                'titulo' => 'SISTEMA INTEGRAL DE CONTROL DE INVENTARIOS POR CÓDIGO QR',
                'tipo_proyecto' => 'Desarrollo Tecnológico',
                'tipo_modalidad' => 'Virtual',
                'objetivo' => 'Implementar un sistema digital integrado que registre entradas y salidas de material de almacén mediante el escaneo rápido de etiquetas con códigos QR.',
                'justificacion' => 'El registro manual en bitácoras físicas propicia errores constantes en existencias, pérdidas de herramientas y demoras operativas.',
                'actividades' => "1. Generar códigos QR únicos vinculados a registros de artículos.\n2. Desarrollar lector de códigos QR multiplataforma responsivo.\n3. Programar módulo de control de stock y reabastecimiento mínimo.",
                'impacto_social' => 'Optimiza los recursos materiales del sector productivo, minimizando desperdicios y fugas financieras.',
                'publico_internet' => 'SI',
                'plan' => 'E906',
                'ciclo_escolar' => 'AGO-2026/ENE-2027',
                'cupos_totales' => 3,
                'cupos_ocupados' => 2,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
