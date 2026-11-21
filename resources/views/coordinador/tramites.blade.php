@extends('layouts.coordinador', ['active' => 'tramites', 'title' => 'Trámites - Coordinador'])

@section('content')
@php
    $activeTab = $activeTab ?? 'solicitudes';
    $search = $search ?? '';
    // Clases CSS para card activa vs inactiva
    $cardActive   = 'glass-card rounded-3xl p-5 flex flex-col relative overflow-hidden group text-left border-2 bg-white shadow-md transition-all duration-300 cursor-pointer';
    $cardInactive = 'glass-card rounded-3xl p-5 flex flex-col relative overflow-hidden group text-left border-2 border-transparent transition-all duration-300 cursor-pointer hover:border-gray-300';
@endphp
    <!-- Header Section -->
    <x-page-header title="Trámites y Expedientes" description="Gestiona las solicitudes de inicio de prácticas y la validación de documentos oficiales." />


    @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-200 text-green-800 text-sm font-semibold flex items-center gap-2">
            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Interactive Metrics Grid (Funciona como selector activo) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8 fade-in-up delay-100">
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
            <span class="text-[11px] text-gray-400 font-medium">Revisión de inicio de prácticas</span>
        </button>

        <!-- 2. Documentos por Validar -->
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

        <!-- 3. Documentos Validados -->
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

        <!-- 4. Solicitudes Aprobadas -->
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
                    {{ $activeTab === 'doc-pendientes' ? 'bg-amber-50 text-amber-600' : ($activeTab === 'doc-validados' ? 'bg-green-50 text-green-600' : 'bg-green-50 text-[#4E7D24]') }}">
                    @if($activeTab === 'doc-pendientes')
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
                        @if($activeTab === 'doc-pendientes') Documentos Pendientes de Validar
                        @elseif($activeTab === 'doc-validados') Historial de Documentos Validados
                        @elseif($activeTab === 'solicitudes-todas') Solicitudes de Prácticas Aprobadas
                        @else Solicitudes Pendientes de Prácticas
                        @endif
                    </h2>
                    <p id="section-subtitle" class="text-xs text-gray-400 font-medium">
                        @if($activeTab === 'doc-pendientes') Expedientes y documentos oficiales subidos por alumnos pendientes de revisión
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
                <form method="GET" action="{{ route('coordinador.tramites') }}">
                    <input type="hidden" name="tab" value="{{ $activeTab }}">
                    <input type="search" name="search" id="search-tramites" value="{{ $search }}" aria-label="Buscar trámites" class="block w-full pl-10 pr-4 py-2 border border-gray-200/90 rounded-xl bg-white/90 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#6BA53A] focus:border-transparent text-xs font-semibold transition-all shadow-xs" placeholder="Buscar por estudiante, empresa o matrícula y presiona Enter">
                </form>
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
                @include('coordinador.tramites.paginacion', ['items' => $solicitudes])
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
                                        <a href="{{ route('documentos.archivo', $doc->id) }}" target="_blank" class="text-xs text-sky-700 font-bold hover:underline truncate max-w-[200px]">
                                            {{ basename($doc->ruta_archivo) }}
                                        </a>
                                    </div>
                                    <div class="text-[10px] text-gray-400 font-semibold mt-0.5">
                                        Cargado: {{ $doc->fecha_carga ? \Carbon\Carbon::parse($doc->fecha_carga)->format('d/m/Y') : 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-center">
                                    <div class="flex justify-center gap-1.5">
                                        <button type="button" onclick="openPreviewModal(@js(route('documentos.archivo', $doc->id)), @js($doc->nombre_doc), @js($doc->solicitud->estudiante->nombre_completo ?? ''))" class="p-2 text-sky-600 bg-sky-50 hover:bg-sky-100 rounded-xl transition-all shadow-sm cursor-pointer" title="Previsualizar documento">
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
                @include('coordinador.tramites.paginacion', ['items' => $documentosPendientes])
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
                                        <a href="{{ route('documentos.archivo', $docValid->id) }}" target="_blank" class="text-xs text-sky-700 font-bold hover:underline truncate max-w-[200px]">
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
                                        <button type="button" onclick="openPreviewModal(@js(route('documentos.archivo', $docValid->id)), @js($docValid->nombre_doc), @js($docValid->solicitud->estudiante->nombre_completo ?? ''))" class="p-2 text-sky-600 bg-sky-50 hover:bg-sky-100 rounded-xl transition-all shadow-sm cursor-pointer" title="Previsualizar documento">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @include('coordinador.tramites.paginacion', ['items' => $documentosValidados])
            </div>
        </div>
    </div>

    <script>
        // Cada pestaña se carga desde el servidor (paginada); se conserva la búsqueda actual
        function switchTab(tab) {
            const params = new URLSearchParams();
            if (tab && tab !== 'solicitudes') params.set('tab', tab);
            const search = (document.getElementById('search-tramites')?.value || '').trim();
            if (search) params.set('search', search);
            const url = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
            // Un enlace dentro del <body hx-boost> navega igual que el resto del sistema (con historial)
            const enlace = document.createElement('a');
            enlace.href = url;
            enlace.hidden = true;
            document.body.appendChild(enlace);
            enlace.click();
            enlace.remove();
        }
        window.switchTab = switchTab;
    </script>

    @include('coordinador.tramites.preview-modal')
@endsection
