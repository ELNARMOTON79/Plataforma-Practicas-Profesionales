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
        <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-[#6BA53A]" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a7 7 0 00-7 7v1h12v-1a7 7 0 00-7-7z"></path></svg>
            </div>
            <span class="text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider">Estudiantes Activos</span>
            <div class="flex items-end gap-3 mb-2">
                <span class="text-4xl font-extrabold text-gray-900 leading-none">{{ $estudiantesActivos }}</span>
                <span class="flex items-center text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-md mb-0.5">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    +8%
                </span>
            </div>
            <span class="text-xs text-gray-400 font-medium">Inscritos en el periodo actual</span>
        </div>

        <!-- Metric Card 2: Instituciones -->
        <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
            </div>
            <span class="text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider">Instituciones</span>
            <div class="flex items-end gap-3 mb-2">
                <span class="text-4xl font-extrabold text-gray-900 leading-none">{{ $instituciones }}</span>
            </div>
            <span class="text-xs text-gray-400 font-medium">Unidades receptoras registradas</span>
        </div>

        <!-- Metric Card 3: Solicitudes Pendientes -->
        <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group border-yellow-100 hover:border-yellow-300">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-yellow-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
            </div>
            <span class="text-xs font-bold text-yellow-600 mb-2 uppercase tracking-wider">Trámites Pendientes</span>
            <div class="flex items-end gap-3 mb-2">
                <span class="text-4xl font-extrabold text-yellow-600 leading-none">{{ $tramitesPendientes }}</span>
            </div>
            <span class="text-xs text-yellow-500 font-medium">Documentos pendientes de firma</span>
        </div>

        <!-- Metric Card 4: Proyectos Activos -->
        <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-indigo-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd"></path></svg>
            </div>
            <span class="text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider">Convenios y Proyectos</span>
            <div class="flex items-end gap-3 mb-2">
                <span class="text-4xl font-extrabold text-gray-900 leading-none">{{ $proyectosActivos }}</span>
            </div>
            <span class="text-xs text-gray-400 font-medium">Vigentes y autorizados</span>
        </div>
    </div>

    <!-- Main Grid Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Quick Students (60%) -->
        <div class="lg:col-span-2 flex flex-col gap-8">
            <div class="glass-card rounded-3xl p-8 fade-in-up delay-200 shadow-sm border border-gray-200/50">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-6 h-6 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Gestión Rápida de Estudiantes
                    </h2>
                    <a href="{{ Route::has('coordinador.alumnos') ? route('coordinador.alumnos') : '#' }}" class="text-sm font-bold text-[#6BA53A] hover:text-[#4E7D24] transition-colors">Ver todos</a>
                </div>

                <div class="overflow-hidden bg-white/60 rounded-2xl border border-gray-100 shadow-inner">
                    <table class="min-w-full divide-y divide-gray-200/50">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Estudiante</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Carrera</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Estatus</th>
                                <th scope="col" class="px-6 py-3.5 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="bg-transparent divide-y divide-gray-200/40">
                            @forelse($recentAlumnos as $alumno)
                                @php
                                    $nombre = $alumno->nombre_completo ?? 'Estudiante';
                                    $avatarText = 'AL';
                                    if ($nombre) {
                                        $words = explode(' ', trim($nombre));
                                        $avatarText = strtoupper(substr($words[0] ?? '', 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                                    }
                                @endphp
                                <tr class="hover:bg-[#6BA53A]/5 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-[#4E7D24] font-bold">
                                                {{ $avatarText }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-gray-900 leading-tight">{{ $nombre }}</div>
                                                <div class="text-xs text-gray-500">Cuenta: {{ $alumno->matricula }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-700 font-semibold uppercase">
                                        {{ $alumno->carrera }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2.5 py-1 inline-flex text-[10px] leading-5 font-bold rounded-lg border {{ $alumno->estatus_class }}">
                                            {{ $alumno->estatus }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-medium">
                                        <a href="{{ route('coordinador.alumnos', ['search' => $alumno->matricula]) }}" class="bg-[#6BA53A] hover:bg-[#4E7D24] text-white px-3.5 py-1.5 rounded-lg text-[10px] font-bold shadow-sm transition-all hover:scale-105 inline-block">Ver Registro</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500 font-medium">
                                        No hay estudiantes registrados recientemente.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Bitácora (40%) -->
        <div class="flex flex-col gap-8 h-full">
            <div class="glass-card rounded-3xl p-6 fade-in-up delay-300 flex-1 flex flex-col border border-gray-200/50">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Bitácora de Actividades
                    </h3>
                </div>

                <div class="relative flex-1 overflow-y-auto pr-1 max-h-[420px] space-y-6">
                    <div class="absolute left-4 top-2 bottom-0 w-px bg-gray-200/75"></div>

                    @forelse($recentLogs as $log)
                        @php
                            $dotColor = 'bg-gray-400 ring-gray-50';
                            if ($log->level === 'success') {
                                $dotColor = 'bg-green-500 ring-green-50';
                            } elseif ($log->level === 'info') {
                                $dotColor = 'bg-blue-500 ring-blue-50';
                            } elseif ($log->level === 'warning') {
                                $dotColor = 'bg-amber-500 ring-amber-50';
                            } elseif ($log->level === 'danger') {
                                $dotColor = 'bg-red-500 ring-red-50';
                            }
                        @endphp
                        <div class="relative pl-10">
                            <div class="absolute left-2.5 top-1.5 w-3.5 h-3.5 rounded-full border-2 border-white shadow-sm ring-4 {{ $dotColor }}"></div>
                            <div class="bg-white/60 rounded-xl p-4 border border-gray-100/70 hover:shadow-md transition-all">
                                <div class="flex justify-between items-start mb-1 gap-2">
                                    <h4 class="text-sm font-bold text-gray-900 leading-tight">{{ $log->action }}</h4>
                                    <span class="text-[10px] font-semibold text-gray-400 whitespace-nowrap">{{ $log->timestamp ? $log->timestamp->diffForHumans() : '' }}</span>
                                </div>
                                <p class="text-xs text-gray-600 font-medium">{{ $log->description }}</p>
                                <div class="text-[9px] text-gray-400 mt-1 font-semibold">Módulo: {{ $log->module }} | IP: {{ $log->ip }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-sm text-gray-500 font-medium">
                            No hay actividades registradas en el sistema.
                        </div>
                    @endforelse
                </div>

                <a href="{{ Route::has('admin.bitacora') ? route('admin.bitacora') : '#' }}" class="mt-6 w-full py-2.5 bg-gray-50 hover:bg-gray-100 text-gray-600 font-bold rounded-xl transition-colors text-xs border border-gray-200 text-center block">
                    Ver Bitácora Completa
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