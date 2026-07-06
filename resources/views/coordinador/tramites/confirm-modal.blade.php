<!-- Modal: Confirmar Aprobación -->
<div id="modal-confirmar-aprobar" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-950/60 backdrop-blur-md transition-opacity duration-300"
         onclick="document.getElementById('modal-confirmar-aprobar').classList.add('hidden')"></div>

    <!-- Modal Positioning -->
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md mx-auto overflow-hidden transform transition-all duration-300 p-6 space-y-4">
            
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100 text-green-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <div class="text-center">
                <h3 class="text-base font-bold text-gray-900 leading-6">Aprobar Solicitud de Prácticas</h3>
                <p class="text-xs text-gray-500 mt-2">¿Estás seguro de que deseas aprobar esta solicitud? El trámite pasará a estar activo para el estudiante.</p>
            </div>

            <form id="form-aprobar-solicitud" hx-boost="false" method="POST" action="" class="flex gap-3 mt-4">
                @csrf
                <button type="button" 
                        onclick="document.getElementById('modal-confirmar-aprobar').classList.add('hidden')"
                        class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-xl text-xs font-bold transition-all">
                    Cancelar
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition-all">
                    Aprobar
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Confirmar Rechazo -->
<div id="modal-confirmar-rechazar" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-950/60 backdrop-blur-md transition-opacity duration-300"
         onclick="document.getElementById('modal-confirmar-rechazar').classList.add('hidden')"></div>

    <!-- Modal Positioning -->
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md mx-auto overflow-hidden transform transition-all duration-300 p-6 space-y-4">
            
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100 text-red-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>

            <div class="text-center">
                <h3 class="text-base font-bold text-gray-900 leading-6">Rechazar Solicitud de Prácticas</h3>
                <p class="text-xs text-gray-500 mt-2">¿Estás seguro de que deseas rechazar esta solicitud? Podés dejar una nota explicando el motivo para orientar al alumno.</p>
            </div>

            <form id="form-rechazar-solicitud" hx-boost="false" method="POST" action="" class="space-y-4">
                @csrf
                <div>
                    <label for="obs-rechazo" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Motivo del Rechazo / Observaciones</label>
                    <textarea id="obs-rechazo" name="observaciones" rows="3" class="block w-full px-3 py-2 text-xs border border-gray-200 rounded-xl bg-gray-50/50 focus:border-red-500 focus:ring-1 focus:ring-red-500 focus:outline-none" placeholder="Escribí los motivos del rechazo aquí..."></textarea>
                </div>
                
                <div class="flex gap-3">
                    <button type="button" 
                            onclick="document.getElementById('modal-confirmar-rechazar').classList.add('hidden')"
                            class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-xl text-xs font-bold transition-all">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition-all">
                        Rechazar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
