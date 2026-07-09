    <!-- Welcome Header -->
    <div class="glass-card rounded-3xl p-8 fade-in-up">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-[#4E7D24] to-[#6BA53A] flex items-center justify-center text-white text-2xl font-extrabold shadow-lg">
                    {{ $iniciales }}
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-1">¡Hola, {{ $nombre }}!</h1>
                    <p class="text-gray-600 font-medium flex flex-wrap items-center gap-2 text-sm">
                        @if($carrera !== '—')
                            <span>{{ $carrera }}</span>
                        @endif
                        @if($semestre)
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                            <span>{{ $semestre }}° Semestre</span>
                        @endif
                        @if($grupo)
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                            <span>Grupo {{ $grupo }}</span>
                        @endif
                        @if($matricula !== '—')
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                            <span class="text-[#4E7D24] font-bold">Matrícula: {{ $matricula }}</span>
                        @endif
                    </p>
                </div>
            </div>
            @if($solicitudesActivas > 0)
            <div class="flex gap-4 items-center w-full lg:w-auto">
                <div class="bg-white/95 px-6 py-3.5 rounded-2xl shadow-sm border border-gray-100 flex-1 lg:flex-initial flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="flex flex-col">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Estatus General</span>
                        <span class="text-base font-extrabold text-[#4E7D24] flex items-center gap-2">
                            <span class="relative flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#6BA53A] opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#4E7D24]"></span>
                            </span>
                            En Curso
                        </span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
