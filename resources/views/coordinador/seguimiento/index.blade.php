@extends('layouts.coordinador', ['active' => 'seguimiento', 'title' => 'Seguimiento - Coordinador'])

@section('content')
    <!-- Header Section -->
    <x-page-header title="Seguimiento Alumno - Proyecto" description="Supervisa las actividades, responsables y expedientes oficiales de los estudiantes inscritos en proyectos." />

    <!-- Style overrides for custom DataTables inside tracking module -->
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

    <!-- Success / Error Alerts -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl flex items-center gap-3 font-semibold text-sm animate-fade-in">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-8" aria-label="Navegación de seguimiento">
            <button onclick="switchTrackingTab('proceso')" id="tab-proceso" class="border-[#6BA53A] text-[#4E7D24] whitespace-nowrap py-4 px-2 border-b-4 font-extrabold text-sm transition-all flex items-center gap-2">
                En Proceso
                <span class="bg-yellow-100 text-yellow-800 py-0.5 px-2.5 rounded-full text-xs ml-1 shadow-sm font-bold">
                    {{ collect($data)->where('estatus', 'EN PROCESO')->count() }}
                </span>
            </button>
            <button onclick="switchTrackingTab('concluido')" id="tab-concluido" class="border-transparent text-gray-500 hover:text-[#4E7D24] hover:border-gray-300 whitespace-nowrap py-4 px-2 border-b-4 font-bold text-sm transition-all flex items-center gap-2">
                Concluidos / Acreditados
                <span class="bg-green-100 text-green-800 py-0.5 px-2.5 rounded-full text-xs ml-1 shadow-sm font-bold">
                    {{ collect($data)->where('estatus', 'ACREDITADO')->count() }}
                </span>
            </button>
        </nav>
    </div>

    <!-- Compact Search Input -->
    <div class="flex justify-end mb-6 fade-in-up delay-100">
        <div class="relative w-full max-w-xs">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-400" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <label for="search-tracking" class="sr-only">Buscar estudiante o proyecto</label>
            <input type="text" id="search-tracking" aria-label="Buscar alumnos" class="block w-full pl-9 pr-4 py-2 border border-gray-200 rounded-xl bg-white/80 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#6BA53A] focus:border-transparent text-xs font-semibold transition-all shadow-sm" placeholder="Buscar alumno, proyecto o matrícula...">
        </div>
    </div>

    <!-- TAB 1: EN PROCESO -->
    <div id="content-proceso" class="block animate-fade-in">
        <div class="glass-card rounded-3xl p-6 md:p-8 fade-in-up delay-200">
            <div class="overflow-x-auto">
                <table id="tabla-proceso" class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th scope="col" class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl">Estudiante / Matrícula</th>
                            <th scope="col" class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Proyecto / Institución</th>
                            <th scope="col" class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Responsable del Proyecto</th>
                            <th scope="col" class="px-4 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Estado</th>
                            <th scope="col" class="px-4 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="bg-transparent divide-y divide-gray-100">
                        @foreach(collect($data)->where('estatus', 'EN PROCESO') as $student)
                            <tr class="hover:bg-[#6BA53A]/5 transition-colors group align-top">
                                <!-- Estudiante -->
                                <td class="px-4 py-4 whitespace-nowrap text-left">
                                    <div class="flex items-center gap-3">
                                        <div class="h-9 w-9 rounded-full bg-yellow-100 text-yellow-750 flex items-center justify-center font-bold text-xs select-none flex-shrink-0">
                                            {{ substr($student['nombre_completo'], 0, 1) }}{{ substr(strrchr($student['nombre_completo'], " "), 1, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors uppercase leading-tight">{{ $student['nombre_completo'] }}</div>
                                            <div class="text-[10px] text-gray-400 font-semibold mt-1">Matrícula: {{ $student['matricula'] }}</div>
                                            <div class="text-[9px] text-gray-400 font-semibold mt-0.5">Inicio: {{ $student['fecha_inicio'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <!-- Proyecto / Institución -->
                                <td class="px-4 py-4 text-left max-w-[220px] whitespace-normal">
                                    <div class="text-xs text-gray-800 font-bold uppercase leading-tight break-words">{{ $student['titulo_proyecto'] }}</div>
                                    <div class="text-[10px] text-gray-400 font-semibold mt-1 uppercase break-words">{{ $student['institucion'] }}</div>
                                </td>
                                <!-- Responsable (Read-only Display) -->
                                <td class="px-4 py-4 text-left max-w-[240px]">
                                    <div class="text-xs font-bold text-gray-800 uppercase leading-snug">{{ $student['responsable'] }}</div>
                                    <div class="text-[10px] text-gray-500 font-semibold mt-0.5 leading-tight">{{ $student['cargo'] }}</div>
                                    <div class="text-[9px] text-[#4E7D24] font-bold mt-1.5 select-all break-all leading-tight">{{ $student['correo_destino'] }}</div>
                                </td>
                                <!-- Estado -->
                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    <span class="px-2.5 py-1 text-[9px] leading-5 font-bold rounded-lg bg-yellow-50 text-yellow-750 border border-yellow-100 uppercase tracking-wider">
                                        {{ $student['estatus'] }}
                                    </span>
                                </td>
                                <!-- Acción -->
                                <td class="px-4 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <a href="{{ route('coordinador.seguimiento.show', $student['id']) }}" class="inline-flex px-3 py-1.5 bg-sky-50 hover:bg-sky-600 text-sky-700 hover:text-white border border-sky-100 rounded-xl text-xs font-bold transition-all shadow-sm">
                                        Seguimiento
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- TAB 2: CONCLUIDOS -->
    <div id="content-concluido" class="hidden animate-fade-in">
        <div class="glass-card rounded-3xl p-6 md:p-8 fade-in-up delay-200">
            <div class="overflow-x-auto">
                <table id="tabla-concluidos" class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th scope="col" class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl">Estudiante / Matrícula</th>
                            <th scope="col" class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Proyecto / Institución</th>
                            <th scope="col" class="px-4 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Responsable del Proyecto</th>
                            <th scope="col" class="px-4 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Estado</th>
                            <th scope="col" class="px-4 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="bg-transparent divide-y divide-gray-100">
                        @foreach(collect($data)->where('estatus', 'ACREDITADO') as $student)
                            <tr class="hover:bg-[#6BA53A]/5 transition-colors group align-top">
                                <!-- Estudiante -->
                                <td class="px-4 py-4 whitespace-nowrap text-left">
                                    <div class="flex items-center gap-3">
                                        <div class="h-9 w-9 rounded-full bg-green-100 text-green-750 flex items-center justify-center font-bold text-xs select-none flex-shrink-0">
                                            {{ substr($student['nombre_completo'], 0, 1) }}{{ substr(strrchr($student['nombre_completo'], " "), 1, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors uppercase leading-tight">{{ $student['nombre_completo'] }}</div>
                                            <div class="text-[10px] text-gray-400 font-semibold mt-1">Matrícula: {{ $student['matricula'] }}</div>
                                            <div class="text-[9px] text-gray-400 font-semibold mt-0.5">Fin: {{ $student['fecha_termino'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <!-- Proyecto / Institución -->
                                <td class="px-4 py-4 text-left max-w-[220px] whitespace-normal">
                                    <div class="text-xs text-gray-800 font-bold uppercase leading-tight break-words">{{ $student['titulo_proyecto'] }}</div>
                                    <div class="text-[10px] text-gray-400 font-semibold mt-1 uppercase break-words">{{ $student['institucion'] }}</div>
                                </td>
                                <!-- Responsable (Read-only Display) -->
                                <td class="px-4 py-4 text-left max-w-[240px]">
                                    <div class="text-xs font-bold text-gray-800 uppercase leading-snug">{{ $student['responsable'] }}</div>
                                    <div class="text-[10px] text-gray-500 font-semibold mt-0.5 leading-tight">{{ $student['cargo'] }}</div>
                                    <div class="text-[9px] text-[#4E7D24] font-bold mt-1.5 select-all break-all leading-tight">{{ $student['correo_destino'] }}</div>
                                </td>
                                <!-- Estado -->
                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    <span class="px-2.5 py-1 text-[9px] leading-5 font-bold rounded-lg bg-green-50 text-green-755 border border-green-100 uppercase tracking-wider">
                                        {{ $student['estatus'] }}
                                    </span>
                                </td>
                                <!-- Acción -->
                                <td class="px-4 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <a href="{{ route('coordinador.seguimiento.show', $student['id']) }}" class="inline-flex px-3 py-1.5 bg-sky-50 hover:bg-sky-600 text-sky-700 hover:text-white border border-sky-100 rounded-xl text-xs font-bold transition-all shadow-sm">
                                        Seguimiento
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts: Tab Switcher + DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
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

            let tableProceso = $('#tabla-proceso').DataTable({
                ...dtConfig,
                columnDefs: [{ orderable: false, targets: [2, 4] }]
            });

            let tableConcluido = $('#tabla-concluidos').DataTable({
                ...dtConfig,
                columnDefs: [{ orderable: false, targets: [2, 4] }]
            });

            // Bind unified search bar
            $('#search-tracking').on('keyup', function() {
                tableProceso.search(this.value).draw();
                tableConcluido.search(this.value).draw();
            });
        });

        // ── Tab Switcher ─────────────────────────────────────────────
        function switchTrackingTab(tab) {
            const contentProceso = document.getElementById('content-proceso');
            const contentConcluido = document.getElementById('content-concluido');
            const tabProceso = document.getElementById('tab-proceso');
            const tabConcluido = document.getElementById('tab-concluido');

            contentProceso.classList.add('hidden');
            contentProceso.classList.remove('block');
            contentConcluido.classList.add('hidden');
            contentConcluido.classList.remove('block');

            tabProceso.classList.remove('border-[#6BA53A]', 'text-[#4E7D24]', 'font-extrabold');
            tabProceso.classList.add('border-transparent', 'text-gray-500', 'font-bold');

            tabConcluido.classList.remove('border-[#6BA53A]', 'text-[#4E7D24]', 'font-extrabold');
            tabConcluido.classList.add('border-transparent', 'text-gray-500', 'font-bold');

            if (tab === 'proceso') {
                contentProceso.classList.remove('hidden');
                contentProceso.classList.add('block');
                tabProceso.classList.add('border-[#6BA53A]', 'text-[#4E7D24]', 'font-extrabold');
                tabProceso.classList.remove('border-transparent', 'text-gray-500', 'font-bold');
            } else {
                contentConcluido.classList.remove('hidden');
                contentConcluido.classList.add('block');
                tabConcluido.classList.add('border-[#6BA53A]', 'text-[#4E7D24]', 'font-extrabold');
                tabConcluido.classList.remove('border-transparent', 'text-gray-500', 'font-bold');
            }
        }
    </script>
@endsection
