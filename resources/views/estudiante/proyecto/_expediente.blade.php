{{-- Partial: _expediente.blade.php
     Full-width section with phase-based digital folder (documents 1–6).
     Variables: $solicitud
     Depends on: <x-estudiante.doc-card /> component, JS functions openUploadModal / simulateViewPdf
--}}
<div class="glass-card rounded-3xl p-6 fade-in-up delay-350" id="expediente-digital">
    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
        <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
        </svg>
        Expediente Digital por Fases del Trámite
    </h3>

    @php $solicitudActiva = in_array($solicitud->estatus ?? 'pendiente', ['aprobada', 'en_proceso', 'finalizada']); @endphp

    {{-- Lock banner when solicitud is not yet approved --}}
    @unless($solicitudActiva)
        <div class="bg-amber-50/80 border-2 border-dashed border-amber-300 rounded-3xl p-8 text-center my-4 flex flex-col items-center justify-center">
            <div class="w-14 h-14 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center mb-4 shadow-sm border border-amber-200">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h4 class="text-base font-extrabold text-amber-900 mb-1">Expediente Digital Bloqueado Temporalmente</h4>
            <p class="text-xs text-amber-800/80 max-w-md font-medium leading-relaxed mb-4">
                Tu solicitud se encuentra actualmente en estado
                <strong class="uppercase underline decoration-amber-400 font-bold">{{ $solicitud->estatus ?? 'pendiente' }}</strong>.
                Podrás generar tu Carta de Presentación y subir documentación una vez que el Coordinador acepte tu solicitud.
            </p>
            <div class="inline-flex items-center gap-2 bg-white px-4 py-2 rounded-xl border border-amber-200 text-[11px] font-bold text-amber-800 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                Esperando aprobación del coordinador de practicas
            </div>
        </div>
    @endunless

    @php
        $documentosCargados = $solicitud ? $solicitud->documentos->keyBy('nombre_doc') : collect([]);
        
        $getOnView = function($docName) use ($documentosCargados) {
            $doc = $documentosCargados->get($docName);
            if (!$doc) return '';
            $url = str_starts_with($doc->ruta_archivo, 'http')
                ? $doc->ruta_archivo
                : asset($doc->ruta_archivo);
            return "window.open('" . $url . "', '_blank')";
        };
    @endphp

    {{-- Phase columns — blurred/disabled when not approved --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 relative
                {{ !$solicitudActiva ? 'opacity-45 pointer-events-none select-none blur-[1px]' : '' }}">

        {{-- Phase 1: Apertura --}}
        <div class="relative pl-6 border-l-2 border-green-400 flex flex-col gap-4">
            <div class="absolute -left-[9px] top-1 w-4 h-4 bg-green-500 rounded-full border-4 border-white shadow-md"></div>
            <h4 class="text-xs font-extrabold text-green-800 uppercase tracking-widest mb-1">Fase Inicial (Apertura)</h4>

            <x-estudiante.doc-card
                :doc-id="1"
                title="Carta de Presentación"
                status="{{ $expediente['Carta de Presentación'] ?? 'pending' }}"
                on-generate="window.open('{{ route('estudiante.cartaPresentacion', $solicitud->id) }}', '_blank')"
                on-upload="openUploadModal(1, 'Carta de Presentación')"
                on-view="{!! $getOnView('Carta de Presentación') !!}" />

            <x-estudiante.doc-card
                :doc-id="2"
                title="Carta de Aceptación"
                status="{{ $expediente['Carta de Aceptación'] ?? 'pending' }}"
                on-upload="openUploadModal(2, 'Carta de Aceptación')"
                on-view="{!! $getOnView('Carta de Aceptación') !!}" />
        </div>

        {{-- Phase 2: Ejecución --}}
        <div class="relative pl-6 border-l-2 border-yellow-450 flex flex-col gap-4">
            <div class="absolute -left-[9px] top-1 w-4 h-4 bg-yellow-500 rounded-full border-4 border-white shadow-md"></div>
            <h4 class="text-xs font-extrabold text-yellow-800 uppercase tracking-widest mb-1">Fase de Avance (Ejecución)</h4>

            <x-estudiante.doc-card
                :doc-id="3"
                title="Plan de Trabajo"
                status="{{ $expediente['Plan de Trabajo'] ?? 'pending' }}"
                on-generate="window.open('{{ route('estudiante.planTrabajo', $solicitud->id) }}', '_blank')"
                on-upload="openUploadModal(3, 'Plan de Trabajo')"
                on-view="{!! $getOnView('Plan de Trabajo') !!}" />

            <x-estudiante.doc-card
                :doc-id="4"
                title="Memoria de Prácticas"
                status="{{ $expediente['Memoria de Prácticas'] ?? 'pending' }}"
                on-upload="openUploadModal(4, 'Memoria de Prácticas')"
                on-view="{!! $getOnView('Memoria de Prácticas') !!}" />
        </div>

        {{-- Phase 3: Cierre --}}
        <div class="relative pl-6 border-l-2 border-gray-300 flex flex-col gap-4">
            <div class="absolute -left-[9px] top-1 w-4 h-4 bg-gray-300 rounded-full border-4 border-white shadow-md" id="docBullet-5"></div>
            <h4 class="text-xs font-extrabold text-gray-400 uppercase tracking-widest mb-1">Fase Final (Cierre y Acreditación)</h4>

            <x-estudiante.doc-card
                :doc-id="5"
                title="Evaluación de Desempeño"
                status="{{ $expediente['Evaluación de Desempeño'] ?? 'pending' }}"
                on-upload="openUploadModal(5, 'Evaluación de Desempeño')"
                on-view="{!! $getOnView('Evaluación de Desempeño') !!}" />

            <x-estudiante.doc-card
                :doc-id="6"
                title="Carta de Término"
                status="{{ $expediente['Carta de Término'] ?? 'pending' }}"
                on-upload="openUploadModal(6, 'Carta de Término')"
                on-view="{!! $getOnView('Carta de Término') !!}" />
        </div>

    </div>
</div>
