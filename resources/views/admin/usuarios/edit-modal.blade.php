<!-- Modal for User Editing -->
<div id="editUserModal" class="fixed inset-0 z-[100] hidden overflow-hidden" aria-labelledby="edit-modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4 md:p-6 text-center">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500/75 backdrop-blur-sm" aria-hidden="true" onclick="closeEditModal()"></div>

        <!-- Modal panel -->
        <form id="editUserForm" action="#" method="POST" hx-boost="false" class="relative flex flex-col w-full max-w-3xl bg-white rounded-3xl shadow-2xl overflow-hidden transition-all transform glass-card max-h-[calc(100vh-4rem)] z-10">
            @csrf
            @method('PUT')
            <!-- Hidden field for User ID -->
            <input type="hidden" id="edit_user_id" name="id">
            <!-- Hidden field for Role to submit it when disabled -->
            <input type="hidden" id="edit_role_hidden" name="role">

            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 flex-shrink-0">
                <h3 class="text-xl font-bold text-gray-900" id="edit-modal-title">Editar Usuario</h3>
                <button type="button" class="text-gray-400 hover:text-gray-500 transition-colors" onclick="closeEditModal()">
                    <span class="sr-only">Cerrar</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <!-- Scrollable Content -->
            <div class="px-6 py-6 md:px-8 overflow-y-auto flex-grow custom-scrollbar">
                <div class="space-y-6">
                    <h4 class="text-md font-bold text-[#4E7D24] border-b border-gray-100 pb-2">Información del Usuario</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo</label>
                            <input type="text" id="edit_name" name="name" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors restrict-letters" placeholder="Ej. Juan Pérez" value="{{ old('name') }}" required pattern="^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$" title="El nombre completo solo debe contener letras y espacios.">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
 
                        <div>
                            <label for="edit_email" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                            <input type="email" id="edit_email" name="email" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors restrict-email" placeholder="ejemplo@ucol.mx" value="{{ old('email') }}" required pattern="^[a-zA-Z0-9._%\+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$" title="Por favor ingresa un correo electrónico válido.">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
 
                        <div>
                            <label for="edit_role" class="block text-sm font-medium text-gray-700 mb-1">Rol en el Sistema</label>
                            <select id="edit_role" class="block w-full px-4 py-2.5 bg-gray-100 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors text-gray-500 cursor-not-allowed" disabled>
                                <option value="1">Administrador</option>
                                <option value="2">Coordinador</option>
                                <option value="3">Alumno</option>
                                <option value="4">Empresa</option>
                            </select>
                        </div>
                    </div>
 
                    <!-- Campos Dinámicos para Edición -->
                    <div id="edit-dynamic-fields" class="mt-6 pt-4 border-t border-gray-100 hidden">
                        <h4 class="text-md font-bold text-[#4E7D24] mb-4">Información Adicional</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Alumno fields -->
                            <div class="edit-alumno-field hidden">
                                <label for="edit_matricula" class="block text-sm font-medium text-gray-700 mb-1">Matrícula</label>
                                <input type="text" id="edit_matricula" name="matricula" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors restrict-numbers" placeholder="Ej. 20182345" value="{{ old('matricula') }}" pattern="^[0-9]+$" title="La matrícula solo debe contener números.">
                                @error('matricula')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="edit-alumno-field hidden">
                                <label for="edit_carrera" class="block text-sm font-medium text-gray-700 mb-1">Carrera</label>
                                <select id="edit_carrera" name="carrera" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors">
                                    <option value="">Seleccionar Carrera</option>
                                    <option value="Ingeniería de Software" {{ old('carrera') == 'Ingeniería de Software' ? 'selected' : '' }}>Ingeniería de Software</option>
                                    <option value="Ingeniería en Mecatrónica" {{ old('carrera') == 'Ingeniería en Mecatrónica' ? 'selected' : '' }}>Ingeniería en Mecatrónica</option>    
                                    <option value="Ingeniería en Tecnologías Electrónicas" {{ old('carrera') == 'Ingeniería en Tecnologías Electrónicas' ? 'selected' : '' }}>Ingeniería en Tecnologías Electrónicas</option>    
                                    <option value="Ingeniería Mecánico Electricista" {{ old('carrera') == 'Ingeniería Mecánico Electricista' ? 'selected' : '' }}>Ingeniería Mecánico Electricista</option>
                                </select>
                                @error('carrera')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="edit-alumno-field hidden">
                                <label for="edit_semestre" class="block text-sm font-medium text-gray-700 mb-1">Semestre</label>
                                <input type="number" id="edit_semestre" name="semestre" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors" placeholder="Ej. 8" value="{{ old('semestre') }}" min="1" max="12" step="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                @error('semestre')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="edit-alumno-field hidden">
                                <label for="edit_grupo" class="block text-sm font-medium text-gray-700 mb-1">Grupo</label>
                                <input type="text" id="edit_grupo" name="grupo" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors restrict-letters-only" placeholder="Ej. A" value="{{ old('grupo') }}" pattern="^[a-zA-Z]$" maxlength="1" title="El grupo debe ser exactamente una letra.">
                                @error('grupo')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
 
                            <!-- Empresa fields -->
                            <div class="edit-empresa-field hidden md:col-span-2">
                                <label for="edit_direccion" class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                                <input type="text" id="edit_direccion" name="direccion" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors restrict-address" placeholder="Av. Tecnológico 123" value="{{ old('direccion') }}" pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s.,#\/\s\-]+$" title="La dirección solo debe contener letras, números, espacios y los siguientes caracteres comunes de domicilio: .,#/-">
                                @error('direccion')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="edit-empresa-field hidden">
                                <label for="edit_tipo_persona" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Persona</label>
                                <select id="edit_tipo_persona" name="tipo_persona" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors text-gray-700">
                                    <option value="Física" {{ old('tipo_persona') == 'Física' ? 'selected' : '' }}>Física</option>
                                    <option value="Moral" {{ old('tipo_persona') == 'Moral' ? 'selected' : '' }}>Moral</option>
                                </select>
                                @error('tipo_persona')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer (Fixed) -->
            <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3 bg-gray-50/50 flex-shrink-0">
                <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors text-sm">
                    Cancelar
                </button>
                <button type="button" onclick="openConfirmEditModal()" class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Actualizar Usuario
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal for Confirm Editing -->
<div id="confirmEditModal" class="fixed inset-0 z-[110] hidden overflow-y-auto" aria-labelledby="confirm-modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500/75 backdrop-blur-sm" aria-hidden="true" onclick="closeConfirmEditModal()"></div>

        <!-- Modal panel -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block w-full max-w-md overflow-hidden text-left align-bottom transition-all transform bg-white rounded-3xl shadow-2xl sm:my-8 sm:align-middle glass-card flex flex-col p-6">
            <!-- Header -->
            <div class="flex items-center gap-3 mb-4">
                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900" id="confirm-modal-title">¿Confirmar Cambios?</h3>
            </div>
            
            <!-- Content -->
            <div class="mb-6">
                <p class="text-sm text-gray-500 leading-relaxed">
                    ¿Estás seguro de que deseas actualizar la información de este usuario? Se guardarán todas las modificaciones realizadas de inmediato.
                </p>
            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeConfirmEditModal()" class="px-4 py-2 border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors text-sm">
                    Cancelar
                </button>
                <button type="button" onclick="submitEditUserForm()" class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-5 py-2 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Sí, Confirmar
                </button>
            </div>
        </div>
    </div>
</div>
