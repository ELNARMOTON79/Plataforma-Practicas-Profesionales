@extends('layouts.empresa', ['active' => 'solicitudes', 'title' => 'Solicitudes - Unidad Receptora'])

@section('content')
    <!-- Header Section -->
    <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-[#005e20] mb-1">Solicitudes de Prácticas</h1>
            <p class="text-gray-500 font-medium">Recibe, revisa y responde las solicitudes de estudiantes</p>
        </div>
        <button class="bg-[#005e20] text-white hover:bg-[#004718] px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 border border-[#004718]">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Nuevo Proyecto
        </button>
    </div>

    <!-- Filters/Tabs -->
    <div class="glass-card rounded-2xl p-2 mb-8 inline-flex flex-wrap gap-2">
        <button class="bg-[#6BA53A] text-white px-6 py-2 rounded-xl text-sm font-bold shadow-sm transition-all">
            Todas
        </button>
        <button class="bg-transparent hover:bg-white/50 text-gray-600 px-6 py-2 rounded-xl text-sm font-bold transition-all">
            Pendientes
        </button>
        <button class="bg-transparent hover:bg-white/50 text-gray-600 px-6 py-2 rounded-xl text-sm font-bold transition-all">
            Aprobadas
        </button>
        <button class="bg-transparent hover:bg-white/50 text-gray-600 px-6 py-2 rounded-xl text-sm font-bold transition-all">
            Rechazadas
        </button>
    </div>

    <!-- Requests List -->
    <div class="space-y-6">
        
        <!-- Card 1 -->
        <div class="glass-card rounded-3xl p-6 md:p-8 border-l-4 border-yellow-400 relative overflow-hidden group">
            <!-- Decorative background element -->
            <div class="absolute right-0 top-0 w-64 h-64 bg-yellow-400/5 rounded-full blur-3xl -mr-20 -mt-20 transition-all group-hover:bg-yellow-400/10"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row justify-between gap-6">
                <!-- Info Section -->
                <div class="flex-1">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h2 class="text-xl font-extrabold text-[#005e20]">María González</h2>
                            <p class="text-gray-500 font-medium">Ingeniería en Sistemas</p>
                        </div>
                        <span class="bg-[#C29B0C] text-white px-4 py-1.5 rounded-full text-xs font-bold shadow-sm inline-flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Pendiente
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Proyecto solicitado</p>
                            <p class="text-sm font-semibold text-gray-800">Desarrollo de Sistema Web</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Fecha de solicitud</p>
                            <p class="text-sm font-semibold text-gray-800">2026-05-12</p>
                        </div>
                    </div>
                </div>

                <!-- Divider (mobile horizontal, desktop vertical) -->
                <div class="w-full md:w-px h-px md:h-auto bg-gray-200/50"></div>

                <!-- Actions Section -->
                <div class="flex flex-row md:flex-col justify-center items-center gap-3 min-w-[140px]">
                    <button class="w-full bg-[#22c55e] hover:bg-[#16a34a] text-white px-4 py-2.5 rounded-xl text-sm font-bold shadow-sm hover:shadow transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        Aceptar
                    </button>
                    <button class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2.5 rounded-xl text-sm font-bold shadow-sm hover:shadow transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Rechazar
                    </button>
                    <button class="w-full bg-white/80 border border-gray-200 text-gray-700 hover:bg-white px-4 py-2.5 rounded-xl text-sm font-bold shadow-sm hover:shadow transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Detalles
                    </button>
                </div>
            </div>
        </div>

        <!-- Example Empty/Simulated Card -->
        <div class="glass-card rounded-3xl p-6 md:p-8 border-l-4 border-transparent opacity-50">
            <div class="h-24 flex items-center justify-center text-gray-400 text-sm font-medium">
                Siguiente solicitud...
            </div>
        </div>

    </div>
@endsection
