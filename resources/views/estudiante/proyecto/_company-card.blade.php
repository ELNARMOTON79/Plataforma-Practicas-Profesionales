{{-- Partial: _company-card.blade.php
     Column 3 — company and advisor info sheet.
     Variables: $solicitud
--}}
<div class="glass-card rounded-3xl p-6 flex flex-col justify-between border border-gray-200/80 shadow-sm hover:shadow-md transition-all fade-in-up delay-200">
    <div>
        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            Información del Asesor y Empresa
        </h3>

        {{-- Advisor avatar + name --}}
        <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-150/60">
            <div class="w-10 h-10 bg-[#4E7D24]/10 rounded-xl flex items-center justify-center text-[#4E7D24] shrink-0 font-bold text-sm border border-[#6BA53A]/20">
                {{ Str::upper(Str::substr($solicitud->responsable ?? 'A', 0, 1)) }}
            </div>
            <div class="overflow-hidden">
                <span class="block text-xs font-extrabold text-gray-900 truncate"
                      title="{{ $solicitud->responsable ?? $solicitud->unidadReceptora?->titular ?? 'Asesor Asignado' }}">
                    {{ $solicitud->responsable ?? $solicitud->unidadReceptora?->titular ?? 'Asesor Asignado' }}
                </span>
                <span class="block text-[11px] text-gray-500 font-semibold truncate mt-0.5">
                    {{ $solicitud->unidadReceptora?->nombre_empresa ?? 'Unidad Receptora' }}
                </span>
            </div>
        </div>

        {{-- Key-value details --}}
        <div class="space-y-3 text-xs text-gray-700 font-semibold">
            <div class="flex justify-between items-center py-1 border-b border-gray-100">
                <span class="text-gray-400 font-bold">Empresa:</span>
                <span class="text-gray-900 truncate max-w-[280px]"
                      title="{{ $solicitud->unidadReceptora?->nombre_empresa }}">
                    {{ $solicitud->unidadReceptora?->nombre_empresa ?? '—' }}
                </span>
            </div>
            <div class="flex justify-between items-center py-1 border-b border-gray-100">
                <span class="text-gray-400 font-bold">Dirección:</span>
                <span class="text-gray-900 truncate max-w-[280px]"
                      title="{{ $solicitud->unidadReceptora?->direccion }}">
                    {{ $solicitud->unidadReceptora?->direccion ?? '—' }}
                </span>
            </div>
            <div class="flex justify-between items-center py-1 border-b border-gray-100">
                <span class="text-gray-400 font-bold">Horas Diarias:</span>
                <span class="text-gray-900">6 horas diarias (480h total)</span>
            </div>
            <div class="flex justify-between items-center py-1">
                <span class="text-gray-400 font-bold">Periodo:</span>
                <span class="text-gray-900">
                    {{ $solicitud->fecha_inicio ? \Carbon\Carbon::parse($solicitud->fecha_inicio)->format('d/m/Y') : '—' }}
                    –
                    {{ $solicitud->fecha_fin ? \Carbon\Carbon::parse($solicitud->fecha_fin)->format('d/m/Y') : '—' }}
                </span>
            </div>
        </div>
    </div>

    {{-- Contact buttons --}}
    <div class="flex flex-col gap-2 mt-6">
        <a href="mailto:{{ $solicitud->unidadReceptora?->correo ?? '' }}"
           class="w-full text-center py-2.5 bg-[#4E7D24] hover:bg-[#3A5D1B] text-white text-xs font-bold rounded-xl transition-all shadow-sm">
            Contacto Empresa
        </a>
        <a href="mailto:aramos@ucol.mx"
           class="w-full text-center py-2.5 border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-bold rounded-xl transition-colors shadow-sm">
            Reportar con Coordinador
        </a>
    </div>
</div>
