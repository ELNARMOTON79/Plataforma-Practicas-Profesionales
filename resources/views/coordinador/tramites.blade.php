@extends('layouts.coordinador', ['active' => 'tramites', 'title' => 'Trámites - Coordinador'])

@section('content')
    <!-- Header Section -->
    <x-page-header title="Trámites y Expedientes" description="Gestiona las solicitudes de inicio de prácticas y la validación de documentos oficiales." />

    {{-- ========== SUCCESS / WARNING ALERTS ========== --}}
    @if(session('success'))
        <div id="successAlert" class="mb-6 bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl shadow-sm flex items-center gap-3 transition-all duration-300 fade-in-up">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span class="font-semibold text-sm">{{ session('success') }}</span>
            <button onclick="document.getElementById('successAlert').remove()" class="text-green-500 hover:text-green-800 transition-colors ml-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    @if(session('warning'))
        <div id="warningAlert" class="mb-6 bg-amber-50 border border-amber-200 text-amber-800 px-6 py-4 rounded-2xl shadow-sm flex items-center gap-3 transition-all duration-300 fade-in-up">
            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <span class="font-semibold text-sm">{{ session('warning') }}</span>
            <button onclick="document.getElementById('warningAlert').remove()" class="text-amber-500 hover:text-amber-800 transition-colors ml-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif


    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200 mb-6 mt-4">
        <nav class="-mb-px flex space-x-8" aria-label="Navegación de trámites">
            <button onclick="switchTab('solicitudes')" id="tab-solicitudes" class="border-[#6BA53A] text-[#4E7D24] whitespace-nowrap py-4 px-2 border-b-4 font-extrabold text-sm transition-colors flex items-center gap-2">
                Solicitudes de Prácticas
                <span class="bg-red-100 text-red-700 py-0.5 px-2.5 rounded-full text-xs ml-1 shadow-sm font-bold">{{ $solicitudes->count() }}</span>
            </button>
            <button onclick="switchTab('documentos')" id="tab-documentos" class="border-transparent text-gray-500 hover:text-[#4E7D24] hover:border-gray-300 whitespace-nowrap py-4 px-2 border-b-4 font-bold text-sm transition-colors flex items-center gap-2">
                Validación de Documentos
                <span class="bg-yellow-100 text-yellow-800 py-0.5 px-2.5 rounded-full text-xs ml-1 shadow-sm font-bold">{{ $documentosPendientes->count() }}</span>
            </button>
        </nav>
    </div>

    <!-- TAB 1: SOLICITUDES DE PRÁCTICAS -->
    <div id="content-solicitudes" class="block animate-fade-in">

        <!-- Buscador Premium Tab 1 -->
        <form method="GET" action="{{ route('coordinador.tramites') }}" class="glass-card rounded-2xl p-4 mb-6 fade-in-up delay-100">
            <input type="hidden" name="tab" value="solicitudes">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <label for="search-solicitudes" class="sr-only">Buscar solicitudes</label>
                <input type="text" name="search_solicitudes" value="{{ request('search_solicitudes') }}" id="search-solicitudes" aria-label="Buscar solicitudes de prácticas" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-white/50 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-[#6BA53A] focus:ring-2 focus:ring-[#6BA53A]/20 sm:text-sm transition-all" placeholder="Buscar por estudiante, institución o periodo...">
                <button type="submit" class="hidden">Buscar</button>
            </div>
        </form>

        <div class="glass-card rounded-3xl p-6 md:p-8 fade-in-up delay-200">
            <h2 class="text-xl font-extrabold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-[#6BA53A]" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Solicitudes Pendientes
            </h2>
            <div class="overflow-x-auto">
                <table id="solicitudes-table" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl whitespace-nowrap">Estudiante</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">No. Cuenta</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Institución</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Periodo</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Hrs/Semana</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Detalles</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl whitespace-nowrap">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-transparent divide-y divide-gray-100">
                        @foreach($solicitudes as $solicitud)
                            <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                                <td class="px-3 py-4 whitespace-nowrap text-center">
                                    <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors">
                                        {{ mb_strtoupper($solicitud->estudiante->nombre_completo ?? 'Sin Nombre') }}
                                    </div>
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">
                                    {{ $solicitud->estudiante->matricula ?? '—' }}
                                </td>
                                <td class="px-3 py-4 text-center whitespace-normal max-w-[160px]">
                                    <div class="text-xs text-gray-600 font-semibold leading-tight break-words">
                                        {{ mb_strtoupper($solicitud->unidadReceptora->nombre_empresa ?? 'No especificada') }}
                                    </div>
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-500">
                                    {{ $solicitud->fecha_inicio ? $solicitud->fecha_inicio->format('d/m/Y') : '—' }} - {{ $solicitud->fecha_fin ? $solicitud->fecha_fin->format('d/m/Y') : '—' }}
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-800">
                                    {{ $solicitud->horas_semanales ?? '480 Hrs Totales' }}
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-center">
                                    <button 
                                        data-estudiante="{{ mb_strtoupper($solicitud->estudiante->nombre_completo ?? 'Sin Nombre') }}"
                                        data-matricula="{{ $solicitud->estudiante->matricula ?? '—' }}"
                                        data-carrera="{{ $solicitud->estudiante->carrera ?? '—' }}"
                                        data-semestre="{{ $solicitud->estudiante->semestre ?? '—' }}"
                                        data-grupo="{{ $solicitud->estudiante->grupo ?? '—' }}"
                                        data-unidad="{{ $solicitud->unidadReceptora->nombre_empresa ?? 'No especificada' }}"
                                        data-departamento="{{ $solicitud->unidadReceptora->unidad_receptora ?? 'General' }}"
                                        data-responsable="{{ $solicitud->responsable ?? '—' }}"
                                        data-inicio="{{ $solicitud->fecha_inicio ? $solicitud->fecha_inicio->format('d/m/Y') : '—' }}"
                                        data-fin="{{ $solicitud->fecha_fin ? $solicitud->fecha_fin->format('d/m/Y') : '—' }}"
                                        data-estatus="{{ $solicitud->estatus }}"
                                        data-titulo="{{ $solicitud->titulo ?? 'Sin título' }}"
                                        data-objetivo="{{ $solicitud->objetivo ?? '—' }}"
                                        data-justificacion="{{ $solicitud->justificacion ?? '—' }}"
                                        data-actividades="{{ $solicitud->actividades ?? '—' }}"
                                        data-impacto="{{ $solicitud->impacto_social ?? '—' }}"
                                        onclick="verDetallesSolicitud(this)" class="px-4 py-2 bg-[#6BA53A]/10 text-[#4E7D24] hover:bg-[#6BA53A]/20 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 mx-auto" title="Ver detalles de la solicitud">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Ver Solicitud
                                    </button>
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center gap-2">
                                        @if($solicitud->estatus === 'pendiente')
                                            <button onclick="confirmarAprobar({{ $solicitud->id }})" class="p-2 text-green-600 bg-green-50 hover:bg-green-100 hover:text-green-700 rounded-lg transition-all cursor-pointer" title="Aprobar solicitud" aria-label="Aprobar solicitud">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </button>
                                            <button onclick="confirmarRechazar({{ $solicitud->id }})" class="p-2 text-red-600 bg-red-50 hover:bg-red-100 hover:text-red-700 rounded-lg transition-all cursor-pointer" title="Rechazar solicitud" aria-label="Rechazar solicitud">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                            </button>
                                        @elseif($solicitud->estatus === 'aprobada')
                                            <span class="px-2.5 py-1 text-xs font-bold bg-green-50 text-green-700 border border-green-200 rounded-lg">Aprobada</span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs font-bold bg-red-50 text-red-700 border border-red-200 rounded-lg">Rechazada</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $solicitudes->appends(request()->query())->links() }}
            </div>
        </div>
    </div>


    <!-- TAB 2: VALIDACIÓN DE DOCUMENTOS -->
    <div id="content-documentos" class="hidden animate-fade-in">

        <!-- Buscador Premium Tab 2 -->
        <form method="GET" action="{{ route('coordinador.tramites') }}" class="glass-card rounded-2xl p-4 mb-6 fade-in-up delay-100">
            <input type="hidden" name="tab" value="documentos">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <label for="search-documentos" class="sr-only">Buscar documentos</label>
                <input type="text" name="search_documentos" value="{{ request('search_documentos') }}" id="search-documentos" aria-label="Buscar documentos pendientes" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-white/50 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-[#6BA53A] focus:ring-2 focus:ring-[#6BA53A]/20 sm:text-sm transition-all" placeholder="Buscar por estudiante, tipo de documento o nombre...">
                <button type="submit" class="hidden">Buscar</button>
            </div>
        </form>

        <!-- Documentos Pendientes -->
        <div class="glass-card rounded-3xl p-6 md:p-8 mb-8 fade-in-up delay-200">
            <h2 class="text-xl font-extrabold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-yellow-500" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Documentos Pendientes de Validar
            </h2>
            <div class="overflow-x-auto">
                <table id="documentos-pendientes-table" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl whitespace-nowrap">Estudiante</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Tipo de Documento</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Nombre de Archivo</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Fecha de Carga</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Acciones</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Notas</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl whitespace-nowrap">Validar</th>
                        </tr>
                    </thead>
                    <tbody class="bg-transparent divide-y divide-gray-100">
                        @foreach($documentosPendientes as $doc)
                            <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                                <td class="px-3 py-4 whitespace-nowrap text-center">
                                    <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors">
                                        {{ mb_strtoupper($doc->solicitud->estudiante->nombre_completo ?? 'Sin Estudiante') }}
                                    </div>
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-semibold text-gray-600">
                                    {{ mb_strtoupper($doc->nombre_doc) }}
                                </td>
                                <td class="px-3 py-4 text-center min-w-[150px]">
                                    <a href="{{ asset($doc->ruta_archivo) }}" target="_blank" class="text-xs text-sky-700 font-bold hover:underline">
                                        {{ basename($doc->ruta_archivo) }}
                                    </a>
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-500">
                                    {{ $doc->fecha_carga ? $doc->fecha_carga->format('d/m/Y') : '—' }}
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ asset($doc->ruta_archivo) }}" target="_blank" class="p-2 text-sky-600 bg-sky-50 hover:bg-sky-100 hover:text-sky-700 rounded-lg transition-all" title="Ver documento">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                    </div>
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-center min-w-[180px]">
                                    <input type="text" id="obs-doc-{{ $doc->id }}" class="block w-full px-3 py-2 text-xs border border-gray-200 rounded-lg bg-white/50 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] focus:outline-none" value="{{ $doc->observaciones }}" placeholder="Sin notas...">
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center gap-2">
                                        <button onclick="confirmarAprobarDoc({{ $doc->id }})" class="p-2 text-green-600 bg-green-50 hover:bg-green-100 hover:text-green-700 rounded-lg transition-all cursor-pointer" title="Aprobar documento" aria-label="Aprobar documento">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </button>
                                        <button onclick="confirmarRechazarDoc({{ $doc->id }})" class="p-2 text-red-600 bg-red-50 hover:bg-red-100 hover:text-red-700 rounded-lg transition-all cursor-pointer" title="Rechazar documento" aria-label="Rechazar documento">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $documentosPendientes->appends(request()->query())->links() }}
            </div>
        </div>

        <!-- Documentos Validados -->
        <div class="glass-card rounded-3xl p-6 md:p-8 fade-in-up delay-300">
            <h2 class="text-xl font-extrabold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-[#6BA53A]" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Historial de Documentos Validados
            </h2>
            <div class="overflow-x-auto">
                <table id="documentos-validados-table" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl whitespace-nowrap">Estudiante</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Tipo de Documento</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Nombre de Archivo</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Estado</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl whitespace-nowrap">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-transparent divide-y divide-gray-100">
                        @foreach($documentosValidados as $doc)
                            <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                                <td class="px-3 py-4 whitespace-nowrap text-center">
                                    <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors">
                                        {{ mb_strtoupper($doc->solicitud->estudiante->nombre_completo ?? 'Sin Estudiante') }}
                                    </div>
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-semibold text-gray-600">
                                    {{ mb_strtoupper($doc->nombre_doc) }}
                                </td>
                                <td class="px-3 py-4 text-center min-w-[150px]">
                                    <a href="{{ asset($doc->ruta_archivo) }}" target="_blank" class="text-xs text-sky-700 font-bold hover:underline">
                                        {{ basename($doc->ruta_archivo) }}
                                    </a>
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-center">
                                    @if($doc->estatus === 'aprobado')
                                        <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-bold rounded-lg bg-green-50 text-green-700 border border-green-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5 mt-1.5"></span> Aprobado
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-bold rounded-lg bg-red-50 text-red-700 border border-red-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5 mt-1.5"></span> Rechazado
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ asset($doc->ruta_archivo) }}" target="_blank" class="p-2 text-sky-600 bg-sky-50 hover:bg-sky-100 hover:text-sky-700 rounded-lg transition-all" title="Ver documento">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $documentosValidados->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <!-- Scripts: Tab switcher -->
    <script>
        window.verDetallesSolicitud = function(btn) {
            document.getElementById('view-sol-estudiante').textContent = btn.dataset.estudiante;
            document.getElementById('view-sol-estudiante-sub').textContent = 'Estudiante: ' + btn.dataset.estudiante + ' | Cuenta: ' + btn.dataset.matricula;
            document.getElementById('view-sol-matricula').textContent = btn.dataset.matricula;
            document.getElementById('view-sol-carrera').textContent = btn.dataset.carrera;
            document.getElementById('view-sol-semestre').textContent = btn.dataset.semestre;
            document.getElementById('view-sol-grupo').textContent = btn.dataset.grupo;
            document.getElementById('view-sol-unidad').textContent = btn.dataset.unidad + (btn.dataset.departamento ? ' (' + btn.dataset.departamento + ')' : '');
            document.getElementById('view-sol-responsable').textContent = btn.dataset.responsable;
            document.getElementById('view-sol-inicio').textContent = btn.dataset.inicio;
            document.getElementById('view-sol-fin').textContent = btn.dataset.fin;
            document.getElementById('view-sol-titulo').textContent = btn.dataset.titulo;
            document.getElementById('view-sol-objetivo').textContent = btn.dataset.objetivo;
            document.getElementById('view-sol-justificacion').textContent = btn.dataset.justificacion;
            document.getElementById('view-sol-actividades').textContent = btn.dataset.actividades;
            document.getElementById('view-sol-impacto').textContent = btn.dataset.impacto;

            const estatus = btn.dataset.estatus;
            const badge = document.getElementById('view-sol-estatus-badge');
            badge.textContent = estatus;
            badge.className = 'px-2 py-0.5 inline-flex text-[10px] leading-5 font-bold rounded-lg uppercase border';
            
            if (estatus === 'pendiente') {
                badge.classList.add('bg-yellow-50', 'text-yellow-700', 'border-yellow-200');
            } else if (estatus === 'aprobada' || estatus === 'en_proceso' || estatus === 'finalizada') {
                badge.classList.add('bg-green-50', 'text-green-700', 'border-green-200');
            } else {
                badge.classList.add('bg-red-50', 'text-red-700', 'border-red-200');
            }

            document.getElementById('modal-ver-solicitud').classList.remove('hidden');
        };

        window.confirmarAprobar = function(id) {
            const form = document.getElementById('form-aprobar-solicitud');
            form.action = `/coordinador/solicitudes/${id}/aprobar`;
            document.getElementById('modal-confirmar-aprobar').classList.remove('hidden');
        };

        window.confirmarRechazar = function(id) {
            const form = document.getElementById('form-rechazar-solicitud');
            form.action = `/coordinador/solicitudes/${id}/rechazar`;
            document.getElementById('modal-confirmar-rechazar').classList.remove('hidden');
        };

        window.confirmarAprobarDoc = function(id) {
            const form = document.getElementById('form-aprobar-documento');
            form.action = `/coordinador/documentos/${id}/aprobar`;
            document.getElementById('modal-confirmar-aprobar-doc').classList.remove('hidden');
        };

        window.confirmarRechazarDoc = function(id) {
            const form = document.getElementById('form-rechazar-documento');
            form.action = `/coordinador/documentos/${id}/rechazar`;
            const obsInput = document.getElementById('obs-doc-' + id);
            if (obsInput) {
                document.getElementById('obs-rechazo-doc').value = obsInput.value;
            }
            document.getElementById('modal-confirmar-rechazar-doc').classList.remove('hidden');
        };

        var successAlert = document.getElementById('successAlert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                setTimeout(() => { successAlert.remove(); }, 500);
            }, 5000);
        }

        var warningAlert = document.getElementById('warningAlert');
        if (warningAlert) {
            setTimeout(() => {
                warningAlert.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                setTimeout(() => { warningAlert.remove(); }, 500);
            }, 5000);
        }

        function switchTab(tab) {
            document.getElementById('content-solicitudes').classList.add('hidden');
            document.getElementById('content-solicitudes').classList.remove('block');
            document.getElementById('content-documentos').classList.add('hidden');
            document.getElementById('content-documentos').classList.remove('block');

            document.getElementById('tab-solicitudes').classList.remove('border-[#6BA53A]', 'text-[#4E7D24]', 'font-extrabold');
            document.getElementById('tab-solicitudes').classList.add('border-transparent', 'text-gray-500', 'font-bold');

            document.getElementById('tab-documentos').classList.remove('border-[#6BA53A]', 'text-[#4E7D24]', 'font-extrabold');
            document.getElementById('tab-documentos').classList.add('border-transparent', 'text-gray-500', 'font-bold');

            if (tab === 'solicitudes') {
                document.getElementById('content-solicitudes').classList.remove('hidden');
                document.getElementById('content-solicitudes').classList.add('block');
                document.getElementById('tab-solicitudes').classList.add('border-[#6BA53A]', 'text-[#4E7D24]', 'font-extrabold');
                document.getElementById('tab-solicitudes').classList.remove('border-transparent', 'text-gray-500', 'font-bold');
            } else {
                document.getElementById('content-documentos').classList.remove('hidden');
                document.getElementById('content-documentos').classList.add('block');
                document.getElementById('tab-documentos').classList.add('border-[#6BA53A]', 'text-[#4E7D24]', 'font-extrabold');
                document.getElementById('tab-documentos').classList.remove('border-transparent', 'text-gray-500', 'font-bold');
            }
        }
        
        // Auto-switch based on URL param
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('tab') === 'documentos') {
                switchTab('documentos');
            }
        });
    </script>
