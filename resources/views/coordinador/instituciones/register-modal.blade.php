{{-- ========== MODAL: REGISTRAR INSTITUCIÓN ========== --}}
<div id="modal-registrar-institucion" class="fixed inset-0 z-[100] hidden overflow-hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4 md:p-6 text-center">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500/75 backdrop-blur-sm" aria-hidden="true" onclick="document.getElementById('modal-registrar-institucion').classList.add('hidden')"></div>

        <!-- Modal panel -->
        <form id="form-registrar-institucion" action="{{ route('coordinador.instituciones.store') }}" method="POST" class="relative flex flex-col w-full max-w-3xl bg-white rounded-3xl shadow-2xl overflow-hidden transition-all transform glass-card max-h-[calc(100vh-4rem)] z-10">
            @csrf
            
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 flex-shrink-0">
                <h3 class="text-xl font-bold text-gray-900" id="modal-title">Registrar Nueva Institución</h3>
                <button type="button" class="text-gray-400 hover:text-gray-500 transition-colors" onclick="document.getElementById('modal-registrar-institucion').classList.add('hidden')">
                    <span class="sr-only">Cerrar</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <!-- Scrollable Content -->
            <div class="px-6 py-6 md:px-8 overflow-y-auto flex-grow custom-scrollbar">
                <div class="space-y-6">
                    <h4 class="text-md font-bold text-[#4E7D24] border-b border-gray-100 pb-2 text-left">Datos de la Institución y Enlace</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                        <!-- Nombre de la Institución -->
                        <div class="md:col-span-2">
                            <label for="inst-nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Institución <span class="text-red-500">*</span></label>
                            <input type="text" id="inst-nombre" name="institucion" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors" placeholder="Ej. Tech Solutions S.A. de C.V." value="{{ old('institucion') }}" required>
                            @error('institucion')
                                <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Correo Electrónico -->
                        <div>
                            <label for="inst-correo" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico (Usuario de Acceso) <span class="text-red-500">*</span></label>
                            <input type="email" id="inst-correo" name="correo" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors" placeholder="ejemplo@empresa.com" value="{{ old('correo') }}" required>
                            @error('correo')
                                <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <label for="inst-telefono" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                            <input type="text" id="inst-telefono" name="telefono" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors" placeholder="Ej. 312-316-1234" value="{{ old('telefono') }}">
                        </div>

                        <!-- Dirección -->
                        <div class="md:col-span-2">
                            <label for="inst-direccion" class="block text-sm font-medium text-gray-700 mb-1">Dirección Física <span class="text-red-500">*</span></label>
                            <input type="text" id="inst-direccion" name="direccion" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors" placeholder="Calle, Número, Local" value="{{ old('direccion') }}" required>
                            @error('direccion')
                                <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Colonia -->
                        <div>
                            <label for="inst-colonia" class="block text-sm font-medium text-gray-700 mb-1">Colonia</label>
                            <input type="text" id="inst-colonia" name="colonia" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors" placeholder="Ej. Las Víboras" value="{{ old('colonia') }}">
                        </div>

                        <!-- Código Postal -->
                        <div>
                            <label for="inst-cp" class="block text-sm font-medium text-gray-700 mb-1">Código Postal</label>
                            <input type="number" id="inst-cp" name="cp" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors" placeholder="Ej. 28040" value="{{ old('cp') }}">
                        </div>

                        <!-- Municipio -->
                        <div>
                            <label for="inst-municipio" class="block text-sm font-medium text-gray-700 mb-1">Municipio</label>
                            <input type="text" id="inst-municipio" name="municipio" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors" placeholder="Ej. Colima" value="{{ old('municipio') }}">
                        </div>

                        <!-- Estado -->
                        <div>
                            <label for="inst-estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                            <input type="text" id="inst-estado" name="estado" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors" placeholder="Ej. Colima" value="{{ old('estado') }}">
                        </div>

                        <!-- Sistema -->
                        <div>
                            <label for="inst-sistema" class="block text-sm font-medium text-gray-700 mb-1">Sistema</label>
                            <select id="inst-sistema" name="sistema" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors text-gray-700">
                                <option value="">Seleccionar Sistema</option>
                                <option value="MUNICIPAL" {{ old('sistema') == 'MUNICIPAL' ? 'selected' : '' }}>MUNICIPAL</option>
                                <option value="ESTATAL" {{ old('sistema') == 'ESTATAL' ? 'selected' : '' }}>ESTATAL</option>
                                <option value="FEDERAL" {{ old('sistema') == 'FEDERAL' ? 'selected' : '' }}>FEDERAL</option>
                                <option value="PRIVADA" {{ old('sistema') == 'PRIVADA' ? 'selected' : '' }}>PRIVADA</option>
                            </select>
                        </div>

                        <!-- Sector -->
                        <div>
                            <label for="inst-sector" class="block text-sm font-medium text-gray-700 mb-1">Sector</label>
                            <select id="inst-sector" name="sector" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors text-gray-700">
                                <option value="">Seleccionar Sector</option>
                                <option value="EDUCATIVO EXTERNO" {{ old('sector') == 'EDUCATIVO EXTERNO' ? 'selected' : '' }}>EDUCATIVO EXTERNO</option>
                                <option value="PÚBLICO" {{ old('sector') == 'PÚBLICO' ? 'selected' : '' }}>PÚBLICO</option>
                                <option value="PRIVADO" {{ old('sector') == 'PRIVADO' ? 'selected' : '' }}>PRIVADO</option>
                                <option value="SOCIAL" {{ old('sector') == 'SOCIAL' ? 'selected' : '' }}>SOCIAL</option>
                                <option value="UDEC" {{ old('sector') == 'UDEC' ? 'selected' : '' }}>UDEC</option>
                            </select>
                        </div>
                    </div>

                    <h4 class="text-md font-bold text-[#4E7D24] border-b border-gray-100 pb-2 text-left mt-6">Datos de la Unidad Receptora Principal</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                        <!-- Nombre de la Unidad Receptora -->
                        <div class="md:col-span-2">
                            <label for="inst-unidad" class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Unidad Receptora</label>
                            <input type="text" id="inst-unidad" name="unidad_receptora" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors" placeholder="Ej. Departamento de Sistemas (Dejar vacío para General)" value="{{ old('unidad_receptora') }}">
                        </div>

                        <!-- Titular -->
                        <div>
                            <label for="inst-titular" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Titular <span class="text-red-500">*</span></label>
                            <input type="text" id="inst-titular" name="titular" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors" placeholder="Ej. Lic. Martín Corona V." value="{{ old('titular') }}" required>
                            @error('titular')
                                <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cargo -->
                        <div>
                            <label for="inst-cargo" class="block text-sm font-medium text-gray-700 mb-1">Cargo del Titular <span class="text-red-500">*</span></label>
                            <input type="text" id="inst-cargo" name="cargo" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors" placeholder="Ej. Representante Legal / Gerente TI" value="{{ old('cargo') }}" required>
                            @error('cargo')
                                <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Info notice --}}
                    <div class="flex items-start gap-3 bg-blue-50 border border-blue-100 rounded-xl px-4 py-3">
                        <svg class="w-4 h-4 text-blue-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-xs text-blue-700 font-medium text-left">Se generará una contraseña aleatoria y se enviará al correo del enlace de la institución automáticamente para que puedan acceder al sistema.</p>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3 bg-gray-50/50 flex-shrink-0">
                <button type="button" onclick="document.getElementById('modal-registrar-institucion').classList.add('hidden')" class="px-5 py-2.5 border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors text-sm">
                    Cancelar
                </button>
                <button type="submit" class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Registrar Institución
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Auto-open modal si hay errores de validación y el formulario no tiene ID de bulk upload --}}
@if($errors->any() && (old('institucion') || old('correo') || old('direccion') || old('titular') || old('cargo')))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('modal-registrar-institucion').classList.remove('hidden');
    });
</script>
@endif
