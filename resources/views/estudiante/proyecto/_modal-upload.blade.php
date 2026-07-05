{{-- Partial: _modal-upload.blade.php
     Slide-over modal to upload a PDF document.
     Requires JS: openUploadModal(), closeUploadModal(), fileSelected(), submitUpload()
     Push via: @push('modals')
--}}
<div id="uploadModal" class="hidden fixed inset-0 z-[99] bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl border border-gray-200 max-w-md w-full overflow-hidden fade-in-up">

        {{-- Modal header --}}
        <div class="bg-gradient-to-r from-gray-950 to-gray-850 p-5 text-white flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold">Subir Documento</h3>
                <p class="text-xs text-gray-300 mt-0.5" id="uploadModalDocName">Cargando...</p>
            </div>
            <button onclick="closeUploadModal()"
                    class="text-gray-300 hover:text-white transition-colors bg-white/10 hover:bg-white/20 p-2 rounded-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Drop zone --}}
        <div class="p-6 space-y-4">
            <div class="border-2 border-dashed border-gray-300 rounded-2xl p-8 flex flex-col items-center justify-center text-center hover:border-[#6BA53A] transition-colors cursor-pointer"
                 onclick="document.getElementById('simPdfInput').click()">
                <input type="file" id="simPdfInput" accept=".pdf" class="hidden" onchange="fileSelected(this)">
                <div class="w-12 h-12 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mb-3"
                     id="uploadIconContainer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                </div>
                <span class="block text-sm font-bold text-gray-800" id="uploadFileText">Seleccionar Archivo PDF</span>
                <span class="text-xs text-gray-400 mt-1">Peso máximo: 5MB</span>
            </div>
        </div>

        {{-- Footer actions --}}
        <div class="p-6 bg-gray-50/50 border-t border-gray-100 flex gap-3">
            <button onclick="closeUploadModal()"
                    class="flex-1 bg-white border border-gray-200 hover:bg-gray-50 text-gray-650 font-bold py-3.5 px-4 rounded-xl text-xs transition-colors shadow-sm">
                Cancelar
            </button>
            <button onclick="submitUpload()"
                    class="flex-1 bg-[#4E7D24] hover:bg-[#3A5D1B] text-white font-bold py-3.5 px-4 rounded-xl text-xs transition-all shadow-md">
                Subir Archivo
            </button>
        </div>
    </div>
</div>
