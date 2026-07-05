{{-- Partial: _work-plan-card.blade.php
     Full-width section — project objectives, justification, activities, and social impact.
     Variables: $solicitud, $objetivosTexto, $actividadesLista
--}}
<div class="glass-card rounded-3xl p-8 border border-gray-200/80 shadow-sm hover:shadow-md transition-all fade-in-up delay-150">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 mb-6 border-b border-gray-150/80">
        <div>
            <h3 class="text-xs font-bold text-[#4E7D24] uppercase tracking-widest flex items-center gap-2 mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                Plan de Trabajo y Actividades
            </h3>
            <h4 class="text-xl font-extrabold text-gray-900">
                {{ $solicitud->titulo ?? $solicitud->unidadReceptora?->nombre_empresa ?? 'Proyecto de Prácticas Profesionales' }}
            </h4>
        </div>
        <div class="self-start sm:self-center shrink-0">
            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-green-700 bg-green-50 px-3 py-1.5 rounded-xl border border-green-200 shadow-2xs">
                <svg class="w-3.5 h-3.5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                Convenio Oficial Autorizado
            </span>
        </div>
    </div>

    {{-- Grid 2 Columnas para Objetivo y Justificación --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        {{-- Objetivo General --}}
        <div class="bg-gray-50/70 rounded-2xl p-5 border border-gray-200/60 flex flex-col justify-between">
            <div>
                <span class="flex items-center gap-2 text-xs font-extrabold text-gray-500 uppercase tracking-wider mb-2.5">
                    <svg class="w-4 h-4 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Objetivo
                </span>
                <p class="text-xs sm:text-sm text-gray-700 leading-relaxed font-medium">
                    {{ $objetivosTexto }}
                </p>
            </div>
        </div>

        {{-- Justificación --}}
        <div class="bg-gray-50/70 rounded-2xl p-5 border border-gray-200/60 flex flex-col justify-between">
            <div>
                <span class="flex items-center gap-2 text-xs font-extrabold text-gray-500 uppercase tracking-wider mb-2.5">
                    <svg class="w-4 h-4 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Justificación
                </span>
                <p class="text-xs sm:text-sm text-gray-700 leading-relaxed font-medium">
                    {{ $solicitud->justificacion ?? 'Desarrollo profesional y aplicación de competencias curriculares en un entorno laboral profesional.' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Grid 2 Columnas para Actividades e Impacto Social --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Actividades Autorizadas --}}
        <div class="bg-gray-50/70 rounded-2xl p-5 border border-gray-200/60">
            <span class="flex items-center gap-2 text-xs font-extrabold text-gray-500 uppercase tracking-wider mb-3">
                <svg class="w-4 h-4 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Actividades Autorizadas
            </span>
            <div class="space-y-2.5 max-h-64 overflow-y-auto pr-1">
                @foreach($actividadesLista as $activity)
                    <div class="flex items-start gap-3 p-2.5 bg-white rounded-xl border border-gray-200/70 shadow-2xs hover:border-[#6BA53A]/40 transition-all">
                        <span class="w-5 h-5 rounded-full bg-[#4E7D24]/10 text-[#4E7D24] flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">
                            ✓
                        </span>
                        <span class="text-xs sm:text-sm font-semibold text-gray-800 leading-snug">{{ $activity }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Impacto Social --}}
        <div class="bg-gray-50/70 rounded-2xl p-5 border border-gray-200/60 flex flex-col justify-between">
            <div>
                <span class="flex items-center gap-2 text-xs font-extrabold text-gray-500 uppercase tracking-wider mb-2.5">
                    <svg class="w-4 h-4 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Impacto Social
                </span>
                <p class="text-xs sm:text-sm text-gray-700 leading-relaxed font-medium">
                    {{ $solicitud->impacto_social ?? 'Contribución al desarrollo productivo y social de la comunidad mediante la aplicación de competencias profesionales.' }}
                </p>
            </div>
        </div>
    </div>
</div>
