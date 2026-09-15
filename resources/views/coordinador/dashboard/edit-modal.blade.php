{{-- ========== MODAL: EDITAR ALUMNO ========== --}}
<div id="modal-editar-alumno" class="fixed inset-0 z-[100] hidden overflow-hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4 md:p-6 text-center">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-950/60 backdrop-blur-md" aria-hidden="true" onclick="document.getElementById('modal-editar-alumno').classList.add('hidden')"></div>

        <!-- Modal panel -->
        <form id="form-editar-alumno" action="" method="POST" class="relative flex flex-col w-full max-w-3xl bg-white rounded-3xl shadow-2xl overflow-hidden transition-all transform max-h-[90vh] z-10">
            @csrf
            @method('PUT')
            
            <input type="hidden" name="id" id="edit-alumno-id" value="{{ old('id') }}">

            <!-- Header (Gradient Green Banner) -->
            <div class="bg-gradient-to-r from-[#4E7D24] to-[#6BA53A] px-8 py-6 flex items-center justify-between flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 p-2 rounded-xl">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="text-left">
                        <h2 id="modal-title" class="text-lg font-bold text-white leading-tight">Editar Datos del Alumno</h2>
                        <p class="text-green-100 text-xs">Modifica los campos del estudiante según sea necesario</p>
                    </div>
                </div>
                <button type="button" 
                        onclick="document.getElementById('modal-editar-alumno').classList.add('hidden')"
                        class="text-white/70 hover:text-white transition-colors p-1.5 rounded-lg hover:bg-white/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Scrollable Content -->
            <div class="px-6 py-6 md:px-8 overflow-y-auto flex-grow custom-scrollbar">
                <div class="space-y-6">
                    <h4 class="text-md font-bold text-[#4E7D24] border-b border-gray-100 pb-2 text-left">Información del Alumno</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                        <!-- Nombre Completo -->
                        <div class="md:col-span-2">
                            <label for="edit-alumno-nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo <span class="text-red-500">*</span></label>
                            <input type="text" id="edit-alumno-nombre" name="nombre" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors restrict-letters" placeholder="Ej. María González López" value="{{ old('nombre') }}" required pattern="^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$" title="El nombre completo solo debe contener letras y espacios.">
                            <p id="error-edit-alumno-nombre" class="text-red-500 text-xs mt-1 font-semibold hidden"></p>
                            @error('nombre')
                                @if(old('id'))
                                    <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                                @endif
                            @enderror
                        </div>

                        <!-- Correo Electrónico -->
                        <div>
                            <label for="edit-alumno-correo" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico <span class="text-red-500">*</span></label>
                            <input type="email" id="edit-alumno-correo" name="correo" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors restrict-email" placeholder="ejemplo@ucol.mx" value="{{ old('correo') }}" required pattern="^[a-zA-Z0-9._%\+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$" title="Por favor ingresa un correo electrónico válido.">
                            <p id="error-edit-alumno-correo" class="text-red-500 text-xs mt-1 font-semibold hidden"></p>
                            @error('correo')
                                @if(old('id'))
                                    <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                                @endif
                            @enderror
                        </div>

                        <!-- Matrícula -->
                        <div>
                            <label for="edit-alumno-matricula" class="block text-sm font-medium text-gray-700 mb-1">Matrícula <span class="text-red-500">*</span></label>
                            <input type="text" id="edit-alumno-matricula" name="matricula" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors restrict-numbers" placeholder="Ej. 20182345" value="{{ old('matricula') }}" required pattern="^[0-9]+$" title="La matrícula solo debe contener números.">
                            <p id="error-edit-alumno-matricula" class="text-red-500 text-xs mt-1 font-semibold hidden"></p>
                            @error('matricula')
                                @if(old('id'))
                                    <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                                @endif
                            @enderror
                        </div>

                        <!-- Carrera -->
                        <div>
                            <label for="edit-alumno-carrera" class="block text-sm font-medium text-gray-700 mb-1">Carrera <span class="text-red-500">*</span></label>
                            <select id="edit-alumno-carrera" name="carrera" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors text-gray-700" required>
                                <option value="">Seleccionar Carrera</option>
                                <option value="Ingeniería de Software" {{ old('carrera') == 'Ingeniería de Software' ? 'selected' : '' }}>Ingeniería de Software</option>
                                <option value="Ingeniería en Mecatrónica" {{ old('carrera') == 'Ingeniería en Mecatrónica' ? 'selected' : '' }}>Ingeniería en Mecatrónica</option>    
                                <option value="Ingeniería en Tecnologías Electrónicas" {{ old('carrera') == 'Ingeniería en Tecnologías Electrónicas' ? 'selected' : '' }}>Ingeniería en Tecnologías Electrónicas</option>    
                                <option value="Ingeniería Mecánico Electricista" {{ old('carrera') == 'Ingeniería Mecánico Electricista' ? 'selected' : '' }}>Ingeniería Mecánico Electricista</option>
                            </select>
                            <p id="error-edit-alumno-carrera" class="text-red-500 text-xs mt-1 font-semibold hidden"></p>
                            @error('carrera')
                                @if(old('id'))
                                    <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                                @endif
                            @enderror
                        </div>

                        <!-- Semestre -->
                        <div>
                            <label for="edit-alumno-semestre" class="block text-sm font-medium text-gray-700 mb-1">Semestre <span class="text-red-500">*</span></label>
                            <select id="edit-alumno-semestre" name="semestre" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors text-gray-700" required>
                                <option value="">Seleccionar Semestre</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ old('semestre') == $i ? 'selected' : '' }}>
                                        {{ $i }}° Semestre
                                    </option>
                                @endfor
                            </select>
                            <p id="error-edit-alumno-semestre" class="text-red-500 text-xs mt-1 font-semibold hidden"></p>
                            @error('semestre')
                                @if(old('id'))
                                    <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                                @endif
                            @enderror
                        </div>

                        <!-- Grupo -->
                        <div class="md:col-span-2">
                            <label for="edit-alumno-grupo" class="block text-sm font-medium text-gray-700 mb-1">Grupo <span class="text-red-500">*</span></label>
                            <input type="text" id="edit-alumno-grupo" name="grupo" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors restrict-letters-only uppercase" placeholder="Ej. A" value="{{ old('grupo') }}" required pattern="^[a-zA-Z]$" maxlength="1" title="El grupo debe ser exactamente una letra.">
                            <p id="error-edit-alumno-grupo" class="text-red-500 text-xs mt-1 font-semibold hidden"></p>
                            @error('grupo')
                                @if(old('id'))
                                    <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                                @endif
                            @enderror
                        </div>

                        <!-- Asesor -->
                        <div>
                            <label for="edit-alumno-asesor" class="block text-sm font-medium text-gray-700 mb-1">Asesor Académico</label>
                            <input type="text" id="edit-alumno-asesor" name="asesor" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors" placeholder="Ej. Dr. Juan Carlos" value="{{ old('asesor') }}">
                            <p id="error-edit-alumno-asesor" class="text-red-500 text-xs mt-1 font-semibold hidden"></p>
                            @error('asesor')
                                @if(old('id'))
                                    <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                                @endif
                            @enderror
                        </div>

                        <!-- Coasesor -->
                        <div>
                            <label for="edit-alumno-coasesor" class="block text-sm font-medium text-gray-700 mb-1">Coasesor</label>
                            <input type="text" id="edit-alumno-coasesor" name="coasesor" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors" placeholder="Ej. Mtra. Ana María" value="{{ old('coasesor') }}">
                            <p id="error-edit-alumno-coasesor" class="text-red-500 text-xs mt-1 font-semibold hidden"></p>
                            @error('coasesor')
                                @if(old('id'))
                                    <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                                @endif
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3 bg-gray-50/50 flex-shrink-0">
                <button type="button" onclick="document.getElementById('modal-editar-alumno').classList.add('hidden')" class="px-5 py-2.5 border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors text-sm">
                    Cancelar
                </button>
                <button type="submit" class="bg-blue-600 text-white hover:bg-blue-700 px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Auto-open modal si hay errores de validación en edición --}}
