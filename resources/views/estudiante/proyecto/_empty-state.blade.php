{{-- Partial: _empty-state.blade.php
     Shown when the student has no active solicitud.
     Variables inherited from parent view: none required.
--}}
<div class="glass-card rounded-3xl p-12 text-center bg-white border border-gray-200 shadow-sm fade-in-up max-w-3xl mx-auto my-12">
    <div class="w-16 h-16 bg-[#6BA53A]/10 text-[#4E7D24] rounded-2xl flex items-center justify-center mx-auto mb-6">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
        </svg>
    </div>
    <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Aún no cuentas con un proyecto activo</h2>
    <p class="text-sm text-gray-500 font-medium max-w-md mx-auto mb-8">
        Para ver el avance de tu proyecto, bitácora de horas y expediente digital, primero debes registrar
        una solicitud de prácticas profesionales.
    </p>
    <a href="{{ route('estudiante.nuevaSolicitud') }}"
       class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full bg-[#4E7D24] text-white font-bold text-sm shadow-md hover:bg-[#3b6620] transition-all">
        <span>Iniciar Solicitud de Prácticas</span>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
        </svg>
    </a>
</div>
