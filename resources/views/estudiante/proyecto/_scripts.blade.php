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
        document.getElementById('uploadDocNameInput').value       = docName;
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

        document.getElementById('uploadDocumentForm').submit();
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
