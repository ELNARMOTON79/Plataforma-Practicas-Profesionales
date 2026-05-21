@extends('layouts.estudiante', ['active' => 'dashboard'])

@section('header')
<header class="bg-white border-b border-gray-200 px-6 py-5 flex items-center justify-between shrink-0">
    <div>
        <h1 id="welcome-name" class="text-xl font-bold text-gray-900">Bienvenido, {{ $nombre }}</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ $carrera }} - Matrícula: {{ $matricula }}</p>
    </div>
    <div class="flex items-center gap-4">
        <div class="relative">
            <button type="button" onclick="toggleProfileMenu()" class="flex items-center gap-2.5 pl-2 border-l border-gray-200 text-gray-900 hover:text-gray-700 transition-colors rounded-md hover:bg-gray-100 hover:shadow-sm" aria-haspopup="true" aria-expanded="false">
                <div id="header-iniciales" class="w-9 h-9 rounded-full bg-[#4E7D24] flex items-center justify-center text-white text-sm font-bold shrink-0">
                    {{ $iniciales }}
                </div>
                <span class="text-sm font-semibold text-gray-800 hidden sm:block">{{ $nombre }}</span>
            </button>

            <div id="profile-menu" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-100 z-50">
                <div class="p-4 border-b">
                    <p class="text-sm font-semibold text-gray-900">{{ $nombre }}</p>
                    <p class="text-xs text-gray-500">{{ $carrera }}</p>
                </div>
                <a href="{{ route('estudiante.miPerfil') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">Mi Perfil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-gray-50">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </div>
</header>
@endsection

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
    <div class="space-y-6">
        @if(session('success'))
            <div class="rounded-lg bg-green-50 border border-green-100 p-4 text-sm text-green-800">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="rounded-lg bg-red-50 border border-red-100 p-4 text-sm text-red-800">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="rounded-[32px] bg-white p-8 shadow-sm border border-gray-200">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Mi Perfil</h2>
                    <p class="mt-2 text-sm text-gray-500">Administra tu información personal y preferencias</p>
                </div>
            </div>

            <div class="mt-6 flex flex-wrap items-center gap-3 rounded-3xl border border-gray-200 bg-gray-50 p-3">
                <a href="#" class="rounded-full bg-white px-4 py-2 text-sm font-semibold text-[#111827] shadow-sm">Datos Personales</a>
                <a href="#" class="rounded-full px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-white hover:shadow-sm">Datos Académicos</a>
                <a href="#" class="rounded-full px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-white hover:shadow-sm">Seguridad</a>
                <a href="#" class="rounded-full px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-white hover:shadow-sm">Notificaciones</a>
            </div>
        </div>

        <div class="rounded-[32px] bg-white p-6 shadow-sm border border-gray-200">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex items-center gap-4">
                    <div id="card-iniciales" class="flex h-20 w-20 items-center justify-center rounded-full bg-[#4E7D24] text-2xl font-bold text-white">{{ $iniciales }}</div>
                    <div>
                        <p id="card-name" class="text-xl font-bold text-gray-900">{{ $nombre }}</p>
                        <p class="text-sm text-gray-500">{{ $carrera }}</p>
                        <p class="text-sm text-gray-500 mt-1">Matrícula: {{ $matricula }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button id="edit-btn" type="button" onclick="enableEdit()" class="rounded-xl border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">Editar</button>
                    <div id="form-actions" class="hidden gap-2">
                        <button id="cancel-btn" type="button" onclick="cancelEdit()" class="rounded-xl border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">Cancelar</button>
                            <button id="save-btn" type="button" onclick="submitPerfilForm()" class="rounded-xl border border-transparent bg-[#4E7D24] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#3b6620]">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <form id="perfil-form" method="POST" action="{{ route('estudiante.updatePerfil') }}">
            @csrf
            <div class="rounded-[32px] bg-white p-6 shadow-sm border border-gray-200">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">Información Personal</h3>
                        <p class="mt-2 text-sm text-gray-500">Actualiza tu información de contacto.</p>
                    </div>
                </div>

                <div class="mt-8 space-y-6">
                    <div class="grid gap-6 lg:grid-cols-2">
                        <div>
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-500">👤</span>
                                Nombre(s)
                            </label>
                            <input name="primerNombre" id="primerNombre" type="text" value="{{ $primerNombre }}" disabled class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700" />
                        </div>
                        <div>
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-500">👤</span>
                                Apellidos
                            </label>
                            <input name="apellidos" id="apellidos" type="text" value="{{ $apellidos }}" disabled class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700" />
                        </div>
                    </div>

                    <div class="grid gap-6 lg:grid-cols-2">
                        <div>
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-500">✉️</span>
                                Correo Electrónico
                            </label>
                            <input type="email" value="{{ $correo }}" disabled class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700" />
                            <p class="mt-2 text-xs text-gray-400">El correo institucional no puede modificarse.</p>
                        </div>
                        <div>
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-500">📞</span>
                                Teléfono
                            </label>
                            <input name="telefono" id="telefono" type="text" value="{{ $telefono ?? '' }}" disabled class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700" />
                        </div>
                    </div>

                    <div>
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-2">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-500">📍</span>
                            Dirección
                        </label>
                        <input name="direccion" id="direccion" type="text" value="{{ $direccion ?? '' }}" disabled class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

<script>
function enableEdit() {
    document.getElementById('edit-btn').classList.add('hidden');
    document.getElementById('form-actions').classList.remove('hidden');
    ['primerNombre','apellidos','telefono','direccion'].forEach(function(id){
        var el = document.getElementById(id);
        if(!el) return;
        el.disabled = false;
        el.classList.remove('bg-gray-50');
        el.classList.add('bg-white');
    });
}

function cancelEdit() {
    if(confirm('¿Deseas cancelar los cambios?')) {
        location.reload();
    }
}

function submitPerfilForm() {
    var form = document.getElementById('perfil-form');
    if (!form) return;

    // Submit via AJAX so we can update the UI immediately
    var url = form.action;
    var formData = new FormData(form);

    fetch(url, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
        },
        body: formData,
    }).then(function(resp){
        if (!resp.ok) throw resp;
        return resp.json();
    }).then(function(json){
        if (json.success) {
            // update DOM: names and initials
            var welcome = document.getElementById('welcome-name');
            if (welcome) welcome.textContent = 'Bienvenido, ' + (json.nombre || '');
            var cardName = document.getElementById('card-name');
            if (cardName) cardName.textContent = json.nombre || '';
            var headerInit = document.getElementById('header-iniciales');
            if (headerInit) headerInit.textContent = json.iniciales || '';
            var cardInit = document.getElementById('card-iniciales');
            if (cardInit) cardInit.textContent = json.iniciales || '';

            // show success alert
            alert('Perfil guardado correctamente.');
            // disable edit mode
            document.getElementById('edit-btn').classList.remove('hidden');
            document.getElementById('form-actions').classList.add('hidden');
            ['primerNombre','apellidos','telefono','direccion'].forEach(function(id){
                var el = document.getElementById(id);
                if(!el) return;
                el.disabled = true;
                el.classList.remove('bg-white');
                el.classList.add('bg-gray-50');
            });
        }
    }).catch(function(err){
        // fallback to normal submit on error
        console.error(err);
        form.submit();
    });
}
</script>
