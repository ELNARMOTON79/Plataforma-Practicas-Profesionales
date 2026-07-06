<!-- Modal: Ver Detalles de la Solicitud -->
<div id="modal-ver-solicitud" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-950/60 backdrop-blur-md transition-opacity duration-300"
         onclick="document.getElementById('modal-ver-solicitud').classList.add('hidden')"></div>

    <!-- Modal Positioning -->
    <div class="flex min-h-screen items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-4xl mx-auto overflow-hidden transform transition-all duration-300 scale-100 max-h-[90vh] flex flex-col">
            
            <!-- Header (Gradient Green Banner) -->
            <div class="bg-gradient-to-r from-[#4E7D24] to-[#6BA53A] px-8 py-6 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 p-2 rounded-xl">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 id="modal-title" class="text-lg font-bold text-white uppercase tracking-wide leading-tight">Detalles de la Solicitud</h2>
                        <p class="text-green-100 text-xs mt-0.5" id="view-sol-estudiante-sub">Cargando información del estudiante...</p>
                    </div>
                </div>
                <button type="button" 
                        onclick="document.getElementById('modal-ver-solicitud').classList.add('hidden')"
                        class="text-white/70 hover:text-white transition-colors p-1.5 rounded-lg hover:bg-white/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Details Body (Scrollable) -->
            <div class="px-8 py-6 space-y-6 overflow-y-auto scrollbar-thin flex-1 text-gray-800">
                
                <!-- Main Grid: Académico vs Receptor -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-gray-100 pb-5">
                    
                    <!-- Left: Estudiante -->
                    <div class="space-y-4">
                        <h3 class="text-xs font-extrabold text-[#4E7D24] uppercase tracking-wider">Datos del Estudiante</h3>
                        <div class="bg-gray-50/50 border border-gray-200/50 p-4 rounded-2xl space-y-3">
                            <div>
                                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Nombre Completo</span>
                                <div class="text-xs font-bold text-gray-800 uppercase mt-0.5" id="view-sol-estudiante">N/A</div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">No. Cuenta / Matrícula</span>
                                    <div class="text-xs font-bold text-gray-700 mt-0.5" id="view-sol-matricula">N/A</div>
                                </div>
                                <div>
                                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Carrera</span>
                                    <div class="text-xs font-bold text-gray-700 mt-0.5" id="view-sol-carrera">N/A</div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Semestre</span>
                                    <div class="text-xs font-bold text-gray-700 mt-0.5" id="view-sol-semestre">N/A</div>
                                </div>
                                <div>
                                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Grupo</span>
                                    <div class="text-xs font-bold text-gray-700 mt-0.5" id="view-sol-grupo">N/A</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Unidad Receptora & Periodo -->
                    <div class="space-y-4">
                        <h3 class="text-xs font-extrabold text-[#4E7D24] uppercase tracking-wider">Institución y Periodo</h3>
                        <div class="bg-gray-50/50 border border-gray-200/50 p-4 rounded-2xl space-y-3">
                            <div>
                                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Unidad Receptora / Institución</span>
                                <div class="text-xs font-bold text-gray-800 uppercase mt-0.5 leading-snug" id="view-sol-unidad">N/A</div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Supervisor / Responsable</span>
                                    <div class="text-xs font-bold text-gray-700 mt-0.5" id="view-sol-responsable">N/A</div>
                                </div>
                                <div>
                                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Estado de Solicitud</span>
                                    <div class="mt-0.5">
                                        <span id="view-sol-estatus-badge" class="px-2 py-0.5 inline-flex text-[10px] leading-5 font-bold rounded-lg uppercase border">N/A</span>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Fecha Inicio</span>
                                    <div class="text-xs font-bold text-gray-700 mt-0.5" id="view-sol-inicio">N/A</div>
                                </div>
                                <div>
                                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Fecha Fin</span>
                                    <div class="text-xs font-bold text-gray-700 mt-0.5" id="view-sol-fin">N/A</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rich text descriptions of the project -->
                <div class="space-y-4">
                    <h3 class="text-xs font-extrabold text-[#4E7D24] uppercase tracking-wider">Detalles del Proyecto Académico</h3>
                    
                    <div>
                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Título del Proyecto</span>
                        <div class="text-sm font-bold text-gray-800 uppercase mt-1 bg-gray-50 border border-gray-200/50 p-3.5 rounded-2xl" id="view-sol-titulo">N/A</div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50/40 p-4 rounded-2xl border-l-4 border-[#6BA53A]">
                            <h4 class="text-xs font-bold text-[#4E7D24] uppercase tracking-wider mb-1.5">Objetivo</h4>
                            <p class="text-xs leading-relaxed text-gray-600 whitespace-pre-line font-medium" id="view-sol-objetivo">N/A</p>
                        </div>

                        <div class="bg-gray-50/40 p-4 rounded-2xl border-l-4 border-sky-500">
                            <h4 class="text-xs font-bold text-sky-700 uppercase tracking-wider mb-1.5">Justificación</h4>
                            <p class="text-xs leading-relaxed text-gray-600 whitespace-pre-line font-medium" id="view-sol-justificacion">N/A</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50/40 p-4 rounded-2xl border-l-4 border-amber-500">
                            <h4 class="text-xs font-bold text-amber-700 uppercase tracking-wider mb-1.5">Actividades</h4>
                            <p class="text-xs leading-relaxed text-gray-600 whitespace-pre-line font-medium" id="view-sol-actividades">N/A</p>
                        </div>

                        <div class="bg-gray-50/40 p-4 rounded-2xl border-l-4 border-purple-500">
                            <h4 class="text-xs font-bold text-purple-700 uppercase tracking-wider mb-1.5">Impacto Social</h4>
                            <p class="text-xs leading-relaxed text-gray-600 whitespace-pre-line font-medium" id="view-sol-impacto">N/A</p>
                        </div>
                    </div>

                    <!-- Observaciones removed -->
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="flex items-center justify-end border-t border-gray-100 px-8 py-5 bg-gray-50/40">
                <button type="button" 
                        onclick="document.getElementById('modal-ver-solicitud').classList.add('hidden')"
                        class="px-6 py-2.5 rounded-xl bg-gray-900 text-white hover:bg-gray-800 text-sm font-bold shadow-md hover:shadow-lg transition-all cursor-pointer">
                    Cerrar Detalles
                </button>
            </div>
        </div>
    </div>
</div>
