@extends('layouts.estudiante', ['title' => 'Mi Perfil - Prácticas Profesionales UdeC', 'active' => ''])

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

            {{-- Edit / Save / Cancel buttons --}}
            <div class="flex items-center gap-2 shrink-0">
                <button type="button" id="edit-btn" onclick="enableEdit()"
                    class="flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Editar perfil
                </button>
                <div id="form-actions" class="hidden items-center gap-2">
                    <button type="button" onclick="cancelEdit()"
                        class="rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-semibold text-gray-600 shadow-sm hover:bg-gray-50 transition-all">
                        Cancelar
                    </button>
                    <button type="button" onclick="submitPerfilForm()"
                        class="flex items-center gap-2 rounded-xl bg-[#4E7D24] px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#3b6620] transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Guardar cambios
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Personal information form --}}
    <div class="glass-card rounded-3xl p-8 fade-in-up delay-100">
        <div class="mb-6 pb-4 border-b border-gray-100">
            <h2 class="text-base font-bold text-gray-900">Información Personal</h2>
            <p class="text-sm text-gray-500 mt-0.5">Actualiza tu nombre, teléfono y dirección.</p>
        </div>

        <form id="perfil-form" method="POST" action="{{ route('estudiante.updatePerfil') }}">
            @csrf
            <div class="grid gap-6 sm:grid-cols-2">
                {{-- Nombre --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                        Nombre(s) <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </span>
                        <input name="primerNombre" id="primerNombre" type="text" value="{{ $primerNombre }}"
                            maxlength="100" disabled
                            class="field w-full rounded-2xl border border-gray-200 bg-gray-50/80 pl-10 pr-4 py-3 text-sm text-gray-800 font-medium transition-all focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/20 focus:border-[#6BA53A]" />
                    </div>
                    <p id="error-primerNombre" class="hidden mt-1.5 text-xs text-red-500 font-medium"></p>
                </div>

                {{-- Apellidos --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Apellidos</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </span>
                        <input name="apellidos" id="apellidos" type="text" value="{{ $apellidos }}"
                            maxlength="100" disabled
                            class="field w-full rounded-2xl border border-gray-200 bg-gray-50/80 pl-10 pr-4 py-3 text-sm text-gray-800 font-medium transition-all focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/20 focus:border-[#6BA53A]" />
                    </div>
                    <p id="error-apellidos" class="hidden mt-1.5 text-xs text-red-500 font-medium"></p>
                </div>

                {{-- Correo (read-only always) --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Correo Electrónico</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </span>
                        <input type="email" value="{{ $correo }}" disabled
                            class="w-full rounded-2xl border border-gray-100 bg-gray-100/60 pl-10 pr-4 py-3 text-sm text-gray-400 font-medium cursor-not-allowed" />
                    </div>
                    <p class="mt-1.5 text-[11px] text-gray-400">El correo institucional no puede modificarse.</p>
                </div>

                {{-- Teléfono --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Teléfono</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </span>
                        <input name="telefono" id="telefono" type="text" value="{{ $telefono ?? '' }}"
                            maxlength="10" placeholder="Ej: 3121234567" inputmode="numeric" disabled
                            class="field w-full rounded-2xl border border-gray-200 bg-gray-50/80 pl-10 pr-4 py-3 text-sm text-gray-800 font-medium transition-all focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/20 focus:border-[#6BA53A]" />
                    </div>
                    <p id="error-telefono" class="hidden mt-1.5 text-xs text-red-500 font-medium"></p>
                </div>

                {{-- Dirección (full width) --}}
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Dirección</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </span>
                        <input name="direccion" id="direccion" type="text" value="{{ $direccion ?? '' }}"
                            maxlength="500" disabled
                            class="field w-full rounded-2xl border border-gray-200 bg-gray-50/80 pl-10 pr-4 py-3 text-sm text-gray-800 font-medium transition-all focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/20 focus:border-[#6BA53A]" />
                    </div>
                    <div class="flex items-center justify-between mt-1.5">
                        <p id="error-direccion" class="hidden text-xs text-red-500 font-medium"></p>
                        <p id="count-direccion" class="text-[11px] text-gray-400 ml-auto"></p>
                    </div>
                </div>
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
    var editableIds = ['primerNombre', 'apellidos', 'telefono', 'direccion'];

    // ── Validation rules ──────────────────────────────────────────────────────
    var LETTER_PATTERN = /^[À-ɏñÑa-zA-Z\s'\-]+$/;
    var PHONE_PATTERN  = /^\d{10}$/;

    var rules = {
        primerNombre: function(v) {
            if (!v.trim())               return 'El nombre es obligatorio.';
            if (v.trim().length < 2)     return 'El nombre debe tener al menos 2 caracteres.';
            if (v.trim().length > 100)   return 'El nombre no puede superar los 100 caracteres.';
            if (!LETTER_PATTERN.test(v)) return 'El nombre solo puede contener letras y espacios.';
            return null;
        },
        apellidos: function(v) {
            if (!v.trim()) return null; // optional
            if (v.trim().length < 2)     return 'Los apellidos deben tener al menos 2 caracteres.';
            if (v.trim().length > 100)   return 'Los apellidos no pueden superar los 100 caracteres.';
            if (!LETTER_PATTERN.test(v)) return 'Los apellidos solo pueden contener letras y espacios.';
            return null;
        },
        telefono: function(v) {
            if (!v.trim()) return null; // optional
            if (!PHONE_PATTERN.test(v.trim())) return 'El teléfono debe tener exactamente 10 dígitos.';
            return null;
        },
        direccion: function(v) {
            if (v.length > 500) return 'La dirección no puede superar los 500 caracteres.';
            return null;
        },
    };

    // ── Field state helpers ───────────────────────────────────────────────────
    function setError(id, msg) {
        var input = document.getElementById(id);
        var errEl = document.getElementById('error-' + id);
        if (input) {
            input.classList.remove('border-gray-200', 'border-green-400');
            input.classList.add('border-red-400');
        }
        if (errEl) {
            errEl.textContent = msg;
            errEl.classList.remove('hidden');
        }
    }

    function clearError(id) {
        var input = document.getElementById(id);
        var errEl = document.getElementById('error-' + id);
        if (input) {
            input.classList.remove('border-red-400', 'border-gray-200');
            input.classList.add('border-green-400');
        }
        if (errEl) {
            errEl.textContent = '';
            errEl.classList.add('hidden');
        }
    }

    function resetFieldState(id) {
        var input = document.getElementById(id);
        var errEl = document.getElementById('error-' + id);
        if (input) {
            input.classList.remove('border-red-400', 'border-green-400');
            input.classList.add('border-gray-200');
        }
        if (errEl) {
            errEl.textContent = '';
            errEl.classList.add('hidden');
        }
    }

    function validateField(id) {
        var el = document.getElementById(id);
        if (!el || el.disabled) return true;
        var rule = rules[id];
        if (!rule) return true;
        var msg = rule(el.value);
        if (msg) { setError(id, msg); return false; }
        clearError(id);
        return true;
    }

    function validateAll() {
        return editableIds.map(validateField).every(Boolean);
    }

    // ── Real-time validation listeners ────────────────────────────────────────
    editableIds.forEach(function(id) {
        var el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('input', function() {
            // Strip non-digits from phone field in real time
            if (id === 'telefono') {
                var pos = el.selectionStart;
                var clean = el.value.replace(/\D/g, '').slice(0, 10);
                if (el.value !== clean) { el.value = clean; el.setSelectionRange(pos, pos); }
            }
            if (!el.disabled) validateField(id);
            // character counter for direccion
            if (id === 'direccion') {
                var counter = document.getElementById('count-direccion');
                if (counter) counter.textContent = el.value.length + ' / 500';
            }
        });
        el.addEventListener('blur', function() {
            if (!el.disabled) validateField(id);
        });
    });

    // ── Edit / Cancel / Submit ────────────────────────────────────────────────
    function enableEdit() {
        document.getElementById('edit-btn').classList.add('hidden');
        document.getElementById('form-actions').style.display = 'flex';
        editableIds.forEach(function(id) {
            var el = document.getElementById(id);
            if (!el) return;
            el.disabled = false;
            el.classList.remove('bg-gray-50/80');
            el.classList.add('bg-white', 'shadow-sm');
            resetFieldState(id);
        });
        // show char counter for direccion
        var dir = document.getElementById('direccion');
        var counter = document.getElementById('count-direccion');
        if (dir && counter) counter.textContent = dir.value.length + ' / 500';
    }

    function cancelEdit() {
        location.reload();
    }

    function submitPerfilForm() {
        if (!validateAll()) return; // stop if client errors exist

        var form = document.getElementById('perfil-form');
        var btn  = document.querySelector('[onclick="submitPerfilForm()"]');
        if (btn) { btn.disabled = true; btn.textContent = 'Guardando...'; }

        fetch(form.action, {
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
                    // Show server validation errors on the fields
                    if (data.errors) {
                        Object.keys(data.errors).forEach(function(key) {
                            setError(key, data.errors[key][0]);
                        });
                    }
                    throw { validation: true };
                });
            }
            if (!resp.ok) throw {};
            return resp.json();
        })
        .then(function(json) {
            if (!json.success) return;

            // Update avatar and name in hero
            var avatar   = document.getElementById('avatar');
            var heroName = document.getElementById('hero-name');
            if (avatar)   avatar.textContent   = json.iniciales || '';
            if (heroName) heroName.textContent  = json.nombre   || '';

            // Return to read mode
            document.getElementById('edit-btn').classList.remove('hidden');
            document.getElementById('form-actions').style.display = 'none';
            editableIds.forEach(function(id) {
                var el = document.getElementById(id);
                if (!el) return;
                el.disabled = true;
                el.classList.add('bg-gray-50/80');
                el.classList.remove('bg-white', 'shadow-sm');
                resetFieldState(id);
            });
            document.getElementById('count-direccion').textContent = '';
            showSuccessModal();
        })
        .catch(function(err) {
            if (!err || !err.validation) form.submit(); // fallback for network errors
        })
        .finally(function() {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Guardar cambios';
            }
        });
    }

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

</script>
