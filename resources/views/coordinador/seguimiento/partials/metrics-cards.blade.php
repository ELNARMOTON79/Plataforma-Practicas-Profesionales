@php
    $enProcesoCount = collect($data)->where('estatus', 'EN PROCESO')->count();
    $acreditadosCount = collect($data)->where('estatus', 'ACREDITADO')->count();
    $totalCount = count($data);
@endphp

<!-- Interactive Metrics Grid -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8 fade-in-up delay-100">
    <!-- 1. En Proceso (Activo por defecto) -->
    <button type="button" onclick="switchTrackingTab('proceso')" id="metric-proceso" 
        class="glass-card rounded-3xl p-5 flex flex-col relative overflow-hidden group text-left border-2 border-[#4E7D24] bg-white ring-4 ring-[#4E7D24]/10 shadow-md transition-all duration-300 cursor-pointer">
        <div class="flex items-center justify-between w-full mb-2">
            <span class="text-xs font-bold uppercase tracking-wider text-[#4E7D24]">En Proceso</span>
            <span class="w-2.5 h-2.5 rounded-full bg-yellow-500 animate-pulse"></span>
        </div>
        <div class="flex items-end gap-3 mb-1">
            <span class="text-3xl font-extrabold text-gray-900">{{ $enProcesoCount }}</span>
            @if($enProcesoCount > 0)
                <span class="flex items-center text-[10px] font-extrabold text-yellow-700 bg-yellow-100 px-2 py-0.5 rounded-md mb-1 border border-yellow-200">
                    Activas
                </span>
            @endif
        </div>
        <span class="text-[11px] text-gray-400 font-medium">Supervisión de actividades en curso</span>
    </button>

    <!-- 2. Concluidos / Acreditados -->
    <button type="button" onclick="switchTrackingTab('concluido')" id="metric-concluido" 
        class="glass-card rounded-3xl p-5 flex flex-col relative overflow-hidden group text-left border-2 border-transparent transition-all duration-300 cursor-pointer hover:border-green-300">
        <div class="flex items-center justify-between w-full mb-2">
            <span class="text-xs font-bold uppercase tracking-wider text-gray-500 group-hover:text-green-700 transition-colors">Concluidos / Acreditados</span>
            <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
        </div>
        <div class="flex items-end gap-3 mb-1">
            <span class="text-3xl font-extrabold text-gray-900">{{ $acreditadosCount }}</span>
            @if($acreditadosCount > 0)
                <span class="flex items-center text-[10px] font-extrabold text-green-700 bg-green-100 px-2 py-0.5 rounded-md mb-1 border border-green-200">
                    Finalizados
                </span>
            @endif
        </div>
        <span class="text-[11px] text-gray-400 font-medium">Historial completado</span>
    </button>

    <!-- 3. Total en Seguimiento -->
    <button type="button" onclick="switchTrackingTab('todos')" id="metric-todos" 
        class="glass-card rounded-3xl p-5 flex flex-col relative overflow-hidden group text-left border-2 border-transparent transition-all duration-300 cursor-pointer hover:border-[#6BA53A]/30">
        <div class="flex items-center justify-between w-full mb-2">
            <span class="text-xs font-bold uppercase tracking-wider text-gray-500 group-hover:text-[#4E7D24] transition-colors">Total en Seguimiento</span>
            <span class="w-2.5 h-2.5 rounded-full bg-[#4E7D24]"></span>
        </div>
        <div class="flex items-end gap-3 mb-1">
            <span class="text-3xl font-extrabold text-gray-900">{{ $totalCount }}</span>
        </div>
        <span class="text-[11px] text-gray-400 font-medium">Ciclo Escolar Activo</span>
    </button>
</div>
