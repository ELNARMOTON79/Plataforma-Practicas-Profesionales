@extends('layouts.estudiante', ['title' => 'Panel Estudiante - Prácticas Profesionales UdeC', 'active' => 'dashboard'])

@section('content')
    <!-- Welcome Header -->
    <div class="glass-card rounded-3xl p-8 fade-in-up">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-[#4E7D24] to-[#6BA53A] flex items-center justify-center text-white text-2xl font-extrabold shadow-lg">
                    {{ strtoupper(substr(auth()->user()->correo ?? 'E', 0, 2)) }}
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-1">¡Hola, Estudiante!</h1>
                    <p class="text-gray-600 font-medium flex flex-wrap items-center gap-2 text-sm">
                        <span>Ingeniería en Software</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                        <span>6° Semestre</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                        <span>Grupo B</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                        <span class="text-[#4E7D24] font-bold">Matrícula: 20183492</span>
                    </p>
                </div>
            </div>
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
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">
        
        <!-- Left 2 Columns -->
        <div class="lg:col-span-2 flex flex-col gap-6">
            
            <!-- Progress Section -->
            <div class="glass-card rounded-3xl p-6 fade-in-up delay-100">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Progreso del Periodo de Prácticas
                    </h2>
                    <a href="{{ route('estudiante.proyecto') }}" class="text-xs font-bold text-[#4E7D24] hover:text-[#2E5417] hover:underline flex items-center gap-0.5">
                        Ver Detalles
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Hours -->
                    <div class="bg-white/60 p-5 rounded-2xl border border-gray-100 flex flex-col justify-between">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-sm font-bold text-gray-500">Horas Acumuladas</span>
                            <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-0.5 rounded-full">33% Completado</span>
                        </div>
                        <div class="flex items-baseline gap-1 mb-3">
                            <span class="text-3xl font-extrabold text-gray-900">120</span>
                            <span class="text-sm font-medium text-gray-500">/ 360 horas</span>
                        </div>
                        <div class="w-full bg-gray-150 rounded-full h-3 overflow-hidden border border-gray-100">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-full rounded-full" style="width: 33.3%"></div>
                        </div>
                    </div>

                    <!-- Days -->
                    <div class="bg-white/60 p-5 rounded-2xl border border-gray-100 flex flex-col justify-between">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-sm font-bold text-gray-500">Días Transcurridos</span>
                            <span class="text-xs font-bold text-[#4E7D24] bg-[#6BA53A]/10 px-2.5 py-0.5 rounded-full">25% Completado</span>
                        </div>
                        <div class="flex items-baseline gap-1 mb-3">
                            <span class="text-3xl font-extrabold text-gray-900">30</span>
                            <span class="text-sm font-medium text-gray-500">/ 120 días</span>
                        </div>
                        <div class="w-full bg-gray-150 rounded-full h-3 overflow-hidden border border-gray-100">
                            <div class="bg-gradient-to-r from-[#4E7D24] to-[#6BA53A] h-full rounded-full" style="width: 25%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents Checklist Summary -->
            <div class="glass-card rounded-3xl p-6 fade-in-up delay-200">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Estatus de Expediente de Documentos
                    </h2>
                    <span class="text-xs font-bold text-gray-500 bg-gray-100 px-3 py-1 rounded-lg">2 / 6 Aprobados</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Doc 1 -->
                    <div class="flex items-center justify-between p-4 bg-white/70 rounded-2xl border border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-green-50 text-green-600 rounded-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-750">Carta de Presentación</span>
                        </div>
                        <span class="text-[10px] font-bold text-green-700 bg-green-50 border border-green-150 px-2 py-0.5 rounded-md">Aprobado</span>
                    </div>

                    <!-- Doc 2 -->
                    <div class="flex items-center justify-between p-4 bg-white/70 rounded-2xl border border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-green-50 text-green-600 rounded-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-750">Carta de Aceptación</span>
                        </div>
                        <span class="text-[10px] font-bold text-green-700 bg-green-50 border border-green-150 px-2 py-0.5 rounded-md">Aprobado</span>
                    </div>

                    <!-- Doc 3 -->
                    <div class="flex items-center justify-between p-4 bg-white/70 rounded-2xl border border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-red-50 text-red-500 rounded-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-750">Plan de Trabajo</span>
                        </div>
                        <span class="text-[10px] font-bold text-red-700 bg-red-50 border border-red-150 px-2 py-0.5 rounded-md" title="Error en firmas de la empresa. Reemplazar en la sección Proyecto.">Rechazado</span>
                    </div>

                    <!-- Doc 4 -->
                    <div class="flex items-center justify-between p-4 bg-white/70 rounded-2xl border border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-yellow-50 text-yellow-600 rounded-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-750">Memoria de Prácticas</span>
                        </div>
                        <span class="text-[10px] font-bold text-yellow-700 bg-yellow-50 border border-yellow-150 px-2 py-0.5 rounded-md">En Revisión</span>
                    </div>

                    <!-- Doc 5 -->
                    <div class="flex items-center justify-between p-4 bg-white/70 rounded-2xl border border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-gray-50 text-gray-400 rounded-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-750">Evaluación de Desempeño</span>
                        </div>
                        <span class="text-[10px] font-bold text-gray-500 bg-gray-50 border border-gray-200 px-2 py-0.5 rounded-md">Sin Subir</span>
                    </div>

                    <!-- Doc 6 -->
                    <div class="flex items-center justify-between p-4 bg-white/70 rounded-2xl border border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-gray-50 text-gray-400 rounded-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-750">Carta de Término</span>
                        </div>
                        <span class="text-[10px] font-bold text-gray-500 bg-gray-50 border border-gray-200 px-2 py-0.5 rounded-md">Sin Subir</span>
                    </div>
                </div>
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

                <div class="bg-gradient-to-br from-green-50 to-green-100/50 border border-green-150 rounded-2xl p-5 flex flex-col items-center text-center shadow-inner">
                    <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center mb-3 text-[#4E7D24] shadow-sm border border-green-50">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="font-bold text-green-950 mb-1">Estado: Aceptada</h4>
                    <p class="text-xs text-green-900/90 font-medium mb-3">Tu solicitud ha sido aprobada por la empresa y el coordinador.</p>
                    
                    <div class="w-full text-left bg-white/70 p-3 rounded-xl border border-green-100 text-xs text-gray-700 font-medium">
                        <p class="mb-1"><span class="text-gray-400 font-bold">Empresa:</span> Tech Solutions S.A.</p>
                        <p class="mb-1"><span class="text-gray-400 font-bold">Proyecto:</span> Desarrollo de App Móvil</p>
                        <p><span class="text-gray-400 font-bold">Asignado el:</span> 12 de Abril, 2026</p>
                    </div>
                </div>
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
@endsection
