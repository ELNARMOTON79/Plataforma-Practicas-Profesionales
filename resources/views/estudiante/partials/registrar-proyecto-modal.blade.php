<!-- Modal: Registrar Proyecto -->
<div id="modal-registrar-proyecto" class="fixed inset-0 z-50 overflow-y-auto {{ $errors->any() ? '' : 'hidden' }}" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-950/60 backdrop-blur-md transition-opacity duration-300"
         onclick="document.getElementById('modal-registrar-proyecto').classList.add('hidden')"></div>

    <!-- Modal Positioning -->
    <div class="rp-wrap flex min-h-screen items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="rp-dialog relative bg-white rounded-3xl shadow-2xl w-full max-w-3xl mx-auto overflow-hidden transform transition-all duration-300 scale-100 max-h-[90vh] flex flex-col">
            
            <!-- Header (Gradient Green Banner) -->
            <div class="rp-header bg-gradient-to-r from-[#4E7D24] to-[#6BA53A] px-8 py-6 relative flex flex-col items-center justify-center text-center flex-shrink-0">
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
                    <h2 id="modal-title" class="text-xl font-bold text-white leading-tight">{{ isset($proyectoPrevio) ? 'Corregir Proyecto' : 'Registrar Nuevo Proyecto' }}</h2>
                </div>
                <p class="text-green-100 text-xs">Completa los campos del proyecto que realizarás en tu empresa</p>
            </div>
            {{-- Layout propio del modal: no depende de clases de Tailwind que no estén compiladas --}}
            <style>
                #modal-registrar-proyecto .rp-wrap { display: flex; min-height: 100vh; align-items: center; justify-content: center; padding: 1.5rem; }
                #modal-registrar-proyecto .rp-dialog { width: 100%; max-width: 760px; max-height: 90vh; margin: 0 auto; display: flex; flex-direction: column; }
                #modal-registrar-proyecto .rp-header { padding: 1.25rem 2rem; position: relative; }
                #modal-registrar-proyecto .rp-header > button { position: absolute; top: 1rem; right: 1rem; }
                #modal-registrar-proyecto .rp-body { padding: 1.5rem 2rem; overflow-y: auto; flex: 1 1 auto; min-height: 0; }
                #modal-registrar-proyecto .rp-body > * + * { margin-top: 1.1rem; }
                #modal-registrar-proyecto .rp-grid { display: grid; grid-template-columns: 1fr; gap: 1rem; }
                @media (min-width: 768px) {
                    #modal-registrar-proyecto .rp-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
                }
                #modal-registrar-proyecto .rp-grid > * { margin-top: 0; }
                #modal-registrar-proyecto label { margin-bottom: 0.4rem; }
                #modal-registrar-proyecto input[type="text"],
                #modal-registrar-proyecto select,
                #modal-registrar-proyecto textarea { padding: 0.65rem 1rem; border-radius: 0.75rem; }
                #modal-registrar-proyecto select { -webkit-appearance: none; -moz-appearance: none; appearance: none; padding-right: 2.5rem; background-image: none; }                #modal-registrar-proyecto .rp-footer { padding-top: 1.25rem; margin-top: 1.25rem; gap: 0.75rem; }
                #modal-registrar-proyecto .rp-footer button { padding: 0.6rem 1.4rem; border-radius: 0.75rem; }
            </style>
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
            <form id="form-registrar-proyecto" action="{{ route('estudiante.registrarProyecto') }}" method="POST" hx-boost="false" class="rp-body px-8 py-6 space-y-5 overflow-y-auto scrollbar-thin flex-1">
                @csrf

                <h4 class="text-md font-bold text-[#4E7D24] border-b border-gray-100 pb-2 text-center mb-2">Información del Proyecto</h4>

                <!-- 1. Unidad Receptora (la de la solicitud activa del alumno) -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Unidad Receptora / Institución</label>
                    <div class="block w-full px-4 py-3 bg-[#6BA53A]/5 border border-[#6BA53A]/30 rounded-xl text-sm font-semibold text-gray-800">
                        {{ strtoupper($solicitudActiva->unidadReceptora?->nombre_empresa ?? 'Sin empresa') }}{{ !empty($solicitudActiva->unidadReceptora?->unidad_receptora) ? ' — ' . $solicitudActiva->unidadReceptora->unidad_receptora : '' }}
                    </div>
                    <p class="text-[11px] text-gray-400 mt-1">Tomada de tu solicitud de prácticas. El proyecto quedará asignado a ti.</p>
                </div>

                <!-- 2. Título -->
                <div>
                    <label for="reg-titulo" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Título del Proyecto <span class="text-red-500">*</span></label>
                    <input type="text" id="reg-titulo" name="titulo" required value="{{ old('titulo', ($proyectoPrevio ?? null)?->titulo) }}" placeholder="Ej. PLATAFORMA WEB PARA ADMINISTRACIÓN DE PRÁCTICAS..." class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400 shadow-sm transition-all @error('titulo') border-red-400 bg-red-50 @enderror">
                    <p id="error-reg-titulo" class="text-red-500 text-xs mt-1 font-semibold hidden"></p>
                    @error('titulo')
                        <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Grid for 2-column inputs -->
                <div class="rp-grid grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Tipo de Proyecto Select -->
                    <div>
                        <label for="reg-tipo-proyecto" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Tipo de Proyecto <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select id="reg-tipo-proyecto" name="tipo_proyecto" required class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 shadow-sm transition-all appearance-none cursor-pointer @error('tipo_proyecto') border-red-400 bg-red-50 @enderror">
                                <option value="">Selecciona el tipo...</option>
                                <option value="Desarrollo Tecnológico" {{ old('tipo_proyecto', ($proyectoPrevio ?? null)?->tipo_proyecto) == 'Desarrollo Tecnológico' ? 'selected' : '' }}>Desarrollo Tecnológico</option>
                                <option value="Investigación" {{ old('tipo_proyecto', ($proyectoPrevio ?? null)?->tipo_proyecto) == 'Investigación' ? 'selected' : '' }}>Investigación Académica</option>
                                <option value="Asistencia Social" {{ old('tipo_proyecto', ($proyectoPrevio ?? null)?->tipo_proyecto) == 'Asistencia Social' ? 'selected' : '' }}>Asistencia Social / Comunitaria</option>
                                <option value="Administrativo" {{ old('tipo_proyecto', ($proyectoPrevio ?? null)?->tipo_proyecto) == 'Administrativo' ? 'selected' : '' }}>Administrativo / Oficina</option>
                                <option value="Infraestructura" {{ old('tipo_proyecto', ($proyectoPrevio ?? null)?->tipo_proyecto) == 'Infraestructura' ? 'selected' : '' }}>Infraestructura y Redes</option>
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
                                <option value="Presencial" {{ old('tipo_modalidad', ($proyectoPrevio ?? null)?->tipo_modalidad) == 'Presencial' ? 'selected' : '' }}>Presencial</option>
                                <option value="Híbrido" {{ old('tipo_modalidad', ($proyectoPrevio ?? null)?->tipo_modalidad) == 'Híbrido' ? 'selected' : '' }}>Híbrido</option>
                                <option value="Virtual" {{ old('tipo_modalidad', ($proyectoPrevio ?? null)?->tipo_modalidad) == 'Virtual' ? 'selected' : '' }}>Virtual / Remoto</option>
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
                <div class="rp-grid grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Objetivo -->
                    <div>
                        <label for="reg-objetivo" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Objetivo del Proyecto <span class="text-red-500">*</span></label>
                        <textarea id="reg-objetivo" name="objetivo" rows="3" required maxlength="1000" placeholder="Describe brevemente la meta principal del proyecto..." class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400 shadow-sm transition-all resize-none @error('objetivo') border-red-400 bg-red-50 @enderror">{{ old('objetivo', ($proyectoPrevio ?? null)?->objetivo) }}</textarea>
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
                        <textarea id="reg-justificacion" name="justificacion" rows="3" required maxlength="1000" placeholder="¿Por qué es necesario y qué problema resuelve?..." class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400 shadow-sm transition-all resize-none @error('justificacion') border-red-400 bg-red-50 @enderror">{{ old('justificacion', ($proyectoPrevio ?? null)?->justificacion) }}</textarea>
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
                        <textarea id="reg-actividades" name="actividades" rows="3" required maxlength="1000" placeholder="Listado de tareas o funciones a realizar..." class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400 shadow-sm transition-all resize-none @error('actividades') border-red-400 bg-red-50 @enderror">{{ old('actividades', ($proyectoPrevio ?? null)?->actividades) }}</textarea>
                        <div class="flex justify-between items-center mt-1">
                            <p id="error-reg-actividades" class="text-red-500 text-[11px] font-semibold hidden"></p>
                            <div class="text-right text-[10px] text-gray-400 ml-auto"><span id="counter-reg-actividades">0</span> / 1000 carac.</div>
                        </div>
                        @error('actividades')
                            <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Impacto Social -->
                    <div>
                        <label for="reg-impacto" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Impacto Social <span class="text-red-500">*</span></label>
                        <textarea id="reg-impacto" name="impacto_social" rows="3" required maxlength="1000" placeholder="Beneficio que aporta a la comunidad o sector social..." class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400 shadow-sm transition-all resize-none @error('impacto_social') border-red-400 bg-red-50 @enderror">{{ old('impacto_social', ($proyectoPrevio ?? null)?->impacto_social) }}</textarea>
                        <div class="flex justify-between items-center mt-1">
                            <p id="error-reg-impacto" class="text-red-500 text-[11px] font-semibold hidden"></p>
                            <div class="text-right text-[10px] text-gray-400 ml-auto"><span id="counter-reg-impacto">0</span> / 1000 carac.</div>
                        </div>
                        @error('impacto_social')
                            <p class="text-red-500 text-xs mt-1 font-semibold server-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Footer Action Buttons -->
                <div class="rp-footer flex items-center justify-end gap-3 border-t border-gray-100 pt-5 mt-4">
                    <button type="button" 
                            onclick="document.getElementById('modal-registrar-proyecto').classList.add('hidden')"
                            class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-bold text-gray-500 hover:bg-gray-50 transition-all cursor-pointer">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-6 py-2.5 rounded-xl bg-[#4E7D24] text-white hover:bg-[#2E5417] text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 transform hover:-translate-y-0.5 cursor-pointer">
                        {{ isset($proyectoPrevio) ? 'Reenviar Proyecto' : 'Registrar Proyecto' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Interactive Client-side Script for Project Registration --}}
