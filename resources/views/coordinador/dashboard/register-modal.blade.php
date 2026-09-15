{{-- ========== MODAL: REGISTRAR ALUMNO ========== --}}
<div id="modal-registrar-alumno" class="fixed inset-0 z-[100] hidden overflow-hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4 md:p-6 text-center">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500/75 backdrop-blur-sm" aria-hidden="true" onclick="document.getElementById('modal-registrar-alumno').classList.add('hidden')"></div>

        <!-- Modal panel -->
        <form id="form-registrar-alumno" action="{{ route('coordinador.alumnos.store') }}" method="POST" class="relative flex flex-col w-full max-w-3xl bg-white rounded-3xl shadow-2xl overflow-hidden transition-all transform glass-card max-h-[calc(100vh-4rem)] z-10">
            @csrf
            
            <!-- Style for shake animation and input states -->
            <style>
                @keyframes shake-field {
                    0%, 100% { transform: translateX(0); }
                    20%, 60% { transform: translateX(-4px); }
                    40%, 80% { transform: translateX(4px); }
                }
                .field-shake {
                    animation: shake-field 0.3s ease-in-out;
                }
                .input-valid {
                    border-color: #10B981 !important;
                    background-color: #ECFDF5 !important;
                    box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.15) !important;
                }
                .input-invalid {
                    border-color: #EF4444 !important;
                    background-color: #FEF2F2 !important;
                    box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.15) !important;
                }
            </style>

            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 flex-shrink-0">
                <h3 class="text-xl font-bold text-gray-900" id="modal-title">Registrar Nuevo Alumno</h3>
                <button type="button" class="text-gray-400 hover:text-gray-500 transition-colors" onclick="document.getElementById('modal-registrar-alumno').classList.add('hidden')">
                    <span class="sr-only">Cerrar</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <!-- Scrollable Content -->
            <div class="px-6 py-6 md:px-8 overflow-y-auto flex-grow custom-scrollbar">
                <div class="space-y-6">
                    <h4 class="text-md font-bold text-[#4E7D24] border-b border-gray-100 pb-2">Información del Alumno</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                        <!-- Nombre Completo -->
                        <div class="md:col-span-2">
                            <label for="alumno-nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo <span class="text-red-500">*</span></label>
                            <input type="text" id="alumno-nombre" name="nombre" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors restrict-letters" placeholder="Ej. María González López" value="{{ old('nombre') }}" required pattern="^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$" title="El nombre completo solo debe contener letras y espacios.">
                            <p id="error-alumno-nombre" class="text-red-500 text-xs mt-1 font-semibold hidden"></p>
                            @error('nombre')
                                <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Correo Electrónico -->
                        <div>
                            <label for="alumno-correo" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico <span class="text-red-500">*</span></label>
                            <input type="email" id="alumno-correo" name="correo" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors restrict-email" placeholder="ejemplo@ucol.mx" value="{{ old('correo') }}" required pattern="^[a-zA-Z0-9._%\+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$" title="Por favor ingresa un correo electrónico válido.">
                            <p id="error-alumno-correo" class="text-red-500 text-xs mt-1 font-semibold hidden"></p>
                            @error('correo')
                                <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Matrícula -->
                        <div>
                            <label for="alumno-matricula" class="block text-sm font-medium text-gray-700 mb-1">Matrícula <span class="text-red-500">*</span></label>
                            <input type="text" id="alumno-matricula" name="matricula" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors restrict-numbers" placeholder="Ej. 20182345" value="{{ old('matricula') }}" required pattern="^[0-9]+$" title="La matrícula solo debe contener números.">
                            <p id="error-alumno-matricula" class="text-red-500 text-xs mt-1 font-semibold hidden"></p>
                            @error('matricula')
                                <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Carrera -->
                        <div>
                            <label for="alumno-carrera" class="block text-sm font-medium text-gray-700 mb-1">Carrera <span class="text-red-500">*</span></label>
                            <select id="alumno-carrera" name="carrera" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors text-gray-700" required>
                                <option value="">Seleccionar Carrera</option>
                                <option value="Ingeniería de Software" {{ old('carrera') == 'Ingeniería de Software' ? 'selected' : '' }}>Ingeniería de Software</option>
                                <option value="Ingeniería en Mecatrónica" {{ old('carrera') == 'Ingeniería en Mecatrónica' ? 'selected' : '' }}>Ingeniería en Mecatrónica</option>    
                                <option value="Ingeniería en Tecnologías Electrónicas" {{ old('carrera') == 'Ingeniería en Tecnologías Electrónicas' ? 'selected' : '' }}>Ingeniería en Tecnologías Electrónicas</option>    
                                <option value="Ingeniería Mecánico Electricista" {{ old('carrera') == 'Ingeniería Mecánico Electricista' ? 'selected' : '' }}>Ingeniería Mecánico Electricista</option>
                            </select>
                            <p id="error-alumno-carrera" class="text-red-500 text-xs mt-1 font-semibold hidden"></p>
                            @error('carrera')
                                <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Semestre -->
                        <div>
                            <label for="alumno-semestre" class="block text-sm font-medium text-gray-700 mb-1">Semestre <span class="text-red-500">*</span></label>
                            <select id="alumno-semestre" name="semestre" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors text-gray-700" required>
                                <option value="">Seleccionar Semestre</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ old('semestre') == $i ? 'selected' : '' }}>
                                        {{ $i }}° Semestre
                                    </option>
                                @endfor
                            </select>
                            <p id="error-alumno-semestre" class="text-red-500 text-xs mt-1 font-semibold hidden"></p>
                            @error('semestre')
                                <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Grupo -->
                        <div class="md:col-span-2">
                            <label for="alumno-grupo" class="block text-sm font-medium text-gray-700 mb-1">Grupo <span class="text-red-500">*</span></label>
                            <input type="text" id="alumno-grupo" name="grupo" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors restrict-letters-only uppercase" placeholder="Ej. A" value="{{ old('grupo') }}" required pattern="^[a-zA-Z]$" maxlength="1" title="El grupo debe ser exactamente una letra.">
                            <p id="error-alumno-grupo" class="text-red-500 text-xs mt-1 font-semibold hidden"></p>
                            @error('grupo')
                                <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Info notice --}}
                    <div class="flex items-start gap-3 bg-blue-50 border border-blue-100 rounded-xl px-4 py-3">
                        <svg class="w-4 h-4 text-blue-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-xs text-blue-700 font-medium text-left">Se generará una contraseña aleatoria y se enviará al correo del alumno automáticamente.</p>
                    </div>
                </div>
            </div>

            <!-- Footer (Fixed) -->
            <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3 bg-gray-50/50 flex-shrink-0">
                <button type="button" onclick="document.getElementById('modal-registrar-alumno').classList.add('hidden')" class="px-5 py-2.5 border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors text-sm">
                    Cancelar
                </button>
                <button type="submit" class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Registrar Alumno
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Auto-open modal si hay errores de validación --}}
@if($errors->any() && !old('id'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('modal-registrar-alumno').classList.remove('hidden');
    });
