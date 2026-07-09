    {{-- Profile hero card --}}
    <div class="glass-card rounded-3xl p-8 fade-in-up">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div class="flex items-center gap-5">
                <div id="avatar" class="flex h-20 w-20 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-[#4E7D24] to-[#6BA53A] text-2xl font-extrabold text-white shadow-lg shadow-green-900/20">
                    {{ $iniciales }}
                </div>
                <div>
                    <h1 id="hero-name" class="text-2xl font-bold text-gray-900">{{ $nombre }}</h1>
                    <p class="text-sm text-gray-500 mt-0.5">{{ $carrera }}</p>
                    <span class="inline-block mt-2 text-xs font-bold text-[#4E7D24] bg-[#6BA53A]/10 border border-[#6BA53A]/20 px-3 py-1 rounded-full">
                        Matrícula: {{ $matricula }}
                    </span>
                </div>
            </div>

        </div>
    </div>
