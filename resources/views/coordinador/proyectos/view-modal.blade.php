<!-- Modal: Ver Detalles de Proyecto -->
<div id="modal-ver-proyecto" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-950/60 backdrop-blur-md transition-opacity duration-300"
         onclick="document.getElementById('modal-ver-proyecto').classList.add('hidden')"></div>

    <!-- Modal Positioning -->
    <div class="flex min-h-screen items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-3xl mx-auto overflow-hidden transform transition-all duration-300 scale-100 max-h-[90vh] flex flex-col">
            
            <!-- Header (Gradient Green Banner) -->
            <div class="bg-gradient-to-r from-[#4E7D24] to-[#6BA53A] px-8 py-6 relative flex flex-col items-center justify-center text-center flex-shrink-0">
                <button type="button" 
                        onclick="document.getElementById('modal-ver-proyecto').classList.add('hidden')"
                        class="absolute top-4 right-4 text-white/70 hover:text-white transition-colors p-1.5 rounded-lg hover:bg-white/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <div class="flex items-center justify-center mb-1">
                    <h2 id="view-title" class="text-xl font-bold text-white uppercase tracking-wide leading-tight max-w-[500px] break-words">Detalles del Proyecto</h2>
                </div>
                <p class="text-green-100 text-xs">Información completa cargada del catálogo de prácticas</p>
            </div>

            <!-- Details Body (Scrollable) -->
            <div class="px-8 py-6 space-y-6 overflow-y-auto scrollbar-thin flex-1 text-gray-800">
                
                <!-- Main Grid: Basic info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 border-b border-gray-100 pb-5">
                    <!-- Left Column: Title & UR -->
                    <div class="space-y-4">
                        <div>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Unidad Receptora / Institución</span>
                            <div class="flex items-center gap-2.5 mt-1 bg-gray-50 border border-gray-200/60 p-3 rounded-2xl">
                                <span class="p-2 bg-[#6BA53A]/10 rounded-xl text-[#4E7D24]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v11m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </span>
                                <span class="text-xs font-bold text-gray-700 uppercase leading-snug break-words" id="view-unidad">N/A</span>
                            </div>
                        </div>

                        <div>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Título del Proyecto</span>
                            <div class="text-sm font-bold text-gray-800 uppercase mt-1 leading-relaxed" id="view-titulo-label">N/A</div>
                        </div>
                    </div>

                    <!-- Right Column: Meta indicators -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50/50 border border-gray-100 p-3.5 rounded-2xl flex flex-col items-center justify-center text-center">
                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">ID Proyecto</span>
                            <span class="text-base font-extrabold text-[#4E7D24] mt-0.5" id="view-id">N/A</span>
                        </div>
                        <div class="bg-gray-50/50 border border-gray-100 p-3.5 rounded-2xl flex flex-col items-center justify-center text-center">
                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Plan Académico</span>
                            <span class="text-sm font-bold text-gray-700 mt-0.5" id="view-plan">N/A</span>
                        </div>
                        <div class="bg-gray-50/50 border border-gray-100 p-3.5 rounded-2xl flex flex-col items-center justify-center text-center">
                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Tipo de Proyecto</span>
                            <span class="text-xs font-bold text-gray-700 mt-0.5" id="view-tipo-proyecto">N/A</span>
                        </div>
                        <div class="bg-gray-50/50 border border-gray-100 p-3.5 rounded-2xl flex flex-col items-center justify-center text-center">
                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Modalidad</span>
                            <span class="text-xs font-bold text-gray-700 mt-0.5" id="view-tipo-modalidad">N/A</span>
                        </div>
                        <div class="bg-gray-50/50 border border-gray-100 p-3.5 rounded-2xl flex flex-col items-center justify-center text-center">
                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Ciclo Escolar</span>
                            <span class="text-xs font-bold text-gray-700 mt-0.5" id="view-ciclo">N/A</span>
                        </div>
                        <div class="bg-gray-50/50 border border-gray-100 p-3.5 rounded-2xl flex flex-col items-center justify-center text-center">
                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Alumnos / Cupo</span>
                            <span class="text-xs font-extrabold text-blue-600 mt-0.5" id="view-cupo">N/A</span>
                        </div>
                    </div>
                </div>

                <!-- Rich text descriptions -->
                <div class="space-y-5">
                    <!-- Objetivo -->
                    <div class="bg-gray-50/40 p-4 rounded-2xl border-l-4 border-[#6BA53A]">
                        <h4 class="text-xs font-bold text-[#4E7D24] uppercase tracking-wider mb-1.5">Objetivo del Proyecto</h4>
                        <p class="text-xs leading-relaxed text-gray-600 whitespace-pre-line font-medium" id="view-objetivo">N/A</p>
                    </div>

                    <!-- Justificación -->
                    <div class="bg-gray-50/40 p-4 rounded-2xl border-l-4 border-[#38bdf8]">
                        <h4 class="text-xs font-bold text-[#0284c7] uppercase tracking-wider mb-1.5">Justificación</h4>
                        <p class="text-xs leading-relaxed text-gray-600 whitespace-pre-line font-medium" id="view-justificacion">N/A</p>
                    </div>

                    <!-- Actividades -->
                    <div class="bg-gray-50/40 p-4 rounded-2xl border-l-4 border-amber-500">
                        <h4 class="text-xs font-bold text-amber-700 uppercase tracking-wider mb-1.5">Actividades del Alumno</h4>
                        <p class="text-xs leading-relaxed text-gray-600 whitespace-pre-line font-medium" id="view-actividades">N/A</p>
                    </div>

                    <!-- Impacto Social -->
                    <div class="bg-gray-50/40 p-4 rounded-2xl border-l-4 border-purple-500">
                        <h4 class="text-xs font-bold text-purple-700 uppercase tracking-wider mb-1.5">Impacto Social</h4>
                        <p class="text-xs leading-relaxed text-gray-600 whitespace-pre-line font-medium" id="view-impacto">N/A</p>
                    </div>
                </div>


            </div>

            <!-- Footer Buttons -->
            <div class="flex items-center justify-end border-t border-gray-100 px-8 py-5 bg-gray-50/40">
                <button type="button" 
                        onclick="document.getElementById('modal-ver-proyecto').classList.add('hidden')"
                        class="px-6 py-2.5 rounded-xl bg-gray-900 text-white hover:bg-gray-800 text-sm font-bold shadow-md hover:shadow-lg transition-all cursor-pointer">
                    Cerrar Vista
                </button>
            </div>
        </div>
    </div>
</div>
