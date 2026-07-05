@extends('layouts.coordinador', ['active' => 'tramites', 'title' => 'Trámites - Coordinador'])

@section('content')
    <!-- Header Section -->
    <x-page-header title="Trámites y Expedientes" description="Gestiona las solicitudes de inicio de prácticas y la validación de documentos oficiales." />

    {{-- ========== SUCCESS / ERROR ALERTS ========== --}}
    @if(session('success'))
        <div id="successAlert" class="mb-6 mt-4 bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl shadow-sm flex items-center gap-3 transition-all duration-300 animate-fade-in">
            <svg class="w-6 h-6 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-semibold text-sm">{{ session('success') }}</span>
            <button onclick="document.getElementById('successAlert').remove()" class="text-green-500 hover:text-green-800 transition-colors ml-auto cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
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
                <span class="bg-yellow-100 text-yellow-800 py-0.5 px-2.5 rounded-full text-xs ml-1 shadow-sm font-bold">{{ isset($documentosPendientes) ? $documentosPendientes->count() : 5 }}</span>
            </button>
        </nav>
    </div>

    <!-- TAB 1: SOLICITUDES DE PRÁCTICAS -->
    <div id="content-solicitudes" class="block animate-fade-in">

        <!-- Buscador Premium Tab 1 -->
        <div class="glass-card rounded-2xl p-4 mb-6 fade-in-up delay-100">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <label for="search-solicitudes" class="sr-only">Buscar solicitudes</label>
                <input type="text" id="search-solicitudes" aria-label="Buscar solicitudes de prácticas" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-white/50 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-[#6BA53A] focus:ring-2 focus:ring-[#6BA53A]/20 sm:text-sm transition-all" placeholder="Buscar por estudiante, institución o periodo...">
            </div>
        </div>

        <div class="glass-card rounded-3xl p-6 md:p-8 fade-in-up delay-200">
            <h2 class="text-xl font-extrabold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-[#6BA53A]" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Solicitudes de Prácticas Registradas
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
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Observaciones</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl whitespace-nowrap">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-transparent divide-y divide-gray-100">
                        @forelse($solicitudes as $solicitud)
                            @php
                                $statusMap = [
                                    'aprobada' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'label' => 'Aprobada'],
                                    'rechazada' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200', 'label' => 'Rechazada'],
                                    'en_proceso' => ['bg' => 'bg-sky-50', 'text' => 'text-sky-700', 'border' => 'border-sky-200', 'label' => 'En proceso'],
                                    'pendiente' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-800', 'border' => 'border-yellow-200', 'label' => 'Pendiente'],
                                    'finalizada' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'border' => 'border-indigo-200', 'label' => 'Finalizada'],
                                ];
                                $st = $statusMap[$solicitud->estatus] ?? $statusMap['pendiente'];
                                $inicioMes = strtoupper($solicitud->fecha_inicio ? str_replace('.', '', $solicitud->fecha_inicio->translatedFormat('M-Y')) : '');
                                $finMes = strtoupper($solicitud->fecha_fin ? str_replace('.', '', $solicitud->fecha_fin->translatedFormat('M-Y')) : '');
                                $periodo = ($inicioMes && $finMes) ? "{$inicioMes}/{$finMes}" : 'AGO-2026/ENE-2027';
                                $nombreEstudiante = strtoupper($solicitud->estudiante?->nombre_completo ?? 'ESTUDIANTE NO REGISTRADO');
                            @endphp
                            <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                                <td class="px-3 py-4 whitespace-nowrap text-center">
                                    <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors">{{ $nombreEstudiante }}</div>
                                    <span class="mt-1 inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold border {{ $st['bg'] }} {{ $st['text'] }} {{ $st['border'] }}">
                                        {{ strtoupper($st['label']) }}
                                    </span>
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">{{ $solicitud->estudiante?->matricula ?? 'N/A' }}</td>
                                <td class="px-3 py-4 text-center whitespace-normal max-w-[160px]">
                                    <div class="text-xs text-gray-600 font-semibold leading-tight break-words">{{ strtoupper($solicitud->unidadReceptora?->nombre_empresa ?? ($solicitud->responsable ?? 'NO ESPECIFICADA')) }}</div>
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-500">{{ $periodo }}</td>
                                <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-800">20 Hrs</td>
                                <td class="px-3 py-4 whitespace-nowrap text-center min-w-[180px]">
                                    <label for="obs-sol-{{ $solicitud->id }}" class="sr-only">Observaciones para {{ $nombreEstudiante }}</label>
                                    <input type="text" id="obs-sol-{{ $solicitud->id }}" value="{{ $solicitud->observaciones }}" aria-label="Observaciones para {{ $nombreEstudiante }}" class="block w-full px-3 py-2 text-xs border border-gray-200 rounded-lg bg-white/50 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] focus:outline-none" placeholder="Añadir observaciones...">
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center gap-2">
                                        <button type="button" onclick="abrirModalConfirmacion('{{ $solicitud->id }}', '{{ addslashes($nombreEstudiante) }}', 'aprobada')" class="p-2 text-green-600 bg-green-50 hover:bg-green-100 hover:text-green-700 rounded-lg transition-all cursor-pointer" title="Aprobar solicitud de {{ $nombreEstudiante }}" aria-label="Aprobar solicitud de {{ $nombreEstudiante }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </button>
                                        <button type="button" onclick="abrirModalConfirmacion('{{ $solicitud->id }}', '{{ addslashes($nombreEstudiante) }}', 'rechazada')" class="p-2 text-red-600 bg-red-50 hover:bg-red-100 hover:text-red-700 rounded-lg transition-all cursor-pointer" title="Rechazar solicitud de {{ $nombreEstudiante }}" aria-label="Rechazar solicitud de {{ $nombreEstudiante }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500 font-medium">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <span>No hay solicitudes de prácticas registradas en el sistema.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
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
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <label for="search-documentos" class="sr-only">Buscar documentos</label>
                <input type="text" id="search-documentos" aria-label="Buscar documentos pendientes" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-white/50 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-[#6BA53A] focus:ring-2 focus:ring-[#6BA53A]/20 sm:text-sm transition-all" placeholder="Buscar por estudiante, tipo de documento o nombre...">
            </div>
        </div>

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
                        <!-- Doc Row 1 -->
                        <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                            <td class="px-3 py-4 whitespace-nowrap text-center">
                                <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors">DOMINGUEZ MARCOS JAZMIN</div>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-semibold text-gray-600">CARTA DE ACEPTACIÓN</td>
                            <td class="px-3 py-4 text-center min-w-[150px]">
                                <a href="#" class="text-xs text-sky-700 font-bold hover:underline">carta_aceptacion_jazmin.pdf</a>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-500">16/05/2026</td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center gap-2">
                                    <button class="p-2 text-sky-600 bg-sky-50 hover:bg-sky-100 hover:text-sky-700 rounded-lg transition-all" title="Ver documento de carta de aceptación de Dominguez Marcos Jazmin" aria-label="Ver documento de carta de aceptación de Dominguez Marcos Jazmin">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                    <button class="p-2 text-gray-600 bg-gray-50 hover:bg-gray-100 hover:text-gray-700 rounded-lg transition-all" title="Descargar carta de aceptación de Dominguez Marcos Jazmin" aria-label="Descargar carta de aceptación de Dominguez Marcos Jazmin">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    </button>
                                </div>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center min-w-[180px]">
                                <label for="notas-doc-1" class="sr-only">Notas para carta de aceptación de Dominguez Marcos Jazmin</label>
                                <input type="text" id="notas-doc-1" aria-label="Notas para carta de aceptación de Dominguez Marcos Jazmin" class="block w-full px-3 py-2 text-xs border border-gray-200 rounded-lg bg-white/50 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] focus:outline-none" placeholder="Añadir notas...">
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center gap-2">
                                    <button class="p-2 text-green-600 bg-green-50 hover:bg-green-100 hover:text-green-700 rounded-lg transition-all" title="Validar carta de aceptación de Dominguez Marcos Jazmin" aria-label="Validar carta de aceptación de Dominguez Marcos Jazmin">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                    <button class="p-2 text-red-600 bg-red-50 hover:bg-red-100 hover:text-red-700 rounded-lg transition-all" title="Rechazar carta de aceptación de Dominguez Marcos Jazmin" aria-label="Rechazar carta de aceptación de Dominguez Marcos Jazmin">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Doc Row 2 -->
                        <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                            <td class="px-3 py-4 whitespace-nowrap text-center">
                                <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors">ALONSO CÁRDENAS HÉCTOR</div>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-semibold text-gray-600">SEGURO SOCIAL</td>
                            <td class="px-3 py-4 text-center min-w-[150px]">
                                <a href="#" class="text-xs text-sky-700 font-bold hover:underline">seguro_hector.pdf</a>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-500">14/05/2026</td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center gap-2">
                                    <button class="p-2 text-sky-600 bg-sky-50 hover:bg-sky-100 hover:text-sky-700 rounded-lg transition-all" title="Ver seguro social de Alonso Cárdenas Héctor" aria-label="Ver seguro social de Alonso Cárdenas Héctor">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                    <button class="p-2 text-gray-600 bg-gray-50 hover:bg-gray-100 hover:text-gray-700 rounded-lg transition-all" title="Descargar seguro social de Alonso Cárdenas Héctor" aria-label="Descargar seguro social de Alonso Cárdenas Héctor">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    </button>
                                </div>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center min-w-[180px]">
                                <label for="notas-doc-2" class="sr-only">Notas para seguro social de Alonso Cárdenas Héctor</label>
                                <input type="text" id="notas-doc-2" aria-label="Notas para seguro social de Alonso Cárdenas Héctor" class="block w-full px-3 py-2 text-xs border border-gray-200 rounded-lg bg-white/50 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] focus:outline-none" placeholder="Añadir notas...">
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center gap-2">
                                    <button class="p-2 text-green-600 bg-green-50 hover:bg-green-100 hover:text-green-700 rounded-lg transition-all" title="Validar seguro social de Alonso Cárdenas Héctor" aria-label="Validar seguro social de Alonso Cárdenas Héctor">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                    <button class="p-2 text-red-600 bg-red-50 hover:bg-red-100 hover:text-red-700 rounded-lg transition-all" title="Rechazar seguro social de Alonso Cárdenas Héctor" aria-label="Rechazar seguro social de Alonso Cárdenas Héctor">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
                        <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                            <td class="px-3 py-4 whitespace-nowrap text-center">
                                <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors">PEREZ LOPEZ JUAN</div>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-semibold text-gray-600">OFICIO DE ASIGNACIÓN</td>
                            <td class="px-3 py-4 text-center min-w-[150px]">
                                <a href="#" class="text-xs text-sky-700 font-bold hover:underline">oficio_asignacion_juan.pdf</a>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center">
                                <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-bold rounded-lg bg-green-50 text-green-700 border border-green-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5 mt-1.5"></span> Aprobado
                                </span>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center gap-2">
                                    <button class="p-2 text-sky-600 bg-sky-50 hover:bg-sky-100 hover:text-sky-700 rounded-lg transition-all" title="Ver oficio de asignación de Perez Lopez Juan" aria-label="Ver oficio de asignación de Perez Lopez Juan">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                    <button class="p-2 text-gray-600 bg-gray-50 hover:bg-gray-100 hover:text-gray-700 rounded-lg transition-all" title="Descargar oficio de asignación de Perez Lopez Juan" aria-label="Descargar oficio de asignación de Perez Lopez Juan">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                            <td class="px-3 py-4 whitespace-nowrap text-center">
                                <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors">RAMÍREZ MENDOZA SOFÍA</div>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-semibold text-gray-600">CARTA DE ACEPTACIÓN</td>
                            <td class="px-3 py-4 text-center min-w-[150px]">
                                <a href="#" class="text-xs text-sky-700 font-bold hover:underline">carta_aceptacion_sofia.pdf</a>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center">
                                <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-bold rounded-lg bg-red-50 text-red-700 border border-red-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5 mt-1.5"></span> Rechazado
                                </span>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center gap-2">
                                    <button class="p-2 text-sky-600 bg-sky-50 hover:bg-sky-100 hover:text-sky-700 rounded-lg transition-all" title="Ver carta de aceptación de Ramírez Mendoza Sofía" aria-label="Ver carta de aceptación de Ramírez Mendoza Sofía">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                    <button class="p-2 text-gray-600 bg-gray-50 hover:bg-gray-100 hover:text-gray-700 rounded-lg transition-all" title="Descargar carta de aceptación de Ramírez Mendoza Sofía" aria-label="Descargar carta de aceptación de Ramírez Mendoza Sofía">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts: Tab switcher + DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        // ── DataTables ──────────────────────────────────────────────
        $(document).ready(function() {
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
                columnDefs: [{ orderable: false, targets: [5, 6] }]
            });
            $('#search-solicitudes').on('keyup', function() {
                tablaSolicitudes.search(this.value).draw();
            });

            // Documentos Pendientes
            let tablaDocsPendientes = $('#documentos-pendientes-table').DataTable({
                ...dtConfig,
                columnDefs: [{ orderable: false, targets: [4, 5, 6] }]
            });

            // Documentos Validados
            let tablaDocsValidados = $('#documentos-validados-table').DataTable({
                ...dtConfig,
                columnDefs: [{ orderable: false, targets: [3, 4] }]
            });

            // Búsqueda unificada para el tab de documentos
            $('#search-documentos').on('keyup', function() {
                tablaDocsPendientes.search(this.value).draw();
                tablaDocsValidados.search(this.value).draw();
            });
        });

        // ── Tab Switcher ─────────────────────────────────────────────
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

        // ── Modal de Confirmación de Estatus ─────────────────────────
        function abrirModalConfirmacion(id, nombreEstudiante, accion) {
            const modal = document.getElementById('modal-confirmar-estatus');
            const form = document.getElementById('form-confirmar-estatus');
            const inputEstatus = document.getElementById('modal-input-estatus');
            const inputObs = document.getElementById('modal-input-observaciones');
            const header = document.getElementById('confirm-modal-header');
            const actionText = document.getElementById('confirm-action-text');
            const studentName = document.getElementById('confirm-student-name');
            const iconApprove = document.getElementById('confirm-icon-approve');
            const iconReject = document.getElementById('confirm-icon-reject');
            const submitBtn = document.getElementById('confirm-submit-btn');
            const subtitle = document.getElementById('confirm-modal-subtitle');

            form.action = `/coordinador/solicitudes/${id}/estatus`;
            inputEstatus.value = accion;
            studentName.textContent = nombreEstudiante;
            subtitle.textContent = `Gestión de Solicitud #${id}`;

            // Tomar observaciones previas si se escribieron en la fila de la tabla
            const filaObs = document.getElementById('obs-sol-' + id);
            if (filaObs && filaObs.value) {
                inputObs.value = filaObs.value;
            } else {
                inputObs.value = '';
            }

            if (accion === 'aprobada') {
                header.className = 'px-8 py-6 flex items-center justify-between transition-colors duration-300 bg-gradient-to-r from-[#4E7D24] to-[#6BA53A]';
                actionText.textContent = 'APROBAR';
                actionText.className = 'font-extrabold uppercase text-[#4E7D24]';
                iconApprove.classList.remove('hidden');
                iconReject.classList.add('hidden');
                submitBtn.className = 'px-6 py-2.5 rounded-xl bg-[#4E7D24] hover:bg-[#3d631c] text-white text-sm font-bold shadow-md hover:shadow-lg transition-all cursor-pointer flex items-center gap-2';
                submitBtn.innerHTML = '<span>Sí, Aprobar Solicitud</span>';
            } else {
                header.className = 'px-8 py-6 flex items-center justify-between transition-colors duration-300 bg-gradient-to-r from-red-600 to-red-500';
                actionText.textContent = 'RECHAZAR';
                actionText.className = 'font-extrabold uppercase text-red-600';
                iconApprove.classList.add('hidden');
                iconReject.classList.remove('hidden');
                submitBtn.className = 'px-6 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-bold shadow-md hover:shadow-lg transition-all cursor-pointer flex items-center gap-2';
                submitBtn.innerHTML = '<span>Sí, Rechazar Solicitud</span>';
            }

            modal.classList.remove('hidden');
        }

        function cerrarModalConfirmacion() {
            document.getElementById('modal-confirmar-estatus').classList.add('hidden');
        }
    </script>
@endsection

@push('modals')
    @include('coordinador.tramites.confirm-modal')
@endpush
