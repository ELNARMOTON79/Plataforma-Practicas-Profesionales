@extends('layouts.admin', ['title' => 'Bitácora del Sistema - Administrador UdeC', 'active' => 'bitacora'])

@php
    // Mock activity logs array containing realistic data from the platform
    $logs = [
        [
            'id' => 1,
            'timestamp' => '2026-05-22 08:33:15',
            'time_ago' => 'Hace 2 min',
            'level' => 'success', // success, info, warning, danger
            'level_name' => 'Éxito',
            'user' => 'Carlos Alonso',
            'user_role' => 'Coordinador',
            'user_email' => 'coordinador_fime@ucol.mx',
            'user_avatar_bg' => 'bg-blue-100 text-blue-600',
            'user_avatar_txt' => 'CA',
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
                'fecha_aprobacion' => '2026-05-22 08:33:15',
                'comentarios' => 'Documento cumple con todos los requisitos de horas y firmas autorizadas.'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        ],
        [
            'id' => 2,
            'timestamp' => '2026-05-22 08:20:00',
            'time_ago' => 'Hace 15 min',
            'level' => 'info',
            'level_name' => 'Info',
            'user' => 'Innovación Digital SA',
            'user_role' => 'Empresa',
            'user_email' => 'contacto@innovacion.com',
            'user_avatar_bg' => 'bg-yellow-100 text-yellow-600',
            'user_avatar_txt' => 'ID',
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
            'id' => 3,
            'timestamp' => '2026-05-22 07:45:10',
            'time_ago' => 'Hace 50 min',
            'level' => 'success',
            'level_name' => 'Éxito',
            'user' => 'María Gómez',
            'user_role' => 'Alumno',
            'user_email' => 'mgomez12@ucol.mx',
            'user_avatar_bg' => 'bg-purple-100 text-purple-600',
            'user_avatar_txt' => 'MG',
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
                'fecha_solicitud' => '2026-05-22 07:45:10'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        ],
        [
            'id' => 4,
            'timestamp' => '2026-05-22 06:12:33',
            'time_ago' => 'Hace 2 horas',
            'level' => 'danger',
            'level_name' => 'Error',
            'user' => 'admin@ucol.mx',
            'user_role' => 'Administrador',
            'user_email' => 'admin@ucol.mx',
            'user_avatar_bg' => 'bg-red-100 text-red-600',
            'user_avatar_txt' => 'AD',
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
            'id' => 5,
            'timestamp' => '2026-05-21 23:59:01',
            'time_ago' => 'Ayer',
            'level' => 'info',
            'level_name' => 'Info',
            'user' => 'Sistema Automático',
            'user_role' => 'Sistema',
            'user_email' => 'system@ucol.mx',
            'user_avatar_bg' => 'bg-gray-100 text-gray-600',
            'user_avatar_txt' => 'SY',
            'module' => 'Sistema',
            'action' => 'Cierre de Periodo Mensual',
            'description' => 'El sistema realizó el corte automático de horas acumuladas del mes de Mayo.',
            'ip' => '127.0.0.1',
            'user_agent' => 'Console/Cron-Job (Ubuntu 22.04 LTS CLI)',
            'payload' => json_encode([
                'cron_job' => 'prácticas:cierre-mensual',
                'fecha_ejecucion' => '2026-05-21 23:59:01',
                'alumnos_procesados' => 142,
                'horas_consolidadas' => 5680,
                'reportes_generados' => 12,
                'estado' => 'Completado con éxito sin fallos'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        ],
        [
            'id' => 6,
            'timestamp' => '2026-05-21 16:30:45',
            'time_ago' => 'Ayer',
            'level' => 'warning',
            'level_name' => 'Advertencia',
            'user' => 'Admin Principal',
            'user_role' => 'Administrador',
            'user_email' => 'admin@ucol.mx',
            'user_avatar_bg' => 'bg-red-100 text-red-600',
            'user_avatar_txt' => 'AP',
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
            'id' => 7,
            'timestamp' => '2026-05-21 04:15:00',
            'time_ago' => 'Ayer',
            'level' => 'danger',
            'level_name' => 'Error',
            'user' => 'Servicio de Respaldo',
            'user_role' => 'Sistema',
            'user_email' => 'backup@ucol.mx',
            'user_avatar_bg' => 'bg-gray-100 text-gray-600',
            'user_avatar_txt' => 'BK',
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
            'id' => 8,
            'timestamp' => '2026-05-20 14:12:05',
            'time_ago' => 'Hace 2 días',
            'level' => 'success',
            'level_name' => 'Éxito',
            'user' => 'Roberto García',
            'user_role' => 'Alumno',
            'user_email' => 'rgarcia19@ucol.mx',
            'user_avatar_bg' => 'bg-purple-100 text-purple-600',
            'user_avatar_txt' => 'RG',
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
            'id' => 9,
            'timestamp' => '2026-05-20 11:05:30',
            'time_ago' => 'Hace 2 días',
            'level' => 'warning',
            'level_name' => 'Advertencia',
            'user' => 'Carlos Alonso',
            'user_role' => 'Coordinador',
            'user_email' => 'coordinador_fime@ucol.mx',
            'user_avatar_bg' => 'bg-blue-100 text-blue-600',
            'user_avatar_txt' => 'CA',
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
@endphp

@section('content')
    <!-- Page Header Section -->
    <x-page-header title="Bitácora del Sistema" description="Monitoreo de actividades, auditoría de seguridad e historial de eventos en tiempo real.">
        <x-slot:actions>
            <div class="flex flex-wrap gap-2">
                <button type="button" onclick="exportLogs('CSV')" class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 px-4 py-2.5 rounded-xl text-sm font-bold shadow-sm hover:shadow transition-all flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Exportar CSV
                </button>
                <button type="button" onclick="exportLogs('PDF')" class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 px-4 py-2.5 rounded-xl text-sm font-bold shadow-sm hover:shadow transition-all flex items-center gap-2">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    Exportar PDF
                </button>
                <button type="button" onclick="openClearLogsConfirm()" class="bg-red-50 hover:bg-red-100 text-red-700 border border-red-100 px-4 py-2.5 rounded-xl text-sm font-bold shadow-sm transition-all flex items-center gap-2">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Limpiar Bitácora
                </button>
            </div>
        </x-slot>
    </x-page-header>

    <!-- Top KPI Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 fade-in-up delay-100 relative z-30">
        <!-- Card 1: Total Events -->
        <div class="glass-card rounded-3xl p-6 flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Actividades Hoy</span>
                <h3 class="text-3xl font-extrabold text-gray-900" id="stat-total-events">148</h3>
                <div class="flex items-center gap-1 text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-md w-fit">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    <span>+12% ayer</span>
                </div>
            </div>
            <div class="h-12 w-12 rounded-2xl bg-[#6BA53A]/10 text-[#4E7D24] flex items-center justify-center shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
        </div>

        <!-- Card 2: Warnings -->
        <div class="glass-card rounded-3xl p-6 flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Advertencias</span>
                <h3 class="text-3xl font-extrabold text-gray-900" id="stat-warnings">3</h3>
                <div class="flex items-center gap-1 text-xs font-semibold text-yellow-600 bg-yellow-50 px-2 py-0.5 rounded-md w-fit">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"></path></svg>
                    <span>Estable</span>
                </div>
            </div>
            <div class="h-12 w-12 rounded-2xl bg-yellow-50 text-yellow-600 flex items-center justify-center shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
        </div>

        <!-- Card 3: Critical Errors -->
        <div class="glass-card rounded-3xl p-6 flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Errores Críticos</span>
                <h3 class="text-3xl font-extrabold text-gray-900 text-red-600 animate-pulse" id="stat-errors">1</h3>
                <div class="flex items-center gap-1 text-xs font-semibold text-red-600 bg-red-50 px-2 py-0.5 rounded-md w-fit">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    <span>Revisión req.</span>
                </div>
            </div>
            <div class="h-12 w-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        <!-- Card 4: Active Users -->
        <div class="glass-card rounded-3xl p-6 flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Usuarios Activos</span>
                <h3 class="text-3xl font-extrabold text-gray-900" id="stat-active-users">24</h3>
                <div class="flex items-center gap-1 text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-md w-fit">
                    <span class="w-2 h-2 rounded-full bg-green-500 mr-0.5 mt-0.5 animate-ping"></span>
                    <span>En línea</span>
                </div>
            </div>
            <div class="h-12 w-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Filters & Main Panel -->
    <div class="glass-card rounded-3xl p-6 md:p-8 fade-in-up delay-200 relative z-30 flex-1 flex flex-col min-h-0">
        <!-- Advanced Search, Module and Level Filters -->
        <div class="flex flex-col lg:flex-row gap-4 items-stretch lg:items-center justify-between mb-6 pb-6 border-b border-gray-100">
            <!-- Search & Dropdowns -->
            <div class="flex flex-col md:flex-row gap-3 flex-1">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" id="log-search" oninput="applyFilters()" class="block w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl leading-5 bg-white/50 placeholder-gray-400 focus:outline-none focus:placeholder-gray-400 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] text-sm transition-colors" placeholder="Buscar por usuario, IP, descripción, acción...">
                </div>

                <div class="flex flex-wrap md:flex-nowrap gap-3">
                    <!-- Level Filter -->
                    <select id="filter-level" onchange="applyFilters()" class="block w-full md:w-44 pl-3 pr-10 py-2.5 text-sm border-gray-200 focus:outline-none focus:ring-[#6BA53A] focus:border-[#6BA53A] font-medium rounded-xl bg-white/50 text-gray-700">
                        <option value="">Severidad: Todo</option>
                        <option value="success">Éxito</option>
                        <option value="info">Info</option>
                        <option value="warning">Advertencia</option>
                        <option value="danger">Error</option>
                    </select>

                    <!-- Module Filter -->
                    <select id="filter-module" onchange="applyFilters()" class="block w-full md:w-44 pl-3 pr-10 py-2.5 text-sm border-gray-200 focus:outline-none focus:ring-[#6BA53A] focus:border-[#6BA53A] font-medium rounded-xl bg-white/50 text-gray-700">
                        <option value="">Módulo: Todo</option>
                        <option value="Autenticación">Autenticación</option>
                        <option value="Usuarios">Usuarios</option>
                        <option value="Documentos">Documentos</option>
                        <option value="Proyectos">Proyectos</option>
                        <option value="Empresas">Empresas</option>
                        <option value="Sistema">Sistema</option>
                    </select>

                    <!-- Quick Date Filter -->
                    <select id="filter-date" onchange="applyFilters()" class="block w-full md:w-44 pl-3 pr-10 py-2.5 text-sm border-gray-200 focus:outline-none focus:ring-[#6BA53A] focus:border-[#6BA53A] font-medium rounded-xl bg-white/50 text-gray-700">
                        <option value="">Fecha: Todo</option>
                        <option value="today">Hoy</option>
                        <option value="yesterday">Ayer</option>
                        <option value="older">Más de 2 días</option>
                    </select>
                </div>
            </div>

            <!-- View Toggles (Table vs Timeline) -->
            <div class="flex items-center gap-1.5 bg-gray-100/80 p-1 rounded-2xl self-start lg:self-center">
                <button type="button" id="tab-table" onclick="toggleView('table')" class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 shadow bg-white text-[#4E7D24]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    Tabla
                </button>
                <button type="button" id="tab-timeline" onclick="toggleView('timeline')" class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 text-gray-500 hover:text-gray-900">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Línea de Tiempo
                </button>
            </div>
        </div>

        <!-- 1. VISTA DE TABLA -->
        <div id="container-table-view" class="flex-1 flex flex-col min-h-0">
            <div class="overflow-x-auto flex-1">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl w-44">Fecha / Hora</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-24">Nivel</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-64">Usuario</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-36">Módulo</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Acción / Descripción</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-36">Dirección IP</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl w-24">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="table-body" class="bg-transparent divide-y divide-gray-100">
                        @foreach($logs as $log)
                            <tr class="log-row hover:bg-[#6BA53A]/5 transition-colors group" 
                                data-level="{{ $log['level'] }}" 
                                data-module="{{ $log['module'] }}"
                                data-date-group="@if($log['time_ago'] == 'Hace 2 min' || $log['time_ago'] == 'Hace 15 min' || $log['time_ago'] == 'Hace 50 min' || $log['time_ago'] == 'Hace 2 horas') today @elseif($log['time_ago'] == 'Ayer') yesterday @else older @endif">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                    <div class="font-bold text-gray-800">{{ date('d M Y', strtotime($log['timestamp'])) }}</div>
                                    <div class="text-xs text-gray-400 mt-0.5 font-normal">{{ date('H:i:s', strtotime($log['timestamp'])) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($log['level'] == 'success')
                                        <span class="px-2.5 py-1 inline-flex items-center text-xs leading-5 font-bold rounded-lg bg-green-50 text-green-700 border border-green-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span> {{ $log['level_name'] }}
                                        </span>
                                    @elseif($log['level'] == 'info')
                                        <span class="px-2.5 py-1 inline-flex items-center text-xs leading-5 font-bold rounded-lg bg-blue-50 text-blue-700 border border-blue-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5"></span> {{ $log['level_name'] }}
                                        </span>
                                    @elseif($log['level'] == 'warning')
                                        <span class="px-2.5 py-1 inline-flex items-center text-xs leading-5 font-bold rounded-lg bg-yellow-50 text-yellow-700 border border-yellow-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 mr-1.5"></span> {{ $log['level_name'] }}
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 inline-flex items-center text-xs leading-5 font-bold rounded-lg bg-red-50 text-red-700 border border-red-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span> {{ $log['level_name'] }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-9 w-9 rounded-full {{ $log['user_avatar_bg'] }} flex items-center justify-center font-extrabold text-sm shadow-sm">
                                            {{ $log['user_avatar_txt'] }}
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors">{{ $log['user'] }}</div>
                                            <div class="text-xs text-gray-500 font-semibold">{{ $log['user_role'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-bold">
                                    {{ $log['module'] }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900 mb-0.5">{{ $log['action'] }}</div>
                                    <p class="text-xs text-gray-500 font-medium line-clamp-1">{{ $log['description'] }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-500">
                                    {{ $log['ip'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button type="button" 
                                            data-log="{{ json_encode($log) }}"
                                            onclick="inspectLog(JSON.parse(this.dataset.log))"
                                            class="p-2 text-[#4E7D24] hover:text-[#2E5417] hover:bg-[#6BA53A]/10 rounded-xl transition-all" 
                                            title="Inspeccionar Payload">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 2. VISTA DE LÍNEA DE TIEMPO -->
        <div id="container-timeline-view" class="hidden flex-1 flex flex-col min-h-0">
            <div class="relative flex-1 overflow-y-auto pr-2 space-y-8 py-4">
                <!-- Timeline Central Line -->
                <div class="absolute left-6 md:left-8 top-4 bottom-4 w-px bg-gray-200"></div>

                <div id="timeline-body" class="space-y-8">
                    @foreach($logs as $log)
                        <!-- Timeline Item -->
                        <div class="timeline-row relative pl-14 md:pl-20 transition-all duration-300"
                             data-level="{{ $log['level'] }}" 
                             data-module="{{ $log['module'] }}"
                             data-date-group="@if($log['time_ago'] == 'Hace 2 min' || $log['time_ago'] == 'Hace 15 min' || $log['time_ago'] == 'Hace 50 min' || $log['time_ago'] == 'Hace 2 horas') today @elseif($log['time_ago'] == 'Ayer') yesterday @else older @endif">
                            
                            <!-- Dot Icon -->
                            <div class="absolute left-3.5 md:left-5 top-1.5 w-6 h-6 rounded-full border-2 border-white flex items-center justify-center shadow shadow-gray-200 z-10 
                                @if($log['level'] == 'success') bg-green-500 text-white ring-4 ring-green-50
                                @elseif($log['level'] == 'info') bg-blue-500 text-white ring-4 ring-blue-50
                                @elseif($log['level'] == 'warning') bg-yellow-500 text-white ring-4 ring-yellow-50
                                @else bg-red-500 text-white ring-4 ring-red-50 @endif">
                                
                                @if($log['level'] == 'success')
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                @elseif($log['level'] == 'info')
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @elseif($log['level'] == 'warning')
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                @else
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                @endif
                            </div>

                            <!-- Card container -->
                            <div class="bg-white/60 hover:bg-white/95 rounded-2xl p-5 border border-gray-100 hover:shadow-md transition-all duration-300 max-w-4xl relative group">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3">
                                    <div class="flex items-center gap-2.5">
                                        <span class="text-xs font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wider
                                            @if($log['level'] == 'success') bg-green-50 text-green-700
                                            @elseif($log['level'] == 'info') bg-blue-50 text-blue-700
                                            @elseif($log['level'] == 'warning') bg-yellow-50 text-yellow-700
                                            @else bg-red-50 text-red-700 @endif">
                                            {{ $log['module'] }}
                                        </span>
                                        <span class="text-xs text-gray-400 font-bold">{{ $log['timestamp'] }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-semibold text-[#4E7D24] bg-[#6BA53A]/10 px-2 py-0.5 rounded">{{ $log['time_ago'] }}</span>
                                        <span class="text-xs font-mono bg-gray-50 text-gray-500 px-2 py-0.5 rounded border border-gray-100">IP: {{ $log['ip'] }}</span>
                                    </div>
                                </div>

                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0 h-9 w-9 rounded-full {{ $log['user_avatar_bg'] }} flex items-center justify-center font-extrabold text-sm shadow-xs mt-0.5">
                                            {{ $log['user_avatar_txt'] }}
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-gray-900 mb-1 group-hover:text-[#4E7D24] transition-colors">{{ $log['action'] }}</h4>
                                            <p class="text-xs text-gray-600 font-medium leading-relaxed">{{ $log['description'] }}</p>
                                            <span class="text-[10px] text-gray-400 block mt-2 font-medium">Realizado por: <strong class="text-gray-600">{{ $log['user'] }}</strong> ({{ $log['user_role'] }} &bull; {{ $log['user_email'] }})</span>
                                        </div>
                                    </div>
                                    <button type="button" 
                                            data-log="{{ json_encode($log) }}"
                                            onclick="inspectLog(JSON.parse(this.dataset.log))"
                                            class="px-3 py-1.5 bg-gray-50 hover:bg-[#6BA53A]/10 text-xs font-bold text-gray-600 hover:text-[#4E7D24] border border-gray-200/60 hover:border-[#6BA53A]/30 rounded-lg transition-all self-end sm:self-center"
                                            title="Inspeccionar Payload">
                                        Ver Detalles
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Vista Vacía (No results state) -->
        <div id="no-results-state" class="hidden flex-col items-center justify-center py-16 text-center">
            <div class="h-16 w-16 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mb-4 border border-gray-100">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h4 class="text-base font-bold text-gray-900 mb-1">No se encontraron logs</h4>
            <p class="text-sm text-gray-500 max-w-xs mx-auto">Prueba cambiando los criterios de filtrado o buscando otros términos.</p>
        </div>

        <!-- Simulated Pagination -->
        <div id="pagination-panel" class="mt-6 flex items-center justify-between border-t border-gray-100 pt-6">
            <div class="flex-1 flex justify-between sm:hidden">
                <button type="button" onclick="showToast('Cargando logs anteriores...', 'info')" class="relative inline-flex items-center px-4 py-2 border border-gray-200 text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-xs">
                    Anterior
                </button>
                <button type="button" onclick="showToast('Cargando siguientes logs...', 'info')" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-200 text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-xs">
                    Siguiente
                </button>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700 font-medium">
                        Mostrando <span class="font-bold text-gray-900" id="stat-showing-range">1 a 9</span> de <span class="font-bold text-gray-900" id="stat-total-records">148</span> registros de bitácora
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-xl shadow-xs -space-x-px" aria-label="Pagination">
                        <button type="button" onclick="showToast('Primera página', 'info')" class="relative inline-flex items-center px-2 py-2 rounded-l-xl border border-gray-200 bg-white/50 text-sm font-medium text-gray-500 hover:bg-white transition-colors cursor-pointer">
                            <span class="sr-only">Anterior</span>
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <span aria-current="page" class="z-10 bg-[#6BA53A]/10 border-[#6BA53A]/50 text-[#4E7D24] relative inline-flex items-center px-4 py-2 border text-sm font-bold">
                            1
                        </span>
                        <button type="button" onclick="showToast('Página 2 cargada', 'info')" class="bg-white/50 border-gray-200 text-gray-500 hover:bg-white relative inline-flex items-center px-4 py-2 border text-sm font-medium transition-colors cursor-pointer">
                            2
                        </button>
                        <button type="button" onclick="showToast('Página 3 cargada', 'info')" class="bg-white/50 border-gray-200 text-gray-500 hover:bg-white relative inline-flex items-center px-4 py-2 border text-sm font-medium transition-colors cursor-pointer">
                            3
                        </button>
                        <span class="relative inline-flex items-center px-4 py-2 border border-gray-200 bg-white/50 text-sm font-medium text-gray-700">
                            ...
                        </span>
                        <button type="button" onclick="showToast('Última página cargada', 'info')" class="bg-white/50 border-gray-200 text-gray-500 hover:bg-white relative inline-flex items-center px-4 py-2 border text-sm font-medium transition-colors cursor-pointer">
                            17
                        </button>
                        <button type="button" onclick="showToast('Siguiente página', 'info')" class="relative inline-flex items-center px-2 py-2 rounded-r-xl border border-gray-200 bg-white/50 text-sm font-medium text-gray-500 hover:bg-white transition-colors cursor-pointer">
                            <span class="sr-only">Siguiente</span>
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DE INSPECCIÓN DE DETALLES DEL LOG -->
    <div id="logDetailModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-500/75 backdrop-blur-sm" aria-hidden="true" onclick="closeLogModal()"></div>

            <!-- Modal panel -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block w-full max-w-4xl overflow-hidden text-left align-bottom transition-all transform bg-white rounded-3xl shadow-2xl sm:my-8 sm:align-middle glass-card">
                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <div class="flex items-center gap-3">
                        <span id="modal-badge" class="px-2.5 py-1 text-xs font-extrabold uppercase rounded-lg"></span>
                        <h3 class="text-xl font-bold text-gray-900" id="modal-title">Detalles de Actividad</h3>
                    </div>
                    <button type="button" class="text-gray-400 hover:text-gray-500 transition-colors" onclick="closeLogModal()">
                        <span class="sr-only">Cerrar</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                
                <!-- Body Content -->
                <div class="px-6 py-6 md:px-8 space-y-6">
                    <!-- General Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- User & Meta Info -->
                        <div class="md:col-span-1 space-y-5 border-r border-gray-100 pr-0 md:pr-6">
                            <div>
                                <h5 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Usuario Responsable</h5>
                                <div class="flex items-center">
                                    <div id="modal-avatar" class="flex-shrink-0 h-10 w-10 rounded-full flex items-center justify-center font-extrabold text-sm shadow-xs"></div>
                                    <div class="ml-3">
                                        <div id="modal-username" class="text-sm font-bold text-gray-900"></div>
                                        <div id="modal-userrole" class="text-xs text-gray-500 font-bold"></div>
                                    </div>
                                </div>
                                <div id="modal-useremail" class="text-xs text-gray-400 mt-2 font-medium break-all"></div>
                            </div>

                            <div class="pt-4 border-t border-gray-50">
                                <h5 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Información del Evento</h5>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-xs text-gray-500 font-medium">Módulo:</span>
                                        <span id="modal-module" class="text-xs text-gray-900 font-bold"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-xs text-gray-500 font-medium">Timestamp:</span>
                                        <span id="modal-timestamp" class="text-xs text-gray-900 font-bold font-mono"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-xs text-gray-500 font-medium">Acción:</span>
                                        <span id="modal-action-tag" class="text-xs text-gray-900 font-bold text-right"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-gray-50">
                                <h5 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Conectividad</h5>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-xs text-gray-500 font-medium">Dirección IP:</span>
                                        <span id="modal-ip" class="text-xs text-gray-900 font-bold font-mono"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description & User Agent -->
                        <div class="md:col-span-2 space-y-5">
                            <div>
                                <h5 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Descripción</h5>
                                <p id="modal-description" class="text-sm font-medium text-gray-700 leading-relaxed bg-[#6BA53A]/5 p-4 rounded-2xl border border-[#6BA53A]/10"></p>
                            </div>

                            <div>
                                <h5 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Cliente / Agente de Usuario</h5>
                                <div class="p-3 bg-gray-50 rounded-xl border border-gray-150 flex gap-2.5 items-start">
                                    <svg class="w-4 h-4 text-gray-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    <span id="modal-useragent" class="text-xs text-gray-600 font-medium leading-normal"></span>
                                </div>
                            </div>

                            <div>
                                <h5 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Carga de Contexto (JSON Payload)</h5>
                                <div class="relative group/code">
                                    <pre class="bg-gray-900 rounded-2xl p-4 overflow-x-auto text-xs text-green-400 font-mono shadow-inner max-h-60 max-w-full">
                                        <code id="modal-json"></code>
                                    </pre>
                                    <button type="button" 
                                            onclick="copyJsonPayload()" 
                                            class="absolute right-3 top-3 bg-white/10 hover:bg-white/20 text-white rounded-lg p-1.5 transition-colors opacity-0 group-hover/code:opacity-100 cursor-pointer"
                                            title="Copiar JSON">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex justify-end gap-3 rounded-b-3xl">
                    <button type="button" onclick="closeLogModal()" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors text-sm shadow-xs">
                        Cerrar Detalle
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DE CONFIRMACIÓN PARA LIMPIAR BITÁCORA -->
    <div id="clearLogsConfirmModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-500/75 backdrop-blur-sm" aria-hidden="true" onclick="closeClearLogsConfirm()"></div>

            <!-- Modal panel -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full glass-card">
                <div class="bg-white px-6 pt-6 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 text-red-600 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">¿Limpiar Bitácora del Sistema?</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">¿Estás seguro de que deseas vaciar todos los registros de actividad? Esta acción no se puede deshacer y borrará permanentemente el historial de auditoría de la plataforma.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 sm:px-6 sm:flex sm:flex-row-reverse gap-3 rounded-b-3xl">
                    <button type="button" onclick="executeClearLogs()" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-xs px-4 py-2.5 bg-red-600 text-base font-bold text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Sí, Limpiar Todo
                    </button>
                    <button type="button" onclick="closeClearLogsConfirm()" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-xs px-4 py-2.5 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- TOAST NOTIFICATION CONTAINER -->
    <div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2"></div>

    <!-- JAVASCRIPT FOR INTERACTIVENESS -->
    <script>
        let currentView = 'table';

        // Toggle between Table view and Timeline view
        function toggleView(view) {
            currentView = view;
            const tabTable = document.getElementById('tab-table');
            const tabTimeline = document.getElementById('tab-timeline');
            const containerTable = document.getElementById('container-table-view');
            const containerTimeline = document.getElementById('container-timeline-view');

            if (view === 'table') {
                containerTable.classList.remove('hidden');
                containerTimeline.classList.add('hidden');

                tabTable.className = "px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 shadow bg-white text-[#4E7D24]";
                tabTimeline.className = "px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 text-gray-500 hover:text-gray-900";
            } else {
                containerTable.classList.add('hidden');
                containerTimeline.classList.remove('hidden');

                tabTable.className = "px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 text-gray-500 hover:text-gray-900";
                tabTimeline.className = "px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 shadow bg-white text-[#4E7D24]";
            }
            applyFilters();
        }

        // Apply filters to Table and Timeline views
        function applyFilters() {
            const query = document.getElementById('log-search').value.toLowerCase();
            const level = document.getElementById('filter-level').value;
            const module = document.getElementById('filter-module').value;
            const date = document.getElementById('filter-date').value;

            const tableRows = document.querySelectorAll('.log-row');
            const timelineRows = document.querySelectorAll('.timeline-row');

            let visibleCount = 0;

            // Filter table rows
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const rowLevel = row.getAttribute('data-level');
                const rowModule = row.getAttribute('data-module');
                const rowDate = row.getAttribute('data-date-group');

                const matchesQuery = text.includes(query);
                const matchesLevel = level === "" || rowLevel === level;
                const matchesModule = module === "" || rowModule === module;
                const matchesDate = date === "" || rowDate === date;

                if (matchesQuery && matchesLevel && matchesModule && matchesDate) {
                    row.classList.remove('hidden');
                    if (currentView === 'table') visibleCount++;
                } else {
                    row.classList.add('hidden');
                }
            });

            // Filter timeline items
            timelineRows.forEach(item => {
                const text = item.textContent.toLowerCase();
                const itemLevel = item.getAttribute('data-level');
                const itemModule = item.getAttribute('data-module');
                const itemDate = item.getAttribute('data-date-group');

                const matchesQuery = text.includes(query);
                const matchesLevel = level === "" || itemLevel === level;
                const matchesModule = module === "" || itemModule === module;
                const matchesDate = date === "" || itemDate === date;

                if (matchesQuery && matchesLevel && matchesModule && matchesDate) {
                    item.classList.remove('hidden');
                    if (currentView === 'timeline') visibleCount++;
                } else {
                    item.classList.add('hidden');
                }
            });

            // Update empty state
            const noResults = document.getElementById('no-results-state');
            const pagPanel = document.getElementById('pagination-panel');
            const statShowing = document.getElementById('stat-showing-range');

            if (visibleCount === 0) {
                noResults.classList.remove('hidden');
                noResults.classList.add('flex');
                pagPanel.classList.add('hidden');
            } else {
                noResults.classList.add('hidden');
                noResults.classList.remove('flex');
                pagPanel.classList.remove('hidden');
                statShowing.innerText = `1 a ${visibleCount}`;
            }
        }

        // Inspect log details and open modal
        function inspectLog(log) {
            const modal = document.getElementById('logDetailModal');
            
            // Set levels / badges
            const badge = document.getElementById('modal-badge');
            badge.innerText = log.level_name;
            badge.className = "px-2.5 py-1 text-xs font-extrabold uppercase rounded-lg";
            
            const avatar = document.getElementById('modal-avatar');
            avatar.innerText = log.user_avatar_txt;
            avatar.className = "flex-shrink-0 h-10 w-10 rounded-full flex items-center justify-center font-extrabold text-sm shadow-xs " + log.user_avatar_bg;

            if (log.level === 'success') {
                badge.classList.add('bg-green-50', 'text-green-700', 'border', 'border-green-100');
            } else if (log.level === 'info') {
                badge.classList.add('bg-blue-50', 'text-blue-700', 'border', 'border-blue-100');
            } else if (log.level === 'warning') {
                badge.classList.add('bg-yellow-50', 'text-yellow-700', 'border', 'border-yellow-100');
            } else {
                badge.classList.add('bg-red-50', 'text-red-700', 'border', 'border-red-100');
            }

            // Bind values
            document.getElementById('modal-username').innerText = log.user;
            document.getElementById('modal-userrole').innerText = log.user_role;
            document.getElementById('modal-useremail').innerText = log.user_email;
            document.getElementById('modal-module').innerText = log.module;
            document.getElementById('modal-timestamp').innerText = log.timestamp;
            document.getElementById('modal-action-tag').innerText = log.action;
            document.getElementById('modal-ip').innerText = log.ip;
            document.getElementById('modal-description').innerText = log.description;
            document.getElementById('modal-useragent').innerText = log.user_agent;
            
            // Format JSON payload
            const rawJson = JSON.parse(log.payload);
            document.getElementById('modal-json').textContent = JSON.stringify(rawJson, null, 4);

            modal.classList.remove('hidden');
        }

        // Close details modal
        function closeLogModal() {
            document.getElementById('logDetailModal').classList.add('hidden');
        }

        // Copy JSON payload from modal to clipboard
        function copyJsonPayload() {
            const codeContent = document.getElementById('modal-json').textContent;
            navigator.clipboard.writeText(codeContent).then(() => {
                showToast('¡Carga JSON copiada al portapapeles!', 'success');
            }).catch(err => {
                showToast('Error al copiar JSON', 'danger');
            });
        }

        // Export simulated logs
        function exportLogs(format) {
            showToast(`Generando reporte en formato ${format}...`, 'info');
            setTimeout(() => {
                showToast(`¡Reporte bitacora.${format.toLowerCase()} descargado exitosamente!`, 'success');
            }, 1500);
        }

        // Open clear confirm modal
        function openClearLogsConfirm() {
            document.getElementById('clearLogsConfirmModal').classList.remove('hidden');
        }

        // Close clear confirm modal
        function closeClearLogsConfirm() {
            document.getElementById('clearLogsConfirmModal').classList.add('hidden');
        }

        // Execute clear logs simulation
        function executeClearLogs() {
            closeClearLogsConfirm();
            showToast('Limpiando registros de bitácora...', 'info');

            setTimeout(() => {
                // Clear the logs arrays visually
                document.getElementById('table-body').innerHTML = '';
                document.getElementById('timeline-body').innerHTML = '';
                
                // Clear counts and stats
                document.getElementById('stat-total-events').innerText = '0';
                document.getElementById('stat-warnings').innerText = '0';
                document.getElementById('stat-errors').innerText = '0';
                document.getElementById('stat-total-records').innerText = '0';
                
                // Apply visual empty state
                applyFilters();
                
                showToast('¡Bitácora vaciada con éxito!', 'success');
            }, 1200);
        }

        // Premium Toast Notifications helper
        function showToast(message, type = 'info') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            
            // Base tailwind classes
            toast.className = "flex items-center gap-3 px-5 py-3 rounded-2xl shadow-lg border text-sm font-semibold transition-all duration-300 transform translate-y-2 opacity-0 glass-card max-w-sm";
            
            // Style by type
            if (type === 'success') {
                toast.classList.add('border-green-150', 'text-green-800');
                toast.innerHTML = `<span class="h-6 w-6 rounded-full bg-green-500 text-white flex items-center justify-center flex-shrink-0"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5" d="M5 13l4 4L19 7"></path></svg></span> <span>${message}</span>`;
            } else if (type === 'danger') {
                toast.classList.add('border-red-150', 'text-red-800');
                toast.innerHTML = `<span class="h-6 w-6 rounded-full bg-red-500 text-white flex items-center justify-center flex-shrink-0"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg></span> <span>${message}</span>`;
            } else { // info
                toast.classList.add('border-blue-150', 'text-blue-800');
                toast.innerHTML = `<span class="h-6 w-6 rounded-full bg-blue-500 text-white flex items-center justify-center flex-shrink-0"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></span> <span>${message}</span>`;
            }

            container.appendChild(toast);
            
            // Reflow for transition
            setTimeout(() => {
                toast.classList.remove('translate-y-2', 'opacity-0');
            }, 10);

            // Remove toast after duration
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 3000);
        }
    </script>
@endsection
