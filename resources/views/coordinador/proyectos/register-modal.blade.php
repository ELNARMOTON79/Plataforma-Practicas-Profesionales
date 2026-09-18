<!-- Modal: Registrar Proyecto -->
<div id="modal-registrar-proyecto" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-950/60 backdrop-blur-md transition-opacity duration-300"
         onclick="document.getElementById('modal-registrar-proyecto').classList.add('hidden')"></div>

    <!-- Modal Positioning -->
    <div class="flex min-h-screen items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-3xl mx-auto overflow-hidden transform transition-all duration-300 scale-100 max-h-[90vh] flex flex-col">
            
            <!-- Header (Gradient Green Banner) -->
            <div class="bg-gradient-to-r from-[#4E7D24] to-[#6BA53A] px-8 py-6 relative flex flex-col items-center justify-center text-center flex-shrink-0">
                <button type="button" 
                        onclick="document.getElementById('modal-registrar-proyecto').classList.add('hidden')"
                        class="absolute top-4 right-4 text-white/70 hover:text-white transition-colors p-1.5 rounded-lg hover:bg-white/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <div class="flex items-center justify-center gap-3 mb-1">
                    <div class="bg-white/20 p-2 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h2 id="modal-title" class="text-xl font-bold text-white leading-tight">Registrar Nuevo Proyecto</h2>
                </div>
                <p class="text-green-100 text-xs">Completa los campos para dar de alta el proyecto en el catálogo</p>
            </div>
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

            <!-- Registration Form with Scrollable Body -->
            <form id="form-registrar-proyecto" action="{{ route('coordinador.proyectos.store') }}" method="POST" class="px-8 py-6 space-y-5 overflow-y-auto scrollbar-thin flex-1">
                @csrf

                <h4 class="text-md font-bold text-[#4E7D24] border-b border-gray-100 pb-2 text-center mb-2">Información del Proyecto</h4>

                <!-- 1. Unidad Receptora Select (Dynamically loaded from DB) -->
                <div>
                    <label for="reg-unidad" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Unidad Receptora / Institución <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select id="reg-unidad" name="unidad_receptora_id" required class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 shadow-sm transition-all appearance-none cursor-pointer @error('unidad_receptora_id') border-red-400 bg-red-50 @enderror">
                            <option value="">Selecciona la institución asociada...</option>
                            @foreach($unidadesReceptoras as $ur)
                                <option value="{{ $ur->id }}" {{ old('unidad_receptora_id') == $ur->id ? 'selected' : '' }}>
                                    {{ strtoupper($ur->nombre_empresa) }}{{ !empty($ur->unidad_receptora) ? ' — ' . $ur->unidad_receptora : '' }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                    <p id="error-reg-unidad" class="text-red-500 text-xs mt-1 font-semibold hidden"></p>
                    @error('unidad_receptora_id')
                        <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 1.5 Alumno Asignado al Proyecto (Opcional) -->
                <div>
                    <label for="reg-estudiante" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Alumno Asignado al Proyecto <span class="text-gray-400 font-normal lowercase">(opcional)</span></label>
                    <div class="relative">
                        <select id="reg-estudiante" name="estudiante_id" class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 shadow-sm transition-all appearance-none cursor-pointer @error('estudiante_id') border-red-400 bg-red-50 @enderror">
                            <option value="">Sin Asignar / Selecciona un alumno...</option>
                            @foreach($alumnos as $al)
                                <option value="{{ $al->id }}" {{ old('estudiante_id') == $al->id ? 'selected' : '' }}>
                                    {{ strtoupper($al->nombre_completo) }} ({{ $al->matricula }}) — {{ strtoupper($al->carrera) }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                    @error('estudiante_id')
                        <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 2. Título -->
                <div>
                    <label for="reg-titulo" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Título del Proyecto <span class="text-red-500">*</span></label>
                    <input type="text" id="reg-titulo" name="titulo" required value="{{ old('titulo') }}" placeholder="Ej. PLATAFORMA WEB PARA ADMINISTRACIÓN DE PRÁCTICAS..." class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400 shadow-sm transition-all @error('titulo') border-red-400 bg-red-50 @enderror">
                    <p id="error-reg-titulo" class="text-red-500 text-xs mt-1 font-semibold hidden"></p>
                    @error('titulo')
                        <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Grid for 2-column inputs -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Tipo de Proyecto Select -->
                    <div>
                        <label for="reg-tipo-proyecto" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Tipo de Proyecto <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select id="reg-tipo-proyecto" name="tipo_proyecto" required class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 shadow-sm transition-all appearance-none cursor-pointer @error('tipo_proyecto') border-red-400 bg-red-50 @enderror">
                                <option value="">Selecciona el tipo...</option>
                                <option value="Desarrollo Tecnológico" {{ old('tipo_proyecto') == 'Desarrollo Tecnológico' ? 'selected' : '' }}>Desarrollo Tecnológico</option>
                                <option value="Investigación" {{ old('tipo_proyecto') == 'Investigación' ? 'selected' : '' }}>Investigación Académica</option>
                                <option value="Asistencia Social" {{ old('tipo_proyecto') == 'Asistencia Social' ? 'selected' : '' }}>Asistencia Social / Comunitaria</option>
                                <option value="Administrativo" {{ old('tipo_proyecto') == 'Administrativo' ? 'selected' : '' }}>Administrativo / Oficina</option>
                                <option value="Infraestructura" {{ old('tipo_proyecto') == 'Infraestructura' ? 'selected' : '' }}>Infraestructura y Redes</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        <p id="error-reg-tipo-proyecto" class="text-red-500 text-xs mt-1 font-semibold hidden"></p>
                        @error('tipo_proyecto')
                            <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tipo de Modalidad Select -->
                    <div>
                        <label for="reg-tipo-modalidad" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Tipo de Modalidad <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select id="reg-tipo-modalidad" name="tipo_modalidad" required class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 shadow-sm transition-all appearance-none cursor-pointer @error('tipo_modalidad') border-red-400 bg-red-50 @enderror">
                                <option value="">Selecciona la modalidad...</option>
                                <option value="Presencial" {{ old('tipo_modalidad') == 'Presencial' ? 'selected' : '' }}>Presencial</option>
                                <option value="Híbrido" {{ old('tipo_modalidad') == 'Híbrido' ? 'selected' : '' }}>Híbrido</option>
                                <option value="Virtual" {{ old('tipo_modalidad') == 'Virtual' ? 'selected' : '' }}>Virtual / Remoto</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        <p id="error-reg-tipo-modalidad" class="text-red-500 text-xs mt-1 font-semibold hidden"></p>
                        @error('tipo_modalidad')
                            <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Textareas Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Objetivo -->
                    <div>
                        <label for="reg-objetivo" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Objetivo del Proyecto <span class="text-red-500">*</span></label>
                        <textarea id="reg-objetivo" name="objetivo" rows="3" required maxlength="1000" placeholder="Describe brevemente la meta principal del proyecto..." class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400 shadow-sm transition-all resize-none @error('objetivo') border-red-400 bg-red-50 @enderror">{{ old('objetivo') }}</textarea>
                        <div class="flex justify-between items-center mt-1">
                            <p id="error-reg-objetivo" class="text-red-500 text-[11px] font-semibold hidden"></p>
                            <div class="text-right text-[10px] text-gray-400 ml-auto"><span id="counter-reg-objetivo">0</span> / 1000 carac.</div>
                        </div>
                        @error('objetivo')
                            <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Justificación -->
                    <div>
                        <label for="reg-justificacion" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Justificación <span class="text-red-500">*</span></label>
                        <textarea id="reg-justificacion" name="justificacion" rows="3" required maxlength="1000" placeholder="¿Por qué es necesario y qué problema resuelve?..." class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400 shadow-sm transition-all resize-none @error('justificacion') border-red-400 bg-red-50 @enderror">{{ old('justificacion') }}</textarea>
                        <div class="flex justify-between items-center mt-1">
                            <p id="error-reg-justificacion" class="text-red-500 text-[11px] font-semibold hidden"></p>
                            <div class="text-right text-[10px] text-gray-400 ml-auto"><span id="counter-reg-justificacion">0</span> / 1000 carac.</div>
                        </div>
                        @error('justificacion')
                            <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actividades -->
                    <div>
                        <label for="reg-actividades" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Actividades del Alumno <span class="text-red-500">*</span></label>
                        <textarea id="reg-actividades" name="actividades" rows="3" required maxlength="1500" placeholder="Listado de tareas o funciones a realizar..." class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400 shadow-sm transition-all resize-none @error('actividades') border-red-400 bg-red-50 @enderror">{{ old('actividades') }}</textarea>
                        <div class="flex justify-between items-center mt-1">
                            <p id="error-reg-actividades" class="text-red-500 text-[11px] font-semibold hidden"></p>
                            <div class="text-right text-[10px] text-gray-400 ml-auto"><span id="counter-reg-actividades">0</span> / 1500 carac.</div>
                        </div>
                        @error('actividades')
                            <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Impacto Social -->
                    <div>
                        <label for="reg-impacto" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Impacto Social <span class="text-red-500">*</span></label>
                        <textarea id="reg-impacto" name="impacto_social" rows="3" required maxlength="1000" placeholder="Beneficio que aporta a la comunidad o sector social..." class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400 shadow-sm transition-all resize-none @error('impacto_social') border-red-400 bg-red-50 @enderror">{{ old('impacto_social') }}</textarea>
                        <div class="flex justify-between items-center mt-1">
                            <p id="error-reg-impacto" class="text-red-500 text-[11px] font-semibold hidden"></p>
                            <div class="text-right text-[10px] text-gray-400 ml-auto"><span id="counter-reg-impacto">0</span> / 1000 carac.</div>
                        </div>
                        @error('impacto_social')
                            <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Cupo de Alumnos -->
                <div>
                    <label for="reg-cupos-totales" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Cupo de Alumnos <span class="text-red-500">*</span></label>
                    <input type="number" id="reg-cupos-totales" name="cupos_totales" required min="1" max="2" value="{{ old('cupos_totales', 1) }}" placeholder="Ej. 1" onwheel="this.blur()" class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400 shadow-sm transition-all restrict-numbers @error('cupos_totales') border-red-400 bg-red-50 @enderror">
                    <p id="error-reg-cupos-totales" class="text-red-500 text-xs mt-1 font-semibold hidden"></p>
                    @error('cupos_totales')
                        <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Footer Action Buttons -->
                <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-5 mt-4">
                    <button type="button" 
                            onclick="document.getElementById('modal-registrar-proyecto').classList.add('hidden')"
                            class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-bold text-gray-500 hover:bg-gray-50 transition-all cursor-pointer">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-6 py-2.5 rounded-xl bg-[#4E7D24] text-white hover:bg-[#2E5417] text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 transform hover:-translate-y-0.5 cursor-pointer">
                        Registrar Proyecto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Interactive Client-side Script for Project Registration --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('form-registrar-proyecto');
        if (!form) return;

        // Prevent wheel/touchpad scroll from altering number inputs
        form.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('wheel', function () { this.blur(); });
        });

        const fields = {
            unidad: {
                el: document.getElementById('reg-unidad'),
                error: document.getElementById('error-reg-unidad'),
                validate: (val) => !val ? 'Debes seleccionar una Unidad Receptora.' : ''
            },
            titulo: {
                el: document.getElementById('reg-titulo'),
                error: document.getElementById('error-reg-titulo'),
                validate: (val) => {
                    if (!val.trim()) return 'El título del proyecto es requerido.';
                    if (val.trim().length < 10) return 'El título debe tener al menos 10 caracteres.';
                    if (val.trim().length > 255) return 'El título no puede superar los 255 caracteres.';
                    return '';
                }
            },
            tipoProyecto: {
                el: document.getElementById('reg-tipo-proyecto'),
                error: document.getElementById('error-reg-tipo-proyecto'),
                validate: (val) => !val ? 'Debes seleccionar el tipo de proyecto.' : ''
            },
            tipoModalidad: {
                el: document.getElementById('reg-tipo-modalidad'),
                error: document.getElementById('error-reg-tipo-modalidad'),
                validate: (val) => !val ? 'Debes seleccionar la modalidad.' : ''
            },
            cuposTotales: {
                el: document.getElementById('reg-cupos-totales'),
                error: document.getElementById('error-reg-cupos-totales'),
                validate: (val) => {
                    const num = parseInt(val);
                    if (isNaN(num) || num < 1 || num > 2) return 'El cupo debe ser 1 o 2 alumnos.';
                    return '';
                }
            },
            objetivo: {
                el: document.getElementById('reg-objetivo'),
                error: document.getElementById('error-reg-objetivo'),
                counter: document.getElementById('counter-reg-objetivo'),
                validate: (val) => {
                    if (!val.trim()) return 'El objetivo del proyecto es requerido.';
                    if (val.trim().length < 20) return 'El objetivo debe tener al menos 20 caracteres.';
                    return '';
                }
            },
            justificacion: {
                el: document.getElementById('reg-justificacion'),
                error: document.getElementById('error-reg-justificacion'),
                counter: document.getElementById('counter-reg-justificacion'),
                validate: (val) => {
                    if (!val.trim()) return 'La justificación es requerida.';
                    if (val.trim().length < 20) return 'La justificación debe tener al menos 20 caracteres.';
                    return '';
                }
            },
            actividades: {
                el: document.getElementById('reg-actividades'),
                error: document.getElementById('error-reg-actividades'),
                counter: document.getElementById('counter-reg-actividades'),
                validate: (val) => {
                    if (!val.trim()) return 'Las actividades son requeridas.';
                    if (val.trim().length < 25) return 'Describe al menos 25 caracteres de actividades.';
                    return '';
                }
            },
            impacto: {
                el: document.getElementById('reg-impacto'),
                error: document.getElementById('error-reg-impacto'),
                counter: document.getElementById('counter-reg-impacto'),
                validate: (val) => {
                    if (!val.trim()) return 'El impacto social es requerido.';
                    if (val.trim().length < 20) return 'El impacto social debe tener al menos 20 caracteres.';
                    return '';
                }
            }
        };

        // Real-time character counters and validations
        Object.keys(fields).forEach(key => {
            const field = fields[key];
            const input = field.el;

            // Character counter trigger if exist
            if (field.counter) {
                const updateCounter = () => {
                    const count = input.value.length;
                    field.counter.textContent = count;
                    if (count > 0) {
                        field.counter.classList.add('text-[#6BA53A]', 'font-bold');
                    } else {
                        field.counter.classList.remove('text-[#6BA53A]', 'font-bold');
                    }
                };
                updateCounter();
                input.addEventListener('input', updateCounter);
            }

            const handleValidate = () => {
                // Clear server error for this field
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

        let isSubmittingConfirmed = false;

        // Submit listener
        form.addEventListener('submit', function(e) {
            if (isSubmittingConfirmed) {
                return;
            }

            e.preventDefault();

            let isFormValid = true;
            let firstInvalidInput = null;

            Object.keys(fields).forEach(key => {
                const field = fields[key];
                const input = field.el;
                if (!input) return;

                const errMessage = field.validate(input.value);

                if (errMessage) {
                    isFormValid = false;
                    if (field.error) {
                        field.error.textContent = errMessage;
                        field.error.classList.remove('hidden');
                    }
                    input.classList.remove('input-valid');
                    input.classList.add('input-invalid');

                    // Apply shake effect
                    input.classList.remove('field-shake');
                    void input.offsetWidth;
                    input.classList.add('field-shake');

                    if (!firstInvalidInput) {
                        firstInvalidInput = input;
                    }
                }
            });

            if (!isFormValid) {
                if (firstInvalidInput) {
                    firstInvalidInput.focus();
                    firstInvalidInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return;
            }

            const tituloProyecto = fields.titulo.el ? fields.titulo.el.value.trim() : '';

            if (document.activeElement) {
                document.activeElement.blur();
            }

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: '¿Confirmar Registro de Proyecto?',
                    html: `<p class="text-sm text-gray-600 mb-2">¿Estás seguro de dar de alta el proyecto <strong>${tituloProyecto}</strong>?</p><p class="text-xs text-gray-500 bg-green-50 p-2.5 rounded-xl border border-green-100 mt-2">El proyecto estará disponible inmediatamente en el catálogo.</p>`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#4E7D24',
                    cancelButtonColor: '#9CA3AF',
                    confirmButtonText: 'Sí, registrar proyecto',
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
                        isSubmittingConfirmed = true;
                        form.submit();
                    }
                });
            } else {
                if (confirm(`¿Estás seguro de registrar el proyecto ${tituloProyecto}?`)) {
                    isSubmittingConfirmed = true;
                    form.submit();
                }
            }
        });
    });
</script>
        </div>
    </div>
</div>
