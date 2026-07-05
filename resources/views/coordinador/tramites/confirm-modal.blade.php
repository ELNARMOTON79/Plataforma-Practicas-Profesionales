<!-- Modal de Confirmación para Estatus de Solicitud -->
<div id="modal-confirmar-estatus" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-950/60 backdrop-blur-md transition-opacity duration-300"
         onclick="cerrarModalConfirmacion()"></div>

    <!-- Modal Positioning -->
    <div class="flex min-h-screen items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg mx-auto overflow-hidden transform transition-all duration-300 scale-100 flex flex-col">
            
            <!-- Header -->
            <div id="confirm-modal-header" class="px-8 py-6 flex items-center justify-between transition-colors duration-300 bg-gradient-to-r from-[#4E7D24] to-[#6BA53A]">
                <div class="flex items-center gap-3">
                    <div id="confirm-modal-icon-bg" class="bg-white/20 p-2.5 rounded-xl">
                        <svg id="confirm-icon-approve" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <svg id="confirm-icon-reject" class="w-6 h-6 text-white hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </div>
                    <div>
                        <h2 id="confirm-modal-title" class="text-lg font-bold text-white uppercase tracking-wide leading-tight">Confirmar Acción</h2>
                        <p id="confirm-modal-subtitle" class="text-white/80 text-xs mt-0.5">Gestión de Solicitud</p>
                    </div>
                </div>
                <button type="button" 
                        onclick="cerrarModalConfirmacion()"
                        class="text-white/70 hover:text-white transition-colors p-1.5 rounded-lg hover:bg-white/10 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <form id="form-confirmar-estatus" method="POST" action="" hx-boost="false">
                @csrf
                @method('PATCH')
                <input type="hidden" name="estatus" id="modal-input-estatus" value="">

                <div class="px-8 py-6 space-y-5 text-gray-800">
                    <div class="bg-gray-50 border border-gray-200/80 rounded-2xl p-4 text-sm leading-relaxed text-gray-700">
                        ¿Estás seguro de que deseas <span id="confirm-action-text" class="font-extrabold uppercase text-[#4E7D24]">APROBAR</span> la solicitud de prácticas profesionales del estudiante <span id="confirm-student-name" class="font-extrabold text-gray-900">ESTUDIANTE</span>?
                    </div>

                    <div>
                        <label for="modal-input-observaciones" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Observaciones / Comentarios para el Estudiante
                        </label>
                        <textarea name="observaciones" id="modal-input-observaciones" rows="3" 
                                  class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 shadow-sm transition-all focus:outline-none placeholder-gray-400" 
                                  placeholder="Escribe aquí observaciones opcionales que verá el alumno..."></textarea>
                        <p class="text-[11px] text-gray-400 mt-1">Este comentario se guardará en la solicitud y será visible en la plataforma.</p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="flex items-center justify-end gap-3 border-t border-gray-100 px-8 py-5 bg-gray-50/40">
                    <button type="button" 
                            onclick="cerrarModalConfirmacion()"
                            class="px-5 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 text-sm font-bold shadow-sm transition-all cursor-pointer">
                        Cancelar
                    </button>
                    <button type="submit" id="confirm-submit-btn"
                            class="px-6 py-2.5 rounded-xl bg-[#4E7D24] hover:bg-[#3d631c] text-white text-sm font-bold shadow-md hover:shadow-lg transition-all cursor-pointer flex items-center gap-2">
                        <span>Confirmar</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