</script>
@endif

{{-- Cerrar modal con tecla Escape y Validaciones del Cliente --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Cerrar con Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.getElementById('modal-registrar-alumno').classList.add('hidden');
            }
        });

        const form = document.getElementById('form-registrar-alumno');
        if (!form) return;

        const fields = {
            nombre: {
                el: document.getElementById('alumno-nombre'),
                error: document.getElementById('error-alumno-nombre'),
                validate: (val) => {
                    if (!val.trim()) return 'El nombre completo es requerido.';
                    if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/u.test(val)) return 'El nombre solo debe contener letras y espacios.';
                    if (val.trim().length < 5) return 'El nombre completo debe tener al menos 5 caracteres.';
                    return '';
                }
            },
            correo: {
                el: document.getElementById('alumno-correo'),
                error: document.getElementById('error-alumno-correo'),
                validate: (val) => {
                    if (!val.trim()) return 'El correo electrónico es requerido.';
                    if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(val)) return 'El formato del correo es inválido.';
                    return '';
                }
            },
            matricula: {
                el: document.getElementById('alumno-matricula'),
                error: document.getElementById('error-alumno-matricula'),
                validate: (val) => {
                    if (!val.trim()) return 'La matrícula es requerida.';
                    if (!/^[0-9]+$/.test(val)) return 'La matrícula solo debe contener números.';
                    if (val.length < 5 || val.length > 20) return 'La matrícula debe tener entre 5 y 20 dígitos.';
                    return '';
                }
            },
            carrera: {
                el: document.getElementById('alumno-carrera'),
                error: document.getElementById('error-alumno-carrera'),
                validate: (val) => {
                    if (!val) return 'La carrera es requerida.';
                    return '';
                }
            },
            semestre: {
                el: document.getElementById('alumno-semestre'),
                error: document.getElementById('error-alumno-semestre'),
                validate: (val) => {
                    if (!val) return 'Debes seleccionar un semestre.';
                    const sem = parseInt(val);
                    if (isNaN(sem) || sem < 1 || sem > 12) return 'El semestre debe ser entre 1 y 12.';
                    return '';
                }
            },
            grupo: {
                el: document.getElementById('alumno-grupo'),
                error: document.getElementById('error-alumno-grupo'),
                validate: (val) => {
                    if (!val.trim()) return 'El grupo es requerido.';
                    if (!/^[a-zA-Z]$/.test(val)) return 'El grupo debe ser exactamente una letra.';
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
            
            if (target.id === 'alumno-grupo') {
                target.value = target.value.toUpperCase();
            }
        });

        // Setup individual validation events
        Object.keys(fields).forEach(key => {
            const field = fields[key];
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
                    input.classList.remove('input-valid');
                    input.classList.add('input-invalid');
                    return false;
                } else {
                    field.error.textContent = '';
                    field.error.classList.add('hidden');
                    input.classList.remove('input-invalid');
                    if (input.value.trim() !== '') {
                        input.classList.add('input-valid');
                    }
                    return true;
                }
            };

            input.addEventListener('input', handleValidate);
            input.addEventListener('blur', handleValidate);
            input.addEventListener('change', handleValidate);
        });

        // Form Submit interception
        form.addEventListener('submit', function(e) {
            let firstInvalidInput = null;
            let isFormValid = true;

            Object.keys(fields).forEach(key => {
                const field = fields[key];
                const input = field.el;
                const errMessage = field.validate(input.value);

                if (errMessage) {
                    isFormValid = false;
                    field.error.textContent = errMessage;
                    field.error.classList.remove('hidden');
                    input.classList.remove('input-valid');
                    input.classList.add('input-invalid');

                    // Apply shake effect
                    input.classList.remove('field-shake');
                    void input.offsetWidth; // Trigger reflow to restart animation
                    input.classList.add('field-shake');

                    if (!firstInvalidInput) {
                        firstInvalidInput = input;
                    }
                }
            });

            if (!isFormValid) {
                e.preventDefault();
                if (firstInvalidInput) {
                    firstInvalidInput.focus();
                    firstInvalidInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
    });
</script>
