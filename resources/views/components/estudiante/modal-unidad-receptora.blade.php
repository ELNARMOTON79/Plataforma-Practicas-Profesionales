<!-- Modal: Información de la Unidad Receptora -->
<div id="modal-unidad-receptora" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-950/60 backdrop-blur-md transition-opacity duration-300"
         onclick="closeUnidadModal()"></div>

    <!-- Modal Positioning -->
    <div class="flex min-h-screen items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl mx-auto overflow-hidden transform transition-all duration-300 scale-100 max-h-[90vh] flex flex-col border border-gray-100">
            
            <!-- Header (Gradient Green Banner) -->
            <div class="bg-gradient-to-r from-[#4E7D24] to-[#6BA53A] px-8 py-6 flex items-center justify-between shrink-0">
                <div class="flex items-center gap-3.5">
                    <div class="bg-white/20 p-2.5 rounded-2xl backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v11m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 id="modal-ur-nombre" class="text-xl font-extrabold text-white leading-tight break-words">Unidad Receptora</h2>
                        <p class="text-green-100 text-xs font-medium mt-0.5 flex items-center gap-2">
                            <span id="modal-ur-sector-badge" class="inline-block bg-white/20 px-2 py-0.5 rounded-md text-[11px] font-semibold">Sector</span>
                            <span id="modal-ur-tipo-badge" class="inline-block bg-white/20 px-2 py-0.5 rounded-md text-[11px] font-semibold">Tipo Persona</span>
                        </p>
                    </div>
                </div>
                <button type="button" 
                        onclick="closeUnidadModal()"
                        class="text-white/80 hover:text-white transition-colors p-2 rounded-xl hover:bg-white/10 shrink-0 cursor-pointer"
                        title="Cerrar modal">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Body (Scrollable Content) -->
            <div class="p-6 sm:p-8 space-y-6 overflow-y-auto custom-scrollbar flex-1 text-gray-800">
                
                <!-- Ubicación y Dirección -->
                <div class="bg-gray-50/80 p-5 rounded-2xl border border-gray-150/60 transition-all hover:border-gray-200">
                    <div class="flex items-center gap-2.5 mb-3">
                        <div class="p-2 bg-[#4E7D24]/10 rounded-xl text-[#4E7D24]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400">Dirección y Ubicación</h4>
                            <p class="text-sm font-semibold text-gray-800 mt-0.5 leading-relaxed" id="modal-ur-direccion">No especificada</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 pt-3 border-t border-gray-200/60 text-xs">
                        <div>
                            <span class="block font-bold text-gray-400 uppercase text-[10px]">Colonia</span>
                            <span class="font-semibold text-gray-700 mt-0.5 block" id="modal-ur-colonia">—</span>
                        </div>
                        <div>
                            <span class="block font-bold text-gray-400 uppercase text-[10px]">Municipio</span>
                            <span class="font-semibold text-gray-700 mt-0.5 block" id="modal-ur-municipio">—</span>
                        </div>
                        <div>
                            <span class="block font-bold text-gray-400 uppercase text-[10px]">C.P. / Estado</span>
                            <span class="font-semibold text-gray-700 mt-0.5 block" id="modal-ur-cp-estado">—</span>
                        </div>
                    </div>
                </div>

                <!-- Responsable / Titular -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-gray-50/80 p-5 rounded-2xl border border-gray-150/60 flex items-start gap-3.5">
                        <div class="p-2.5 bg-blue-50 rounded-xl text-blue-600 shrink-0 mt-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Titular / Responsable</span>
                            <span class="text-sm font-extrabold text-gray-900 block mt-1 truncate" id="modal-ur-titular">No especificado</span>
                            <span class="text-xs text-gray-500 font-medium block mt-0.5" id="modal-ur-cargo">—</span>
                        </div>
                    </div>

                    <div class="bg-gray-50/80 p-5 rounded-2xl border border-gray-150/60 flex items-start gap-3.5">
                        <div class="p-2.5 bg-amber-50 rounded-xl text-amber-600 shrink-0 mt-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Contacto / Teléfono</span>
                            <span class="text-sm font-extrabold text-gray-900 block mt-1" id="modal-ur-telefono">No especificado</span>
                            <span class="text-xs text-[#4E7D24] font-semibold block mt-0.5 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span> Canal de comunicación oficial
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Estatus del Convenio -->
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50/60 to-transparent rounded-2xl border border-green-100">
                    <div class="flex items-center gap-3">
                        <div class="w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse"></div>
                        <span class="text-xs font-bold text-gray-700 uppercase tracking-wide">Estado de Vinculación Institucional</span>
                    </div>
                    <span class="px-3 py-1 bg-green-100 border border-green-200 text-green-800 font-extrabold text-xs rounded-full uppercase" id="modal-ur-convenio-badge">Convenio Vigente</span>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-between border-t border-gray-100 px-8 py-5 bg-gray-50/60 shrink-0">
                <span class="text-xs text-gray-400 font-medium hidden sm:inline">Prácticas Profesionales UdeC</span>
                <div class="flex items-center gap-3 ml-auto">
                    <button type="button" 
                            onclick="closeUnidadModal()"
                            class="px-6 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 text-sm font-bold shadow-sm transition-all cursor-pointer">
                        Cerrar
                    </button>
                    @if(auth()->user()?->estudiante?->solicitudes()->exists())
                    <button type="button" disabled
                       class="px-6 py-2.5 rounded-xl bg-gray-200 text-gray-500 text-sm font-bold shadow-none cursor-not-allowed inline-flex items-center gap-1.5 select-none" title="Ya cuentas con una solicitud registrada (Límite: 1)">
                        <span>Solicitud Activa</span>
                    </button>
                    @else
                    <a href="{{ route('estudiante.nuevaSolicitud') }}" 
                       id="modal-ur-btn-iniciar"
                       class="px-6 py-2.5 rounded-xl bg-[#4E7D24] text-white hover:bg-[#3b6620] text-sm font-bold shadow-md hover:shadow-lg transition-all inline-flex items-center gap-1.5">
                        <span>Iniciar Solicitud</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openUnidadModal(data) {
        if (!data) return;
        
        // Populate fields
        document.getElementById('modal-ur-nombre').textContent = data.nombre_empresa || data.unidad_receptora || 'Unidad Receptora';
        document.getElementById('modal-ur-sector-badge').textContent = data.sector ? `Sector: ${data.sector}` : 'Sector: General';
        
        const esMoral = (data.tipo_persona && data.tipo_persona.toLowerCase() === 'moral');
        document.getElementById('modal-ur-tipo-badge').textContent = esMoral ? 'Persona Moral' : (data.tipo_persona ? 'Persona Física' : 'Institución');
        
        document.getElementById('modal-ur-direccion').textContent = data.direccion || 'Dirección no especificada en el registro';
        document.getElementById('modal-ur-colonia').textContent = data.colonia || '—';
        document.getElementById('modal-ur-municipio').textContent = data.municipio || '—';
        
        const cp = data.cp ? `C.P. ${data.cp}` : '';
        const estado = data.estado || '';
        const cpEstado = [cp, estado].filter(Boolean).join(' — ');
        document.getElementById('modal-ur-cp-estado').textContent = cpEstado || '—';
        
        document.getElementById('modal-ur-titular').textContent = data.titular || 'No especificado';
        document.getElementById('modal-ur-cargo').textContent = data.cargo || 'Responsable de área';
        document.getElementById('modal-ur-telefono').textContent = data.telefono || 'Sin teléfono registrado';
        
        const convenio = data.convenio || 'Vigente';
        document.getElementById('modal-ur-convenio-badge').textContent = `Convenio ${convenio}`;

        // Configure "Iniciar Solicitud" link with pre-fill parameters
        const btnIniciar = document.getElementById('modal-ur-btn-iniciar');
        if (btnIniciar) {
            if (data.id) {
                btnIniciar.href = `{{ route('estudiante.nuevaSolicitud') }}?ur_id=${data.id}`;
            } else {
                const params = new URLSearchParams({
                    empresa_nombre: data.nombre_empresa || data.unidad_receptora || '',
                    empresa_direccion: data.direccion || '',
                    supervisor_nombre: data.titular || '',
                    supervisor_telefono: data.telefono || '',
                    supervisor_email: (data.user && data.user.correo) ? data.user.correo : (data.correo || '')
                });
                btnIniciar.href = `{{ route('estudiante.nuevaSolicitud') }}?${params.toString()}`;
            }
        }

        // Show modal
        const modal = document.getElementById('modal-unidad-receptora');
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeUnidadModal() {
        const modal = document.getElementById('modal-unidad-receptora');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('modal-unidad-receptora');
            if (modal && !modal.classList.contains('hidden')) {
                closeUnidadModal();
            }
        }
    });
</script>