@if($errors->any() && old('id'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('form-editar-alumno');
        form.action = `/coordinador/alumnos/{{ old('id') }}`;
        document.getElementById('modal-editar-alumno').classList.remove('hidden');
    });
</script>
@endif

{{-- Cerrar modal con tecla Escape y Validaciones del Cliente --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Cerrar con Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.getElementById('modal-editar-alumno').classList.add('hidden');
            }
        });

        const form = document.getElementById('form-editar-alumno');
        if (!form) return;

        const editFields = {
            nombre: {
                el: document.getElementById('edit-alumno-nombre'),
                error: document.getElementById('error-edit-alumno-nombre'),
                validate: (val) => {
                    if (!val.trim()) return 'El nombre completo es requerido.';
                    if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/u.test(val)) return 'El nombre solo debe contener letras y espacios.';
                    if (val.trim().length < 5) return 'El nombre completo debe tener al menos 5 caracteres.';
                    return '';
                }
            },
            correo: {
                el: document.getElementById('edit-alumno-correo'),
                error: document.getElementById('error-edit-alumno-correo'),
                validate: (val) => {
                    if (!val.trim()) return 'El correo electrónico es requerido.';
                    if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(val)) return 'El formato del correo es inválido.';
                    return '';
                }
            },
            matricula: {
                el: document.getElementById('edit-alumno-matricula'),
                error: document.getElementById('error-edit-alumno-matricula'),
                validate: (val) => {
                    if (!val.trim()) return 'La matrícula es requerida.';
                    if (!/^[0-9]+$/.test(val)) return 'La matrícula solo debe contener números.';
                    if (val.length < 5 || val.length > 20) return 'La matrícula debe tener entre 5 y 20 dígitos.';
                    return '';
                }
            },
            carrera: {
                el: document.getElementById('edit-alumno-carrera'),
                error: document.getElementById('error-edit-alumno-carrera'),
                validate: (val) => {
                    if (!val) return 'La carrera es requerida.';
                    return '';
                }
            },
            semestre: {
                el: document.getElementById('edit-alumno-semestre'),
                error: document.getElementById('error-edit-alumno-semestre'),
                validate: (val) => {
                    if (!val) return 'Debes seleccionar un semestre.';
                    const sem = parseInt(val);
                    if (isNaN(sem) || sem < 1 || sem > 12) return 'El semestre debe ser entre 1 y 12.';
                    return '';
                }
            },
            grupo: {
                el: document.getElementById('edit-alumno-grupo'),
                error: document.getElementById('error-edit-alumno-grupo'),
                validate: (val) => {
                    if (!val.trim()) return 'El grupo es requerido.';
                    if (!/^[a-zA-Z]$/.test(val)) return 'El grupo debe ser exactamente una letra.';
                    return '';
                }
            },
            asesor: {
                el: document.getElementById('edit-alumno-asesor'),
                error: document.getElementById('error-edit-alumno-asesor'),
                validate: (val) => {
                    if (val.trim() && val.trim().length < 3) return 'El nombre del asesor debe tener al menos 3 caracteres.';
                    return '';
                }
            },
            coasesor: {
                el: document.getElementById('edit-alumno-coasesor'),
                error: document.getElementById('error-edit-alumno-coasesor'),
                validate: (val) => {
                    if (val.trim() && val.trim().length < 3) return 'El nombre del coasesor debe tener al menos 3 caracteres.';
                    return '';
                }
            }
        };

        // Real-time key filters (delegated or direct)
        form.addEventListener('keypress', function(e) {
            const target = e.target;
            if (!target || !target.classList) return;
            
            let regex = null;
            if (target.classList.contains('restrict-letters')) {
                regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]$/;
            } else if (target.classList.contains('restrict-numbers')) {
                regex = /^[0-9]$/;
            } else if (target.classList.contains('restrict-letters-only')) {
                regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]$/;
            } else if (target.classList.contains('restrict-email')) {
                regex = /^[a-zA-Z0-9@._+-]$/;
            }
            
            if (regex) {
                if (e.key === 'Backspace' || e.key === 'Enter' || e.key === 'Tab' || e.key === 'Delete' || e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
                    return;
                }
                if (!regex.test(e.key)) {
                    e.preventDefault();
                }
            }
        });

        form.addEventListener('input', function(e) {
            const target = e.target;
            if (!target || !target.classList) return;
            
            let regex = null;
            if (target.classList.contains('restrict-letters')) {
                regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]$/;
            } else if (target.classList.contains('restrict-numbers')) {
                regex = /^[0-9]$/;
            } else if (target.classList.contains('restrict-letters-only')) {
                regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]$/;
            } else if (target.classList.contains('restrict-email')) {
                regex = /^[a-zA-Z0-9@._+-]$/;
            }
            
            if (regex) {
                let newValue = '';
                for (let char of target.value) {
                    if (regex.test(char)) {
                        newValue += char;
                    }
                }
                if (target.value !== newValue) {
                    target.value = newValue;
                }
            }
            
            if (target.id === 'edit-alumno-grupo') {
                target.value = target.value.toUpperCase();
            }
        });

        // Setup individual validation events
        Object.keys(editFields).forEach(key => {
            const field = editFields[key];
            const input = field.el;

            const handleValidate = () => {
                // Clear server errors for this field as soon as user types or modifies it
                const parent = input.parentElement;
                const serverErr = parent.querySelector('.server-error');
                if (serverErr) serverErr.remove();
                input.classList.remove('border-red-400', 'bg-red-50');

                const errMessage = field.validate(input.value);
                if (errMessage) {
                    field.error.textContent = errMessage;
                    field.error.classList.remove('hidden');
                    input.classList.add('input-invalid');
                    input.classList.remove('input-valid');
                } else {
                    field.error.textContent = '';
                    field.error.classList.add('hidden');
                    input.classList.remove('input-invalid');
                    if (input.value.trim() !== '') {
                        input.classList.add('input-valid');
                    } else {
                        input.classList.remove('input-valid');
                    }
                }
            };

            input.addEventListener('input', handleValidate);
            input.addEventListener('change', handleValidate);
            input.addEventListener('blur', handleValidate);
        });

        // Validate on submit
        form.addEventListener('submit', function (e) {
            let isValid = true;
            for (const key in editFields) {
                const field = editFields[key];
                const errorMsg = field.validate(field.el.value);
                if (errorMsg) {
                    isValid = false;
                    field.error.textContent = errorMsg;
                    field.error.classList.remove('hidden');
                    field.el.classList.add('input-invalid');
                    field.el.classList.add('field-shake');
                    setTimeout(() => {
                        field.el.classList.remove('field-shake');
                    }, 300);
                } else {
                    field.error.textContent = '';
                    field.error.classList.add('hidden');
                    field.el.classList.remove('input-invalid');
                }
            }
            if (!isValid) {
                e.preventDefault();
            }
        });
    });
</script>
