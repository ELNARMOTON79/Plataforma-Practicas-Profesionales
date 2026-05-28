@extends('layouts.coordinador', ['active' => 'perfil', 'title' => 'Mi Perfil - Coordinador'])

@section('content')
    <!-- Header Section -->
    <x-page-header title="Configuración del Perfil" description="Visualiza tus datos personales y gestiona la seguridad de tu cuenta institucional.">
    </x-page-header>

    <!-- Success Alert -->
    @if(session('success'))
        <div id="successAlert" class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl shadow-sm flex items-center gap-3 transition-all duration-300 fade-in-up">
            <svg class="w-6 h-6 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-semibold text-sm">{{ session('success') }}</span>
            <button onclick="document.getElementById('successAlert').remove()" class="text-green-500 hover:text-green-800 transition-colors ml-auto">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    @endif

    <!-- Server Errors Alert -->
    @if($errors->any())
        <div id="errorAlert" class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-2xl shadow-sm flex flex-col gap-1 transition-all duration-300 fade-in-up">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <span class="font-bold text-sm">Por favor corrige los siguientes errores:</span>
                <button onclick="document.getElementById('errorAlert').remove()" class="text-red-500 hover:text-red-800 transition-colors ml-auto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <ul class="list-disc list-inside text-xs text-red-700 ml-9 space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Configuration Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start fade-in-up delay-100 relative z-10">
        
        <!-- Left Panel: Datos Personales (Bloqueados) -->
        <div class="lg:col-span-5 flex flex-col gap-6">
            <div class="glass-card rounded-3xl p-6 md:p-8 bg-white/70 border border-gray-200/50 shadow-md">
                <div class="flex items-center gap-4 mb-6">
                    <div class="p-3 bg-[#6BA53A]/10 rounded-2xl">
                        <svg class="w-6 h-6 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Datos Personales</h2>
                        <p class="text-xs font-semibold text-gray-500">Identificación oficial en el sistema.</p>
                    </div>
                </div>

                <div class="space-y-5">
                    <!-- Nombre Completo (Readonly) -->
                    <div class="space-y-2">
                        <label for="profile_name" class="text-xs font-bold text-gray-700 ml-1 uppercase tracking-wider">Nombre Completo</label>
                        <input 
                            type="text" 
                            id="profile_name" 
                            value="{{ $coordinadorName }}"
                            readonly 
                            disabled
                            class="w-full bg-gray-100/80 border border-gray-200 text-gray-500 text-sm rounded-xl block p-3.5 outline-none cursor-not-allowed font-semibold select-none shadow-sm"
                        >
                    </div>

                    <!-- Correo Electrónico (Readonly) -->
                    <div class="space-y-2">
                        <label for="profile_email" class="text-xs font-bold text-gray-700 ml-1 uppercase tracking-wider">Correo Electrónico</label>
                        <input 
                            type="email" 
                            id="profile_email" 
                            value="{{ $user->correo }}"
                            readonly 
                            disabled
                            class="w-full bg-gray-100/80 border border-gray-200 text-gray-500 text-sm rounded-xl block p-3.5 outline-none cursor-not-allowed font-semibold select-none shadow-sm"
                        >
                    </div>

                    <!-- Info notice explaining lock -->
                    <div class="flex items-start gap-3 bg-blue-50 border border-blue-100 rounded-xl px-4 py-3.5 mt-4">
                        <svg class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-xs text-blue-700 font-semibold leading-relaxed">
                            Los datos personales (nombre y correo electrónico) son administrados de manera oficial por el Administrador del sistema y no son editables para garantizar la validez del registro institucional.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel: Seguridad y Contraseña (Editable Subview Include) -->
        <div class="lg:col-span-7 flex flex-col gap-6">
            @include('coordinador.perfil.cambiar-contrasena')
        </div>

    </div>

    <!-- Script to Auto-dismiss success alert after 5 seconds -->
    <script>
        const successAlert = document.getElementById('successAlert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                successAlert.style.opacity = '0';
                successAlert.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    successAlert.remove();
                }, 500);
            }, 5000);
        }
    </script>
@endsection
