@extends('layouts.coordinador', ['active' => 'dashboard', 'title' => 'Inicio - Coordinador'])

@section('content')

    {{-- ========== SUCCESS / ERROR ALERTS ========== --}}
    @if(session('success'))
        <div id="successAlert" class="mb-6 bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl shadow-sm flex items-center gap-3 transition-all duration-300 fade-in-up">
            <svg class="w-6 h-6 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-semibold text-sm">{{ session('success') }}</span>
            <button onclick="document.getElementById('successAlert').remove()" class="text-green-500 hover:text-green-800 transition-colors ml-auto">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div id="errorAlert" class="mb-6 bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-2xl shadow-sm flex flex-col gap-2 transition-all duration-300 fade-in-up">
            <div class="flex items-center gap-3 w-full">
                <svg class="w-6 h-6 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <span class="font-bold text-sm">Por favor corrige los siguientes errores:</span>
                <button onclick="document.getElementById('errorAlert').remove()" class="text-red-500 hover:text-red-800 transition-colors ml-auto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <ul class="list-disc pl-9 text-xs font-semibold space-y-1 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Welcome Header -->
    <x-page-header title="Panel del Coordinador" description="Monitoreo general y gestión de estudiantes en prácticas profesionales.">
        <x-slot:actions>
            <button
                id="btn-abrir-modal-alumno"
                onclick="document.getElementById('modal-registrar-alumno').classList.remove('hidden')"
                class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Registrar Alumno
            </button>
        </x-slot>
    </x-page-header>

    <!-- Metrics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 fade-in-up delay-100">
        <!-- Metric Card 1: Estudiantes Activos -->
        <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group border-green-100 hover:border-[#6BA53A] transition-all">
            <div class="absolute inset-y-0 right-0 pr-5 flex items-center opacity-10 group-hover:opacity-20 transition-opacity pointer-events-none">
                <svg class="w-12 h-12 text-[#6BA53A]" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a7 7 0 00-7 7v1h12v-1a7 7 0 00-7-7z"></path></svg>
            </div>
            <span class="text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider">Estudiantes Activos</span>
            <div class="flex items-end gap-3 mb-2">
                <span class="text-4xl font-extrabold text-[#4E7D24] leading-none">{{ $estudiantesActivos }}</span>
                <span class="flex items-center text-xs font-semibold {{ ($porcentajeActivos ?? 0) > 0 ? 'text-green-600 bg-green-50' : 'text-gray-500 bg-gray-100' }} px-2 py-0.5 rounded-md mb-0.5">
                    @if(($porcentajeActivos ?? 0) > 0)
                        <svg class="w-3 h-3 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                        +{{ $porcentajeActivos }}%
                    @else
                        {{ $porcentajeActivos ?? 0 }}%
                    @endif
                </span>
            </div>
            <span class="text-xs text-gray-400 font-medium">Inscritos en el periodo actual</span>
        </div>

        <!-- Metric Card 2: Instituciones -->
        <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group border-teal-100 hover:border-teal-400 transition-all">
            <div class="absolute inset-y-0 right-0 pr-5 flex items-center opacity-10 group-hover:opacity-20 transition-opacity pointer-events-none">
                <svg class="w-12 h-12 text-teal-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
            </div>
            <span class="text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider">Instituciones</span>
            <div class="flex items-end gap-3 mb-2">
                <span class="text-4xl font-extrabold text-teal-600 leading-none">{{ $instituciones }}</span>
            </div>
            <span class="text-xs text-gray-400 font-medium">Unidades receptoras registradas</span>
        </div>

        <!-- Metric Card 3: Solicitudes Pendientes -->
        <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group border-amber-100 hover:border-amber-400 transition-all">
            <div class="absolute inset-y-0 right-0 pr-5 flex items-center opacity-10 group-hover:opacity-20 transition-opacity pointer-events-none">
                <svg class="w-12 h-12 text-yellow-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
            </div>
            <span class="text-xs font-bold text-yellow-600 mb-2 uppercase tracking-wider">Trámites Pendientes</span>
            <div class="flex items-end gap-3 mb-2">
                <span class="text-4xl font-extrabold text-yellow-600 leading-none">{{ $tramitesPendientes }}</span>
            </div>
            <span class="text-xs text-yellow-500 font-medium">Documentos pendientes</span>
        </div>

        <!-- Metric Card 4: Proyectos Registrados -->
        <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group border-indigo-100 hover:border-indigo-400 transition-all">
            <div class="absolute inset-y-0 right-0 pr-5 flex items-center opacity-10 group-hover:opacity-20 transition-opacity pointer-events-none">
                <svg class="w-12 h-12 text-indigo-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd"></path></svg>
            </div>
            <span class="text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider">Proyectos Registrados</span>
            <div class="flex items-end gap-3 mb-2">
                <span class="text-4xl font-extrabold text-indigo-600 leading-none">{{ $proyectosActivos }}</span>
            </div>
            <span class="text-xs text-gray-400 font-medium">Proyectos de prácticas activos</span>
        </div>
    </div>

    <!-- Main Grid Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Quick Students (60%) -->
        <div class="lg:col-span-2 flex flex-col gap-8">
            <div class="glass-card rounded-3xl p-8 fade-in-up delay-200 shadow-sm border border-gray-200/50">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-6 h-6 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        Trámites y Alumnos Pendientes
                    </h2>
                    <span class="text-xs font-bold text-gray-500 bg-gray-100 px-3 py-1 rounded-full">{{ count($pendientesPorAtender) }} pendientes</span>
                </div>

                <div class="overflow-x-auto bg-white/60 rounded-2xl border border-gray-100 shadow-inner">
                    <table class="min-w-full divide-y divide-gray-200/50">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th scope="col" class="px-4 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Estudiante</th>
                                <th scope="col" class="px-4 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Asunto / Estatus</th>
                                <th scope="col" class="px-4 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Detalles</th>
                                <th scope="col" class="px-4 py-3.5 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="bg-transparent divide-y divide-gray-200/40">
                            @forelse($pendientesPorAtender as $pendiente)
                                @php
                                    $nombre = $pendiente->estudiante->nombre_completo ?? 'Estudiante';
                                    $avatarText = 'AL';
                                    if ($nombre) {
                                        $words = explode(' ', trim($nombre));
                                        $avatarText = strtoupper(substr($words[0] ?? '', 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                                    }
                                @endphp
                                <tr class="hover:bg-[#6BA53A]/5 transition-colors">
                                    <td class="px-4 py-3.5 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-[#4E7D24] font-bold">
                                                {{ $avatarText }}
                                            </div>
                                            <div class="ml-3.5">
                                                <div class="text-sm font-bold text-gray-900 leading-tight">{{ $nombre }}</div>
                                                <div class="text-xs text-gray-500 mt-0.5 font-medium space-y-0.5">
                                                    <div>Cuenta: <strong class="text-gray-700 font-semibold">{{ $pendiente->estudiante?->matricula ?? 'S/N' }}</strong></div>
                                                    @if($pendiente->estudiante?->carrera)
                                                        <div class="text-gray-500 truncate max-w-[180px]" title="{{ $pendiente->estudiante->carrera }}">{{ $pendiente->estudiante->carrera }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5 whitespace-nowrap">
                                        <span class="px-2.5 py-1 inline-flex text-[10px] leading-4 font-bold rounded-lg border {{ $pendiente->badge_class }}">
                                            {{ $pendiente->badge_text }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3.5 text-xs text-gray-600 font-semibold uppercase max-w-[160px] truncate">
                                        {{ $pendiente->detalle }}
                                    </td>
                                    <td class="px-4 py-3.5 whitespace-nowrap text-right text-xs font-medium">
                                        <a href="{{ $pendiente->link }}" class="bg-[#6BA53A] hover:bg-[#4E7D24] text-white px-3.5 py-1.5 rounded-xl text-xs font-bold shadow-sm transition-all hover:scale-105 inline-flex items-center gap-1">
                                            <span>{{ $pendiente->accion_label }}</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-12 text-center text-sm text-gray-500 font-medium">
                                        <div class="flex flex-col items-center justify-center gap-3">
                                            <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <span class="text-gray-600 font-semibold">¡Todo al día! No hay trámites ni registros pendientes.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Últimos Documentos y Reportes (40%) -->
        <div class="flex flex-col gap-8 h-full">
            <div class="glass-card rounded-3xl p-6 fade-in-up delay-300 flex-1 flex flex-col border border-gray-200/50">
                <div class="flex items-start justify-between gap-2 mb-6">
                    <div class="flex items-start gap-2 min-w-0">
                        <svg class="w-5 h-5 text-[#4E7D24] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-base font-bold text-gray-900 leading-snug">
                            Últimos trámites
                        </h3>
                    </div>
                    <span class="text-[10px] font-bold text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full whitespace-nowrap shrink-0">Entregas Alumnos</span>
                </div>

                <div class="relative flex-1 overflow-y-auto pr-1 max-h-[420px] space-y-4">
                    @forelse($ultimosDocumentos as $doc)
                        @php
                            $nombreAlumno = $doc->solicitud->estudiante->nombre_completo ?? 'Estudiante';
                            $matriculaAlumno = $doc->solicitud->estudiante->matricula ?? 'S/N';
                            $empresa = $doc->solicitud->unidadReceptora->nombre_empresa ?? null;
                            $fechaFormateada = $doc->fecha_carga ? \Carbon\Carbon::parse($doc->fecha_carga)->locale('es')->diffForHumans() : 'Reciente';
                        @endphp
                        <div class="bg-white/80 rounded-2xl p-4 border border-gray-100/90 hover:shadow-md transition-all flex flex-col gap-2">
                            <div class="flex items-start justify-between gap-2">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-xl bg-[#6BA53A]/10 text-[#4E7D24] flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-gray-900 leading-tight">{{ $doc->nombre_doc }}</h4>
                                        <p class="text-[11px] text-gray-500 font-medium">{{ $nombreAlumno }} • <span class="text-gray-400">Cuenta: {{ $matriculaAlumno }}</span></p>
                                    </div>
                                </div>
                                <span class="text-[10px] font-semibold text-gray-400 whitespace-nowrap">{{ $fechaFormateada }}</span>
                            </div>

                            @if($empresa)
                                <div class="text-[10px] text-gray-500 font-medium bg-gray-50 px-2.5 py-1 rounded-lg border border-gray-100 flex items-center justify-between">
                                    <span class="truncate">Empresa: <strong class="text-gray-700 font-semibold">{{ $empresa }}</strong></span>
                                    <a href="{{ route('coordinador.tramites') }}" class="text-[#4E7D24] hover:text-[#2E5417] font-bold text-[10px] flex items-center gap-0.5 ml-2 whitespace-nowrap">
                                        Revisar
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-10 text-sm text-gray-500 font-medium">
                            <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            No hay entregas de documentos registradas recientemente.
                        </div>
                    @endforelse
                </div>

                <a href="{{ route('coordinador.tramites') }}" class="mt-6 w-full py-2.5 bg-gray-50 hover:bg-[#6BA53A]/10 text-gray-700 hover:text-[#4E7D24] font-bold rounded-xl transition-colors text-xs border border-gray-200 text-center block">
                    Ver Todos los Trámites y Documentos
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-ocultar alerta de éxito a los 5 segundos
            const successAlert = document.getElementById('successAlert');
            if (successAlert) {
                setTimeout(function() {
                    successAlert.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                    setTimeout(function() {
                        successAlert.remove();
                    }, 500);
                }, 5000);
            }

            // Auto-ocultar alerta de error a los 5 segundos
            const errorAlert = document.getElementById('errorAlert');
            if (errorAlert) {
                setTimeout(function() {
                    errorAlert.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                    setTimeout(function() {
                        errorAlert.remove();
                    }, 500);
                }, 5000);
            }
        });
    </script>
@endsection

@push('modals')
    @include('coordinador.dashboard.register-modal')
@endpush