@extends('layouts.estudiante', ['active' => 'nueva-solicitud'])

@section('header')
<header class="bg-white border-b border-gray-200 px-6 py-5 flex items-center justify-between shrink-0">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Bienvenido, {{ $nombre }}</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ $carrera }} — Matrícula: {{ $matricula }}</p>
    </div>
    <div class="flex items-center gap-4">
        <div class="relative">
            <button type="button" onclick="toggleProfileMenu()" class="flex items-center gap-2.5 pl-2 border-l border-gray-200 text-gray-900 hover:text-gray-700 transition-colors rounded-md hover:bg-gray-100 hover:shadow-sm" aria-haspopup="true" aria-expanded="false">
                <div class="w-9 h-9 rounded-full bg-[#4E7D24] flex items-center justify-center text-white text-sm font-bold shrink-0">
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
<div class="w-full space-y-6">
    <!-- Header / Titles -->
    <div class="text-left px-2">
        <h1 class="text-3xl font-extrabold text-gray-900">Nueva Solicitud de Practicas</h1>
        <p class="text-sm text-gray-500 mt-1">Completa el formulario para registrar tu solicitud</p>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-[32px] shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-8 sm:px-12 py-10">
            <div class="max-w-3xl mx-auto">
                @include('estudiante.solicitud._steps', ['step' => 1, 'progress' => '0%'])
                
                @include('estudiante.solicitud._form-step-1')
            </div>
        </div>
    </div>
</div>

<script>
    function autocompletarEmpresa(select) {
        const option = select.options[select.selectedIndex];
        if (!option) return;

        const nombre = option.getAttribute('data-nombre') || '';
        const direccion = option.getAttribute('data-direccion') || '';
        const titular = option.getAttribute('data-titular') || '';
        const telefono = option.getAttribute('data-telefono') || '';
        const email = option.getAttribute('data-email') || '';

        const elNombre = document.querySelector('input[name="empresa_nombre"]');
        const elDir = document.querySelector('input[name="empresa_direccion"]');
        const elSup = document.querySelector('input[name="supervisor_nombre"]');
        const elTel = document.querySelector('input[name="supervisor_telefono"]');
        const elEmail = document.querySelector('input[name="supervisor_email"]');

        const esOficial = !!option.value;

        function setCampo(el, val, lock) {
            if (!el) return;
            el.value = val;
            el.readOnly = lock && !!val;
            if (lock && !!val) {
                el.className = "w-full rounded-xl border bg-gray-100/80 border-gray-300 text-gray-600 font-semibold cursor-not-allowed select-none py-3 px-4 text-sm shadow-sm transition-all";
            } else {
                el.className = "w-full rounded-xl border border-gray-200 bg-white py-3 px-4 text-sm text-gray-700 shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all";
            }
        }

        setCampo(elNombre, nombre, esOficial);
        setCampo(elDir, direccion, esOficial);
        setCampo(elSup, titular, esOficial);
        setCampo(elTel, telefono, esOficial);
        setCampo(elEmail, email, esOficial);

        // Visual flash animation
        [elNombre, elDir, elSup, elTel, elEmail].forEach(el => {
            if (el && el.value) {
                el.classList.add('ring-2', 'ring-[#4E7D24]', 'bg-green-50/50');
                setTimeout(() => el.classList.remove('ring-2', 'ring-[#4E7D24]', 'bg-green-50/50'), 1200);
            }
        });
    }
</script>
@endsection
