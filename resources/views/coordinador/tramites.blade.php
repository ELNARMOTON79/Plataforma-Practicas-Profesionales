@extends('layouts.coordinador', ['active' => 'tramites', 'title' => 'Trámites - Coordinador'])

@section('content')
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

    <!-- Metrics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 fade-in-up delay-100">
        <!-- Solicitudes Pendientes -->
        <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group border border-transparent hover:border-yellow-300 transition-all duration-300">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
            </div>
            <span class="text-sm font-bold text-gray-500 mb-2">Solicitudes Pendientes</span>
            <div class="flex items-end gap-3 mb-2">
                <span class="text-4xl font-extrabold text-gray-900">{{ $solicitudesPendientesCount }}</span>
                @if($solicitudesPendientesCount > 0)
                    <span class="flex items-center text-xs font-semibold text-yellow-600 bg-yellow-50 px-2 py-0.5 rounded-md mb-1 border border-yellow-100">
                        Nuevas
                    </span>
                @endif
            </div>
            <span class="text-xs text-gray-400 font-medium">Revisión de inicio de prácticas</span>
        </div>

        <!-- Documentos por Validar -->
        <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group border border-transparent hover:border-orange-300 transition-all duration-300">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-orange-500" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
            </div>
            <span class="text-sm font-bold text-gray-500 mb-2">Documentos por Validar</span>
            <div class="flex items-end gap-3 mb-2">
                <span class="text-4xl font-extrabold text-gray-900">{{ $documentosPendientesCount }}</span>
                @if($documentosPendientesCount > 0)
                    <span class="flex items-center text-xs font-semibold text-orange-600 bg-orange-50 px-2 py-0.5 rounded-md mb-1 border border-orange-100">
                        Pendientes
                    </span>
                @endif
            </div>
            <span class="text-xs text-gray-400 font-medium">Expedientes de alumnos</span>
        </div>

        <!-- Documentos Validados -->
        <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group border border-transparent hover:border-green-300 transition-all duration-300">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            </div>
            <span class="text-sm font-bold text-gray-500 mb-2">Documentos Validados</span>
            <div class="flex items-end gap-3 mb-2">
                <span class="text-4xl font-extrabold text-gray-900">{{ $documentosValidadosCount }}</span>
            </div>
            <span class="text-xs text-gray-400 font-medium">Historial completo</span>
        </div>

        <!-- Total Trámites -->
        <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group border border-transparent hover:border-[#6BA53A]/30 transition-all duration-300">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-[#4E7D24]" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>
            </div>
            <span class="text-sm font-bold text-gray-500 mb-2">Total de Trámites</span>
            <div class="flex items-end gap-3 mb-2">
                <span class="text-4xl font-extrabold text-gray-900">{{ $totalTramitesCount }}</span>
            </div>
            <span class="text-xs text-gray-400 font-medium">Ciclo Escolar Activo</span>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-8" aria-label="Navegación de trámites">
            <button onclick="switchTab('solicitudes')" id="tab-solicitudes" class="border-[#6BA53A] text-[#4E7D24] whitespace-nowrap py-4 px-2 border-b-4 font-extrabold text-sm transition-all flex items-center gap-2">
                Solicitudes de Prácticas
                <span class="bg-red-100 text-red-700 py-0.5 px-2.5 rounded-full text-xs ml-1 shadow-sm font-bold">{{ $solicitudesPendientesCount }}</span>
            </button>
            <button onclick="switchTab('documentos')" id="tab-documentos" class="border-transparent text-gray-500 hover:text-[#4E7D24] hover:border-gray-300 whitespace-nowrap py-4 px-2 border-b-4 font-bold text-sm transition-all flex items-center gap-2">
                Validación de Documentos
                <span class="bg-yellow-100 text-yellow-800 py-0.5 px-2.5 rounded-full text-xs ml-1 shadow-sm font-bold">{{ $documentosPendientesCount }}</span>
            </button>
        </nav>
    </div>

    <!-- TAB 1: SOLICITUDES DE PRÁCTICAS -->
    <div id="content-solicitudes" class="block animate-fade-in">
        <!-- Buscador Premium Tab 1 -->
        <form method="GET" action="{{ route('coordinador.tramites') }}" class="glass-card rounded-2xl p-4 mb-6 fade-in-up delay-100">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <label for="search-solicitudes" class="sr-only">Buscar solicitudes</label>
                <input type="text" id="search-solicitudes" name="search_solicitudes" value="{{ request('search_solicitudes') }}" aria-label="Buscar solicitudes de prácticas" class="block w-full pl-11 pr-4 py-2.5 border border-gray-200 rounded-2xl bg-white/50 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#6BA53A] focus:border-transparent text-sm font-medium transition-all" placeholder="Buscar por estudiante, institución o matrícula...">
            </div>
        </form>

        <!-- Tabla Premium de Solicitudes -->
        <div class="glass-card rounded-3xl p-6 md:p-8 fade-in-up delay-200">
            <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2 text-left">
                <svg class="w-5 h-5 text-[#6BA53A]" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Solicitudes Registradas
            </h2>

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
                                <td class="px-6 py-3 whitespace-nowrap text-center">
                                    @if($solicitud->estatus == 'pendiente')
                                        <span class="px-2.5 py-1 text-[10px] leading-5 font-bold rounded-lg bg-yellow-100 text-yellow-800 border border-yellow-200 uppercase">
                                            Pendiente
                                        </span>
                                    @elseif($solicitud->estatus == 'aprobada')
                                        <span class="px-2.5 py-1 text-[10px] leading-5 font-bold rounded-lg bg-green-100 text-green-800 border border-green-200 uppercase">
                                            Aprobada
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
                                            <form id="form-aprobar-{{ $solicitud->id }}" action="{{ route('coordinador.tramites.solicitud.aprobar', $solicitud->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
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
    </div>

    <!-- TAB 2: VALIDACIÓN DE DOCUMENTOS -->
    <div id="content-documentos" class="hidden animate-fade-in">
        <!-- Buscador Premium Tab 2 -->
        <div class="glass-card rounded-2xl p-4 mb-6 fade-in-up delay-100">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <label for="search-documentos" class="sr-only">Buscar documentos</label>
                <input type="text" id="search-documentos" aria-label="Buscar documentos" class="block w-full pl-11 pr-4 py-2.5 border border-gray-200 rounded-2xl bg-white/50 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#6BA53A] focus:border-transparent text-sm font-medium transition-all" placeholder="Buscar por estudiante, tipo de documento o nombre...">
            </div>
        </div>

        <!-- Documentos Pendientes -->
        <div class="glass-card rounded-3xl p-6 md:p-8 mb-8 fade-in-up delay-200">
            <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2 text-left">
                <svg class="w-5 h-5 text-yellow-500" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Documentos Pendientes de Validar
            </h2>

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
                                        <a href="{{ asset('storage/' . $doc->ruta_archivo) }}" target="_blank" class="p-2 text-sky-600 bg-sky-50 hover:bg-sky-155 rounded-xl transition-all shadow-sm" title="Ver documento">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                    </div>
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-left min-w-[200px]">
                                    <span class="text-xs text-gray-500 italic">Pendiente de validación</span>
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-center text-sm font-medium">
                                    <span class="text-xs font-semibold text-yellow-600 bg-yellow-50 px-2.5 py-1 rounded-lg border border-yellow-200">En revisión</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Documentos Validados (Historial) -->
        <div class="glass-card rounded-3xl p-6 md:p-8 fade-in-up delay-300">
            <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2 text-left">
                <svg class="w-5 h-5 text-[#6BA53A]" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Historial de Documentos Validados
            </h2>

            <div class="overflow-x-auto">
                <table id="documentos-validados-table" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl">Estudiante / Documento</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Archivo</th>
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
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-center">
                                    <span class="px-2.5 py-1 inline-flex items-center text-[10px] leading-5 font-bold rounded-lg bg-green-50 text-green-700 border border-green-100">
                                        <span class="w-1 h-1 rounded-full bg-green-500 mr-1.5"></span> Validado
                                    </span>
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-center">
                                    <div class="flex justify-center gap-1.5">
                                        <a href="{{ asset('storage/' . $docValid->ruta_archivo) }}" target="_blank" class="p-2 text-sky-600 bg-sky-50 hover:bg-sky-155 rounded-xl transition-all shadow-sm" title="Ver documento">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts: Tab switcher + dynamic JQuery DataTables filtering -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            // Read search parameter from URL
            const urlParams = new URLSearchParams(window.location.search);
            const searchVal = urlParams.get('search') || '';

            const dtConfig = {
                searching: true,
                lengthChange: false,
                pageLength: 5,
                ordering: true,
                info: false,
                dom: 'rtp',
                language: { url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' }
            };

            // Solicitudes
            let tablaSolicitudes = $('#solicitudes-table').DataTable({
                ...dtConfig,
                columnDefs: [{ orderable: false, targets: [3, 4] }]
            });

            // Documentos Pendientes
            let tablaDocsPendientes = $('#documentos-pendientes-table').DataTable({
                ...dtConfig,
                columnDefs: [{ orderable: false, targets: [2, 3, 4] }]
            });

            // Documentos Validados (Historial)
            let tablaDocsValidados = $('#documentos-validados-table').DataTable({
                ...dtConfig,
                columnDefs: [{ orderable: false, targets: [2, 3] }]
            });

            // Apply search from URL if present
            if (searchVal) {
                const decodedSearch = decodeURIComponent(searchVal);
                
                $('#search-solicitudes').val(decodedSearch);
                tablaSolicitudes.search(decodedSearch).draw();

                $('#search-documentos').val(decodedSearch);
                tablaDocsPendientes.search(decodedSearch).draw();
                tablaDocsValidados.search(decodedSearch).draw();
            }

            // Real-time search inputs binding
            $('#search-solicitudes').on('keyup', function() {
                tablaSolicitudes.search(this.value).draw();
            });

            $('#search-documentos').on('keyup', function() {
                tablaDocsPendientes.search(this.value).draw();
                tablaDocsValidados.search(this.value).draw();
            });
        });

        // ── Tab Switcher ─────────────────────────────────────────────
        function switchTab(tab) {
            const solicitudesContent = document.getElementById('content-solicitudes');
            const documentosContent = document.getElementById('content-documentos');
            const tabSolicitudesBtn = document.getElementById('tab-solicitudes');
            const tabDocumentosBtn = document.getElementById('tab-documentos');

            solicitudesContent.classList.add('hidden');
            solicitudesContent.classList.remove('block');
            documentosContent.classList.add('hidden');
            documentosContent.classList.remove('block');

            tabSolicitudesBtn.classList.remove('border-[#6BA53A]', 'text-[#4E7D24]', 'font-extrabold');
            tabSolicitudesBtn.classList.add('border-transparent', 'text-gray-500', 'font-bold');

            tabDocumentosBtn.classList.remove('border-[#6BA53A]', 'text-[#4E7D24]', 'font-extrabold');
            tabDocumentosBtn.classList.add('border-transparent', 'text-gray-500', 'font-bold');

            if (tab === 'solicitudes') {
                solicitudesContent.classList.remove('hidden');
                solicitudesContent.classList.add('block');
                tabSolicitudesBtn.classList.add('border-[#6BA53A]', 'text-[#4E7D24]', 'font-extrabold');
                tabSolicitudesBtn.classList.remove('border-transparent', 'text-gray-500', 'font-bold');
            } else {
                documentosContent.classList.remove('hidden');
                documentosContent.classList.add('block');
                tabDocumentosBtn.classList.add('border-[#6BA53A]', 'text-[#4E7D24]', 'font-extrabold');
                tabDocumentosBtn.classList.remove('border-transparent', 'text-gray-500', 'font-bold');
            }
        }
    </script>
@endsection
