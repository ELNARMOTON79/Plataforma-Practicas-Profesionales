{{-- Partial: _progress-card.blade.php
     Column 1 — circular progress ring for completed hours.
     Variables: $horasCompletadas, $horasMeta, $porcentajeHoras, $horasFaltantes
--}}
<div class="glass-card rounded-3xl p-6 flex flex-col justify-between border border-gray-200/80 shadow-sm hover:shadow-md transition-all fade-in-up delay-100">
    <div>
        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6 flex items-center gap-2">
            <svg class="w-4 h-4 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
            </svg>
            Porcentaje de Avance
        </h3>

        {{-- Circular progress ring --}}
        <div class="relative w-36 h-36 mx-auto flex items-center justify-center my-2">
            <svg class="w-full h-full transform -rotate-95" viewBox="0 0 100 100">
                <circle class="text-gray-150" stroke-width="8" stroke="currentColor"
                        fill="transparent" r="40" cx="50" cy="50"/>
                <circle class="text-[#4E7D24] transition-all duration-700 ease-out"
                        id="circularProgressRing"
                        stroke-width="8"
                        stroke-dasharray="251.2"
                        stroke-dashoffset="{{ 251.2 - ($porcentajeHoras / 100 * 251.2) }}"
                        stroke-linecap="round"
                        stroke="currentColor"
                        fill="transparent" r="40" cx="50" cy="50"/>
            </svg>
            <div class="absolute flex flex-col items-center justify-center">
                <span class="text-2xl font-extrabold text-gray-900" id="circularHoursText">
                    {{ (int) $horasCompletadas }} h
                </span>
                <span class="text-[9px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">
                    de {{ $horasMeta }} totales
                </span>
            </div>
        </div>
    </div>

    <div class="mt-6 w-full bg-[#6BA53A]/10 rounded-2xl p-3.5 border border-[#6BA53A]/20">
        <span class="block text-xs font-extrabold text-[#4E7D24] mb-0.5" id="circularPercentageText">
            {{ $porcentajeHoras }}% Completado
        </span>
        <span class="text-[11px] text-gray-600 font-medium leading-tight block" id="circularHoursRemaining">
            @if($horasFaltantes > 0)
                Faltan {{ $horasFaltantes }} horas para acreditar tus prácticas.
            @else
                ¡Felicidades! Has cubierto las {{ $horasMeta }} horas necesarias.
            @endif
        </span>
    </div>
</div>
