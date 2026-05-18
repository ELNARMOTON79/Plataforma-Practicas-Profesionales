@extends('layouts.coordinador', ['active' => 'dashboard', 'title' => 'Inicio - Coordinador'])

@section('content')
    <!-- Títulos -->
    <div class="mb-4">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Inicio</h1>
        <p class="text-gray-500 font-medium">Resumen general del programa de prácticas</p>
    </div>

    <!-- Estadísticas (KPIs) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Card 1 -->
        <div class="glass-card rounded-2xl p-6 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <span class="text-gray-500 font-medium text-sm">Estudiantes Activos</span>
                <div class="p-2 bg-[#6BA53A]/10 rounded-lg">
                    <svg class="w-6 h-6 text-[#6BA53A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <h3 class="text-4xl font-extrabold text-[#4E7D24]">100</h3>
        </div>

        <!-- Card 2 -->
        <div class="glass-card rounded-2xl p-6 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <span class="text-gray-500 font-medium text-sm">Instituciones Vinculadas</span>
                <div class="p-2 bg-[#4E7D24]/10 rounded-lg">
                    <svg class="w-6 h-6 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
            </div>
            <h3 class="text-4xl font-extrabold text-[#4E7D24]">30</h3>
        </div>

        <!-- Card 3 -->
        <div class="glass-card rounded-2xl p-6 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <span class="text-gray-500 font-medium text-sm">Solicitudes Pendientes</span>
                <div class="p-2 bg-yellow-500/10 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <h3 class="text-4xl font-extrabold text-[#4E7D24]">10</h3>
        </div>

        <!-- Card 4 -->
        <div class="glass-card rounded-2xl p-6 flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <span class="text-gray-500 font-medium text-sm">Proyectos Finalizados</span>
                <div class="p-2 bg-[#6BA53A]/10 rounded-lg">
                    <svg class="w-6 h-6 text-[#6BA53A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <h3 class="text-4xl font-extrabold text-[#4E7D24]">20</h3>
        </div>
    </div>

    <!-- Actividad Reciente -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="glass-card rounded-2xl p-8">
            <h2 class="text-xl font-bold text-[#2E5417] mb-6 flex items-center gap-2">
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
                        <p class="font-semibold text-gray-800 group-hover:text-[#6BA53A] transition-colors">Nueva solicitud recibida</p>
                        <p class="text-sm text-gray-500">Hace 2 horas</p>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="flex items-center gap-4 group cursor-pointer">
                    <div class="w-12 h-12 bg-[#6BA53A]/10 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-[#6BA53A]/20 transition-colors">
                        <svg class="w-6 h-6 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 group-hover:text-[#6BA53A] transition-colors">Nueva solicitud recibida</p>
                        <p class="text-sm text-gray-500">Hace 4 horas</p>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="flex items-center gap-4 group cursor-pointer">
                    <div class="w-12 h-12 bg-[#6BA53A]/10 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-[#6BA53A]/20 transition-colors">
                        <svg class="w-6 h-6 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 group-hover:text-[#6BA53A] transition-colors">Nueva solicitud recibida</p>
                        <p class="text-sm text-gray-500">Hace 6 horas</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Columna vacía o para futuro contenido -->
        <div></div>
    </div>
@endsection