@extends('layouts.empresa', ['active' => 'convenios', 'title' => 'Gestión de Convenios - Unidad Receptora'])

@section('content')
    <!-- Header Section -->
    <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-[#005e20] mb-1">Gestión de Convenios</h1>
            <p class="text-gray-500 font-medium">Consulta y gestiona los convenios institucionales</p>
        </div>
        <button class="bg-[#005e20] text-white hover:bg-[#004718] px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 border border-[#004718]">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Solicitar Nuevo Convenio
        </button>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Card 1 (Vigente) -->
        <div class="glass-card rounded-3xl p-6 relative overflow-hidden group border-t-4 border-[#22c55e]">
            <div class="absolute right-0 top-0 w-32 h-32 bg-[#22c55e]/5 rounded-full blur-2xl -mr-10 -mt-10 transition-all group-hover:bg-[#22c55e]/10"></div>
            
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 bg-[#22c55e]/10 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-[#16a34a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <span class="bg-[#22c55e] text-white px-4 py-1 rounded-full text-[11px] font-bold shadow-sm uppercase tracking-wider">
                        Vigente
                    </span>
                </div>

                <h3 class="text-xl font-extrabold text-gray-900 mb-4">Empresa Tecnología</h3>

                <div class="space-y-3 mb-6">
                    <div class="flex items-center gap-3 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="font-medium">Vigencia: 2026-12-31</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                        <span class="font-medium">Proyectos activos: 3</span>
                    </div>
                </div>

                <button class="w-full bg-[#005e20] hover:bg-[#004718] text-white px-4 py-2.5 rounded-xl text-sm font-bold shadow-sm hover:shadow transition-all text-center">
                    Ver detalles
                </button>
            </div>
        </div>

        <!-- Card 2 (Por Vencer) -->
        <div class="glass-card rounded-3xl p-6 relative overflow-hidden group border-t-4 border-[#C29B0C]">
            <div class="absolute right-0 top-0 w-32 h-32 bg-[#C29B0C]/5 rounded-full blur-2xl -mr-10 -mt-10 transition-all group-hover:bg-[#C29B0C]/10"></div>
            
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 bg-[#C29B0C]/10 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-[#C29B0C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <span class="bg-[#C29B0C] text-white px-4 py-1 rounded-full text-[11px] font-bold shadow-sm uppercase tracking-wider">
                        Por Vencer
                    </span>
                </div>

                <h3 class="text-xl font-extrabold text-gray-900 mb-4">Empresa Tecnología</h3>

                <div class="space-y-3 mb-6">
                    <div class="flex items-center gap-3 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="font-medium">Vigencia: 2026-12-31</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                        <span class="font-medium">Proyectos activos: 3</span>
                    </div>
                </div>

                <button class="w-full bg-[#005e20] hover:bg-[#004718] text-white px-4 py-2.5 rounded-xl text-sm font-bold shadow-sm hover:shadow transition-all text-center">
                    Ver detalles
                </button>
            </div>
        </div>

        <!-- Card 3 (Caducado) -->
        <div class="glass-card rounded-3xl p-6 relative overflow-hidden group border-t-4 border-red-500">
            <div class="absolute right-0 top-0 w-32 h-32 bg-red-500/5 rounded-full blur-2xl -mr-10 -mt-10 transition-all group-hover:bg-red-500/10"></div>
            
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 bg-red-500/10 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <span class="bg-red-500 text-white px-4 py-1 rounded-full text-[11px] font-bold shadow-sm uppercase tracking-wider">
                        Caducado
                    </span>
                </div>

                <h3 class="text-xl font-extrabold text-gray-900 mb-4">Empresa Tecnología</h3>

                <div class="space-y-3 mb-6">
                    <div class="flex items-center gap-3 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="font-medium">Vigencia: 2026-12-31</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-600">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                        <span class="font-medium">Proyectos activos: 3</span>
                    </div>
                </div>

                <button class="w-full bg-[#005e20] hover:bg-[#004718] text-white px-4 py-2.5 rounded-xl text-sm font-bold shadow-sm hover:shadow transition-all text-center">
                    Ver detalles
                </button>
            </div>
        </div>

    </div>
@endsection
