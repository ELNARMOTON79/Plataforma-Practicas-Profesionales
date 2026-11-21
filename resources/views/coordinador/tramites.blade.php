@extends('layouts.coordinador', ['active' => 'tramites', 'title' => 'Trámites - Coordinador'])

@section('content')
@php
    $activeTab = request('tab', 'solicitudes');
    // Clases CSS para card activa vs inactiva
    $cardActive   = 'glass-card rounded-3xl p-5 flex flex-col relative overflow-hidden group text-left border-2 bg-white shadow-md transition-all duration-300 cursor-pointer';
    $cardInactive = 'glass-card rounded-3xl p-5 flex flex-col relative overflow-hidden group text-left border-2 border-transparent transition-all duration-300 cursor-pointer hover:border-gray-300';
@endphp
    <!-- Header Section -->
    <x-page-header title="Trámites y Expedientes" description="Gestiona las solicitudes de inicio de prácticas y la validación de documentos oficiales." />

    <!-- Style overrides for premium DataTables integration -->
    <style>
        .dataTables_paginate {
            margin-top: 1.5rem;
            display: flex;
            justify-content: flex-end;
            gap: 0.25rem;
        }
        .dataTables_paginate .paginate_button {
            padding: 0.4rem 0.8rem;
            border-radius: 0.75rem;
            font-size: 0.75rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid #E5E7EB;
            background: white;
            color: #4B5563 !important;
        }
        .dataTables_paginate .paginate_button.current {
            background: #4E7D24 !important;
            color: white !important;
            border-color: #4E7D24;
        }
        .dataTables_paginate .paginate_button:hover:not(.current) {
            background: #F3F4F6 !important;
            color: #1F2937 !important;
        }
        .dataTables_paginate .paginate_button.disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }
    </style>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-200 text-green-800 text-sm font-semibold flex items-center gap-2">
            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Interactive Metrics Grid (Funciona como selector activo) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8 fade-in-up delay-100">
        <!-- 1. Solicitudes Pendientes (Activo por defecto) -->
        <button type="button" onclick="switchTab('solicitudes')" id="metric-solicitudes"
            class="{{ in_array($activeTab, ['solicitudes', '']) ? $cardActive . ' border-[#4E7D24] ring-4 ring-[#4E7D24]/10' : $cardInactive . ' hover:border-[#4E7D24]/40' }}">
            <div class="flex items-center justify-between w-full mb-2">
                <span class="text-xs font-bold uppercase tracking-wider {{ in_array($activeTab, ['solicitudes', '']) ? 'text-[#4E7D24]' : 'text-gray-500 group-hover:text-[#4E7D24] transition-colors' }}">Solicitudes Pendientes</span>
                <span class="w-2.5 h-2.5 rounded-full bg-yellow-500 animate-pulse"></span>
            </div>
            <div class="flex items-end gap-3 mb-1">
                <span class="text-3xl font-extrabold text-gray-900">{{ $solicitudesPendientesCount }}</span>
                @if($solicitudesPendientesCount > 0)
                    <span class="flex items-center text-[10px] font-extrabold text-yellow-700 bg-yellow-100 px-2 py-0.5 rounded-md mb-1 border border-yellow-200">
                        Nuevas
                    </span>
                @endif
            </div>
            <span class="text-[11px] text-gray-400 font-medium">Inicio de prácticas</span>
        </button>

        <!-- 2. Propuestas de Proyecto -->
        <button type="button" onclick="switchTab('proyectos-pendientes')" id="metric-proyectos-pendientes"
            class="{{ $activeTab === 'proyectos-pendientes' ? $cardActive . ' border-purple-500 ring-4 ring-purple-500/10' : $cardInactive . ' hover:border-purple-300' }}">
            <div class="flex items-center justify-between w-full mb-2">
                <span class="text-xs font-bold uppercase tracking-wider {{ $activeTab === 'proyectos-pendientes' ? 'text-purple-700' : 'text-gray-500 group-hover:text-purple-700 transition-colors' }}">Propuestas de Proyecto</span>
                <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
            </div>
            <div class="flex items-end gap-3 mb-1">
                <span class="text-3xl font-extrabold text-gray-900">{{ $proyectosPendientesCount }}</span>
                @if($proyectosPendientesCount > 0)
                    <span class="flex items-center text-[10px] font-extrabold text-purple-700 bg-purple-100 px-2 py-0.5 rounded-md mb-1 border border-purple-200">
                        Por Revisar
                    </span>
                @endif
            </div>
            <span class="text-[11px] text-gray-400 font-medium">Proyectos de alumnos</span>
        </button>

        <!-- 3. Documentos por Validar -->
        <button type="button" onclick="switchTab('doc-pendientes')" id="metric-doc-pendientes"
            class="{{ $activeTab === 'doc-pendientes' ? $cardActive . ' border-amber-400 ring-4 ring-amber-400/10' : $cardInactive . ' hover:border-amber-300' }}">
            <div class="flex items-center justify-between w-full mb-2">
                <span class="text-xs font-bold uppercase tracking-wider {{ $activeTab === 'doc-pendientes' ? 'text-amber-700' : 'text-gray-500 group-hover:text-amber-700 transition-colors' }}">Documentos por Validar</span>
                <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>
            </div>
            <div class="flex items-end gap-3 mb-1">
                <span class="text-3xl font-extrabold text-gray-900">{{ $documentosPendientesCount }}</span>
                @if($documentosPendientesCount > 0)
                    <span class="flex items-center text-[10px] font-extrabold text-amber-700 bg-amber-100 px-2 py-0.5 rounded-md mb-1 border border-amber-200">
                        Pendientes
                    </span>
                @endif
            </div>
            <span class="text-[11px] text-gray-400 font-medium">Expedientes de alumnos</span>
        </button>

        <!-- 4. Documentos Validados -->
        <button type="button" onclick="switchTab('doc-validados')" id="metric-doc-validados"
            class="{{ $activeTab === 'doc-validados' ? $cardActive . ' border-green-500 ring-4 ring-green-500/10' : $cardInactive . ' hover:border-green-300' }}">
            <div class="flex items-center justify-between w-full mb-2">
                <span class="text-xs font-bold uppercase tracking-wider {{ $activeTab === 'doc-validados' ? 'text-green-700' : 'text-gray-500 group-hover:text-green-700 transition-colors' }}">Documentos Validados</span>
                <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
            </div>
            <div class="flex items-end gap-3 mb-1">
                <span class="text-3xl font-extrabold text-gray-900">{{ $documentosValidadosCount }}</span>
            </div>
            <span class="text-[11px] text-gray-400 font-medium">Historial completo</span>
        </button>

        <!-- 5. Solicitudes Aprobadas -->
        <button type="button" onclick="switchTab('solicitudes-todas')" id="metric-total"
            class="{{ $activeTab === 'solicitudes-todas' ? $cardActive . ' border-[#4E7D24] ring-4 ring-[#4E7D24]/10' : $cardInactive . ' hover:border-[#6BA53A]/30' }}">
            <div class="flex items-center justify-between w-full mb-2">
                <span class="text-xs font-bold uppercase tracking-wider {{ $activeTab === 'solicitudes-todas' ? 'text-[#4E7D24]' : 'text-gray-500 group-hover:text-[#4E7D24] transition-colors' }}">Solicitudes Aprobadas</span>
                <span class="w-2.5 h-2.5 rounded-full bg-[#4E7D24]"></span>
            </div>
            <div class="flex items-end gap-3 mb-1">
                <span class="text-3xl font-extrabold text-gray-900">{{ $solicitudesAprobadasCount }}</span>
            </div>
            <span class="text-[11px] text-gray-400 font-medium">Prácticas activas</span>
        </button>
    </div>

    <div class="glass-card rounded-3xl p-6 md:p-8 fade-in-up delay-200">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div id="section-icon" class="p-2.5 rounded-2xl transition-all
                    {{ $activeTab === 'proyectos-pendientes' ? 'bg-purple-50 text-purple-700' : ($activeTab === 'doc-pendientes' ? 'bg-amber-50 text-amber-600' : ($activeTab === 'doc-validados' ? 'bg-green-50 text-green-600' : 'bg-green-50 text-[#4E7D24]')) }}">
                    @if($activeTab === 'proyectos-pendientes')
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    @elseif($activeTab === 'doc-pendientes')
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1 -18 0 9 9 0 0 1 18 0z"></path></svg>
                    @elseif($activeTab === 'doc-validados')
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 1 1 -18 0 9 9 0 0 1 18 0z"></path></svg>
                    @elseif($activeTab === 'solicitudes-todas')
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>
                    @else
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    @endif
                </div>
                <div>
                    <h2 id="section-title" class="text-lg font-extrabold text-gray-800 leading-tight">
                        @if($activeTab === 'proyectos-pendientes') Propuestas de Proyecto por Revisar
                        @elseif($activeTab === 'doc-pendientes') Documentos Pendientes de Validar
                        @elseif($activeTab === 'doc-validados') Historial de Documentos Validados
                        @elseif($activeTab === 'solicitudes-todas') Solicitudes de Prácticas Aprobadas
                        @else Solicitudes Pendientes de Prácticas
                        @endif
                    </h2>
                    <p id="section-subtitle" class="text-xs text-gray-400 font-medium">
                        @if($activeTab === 'proyectos-pendientes') Proyectos propuestos por estudiantes pendientes de autorización o retroalimentación
                        @elseif($activeTab === 'doc-pendientes') Expedientes y documentos oficiales subidos por alumnos pendientes de revisión
                        @elseif($activeTab === 'doc-validados') Registro histórico completo de los expedientes validados y autorizados
                        @elseif($activeTab === 'solicitudes-todas') Historial de las solicitudes que ya fueron aprobadas para inicio de prácticas
                        @else Revisión y autorización de inicio de prácticas profesionales pendientes
                        @endif
                    </p>
                </div>
            </div>

            <div class="relative w-full sm:w-80 md:w-96">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <svg class="h-4 w-4" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <label for="search-tramites" class="sr-only">Buscar trámites</label>
                <input type="text" id="search-tramites" value="{{ request('search') ?? request('search_solicitudes') }}" aria-label="Buscar trámites" class="block w-full pl-10 pr-4 py-2 border border-gray-200/90 rounded-xl bg-white/90 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#6BA53A] focus:border-transparent text-xs font-semibold transition-all shadow-xs" placeholder="Buscar por estudiante, empresa o matrícula...">
            </div>
        </div>

        <div id="content-solicitudes" class="{{ in_array($activeTab, ['solicitudes', 'solicitudes-todas', '']) ? 'block' : 'hidden' }} animate-fade-in">
            <div class="overflow-x-auto">
                <table id="solicitudes-table" class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl">Estudiante / Matrícula</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Institución / Periodo</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Estado</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Observaciones</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-transparent divide-y divide-gray-100">
                        @foreach($solicitudes as $solicitud)
                            <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                                <!-- Estudiante -->
                                <td class="px-6 py-3 whitespace-nowrap text-left">
                                    <div class="flex items-center gap-3">
                                        <div class="h-9 w-9 rounded-full bg-yellow-100 text-yellow-750 flex items-center justify-center font-bold text-xs select-none">
                                            {{ strtoupper(substr($solicitud->estudiante->nombre_completo ?? 'E', 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors uppercase leading-tight">
                                                {{ $solicitud->estudiante->nombre_completo ?? 'Estudiante no registrado' }}
                                            </div>
                                            <div class="text-[10px] text-gray-400 font-semibold mt-0.5">
                                                Matrícula: {{ $solicitud->estudiante->matricula ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <!-- Institución y Periodo -->
                                <td class="px-6 py-3 text-left max-w-[200px] whitespace-normal">
                                    <div class="text-xs text-gray-800 font-bold uppercase leading-tight break-words">
                                        {{ $solicitud->unidadReceptora->nombre_empresa ?? 'No especificada' }}
                                    </div>
                                    <div class="text-[10px] text-gray-400 font-semibold mt-0.5">
                                        Periodo: {{ $solicitud->fecha_inicio ? \Carbon\Carbon::parse($solicitud->fecha_inicio)->format('d/m/Y') : 'N/A' }} - {{ $solicitud->fecha_fin ? \Carbon\Carbon::parse($solicitud->fecha_fin)->format('d/m/Y') : 'N/A' }}
                                    </div>
                                </td>
                                <!-- Estado -->
                                <td class="px-6 py-3 whitespace-nowrap text-center" data-search="{{ strtolower($solicitud->estatus) }}">
                                    @if($solicitud->estatus == 'pendiente')
                                        <span class="px-2.5 py-1 text-[10px] leading-5 font-bold rounded-lg bg-yellow-100 text-yellow-800 border border-yellow-200 uppercase">
                                            Pendiente
                                        </span>
                                    @elseif($solicitud->estatus == 'aprobada')
                                        <span class="px-2.5 py-1 text-[10px] leading-5 font-bold rounded-lg bg-green-100 text-green-800 border border-green-200 uppercase">
                                            Aprobada
                                        </span>
                                    @elseif($solicitud->estatus == 'en_proceso')
                                        <span class="px-2.5 py-1 text-[10px] leading-5 font-bold rounded-lg bg-blue-100 text-blue-800 border border-blue-200 uppercase">
                                            En Proceso
                                        </span>
                                    @elseif($solicitud->estatus == 'finalizada')
                                        <span class="px-2.5 py-1 text-[10px] leading-5 font-bold rounded-lg bg-emerald-100 text-emerald-800 border border-emerald-200 uppercase">
                                            Finalizada
                                        </span>
                                    @elseif($solicitud->estatus == 'rechazada')
                                        <span class="px-2.5 py-1 text-[10px] leading-5 font-bold rounded-lg bg-red-100 text-red-800 border border-red-200 uppercase">
                                            Rechazada
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 text-[10px] leading-5 font-bold rounded-lg bg-gray-100 text-gray-700 uppercase">
                                            {{ $solicitud->estatus }}
                                        </span>
                                    @endif
                                </td>
                                <!-- Observaciones -->
                                <td class="px-6 py-3 whitespace-normal text-left min-w-[200px]">
                                    @if($solicitud->estatus == 'pendiente')
                                        <input type="text" id="obs-input-{{ $solicitud->id }}" form="form-aprobar-{{ $solicitud->id }}" name="observaciones" class="block w-full px-3 py-1.5 text-xs border border-gray-200 rounded-xl bg-white/50 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] focus:outline-none" placeholder="Añadir observaciones...">
                                    @else
                                        <span class="text-xs text-gray-500 italic">{{ $solicitud->observaciones ?? 'Sin observaciones' }}</span>
                                    @endif
                                </td>
                                <!-- Acciones -->
                                <td class="px-6 py-3 whitespace-nowrap text-center text-sm font-medium">
                                    @if($solicitud->estatus == 'pendiente')
                                        <div class="flex justify-center gap-2">
                                            <form id="form-aprobar-{{ $solicitud->id }}" action="{{ route('coordinador.tramites.solicitud.aprobar', $solicitud->id) }}" method="POST" onsubmit="document.getElementById('hidden-aprobar-obs-{{ $solicitud->id }}').value = document.getElementById('obs-input-{{ $solicitud->id }}').value">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" id="hidden-aprobar-obs-{{ $solicitud->id }}" name="observaciones">
                                                <button type="submit" class="px-3 py-1.5 bg-green-50 hover:bg-green-600 text-green-700 hover:text-white border border-green-200 rounded-xl text-xs font-bold transition-all shadow-sm" title="Aprobar solicitud">
                                                    Aprobar
                                                </button>
                                            </form>
                                            <form id="form-rechazar-{{ $solicitud->id }}" action="{{ route('coordinador.tramites.solicitud.rechazar', $solicitud->id) }}" method="POST" onsubmit="document.getElementById('hidden-obs-{{ $solicitud->id }}').value = document.getElementById('obs-input-{{ $solicitud->id }}').value">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" id="hidden-obs-{{ $solicitud->id }}" name="observaciones">
                                                <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-600 text-red-700 hover:text-white border border-red-200 rounded-xl text-xs font-bold transition-all shadow-sm" title="Rechazar solicitud">
                                                    Rechazar
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-xs font-semibold text-gray-400">Procesado</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- PROPUESTAS DE PROYECTO PENDIENTES -->
        <div id="content-proyectos-pendientes" class="{{ $activeTab === 'proyectos-pendientes' ? 'block' : 'hidden' }} animate-fade-in">
            <div class="overflow-x-auto">
                <table id="proyectos-pendientes-table" class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl">Estudiante / Matrícula</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Proyecto Propuesto / Empresa</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Detalles</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Observaciones / Motivo</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-transparent divide-y divide-gray-100">
                        @foreach($proyectosPendientes as $proy)
                            <tr class="hover:bg-purple-50/30 transition-colors group">
                                <!-- Estudiante -->
                                <td class="px-6 py-3 whitespace-nowrap text-left">
                                    <div class="flex items-center gap-3">
                                        <div class="h-9 w-9 rounded-full bg-purple-100 text-purple-750 flex items-center justify-center font-bold text-xs select-none">
                                            {{ strtoupper(substr($proy->estudiante->nombre_completo ?? 'P', 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="text-xs font-bold text-gray-900 group-hover:text-purple-700 transition-colors uppercase leading-tight">
                                                {{ $proy->estudiante->nombre_completo ?? 'Estudiante' }}
                                            </div>
                                            <div class="text-[10px] text-gray-400 font-semibold mt-0.5">
                                                Cuenta: {{ $proy->estudiante->matricula ?? 'S/N' }} • {{ $proy->estudiante->carrera ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <!-- Proyecto & Empresa -->
                                <td class="px-6 py-3 text-left max-w-[280px] whitespace-normal">
                                    <div class="text-xs text-gray-800 font-bold uppercase leading-tight break-words">
                                        {{ $proy->titulo }}
                                    </div>
                                    <div class="text-[10px] text-gray-500 font-semibold mt-0.5">
                                        {{ $proy->empresa->nombre_empresa ?? 'No especificada' }}
                                    </div>
                                    <div class="mt-1 flex items-center gap-1.5 flex-wrap">
                                        @if($proy->tipo_proyecto)
                                            <span class="text-[9px] font-bold text-purple-700 bg-purple-50 px-2 py-0.5 rounded border border-purple-100">{{ $proy->tipo_proyecto }}</span>
                                        @endif
                                        @if($proy->tipo_modalidad)
                                            <span class="text-[9px] font-bold text-gray-600 bg-gray-100 px-2 py-0.5 rounded">{{ $proy->tipo_modalidad }}</span>
                                        @endif
                                    </div>
                                </td>
                                <!-- Detalles (Modal) -->
                                <td class="px-6 py-3 whitespace-nowrap text-center">
                                    <button type="button" onclick="abrirModalDetalleProyecto({{ json_encode($proy) }})" class="p-2 text-purple-700 bg-purple-50 hover:bg-purple-100 rounded-xl transition-all shadow-sm cursor-pointer" title="Ver objetivo, justificación y actividades">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                </td>
                                <!-- Input observaciones -->
                                <td class="px-6 py-3 whitespace-normal text-left min-w-[200px]">
                                    <input type="text" id="obs-proy-input-{{ $proy->id }}" form="form-proy-rechazar-{{ $proy->id }}" name="observaciones" class="block w-full px-3 py-1.5 text-xs border border-gray-200 rounded-xl bg-white/50 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 focus:outline-none" placeholder="Motivo en caso de rechazo...">
                                </td>
                                <!-- Acciones -->
                                <td class="px-6 py-3 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center gap-2">
                                        <form id="form-proy-aprobar-{{ $proy->id }}" action="{{ route('coordinador.tramites.proyecto.aprobar', $proy->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3 py-1.5 bg-green-50 hover:bg-green-600 text-green-700 hover:text-white border border-green-200 rounded-xl text-xs font-bold transition-all shadow-sm" title="Aprobar e incorporar proyecto">
                                                Aprobar
                                            </button>
                                        </form>
                                        <form id="form-proy-rechazar-{{ $proy->id }}" action="{{ route('coordinador.tramites.proyecto.rechazar', $proy->id) }}" method="POST" onsubmit="return validarRechazoProyecto({{ $proy->id }})">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-600 text-red-700 hover:text-white border border-red-200 rounded-xl text-xs font-bold transition-all shadow-sm" title="Rechazar y solicitar correcciones">
                                                Rechazar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- DOCUMENTOS PENDIENTES -->
        <div id="content-doc-pendientes" class="{{ $activeTab === 'doc-pendientes' ? 'block' : 'hidden' }} animate-fade-in">
            <div class="overflow-x-auto">
                <table id="documentos-pendientes-table" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl">Estudiante / Tipo Documento</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Archivo / Fecha de Carga</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Visualizar</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Notas de Retroalimentación</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl">Validar</th>
                        </tr>
                    </thead>
                    <tbody class="bg-transparent divide-y divide-gray-100">
                        @foreach($documentosPendientes as $doc)
                            <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                                <td class="px-6 py-3 whitespace-nowrap text-left">
                                    <div class="flex items-center gap-3">
                                        <div class="h-9 w-9 rounded-full bg-orange-100 text-orange-750 flex items-center justify-center font-bold text-xs select-none">
                                            {{ strtoupper(substr($doc->solicitud->estudiante->nombre_completo ?? 'D', 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors uppercase leading-tight">
                                                {{ $doc->solicitud->estudiante->nombre_completo ?? 'Estudiante' }}
                                            </div>
                                            <div class="text-[9px] font-bold text-orange-650 bg-orange-50/80 px-2 py-0.5 rounded-md mt-1 inline-block uppercase">
                                                {{ $doc->nombre_doc }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-left">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        <a href="{{ asset('storage/' . $doc->ruta_archivo) }}" target="_blank" class="text-xs text-sky-700 font-bold hover:underline truncate max-w-[200px]">
                                            {{ basename($doc->ruta_archivo) }}
                                        </a>
                                    </div>
                                    <div class="text-[10px] text-gray-400 font-semibold mt-0.5">
                                        Cargado: {{ $doc->fecha_carga ? \Carbon\Carbon::parse($doc->fecha_carga)->format('d/m/Y') : 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-center">
                                    <div class="flex justify-center gap-1.5">
                                        <button type="button" onclick="openPreviewModal('{{ asset('storage/' . $doc->ruta_archivo) }}', '{{ e($doc->nombre_doc) }}', '{{ e($doc->solicitud->estudiante->nombre_completo ?? '') }}')" class="p-2 text-sky-600 bg-sky-50 hover:bg-sky-100 rounded-xl transition-all shadow-sm cursor-pointer" title="Previsualizar documento">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-3 whitespace-normal text-left min-w-[200px]">
                                    <input type="text" id="obs-doc-input-{{ $doc->id }}" form="form-doc-validar-{{ $doc->id }}" name="observaciones" class="block w-full px-3 py-1.5 text-xs border border-gray-200 rounded-xl bg-white/50 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] focus:outline-none" placeholder="Añadir observaciones...">
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center gap-2">
                                        <form id="form-doc-validar-{{ $doc->id }}" action="{{ route('coordinador.tramites.documento.validar', $doc->id) }}" method="POST" onsubmit="document.getElementById('hidden-doc-validar-obs-{{ $doc->id }}').value = document.getElementById('obs-doc-input-{{ $doc->id }}').value">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" id="hidden-doc-validar-obs-{{ $doc->id }}" name="observaciones">
                                            <button type="submit" class="px-3 py-1.5 bg-green-50 hover:bg-green-600 text-green-700 hover:text-white border border-green-200 rounded-xl text-xs font-bold transition-all shadow-sm" title="Validar documento">
                                                Validar
                                            </button>
                                        </form>
                                        <form id="form-doc-rechazar-{{ $doc->id }}" action="{{ route('coordinador.tramites.documento.rechazar', $doc->id) }}" method="POST" onsubmit="document.getElementById('hidden-doc-obs-{{ $doc->id }}').value = document.getElementById('obs-doc-input-{{ $doc->id }}').value">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" id="hidden-doc-obs-{{ $doc->id }}" name="observaciones">
                                            <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-600 text-red-700 hover:text-white border border-red-200 rounded-xl text-xs font-bold transition-all shadow-sm" title="Rechazar documento">
                                                Rechazar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- DOCUMENTOS VALIDADOS -->
        <div id="content-doc-validados" class="{{ $activeTab === 'doc-validados' ? 'block' : 'hidden' }} animate-fade-in">
            <div class="overflow-x-auto">
                <table id="documentos-validados-table" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl">Estudiante / Documento</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Archivo / Fecha</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Notas de Retroalimentación</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Estado</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-transparent divide-y divide-gray-100">
                        @foreach($documentosValidados as $docValid)
                            <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                                <td class="px-6 py-3 whitespace-nowrap text-left">
                                    <div class="flex items-center gap-3">
                                        <div class="h-9 w-9 rounded-full bg-green-100 text-green-750 flex items-center justify-center font-bold text-xs select-none">
                                            {{ strtoupper(substr($docValid->solicitud->estudiante->nombre_completo ?? 'V', 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors uppercase leading-tight">
                                                {{ $docValid->solicitud->estudiante->nombre_completo ?? 'Estudiante' }}
                                            </div>
                                            <div class="text-[9px] font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-md mt-1 inline-block uppercase">
                                                {{ $docValid->nombre_doc }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-left">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        <a href="{{ asset('storage/' . $docValid->ruta_archivo) }}" target="_blank" class="text-xs text-sky-700 font-bold hover:underline truncate max-w-[200px]">
                                            {{ basename($docValid->ruta_archivo) }}
                                        </a>
                                    </div>
                                    <div class="text-[10px] text-gray-400 font-semibold mt-0.5">
                                        Cargado: {{ $docValid->fecha_carga ? \Carbon\Carbon::parse($docValid->fecha_carga)->format('d/m/Y') : 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-3 whitespace-normal text-left max-w-[220px]">
                                    <span class="text-xs text-gray-600 font-medium italic">{{ $docValid->observaciones ?? 'Sin observaciones' }}</span>
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-center">
                                    <span class="px-2.5 py-1 inline-flex items-center text-[10px] leading-5 font-bold rounded-lg bg-green-50 text-green-700 border border-green-100">
                                        <span class="w-1 h-1 rounded-full bg-green-500 mr-1.5"></span> Validado
                                    </span>
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-center">
                                    <div class="flex justify-center gap-1.5">
                                        <button type="button" onclick="openPreviewModal('{{ asset('storage/' . $docValid->ruta_archivo) }}', '{{ e($docValid->nombre_doc) }}', '{{ e($docValid->solicitud->estudiante->nombre_completo ?? '') }}')" class="p-2 text-sky-600 bg-sky-50 hover:bg-sky-100 rounded-xl transition-all shadow-sm cursor-pointer" title="Previsualizar documento">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        var tablaSolicitudes = null;
        var tablaDocsPendientes = null;
        var tablaDocsValidados = null;

        function initTramitesPage() {
            if (!document.getElementById('solicitudes-table')) return;
            if (typeof $ === 'undefined' || !$.fn.DataTable) return;

            // Destruir instancias previas de forma segura
            ['#solicitudes-table', '#documentos-pendientes-table', '#documentos-validados-table'].forEach(function(selector) {
                if ($.fn.DataTable.isDataTable(selector)) {
                    try {
                        $(selector).DataTable().destroy();
                    } catch (e) {
                        console.warn('Advertencia al resetear DataTable:', e);
                    }
                }
            });
            
            const urlParams = new URLSearchParams(window.location.search);
            const searchVal = urlParams.get('search') || '';
            const tabParam = urlParams.get('tab') || '';

            const emptyStateHTML = `
                <div class="py-12 px-4 text-center flex flex-col items-center justify-center">
                    <div class="w-14 h-14 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mb-3 shadow-inner border border-gray-200/50">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-sm font-bold text-gray-700">Sin datos disponibles</h3>
                    <p class="text-xs text-gray-400 mt-1 max-w-xs">No existen registros pendientes en esta categoría actualmente.</p>
                </div>
            `;

            // Configuración local en español (sin peticiones externas que puedan fallar sin internet)
            const dtConfig = {
                destroy: true,
                searching: true,
                lengthChange: false,
                pageLength: 5,
                ordering: true,
                info: false,
                dom: 'rtp',
                language: {
                    emptyTable: emptyStateHTML,
                    zeroRecords: `
                        <div class="py-12 px-4 text-center flex flex-col items-center justify-center">
                            <div class="w-14 h-14 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mb-3">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-700">Sin coincidencias</h3>
                            <p class="text-xs text-gray-400 mt-1">Intenta ajustando el término de búsqueda.</p>
                        </div>
                    `,
                    paginate: {
                        first: "Primero",
                        previous: "Anterior",
                        next: "Siguiente",
                        last: "Último"
                    }
                }
            };

            // Solicitudes
            tablaSolicitudes = $('#solicitudes-table').DataTable({
                ...dtConfig,
                columnDefs: [{ orderable: false, targets: [3, 4] }]
            });

            // Proyectos Pendientes
            tablaProyectosPendientes = $('#proyectos-pendientes-table').DataTable({
                ...dtConfig,
                columnDefs: [{ orderable: false, targets: [2, 3, 4] }]
            });

            // Documentos Pendientes
            tablaDocsPendientes = $('#documentos-pendientes-table').DataTable({
                ...dtConfig,
                columnDefs: [{ orderable: false, targets: [2, 3, 4] }]
            });

            // Documentos Validados
            tablaDocsValidados = $('#documentos-validados-table').DataTable({
                ...dtConfig,
                columnDefs: [{ orderable: false, targets: [3, 4] }]
            });

            if (searchVal) {
                const decodedSearch = decodeURIComponent(searchVal);
                $('#search-tramites').val(decodedSearch);
                tablaSolicitudes.search(decodedSearch).draw();
                if (tablaProyectosPendientes) tablaProyectosPendientes.search(decodedSearch).draw();
                tablaDocsPendientes.search(decodedSearch).draw();
                tablaDocsValidados.search(decodedSearch).draw();
            }

            $('#search-tramites').off('keyup input').on('keyup input', function() {
                const val = this.value;
                if (tablaSolicitudes) tablaSolicitudes.search(val).draw();
                if (tablaProyectosPendientes) tablaProyectosPendientes.search(val).draw();
                if (tablaDocsPendientes) tablaDocsPendientes.search(val).draw();
                if (tablaDocsValidados) tablaDocsValidados.search(val).draw();
            });

            const targetTab = tabParam || '{{ $activeTab }}' || 'solicitudes';
            switchTab(targetTab);
        }

        // Debounce para evitar ejecuciones concurrentes o múltiples que colisionen en el DOM
        var _initTramitesDebounce = null;
        function triggerInitTramites() {
            if (_initTramitesDebounce) clearTimeout(_initTramitesDebounce);
            _initTramitesDebounce = setTimeout(function() {
                initTramitesPage();
            }, 60);
        }

        if (!window._tramitesListenersRegistered) {
            document.addEventListener('DOMContentLoaded', triggerInitTramites);
            document.addEventListener('htmx:afterSettle', triggerInitTramites);
            window._tramitesListenersRegistered = true;
        }

        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            triggerInitTramites();
        }
        window.switchTab = switchTab;

        function switchTab(tab) {
            const urlParams = new URLSearchParams(window.location.search);
            if (tab && tab !== 'solicitudes') {
                urlParams.set('tab', tab);
            } else {
                urlParams.delete('tab');
            }
            const newUrl = window.location.pathname + (urlParams.toString() ? '?' + urlParams.toString() : '');
            history.replaceState(null, '', newUrl);

            const contentSolicitudes = document.getElementById('content-solicitudes');
            const contentProyectosPendientes = document.getElementById('content-proyectos-pendientes');
            const contentDocPendientes = document.getElementById('content-doc-pendientes');
            const contentDocValidados = document.getElementById('content-doc-validados');

            const mSolicitudes = document.getElementById('metric-solicitudes');
            const mProyectosPendientes = document.getElementById('metric-proyectos-pendientes');
            const mDocPendientes = document.getElementById('metric-doc-pendientes');
            const mDocValidados = document.getElementById('metric-doc-validados');
            const mTotal = document.getElementById('metric-total');

            const sectionIcon = document.getElementById('section-icon');
            const sectionTitle = document.getElementById('section-title');
            const sectionSubtitle = document.getElementById('section-subtitle');

            contentSolicitudes.classList.add('hidden');
            if (contentProyectosPendientes) contentProyectosPendientes.classList.add('hidden');
            contentDocPendientes.classList.add('hidden');
            contentDocValidados.classList.add('hidden');

            const resetMetricCard = (el, titleColor) => {
                if (!el) return;
                el.className = "glass-card rounded-3xl p-5 flex flex-col relative overflow-hidden group text-left border-2 border-transparent transition-all duration-300 cursor-pointer hover:border-gray-300";
                const spanTitle = el.querySelector('span');
                if (spanTitle) {
                    spanTitle.className = "text-xs font-bold uppercase tracking-wider text-gray-500 group-hover:" + titleColor + " transition-colors";
                }
            };

            resetMetricCard(mSolicitudes, "text-[#4E7D24]");
            resetMetricCard(mProyectosPendientes, "text-purple-700");
            resetMetricCard(mDocPendientes, "text-amber-700");
            resetMetricCard(mDocValidados, "text-green-700");
            resetMetricCard(mTotal, "text-[#4E7D24]");

            if (tab === 'proyectos-pendientes') {
                if (contentProyectosPendientes) contentProyectosPendientes.classList.remove('hidden');
                if (mProyectosPendientes) {
                    mProyectosPendientes.className = "glass-card rounded-3xl p-5 flex flex-col relative overflow-hidden group text-left border-2 border-purple-500 bg-white ring-4 ring-purple-500/10 shadow-md transition-all duration-300 cursor-pointer";
                    const spanP = mProyectosPendientes.querySelector('span');
                    if (spanP) spanP.className = "text-xs font-bold uppercase tracking-wider text-purple-700";
                }

                sectionIcon.className = "p-2.5 rounded-2xl bg-purple-50 text-purple-700 transition-all";
                sectionIcon.innerHTML = `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>`;
                sectionTitle.textContent = "Propuestas de Proyecto por Revisar";
                sectionSubtitle.textContent = "Proyectos propuestos por estudiantes pendientes de autorización o retroalimentación";
            } else if (tab === 'doc-pendientes') {
                contentDocPendientes.classList.remove('hidden');
                mDocPendientes.className = "glass-card rounded-3xl p-5 flex flex-col relative overflow-hidden group text-left border-2 border-amber-400 bg-white ring-4 ring-amber-400/10 shadow-md transition-all duration-300 cursor-pointer";
                mDocPendientes.querySelector('span').className = "text-xs font-bold uppercase tracking-wider text-amber-700";

                sectionIcon.className = "p-2.5 rounded-2xl bg-amber-50 text-amber-600 transition-all";
                sectionIcon.innerHTML = `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1 -18 0 9 9 0 0 1 18 0z"></path></svg>`;
                sectionTitle.textContent = "Documentos Pendientes de Validar";
                sectionSubtitle.textContent = "Expedientes y documentos oficiales subidos por alumnos pendientes de revisión";
            } else if (tab === 'doc-validados') {
                contentDocValidados.classList.remove('hidden');
                mDocValidados.className = "glass-card rounded-3xl p-5 flex flex-col relative overflow-hidden group text-left border-2 border-green-500 bg-white ring-4 ring-green-500/10 shadow-md transition-all duration-300 cursor-pointer";
                mDocValidados.querySelector('span').className = "text-xs font-bold uppercase tracking-wider text-green-700";

                sectionIcon.className = "p-2.5 rounded-2xl bg-green-50 text-green-600 transition-all";
                sectionIcon.innerHTML = `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 1 1 -18 0 9 9 0 0 1 18 0z"></path></svg>`;
                sectionTitle.textContent = "Historial de Documentos Validados";
                sectionSubtitle.textContent = "Registro histórico completo de los expedientes validados y autorizados";
            } else if (tab === 'solicitudes-todas') {
                contentSolicitudes.classList.remove('hidden');
                mTotal.className = "glass-card rounded-3xl p-5 flex flex-col relative overflow-hidden group text-left border-2 border-[#4E7D24] bg-white ring-4 ring-[#4E7D24]/10 shadow-md transition-all duration-300 cursor-pointer";
                mTotal.querySelector('span').className = "text-xs font-bold uppercase tracking-wider text-[#4E7D24]";

                sectionIcon.className = "p-2.5 rounded-2xl bg-green-50 text-[#4E7D24] transition-all";
                sectionIcon.innerHTML = `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>`;
                sectionTitle.textContent = "Solicitudes de Prácticas Aprobadas";
                sectionSubtitle.textContent = "Historial de las solicitudes que ya fueron aprobadas para inicio de prácticas";

                if (tablaSolicitudes) {
                    tablaSolicitudes.column(2).search('aprobada|en_proceso|finalizada', true, false).draw();
                }
            } else {
                contentSolicitudes.classList.remove('hidden');
                mSolicitudes.className = "glass-card rounded-3xl p-5 flex flex-col relative overflow-hidden group text-left border-2 border-[#4E7D24] bg-white ring-4 ring-[#4E7D24]/10 shadow-md transition-all duration-300 cursor-pointer";
                mSolicitudes.querySelector('span').className = "text-xs font-bold uppercase tracking-wider text-[#4E7D24]";

                sectionIcon.className = "p-2.5 rounded-2xl bg-green-50 text-[#4E7D24] transition-all";
                sectionIcon.innerHTML = `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>`;
                sectionTitle.textContent = "Solicitudes Pendientes de Prácticas";
                sectionSubtitle.textContent = "Revisión y autorización de inicio de prácticas profesionales pendientes";

                if (tablaSolicitudes) {
                    tablaSolicitudes.column(2).search('pendiente', false, false).draw();
                }
            }
        }

        function abrirModalDetalleProyecto(proy) {
            if (!proy) return;
            document.getElementById('modal-proy-titulo').textContent = proy.titulo || 'Sin título';
            const est = proy.estudiante || {};
            document.getElementById('modal-proy-alumno').textContent = (est.nombre_completo || 'Estudiante') + (est.matricula ? ' • Matrícula: ' + est.matricula : '') + (est.carrera ? ' • ' + est.carrera : '');
            document.getElementById('modal-proy-empresa').textContent = proy.empresa?.nombre_empresa || 'No especificada';
            document.getElementById('modal-proy-tipo').textContent = [proy.tipo_proyecto, proy.tipo_modalidad].filter(Boolean).join(' · ') || 'No especificado';
            document.getElementById('modal-proy-objetivo').textContent = proy.objetivo || 'Sin objetivo';
            document.getElementById('modal-proy-justificacion').textContent = proy.justificacion || 'Sin justificación';
            document.getElementById('modal-proy-actividades').textContent = proy.actividades || 'Sin actividades';
            document.getElementById('modal-proy-impacto').textContent = proy.impacto_social || 'Sin impacto social';
            document.getElementById('modal-detalle-proyecto').classList.remove('hidden');
        }

        function cerrarModalDetalleProyecto() {
            document.getElementById('modal-detalle-proyecto').classList.add('hidden');
        }

        function validarRechazoProyecto(id) {
            const input = document.getElementById('obs-proy-input-' + id);
            if (!input || !input.value.trim()) {
                alert('Por favor escribe el motivo del rechazo en el campo de texto antes de rechazar.');
                if (input) input.focus();
                return false;
            }
            return confirm('¿Estás seguro de rechazar esta propuesta de proyecto? El alumno recibirá tus observaciones para corregirlo.');
        }
    </script>

    <!-- Modal: Detalle de Propuesta de Proyecto -->
    <div id="modal-detalle-proyecto" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="relative w-full max-w-3xl bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 flex flex-col max-h-[90vh] animate-fade-in">
            <!-- Header Modal -->
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-purple-50/50">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-xl bg-purple-100 text-purple-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <h3 id="modal-proy-titulo" class="text-sm font-extrabold text-gray-900 leading-tight">Propuesta de Proyecto</h3>
                        <p id="modal-proy-alumno" class="text-xs text-purple-700 font-semibold"></p>
                    </div>
                </div>
                <button type="button" onclick="cerrarModalDetalleProyecto()" class="p-2 text-gray-400 hover:text-gray-600 rounded-xl hover:bg-gray-100 transition-all cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Body Modal -->
            <div class="p-6 space-y-4 overflow-y-auto text-xs text-gray-700">
                <div class="grid grid-cols-2 gap-4 pb-3 border-b border-gray-100">
                    <div>
                        <span class="block text-gray-400 font-bold uppercase tracking-wider text-[10px]">Empresa / Institución</span>
                        <span id="modal-proy-empresa" class="font-bold text-gray-800 text-sm"></span>
                    </div>
                    <div>
                        <span class="block text-gray-400 font-bold uppercase tracking-wider text-[10px]">Tipo / Modalidad</span>
                        <span id="modal-proy-tipo" class="font-semibold text-gray-800"></span>
                    </div>
                </div>

                <div>
                    <span class="block text-gray-400 font-bold uppercase tracking-wider text-[10px] mb-1">Objetivo del Proyecto</span>
                    <p id="modal-proy-objetivo" class="bg-gray-50 p-3 rounded-xl border border-gray-100 text-gray-800 whitespace-pre-line"></p>
                </div>

                <div>
                    <span class="block text-gray-400 font-bold uppercase tracking-wider text-[10px] mb-1">Justificación</span>
                    <p id="modal-proy-justificacion" class="bg-gray-50 p-3 rounded-xl border border-gray-100 text-gray-800 whitespace-pre-line"></p>
                </div>

                <div>
                    <span class="block text-gray-400 font-bold uppercase tracking-wider text-[10px] mb-1">Actividades Principales</span>
                    <p id="modal-proy-actividades" class="bg-gray-50 p-3 rounded-xl border border-gray-100 text-gray-800 whitespace-pre-line"></p>
                </div>

                <div>
                    <span class="block text-gray-400 font-bold uppercase tracking-wider text-[10px] mb-1">Impacto Social</span>
                    <p id="modal-proy-impacto" class="bg-gray-50 p-3 rounded-xl border border-gray-100 text-gray-800 whitespace-pre-line"></p>
                </div>
            </div>

            <!-- Footer Modal -->
            <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex justify-end gap-2">
                <button type="button" onclick="cerrarModalDetalleProyecto()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-bold rounded-xl transition-all">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    @include('coordinador.tramites.preview-modal')
@endsection
