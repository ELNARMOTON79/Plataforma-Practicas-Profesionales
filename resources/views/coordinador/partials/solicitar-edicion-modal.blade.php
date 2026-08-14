<!-- Modal: Solicitar Edición/Baja al Administrador -->
<div id="solicitarEdicionModal" class="fixed inset-0 z-[100] hidden overflow-hidden" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4 md:p-6 text-center">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-500/75 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeSolicitarEdicionModal()"></div>

        <!-- Panel -->
        <div class="relative flex flex-col w-full max-w-lg bg-white rounded-3xl shadow-2xl overflow-hidden text-left transform transition-all z-10">
            <!-- Header -->
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="bg-amber-100 text-amber-600 p-2 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 leading-tight">Solicitar Soporte al Administrador</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Reporta un error en el registro o solicita una baja.</p>
                    </div>
                </div>
                <button type="button" onclick="closeSolicitarEdicionModal()" class="text-gray-400 hover:text-gray-600 transition-colors bg-white rounded-lg p-1 hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Body -->
            <form id="formSolicitarEdicion" onsubmit="submitSolicitarEdicion(event)">
                @csrf
                <div class="px-6 py-6 space-y-5">
                    <div id="edicionAlert" class="hidden mb-4 p-3 rounded-xl text-sm font-semibold"></div>

                    <input type="hidden" id="edicion_tipo_registro" name="tipo_registro">
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">Registro a modificar</label>
                        <input type="text" id="edicion_nombre_registro" name="nombre_registro" readonly class="w-full bg-gray-50 border border-gray-200 text-gray-600 rounded-xl px-4 py-2.5 text-sm font-semibold focus:outline-none cursor-not-allowed">
                    </div>

                    <div>
                        <label for="edicion_mensaje" class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">Motivo de la solicitud <span class="text-red-500">*</span></label>
                        <textarea id="edicion_mensaje" name="mensaje_soporte" rows="4" required class="w-full bg-white border border-gray-200 text-gray-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors" placeholder="Ej: Favor de corregir el apellido a 'López' o 'Solicito dar de baja a este alumno por abandono'." minlength="10"></textarea>
                        <p class="text-[10px] text-gray-400 font-medium mt-1">Explica detalladamente qué debe hacer el administrador con este registro.</p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" onclick="closeSolicitarEdicionModal()" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" id="btnSubmitEdicion" class="px-4 py-2 bg-amber-500 text-white text-sm font-bold rounded-xl hover:bg-amber-600 transition-colors shadow-sm flex items-center gap-2">
                        <span>Enviar Solicitud</span>
                        <svg id="edicionLoader" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openSolicitarEdicionModal(tipo, nombre) {
        document.getElementById('edicion_tipo_registro').value = tipo;
        document.getElementById('edicion_nombre_registro').value = nombre;
        document.getElementById('edicion_mensaje').value = '';
        
        const alert = document.getElementById('edicionAlert');
        alert.classList.add('hidden');
        alert.className = 'hidden mb-4 p-3 rounded-xl text-sm font-semibold';
        
        document.getElementById('solicitarEdicionModal').classList.remove('hidden');
    }

    function closeSolicitarEdicionModal() {
        document.getElementById('solicitarEdicionModal').classList.add('hidden');
    }

    function submitSolicitarEdicion(e) {
        e.preventDefault();
        
        const form = e.target;
        const btn = document.getElementById('btnSubmitEdicion');
        const loader = document.getElementById('edicionLoader');
        const alert = document.getElementById('edicionAlert');
        
        btn.disabled = true;
        btn.classList.add('opacity-75', 'cursor-wait');
        loader.classList.remove('hidden');
        alert.classList.add('hidden');

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        fetch("{{ route('coordinador.solicitar-edicion') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || formData.get('_token')
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(res => {
            if (res.success) {
                alert.textContent = res.message;
                alert.classList.remove('hidden', 'bg-red-50', 'text-red-700', 'border-red-200');
                alert.classList.add('bg-green-50', 'text-green-700', 'border', 'border-green-200');
                
                setTimeout(() => {
                    closeSolicitarEdicionModal();
                    btn.disabled = false;
                    btn.classList.remove('opacity-75', 'cursor-wait');
                    loader.classList.add('hidden');
                }, 2000);
            } else {
                throw new Error(res.message || 'Error desconocido');
            }
        })
        .catch(err => {
            alert.textContent = err.message || 'Error de conexión. Intente nuevamente.';
            alert.classList.remove('hidden', 'bg-green-50', 'text-green-700', 'border-green-200');
            alert.classList.add('bg-red-50', 'text-red-700', 'border', 'border-red-200');
            
            btn.disabled = false;
            btn.classList.remove('opacity-75', 'cursor-wait');
            loader.classList.add('hidden');
        });
    }
</script>
