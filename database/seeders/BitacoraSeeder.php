<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BitacoraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate to start fresh
        DB::table('bitacora')->truncate();

        $logs = [
            [
                'timestamp' => Carbon::now()->subMinutes(2),
                'level' => 'success',
                'level_name' => 'Éxito',
                'user' => 'Carlos Alonso',
                'user_role' => 'Coordinador',
                'user_email' => 'coordinador_fime@ucol.mx',
                'module' => 'Documentos',
                'action' => 'Documento Aprobado',
                'description' => 'El coordinador Carlos Alonso aprobó la Carta de Aceptación del alumno Juan Pérez.',
                'ip' => '192.168.1.45',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
                'payload' => json_encode([
                    'documento_id' => 104,
                    'documento_tipo' => 'Carta de Aceptación',
                    'alumno' => 'Juan Pérez',
                    'alumno_id' => 20205849,
                    'aprobado_por' => 'Carlos Alonso',
                    'fecha_aprobacion' => Carbon::now()->subMinutes(2)->toDateTimeString(),
                    'comentarios' => 'Documento cumple con todos los requisitos de horas y firmas autorizadas.'
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            ],
            [
                'timestamp' => Carbon::now()->subMinutes(15),
                'level' => 'info',
                'level_name' => 'Info',
                'user' => 'Innovación Digital SA',
                'user_role' => 'Empresa',
                'user_email' => 'contacto@innovacion.com',
                'module' => 'Empresas',
                'action' => 'Nueva Empresa Registrada',
                'description' => 'La empresa Innovación Digital SA completó su registro de perfil en la plataforma.',
                'ip' => '189.245.12.102',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36',
                'payload' => json_encode([
                    'empresa_id' => 15,
                    'nombre_comercial' => 'Innovación Digital SA',
                    'rfc' => 'IDI190520XYZ',
                    'correo_contacto' => 'contacto@innovacion.com',
                    'sector' => 'Tecnología y Desarrollo de Software',
                    'representante' => 'Ing. Marta Rodríguez',
                    'estado' => 'Pendiente de Validación'
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            ],
            [
                'timestamp' => Carbon::now()->subMinutes(50),
                'level' => 'success',
                'level_name' => 'Éxito',
                'user' => 'María Gómez',
                'user_role' => 'Alumno',
                'user_email' => 'mgomez12@ucol.mx',
                'module' => 'Proyectos',
                'action' => 'Solicitud de Proyecto',
                'description' => 'La alumna María Gómez aplicó a la vacante "Desarrollo Web Frontend" en Tech Solutions.',
                'ip' => '192.168.1.189',
                'user_agent' => 'Mozilla/5.0 (Linux; Android 13; SM-S901B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Mobile Safari/537.36',
                'payload' => json_encode([
                    'alumno_id' => 20194875,
                    'alumno_nombre' => 'María Gómez',
                    'proyecto_id' => 8,
                    'proyecto_titulo' => 'Desarrollo Web Frontend',
                    'empresa' => 'Tech Solutions SA',
                    'fecha_solicitud' => Carbon::now()->subMinutes(50)->toDateTimeString()
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            ],
            [
                'timestamp' => Carbon::now()->subHours(2),
                'level' => 'danger',
                'level_name' => 'Error',
                'user' => 'admin@ucol.mx',
                'user_role' => 'Administrador',
                'user_email' => 'admin@ucol.mx',
                'module' => 'Autenticación',
                'action' => 'Inicio de Sesión Fallido',
                'description' => 'Múltiples intentos fallidos para la cuenta admin@ucol.mx desde IP 187.21.90.4',
                'ip' => '187.21.90.4',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:125.0) Gecko/20100101 Firefox/125.0',
                'payload' => json_encode([
                    'intento_correo' => 'admin@ucol.mx',
                    'contador_intentos' => 5,
                    'origen_ip' => '187.21.90.4',
                    'resultado' => 'Cuenta bloqueada temporalmente por 15 minutos',
                    'cabeceras' => [
                        'Accept-Language' => 'ru-RU,ru;q=0.9,en-US;q=0.8',
                        'Connection' => 'keep-alive'
                    ]
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            ],
            [
                'timestamp' => Carbon::yesterday()->setTime(23, 59, 1),
                'level' => 'info',
                'level_name' => 'Info',
                'user' => 'Sistema Automático',
                'user_role' => 'Sistema',
                'user_email' => 'system@ucol.mx',
                'module' => 'Sistema',
                'action' => 'Cierre de Periodo Mensual',
                'description' => 'El sistema realizó el corte automático de horas acumuladas del mes de Mayo.',
                'ip' => '127.0.0.1',
                'user_agent' => 'Console/Cron-Job (Ubuntu 22.04 LTS CLI)',
                'payload' => json_encode([
                    'cron_job' => 'prácticas:cierre-mensual',
                    'fecha_ejecucion' => Carbon::yesterday()->setTime(23, 59, 1)->toDateTimeString(),
                    'alumnos_procesados' => 142,
                    'horas_consolidadas' => 5680,
                    'reportes_generados' => 12,
                    'estado' => 'Completado con éxito sin fallos'
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            ],
            [
                'timestamp' => Carbon::yesterday()->setTime(16, 30, 45),
                'level' => 'warning',
                'level_name' => 'Advertencia',
                'user' => 'Admin Principal',
                'user_role' => 'Administrador',
                'user_email' => 'admin@ucol.mx',
                'module' => 'Usuarios',
                'action' => 'Modificación de Permisos',
                'description' => 'Se actualizaron los privilegios del coordinador Ana Lilia (FIME) para supervisión de trámites.',
                'ip' => '192.168.1.15',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
                'payload' => json_encode([
                    'modificado_por' => 'Admin Principal',
                    'usuario_afectado' => 'Ana Lilia Valdovinos',
                    'usuario_id' => 1023,
                    'cambios' => [
                        'rol' => 'Coordinador',
                        'permisos_anteriores' => ['ver_alumnos', 'ver_reportes'],
                        'permisos_nuevos' => ['ver_alumnos', 'ver_reportes', 'aprobar_tramites', 'gestionar_proyectos']
                    ],
                    'motivo' => 'Asignación de jefatura de carrera de Sistemas'
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            ],
            [
                'timestamp' => Carbon::yesterday()->setTime(4, 15, 0),
                'level' => 'danger',
                'level_name' => 'Error',
                'user' => 'Servicio de Respaldo',
                'user_role' => 'Sistema',
                'user_email' => 'backup@ucol.mx',
                'module' => 'Sistema',
                'action' => 'Fallo de Respaldo en la Nube',
                'description' => 'No se pudo sincronizar el archivo de respaldo semanal al almacenamiento en la nube AWS S3.',
                'ip' => '10.0.0.4',
                'user_agent' => 'AWS-SDK-PHP/3.280 GuzzleHttp/7.8 curl/8.5',
                'payload' => json_encode([
                    'tarea' => 'db:backup-upload',
                    'archivo_local' => '/storage/backups/backup_20260521_040001.sql.gz',
                    'tamano_bytes' => 452891000,
                    'destino_bucket' => 'ppweb-uol-backups',
                    'codigo_error' => 'S3Exception (507 Insufficient Storage)',
                    'mensaje' => 'El almacenamiento del bucket de destino o el límite mensual del servicio ha sido superado.',
                    'reintentos_fallidos' => 3
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            ],
            [
                'timestamp' => Carbon::now()->subDays(2)->setTime(14, 12, 5),
                'level' => 'success',
                'level_name' => 'Éxito',
                'user' => 'Roberto García',
                'user_role' => 'Alumno',
                'user_email' => 'rgarcia19@ucol.mx',
                'module' => 'Autenticación',
                'action' => 'Cambio de Contraseña',
                'description' => 'El alumno Roberto García cambió su contraseña de acceso exitosamente desde el perfil.',
                'ip' => '201.175.45.19',
                'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_4_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.4.1 Mobile/15E148 Safari/605.1.15',
                'payload' => json_encode([
                    'usuario_id' => 20206987,
                    'metodo' => 'Perfil del Usuario (Contraseña Anterior)',
                    'seguridad_fortaleza' => 'Fuerte (14 caracteres, alfanumérico + símbolos)',
                    'notificacion_enviada' => true,
                    'correo_notificado' => 'rgarcia19@ucol.mx'
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            ],
            [
                'timestamp' => Carbon::now()->subDays(2)->setTime(11, 5, 30),
                'level' => 'warning',
                'level_name' => 'Advertencia',
                'user' => 'Carlos Alonso',
                'user_role' => 'Coordinador',
                'user_email' => 'coordinador_fime@ucol.mx',
                'module' => 'Documentos',
                'action' => 'Documento Rechazado',
                'description' => 'El coordinador Carlos Alonso rechazó el Reporte Mensual 1 del alumno Pedro Torres.',
                'ip' => '192.168.1.45',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
                'payload' => json_encode([
                    'documento_id' => 98,
                    'documento_tipo' => 'Reporte Mensual 1',
                    'alumno' => 'Pedro Torres',
                    'alumno_id' => 20214879,
                    'motivo_rechazo' => 'Falta firma del asesor organizacional de la empresa.',
                    'notificado_alumno' => true
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            ]
        ];

        foreach ($logs as $log) {
            DB::table('bitacora')->insert(array_merge($log, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));
        }
    }
}
