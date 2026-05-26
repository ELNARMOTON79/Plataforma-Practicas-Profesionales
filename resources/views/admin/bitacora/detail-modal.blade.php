<!-- MODAL DE INSPECCIÓN DE DETALLES DEL LOG -->
<div id="logDetailModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500/75 backdrop-blur-sm" aria-hidden="true" onclick="closeLogModal()"></div>

        <!-- Modal panel -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block w-full max-w-4xl overflow-hidden text-left align-bottom transition-all transform bg-white rounded-3xl shadow-2xl sm:my-8 sm:align-middle glass-card">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <div class="flex items-center gap-3">
                    <span id="modal-badge" class="px-2.5 py-1 text-xs font-extrabold uppercase rounded-lg"></span>
                    <h3 class="text-xl font-bold text-gray-900" id="modal-title">Detalles de Actividad</h3>
                </div>
                <button type="button" class="text-gray-400 hover:text-gray-500 transition-colors" onclick="closeLogModal()">
                    <span class="sr-only">Cerrar</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <!-- Body Content -->
            <div class="px-6 py-6 md:px-8 space-y-6">
                <!-- General Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- User & Meta Info -->
                    <div class="md:col-span-1 space-y-5 border-r border-gray-100 pr-0 md:pr-6">
                        <div>
                            <h5 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Usuario Responsable</h5>
                            <div class="flex items-center">
                                <div id="modal-avatar" class="flex-shrink-0 h-10 w-10 rounded-full flex items-center justify-center font-extrabold text-sm shadow-xs"></div>
                                <div class="ml-3">
                                    <div id="modal-username" class="text-sm font-bold text-gray-900"></div>
                                    <div id="modal-userrole" class="text-xs text-gray-500 font-bold"></div>
                                </div>
                            </div>
                            <div id="modal-useremail" class="text-xs text-gray-400 mt-2 font-medium break-all"></div>
                        </div>

                        <div class="pt-4 border-t border-gray-50">
                            <h5 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Información del Evento</h5>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-xs text-gray-500 font-medium">Módulo:</span>
                                    <span id="modal-module" class="text-xs text-gray-900 font-bold"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-xs text-gray-500 font-medium">Timestamp:</span>
                                    <span id="modal-timestamp" class="text-xs text-gray-900 font-bold font-mono"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-xs text-gray-500 font-medium">Acción:</span>
                                    <span id="modal-action-tag" class="text-xs text-gray-900 font-bold text-right"></span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Description & User Agent -->
                    <div class="md:col-span-2 space-y-5">
                        <div>
                            <h5 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Descripción</h5>
                            <p id="modal-description" class="text-sm font-medium text-gray-700 leading-relaxed bg-[#6BA53A]/5 p-4 rounded-2xl border border-[#6BA53A]/10"></p>
                        </div>

                        <div>
                            <h5 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Cliente / Agente de Usuario</h5>
                            <div class="p-3 bg-gray-50 rounded-xl border border-gray-150 flex gap-2.5 items-start">
                                <svg class="w-4 h-4 text-gray-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span id="modal-useragent" class="text-xs text-gray-600 font-medium leading-normal"></span>
                            </div>
                        </div>

                        <div>
                            <h5 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Carga de Contexto (JSON Payload)</h5>
                            <div class="relative group/code">
                                <pre class="bg-gray-900 rounded-2xl p-4 overflow-x-auto text-xs text-green-400 font-mono shadow-inner max-h-60 max-w-full">
                                    <code id="modal-json"></code>
                                </pre>
                                <button type="button" 
                                        onclick="copyJsonPayload()" 
                                        class="absolute right-3 top-3 bg-white/10 hover:bg-white/20 text-white rounded-lg p-1.5 transition-colors opacity-0 group-hover/code:opacity-100 cursor-pointer"
                                        title="Copiar JSON">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex justify-end gap-3 rounded-b-3xl">
                <button type="button" onclick="closeLogModal()" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors text-sm shadow-xs">
                    Cerrar Detalle
                </button>
            </div>
        </div>
    </div>
</div>
