@extends('layouts.estudiante', ['title' => 'Mi Perfil - Prácticas Profesionales UdeC', 'active' => 'perfil'])

@section('content')


    {{-- Server-side alerts --}}
    @if(session('success'))
        <div class="rounded-2xl bg-green-50 border border-green-100 p-4 text-sm text-green-800 fade-in-up">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="rounded-2xl bg-red-50 border border-red-100 p-4 text-sm text-red-800 fade-in-up">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    {{-- Profile hero card --}}
    <div class="glass-card rounded-3xl p-8 fade-in-up">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div class="flex items-center gap-5">
                <div id="avatar" class="flex h-20 w-20 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-[#4E7D24] to-[#6BA53A] text-2xl font-extrabold text-white shadow-lg shadow-green-900/20">
                    {{ $iniciales }}
                </div>
                <div>
                    <h1 id="hero-name" class="text-2xl font-bold text-gray-900">{{ $nombre }}</h1>
                    <p class="text-sm text-gray-500 mt-0.5">{{ $carrera }}</p>
                    <span class="inline-block mt-2 text-xs font-bold text-[#4E7D24] bg-[#6BA53A]/10 border border-[#6BA53A]/20 px-3 py-1 rounded-full">
                        Matrícula: {{ $matricula }}
                    </span>
                </div>
            </div>

        </div>
    </div>

    {{-- Change password card --}}
    <div class="glass-card rounded-3xl p-8 fade-in-up delay-200">
        <div class="mb-6 pb-4 border-b border-gray-100">
            <h2 class="text-base font-bold text-gray-900">Cambiar Contraseña</h2>
            <p class="text-sm text-gray-500 mt-0.5">Ingresa tu contraseña actual y define una nueva.</p>
        </div>

        <form id="password-form" class="grid gap-5 sm:grid-cols-2">
            @csrf

            {{-- Current password --}}
            <div class="sm:col-span-2">
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                    Contraseña actual <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </span>
                    <input type="password" id="current_password" name="current_password"
                        placeholder="Tu contraseña actual"
                        class="w-full rounded-2xl border border-gray-200 bg-gray-50/80 pl-10 pr-4 py-3 text-sm text-gray-800 font-medium transition-all focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/20 focus:border-[#6BA53A]" />
                </div>
                <p id="error-current_password" class="hidden mt-1.5 text-xs text-red-500 font-medium"></p>
            </div>

            {{-- New password --}}
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                    Nueva contraseña <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                    </span>
                    <input type="password" id="new_password" name="new_password"
                        placeholder="Mínimo 8 caracteres"
                        class="w-full rounded-2xl border border-gray-200 bg-gray-50/80 pl-10 pr-4 py-3 text-sm text-gray-800 font-medium transition-all focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/20 focus:border-[#6BA53A]" />
                </div>
                <p id="error-new_password" class="hidden mt-1.5 text-xs text-red-500 font-medium"></p>
            </div>

            {{-- Confirm password --}}
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                    Confirmar contraseña <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </span>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                        placeholder="Repite la nueva contraseña"
                        class="w-full rounded-2xl border border-gray-200 bg-gray-50/80 pl-10 pr-4 py-3 text-sm text-gray-800 font-medium transition-all focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/20 focus:border-[#6BA53A]" />
                </div>
                <p id="error-new_password_confirmation" class="hidden mt-1.5 text-xs text-red-500 font-medium"></p>
            </div>

            <div class="sm:col-span-2 flex justify-end">
                <button type="button" onclick="openConfirmModal()"
                    class="flex items-center gap-2 rounded-xl bg-[#4E7D24] px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#3b6620] transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Cambiar contraseña
                </button>
            </div>
        </form>
    </div>

    {{-- Academic info (read-only) --}}
    <div class="glass-card rounded-3xl p-8 fade-in-up delay-200">
        <div class="mb-6 pb-4 border-b border-gray-100">
            <h2 class="text-base font-bold text-gray-900">Datos Académicos</h2>
            <p class="text-sm text-gray-500 mt-0.5">Información registrada en el sistema. Contacta a tu coordinador para modificarla.</p>
        </div>
        <div class="grid gap-6 sm:grid-cols-2">
            <div class="bg-gray-50/60 border border-gray-100 rounded-2xl p-4">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Matrícula</p>
                <p class="text-sm font-bold text-gray-800">{{ $matricula !== '—' ? $matricula : 'No registrada' }}</p>
            </div>
            <div class="bg-gray-50/60 border border-gray-100 rounded-2xl p-4">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Carrera</p>
                <p class="text-sm font-bold text-gray-800">{{ $carrera !== '—' ? $carrera : 'No registrada' }}</p>
            </div>
        </div>
    </div>

@endsection

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
