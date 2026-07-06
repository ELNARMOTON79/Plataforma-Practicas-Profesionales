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
                                    <button onclick="verDetallesSolicitud({{ $solicitud->id }})" class="px-4 py-2 bg-[#6BA53A]/10 text-[#4E7D24] hover:bg-[#6BA53A]/20 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 mx-auto" title="Ver detalles de la solicitud">
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
                                    <input type="text" class="block w-full px-3 py-2 text-xs border border-gray-200 rounded-lg bg-white/50 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] focus:outline-none" value="{{ $doc->observaciones }}" placeholder="Sin notas..." readonly>
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center gap-2">
                                        <button class="p-2 text-green-600 bg-green-50 hover:bg-green-100 hover:text-green-700 rounded-lg transition-all opacity-50 cursor-not-allowed" disabled>
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </button>
                                        <button class="p-2 text-red-600 bg-red-50 hover:bg-red-100 hover:text-red-700 rounded-lg transition-all opacity-50 cursor-not-allowed" disabled>
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
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
        </div>
    </div>

    <!-- Scripts: Tab switcher + DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        // Build JS dictionary dynamically from Eloquent items for view modal prefilling
        const solicitudesData = {
            @foreach($solicitudes as $solicitud)
                "{{ $solicitud->id }}": {
                    estudiante: "{{ e($solicitud->estudiante->nombre_completo ?? 'Sin Nombre') }}",
                    matricula: "{{ e($solicitud->estudiante->matricula ?? '—') }}",
                    carrera: "{{ e($solicitud->estudiante->carrera ?? '—') }}",
                    semestre: "{{ e($solicitud->estudiante->semestre ?? '—') }}",
                    grupo: "{{ e($solicitud->estudiante->grupo ?? '—') }}",
                    unidad: "{{ e($solicitud->unidadReceptora->nombre_empresa ?? 'No especificada') }}",
                    departamento: "{{ e($solicitud->unidadReceptora->unidad_receptora ?? 'General') }}",
                    responsable: "{{ e($solicitud->responsable ?? '—') }}",
                    inicio: "{{ $solicitud->fecha_inicio ? $solicitud->fecha_inicio->format('d/m/Y') : '—' }}",
                    fin: "{{ $solicitud->fecha_fin ? $solicitud->fecha_fin->format('d/m/Y') : '—' }}",
                    estatus: "{{ $solicitud->estatus }}",
                    titulo: "{{ e($solicitud->titulo ?? 'Sin título') }}",
                    objetivo: {!! json_encode($solicitud->objetivo ?? '—') !!},
                    justificacion: {!! json_encode($solicitud->justificacion ?? '—') !!},
                    actividades: {!! json_encode($solicitud->actividades ?? '—') !!},
                    impacto: {!! json_encode($solicitud->impacto_social ?? '—') !!},
                    observaciones: {!! json_encode($solicitud->observaciones ?? 'Ninguna') !!}
                },
            @endforeach
        };

        window.verDetallesSolicitud = function(id) {
            const sol = solicitudesData[id];
            if (!sol) return;

            document.getElementById('view-sol-estudiante').textContent = sol.estudiante;
            document.getElementById('view-sol-estudiante-sub').textContent = 'Estudiante: ' + sol.estudiante + ' | Cuenta: ' + sol.matricula;
            document.getElementById('view-sol-matricula').textContent = sol.matricula;
            document.getElementById('view-sol-carrera').textContent = sol.carrera;
            document.getElementById('view-sol-semestre').textContent = sol.semestre;
            document.getElementById('view-sol-grupo').textContent = sol.grupo;
            document.getElementById('view-sol-unidad').textContent = sol.unidad + (sol.departamento ? ' (' + sol.departamento + ')' : '');
            document.getElementById('view-sol-responsable').textContent = sol.responsable;
            document.getElementById('view-sol-inicio').textContent = sol.inicio;
            document.getElementById('view-sol-fin').textContent = sol.fin;
            document.getElementById('view-sol-titulo').textContent = sol.titulo;
            document.getElementById('view-sol-objetivo').textContent = sol.objetivo;
            document.getElementById('view-sol-justificacion').textContent = sol.justificacion;
            document.getElementById('view-sol-actividades').textContent = sol.actividades;
            document.getElementById('view-sol-impacto').textContent = sol.impacto;

            // Setup estatus badge classes
            const badge = document.getElementById('view-sol-estatus-badge');
            badge.textContent = sol.estatus;
            badge.className = 'px-2 py-0.5 inline-flex text-[10px] leading-5 font-bold rounded-lg uppercase border';
            
            if (sol.estatus === 'pendiente') {
                badge.classList.add('bg-yellow-50', 'text-yellow-700', 'border-yellow-200');
            } else if (sol.estatus === 'aprobada' || sol.estatus === 'en_proceso' || sol.estatus === 'finalizada') {
                badge.classList.add('bg-green-50', 'text-green-700', 'border-green-200');
            } else {
                badge.classList.add('bg-red-50', 'text-red-700', 'border-red-200');
            }

            // Show modal
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

        // Auto-dismiss alerts
        const successAlert = document.getElementById('successAlert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                setTimeout(() => { successAlert.remove(); }, 500);
            }, 5000);
        }

        const warningAlert = document.getElementById('warningAlert');
        if (warningAlert) {
            setTimeout(() => {
                warningAlert.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                setTimeout(() => { warningAlert.remove(); }, 500);
            }, 5000);
        }

        // Helper to wait until jQuery and DataTables are loaded in the DOM (crucial for HTMX boosted navigation)
        function runWhenjQueryReady(callback) {
            if (window.jQuery && window.jQuery.fn && window.jQuery.fn.DataTable) {
                callback();
            } else {
                setTimeout(function() {
                    runWhenjQueryReady(callback);
                }, 50);
            }
        }

        // ── DataTables ──────────────────────────────────────────────
        runWhenjQueryReady(function() {
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
    </script>
@endsection

@push('modals')
    @include('coordinador.tramites.view-modal')
    @include('coordinador.tramites.confirm-modal')
@endpush
