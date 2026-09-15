<!-- Top KPI Cards Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 fade-in-up delay-100 relative z-30">
    <!-- Card 1: Total Events -->
    <div class="glass-card rounded-3xl p-6 flex items-center justify-between">
        <div class="space-y-1">
            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Actividades Hoy</span>
            <h3 class="text-3xl font-extrabold text-gray-900" id="stat-total-events">{{ $totalEventsToday }}</h3>
        </div>
        <div class="h-12 w-12 rounded-2xl bg-[#6BA53A]/10 text-[#4E7D24] flex items-center justify-center shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
        </div>
    </div>

    <!-- Card 2: Warnings -->
    <div class="glass-card rounded-3xl p-6 flex items-center justify-between">
        <div class="space-y-1">
            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Advertencias</span>
            <h3 class="text-3xl font-extrabold text-gray-900" id="stat-warnings">{{ $warningsCount }}</h3>
            <div class="flex items-center gap-1 text-xs font-semibold text-yellow-600 bg-yellow-50 px-2 py-0.5 rounded-md w-fit">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"></path></svg>
                <span>Estable</span>
            </div>
        </div>
        <div class="h-12 w-12 rounded-2xl bg-yellow-50 text-yellow-600 flex items-center justify-center shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
    </div>

    <!-- Card 3: Critical Errors -->
    <div class="glass-card rounded-3xl p-6 flex items-center justify-between">
        <div class="space-y-1">
            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Errores Críticos</span>
            <h3 class="text-3xl font-extrabold text-gray-900 text-red-600 animate-pulse" id="stat-errors">{{ $errorsCount }}</h3>
            <div class="flex items-center gap-1 text-xs font-semibold text-red-600 bg-red-50 px-2 py-0.5 rounded-md w-fit">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                <span>Revisión req.</span>
            </div>
        </div>
        <div class="h-12 w-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>

</div>
