    <!-- Search -->
    <div class="glass-card rounded-3xl p-6 fade-in-up delay-100">
        <form method="GET" action="{{ route('estudiante.convenios') }}" class="flex flex-col sm:flex-row gap-4 items-center">
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" name="q" value="{{ $search }}" class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl bg-white/70 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/20 focus:border-[#6BA53A] sm:text-sm transition-all shadow-sm" placeholder="Buscar por empresa o dirección...">
            </div>
            <button type="submit" class="shrink-0 px-6 py-3.5 bg-[#4E7D24] text-white text-sm font-semibold rounded-2xl hover:bg-[#3b6620] transition-all shadow-sm">Buscar</button>
            @if($search)
                <a href="{{ route('estudiante.convenios') }}" class="shrink-0 text-sm text-gray-500 hover:text-gray-700 font-medium">Limpiar</a>
            @endif
        </form>
    </div>
