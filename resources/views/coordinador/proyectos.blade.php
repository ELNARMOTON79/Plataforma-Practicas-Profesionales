@extends('layouts.coordinador', ['active' => 'proyectos', 'title' => 'Proyectos - Coordinador'])

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
    <x-page-header title="Listado de Proyectos" description="Catálogo de proyectos registrados para Prácticas ">       <x-slot:actions>
            <button onclick="document.getElementById('modal-registrar-proyecto').classList.remove('hidden')" class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Registrar Proyecto
            </button>
        </x-slot>
    </x-page-header>
    <!-- Table Container (Glassmorphic) -->
    <!-- Table Container (Glassmorphic) -->
    <div class="glass-card rounded-3xl p-6 md:p-8 fade-in-up delay-100">
               <!-- Filters & Search -->
        <form method="GET" action="{{ route('coordinador.proyectos') }}" class="flex flex-col lg:flex-row gap-4 items-center justify-between mb-6 w-full">
            <!-- Left side: Search & Filters -->
            <div class="flex flex-wrap sm:flex-nowrap items-center gap-3 w-full lg:w-auto">
                <!-- 1. Search Input -->
                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" class="h-10 block w-full pl-9 pr-3 text-sm border border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#6BA53A] focus:border-[#6BA53A] font-medium text-gray-700 shadow-sm transition-all restrict-search" placeholder="Buscar..." pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s@.]+$" title="El buscador solo acepta letras, números, espacios, @ y puntos." onkeypress="return (event.ctrlKey || event.metaKey || event.altKey) || /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s@.]$/.test(event.key) || ['Backspace', 'Enter', 'Tab', 'Delete', 'ArrowLeft', 'ArrowRight'].includes(event.key)" oninput="this.value = this.value.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s@.]/g, '')">
                </div>
                <button type="submit" class="hidden">Buscar</button>

                <!-- Plan Select -->
                <select name="plan" onchange="this.form.submit()" class="h-10 block w-full sm:w-auto pl-3 pr-10 text-sm border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#6BA53A] focus:border-[#6BA53A] font-medium rounded-xl bg-white text-gray-700 shadow-sm cursor-pointer transition-all">
                    <option value="">Todos los Planes</option>
                    <option value="E906" {{ request('plan') == 'E906' ? 'selected' : '' }}>PLAN E906</option>
                    <option value="E907" {{ request('plan') == 'E907' ? 'selected' : '' }}>PLAN E907</option>
                    <option value="E908" {{ request('plan') == 'E908' ? 'selected' : '' }}>PLAN E908</option>
                </select>

                <!-- Cupo Select -->
                <select name="cupo" onchange="this.form.submit()" class="h-10 block w-full sm:w-auto pl-3 pr-10 text-sm border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#6BA53A] focus:border-[#6BA53A] font-medium rounded-xl bg-white text-gray-700 shadow-sm cursor-pointer transition-all">
                    <option value="">Todos los Cupos</option>
                    <option value="disponible" {{ request('cupo') == 'disponible' ? 'selected' : '' }}>DISPONIBLE</option>
                    <option value="lleno" {{ request('cupo') == 'lleno' ? 'selected' : '' }}>CUPO LLENO</option>
                </select>

            </div>

            <!-- Right side: Show entries -->
            <div class="flex items-center gap-2 text-sm text-gray-600 font-medium w-full lg:w-auto justify-start lg:justify-end">
                <span>Mostrar</span>
                <select name="per_page" onchange="this.form.submit()" class="h-10 pl-3 pr-8 text-sm border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#6BA53A] focus:border-[#6BA53A] font-medium rounded-xl bg-white text-gray-700 shadow-sm cursor-pointer transition-all">
                    <option value="5" {{ $proyectos->perPage() == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ $proyectos->perPage() == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ $proyectos->perPage() == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ $proyectos->perPage() == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $proyectos->perPage() == 100 ? 'selected' : '' }}>100</option>
                </select>
                <span>registros</span>
            </div>
        </form>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table id="proyectos-table" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl whitespace-nowrap">Proyecto</th>
                        <th scope="col" class="px-3 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider max-w-[220px] whitespace-normal">Nombre del Proyecto</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider max-w-[180px] whitespace-normal">Plantel / Plan</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Ciclo Escolar</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Alumnos / Cupo</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl whitespace-nowrap">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-transparent divide-y divide-gray-100">
                    @forelse($proyectos as $proyecto)
                        @php
                            $esLleno = $proyecto->cupos_ocupados >= $proyecto->cupos_totales;
                            $esVacio = $proyecto->cupos_ocupados == 0;
                            
                            $badgeClass = $esLleno 
                                ? 'bg-sky-50 text-sky-700 border-sky-100' 
                                : ($esVacio ? 'bg-gray-100 text-gray-400 border-gray-200' : 'bg-amber-50 text-amber-700 border-amber-100');
                                
                            $dotClass = $esLleno
                                ? 'bg-sky-500'
                                : ($esVacio ? 'bg-gray-400' : 'bg-amber-500');
                        @endphp
                        <tr class="transition-colors group hover:bg-[#6BA53A]/5 project-row">
                            <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">
                                #{{ $proyecto->id }}
                            </td>
                            <td class="px-3 py-4 text-left max-w-[220px] whitespace-normal">
                                <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors uppercase leading-tight break-words">{{ $proyecto->titulo }}</div>
                                <div class="text-[10px] text-gray-400 uppercase mt-0.5">{{ optional($proyecto->empresa)->nombre_empresa ?? 'Sin Unidad' }}</div>
                                @if($proyecto->estudiante)
                                    <div class="text-[10px] text-[#4E7D24] font-bold uppercase mt-0.5">Alumno: {{ $proyecto->estudiante->nombre_completo }}</div>
                                @endif
                            </td>
                            <td class="px-3 py-4 text-center max-w-[180px] whitespace-normal">
                                <div class="text-xs text-gray-600 font-bold leading-tight break-words uppercase">FACULTAD DE INGENIERÍA ELECTROMECÁNICA / {{ $proyecto->plan }}</div>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-xs text-gray-500 font-bold tracking-wide">
                                {{ $proyecto->ciclo_escolar }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg border {{ $badgeClass }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }} mr-1.5 mt-1.5"></span> {{ $proyecto->cupos_ocupados }} / {{ $proyecto->cupos_totales }}
                                </span>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center items-center gap-2">
                                    <button type="button" onclick="abrirEditarProyecto('{{ $proyecto->id }}')" class="px-4 py-1.5 bg-[#0084d1] hover:bg-[#0070b3] text-white text-xs font-extrabold uppercase tracking-wider rounded-xl shadow-sm hover:shadow transition-all transform hover:-translate-y-0.5 cursor-pointer" title="Editar proyecto {{ $proyecto->id }}" aria-label="Editar proyecto {{ $proyecto->id }}">
                                        EDITAR
                                    </button>
                                    <button type="button" onclick="abrirVerProyecto('{{ $proyecto->id }}')" class="px-4 py-1.5 bg-[#4E7D24] hover:bg-[#2E5417] text-white text-xs font-extrabold uppercase tracking-wider rounded-xl shadow-sm hover:shadow transition-all transform hover:-translate-y-0.5 cursor-pointer" title="Ver detalles del proyecto {{ $proyecto->id }}" aria-label="Ver detalles del proyecto {{ $proyecto->id }}">
                                        VER
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500 font-medium">
                                No se encontraron proyectos con los criterios de búsqueda seleccionados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $proyectos->appends(request()->query())->links() }}
        </div>
    </div>

    <!-- Vanilla Javascript Dynamic Engine -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Build JS mock dictionary dynamically from Eloquent items for view & edit modals prefilling
            const projectDetails = {
                @foreach($proyectos as $proyecto)
                    "{{ $proyecto->id }}": {
                        id: "{{ $proyecto->id }}",
                        titulo: "{{ $proyecto->titulo }}",
                        unidad: "{{ optional($proyecto->empresa)->nombre_empresa ? (strtoupper(optional($proyecto->empresa)->nombre_empresa) . (optional($proyecto->empresa)->unidad_receptora ? ' — ' . optional($proyecto->empresa)->unidad_receptora : '')) : 'Sin Unidad' }}",
                        unidadId: "{{ $proyecto->unidad_receptora_id }}",
                        estudianteId: "{{ $proyecto->estudiante_id ?? '' }}",
                        tipoProyecto: "{{ $proyecto->tipo_proyecto }}",
                        tipoModalidad: "{{ $proyecto->tipo_modalidad }}",
                        objetivo: @json($proyecto->objetivo),
                        justificacion: @json($proyecto->justificacion),
                        actividades: @json($proyecto->actividades),
                        impactoSocial: @json($proyecto->impacto_social),
                        plan: "{{ $proyecto->plan }}",
                        ciclo: "{{ $proyecto->ciclo_escolar }}",
                        cupo: "{{ $proyecto->cupos_ocupados }} / {{ $proyecto->cupos_totales }}",
                        cuposTotales: "{{ $proyecto->cupos_totales }}"
                    },
                @endforeach
            };

            // Global functions for modal opening
            window.abrirVerProyecto = function(id) {
                const project = projectDetails[id];
                if (!project) return;

                document.getElementById('view-id').textContent = '#' + project.id;
                document.getElementById('view-title').textContent = project.titulo;
                document.getElementById('view-titulo-label').textContent = project.titulo;
                document.getElementById('view-unidad').textContent = project.unidad;
                document.getElementById('view-tipo-proyecto').textContent = project.tipoProyecto;
                document.getElementById('view-tipo-modalidad').textContent = project.tipoModalidad;
                document.getElementById('view-plan').textContent = project.plan;
                document.getElementById('view-ciclo').textContent = project.ciclo;
                document.getElementById('view-cupo').textContent = project.cupo;
                document.getElementById('view-objetivo').textContent = project.objetivo;
                document.getElementById('view-justificacion').textContent = project.justificacion;
                document.getElementById('view-actividades').textContent = project.actividades;
                document.getElementById('view-impacto').textContent = project.impactoSocial;

                document.getElementById('modal-ver-proyecto').classList.remove('hidden');
            };

            window.abrirEditarProyecto = function(id) {
                const project = projectDetails[id];
                if (!project) return;

                // Set form action dynamically
                const form = document.getElementById('form-editar-proyecto');
                form.action = `/coordinador/proyectos/${project.id}`;

                // Set edit header text
                document.getElementById('edit-id-display').textContent = '#' + project.id;

                // Pre-fill inputs
                document.getElementById('edit-unidad').value = project.unidadId;
                if (document.getElementById('edit-estudiante')) {
                    document.getElementById('edit-estudiante').value = project.estudianteId || '';
                }
                document.getElementById('edit-titulo').value = project.titulo;
                document.getElementById('edit-tipo-proyecto').value = project.tipoProyecto;
                document.getElementById('edit-tipo-modalidad').value = project.tipoModalidad;
                document.getElementById('edit-cupos-totales').value = project.cuposTotales;
                document.getElementById('edit-objetivo').value = project.objetivo;
                document.getElementById('edit-justificacion').value = project.justificacion;
                document.getElementById('edit-actividades').value = project.actividades;
                document.getElementById('edit-impacto').value = project.impactoSocial;

                document.getElementById('modal-editar-proyecto').classList.remove('hidden');
            };

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
    @include('coordinador.proyectos.register-modal')
    @include('coordinador.proyectos.view-modal')
    @include('coordinador.proyectos.edit-modal')

    {{-- Re-open correct modal on validation errors --}}
    @if($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                @if(old('_method') === 'PUT')
                    const editProjId = "{{ session('edit_proyecto_id') }}";
                    if (editProjId) {
                        const form = document.getElementById('form-editar-proyecto');
                        if (form) form.action = `/coordinador/proyectos/${editProjId}`;
                        
                        const displayId = document.getElementById('edit-id-display');
                        if (displayId) displayId.textContent = '#' + editProjId;
                        
                        const editModal = document.getElementById('modal-editar-proyecto');
                        if (editModal) editModal.classList.remove('hidden');
                    }
                @else
                    const regModal = document.getElementById('modal-registrar-proyecto');
                    if (regModal) regModal.classList.remove('hidden');
                @endif
            });
        </script>
    @endif
@endpush
