@push('modals')
    <!-- Modal Preview Documento -->
    <div id="preview-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="relative w-full max-w-4xl bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 flex flex-col max-h-[90vh] animate-fade-in">
            <!-- Header Modal -->
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-xl bg-sky-50 text-sky-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </div>
                    <div>
                        <h3 id="modal-doc-title" class="text-sm font-extrabold text-gray-800">Previsualización de Documento</h3>
                        <p id="modal-doc-student" class="text-xs text-gray-400 font-medium"></p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a id="modal-doc-download" href="#" target="_blank" class="px-3 py-1.5 text-xs font-bold text-sky-700 bg-sky-50 hover:bg-sky-100 rounded-xl transition-all flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        <span>Abrir en pestaña nueva</span>
                    </a>
                    <button type="button" onclick="closePreviewModal()" class="p-2 text-gray-400 hover:text-gray-600 rounded-xl hover:bg-gray-100 transition-all cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Body Modal (Viewer Frame) -->
            <div class="flex-1 bg-slate-900/90 p-2 min-h-[500px]">
                <iframe id="modal-doc-iframe" src="" class="w-full h-full min-h-[500px] rounded-2xl border-0 bg-white shadow-inner" frameborder="0"></iframe>
            </div>
        </div>
    </div>
@endpush

<script>
    function openPreviewModal(url, docName, studentName) {
        document.getElementById('modal-doc-title').textContent = docName;
        document.getElementById('modal-doc-student').textContent = studentName ? 'Estudiante: ' + studentName : '';
        document.getElementById('modal-doc-download').href = url;
        document.getElementById('modal-doc-iframe').src = url;
        document.getElementById('preview-modal').classList.remove('hidden');
    }

    function closePreviewModal() {
        document.getElementById('preview-modal').classList.add('hidden');
        document.getElementById('modal-doc-iframe').src = '';
    }
</script>
