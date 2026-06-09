<!-- Modal for User Registration -->
<div id="registerUserModal" class="fixed inset-0 z-[100] hidden overflow-hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4 md:p-6 text-center">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500/75 backdrop-blur-sm" aria-hidden="true" onclick="document.getElementById('registerUserModal').classList.add('hidden')"></div>

        <!-- Modal panel -->
        <form action="{{ route('admin.usuarios.store') }}" method="POST" class="relative flex flex-col w-full max-w-3xl bg-white rounded-3xl shadow-2xl overflow-hidden transition-all transform glass-card max-h-[calc(100vh-4rem)] z-10">
            @csrf
            
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 flex-shrink-0">
                <h3 class="text-xl font-bold text-gray-900" id="modal-title">Registrar Nuevo Usuario</h3>
                <button type="button" class="text-gray-400 hover:text-gray-500 transition-colors" onclick="document.getElementById('registerUserModal').classList.add('hidden')">
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
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo</label>
                            <input type="text" id="name" name="name" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors restrict-letters" placeholder="Ej. Juan Pérez" value="{{ old('name') }}" required pattern="^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$" title="El nombre completo solo debe contener letras y espacios.">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
 
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                            <input type="email" id="email" name="email" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors restrict-email" placeholder="ejemplo@ucol.mx" value="{{ old('email') }}" required pattern="^[a-zA-Z0-9._%\+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$" title="Por favor ingresa un correo electrónico válido.">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
 
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Rol en el Sistema</label>
                            <select id="role" name="role" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors text-gray-700" onchange="toggleDynamicFields(this.value)" required>
                                <option value="">Selecciona un rol</option>
                                <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>Administrador</option>
                                <option value="2" {{ old('role') == '2' ? 'selected' : '' }}>Coordinador</option>
                                <option value="3" {{ old('role') == '3' ? 'selected' : '' }}>Alumno</option>
                                <option value="4" {{ old('role') == '4' ? 'selected' : '' }}>Empresa</option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
 
                    <!-- Campos Dinámicos -->
                    <div id="dynamic-fields-modal" class="mt-6 pt-4 border-t border-gray-100 hidden">
                        <h4 class="text-md font-bold text-[#4E7D24] mb-4">Información Adicional</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Alumno / Estudiante fields -->
                            <div class="alumno-field-modal hidden">
                                <label for="matricula" class="block text-sm font-medium text-gray-700 mb-1">Matrícula</label>
                                <input type="text" id="matricula" name="matricula" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors restrict-numbers" placeholder="Ej. 20182345" value="{{ old('matricula') }}" pattern="^[0-9]+$" title="La matrícula solo debe contener números.">
                                @error('matricula')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="alumno-field-modal hidden">
                                <label for="carrera" class="block text-sm font-medium text-gray-700 mb-1">Carrera</label>
                                <select id="carrera" name="carrera" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors text-gray-700">
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
                            <div class="alumno-field-modal hidden">
                                <label for="semestre" class="block text-sm font-medium text-gray-700 mb-1">Semestre</label>
                                <input type="number" id="semestre" name="semestre" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors" placeholder="Ej. 8" value="{{ old('semestre') }}" min="1" max="12" step="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                @error('semestre')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="alumno-field-modal hidden">
                                <label for="grupo" class="block text-sm font-medium text-gray-700 mb-1">Grupo</label>
                                <input type="text" id="grupo" name="grupo" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors restrict-letters-only" placeholder="Ej. A" value="{{ old('grupo') }}" pattern="^[a-zA-Z]$" maxlength="1" title="El grupo debe ser exactamente una letra.">
                                @error('grupo')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
 
                            <!-- Empresa / Unidad Receptora fields -->
                            <div class="empresa-field-modal hidden">
                                <label for="nombre_empresa" class="block text-sm font-medium text-gray-700 mb-1">Nombre Empresa</label>
                                <input type="text" id="nombre_empresa" name="nombre_empresa" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors restrict-company-name" placeholder="Ej. Universidad de Colima" value="{{ old('nombre_empresa') }}" pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s.,&\-]+$" title="El nombre de la empresa solo debe contener letras, números, espacios y los siguientes caracteres permitidos: .,&-">
                                @error('nombre_empresa')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="empresa-field-modal hidden">
                                <label for="tipo_persona" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Persona</label>
                                <select id="tipo_persona" name="tipo_persona" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors text-gray-700">
                                    <option value="Física" {{ old('tipo_persona') == 'Física' ? 'selected' : '' }}>Física</option>
                                    <option value="Moral" {{ old('tipo_persona') == 'Moral' ? 'selected' : '' }}>Moral</option>
                                </select>
                                @error('tipo_persona')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="empresa-field-modal hidden md:col-span-2">
                                <label for="direccion" class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                                <input type="text" id="direccion" name="direccion" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors restrict-address" placeholder="Av. Tecnológico 123" value="{{ old('direccion') }}" pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s.,#\/\s\-]+$" title="La dirección solo debe contener letras, números, espacios y los siguientes caracteres comunes de domicilio: .,#/-">
                                @error('direccion')
                                    <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer (Fixed) -->
            <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3 bg-gray-50/50 flex-shrink-0">
                <button type="button" onclick="document.getElementById('registerUserModal').classList.add('hidden')" class="px-5 py-2.5 border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors text-sm">
                    Cancelar
                </button>
                <button type="submit" class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Guardar Usuario
                </button>
            </div>
        </form>
    </div>
</div>
