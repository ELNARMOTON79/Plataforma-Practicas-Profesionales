@extends('layouts.estudiante', ['title' => 'Panel Estudiante - Prácticas Profesionales UdeC', 'active' => 'dashboard'])

@section('content')
    <!-- Welcome Header -->
    <div class="glass-card rounded-3xl p-8 fade-in-up">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-[#4E7D24] to-[#6BA53A] flex items-center justify-center text-white text-2xl font-extrabold shadow-lg">
                    {{ $iniciales }}
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-1">¡Hola, {{ $nombre }}!</h1>
                    <p class="text-gray-600 font-medium flex flex-wrap items-center gap-2 text-sm">
                        @if($carrera !== '—')
                            <span>{{ $carrera }}</span>
                        @endif
                        @if($semestre)
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                            <span>{{ $semestre }}° Semestre</span>
                        @endif
                        @if($grupo)
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                            <span>Grupo {{ $grupo }}</span>
                        @endif
                        @if($matricula !== '—')
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                            <span class="text-[#4E7D24] font-bold">Matrícula: {{ $matricula }}</span>
                        @endif
                    </p>
                </div>
            </div>
            @if($hasPracticaActiva)
            <div class="flex gap-4 items-center w-full lg:w-auto">
                <div class="bg-white/95 px-6 py-3.5 rounded-2xl shadow-sm border border-gray-100 flex-1 lg:flex-initial flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="flex flex-col">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Estatus General</span>
                        <span class="text-base font-extrabold text-[#4E7D24] flex items-center gap-2">
                            <span class="relative flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#6BA53A] opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#4E7D24]"></span>
                            </span>
                            En Curso
                        </span>
                    </div>
                </div>
            </div>
            @elseif($solicitudesPendientes > 0)
            <div class="flex gap-4 items-center w-full lg:w-auto">
                <div class="bg-white/95 px-6 py-3.5 rounded-2xl shadow-sm border border-gray-100 flex-1 lg:flex-initial flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="flex flex-col">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Estatus General</span>
                        <span class="text-base font-extrabold text-blue-600 flex items-center gap-2">
                            <span class="relative flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-200 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-blue-600"></span>
                            </span>
                            En Revisión
                        </span>
                    </div>
                </div>
            </div>
            @else
            <div class="flex gap-4 items-center w-full lg:w-auto">
                <div class="bg-white/95 px-6 py-3.5 rounded-2xl shadow-sm border border-gray-100 flex-1 lg:flex-initial flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="flex flex-col">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Estatus General</span>
                        <span class="text-base font-extrabold text-gray-500 flex items-center gap-2">
                            <span class="relative flex h-2.5 w-2.5">
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-gray-400"></span>
                            </span>
                            Sin solicitud activa
                        </span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">
        
        <!-- Left 2 Columns -->
        <div class="lg:col-span-2 flex flex-col gap-6">
            
            <!-- Progress Section -->
            <div id="progressSection" class="glass-card rounded-3xl p-6 fade-in-up delay-100" data-porcentaje="{{ $porcentajeHoras ?? 0 }}" data-docswidth="{{ $documentosPendientes === 0 ? 100 : (($documentosStatus ? (100 - ($documentosPendientes / count($documentosStatus) * 100)) : 0)) }}">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Progreso del Periodo de Prácticas
                    </h2>
                    @if($hasPracticaActiva)
                    <a href="{{ route('estudiante.proyecto') }}" class="text-xs font-bold text-[#4E7D24] hover:text-[#2E5417] hover:underline flex items-center gap-0.5">
                        Ver Detalles
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    @endif
                </div>

                @if($hasPracticaActiva)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Hours -->
                    <div class="bg-white/60 p-5 rounded-2xl border border-gray-100 flex flex-col justify-between">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-sm font-bold text-gray-500">Horas Acumuladas</span>
                            <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-0.5 rounded-full">{{ $porcentajeHoras }}% Completado</span>
                        </div>
                        <div class="flex items-baseline gap-1 mb-3">
                            <span class="text-3xl font-extrabold text-gray-900">{{ $horasCompletadas }}</span>
                            <span class="text-sm font-medium text-gray-500">/ {{ $horasMeta }} horas</span>
                        </div>
                        <div class="w-full bg-gray-150 rounded-full h-3 overflow-hidden border border-gray-100">
                            <div id="hoursProgressBar" class="bg-gradient-to-r from-blue-500 to-blue-600 h-full rounded-full"></div>
                        </div>
                    </div>
                    <!-- Pending docs -->
                    <div class="bg-white/60 p-5 rounded-2xl border border-gray-100 flex flex-col justify-between">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-sm font-bold text-gray-500">Documentos Pendientes</span>
                            @if($documentosPendientes === 0)
                                <span class="text-xs font-bold text-[#4E7D24] bg-[#6BA53A]/10 px-2.5 py-0.5 rounded-full">Al día</span>
                            @else
                                <span class="text-xs font-bold text-orange-600 bg-orange-50 px-2.5 py-0.5 rounded-full">{{ $documentosPendientes }} pendiente(s)</span>
                            @endif
                        </div>
                        <div class="flex items-baseline gap-1 mb-3">
                            <span class="text-3xl font-extrabold text-gray-900">{{ $documentosPendientes }}</span>
                            <span class="text-sm font-medium text-gray-500">por entregar</span>
                        </div>
                        <div class="w-full bg-gray-150 rounded-full h-3 overflow-hidden border border-gray-100">
                            <div id="docsProgressBar" class="bg-gradient-to-r from-[#4E7D24] to-[#6BA53A] h-full rounded-full"></div>
                        </div>
                    </div>
                </div>
                @elseif($solicitudesPendientes > 0)
                <div class="flex flex-col items-center justify-center py-8 text-center">
                    <svg class="w-12 h-12 text-blue-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <p class="text-sm font-semibold text-blue-600">Solicitud en revisión</p>
                    <p class="text-xs text-gray-300 mt-1">Tu solicitud está pendiente de aprobación. El progreso aparecerá cuando sea aprobada.</p>
                    <a href="{{ route('estudiante.misSolicitudes') }}" class="mt-4 text-xs font-bold text-[#4E7D24] hover:underline">Ver mi solicitud →</a>
                </div>
                @else
                <div class="flex flex-col items-center justify-center py-8 text-center">
                    <svg class="w-12 h-12 text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    <p class="text-sm font-semibold text-gray-400">Sin prácticas activas</p>
                    <p class="text-xs text-gray-300 mt-1">El progreso se mostrará cuando tengas una solicitud aprobada.</p>
                    <a href="{{ route('estudiante.convenios') }}" class="mt-4 text-xs font-bold text-[#4E7D24] hover:underline">Buscar convenios →</a>
                </div>
                @endif
            </div>

            <!-- Documents Checklist Summary -->
            <div class="glass-card rounded-3xl p-6 fade-in-up delay-200">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2 mb-6">
                    <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Estatus de Expediente de Documentos
                </h2>

                @if($hasPracticaActiva)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($documentosStatus as $documento)
                        <div class="flex items-center justify-between p-4 bg-white/70 rounded-2xl border border-gray-100">
                            <div class="flex items-center gap-3">
                                <div class="p-2 rounded-xl {{ $documento['status'] === 'subido' ? 'bg-green-50 text-green-600' : 'bg-gray-50 text-gray-400' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $documento['status'] === 'subido' ? 'M5 13l4 4L19 7' : 'M12 4.5v15m7.5-7.5h-15' }}"></path></svg>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-750">{{ $documento['nombre'] }}</div>
                                    @if($documento['fecha'])
                                        <div class="text-[11px] text-gray-400">Cargado {{ $documento['fecha'] }}</div>
                                    @endif
                                </div>
                            </div>
                            <span class="text-[10px] font-bold {{ $documento['status'] === 'subido' ? 'text-green-700 bg-green-50 border border-green-150' : 'text-gray-500 bg-gray-50 border border-gray-200' }} px-2 py-0.5 rounded-md">
                                 {{ $documento['label'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
                @elseif($solicitudesPendientes > 0)
                <div class="flex flex-col items-center justify-center py-8 text-center">
                    <svg class="w-12 h-12 text-blue-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <p class="text-sm font-semibold text-blue-600">Solicitud en revisión</p>
                    <p class="text-xs text-gray-300 mt-1">Los documentos estarán disponibles una vez que tu solicitud sea aprobada.</p>
                    <a href="{{ route('estudiante.misSolicitudes') }}" class="mt-4 text-xs font-bold text-[#4E7D24] hover:underline">Ver mi solicitud →</a>
                </div>
                @else
                <div class="flex flex-col items-center justify-center py-8 text-center">
                    <svg class="w-12 h-12 text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <p class="text-sm font-semibold text-gray-400">Sin documentos por revisar</p>
                    <p class="text-xs text-gray-300 mt-1">Los documentos aparecerán una vez que tengas una práctica activa.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Right Column: Request Details & Quick Links -->
        <div class="flex flex-col gap-6">
            
            <!-- Quick Actions -->
            <div class="glass-card rounded-3xl p-6 fade-in-up delay-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Accesos Rápidos</h3>
                <div class="flex flex-col gap-3">
                    <a href="{{ route('estudiante.convenios') }}" class="flex items-center gap-4 p-3.5 bg-gradient-to-r from-[#4E7D24]/10 to-transparent hover:from-[#4E7D24]/15 rounded-2xl border border-[#4E7D24]/10 transition-all group">
                        <div class="w-10 h-10 bg-[#4E7D24] text-white rounded-xl flex items-center justify-center shadow-md group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-gray-900">Buscar Convenios</span>
                            <span class="text-xs text-gray-500 font-medium">Ver empresas y vacantes</span>
                        </div>
                    </a>

                    <a href="{{ route('estudiante.proyecto') }}" class="flex items-center gap-4 p-3.5 bg-gradient-to-r from-blue-50 to-transparent hover:from-blue-100/50 rounded-2xl border border-blue-100 transition-all group">
                        <div class="w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center shadow-md group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-gray-900">Subir Documento</span>
                            <span class="text-xs text-gray-500 font-medium">Carga de trámites en formato PDF</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Active Request Widget -->
            <div class="glass-card rounded-3xl p-6 fade-in-up delay-300">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Mi Solicitud de Proyecto
                </h3>

                @if($hasPracticaActiva)
                <div class="bg-gradient-to-br from-green-50 to-green-100/50 border border-green-150 rounded-2xl p-5 flex flex-col items-center text-center shadow-inner">
                    <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center mb-3 text-[#4E7D24] shadow-sm border border-green-50">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="font-bold text-green-950 mb-1">Solicitud Activa</h4>
                    <p class="text-xs text-green-900/90 font-medium mb-3">Tienes {{ $solicitudesActivas }} solicitud(es) en proceso.</p>
                    <a href="{{ route('estudiante.proyecto') }}" class="w-full text-center py-2.5 bg-[#4E7D24] text-white text-xs font-bold rounded-xl hover:bg-[#3d6320] transition-colors block">Ver mis solicitudes</a>
                </div>
                @elseif($solicitudesPendientes > 0)
                <div class="bg-blue-50 rounded-2xl p-5 flex flex-col items-center text-center shadow-inner border border-blue-100">
                    <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center mb-3 text-blue-600 shadow-sm border border-blue-100">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h4 class="font-bold text-blue-900 mb-1">Solicitud en Revisión</h4>
                    <p class="text-xs text-blue-900/90 font-medium mb-3">Tienes {{ $solicitudesPendientes }} solicitud(es) pendientes.</p>
                    <a href="{{ route('estudiante.misSolicitudes') }}" class="w-full text-center py-2.5 bg-[#4E7D24] text-white text-xs font-bold rounded-xl hover:bg-[#3d6320] transition-colors block">Ver mi solicitud</a>
                </div>
                @else
                <div class="flex flex-col items-center justify-center py-8 text-center">
                    <div class="w-14 h-14 bg-gray-50 rounded-full flex items-center justify-center mb-3 text-gray-300 border border-gray-100">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-400">Sin proyecto asignado</p>
                    <p class="text-xs text-gray-300 mt-1 mb-4">Aún no tienes una solicitud de prácticas activa.</p>
                    <a href="{{ route('estudiante.convenios') }}" class="text-xs font-bold text-[#4E7D24] hover:underline">Buscar convenios →</a>
                </div>
                @endif
            </div>
            
            <!-- Academic Contact -->
            <div class="glass-card rounded-3xl p-6 bg-gradient-to-br from-white to-[#6BA53A]/5 border border-[#6BA53A]/10 fade-in-up delay-400">
                <h3 class="text-sm font-bold text-gray-900 mb-3 uppercase tracking-wider">Contacto de Soporte</h3>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div>
                        <span class="block text-sm font-bold text-gray-900">Mtro. Alejandro Ramos</span>
                        <span class="text-[11px] text-gray-500 font-medium">Coordinador de Prácticas</span>
                    </div>
                </div>
                <a href="mailto:aramos@ucol.mx" class="block w-full text-center py-2.5 mt-4 bg-white border border-gray-200 text-xs font-bold text-gray-750 rounded-xl hover:bg-gray-50 transition-colors">Enviar Correo</a>
            </div>

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            try {
                var container = document.getElementById('progressSection');
                if (!container) return;
                var porcentajeHoras = parseFloat(container.getAttribute('data-porcentaje')) || 0;
                var docsWidth = parseFloat(container.getAttribute('data-docswidth')) || 0;

                var hoursBar = document.getElementById('hoursProgressBar');
                if (hoursBar) hoursBar.style.width = porcentajeHoras + '%';

                var docsBar = document.getElementById('docsProgressBar');
                if (docsBar) docsBar.style.width = docsWidth + '%';
            } catch (e) {
                console.error('Error setting progress widths', e);
            }
        });
    </script>
@endsection
