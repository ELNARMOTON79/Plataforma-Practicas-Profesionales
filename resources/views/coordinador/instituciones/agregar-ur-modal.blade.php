{{-- ========== MODAL: AGREGAR UNIDAD RECEPTORA A INSTITUCIÓN EXISTENTE ========== --}}
<div id="modal-agregar-ur" class="fixed inset-0 z-[110] hidden overflow-hidden" aria-labelledby="modal-title-ur" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4 md:p-6 text-center">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-950/60 backdrop-blur-md" aria-hidden="true" onclick="cerrarModalAgregarUR()"></div>

        <!-- Modal panel -->
        <form id="form-agregar-ur" action="{{ route('coordinador.instituciones.store-ur') }}" method="POST" class="relative flex flex-col w-full max-w-xl bg-white rounded-3xl shadow-2xl overflow-hidden transition-all transform max-h-[90vh] z-10">
            @csrf
            
            <input type="hidden" name="nombre_empresa" id="add-ur-empresa-hidden" value="{{ old('nombre_empresa') }}">

            <!-- Header (Gradient Green Banner) -->
            <div class="bg-gradient-to-r from-[#4E7D24] to-[#6BA53A] px-8 py-6 flex items-center justify-between flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 p-2 rounded-xl text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <h2 id="modal-title-ur" class="text-lg font-bold text-white leading-tight">Agregar Unidad Receptora</h2>
                        <p class="text-green-100 text-xs">Registra un nuevo departamento o área para la institución</p>
                    </div>
                </div>
                <button type="button" 
                        onclick="cerrarModalAgregarUR()"
                        class="text-white/70 hover:text-white transition-colors p-1.5 rounded-lg hover:bg-white/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Scrollable Content -->
            <div class="px-6 py-6 md:px-8 overflow-y-auto flex-grow custom-scrollbar space-y-5 text-left">
                
                <!-- Empresa Destino Badge Card -->
                <div class="bg-[#6BA53A]/10 border border-[#6BA53A]/20 rounded-2xl p-4 flex items-center gap-3">
                    <div class="bg-[#4E7D24] text-white p-2 rounded-xl shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div class="min-w-0">
                        <span class="block text-[10px] font-bold text-[#4E7D24] uppercase tracking-wider">Institución Seleccionada</span>
                        <span id="add-ur-empresa-display" class="block text-sm font-bold text-gray-900 truncate uppercase">Cargando...</span>
                    </div>
                </div>

                <!-- Nombre de la Unidad Receptora -->
                <div>
                    <label for="add-ur-nombre" class="block text-sm font-medium text-gray-700 mb-1">
                        Nombre del Departamento / UR <span class="text-gray-400 text-xs">(Opcional)</span>
                    </label>
                    <input type="text" id="add-ur-nombre" name="unidad_receptora" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors" placeholder="Ej. Dirección de Obras Públicas / Depto. de TI" value="{{ old('unidad_receptora') }}">
                    <p class="text-[11px] text-gray-500 mt-1">Si se deja vacío, se registrará como área <strong>General</strong>.</p>
                </div>

                <!-- Titular -->
                <div>
                    <label for="add-ur-titular" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Titular <span class="text-red-500">*</span></label>
                    <input type="text" id="add-ur-titular" name="titular" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors" placeholder="Ej. Lic. Martín Corona V." value="{{ old('titular') }}" required>
                </div>

                <!-- Cargo -->
                <div>
                    <label for="add-ur-cargo" class="block text-sm font-medium text-gray-700 mb-1">Cargo del Titular <span class="text-red-500">*</span></label>
                    <input type="text" id="add-ur-cargo" name="cargo" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors" placeholder="Ej. Director General de TI" value="{{ old('cargo') }}" required>
                </div>

                <!-- Municipio (Opcional) -->
                <div>
                    <label for="add-ur-municipio" class="block text-sm font-medium text-gray-700 mb-1">
                        Municipio de la UR <span class="text-gray-400 text-xs">(Opcional)</span>
                    </label>
                    <input type="text" id="add-ur-municipio" name="municipio" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors" placeholder="Ej. Manzanillo, Tecomán, Colima (Si difiere de la matriz)" value="{{ old('municipio') }}">
                    <p class="text-[11px] text-gray-500 mt-1">Si se deja vacío, tomará el municipio principal de la institución.</p>
                </div>

                <!-- Dirección Específica (Opcional) -->
                <div>
                    <label for="add-ur-direccion" class="block text-sm font-medium text-gray-700 mb-1">
                        Dirección Específica <span class="text-gray-400 text-xs">(Opcional)</span>
                    </label>
                    <input type="text" id="add-ur-direccion" name="direccion" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors" placeholder="Ej. Av. Elías Zamora Verduzco #100, Col. Salagua" value="{{ old('direccion') }}">
                </div>

                <!-- Teléfono Directo (Opcional) -->
                <div>
                    <label for="add-ur-telefono" class="block text-sm font-medium text-gray-700 mb-1">Teléfono Directo de la UR <span class="text-gray-400 text-xs">(Opcional)</span></label>
                    <input type="text" id="add-ur-telefono" name="telefono" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors" placeholder="Ej. 314-331-1234 Ext. 102" value="{{ old('telefono') }}">
                </div>
            </div>
            
            <!-- Footer -->
            <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3 bg-gray-50/50 flex-shrink-0">
                <button type="button" onclick="cerrarModalAgregarUR()" class="px-5 py-2.5 border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors text-sm">
                    Cancelar
                </button>
                <button type="submit" class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Agregar UR
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function abrirModalAgregarUR(nombreEmpresa) {
        document.getElementById('add-ur-empresa-hidden').value = nombreEmpresa;
        document.getElementById('add-ur-empresa-display').textContent = nombreEmpresa;
        
        // Reset form inputs
        document.getElementById('add-ur-nombre').value = '';
        document.getElementById('add-ur-titular').value = '';
        document.getElementById('add-ur-cargo').value = '';
        document.getElementById('add-ur-municipio').value = '';
        document.getElementById('add-ur-direccion').value = '';
        document.getElementById('add-ur-telefono').value = '';

        document.getElementById('modal-agregar-ur').classList.remove('hidden');
    }

    function cerrarModalAgregarUR() {
        document.getElementById('modal-agregar-ur').classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const formUR = document.getElementById('form-agregar-ur');
        if (!formUR) return;

        let isSubmittingUR = false;

        formUR.addEventListener('submit', function(e) {
            if (isSubmittingUR) return;

            e.preventDefault();

            if (!formUR.checkValidity()) {
                formUR.reportValidity();
                return;
            }

            const nombreEmpresa = document.getElementById('add-ur-empresa-hidden').value;
            const urNombre = document.getElementById('add-ur-nombre').value.trim() || 'General';
            const titularName = document.getElementById('add-ur-titular').value.trim();

            if (document.activeElement) {
                document.activeElement.blur();
            }

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: '¿Agregar Unidad Receptora?',
                    html: `<p class="text-sm text-gray-600 mb-2">¿Estás seguro de agregar la Unidad Receptora <strong>${urNombre}</strong> a <strong>${nombreEmpresa}</strong>?</p><p class="text-xs text-gray-500 bg-green-50 p-2.5 rounded-xl border border-green-100 mt-2">Titular asignado: <strong>${titularName}</strong>.</p>`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#4E7D24',
                    cancelButtonColor: '#9CA3AF',
                    confirmButtonText: 'Sí, agregar UR',
                    cancelButtonText: 'Revisar datos',
                    focusConfirm: false,
                    focusCancel: false,
                    customClass: {
                        popup: 'rounded-3xl p-6 font-sans shadow-2xl',
                        confirmButton: 'px-5 py-2.5 rounded-xl font-bold text-sm shadow-md hover:bg-[#2E5417]',
                        cancelButton: 'px-5 py-2.5 rounded-xl font-bold text-sm'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        isSubmittingUR = true;
                        formUR.submit();
                    }
                });
            } else {
                if (confirm(`¿Estás seguro de agregar la Unidad Receptora ${urNombre} a ${nombreEmpresa}?`)) {
                    isSubmittingUR = true;
                    formUR.submit();
                }
            }
        });
    });
</script>
