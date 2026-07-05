{{-- Partial: _scripts.blade.php
     All client-side JavaScript for the proyecto view.
     Push via: @push('scripts')
     Blade variables injected: $horasMeta, $horasCompletadas, $totalDocsSubidos
--}}
<script>
    // ─────────────────────────────────────────────────────────────
    // Circular Progress Ring
    // ─────────────────────────────────────────────────────────────
    const MAX_CIRCLE_OFFSET = 251.2; // 2 * PI * r = 2 * PI * 40
    const TOTAL_HOURS        = {{ $horasMeta ?? 480 }};

    let currentHours  = {{ (int) ($horasCompletadas ?? 0) }};
    let approvedDocs  = {{ $totalDocsSubidos ?? 0 }};

    function updateCircularProgress(newHours) {
        currentHours = Math.min(newHours, TOTAL_HOURS);

        document.getElementById('circularHoursText').textContent  = `${currentHours} h`;
        document.getElementById('heroHoursLabel').textContent      = currentHours;

        const percentage = ((currentHours / TOTAL_HOURS) * 100).toFixed(1);
        document.getElementById('circularPercentageText').textContent = `${percentage}% Completado`;

        const remaining = TOTAL_HOURS - currentHours;
        const remainingEl = document.getElementById('circularHoursRemaining');

        if (remaining > 0) {
            remainingEl.textContent  = `Faltan ${remaining} horas para acreditar tus prácticas.`;
            remainingEl.className    = 'text-[11px] text-gray-600 font-medium leading-tight block';
        } else {
            remainingEl.textContent  = `¡Felicidades! Has cubierto las ${TOTAL_HOURS} horas necesarias.`;
            remainingEl.className    = 'text-[11px] text-green-800/80 font-bold block';
        }

        const offset = MAX_CIRCLE_OFFSET - (currentHours / TOTAL_HOURS * MAX_CIRCLE_OFFSET);
        document.getElementById('circularProgressRing').setAttribute('stroke-dashoffset', offset);
    }

    // ─────────────────────────────────────────────────────────────
    // Upload Modal
    // ─────────────────────────────────────────────────────────────
    let activeDocId   = null;
    let activeDocName = '';

    function openUploadModal(docId, docName) {
        activeDocId   = docId;
        activeDocName = docName;

        document.getElementById('uploadModalDocName').textContent = docName;
        document.getElementById('uploadFileText').textContent     = 'Seleccionar Archivo PDF';
        document.getElementById('simPdfInput').value              = '';

        const iconEl = document.getElementById('uploadIconContainer');
        iconEl.className = 'w-12 h-12 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mb-3';
        iconEl.innerHTML = `
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
            </svg>`;

        document.getElementById('uploadModal').classList.remove('hidden');
    }

    function closeUploadModal() {
        document.getElementById('uploadModal').classList.add('hidden');
    }

    function fileSelected(input) {
        if (!input.files?.[0]) return;

        document.getElementById('uploadFileText').textContent = input.files[0].name;

        const iconEl = document.getElementById('uploadIconContainer');
        iconEl.className = 'w-12 h-12 bg-green-50 text-green-500 rounded-full flex items-center justify-center mb-3';
        iconEl.innerHTML = `
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>`;
    }

    function submitUpload() {
        const input = document.getElementById('simPdfInput');
        if (input.files.length === 0 &&
            document.getElementById('uploadFileText').textContent === 'Seleccionar Archivo PDF') {
            alert('Por favor selecciona un archivo PDF de tu equipo.');
            return;
        }

        closeUploadModal();

        const badge   = document.getElementById(`docBadge-${activeDocId}`);
        const row     = document.getElementById(`docRow-${activeDocId}`);
        const actions = document.getElementById(`docActions-${activeDocId}`);
        const icon    = document.getElementById(`docIconContainer-${activeDocId}`);

        // Update badge to "En Revisión"
        if (badge) {
            badge.className  = 'inline-block text-[9px] font-bold text-yellow-700 bg-yellow-50 px-2 py-0.5 rounded mt-1 border border-yellow-100';
            badge.textContent = 'En Revisión';
        }

        // Update card appearance
        if (row && row.classList.contains('border-dashed')) {
            row.className = 'bg-white/60 border border-gray-100 rounded-2xl p-4 flex flex-col justify-between hover:border-yellow-300 transition-colors shadow-sm';

            if (icon) {
                icon.className = 'p-2 bg-yellow-50 text-yellow-600 rounded-xl';
                icon.innerHTML = `
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>`;
            }

            // Append view button to header
            const topDiv = row.querySelector('.flex.items-center.gap-2.mb-4') ?? row.querySelector('.flex');
            if (topDiv) {
                topDiv.className = 'flex items-center justify-between gap-2 mb-4 w-full';
                const viewBtn = document.createElement('button');
                viewBtn.onclick   = () => simulateViewPdf(activeDocName, 'En Revisión');
                viewBtn.className = 'text-gray-400 hover:text-gray-700 transition-all';
                viewBtn.innerHTML = `
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>`;
                topDiv.appendChild(viewBtn);
            }

            if (actions) {
                actions.innerHTML = `
                    <button onclick="openUploadModal(${activeDocId}, '${activeDocName}')"
                            class="w-full text-center py-2 border border-gray-200 hover:bg-gray-50 text-gray-600 text-xs font-bold rounded-xl transition-all shadow-sm">
                        Volver a Subir
                    </button>`;
            }
        }

        showToast('¡Expediente Actualizado!', `El documento "${activeDocName}" ha sido cargado. Su estado es "En Revisión".`);
    }

    // ─────────────────────────────────────────────────────────────
    // PDF Viewer Modal
    // ─────────────────────────────────────────────────────────────
    function simulateViewPdf(docName, status) {
        document.getElementById('pdfModalTitle').textContent    = `Visor de Documentos: ${docName}`;
        document.getElementById('pdfModalSubtitle').textContent = `Estado de Validación: ${status} | Previsualización Digital`;
        document.getElementById('pdfDocDocName').textContent    = docName.toUpperCase();
        document.getElementById('pdfModal').classList.remove('hidden');
    }

    function closePdfModal() {
        document.getElementById('pdfModal').classList.add('hidden');
    }

    // ─────────────────────────────────────────────────────────────
    // Toast Notification
    // ─────────────────────────────────────────────────────────────
    function showToast(title, message) {
        document.getElementById('toastTitle').textContent   = title;
        document.getElementById('toastMessage').textContent = message;

        const toast = document.getElementById('projectSuccessToast');
        toast.classList.remove('hidden');

        setTimeout(() => toast.classList.add('hidden'), 6000);
    }
</script>
