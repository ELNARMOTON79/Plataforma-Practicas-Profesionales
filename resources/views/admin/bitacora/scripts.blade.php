<!-- TOAST NOTIFICATION CONTAINER -->
<div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2"></div>

<!-- JAVASCRIPT FOR INTERACTIVENESS -->
<script>
    var currentView = "{{ request('view', 'table') }}";

    // Toggle between Table view and Timeline view
    function toggleView(view) {
        currentView = view; 
        const tabTable = document.getElementById('tab-table');
        const tabTimeline = document.getElementById('tab-timeline');
        const containerTable = document.getElementById('container-table-view');
        const containerTimeline = document.getElementById('container-timeline-view');
        const filterView = document.getElementById('filter-view');

        if (filterView) {
            filterView.value = view;
        }

        if (view === 'table') {
            containerTable.classList.remove('hidden');
            containerTimeline.classList.add('hidden');

            tabTable.className = "px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 shadow bg-white text-[#4E7D24]";
            tabTimeline.className = "px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 text-gray-500 hover:text-gray-900";
        } else {
            containerTable.classList.add('hidden');
            containerTimeline.classList.remove('hidden');

            tabTable.className = "px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 text-gray-500 hover:text-gray-900";
            tabTimeline.className = "px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 shadow bg-white text-[#4E7D24]";
        }
    }

    // Inspect log details and open modal
    function inspectLog(log) {
        const modal = document.getElementById('logDetailModal');
        if (!modal) return;
        
        // Helper to safely set element text
        const setElementText = (id, text) => {
            const el = document.getElementById(id);
            if (el) el.textContent = text !== null && text !== undefined ? text : '';
        };

        // Set levels / badges
        const badge = document.getElementById('modal-badge');
        if (badge) {
            badge.innerText = log.level_name || '';
            badge.className = "px-2.5 py-1 text-xs font-extrabold uppercase rounded-lg";
            
            if (log.level === 'success') {
                badge.classList.add('bg-green-50', 'text-green-700', 'border', 'border-green-100');
            } else if (log.level === 'info') {
                badge.classList.add('bg-blue-50', 'text-blue-700', 'border', 'border-blue-100');
            } else if (log.level === 'warning') {
                badge.classList.add('bg-yellow-50', 'text-yellow-700', 'border', 'border-yellow-100');
            } else {
                badge.classList.add('bg-red-50', 'text-red-700', 'border', 'border-red-100');
            }
        }
        
        const avatar = document.getElementById('modal-avatar');
        if (avatar) {
            avatar.innerText = log.user_avatar_txt || '';
            avatar.className = "flex-shrink-0 h-10 w-10 rounded-full flex items-center justify-center font-extrabold text-sm shadow-xs " + (log.user_avatar_bg || 'bg-gray-100 text-gray-600');
        }

        // Bind values
        setElementText('modal-username', log.user);
        setElementText('modal-userrole', log.user_role);
        setElementText('modal-useremail', log.user_email);
        setElementText('modal-module', log.module);
        setElementText('modal-timestamp', log.timestamp);
        setElementText('modal-action-tag', log.action);
        setElementText('modal-ip', log.ip);
        setElementText('modal-description', log.description);
        setElementText('modal-useragent', log.user_agent);
        
        // Format JSON payload
        let rawJson = null;
        let isJsonParsed = false;
        
        if (log.payload) {
            if (typeof log.payload === 'object') {
                rawJson = log.payload;
                isJsonParsed = true;
            } else if (typeof log.payload === 'string') {
                try {
                    rawJson = JSON.parse(log.payload);
                    isJsonParsed = true;
                } catch (e) {
                    console.error("Error parsing JSON payload:", e);
                    rawJson = log.payload;
                    isJsonParsed = false;
                }
            } else {
                rawJson = log.payload;
                isJsonParsed = false;
            }
        }

        const modalJson = document.getElementById('modal-json');
        if (modalJson) {
            if (rawJson !== null && rawJson !== undefined) {
                modalJson.textContent = isJsonParsed ? JSON.stringify(rawJson, null, 4) : String(rawJson);
            } else {
                modalJson.textContent = 'Sin payload';
            }
        }

        modal.classList.remove('hidden');
    }

    // Close details modal
    function closeLogModal() {
        const modal = document.getElementById('logDetailModal');
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    // Copy JSON payload from modal to clipboard
    function copyJsonPayload() {
        const codeContent = document.getElementById('modal-json').textContent;
        navigator.clipboard.writeText(codeContent).then(() => {
            showToast('¡Carga JSON copiada al portapapeles!', 'success');
        }).catch(err => {
            showToast('Error al copiar JSON', 'danger');
        });
    }

    // Export logs (CSV and PDF with current active filters)
    function exportLogs(format) {
        // Collect current URL filters
        const searchParams = new URLSearchParams(window.location.search);
        searchParams.set('format', format);
        
        const url = "{{ route('admin.bitacora.export') }}?" + searchParams.toString();
        
        if (format === 'CSV') {
            showToast('Generando reporte CSV...', 'success');
            window.location.href = url;
        } else if (format === 'PDF') {
            showToast('Generando reporte PDF...', 'success');
            window.open(url, '_blank');
        }
    }

    // Open clear confirm modal
    function openClearLogsConfirm() {
        document.getElementById('clearLogsConfirmModal').classList.remove('hidden');
    }

    // Close clear confirm modal
    function closeClearLogsConfirm() {
        document.getElementById('clearLogsConfirmModal').classList.add('hidden');
    }

    // Execute clear logs on database
    function executeClearLogs() {
        closeClearLogsConfirm();
        showToast('Limpiando registros de bitácora...', 'info');

        const csrfToken = "{{ csrf_token() }}";

        fetch("{{ route('admin.bitacora.clear') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            }
            throw new Error('Error al vaciar la bitácora');
        })
        .then(data => {
            if (data.success) {
                document.getElementById('table-body').innerHTML = '';
                const timelineBody = document.getElementById('timeline-body');
                if (timelineBody) {
                    timelineBody.innerHTML = '';
                }
                
                document.getElementById('stat-total-events').innerText = '0';
                document.getElementById('stat-warnings').innerText = '0';
                document.getElementById('stat-errors').innerText = '0';
                document.getElementById('stat-total-records').innerText = '0';
                
                showToast('¡Bitácora vaciada con éxito!', 'success');
                
                // Reload page after a short delay to display the new audit event log
                setTimeout(() => {
                    window.location.reload();
                }, 1200);
            } else {
                showToast('No se pudo vaciar la bitácora.', 'danger');
            }
        })
        .catch(error => {
            console.error(error);
            showToast('Error al vaciar la bitácora.', 'danger');
        });
    }

    // Premium Toast Notifications helper
    function showToast(message, type = 'info') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        
        // Base tailwind classes
        toast.className = "flex items-center gap-3 px-5 py-3 rounded-2xl shadow-lg border text-sm font-semibold transition-all duration-300 transform translate-y-2 opacity-0 glass-card max-w-sm";
        
        // Style by type
        if (type === 'success') {
            toast.classList.add('border-green-150', 'text-green-800');
            toast.innerHTML = `<span class="h-6 w-6 rounded-full bg-green-500 text-white flex items-center justify-center flex-shrink-0"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5" d="M5 13l4 4L19 7"></path></svg></span> <span>${message}</span>`;
        } else if (type === 'danger') {
            toast.classList.add('border-red-150', 'text-red-800');
            toast.innerHTML = `<span class="h-6 w-6 rounded-full bg-red-500 text-white flex items-center justify-center flex-shrink-0"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg></span> <span>${message}</span>`;
        } else { // info
            toast.classList.add('border-blue-150', 'text-blue-800');
            toast.innerHTML = `<span class="h-6 w-6 rounded-full bg-blue-500 text-white flex items-center justify-center flex-shrink-0"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></span> <span>${message}</span>`;
        }

        container.appendChild(toast);
        
        // Reflow for transition
        setTimeout(() => {
            toast.classList.remove('translate-y-2', 'opacity-0');
        }, 10);

        // Remove toast after duration
        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-2');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 3000);
    }
</script>
