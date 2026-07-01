@extends('layouts.coordinador', ['active' => 'alumnos', 'title' => 'Alumnos - Coordinador'])

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

    <!-- Header Section -->
    <x-page-header title="Listado de Alumnos" description="Directorio y gestión de estudiantes en prácticas profesionales.">
        <x-slot:actions>
            <button
                id="btn-abrir-bulk-upload"
                onclick="document.getElementById('bulkUploadModal').classList.remove('hidden')"
                class="bg-white text-[#4E7D24] border border-[#4E7D24] hover:bg-[#6BA53A]/5 px-5 py-2.5 rounded-xl text-sm font-bold shadow-sm hover:shadow transition-all flex items-center gap-2 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                Importar Alumnos
            </button>
            <button
                id="btn-abrir-modal-alumno"
                onclick="document.getElementById('modal-registrar-alumno').classList.remove('hidden')"
                class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Registrar Alumno
            </button>
        </x-slot>
    </x-page-header>

    <!-- Main Alumnos Container (Glassmorphic) -->
    <div class="glass-card rounded-3xl p-6 md:p-8 fade-in-up delay-100">
        
        <!-- Filters & Search -->
        <form method="GET" action="{{ route('coordinador.alumnos') }}" class="flex flex-col md:flex-row gap-4 items-center justify-between mb-6 w-full">
            <!-- Left side: Show entries -->
            <div class="flex items-center gap-2 text-sm text-gray-600 font-medium w-full md:w-auto">
                <span>Mostrar</span>
                <select name="per_page" onchange="this.form.submit()" class="pl-3 pr-8 py-1.5 text-sm border border-gray-200 focus:outline-none focus:ring-[#6BA53A] focus:border-[#6BA53A] font-medium rounded-xl bg-white/50 text-gray-700">
                    <option value="5" {{ request('per_page', '5') == '5' ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page', '5') == '100' ? 'selected' : '' }}>100</option>
                </select>
                <span>registros</span>
            </div>

            <!-- Right side: Filters & Search -->
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
                <!-- Carrera Select -->
                <select name="carrera" onchange="this.form.submit()" class="block w-full sm:w-auto pl-3 pr-10 py-2 text-sm border border-gray-200 focus:outline-none focus:ring-[#6BA53A] focus:border-[#6BA53A] font-medium rounded-xl bg-white/50 text-gray-700">
                    <option value="">Todas las Carreras</option>
                    @foreach($carrerasDisponibles as $carr)
                        <option value="{{ $carr }}" {{ request('carrera') == $carr ? 'selected' : '' }}>{{ strtoupper($carr) }}</option>
                    @endforeach
                </select>

                <!-- Estatus Select -->
                <select name="estatus" onchange="this.form.submit()" class="block w-full sm:w-auto pl-3 pr-10 py-2 text-sm border border-gray-200 focus:outline-none focus:ring-[#6BA53A] focus:border-[#6BA53A] font-medium rounded-xl bg-white/50 text-gray-700">
                    <option value="">Todos los Estatus</option>
                    <option value="activo" {{ request('estatus') == 'activo' ? 'selected' : '' }}>ACTIVO</option>
                    <option value="asignado" {{ request('estatus') == 'asignado' ? 'selected' : '' }}>ASIGNADO</option>
                    <option value="pendiente" {{ request('estatus') == 'pendiente' ? 'selected' : '' }}>PENDIENTE</option>
                    <option value="inactivo" {{ request('estatus') == 'inactivo' ? 'selected' : '' }}>INACTIVO</option>
                </select>

                <!-- Search Input -->
                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-white/50 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] sm:text-sm transition-colors restrict-search" placeholder="Buscar..." pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s@.]+$" title="El buscador solo acepta letras, números, espacios, @ y puntos." onkeypress="return (event.ctrlKey || event.metaKey || event.altKey) || /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s@.]$/.test(event.key) || ['Backspace', 'Enter', 'Tab', 'Delete', 'ArrowLeft', 'ArrowRight'].includes(event.key)" oninput="this.value = this.value.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s@.]/g, '')">
                </div>
                <button type="submit" class="hidden">Buscar</button>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl">Estudiante</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Plantel y Carrera</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Sem. Inscripción</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Sexo</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Estatus</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-transparent divide-y divide-gray-100">
                    @forelse($alumnos as $alumno)
                        @php
                            $nombre = $alumno->nombre_completo;
                            $avatarText = 'AL';
                            if ($nombre) {
                                $words = explode(' ', trim($nombre));
                                $avatarText = strtoupper(substr($words[0] ?? '', 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                            }
                            
                            $activo = $alumno->user && $alumno->user->activo;
                            
                            // Avatar background dynamic classes matching the status
                            $avatarBg = 'bg-gray-100 text-gray-600';
                            $estatus = $alumno->estatus;
                            if (!$activo) {
                                $avatarBg = 'bg-gray-100 text-gray-400';
                            } elseif ($estatus == 'ACTIVO') {
                                $avatarBg = 'bg-green-100 text-green-700';
                            } elseif ($estatus == 'ASIGNADO') {
                                $avatarBg = 'bg-blue-100 text-blue-700';
                            } elseif ($estatus == 'PENDIENTE') {
                                $avatarBg = 'bg-yellow-100 text-yellow-700';
                            }
                        @endphp
                        <tr class="transition-colors group {{ !$activo ? 'bg-gray-50/50 opacity-60 text-gray-400' : 'hover:bg-[#6BA53A]/5' }}">
                            <!-- Estudiante -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 md:h-12 md:w-12 rounded-full {{ $avatarBg }} flex items-center justify-center font-bold shadow-sm text-sm">
                                        {{ $avatarText }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold {{ $activo ? 'text-gray-900 group-hover:text-[#4E7D24]' : 'text-gray-400' }} transition-colors leading-tight uppercase">{{ $alumno->nombre_completo }}</div>
                                        <div class="text-xs {{ $activo ? 'text-gray-500' : 'text-gray-400' }}">{{ $alumno->user->correo ?? '' }}</div>
                                        <div class="text-[10px] {{ $activo ? 'text-gray-400' : 'text-gray-300' }} font-semibold tracking-wide">Matrícula: {{ $alumno->matricula }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Plantel y Carrera -->
                            <td class="px-6 py-4 whitespace-normal">
                                <div class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1 leading-none">FACULTAD DE INGENIERÍA ELECTROMECÁNICA</div>
                                <div class="text-sm font-bold text-gray-800 uppercase mb-0.5 leading-tight">{{ $alumno->carrera }}</div>
                                <div class="text-xs text-gray-500 font-semibold">{{ $alumno->semestre }}° Semestre, Grupo "{{ $alumno->grupo }}"</div>
                                @if($alumno->asesor)
                                    <div class="text-[10px] text-[#4E7D24] font-bold mt-1.5 uppercase leading-tight">Asesor: {{ $alumno->asesor }}</div>
                                @endif
                                @if($alumno->coasesor)
                                    <div class="text-[10px] text-gray-500 font-semibold uppercase leading-tight">Coasesor: {{ $alumno->coasesor }}</div>
                                @endif
                            </td>
                            <!-- Sem. Inscripción -->
                            <td class="px-6 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-700">
                                @php
                                    $solicitud = \DB::table('solicitudes')
                                        ->where('estudiante_id', $alumno->id)
                                        ->orderBy('id', 'desc')
                                        ->first();
                                @endphp
                                @if($solicitud && in_array($solicitud->estatus, ['aprobada', 'en_proceso', 'finalizada']))
                                    <span class="bg-gray-100 text-gray-800 px-2.5 py-1 rounded-lg">{{ $alumno->semestre }}</span>
                                @else
                                    <span class="text-gray-400">SIN REGISTRO</span>
                                @endif
                            </td>
                            <!-- Sexo -->
                            <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-gray-600 uppercase">
                                {{ $alumno->sexo }}
                            </td>
                            <!-- Estatus -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if(!$activo)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg bg-gray-100 text-gray-400 border border-gray-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400 mr-1.5 mt-1.5"></span> Inactivo
                                    </span>
                                @elseif($estatus == 'ACTIVO')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg bg-green-50 text-green-700 border border-green-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5 mt-1.5"></span> Activo
                                    </span>
                                @elseif($estatus == 'ASIGNADO')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg bg-blue-50 text-blue-700 border border-blue-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5 mt-1.5"></span> Asignado
                                    </span>
                                @elseif($estatus == 'PENDIENTE')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg bg-yellow-50 text-yellow-700 border border-yellow-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 mr-1.5 mt-1.5"></span> Pendiente
                                    </span>
                                @endif
                            </td>
                            <!-- Acciones -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-2">
                                    @if($solicitud && in_array($solicitud->estatus, ['aprobada', 'en_proceso', 'finalizada']))
                                        <a href="{{ route('coordinador.tramites') }}?search={{ urlencode($alumno->nombre_completo) }}" class="px-3 py-1.5 inline-flex text-xs leading-5 font-bold rounded-lg bg-green-600 hover:bg-green-700 text-white shadow-sm hover:shadow transition-all uppercase">
                                            Ver Registro
                                        </a>
                                    @else
                                        <a href="{{ route('coordinador.tramites') }}?search={{ urlencode($alumno->nombre_completo) }}" class="px-3 py-1.5 inline-flex text-xs leading-5 font-bold rounded-lg bg-sky-600 hover:bg-sky-700 text-white shadow-sm hover:shadow transition-all uppercase">
                                            Registrar
                                        </a>
                                    @endif
                                    <button type="button" onclick="abrirEditarAlumno('{{ $alumno->id }}')" class="p-1.5 text-blue-600 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 rounded-lg transition-all shadow-sm" title="Editar alumno {{ $alumno->nombre_completo }}" aria-label="Editar alumno">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500 font-medium">
                                No se encontraron estudiantes con los criterios de búsqueda seleccionados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $alumnos->appends(request()->query())->links() }}
        </div>
    </div>

    <script>
        // Dictionary with student details for editing modal
        const alumnoDetails = {
            @foreach($alumnos as $alumno)
                "{{ $alumno->id }}": {
                    id: "{{ $alumno->id }}",
                    nombre: "{{ addslashes($alumno->nombre_completo) }}",
                    correo: "{{ addslashes($alumno->user->correo ?? '') }}",
                    matricula: "{{ addslashes($alumno->matricula) }}",
                    carrera: "{{ addslashes($alumno->carrera) }}",
                    semestre: "{{ $alumno->semestre }}",
                    grupo: "{{ addslashes($alumno->grupo) }}",
                    asesor: "{{ addslashes($alumno->asesor ?? '') }}",
                    coasesor: "{{ addslashes($alumno->coasesor ?? '') }}"
                },
            @endforeach
        };

        function abrirEditarAlumno(id) {
            const alumno = alumnoDetails[id];
            if (!alumno) return;

            // Populate form fields
            document.getElementById('edit-alumno-id').value = alumno.id;
            document.getElementById('edit-alumno-nombre').value = alumno.nombre;
            document.getElementById('edit-alumno-correo').value = alumno.correo;
            document.getElementById('edit-alumno-matricula').value = alumno.matricula;
            document.getElementById('edit-alumno-carrera').value = alumno.carrera;
            document.getElementById('edit-alumno-semestre').value = alumno.semestre;
            document.getElementById('edit-alumno-grupo').value = alumno.grupo;
            document.getElementById('edit-alumno-asesor').value = alumno.asesor;
            document.getElementById('edit-alumno-coasesor').value = alumno.coasesor;

            // Update form action route
            const form = document.getElementById('form-editar-alumno');
            form.action = `/coordinador/alumnos/${id}`;

            // Remove any old validation/error styles
            const serverErrors = form.querySelectorAll('.server-error');
            serverErrors.forEach(err => err.remove());
            
            const inputs = form.querySelectorAll('input, select');
            inputs.forEach(input => {
                input.classList.remove('input-invalid', 'input-valid', 'border-red-400', 'bg-red-50');
            });
            
            const errorParagraphs = form.querySelectorAll('p[id^="error-edit-alumno-"]');
            errorParagraphs.forEach(p => p.classList.add('hidden'));

            // Show edit modal
            document.getElementById('modal-editar-alumno').classList.remove('hidden');
        }

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
    @include('coordinador.dashboard.edit-modal')
    @include('coordinador.alumnos.bulk-upload-modal')
@endpush
