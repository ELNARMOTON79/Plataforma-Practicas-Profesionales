{{-- Partial: _modal-pdf.blade.php
     Simulated PDF viewer modal.
     Requires JS: simulateViewPdf(), closePdfModal()
     Push via: @push('modals')
     Variables (Blade): used to render the letter body — auth()->user()->correo
--}}
<div id="pdfModal" class="hidden fixed inset-0 z-[99] bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl border border-gray-200 max-w-3xl w-full h-[85vh] overflow-hidden flex flex-col fade-in-up">

        {{-- Modal header --}}
        <div class="bg-gray-900 p-5 text-white flex justify-between items-center">
            <div>
                <h3 class="text-base font-bold" id="pdfModalTitle">Visor de Documentos (Simulado)</h3>
                <p class="text-xs text-gray-400 mt-0.5" id="pdfModalSubtitle">Cargando...</p>
            </div>
            <button onclick="closePdfModal()"
                    class="text-gray-300 hover:text-white transition-colors bg-white/10 hover:bg-white/20 p-2 rounded-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Document body --}}
        <div class="flex-1 bg-gray-100 overflow-y-auto p-8 flex flex-col items-center justify-start custom-scrollbar">
            <div class="max-w-2xl w-full bg-white shadow-lg border border-gray-200 rounded-xl p-10 min-h-[750px] relative flex flex-col justify-between">

                {{-- Letterhead --}}
                <div class="flex justify-between items-start border-b-2 border-gray-200 pb-5">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo_verde.png') }}" alt="Logo" class="h-14 w-auto object-contain">
                        <div>
                            <h4 class="font-bold text-xs text-gray-900 uppercase">Universidad de Colima</h4>
                            <h5 class="text-[10px] text-gray-500 uppercase font-semibold">Facultad de Ingeniería Mecánica y Eléctrica</h5>
                            <h5 class="text-[9px] text-gray-450 uppercase font-bold">Dirección General de Prácticas Profesionales</h5>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-[9px] font-bold text-gray-450 bg-gray-100 border border-gray-200 px-2 py-0.5 rounded">DOCUMENTO OFICIAL</span>
                        <p class="text-[9px] text-gray-400 font-medium mt-1">Folio: UDEC-PP-2026-0429</p>
                    </div>
                </div>

                {{-- Letter body --}}
                <div class="my-8 flex-1">
                    <h3 class="text-center font-bold text-sm text-gray-800 uppercase tracking-wider mb-6"
                        id="pdfDocDocName">CARTA DE PRESENTACIÓN DE PRÁCTICAS</h3>

                    <p class="text-xs text-right text-gray-600 font-medium mb-6">Colima, Col., a 12 de Abril del 2026.</p>

                    <p class="text-xs text-gray-800 font-bold mb-4">
                        ING. ROBERTO MEDINA<br>
                        ASIGNADOR DE PROYECTOS EXTERNOS<br>
                        TECH SOLUTIONS S.A.<br>
                        PRESENTE.
                    </p>

                    <p class="text-xs text-gray-700 leading-relaxed text-justify font-medium mb-4">
                        Por medio de la presente, la Coordinación de Prácticas Profesionales de la Universidad
                        de Colima tiene el honor de presentar al estudiante
                        <strong>{{ auth()->user()->correo }}</strong> con matrícula <strong>20183492</strong>,
                        de la carrera de <strong>Ingeniería en Software</strong> (6° semestre), para que realice
                        su periodo de prácticas profesionales en su distinguida empresa.
                    </p>

                    <p class="text-xs text-gray-700 leading-relaxed text-justify font-medium mb-4">
                        Las prácticas profesionales constan de cubrir un total de <strong>360 horas</strong>,
                        realizando actividades afines a su perfil de egreso en el área de desarrollo web/móvil,
                        las cuales se llevarán a cabo en el periodo establecido y bajo la supervisión del asesor
                        que sea designado.
                    </p>

                    <p class="text-xs text-gray-700 leading-relaxed text-justify font-medium mb-6">
                        Agradeciendo de antemano el apoyo que se sirva brindar a nuestro estudiante en su
                        formación integral, quedo de usted para cualquier aclaración o duda.
                    </p>
                </div>

                {{-- Signatures --}}
                <div class="border-t border-gray-150 pt-5">
                    <div class="grid grid-cols-2 gap-8 text-center">
                        <div class="flex flex-col items-center">
                            <span class="text-[9px] font-bold text-[#4E7D24] mb-12">AUTORIZACIÓN INSTITUCIONAL</span>
                            <div class="w-32 border-b border-gray-400"></div>
                            <span class="text-[9px] text-gray-800 font-bold mt-1">Mtro. Alejandro Ramos</span>
                            <span class="text-[8px] text-gray-500 font-semibold">Coordinador UdeC</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="text-[9px] font-bold text-gray-450 mb-12">RECIBIDO POR LA EMPRESA</span>
                            <div class="w-32 border-b border-gray-400"></div>
                            <span class="text-[9px] text-gray-800 font-bold mt-1">Ing. Roberto Medina</span>
                            <span class="text-[8px] text-gray-500 font-semibold">Tech Solutions S.A.</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Footer --}}
        <div class="p-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-2">
            <button onclick="closePdfModal()"
                    class="bg-gray-900 text-white font-bold py-2.5 px-6 rounded-xl text-xs hover:bg-black transition-colors shadow-sm">
                Cerrar Visor
            </button>
        </div>

    </div>
</div>