<script>
    (function () {
        const form = document.getElementById('form-registrar-proyecto');
        if (!form) return;

        // Prevent wheel/touchpad scroll from altering number inputs
        form.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('wheel', function () { this.blur(); });
        });

        const fields = {
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
                    title: '¿Confirmar registro de proyecto?',
                    // Estilos en línea: la vista del alumno no tiene compiladas todas las clases de Tailwind
                    html: '<p style="font-size:14px;color:#4b5563;margin:0 0 10px;">¿Estás seguro de registrar el proyecto <strong style="color:#111827;"></strong>?</p>' +
                          '<p style="font-size:12px;color:#4E7D24;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:10px 12px;margin:0;">El proyecto se enviará al coordinador para su revisión.</p>',
                    icon: 'question',
                    iconColor: '#6BA53A',
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonColor: '#4E7D24',
                    cancelButtonColor: '#9CA3AF',
                    confirmButtonText: 'Sí, registrar proyecto',
                    cancelButtonText: 'Revisar datos',
                    focusConfirm: false,
                    focusCancel: false,
                    didOpen: (popup) => {
                        popup.style.borderRadius = '24px';
                        popup.style.fontFamily = "'Outfit', sans-serif";
                        popup.querySelector('.swal2-html-container strong').textContent = tituloProyecto;
                        popup.querySelectorAll('.swal2-actions button').forEach((b) => {
                            b.style.borderRadius = '12px';
                            b.style.fontWeight = '700';
                            b.style.fontSize = '14px';
                            b.style.padding = '10px 20px';
                        });
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
    })();
</script>
