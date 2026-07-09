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
    <x-page-header title="Listado de Proyectos" description="Catálogo de proyectos disponibles para prácticas">
        <x-slot:actions>
            <button onclick="document.getElementById('modal-registrar-proyecto').classList.remove('hidden')" class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Registrar Proyecto
            </button>
        </x-slot>
    </x-page-header>

    <!-- Table Container for Approved Applications (Solicitudes Aprobadas) -->
    <div class="glass-card rounded-3xl p-6 md:p-8 mt-8 fade-in-up delay-200">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-bold text-gray-900 uppercase tracking-wide">Prácticas Asignadas (Solicitudes Aprobadas)</h3>
                <p class="text-xs text-gray-500 mt-0.5">Estudiantes asignados a proyectos propuestos que han sido aprobados por el coordinador</p>
            </div>
            <span class="px-3 py-1 text-xs font-bold rounded-lg bg-green-50 text-green-700 border border-green-200 uppercase">
                {{ $solicitudesAprobadas->count() }} Activas
            </span>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table id="solicitudes-aprobadas-table" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl whitespace-nowrap">Estudiante</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">No. Cuenta</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Institución</th>
                        <th scope="col" class="px-3 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider max-w-[220px] whitespace-normal">Proyecto Propuesto</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Periodo</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl whitespace-nowrap">Detalles</th>
                    </tr>
                </thead>
                <tbody class="bg-transparent divide-y divide-gray-100">
                    @forelse($solicitudesAprobadas as $sol)
                        <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                            <td class="px-3 py-4 whitespace-nowrap text-center">
                                <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors">
                                    {{ mb_strtoupper($sol->estudiante->nombre_completo ?? 'Sin Nombre') }}
                                </div>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">
                                {{ $sol->estudiante->matricula ?? '—' }}
                            </td>
                            <td class="px-3 py-4 text-center whitespace-normal max-w-[160px]">
                                <div class="text-xs text-gray-600 font-semibold leading-tight break-words uppercase">
                                    {{ mb_strtoupper($sol->unidadReceptora->nombre_empresa ?? 'No especificada') }}
                                </div>
                            </td>
                            <td class="px-3 py-4 text-left max-w-[220px] whitespace-normal">
                                <div class="text-xs font-bold text-gray-800 uppercase leading-snug break-words">
                                    {{ $sol->titulo ?? 'Sin título' }}
                                </div>
                                <div class="text-[10px] text-gray-400 uppercase mt-0.5">Resp: {{ $sol->responsable ?? '—' }}</div>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-500">
                                {{ $sol->fecha_inicio ? $sol->fecha_inicio->format('d/m/Y') : '—' }} - {{ $sol->fecha_fin ? $sol->fecha_fin->format('d/m/Y') : '—' }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center">
                                <button onclick="verDetallesSolicitud({{ $sol->id }})" class="px-4 py-2 bg-[#6BA53A]/10 text-[#4E7D24] hover:bg-[#6BA53A]/20 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 mx-auto" title="Ver detalles de la solicitud">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Ver Detalles
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500 font-medium">
                                No hay solicitudes de prácticas aprobadas actualmente.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Vanilla Javascript Dynamic Engine -->
    <script>
        // Build JS dictionary dynamically for approved solicitudes
        window.solicitudesData = {
            @foreach($solicitudesAprobadas as $sol)
                "{{ $sol->id }}": {
                    estudiante: @json($sol->estudiante->nombre_completo ?? 'Sin Nombre'),
                    matricula: @json($sol->estudiante->matricula ?? '—'),
                    carrera: @json($sol->estudiante->carrera ?? '—'),
                    semestre: @json($sol->estudiante->semestre ?? '—'),
                    grupo: @json($sol->estudiante->grupo ?? '—'),
                    unidad: @json($sol->unidadReceptora->nombre_empresa ?? 'No especificada'),
                    departamento: @json($sol->unidadReceptora->unidad_receptora ?? 'General'),
                    responsable: @json($sol->responsable ?? '—'),
                    inicio: @json($sol->fecha_inicio ? $sol->fecha_inicio->format('d/m/Y') : '—'),
                    fin: @json($sol->fecha_fin ? $sol->fecha_fin->format('d/m/Y') : '—'),
                    estatus: @json($sol->estatus),
                    titulo: @json($sol->titulo ?? 'Sin título'),
                    objetivo: @json($sol->objetivo ?? '—'),
                    justificacion: @json($sol->justificacion ?? '—'),
                    actividades: @json($sol->actividades ?? '—'),
                    impacto: @json($sol->impacto_social ?? '—')
                },
            @endforeach
        };

        window.verDetallesSolicitud = function(id) {
            const sol = window.solicitudesData[id];
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

            const badge = document.getElementById('view-sol-estatus-badge');
            if (badge) {
                badge.textContent = sol.estatus;
                badge.className = 'px-2 py-0.5 inline-flex text-[10px] leading-5 font-bold rounded-lg uppercase border bg-green-50 text-green-700 border-green-200';
            }

            document.getElementById('modal-ver-solicitud').classList.remove('hidden');
        };

        document.addEventListener('DOMContentLoaded', function() {
            // Build JS mock dictionary dynamically from Eloquent items for view & edit modals prefilling
            const projectDetails = {
                @foreach($proyectos as $proyecto)
                    "{{ $proyecto->id }}": {
                        id: @json($proyecto->id),
                        titulo: @json($proyecto->titulo),
                        unidad: @json(optional($proyecto->empresa)->nombre_empresa ?? 'Sin Unidad'),
                        unidadId: @json($proyecto->unidad_receptora_id),
                        tipoProyecto: @json($proyecto->tipo_proyecto),
                        tipoModalidad: @json($proyecto->tipo_modalidad),
                        objetivo: @json($proyecto->objetivo),
                        justificacion: @json($proyecto->justificacion),
                        actividades: @json($proyecto->actividades),
                        impactoSocial: @json($proyecto->impacto_social),
                        publicoInternet: @json($proyecto->publico_internet),
                        plan: @json($proyecto->plan),
                        ciclo: @json($proyecto->ciclo_escolar),
                        cupo: @json($proyecto->cupos_ocupados . ' / ' . $proyecto->cupos_totales)
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
    @include('coordinador.tramites.view-modal')

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
