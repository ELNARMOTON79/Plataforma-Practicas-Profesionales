@extends('layouts.empresa', ['active' => 'dashboard', 'title' => 'Inicio - Unidad Receptora'])

@section('content')
    <!-- Header -->
    <div class="mb-4">
        <h1 class="text-3xl font-extrabold text-[#005e20] mb-1">Inicio</h1>
        <p class="text-gray-500 font-medium text-sm">Resumen general del programa de prácticas</p>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        
        <!-- Card 1 -->
        <div class="glass-card rounded-2xl p-6 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <span class="text-gray-500 text-sm font-medium">Proyectos Activos</span>
                <div class="p-2 bg-[#6BA53A]/10 rounded-lg">
                    <svg class="w-6 h-6 text-[#6BA53A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
            </div>
            <div class="text-left">
                <span class="text-4xl font-extrabold text-[#005e20]">100</span>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="glass-card rounded-2xl p-6 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <span class="text-gray-500 text-sm font-medium">Convenios Vigentes</span>
                <div class="p-2 bg-[#4E7D24]/10 rounded-lg">
                    <svg class="w-6 h-6 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
            </div>
            <div class="text-left">
                <span class="text-4xl font-extrabold text-[#005e20]">30</span>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="glass-card rounded-2xl p-6 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <span class="text-gray-500 text-sm font-medium">Solicitudes Pendientes</span>
                <div class="p-2 bg-[#C29B0C]/10 rounded-lg">
                    <svg class="w-6 h-6 text-[#C29B0C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="text-left">
                <span class="text-4xl font-extrabold text-[#005e20]">10</span>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="glass-card rounded-2xl p-6 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <span class="text-gray-500 text-sm font-medium">Estudiantes asignados</span>
                <div class="p-2 bg-[#6BA53A]/10 rounded-lg">
                    <svg class="w-6 h-6 text-[#6BA53A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <div class="text-left">
                <span class="text-4xl font-extrabold text-[#005e20]">20</span>
            </div>
        </div>

    </div>

    <!-- Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="glass-card rounded-2xl p-8">
            <h2 class="text-xl font-bold text-[#005e20] mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#6BA53A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                Actividad Reciente
            </h2>
            
            <div class="space-y-6">
                <!-- Item 1 -->
                <div class="flex items-center gap-4 group cursor-pointer">
                    <div class="w-12 h-12 bg-[#6BA53A]/10 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-[#6BA53A]/20 transition-colors">
                        <svg class="w-6 h-6 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 group-hover:text-[#6BA53A] transition-colors">Nueva solicitud recibida - Juan Pérez</p>
                        <p class="text-sm text-gray-500">Hace 2 horas</p>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="flex items-center gap-4 group cursor-pointer">
                    <div class="w-12 h-12 bg-[#6BA53A]/10 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-[#6BA53A]/20 transition-colors">
                        <svg class="w-6 h-6 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 group-hover:text-[#6BA53A] transition-colors">Convenio Renovado</p>
                        <p class="text-sm text-gray-500">Hace 4 horas</p>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="flex items-center gap-4 group cursor-pointer">
                    <div class="w-12 h-12 bg-[#6BA53A]/10 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-[#6BA53A]/20 transition-colors">
                        <svg class="w-6 h-6 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 group-hover:text-[#6BA53A] transition-colors">Estudiante asignado a proyecto</p>
                        <p class="text-sm text-gray-500">Hace 6 horas</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Columna vacía o para futuro contenido -->
        <div></div>
    </div>

@endsection