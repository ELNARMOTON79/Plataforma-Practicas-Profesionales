@extends('layouts.estudiante', ['active' => 'nueva-solicitud'])

@section('header')
<header class="bg-white border-b border-gray-200 px-6 py-5 flex items-center justify-between shrink-0">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Bienvenido, Juan Pérez Alumno</h1>
        <p class="text-sm text-gray-500 mt-0.5">Ingeniería en Software — Matrícula: 20191234</p>
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
                <!-- Circular Step Progress Indicator -->
                <div class="relative flex items-center justify-between w-full max-w-md mx-auto mt-4 mb-12">
                    <!-- Line segment background -->
                    <div class="absolute left-[25%] right-[25%] top-6 h-[2px] bg-gray-200 z-0"></div>
                    
                    <!-- Line segment active (Paso 1 is active, so progress line is 0% active) -->
                    <div class="absolute left-[25%] top-6 h-[2px] bg-[#8cc772] z-0 transition-all duration-300" style="width: 0%;"></div>

                    <!-- Step 1 (Active) -->
                    <div class="relative z-10 flex flex-col items-center w-1/2">
                        <div class="flex items-center justify-center w-12 h-12 rounded-full border-2 border-[#8cc772] bg-white text-[#4E7D24] shadow-sm transition-all duration-200">
                            <!-- Ícono de Empresa (Edificio) -->
                            <svg class="w-5 h-5 text-[#6BA53A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <span class="mt-3 text-xs sm:text-sm font-semibold text-[#6BA53A] text-center max-w-[140px] leading-tight">Informacion de la Empresa</span>
                    </div>

                    <!-- Step 2 (Inactive) -->
                    <div class="relative z-10 flex flex-col items-center w-1/2">
                        <div class="flex items-center justify-center w-12 h-12 rounded-full border border-gray-300 bg-white text-gray-400 transition-all duration-200">
                            <!-- Ícono de Detalles (Documento) -->
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span class="mt-3 text-xs sm:text-sm font-medium text-gray-400 text-center max-w-[140px] leading-tight">Detalles de la Practica</span>
                    </div>
                </div>

                <form action="{{ route('estudiante.nuevaSolicitudDetalles') }}" method="GET" class="mt-6 space-y-6">
                    @if(isset($unidadSelected) && $unidadSelected)
                        <input type="hidden" name="ur_id" value="{{ $unidadSelected->id }}" />
                    @endif
                    <div class="grid gap-5">
                        <!-- Nombre de la Empresa -->
                        <div class="space-y-2">
                            <div class="relative">
                                <input type="text" name="empresa_nombre" value="{{ old('empresa_nombre', $unidadSelected?->nombre_empresa ?? request('empresa_nombre', '')) }}" placeholder="Buscar empresa..." class="w-full rounded-xl border {{ (isset($unidadSelected) && $unidadSelected && $unidadSelected->nombre_empresa) ? 'bg-gray-100/80 border-gray-300 text-gray-600 font-semibold cursor-not-allowed select-none' : 'border-gray-200 bg-white text-gray-700' }} py-3 pl-4 pr-11 text-sm shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all" {{ (isset($unidadSelected) && $unidadSelected && $unidadSelected->nombre_empresa) ? 'readonly' : '' }} required />
                                <span class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <!-- Dirección de la Empresa -->
                        <div class="space-y-2">
                            <label class="flex items-center justify-between text-sm font-semibold text-gray-700">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    Dirección de la Empresa <span class="text-red-500">*</span>
                                </span>
                            </label>
                            <div>
                                <input type="text" name="empresa_direccion" value="{{ old('empresa_direccion', $unidadSelected?->direccion ?? request('empresa_direccion', '')) }}" placeholder="Ej: Miguel de la Madrid #22" class="w-full rounded-xl border {{ (isset($unidadSelected) && $unidadSelected && $unidadSelected->direccion) ? 'bg-gray-100/80 border-gray-300 text-gray-600 font-semibold cursor-not-allowed select-none' : 'border-gray-200 bg-white text-gray-700' }} py-3 px-4 text-sm shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all" {{ (isset($unidadSelected) && $unidadSelected && $unidadSelected->direccion) ? 'readonly' : '' }} required />
                            </div>
                        </div>

                        <!-- Nombre del Supervisor & Teléfono del Supervisor -->
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="space-y-2">
                                <label class="flex items-center justify-between text-sm font-semibold text-gray-700">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        Nombre del Supervisor <span class="text-red-500">*</span>
                                    </span>
                                </label>
                                <input type="text" name="supervisor_nombre" value="{{ old('supervisor_nombre', $unidadSelected?->titular ?? request('supervisor_nombre', '')) }}" placeholder="Nombre completo" class="w-full rounded-xl border {{ (isset($unidadSelected) && $unidadSelected && $unidadSelected->titular) ? 'bg-gray-100/80 border-gray-300 text-gray-600 font-semibold cursor-not-allowed select-none' : 'border-gray-200 bg-white text-gray-700' }} py-3 px-4 text-sm shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all" {{ (isset($unidadSelected) && $unidadSelected && $unidadSelected->titular) ? 'readonly' : '' }} required />
                            </div>
                            <div class="space-y-2">
                                <label class="flex items-center justify-between text-sm font-semibold text-gray-700">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        Teléfono del Supervisor
                                    </span>
                                </label>
                                <input type="tel" name="supervisor_telefono" value="{{ old('supervisor_telefono', $unidadSelected?->telefono ?? request('supervisor_telefono', '')) }}" placeholder="(809) 123-4567" class="w-full rounded-xl border {{ (isset($unidadSelected) && $unidadSelected && $unidadSelected->telefono) ? 'bg-gray-100/80 border-gray-300 text-gray-600 font-semibold cursor-not-allowed select-none' : 'border-gray-200 bg-white text-gray-700' }} py-3 px-4 text-sm shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all" {{ (isset($unidadSelected) && $unidadSelected && $unidadSelected->telefono) ? 'readonly' : '' }} />
                            </div>
                        </div>

                        <!-- Email del Supervisor -->
                        <div class="space-y-2">
                            <label class="flex items-center justify-between text-sm font-semibold text-gray-700">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    Email del Supervisor <span class="text-red-500">*</span>
                                </span>
                            </label>
                            <input type="email" name="supervisor_email" value="{{ old('supervisor_email', $unidadSelected?->user?->correo ?? request('supervisor_email', '')) }}" placeholder="supervisor@empresa.com" class="w-full rounded-xl border {{ (isset($unidadSelected) && $unidadSelected && ($unidadSelected->user?->correo || request('supervisor_email'))) ? 'bg-gray-100/80 border-gray-300 text-gray-600 font-semibold cursor-not-allowed select-none' : 'border-gray-200 bg-white text-gray-700' }} py-3 px-4 text-sm shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all" {{ (isset($unidadSelected) && $unidadSelected && ($unidadSelected->user?->correo || request('supervisor_email'))) ? 'readonly' : '' }} required />
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-end items-center pt-4">
                        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#4E7D24] hover:bg-[#3b6620] px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-250 cursor-pointer">
                            Siguiente <span class="ml-2 font-bold">&gt;</span>
                        </button>
                    </div>
                </form>
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
