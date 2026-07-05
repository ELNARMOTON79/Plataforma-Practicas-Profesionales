{{-- Partial: _hero.blade.php
     Top banner for the proyecto view when a solicitud exists.
     Variables: $solicitud, $horasCompletadas, $horasMeta, $diasTranscurridos, $diasTotales,
                $totalDocsSubidos, $totalDocsMeta
--}}
<div class="glass-card rounded-3xl p-8 relative overflow-hidden bg-gradient-to-r from-white via-white to-[#6BA53A]/5 border border-[#6BA53A]/25 fade-in-up">
    <div class="absolute -right-10 -top-10 w-44 h-44 bg-[#4E7D24] rounded-full mix-blend-multiply filter blur-2xl opacity-10"></div>

    <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">

        {{-- Title & status badges --}}
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="text-[10px] font-bold text-[#4E7D24] bg-[#6BA53A]/10 px-2.5 py-0.5 rounded-md border border-[#6BA53A]/20">
                    @if(in_array($solicitud->estatus, ['aprobada', 'en_proceso']))
                        Fase de Ejecución
                    @elseif($solicitud->estatus === 'finalizada')
                        Fase Final
                    @else
                        Fase Inicial (Revisión)
                    @endif
                </span>

                <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-md text-[10px] font-bold
                    @if(in_array($solicitud->estatus, ['aprobada', 'en_proceso']))
                        bg-yellow-50 text-yellow-750 border border-yellow-150
                    @elseif($solicitud->estatus === 'finalizada')
                        bg-green-50 text-green-700 border border-green-200
                    @else
                        bg-blue-50 text-blue-700 border border-blue-200
                    @endif">
                    @if(in_array($solicitud->estatus, ['aprobada', 'en_proceso']))
                        <span class="relative flex h-1.5 w-1.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-yellow-500"></span>
                        </span>
                        En Curso
                    @elseif($solicitud->estatus === 'finalizada')
                        Completado
                    @else
                        En Revisión
                    @endif
                </span>
            </div>

            <h1 class="text-3xl font-extrabold text-gray-900 leading-tight">
                {{ $solicitud->unidadReceptora?->nombre_empresa ?? 'Proyecto de Prácticas' }}
            </h1>
            <p class="text-sm font-bold text-gray-500 mt-1">
                Responsable: {{ $solicitud->responsable ?? 'Asesor asignado' }}
            </p>
        </div>

        {{-- Global stats --}}
        <div class="grid grid-cols-3 gap-6 lg:gap-12 border-t lg:border-t-0 lg:border-l border-gray-200/65 pt-6 lg:pt-0 lg:pl-12">
            <div>
                <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Horas Totales</span>
                <span class="text-2xl font-extrabold text-gray-900 flex items-baseline gap-1">
                    <span id="heroHoursLabel">{{ (int) $horasCompletadas }}</span>
                    <span class="text-xs font-semibold text-gray-450">/ {{ $horasMeta }} h</span>
                </span>
            </div>
            <div>
                <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Días Transcurridos</span>
                <span class="text-2xl font-extrabold text-gray-900 flex items-baseline gap-1">
                    {{ $diasTranscurridos }}
                    <span class="text-xs font-semibold text-gray-450">/ {{ $diasTotales }} d</span>
                </span>
            </div>
            <div>
                <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Expediente</span>
                <span class="text-2xl font-extrabold text-[#4E7D24] flex items-baseline gap-1" id="heroDocsLabel">
                    {{ $totalDocsSubidos }}
                    <span class="text-xs font-semibold text-gray-450">/ {{ $totalDocsMeta }} docs</span>
                </span>
            </div>
        </div>

    </div>
</div>
