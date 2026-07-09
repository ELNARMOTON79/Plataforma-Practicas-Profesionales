@push('modals')
    {{-- Confirmation modal --}}
    <div id="confirm-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; z-index:9999; background:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:20px; padding:32px 28px; text-align:center; width:300px; box-shadow:0 25px 60px rgba(0,0,0,0.2);">
            <div style="width:52px; height:52px; border-radius:50%; background:#fef9ec; border:1px solid #fde68a; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                <svg style="width:26px; height:26px;" fill="none" stroke="#d97706" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
            </div>
            <p style="font-weight:700; color:#111827; font-size:15px; margin:0 0 8px;">¿Cambiar contraseña?</p>
            <p style="color:#6b7280; font-size:13px; margin:0 0 24px;">Esta acción actualizará tu contraseña de acceso. Asegúrate de recordarla.</p>
            <div style="display:flex; gap:10px;">
                <button onclick="closeConfirmModal()" style="flex:1; padding:10px 0; border-radius:12px; border:1px solid #e5e7eb; background:#fff; font-size:13px; font-weight:600; color:#374151; cursor:pointer;">
                    Cancelar
                </button>
                <button id="confirm-btn" onclick="submitPasswordForm()" style="flex:1; padding:10px 0; border-radius:12px; border:none; background:#4E7D24; font-size:13px; font-weight:600; color:#fff; cursor:pointer;">
                    Confirmar
                </button>
            </div>
        </div>
    </div>

    <div id="success-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; z-index:9999; background:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:20px; padding:32px 28px; text-align:center; width:260px; box-shadow:0 25px 60px rgba(0,0,0,0.2);">
            <div id="modal-progress-bar" style="height:3px; background:#4E7D24; width:100%; border-radius:99px; margin-bottom:24px; transition:width 3s linear;"></div>
            <div style="width:52px; height:52px; border-radius:50%; background:#f0fdf4; border:1px solid #bbf7d0; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                <svg style="width:26px; height:26px;" fill="none" stroke="#4E7D24" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <p style="font-weight:700; color:#111827; font-size:15px; margin:0 0 6px;">¡Guardado exitosamente!</p>
            <p style="color:#9ca3af; font-size:13px; margin:0;">Tu perfil ha sido actualizado.</p>
        </div>
    </div>
@endpush

@push('scripts')
<script>
    var _modalTimer = null;

    function showSuccessModal() {
        var modal = document.getElementById('success-modal');
        var bar   = document.getElementById('modal-progress-bar');
        modal.style.display = 'flex';

        // Animate progress bar shrinking over 3 s
        if (bar) {
            bar.style.transition = 'none';
            bar.style.width = '100%';
            setTimeout(function() {
                bar.style.transition = 'width 3s linear';
                bar.style.width = '0%';
            }, 30);
        }

        if (_modalTimer) clearTimeout(_modalTimer);
        _modalTimer = setTimeout(closeSuccessModal, 3000);
    }

    function closeSuccessModal() {
        if (_modalTimer) { clearTimeout(_modalTimer); _modalTimer = null; }
        document.getElementById('success-modal').style.display = 'none';
    }

    document.getElementById('success-modal').addEventListener('click', function(e) {
        if (e.target === this) closeSuccessModal();
    });

    // ── Password change ───────────────────────────────────────────────────────
    function setPwError(id, msg) {
        var el  = document.getElementById(id);
        var err = document.getElementById('error-' + id);
        if (el)  { el.classList.add('border-red-400'); el.classList.remove('border-gray-200','border-green-400'); }
        if (err) { err.textContent = msg; err.classList.remove('hidden'); }
    }

    function clearPwError(id) {
        var el  = document.getElementById(id);
        var err = document.getElementById('error-' + id);
        if (el)  { el.classList.remove('border-red-400'); el.classList.add('border-green-400'); }
        if (err) { err.textContent = ''; err.classList.add('hidden'); }
    }

    function validatePasswordForm() {
        var ok      = true;
        var current = document.getElementById('current_password').value;
        var newPass = document.getElementById('new_password').value;
        var confirm = document.getElementById('new_password_confirmation').value;

        if (!current.trim()) { setPwError('current_password', 'La contraseña actual es obligatoria.'); ok = false; }
        else clearPwError('current_password');

        if (!newPass.trim()) { setPwError('new_password', 'La nueva contraseña es obligatoria.'); ok = false; }
        else if (newPass.length < 8) { setPwError('new_password', 'La contraseña debe tener al menos 8 caracteres.'); ok = false; }
        else clearPwError('new_password');

        if (!confirm.trim()) { setPwError('new_password_confirmation', 'Confirma la nueva contraseña.'); ok = false; }
        else if (confirm !== newPass) { setPwError('new_password_confirmation', 'Las contraseñas no coinciden.'); ok = false; }
        else clearPwError('new_password_confirmation');

        return ok;
    }

    function openConfirmModal() {
        if (!validatePasswordForm()) return;
        document.getElementById('confirm-modal').style.display = 'flex';
    }

    function closeConfirmModal() {
        document.getElementById('confirm-modal').style.display = 'none';
    }

    document.getElementById('confirm-modal').addEventListener('click', function(e) {
        if (e.target === this) closeConfirmModal();
    });

    function submitPasswordForm() {
        var btn = document.getElementById('confirm-btn');
        btn.disabled = true;
        btn.textContent = 'Guardando...';

        var form = document.getElementById('password-form');
        fetch('{{ route("estudiante.changePassword") }}', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            },
            body: new FormData(form),
        })
        .then(function(resp) {
            if (resp.status === 422) {
                return resp.json().then(function(data) {
                    if (data.errors) {
                        Object.keys(data.errors).forEach(function(key) { setPwError(key, data.errors[key][0]); });
                    }
                    throw { validation: true };
                });
            }
            if (!resp.ok) throw {};
            return resp.json();
        })
        .then(function(json) {
            if (!json.success) return;
            closeConfirmModal();
            form.reset();
            ['current_password','new_password','new_password_confirmation'].forEach(function(id) {
                var el = document.getElementById(id);
                if (el) { el.classList.remove('border-green-400','border-red-400'); el.classList.add('border-gray-200'); }
                var err = document.getElementById('error-' + id);
                if (err) { err.textContent = ''; err.classList.add('hidden'); }
            });
            showSuccessModal();
        })
        .catch(function(err) {
            closeConfirmModal();
        })
        .finally(function() {
            btn.disabled = false;
            btn.textContent = 'Confirmar';
        });
    }
</script>
@endpush
