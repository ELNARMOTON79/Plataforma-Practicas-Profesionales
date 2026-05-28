<!-- Styles for premium validations -->
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

<!-- Seguridad y Contraseña Card -->
<div class="glass-card rounded-3xl p-6 md:p-8 bg-white/70 border border-gray-200/50 shadow-md">
    <div class="flex items-center gap-4 mb-6">
        <div class="p-3 bg-[#6BA53A]/10 rounded-2xl">
            <svg class="w-6 h-6 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-900 font-sans">Seguridad de la Cuenta</h2>
            <p class="text-xs font-semibold text-gray-500">Mantén tu cuenta protegida cambiando tu contraseña periódicamente.</p>
        </div>
    </div>

    <form id="passwordForm" action="{{ route('coordinador.perfil.password') }}" method="POST" class="space-y-6">
        @csrf
        <!-- Contraseña Actual -->
        <div class="space-y-2 max-w-md">
            <label for="current_password" class="text-xs font-bold text-gray-700 ml-1 uppercase tracking-wider">Contraseña Actual <span class="text-red-500">*</span></label>
            <div class="relative">
                <input 
                    type="password" 
                    id="current_password" 
                    name="current_password" 
                    required
                    class="w-full bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] block p-3.5 pr-11 transition-all outline-none"
                >
                <button type="button" onclick="togglePasswordVisibility('current_password', this)" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-[#4E7D24] transition-colors focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <p id="error-current-password" class="text-red-500 text-xs mt-1 font-semibold hidden"></p>
        </div>

        <!-- Nueva Contraseña + Confirmar -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nueva Contraseña -->
            <div class="space-y-2">
                <label for="new_password" class="text-xs font-bold text-gray-700 ml-1 uppercase tracking-wider">Nueva Contraseña <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input 
                        type="password" 
                        id="new_password" 
                        name="password" 
                        required
                        placeholder="Mínimo 8 caracteres"
                        class="w-full bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] block p-3.5 pr-11 transition-all outline-none"
                    >
                    <button type="button" onclick="togglePasswordVisibility('new_password', this)" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-[#4E7D24] transition-colors focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                <p id="error-new-password" class="text-red-500 text-xs mt-1 font-semibold hidden"></p>
            </div>

            <!-- Confirmar Contraseña -->
            <div class="space-y-2">
                <label for="password_confirmation" class="text-xs font-bold text-gray-700 ml-1 uppercase tracking-wider">Confirmar Nueva Contraseña <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        required
                        placeholder="Mínimo 8 caracteres"
                        class="w-full bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] block p-3.5 pr-11 transition-all outline-none"
                    >
                    <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-[#4E7D24] transition-colors focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                <p id="error-password-confirmation" class="text-red-500 text-xs mt-1 font-semibold hidden"></p>
            </div>
        </div>

        <div class="flex justify-end pt-2">
            <button type="button" onclick="confirmPasswordChange()" class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-6 py-3 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 transform hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Actualizar Contraseña
            </button>
        </div>
    </form>
</div>

<!-- MODAL: Confirmation for Password Change -->
@push('modals')
    <div id="passwordModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-sm hidden transition-opacity duration-300">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 md:p-8 shadow-2xl border border-gray-100 flex flex-col gap-6 transform scale-95 transition-transform duration-300">
            <div class="flex items-center gap-4 text-[#4E7D24]">
                <div class="p-3 bg-[#6BA53A]/10 rounded-2xl">
                    <svg class="w-6 h-6 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">¿Confirmar cambio?</h3>
            </div>

            <p class="text-sm font-medium text-gray-600 leading-relaxed">
                ¿Estás seguro de que deseas actualizar tu contraseña? Se cerrará tu sesión actual en otros dispositivos y deberás ingresar con tus nuevas credenciales en tu próximo inicio de sesión.
            </p>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal('passwordModal')" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-xl text-sm font-bold transition-all">
                    Cancelar
                </button>
                <button type="button" onclick="submitPasswordForm()" class="bg-[#4E7D24] hover:bg-[#2E5417] text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md transition-all">
                    Sí, cambiar contraseña
                </button>
            </div>
        </div>
    </div>
@endpush

<!-- Script Block for Operations & Real-time Interactive Validations -->
<script>
    // Modal Helpers
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        modal.classList.remove('hidden');
        setTimeout(() => {
            if (modal.firstElementChild) {
                modal.firstElementChild.classList.remove('scale-95');
                modal.firstElementChild.classList.add('scale-100');
            }
        }, 10);
    }
    window.openModal = openModal;

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        if (modal.firstElementChild) {
            modal.firstElementChild.classList.remove('scale-100');
            modal.firstElementChild.classList.add('scale-95');
        }
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 150);
    }
    window.closeModal = closeModal;

    // Password confirmation helper
    function confirmPasswordChange() {
        const form = document.getElementById('passwordForm');
        if (!form) return;

        // Trigger client side validation checks
        let isFormValid = true;
        let firstInvalidInput = null;

        const fields = ['current_password', 'new_password', 'password_confirmation'];
        fields.forEach(fid => {
            const input = document.getElementById(fid);
            if (input) {
                // Force a validate event check
                input.dispatchEvent(new Event('blur'));
                if (input.classList.contains('input-invalid')) {
                    isFormValid = false;
                    if (!firstInvalidInput) firstInvalidInput = input;
                }
            }
        });

        if (form.checkValidity() && isFormValid) {
            openModal('passwordModal');
        } else {
            form.reportValidity();
            if (firstInvalidInput) {
                firstInvalidInput.focus();
            }
        }
    }
    window.confirmPasswordChange = confirmPasswordChange;

    function submitPasswordForm() {
        closeModal('passwordModal');
        const form = document.getElementById('passwordForm');
        if (form) form.submit();
    }
    window.submitPasswordForm = submitPasswordForm;

    // Toggle password visibility helper
    function togglePasswordVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        if (!input) return;
        
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        
        // Toggle SVG icon
        if (isPassword) {
            // Eye slashed (closed)
            btn.innerHTML = `
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                </svg>
            `;
        } else {
            // Eye open
            btn.innerHTML = `
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            `;
        }
    }
    window.togglePasswordVisibility = togglePasswordVisibility;

    // ================= CLIENT SIDE VALIDATIONS =================
    document.addEventListener('DOMContentLoaded', function () {
        // Password Form validations
        const passwordForm = document.getElementById('passwordForm');
        if (passwordForm) {
            const passFields = {
                current: {
                    el: document.getElementById('current_password'),
                    error: document.getElementById('error-current-password'),
                    validate: (val) => !val ? 'La contraseña actual es requerida.' : ''
                },
                new: {
                    el: document.getElementById('new_password'),
                    error: document.getElementById('error-new-password'),
                    validate: (val) => {
                        if (!val) return 'La nueva contraseña es requerida.';
                        if (val.length < 8) return 'La nueva contraseña debe tener al menos 8 caracteres.';
                        
                        const currentVal = document.getElementById('current_password').value;
                        if (val === currentVal && currentVal) {
                            return 'La nueva contraseña debe ser diferente a la contraseña actual.';
                        }
                        return '';
                    }
                },
                confirmation: {
                    el: document.getElementById('password_confirmation'),
                    error: document.getElementById('error-password-confirmation'),
                    validate: (val) => {
                        if (!val) return 'Debes confirmar la nueva contraseña.';
                        
                        const newVal = document.getElementById('new_password').value;
                        if (val !== newVal) return 'La confirmación de contraseña no coincide con la nueva contraseña.';
                        return '';
                    }
                }
            };

            Object.keys(passFields).forEach(key => {
                const field = passFields[key];
                const input = field.el;

                const handleValidate = () => {
                    const err = field.validate(input.value);
                    if (err) {
                        field.error.textContent = err;
                        field.error.classList.remove('hidden');
                        input.classList.remove('input-valid');
                        input.classList.add('input-invalid');
                        return false;
                    } else {
                        field.error.textContent = '';
                        field.error.classList.add('hidden');
                        input.classList.remove('input-invalid');
                        input.classList.add('input-valid');
                        return true;
                    }
                };

                input.addEventListener('input', handleValidate);
                input.addEventListener('blur', handleValidate);
            });

            // Extra validation: Re-validate confirmation if new password changes
            passFields.new.el.addEventListener('input', () => {
                if (passFields.confirmation.el.value) {
                    passFields.confirmation.el.dispatchEvent(new Event('input'));
                }
            });

            passwordForm.addEventListener('submit', function (e) {
                let isFormValid = true;
                let firstInvalidInput = null;

                Object.keys(passFields).forEach(key => {
                    const field = passFields[key];
                    const input = field.el;
                    const err = field.validate(input.value);

                    if (err) {
                        isFormValid = false;
                        field.error.textContent = err;
                        field.error.classList.remove('hidden');
                        input.classList.remove('input-valid');
                        input.classList.add('input-invalid');

                        input.classList.remove('field-shake');
                        void input.offsetWidth;
                        input.classList.add('field-shake');

                        if (!firstInvalidInput) firstInvalidInput = input;
                    }
                });

                if (!isFormValid) {
                    e.preventDefault();
                    if (firstInvalidInput) {
                        firstInvalidInput.focus();
                    }
                }
            });
        }
    });
</script>
