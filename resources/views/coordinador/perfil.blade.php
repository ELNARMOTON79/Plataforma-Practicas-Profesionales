@extends('layouts.coordinador', ['active' => 'perfil', 'title' => 'Mi Perfil - Coordinador'])

@section('content')
    <!-- Header Section -->
    <x-page-header title="Perfil del Coordinador" description="Gestionar información personal y de contacto." />


    <!-- Profile Card -->
    <div class="max-w-fit mx-auto glass-card rounded-3xl p-8 lg:p-12 border-t-4 border-[#6BA53A] shadow-sm">
        
        <!-- Header Info -->
        <div class="flex items-center gap-5 mb-8">
            <div class="w-16 h-16 bg-[#6BA53A]/20 rounded-full flex items-center justify-center text-[#4E7D24] shadow-inner">
                <svg class="w-8 h-8" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <div>
                <h2 class="text-xl font-extrabold text-gray-800">Información General</h2>
                <p class="text-sm text-gray-500 font-medium">Coordinador de Prácticas Profesionales</p>
            </div>
        </div>

        <hr class="border-gray-200 mb-8">

        <!-- Form -->
        <form action="#" method="POST">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-10 mb-10">
                
                <!-- Nombre Completo -->
                <div>
                    <label for="perfil-nombre" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-2">
                        <svg class="w-5 h-5 text-gray-400" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Nombre Completo
                    </label>
                    <input type="text" id="perfil-nombre" name="nombre" class="w-full md:w-[420px] px-4 py-3 rounded-xl border border-gray-200 bg-white/60 focus:ring-2 focus:ring-[#6BA53A] focus:border-[#6BA53A] outline-none transition-all text-sm font-medium text-gray-800 shadow-inner" placeholder="Tu nombre completo" value="Juan Pérez López">
                </div>

                <!-- Correo Electrónico -->
                <div>
                    <label for="perfil-correo" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-2">
                        <svg class="w-5 h-5 text-gray-400" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Correo Electrónico
                    </label>
                    <input type="email" id="perfil-correo" name="correo" class="w-full md:w-[420px] px-4 py-3 rounded-xl border border-gray-200 bg-white/60 focus:ring-2 focus:ring-[#6BA53A] focus:border-[#6BA53A] outline-none transition-all text-sm font-medium text-gray-800 shadow-inner" placeholder="tu@correo.ucol.mx" value="coordinador@ucol.mx">
                </div>

                <!-- Teléfono -->
                <div>
                    <label for="perfil-telefono" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-2">
                        <svg class="w-5 h-5 text-gray-400" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        Teléfono
                    </label>
                    <input type="tel" id="perfil-telefono" name="telefono" class="w-full md:w-[420px] px-4 py-3 rounded-xl border border-gray-200 bg-white/60 focus:ring-2 focus:ring-[#6BA53A] focus:border-[#6BA53A] outline-none transition-all text-sm font-medium text-gray-800 shadow-inner" placeholder="Tu número de teléfono" value="312 123 4567">
                </div>

                <!-- Departamento -->
                <div>
                    <label for="perfil-departamento" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-2">
                        <svg class="w-5 h-5 text-gray-400" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Departamento
                    </label>
                    <input type="text" id="perfil-departamento" name="departamento" class="w-full md:w-[420px] px-4 py-3 rounded-xl border border-gray-200 bg-white/60 focus:ring-2 focus:ring-[#6BA53A] focus:border-[#6BA53A] outline-none transition-all text-sm font-medium text-gray-800 shadow-inner" placeholder="Tu departamento" value="Facultad de Ingeniería Electromecánica">
                </div>

            </div>

            <!-- Botón de Guardar -->
            <div class="flex justify-end">
                <button type="submit" class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-8 py-3 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 transform hover:-translate-y-0.5" aria-label="Guardar cambios del perfil">
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
@endsection
