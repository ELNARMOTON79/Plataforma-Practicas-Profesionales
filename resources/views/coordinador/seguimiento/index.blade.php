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
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 1 1 -18 0 9 9 0 0 1 18 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- 1. Interactive Metrics Grid Partial -->
    @include('coordinador.seguimiento.partials.metrics-cards')

    <!-- 2. Main Container Glass Card -->
    <div class="glass-card rounded-3xl p-6 md:p-8 fade-in-up delay-200">
        <!-- Integrated Header & Search Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div id="section-icon" class="p-2.5 rounded-2xl bg-yellow-50 text-yellow-600 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1 -18 0 9 9 0 0 1 18 0z"></path></svg>
                </div>
                <div>
                    <h2 id="section-title" class="text-lg font-extrabold text-gray-800 leading-tight">Alumnos En Proceso de Prácticas</h2>
                    <p id="section-subtitle" class="text-xs text-gray-400 font-medium">Supervisión de actividades y responsables asignados</p>
                </div>
            </div>

            <!-- Integrated Search Bar -->
            <div class="relative w-full sm:w-80 md:w-96">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <svg class="h-4 w-4" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <label for="search-tracking" class="sr-only">Buscar estudiante o proyecto</label>
                <input type="text" id="search-tracking" aria-label="Buscar alumnos" class="block w-full pl-10 pr-4 py-2 border border-gray-200/90 rounded-xl bg-white/90 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#6BA53A] focus:border-transparent text-xs font-semibold transition-all shadow-xs" placeholder="Buscar alumno, proyecto o matrícula...">
            </div>
        </div>

        <!-- 3. Tables Partials -->
        @include('coordinador.seguimiento.partials.tabla-proceso')
        @include('coordinador.seguimiento.partials.tabla-concluidos')
        @include('coordinador.seguimiento.partials.tabla-todos')
    </div>

    <script>
        var tableProceso = null;
        var tableConcluido = null;
        var tableTodos = null;

        function initSeguimientoPage() {
            if (!document.getElementById('tabla-proceso')) return;
            if (typeof $ === 'undefined' || !$.fn.DataTable) return;

            // Destruir instancias previas de forma segura
            ['#tabla-proceso', '#tabla-concluidos', '#tabla-todos'].forEach(function(selector) {
                if ($.fn.DataTable.isDataTable(selector)) {
                    try {
                        $(selector).DataTable().destroy();
                    } catch (e) {
                        console.warn('Advertencia al resetear DataTable seguimiento:', e);
                    }
                }
            });

            const dtConfig = {
                destroy: true,
                searching: true,
                lengthChange: false,
                pageLength: 5,
                ordering: true,
                info: false,
                dom: 'rtp',
                language: {
                    zeroRecords: `
                        <div class="py-12 px-4 text-center flex flex-col items-center justify-center">
                            <div class="w-14 h-14 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mb-3">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-700">Sin coincidencias</h3>
                            <p class="text-xs text-gray-400 mt-1">Intenta ajustando el término de búsqueda.</p>
                        </div>
                    `,
                    paginate: {
                        first: "Primero",
                        previous: "Anterior",
                        next: "Siguiente",
                        last: "Último"
                    }
                }
            };

            tableProceso = $('#tabla-proceso').DataTable({
                ...dtConfig,
                columnDefs: [{ orderable: false, targets: [2, 4] }],
                language: {
                    ...dtConfig.language,
                    emptyTable: `
                        <div class="py-12 px-4 text-center flex flex-col items-center justify-center">
                            <div class="w-14 h-14 rounded-full bg-yellow-50 text-yellow-600 flex items-center justify-center mb-3 shadow-inner border border-yellow-100">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 1 1 -18 0 9 9 0 0 1 18 0z"></path></svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-700">Sin alumnos en proceso</h3>
                            <p class="text-xs text-gray-400 mt-1 max-w-xs">No existen estudiantes con prácticas profesionales activas actualmente.</p>
                        </div>
                    `
                }
            });

            tableConcluido = $('#tabla-concluidos').DataTable({
                ...dtConfig,
                columnDefs: [{ orderable: false, targets: [2, 4] }],
                language: {
                    ...dtConfig.language,
                    emptyTable: `
                        <div class="py-12 px-4 text-center flex flex-col items-center justify-center">
                            <div class="w-14 h-14 rounded-full bg-green-50 text-green-600 flex items-center justify-center mb-3 shadow-inner border border-green-100">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 1 1 -18 0 9 9 0 0 1 18 0z"></path></svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-700">Sin alumnos concluidos</h3>
                            <p class="text-xs text-gray-400 mt-1 max-w-xs">No existen estudiantes que hayan acreditado o finalizado sus prácticas aún.</p>
                        </div>
                    `
                }
            });

            tableTodos = $('#tabla-todos').DataTable({
                ...dtConfig,
                columnDefs: [{ orderable: false, targets: [2, 4] }],
                language: {
                    ...dtConfig.language,
                    emptyTable: `
                        <div class="py-12 px-4 text-center flex flex-col items-center justify-center">
                            <div class="w-14 h-14 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mb-3 shadow-inner border border-gray-200/50">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <h3 class="text-sm font-bold text-gray-700">Sin datos disponibles</h3>
                            <p class="text-xs text-gray-400 mt-1 max-w-xs">No se encontraron estudiantes en el sistema.</p>
                        </div>
                    `
                }
            });

            // Read search parameter from URL if provided
            const urlParams = new URLSearchParams(window.location.search);
            const searchParam = urlParams.get('search');
            if (searchParam) {
                $('#search-tracking').val(searchParam);
                tableProceso.search(searchParam).draw();
                tableConcluido.search(searchParam).draw();
                tableTodos.search(searchParam).draw();

                if (tableProceso.rows({ search: 'applied' }).count() === 0 && tableConcluido.rows({ search: 'applied' }).count() > 0) {
                    switchTrackingTab('concluido');
                }
            }

            // Bind unified search bar
            $('#search-tracking').off('keyup input').on('keyup input', function() {
                const val = this.value;
                if (tableProceso) tableProceso.search(val).draw();
                if (tableConcluido) tableConcluido.search(val).draw();
                if (tableTodos) tableTodos.search(val).draw();
            });
        }

        var _initSeguimientoDebounce = null;
        function triggerInitSeguimiento() {
            if (_initSeguimientoDebounce) clearTimeout(_initSeguimientoDebounce);
            _initSeguimientoDebounce = setTimeout(function() {
                initSeguimientoPage();
            }, 60);
        }

        if (!window._seguimientoListenersRegistered) {
            document.addEventListener('DOMContentLoaded', triggerInitSeguimiento);
            document.addEventListener('htmx:afterSettle', triggerInitSeguimiento);
            window._seguimientoListenersRegistered = true;
        }

        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            triggerInitSeguimiento();
        }
        window.switchTrackingTab = switchTrackingTab;

        // ── Tab Switcher estilo Trámites ─────────────────────────────
        function switchTrackingTab(tab) {
            const contentProceso = document.getElementById('content-proceso');
            const contentConcluido = document.getElementById('content-concluido');
            const contentTodos = document.getElementById('content-todos');

            const mProceso = document.getElementById('metric-proceso');
            const mConcluido = document.getElementById('metric-concluido');
            const mTodos = document.getElementById('metric-todos');

            const sectionIcon = document.getElementById('section-icon');
            const sectionTitle = document.getElementById('section-title');
            const sectionSubtitle = document.getElementById('section-subtitle');

            if (!contentProceso || !contentConcluido || !contentTodos) return;

            contentProceso.classList.add('hidden');
            contentConcluido.classList.add('hidden');
            contentTodos.classList.add('hidden');

            const resetMetricCard = (el, titleColor) => {
                if (!el) return;
                el.className = "glass-card rounded-3xl p-5 flex flex-col relative overflow-hidden group text-left border-2 border-transparent transition-all duration-300 cursor-pointer hover:border-gray-300";
                const spanTitle = el.querySelector('span');
                if (spanTitle) {
                    spanTitle.className = "text-xs font-bold uppercase tracking-wider text-gray-500 group-hover:" + titleColor + " transition-colors";
                }
            };

            resetMetricCard(mProceso, "text-[#4E7D24]");
            resetMetricCard(mConcluido, "text-green-700");
            resetMetricCard(mTodos, "text-[#4E7D24]");

            if (tab === 'concluido') {
                contentConcluido.classList.remove('hidden');
                if (mConcluido) {
                    mConcluido.className = "glass-card rounded-3xl p-5 flex flex-col relative overflow-hidden group text-left border-2 border-green-500 bg-white ring-4 ring-green-500/10 shadow-md transition-all duration-300 cursor-pointer";
                    const spanC = mConcluido.querySelector('span');
                    if (spanC) spanC.className = "text-xs font-bold uppercase tracking-wider text-green-700";
                }

                if (sectionIcon) {
                    sectionIcon.className = "p-2.5 rounded-2xl bg-green-50 text-green-600 transition-all";
                    sectionIcon.innerHTML = `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 1 1 -18 0 9 9 0 0 1 18 0z"></path></svg>`;
                }
                if (sectionTitle) sectionTitle.textContent = "Alumnos Concluidos / Acreditados";
                if (sectionSubtitle) sectionSubtitle.textContent = "Historial completo de estudiantes que finalizaron exitosamente su proceso de prácticas";
            } else if (tab === 'todos') {
                contentTodos.classList.remove('hidden');
                if (mTodos) {
                    mTodos.className = "glass-card rounded-3xl p-5 flex flex-col relative overflow-hidden group text-left border-2 border-[#4E7D24] bg-white ring-4 ring-[#4E7D24]/10 shadow-md transition-all duration-300 cursor-pointer";
                    const spanT = mTodos.querySelector('span');
                    if (spanT) spanT.className = "text-xs font-bold uppercase tracking-wider text-[#4E7D24]";
                }

                if (sectionIcon) {
                    sectionIcon.className = "p-2.5 rounded-2xl bg-green-50 text-[#4E7D24] transition-all";
                    sectionIcon.innerHTML = `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>`;
                }
                if (sectionTitle) sectionTitle.textContent = "Todos los Alumnos en Seguimiento";
                if (sectionSubtitle) sectionSubtitle.textContent = "Registro general de estudiantes en prácticas (En Proceso y Acreditados)";
            } else {
                contentProceso.classList.remove('hidden');
                if (mProceso) {
                    mProceso.className = "glass-card rounded-3xl p-5 flex flex-col relative overflow-hidden group text-left border-2 border-[#4E7D24] bg-white ring-4 ring-[#4E7D24]/10 shadow-md transition-all duration-300 cursor-pointer";
                    const spanP = mProceso.querySelector('span');
                    if (spanP) spanP.className = "text-xs font-bold uppercase tracking-wider text-[#4E7D24]";
                }

                if (sectionIcon) {
                    sectionIcon.className = "p-2.5 rounded-2xl bg-yellow-50 text-yellow-600 transition-all";
                    sectionIcon.innerHTML = `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1 -18 0 9 9 0 0 1 18 0z"></path></svg>`;
                }
                if (sectionTitle) sectionTitle.textContent = "Alumnos En Proceso de Prácticas";
                if (sectionSubtitle) sectionSubtitle.textContent = "Supervisión de actividades y responsables asignados";
            }
        }
    </script>
@endsection
