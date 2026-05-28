{{-- ========== MODAL: REGISTRAR ALUMNO ========== --}}
<div id="modal-registrar-alumno"
     class="hidden fixed inset-0 flex items-center justify-center p-4"
     style="z-index: 9999;"
     role="dialog" aria-modal="true" aria-labelledby="modal-title">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"
         onclick="document.getElementById('modal-registrar-alumno').classList.add('hidden')"></div>

    {{-- Modal Panel --}}
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg mx-auto overflow-hidden">

        {{-- Header --}}
        <div class="bg-gradient-to-r from-[#4E7D24] to-[#6BA53A] px-8 py-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="bg-white/20 p-2 rounded-xl">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <div>
                    <h2 id="modal-title" class="text-lg font-bold text-white">Registrar Nuevo Alumno</h2>
                    <p class="text-green-100 text-xs">Se generará y enviará una contraseña automáticamente</p>
                </div>
            </div>
            <button onclick="document.getElementById('modal-registrar-alumno').classList.add('hidden')"
                    class="text-white/70 hover:text-white transition-colors p-1 rounded-lg hover:bg-white/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Form Body --}}
        <form id="form-registrar-alumno"
              action="{{ route('coordinador.alumnos.store') }}"
              method="POST"
              class="px-8 py-6 space-y-5">
            @csrf

            {{-- Style for shake animation and input states --}}
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

            {{-- Nombre Completo --}}
            <div>
                <label for="alumno-nombre" class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">
                    Nombre Completo <span class="text-red-500">*</span>
                </label>
                <input type="text" id="alumno-nombre" name="nombre"
                       value="{{ old('nombre') }}"
                       placeholder="Ej: María González López"
                       required
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/40 focus:border-[#6BA53A] transition-all @error('nombre') border-red-400 bg-red-50 @enderror">
                <p id="error-alumno-nombre" class="text-red-500 text-xs mt-1 font-semibold hidden"></p>
                @error('nombre')
                    <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Correo --}}
            <div>
                <label for="alumno-correo" class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">
                    Correo Electrónico <span class="text-red-500">*</span>
                </label>
                <input type="email" id="alumno-correo" name="correo"
                       value="{{ old('correo') }}"
                       placeholder="alumno@universidad.edu.mx"
                       required
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/40 focus:border-[#6BA53A] transition-all @error('correo') border-red-400 bg-red-50 @enderror">
                <p id="error-alumno-correo" class="text-red-500 text-xs mt-1 font-semibold hidden"></p>
                @error('correo')
                    <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Matrícula + Carrera --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="alumno-matricula" class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">
                        Matrícula <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="alumno-matricula" name="matricula"
                           value="{{ old('matricula') }}"
                           placeholder="Ej: 20206744"
                           inputmode="numeric"
                           required
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/40 focus:border-[#6BA53A] transition-all @error('matricula') border-red-400 bg-red-50 @enderror">
                    <p id="error-alumno-matricula" class="text-red-500 text-xs mt-1 font-semibold hidden"></p>
                    @error('matricula')
                        <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="alumno-carrera" class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">
                        Carrera <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="alumno-carrera" name="carrera"
                           value="{{ old('carrera') }}"
                           placeholder="Ej: Ing. de Software"
                           required
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/40 focus:border-[#6BA53A] transition-all @error('carrera') border-red-400 bg-red-50 @enderror">
                    <p id="error-alumno-carrera" class="text-red-500 text-xs mt-1 font-semibold hidden"></p>
                    @error('carrera')
                        <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Semestre + Grupo --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="alumno-semestre" class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">
                        Semestre <span class="text-red-500">*</span>
                    </label>
                    <select id="alumno-semestre" name="semestre"
                            required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/40 focus:border-[#6BA53A] transition-all @error('semestre') border-red-400 bg-red-50 @enderror">
                        <option value="">-- Seleccionar --</option>
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
                <div>
                    <label for="alumno-grupo" class="block text-xs font-bold text-gray-700 mb-1.5 uppercase tracking-wider">
                        Grupo <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="alumno-grupo" name="grupo"
                           value="{{ old('grupo') }}"
                           placeholder="Ej: A"
                           maxlength="1"
                           required
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm uppercase focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/40 focus:border-[#6BA53A] transition-all @error('grupo') border-red-400 bg-red-50 @enderror">
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
                <p class="text-xs text-blue-700 font-medium">Se generará una contraseña aleatoria y se enviará al correo del alumno automáticamente.</p>
            </div>

            {{-- Footer Buttons --}}
            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button"
                        onclick="document.getElementById('modal-registrar-alumno').classList.add('hidden')"
                        class="px-5 py-2.5 rounded-xl text-sm font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 transition-colors">
                    Cancelar
                </button>
                <button type="submit"
                        id="btn-submit-alumno"
                        class="px-6 py-2.5 rounded-xl text-sm font-bold text-white bg-[#4E7D24] hover:bg-[#2E5417] shadow-md hover:shadow-lg transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Registrar Alumno
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Auto-open modal si hay errores de validación --}}
@if($errors->any())
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
                    if (!val.trim()) return 'La carrera es requerida.';
                    if (val.trim().length < 4) return 'La carrera debe tener al menos 4 caracteres.';
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

        // Real-time constraints
        fields.grupo.el.addEventListener('input', function() {
            // Strip any non-letters
            this.value = this.value.replace(/[^a-zA-Z]/g, '').toUpperCase();
        });

        fields.matricula.el.addEventListener('input', function() {
            // Strip any non-digits
            this.value = this.value.replace(/[^0-9]/g, '');
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