@endsection

@push('modals')
    @include('coordinador.tramites.view-modal')
    @include('coordinador.tramites.confirm-modal')

    {{-- Modal: Confirmar Aprobación de Documento --}}
    <div id="modal-confirmar-aprobar-doc" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-950/60 backdrop-blur-md transition-opacity duration-300"
             onclick="document.getElementById('modal-confirmar-aprobar-doc').classList.add('hidden')"></div>
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md mx-auto overflow-hidden transform transition-all duration-300 p-6 space-y-4">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100 text-green-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div class="text-center">
                    <h3 class="text-base font-bold text-gray-900 leading-6">Aprobar Documento</h3>
                    <p class="text-xs text-gray-500 mt-2">¿Estás seguro de que deseas aprobar este documento? El estudiante será notificado del cambio de estatus.</p>
                </div>
                <form id="form-aprobar-documento" hx-boost="false" method="POST" action="" class="flex gap-3 mt-4">
                    @csrf
                    <button type="button"
                            onclick="document.getElementById('modal-confirmar-aprobar-doc').classList.add('hidden')"
                            class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-xl text-xs font-bold transition-all">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="flex-1 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition-all">
                        Aprobar
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal: Confirmar Rechazo de Documento --}}
    <div id="modal-confirmar-rechazar-doc" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-950/60 backdrop-blur-md transition-opacity duration-300"
             onclick="document.getElementById('modal-confirmar-rechazar-doc').classList.add('hidden')"></div>
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md mx-auto overflow-hidden transform transition-all duration-300 p-6 space-y-4">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100 text-red-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="text-center">
                    <h3 class="text-base font-bold text-gray-900 leading-6">Rechazar Documento</h3>
                    <p class="text-xs text-gray-500 mt-2">El documento será marcado como rechazado. Podés dejar una nota con el motivo para orientar al alumno.</p>
                </div>
                <form id="form-rechazar-documento" hx-boost="false" method="POST" action="" class="space-y-4">
                    @csrf
                    <div>
                        <label for="obs-rechazo-doc" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Motivo del Rechazo / Observaciones</label>
                        <textarea id="obs-rechazo-doc" name="observaciones" rows="3" class="block w-full px-3 py-2 text-xs border border-gray-200 rounded-xl bg-gray-50/50 focus:border-red-500 focus:ring-1 focus:ring-red-500 focus:outline-none" placeholder="Escribí los motivos del rechazo aquí..."></textarea>
                    </div>
                    <div class="flex gap-3">
                        <button type="button"
                                onclick="document.getElementById('modal-confirmar-rechazar-doc').classList.add('hidden')"
                                class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-xl text-xs font-bold transition-all">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition-all">
                            Rechazar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush
