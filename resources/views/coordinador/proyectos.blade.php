@extends('layouts.coordinador', ['active' => 'proyectos', 'title' => 'Proyectos - Coordinador'])

@section('content')
    {{-- ========== SUCCESS / ERROR ALERTS ========== --}}
    @if(session('success'))
        <div id="alert-success" class="flex items-start gap-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl px-5 py-4 mb-6 shadow-sm fade-in-up">
            <svg class="w-5 h-5 mt-0.5 flex-shrink-0 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <p class="text-sm font-semibold">{{ session('success') }}</p>
            <button onclick="document.getElementById('alert-success').remove()" class="ml-auto text-green-400 hover:text-green-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div id="alert-error" class="flex items-start gap-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl px-5 py-4 mb-6 shadow-sm fade-in-up">
            <svg class="w-5 h-5 mt-0.5 flex-shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <div>
                <p class="text-sm font-bold mb-1">Corrige los siguientes errores:</p>
                <ul class="text-xs space-y-0.5 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button onclick="document.getElementById('alert-error').remove()" class="ml-auto text-red-400 hover:text-red-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    <!-- Header Section -->
    <x-page-header title="Listado de Proyectos" description="Catálogo de proyectos disponibles para prácticas">
        <x-slot:actions>
            <button onclick="document.getElementById('modal-registrar-proyecto').classList.remove('hidden')" class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Registrar Proyecto
            </button>
        </x-slot>
    </x-page-header>
    <!-- Table Container (Glassmorphic) -->
    <div class="glass-card rounded-3xl p-6 md:p-8 border-t-4 border-[#6BA53A] fade-in-up delay-100 shadow-sm">
               <!-- Filters & Search -->
        <form method="GET" action="{{ route('coordinador.proyectos') }}" class="flex flex-col lg:flex-row gap-4 items-center justify-between mb-6 w-full">
            <!-- Left side: Show entries -->
            <div class="flex items-center gap-2 text-sm text-gray-600 font-medium w-full lg:w-auto">
                <span>Mostrar</span>
                <select name="per_page" onchange="this.form.submit()" class="pl-3 pr-8 py-2 text-sm border border-gray-200 focus:outline-none focus:ring-[#6BA53A] focus:border-[#6BA53A] font-bold rounded-xl bg-white/50 text-gray-700 shadow-sm transition-all">
                    <option value="5" {{ request('per_page', 5) == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                </select>
                <span>registros</span>
            </div>

            <!-- Right side: Search and Filters -->
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
                <!-- Plan Select -->
                <select name="plan" onchange="this.form.submit()" class="block w-full sm:w-auto pl-3 pr-10 py-2.5 text-sm border border-gray-200 focus:outline-none focus:ring-[#6BA53A] focus:border-[#6BA53A] font-bold rounded-xl bg-white/50 text-gray-700 shadow-sm transition-all">
                    <option value="">Todos los Planes</option>
                    <option value="E906" {{ request('plan') == 'E906' ? 'selected' : '' }}>PLAN E906</option>
                    <option value="E907" {{ request('plan') == 'E907' ? 'selected' : '' }}>PLAN E907</option>
                    <option value="E908" {{ request('plan') == 'E908' ? 'selected' : '' }}>PLAN E908</option>
                </select>

                <!-- Cupo Select -->
                <select name="cupo" onchange="this.form.submit()" class="block w-full sm:w-auto pl-3 pr-10 py-2.5 text-sm border border-gray-200 focus:outline-none focus:ring-[#6BA53A] focus:border-[#6BA53A] font-bold rounded-xl bg-white/50 text-gray-700 shadow-sm transition-all">
                    <option value="">Todos los Cupos</option>
                    <option value="disponible" {{ request('cupo') == 'disponible' ? 'selected' : '' }}>DISPONIBLE</option>
                    <option value="lleno" {{ request('cupo') == 'lleno' ? 'selected' : '' }}>CUPO LLENO</option>
                </select>

                <!-- Acceso / Estatus Select -->
                <select name="acceso" onchange="this.form.submit()" class="block w-full sm:w-auto pl-3 pr-10 py-2.5 text-sm border border-gray-200 focus:outline-none focus:ring-[#6BA53A] focus:border-[#6BA53A] font-bold rounded-xl bg-white/50 text-gray-700 shadow-sm transition-all">
                    <option value="">Todos los Accesos</option>
                    <option value="activo" {{ request('acceso') == 'activo' ? 'selected' : '' }}>ACCESO ACTIVO</option>
                    <option value="inactivo" {{ request('acceso') == 'inactivo' ? 'selected' : '' }}>ACCESO INACTIVO</option>
                </select>

                <!-- Search Input -->
                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl leading-5 bg-white/50 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] sm:text-sm shadow-sm transition-all" placeholder="Buscar por nombre o ID...">
                </div>
                <button type="submit" class="hidden">Buscar</button>
            </div>
        </form>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table id="proyectos-table" class="min-w-full divide-y divide-gray-200/50">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl whitespace-nowrap">Proyecto</th>
                        <th scope="col" class="px-3 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider max-w-[220px] whitespace-normal">Nombre del Proyecto</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider max-w-[180px] whitespace-normal">Plantel / Plan</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Ciclo Escolar</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Alumnos / Cupo</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Activo Internet</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl whitespace-nowrap">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-transparent divide-y divide-gray-100/50">
                    @forelse($proyectos as $proyecto)
                        @php
                            $esLleno = $proyecto->cupos_ocupados >= $proyecto->cupos_totales;
                            $esVacio = $proyecto->cupos_ocupados == 0;
                            $badgeClass = $esLleno 
                                ? 'bg-sky-50 text-sky-700 border-sky-200' 
                                : ($esVacio ? 'bg-gray-50 text-gray-600 border-gray-200' : 'bg-amber-50 text-amber-700 border-amber-200');
                        @endphp
                        <tr class="hover:bg-[#6BA53A]/5 transition-colors group project-row">
                            <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">
                                #{{ $proyecto->id }}
                            </td>
                            <td class="px-3 py-4 text-left max-w-[220px] whitespace-normal">
                                <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors uppercase leading-tight break-words">{{ $proyecto->titulo }}</div>
                                <div class="text-[10px] text-gray-400 uppercase mt-0.5">{{ optional($proyecto->empresa)->nombre_empresa ?? 'Sin Unidad' }}</div>
                            </td>
                            <td class="px-3 py-4 text-center max-w-[180px] whitespace-normal">
                                <div class="text-xs text-gray-600 font-bold leading-tight break-words uppercase">FACULTAD DE INGENIERÍA ELECTROMECÁNICA / {{ $proyecto->plan }}</div>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-xs text-gray-500 font-bold tracking-wide">
                                {{ $proyecto->ciclo_escolar }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center">
                                <span class="px-3 py-1 inline-flex text-[11px] leading-5 font-bold rounded-lg border shadow-sm {{ $badgeClass }}">
                                    {{ $proyecto->cupos_ocupados }} / {{ $proyecto->cupos_totales }}
                                </span>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center">
                                <!-- Toggle switch with HTMX -->
                                <div class="relative inline-block w-10 align-middle select-none transition duration-200 ease-in">
                                    <input type="checkbox" name="toggle" id="toggle{{ $proyecto->id }}" 
                                           hx-patch="/coordinador/proyectos/{{ $proyecto->id }}/toggle-status"
                                           hx-trigger="change"
                                           hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'
                                           aria-label="Activar acceso a internet - Proyecto {{ $proyecto->id }}" 
                                           class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 appearance-none cursor-pointer border-gray-300" 
                                           {{ $proyecto->activo ? 'checked' : '' }}/>
                                    <label for="toggle{{ $proyecto->id }}" class="toggle-label block overflow-hidden h-5 rounded-full bg-gray-300 cursor-pointer"><span class="sr-only">Activo</span></label>
                                </div>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center gap-3">
                                    <button type="button" onclick="abrirEditarProyecto('{{ $proyecto->id }}')" class="text-[#6BA53A] hover:text-[#4E7D24] hover:scale-110 transition-transform animate-hover cursor-pointer" title="Editar proyecto {{ $proyecto->id }}" aria-label="Editar proyecto {{ $proyecto->id }}">
                                        <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    <button type="button" onclick="abrirVerProyecto('{{ $proyecto->id }}')" class="text-[#38bdf8] hover:text-[#0284c7] hover:scale-110 transition-transform animate-hover cursor-pointer" title="Ver detalles del proyecto {{ $proyecto->id }}" aria-label="Ver detalles del proyecto {{ $proyecto->id }}">
                                        <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-sm text-gray-500 font-medium">
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
                        unidad: "{{ optional($proyecto->empresa)->nombre_empresa ?? 'Sin Unidad' }}",
                        unidadId: "{{ $proyecto->unidad_receptora_id }}",
                        tipoProyecto: "{{ $proyecto->tipo_proyecto }}",
                        tipoModalidad: "{{ $proyecto->tipo_modalidad }}",
                        objetivo: @json($proyecto->objetivo),
                        justificacion: @json($proyecto->justificacion),
                        actividades: @json($proyecto->actividades),
                        impactoSocial: @json($proyecto->impacto_social),
                        publicoInternet: "{{ $proyecto->publico_internet }}",
                        plan: "{{ $proyecto->plan }}",
                        ciclo: "{{ $proyecto->ciclo_escolar }}",
                        cupo: "{{ $proyecto->cupos_ocupados }} / {{ $proyecto->cupos_totales }}"
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

                // Handle public internet badge styling
                const badge = document.getElementById('view-publico-badge');
                if (project.publicoInternet === 'SI') {
                    badge.textContent = 'Público';
                    badge.className = 'px-3.5 py-1 text-[11px] font-bold rounded-lg uppercase shadow-sm bg-green-50 text-green-700 border border-green-200';
                } else {
                    badge.textContent = 'Privado';
                    badge.className = 'px-3.5 py-1 text-[11px] font-bold rounded-lg uppercase shadow-sm bg-red-50 text-red-700 border border-red-200';
                }

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
                document.getElementById('edit-titulo').value = project.titulo;
                document.getElementById('edit-tipo-proyecto').value = project.tipoProyecto;
                document.getElementById('edit-tipo-modalidad').value = project.tipoModalidad;
                document.getElementById('edit-objetivo').value = project.objetivo;
                document.getElementById('edit-justificacion').value = project.justificacion;
                document.getElementById('edit-actividades').value = project.actividades;
                document.getElementById('edit-impacto').value = project.impactoSocial;
                document.getElementById('edit-publico').value = project.publicoInternet;

                document.getElementById('modal-editar-proyecto').classList.remove('hidden');
            };
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
