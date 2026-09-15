<!-- Modal for Bulk Student Registration from Excel -->
<div id="bulkUploadModal" class="fixed inset-0 z-[100] hidden overflow-hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Include SheetJS Library for client-side Excel parsing -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

    <div class="flex items-center justify-center min-h-screen p-4 md:p-6 text-center">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500/75 backdrop-blur-sm" aria-hidden="true" onclick="closeBulkUploadModal()"></div>

        <!-- Modal panel -->
        <div class="relative flex flex-col w-full max-w-4xl bg-white rounded-3xl shadow-2xl overflow-hidden transition-all transform glass-card max-h-[calc(100vh-4rem)] z-10">
            
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="bg-[#4E7D24]/10 p-2 rounded-xl text-[#4E7D24]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900" id="modal-title">Subir Estudiantes desde Excel</h3>
                        <p class="text-xs text-gray-500 font-medium">Registra múltiples alumnos rápidamente mediante un archivo Excel o CSV.</p>
                    </div>
                </div>
                <button type="button" class="text-gray-400 hover:text-gray-500 transition-colors" onclick="closeBulkUploadModal()">
                    <span class="sr-only">Cerrar</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <!-- Scrollable Content -->
            <div class="px-6 py-6 md:px-8 overflow-y-auto flex-grow custom-scrollbar">
                
                <!-- Server-Side Error Alert Box -->
                <div id="bulkErrorAlert" class="hidden mb-6 bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-2xl shadow-sm flex flex-col gap-2 transition-all">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <span class="font-bold text-sm">Errores detectados en la importación:</span>
                    </div>
                    <ul id="bulkErrorList" class="list-disc pl-9 text-xs font-semibold space-y-1 mt-1 max-h-32 overflow-y-auto custom-scrollbar">
                        <!-- Filled by JS -->
                    </ul>
                </div>

                <div class="space-y-6">
                    <!-- Template Download Tool -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-between items-center bg-[#6BA53A]/5 px-5 py-4 rounded-2xl border border-[#6BA53A]/10">
                        <div class="flex items-start gap-3">
                            <div class="bg-[#4E7D24]/10 p-1.5 rounded-lg text-[#4E7D24] mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-[#4E7D24]">¿No tienes la plantilla del Excel?</p>
                                <p class="text-xs text-gray-600">Descarga nuestro formato de plantilla oficial estructurado para evitar errores de carga.</p>
                            </div>
                        </div>
                        <button type="button" onclick="downloadBulkTemplate()" class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-4 py-2 rounded-xl text-xs font-bold transition-all shadow-sm hover:shadow flex items-center gap-2 w-full sm:w-auto justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Descargar Plantilla
                        </button>
                    </div>

                    <!-- Drag and Drop Zone -->
                    <div>
                        <input type="file" id="excelFile" accept=".xlsx, .xls, .csv" class="hidden" onchange="handleFileSelect(event)">
                        
                        <div id="dropZone" 
                             onclick="document.getElementById('excelFile').click()" 
                             class="border-3 border-dashed border-[#6BA53A]/30 hover:border-[#6BA53A] bg-gray-50/50 hover:bg-[#6BA53A]/5 transition-all rounded-3xl p-10 flex flex-col items-center justify-center cursor-pointer group relative overflow-hidden select-none">
                            
                            <div class="flex flex-col items-center justify-center text-center space-y-3 z-10">
                                <div class="bg-[#6BA53A]/10 p-4 rounded-full text-[#6BA53A] group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-base font-bold text-gray-800">Selecciona o arrastra tu archivo Excel aquí</p>
                                    <p class="text-xs text-gray-500 font-semibold mt-1">Formatos permitidos: .xlsx, .xls, .csv (Máximo 10MB)</p>
                                </div>
                            </div>
                        </div>

                        <!-- Selected File indicator bar -->
                        <div id="selectedFileBar" class="hidden mt-4 items-center justify-between bg-gray-50 border border-gray-200 px-5 py-3 rounded-2xl animate-fade-in">
                            <div class="flex items-center gap-3 min-w-0">
                                <svg class="w-8 h-8 text-[#4E7D24] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <div class="min-w-0">
                                    <p id="fileName" class="text-sm font-bold text-gray-900 truncate">archivo.xlsx</p>
                                    <p id="fileSize" class="text-xs text-gray-500">1.2 MB</p>
                                </div>
                            </div>
                            <button type="button" onclick="clearFile()" class="text-gray-400 hover:text-red-600 transition-colors p-1.5 rounded-lg hover:bg-red-50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Client-Side Excel Preview Table -->
                    <div id="previewArea" class="hidden space-y-4 animate-fade-in">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                            <h4 class="text-md font-bold text-[#4E7D24] flex items-center gap-2">
                                <span>Vista Previa de Alumnos Encontrados</span>
                                <span id="rowCountBadge" class="bg-gray-100 text-gray-800 text-xs px-2.5 py-0.5 rounded-full font-bold">0 filas</span>
                            </h4>
                            <div id="validationSummary" class="text-xs font-bold">
                                <!-- Filled by JS -->
                            </div>
                        </div>

                        <div class="overflow-x-auto border border-gray-200 rounded-2xl max-h-72 custom-scrollbar shadow-inner bg-white/50">
                            <table class="min-w-full divide-y divide-gray-200 table-fixed">
                                <thead class="bg-gray-50 sticky top-0 z-20">
                                    <tr>
                                        <th scope="col" class="w-8 px-2 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">#</th>
                                        <th scope="col" class="w-44 px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nombre Completo</th>
                                        <th scope="col" class="w-48 px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Correo Electrónico</th>
                                        <th scope="col" class="w-28 px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Matrícula</th>
                                        <th scope="col" class="w-40 px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Carrera</th>
                                        <th scope="col" class="w-20 px-3 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Sem</th>
                                        <th scope="col" class="w-20 px-3 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Gpo</th>
                                        <th scope="col" class="w-24 px-3 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-2xl">Estatus</th>
                                    </tr>
                                </thead>
                                <tbody id="previewTableBody" class="divide-y divide-gray-100 text-xs text-gray-700 bg-white">
                                    <!-- Rows populated dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer (Fixed) -->
            <div class="px-6 py-4 border-t border-gray-100 flex justify-between items-center bg-gray-50/50 flex-shrink-0">
                <span class="text-xs text-gray-500 font-semibold italic">* Se enviarán correos automáticos con accesos a cada estudiante.</span>
                <div class="flex gap-3">
                    <button type="button" onclick="closeBulkUploadModal()" class="px-5 py-2.5 border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors text-sm">
                        Cancelar
                    </button>
                    <button type="button" id="btnSubmitImport" onclick="submitImport()" disabled class="bg-gray-400 text-white cursor-not-allowed px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg transition-all flex items-center gap-2">
                        <span id="btnText">Importar Estudiantes</span>
                        <svg id="btnLoader" class="hidden w-5 h-5 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    let parsedStudents = [];

    // Drag & Drop event bindings
    const dropZone = document.getElementById('dropZone');
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropZone.classList.add('border-[#6BA53A]', 'bg-[#6BA53A]/5');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropZone.classList.remove('border-[#6BA53A]', 'bg-[#6BA53A]/5');
        }, false);
    });

    dropZone.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        if (files.length > 0) {
            document.getElementById('excelFile').files = files;
            processExcelFile(files[0]);
        }
    });

    function handleFileSelect(event) {
        const file = event.target.files[0];
        if (file) {
            processExcelFile(file);
        }
    }

    function processExcelFile(file) {
        // Validate file type
        const ext = file.name.split('.').pop().toLowerCase();
        if (!['xlsx', 'xls', 'csv'].includes(ext)) {
            alert('Formato de archivo no soportado. Sube un archivo Excel (.xlsx, .xls) o CSV.');
            clearFile();
            return;
        }

        // Show File bar
        document.getElementById('fileName').textContent = file.name;
        document.getElementById('fileSize').textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
        document.getElementById('selectedFileBar').classList.remove('hidden');
        document.getElementById('selectedFileBar').classList.add('flex');
        document.getElementById('dropZone').classList.add('hidden');

        // Parse file via FileReader & SheetJS
        const reader = new FileReader();
        reader.onload = function(e) {
            try {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, { type: 'array' });
                const firstSheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[firstSheetName];
                
                // Convert sheet to JSON arrays (header: 1 gets raw rows)
                const rows = XLSX.utils.sheet_to_json(worksheet, { header: 1, defval: "" });
                
                if (rows.length < 2) {
                    alert('El archivo Excel está vacío o no contiene filas de datos.');
                    clearFile();
                    return;
                }

                analyzeAndPreviewData(rows);
            } catch (err) {
                console.error(err);
                alert('Ocurrió un error al leer el archivo Excel. Asegúrate de que no esté dañado.');
                clearFile();
            }
        };
        reader.readAsArrayBuffer(file);
    }

    function mapHeaders(headerRow) {
        const map = {};
        headerRow.forEach((cell, index) => {
            if (cell === null || cell === undefined) return;
            const norm = cell.toString().toLowerCase().trim().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
            
            if (norm === 'correo' || norm === 'email' || norm === 'correo electronico') {
                map.correo = index;
            } else if (norm === 'matricula' || norm === 'cuenta' || norm === 'numero de cuenta' || norm === 'no cuenta' || norm === 'no. cuenta') {
                map.matricula = index;
            } else if (norm === 'nombre' || norm === 'nombre completo' || norm === 'nombre estudiante') {
                map.nombre = index;
            } else if (norm === 'carrera') {
                map.carrera = index;
            } else if (norm === 'semestre') {
                map.semestre = index;
            } else if (norm === 'grupo') {
                map.grupo = index;
            }
        });
        return map;
    }

    function analyzeAndPreviewData(rows) {
        const headerRow = rows[0];
        const headerMap = mapHeaders(headerRow);

        // Verify that all 6 columns exist
        const requiredFields = ['correo', 'matricula', 'nombre', 'carrera', 'semestre', 'grupo'];
        const missingFields = [];
        requiredFields.forEach(field => {
            if (headerMap[field] === undefined) {
                const labelMap = {
                    correo: 'Correo Electrónico',
                    matricula: 'Matrícula',
                    nombre: 'Nombre Completo',
                    carrera: 'Carrera',
                    semestre: 'Semestre',
                    grupo: 'Grupo'
                };
                missingFields.push(labelMap[field]);
            }
        });

        if (missingFields.length > 0) {
            alert(`Estructura inválida. Faltan las siguientes columnas en el archivo: \n- ${missingFields.join('\n- ')}\n\nPor favor, descarga y usa la plantilla de ejemplo.`);
            clearFile();
            return;
        }

        parsedStudents = [];
        const tableBody = document.getElementById('previewTableBody');
        tableBody.innerHTML = '';

        let errorsCount = 0;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        // Track list duplicates
        const seenEmails = new Set();
        const seenMatriculas = new Set();

        // Process rows (starting at 1)
        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            
            // Skip fully empty rows
            const isEmptyRow = row.every(cell => cell === null || cell === undefined || cell.toString().trim() === '');
            if (isEmptyRow) continue;

            const correo = (row[headerMap.correo] || '').toString().trim();
            const matricula = (row[headerMap.matricula] || '').toString().trim();
            const nombre = (row[headerMap.nombre] || '').toString().trim();
            const carrera = (row[headerMap.carrera] || '').toString().trim();
            const semestreRaw = (row[headerMap.semestre] || '').toString().trim();
            const grupo = (row[headerMap.grupo] || '').toString().trim();

            const student = { correo, matricula, nombre, carrera, semestre: semestreRaw, grupo, errors: [] };

            // Client-side Validations
            if (!nombre) {
                student.errors.push('Nombre requerido');
            }
            if (!correo) {
                student.errors.push('Correo requerido');
            } else if (!emailRegex.test(correo)) {
                student.errors.push('Correo inválido');
            } else if (seenEmails.has(correo.toLowerCase())) {
                student.errors.push('Correo repetido en archivo');
            } else {
                seenEmails.add(correo.toLowerCase());
            }

            if (!matricula) {
                student.errors.push('Matrícula requerida');
            } else if (seenMatriculas.has(matricula.toLowerCase())) {
                student.errors.push('Matrícula repetida en archivo');
            } else {
                seenMatriculas.add(matricula.toLowerCase());
            }

            if (!carrera) {
                student.errors.push('Carrera requerida');
            }
            
            const semesterInt = parseInt(semestreRaw, 10);
            if (!semestreRaw) {
                student.errors.push('Semestre requerido');
            } else if (isNaN(semesterInt) || semesterInt < 1 || semesterInt > 12) {
                student.errors.push('Semestre debe ser 1-12');
            } else {
                student.semestre = semesterInt;
            }

            if (!grupo) {
                student.errors.push('Grupo requerido');
            }

            parsedStudents.push(student);

            // Render Preview row
            const tr = document.createElement('tr');
            tr.className = 'hover:bg-gray-50/50 transition-colors';
            
            let statusHtml = '';
            if (student.errors.length > 0) {
                errorsCount++;
                tr.className += ' bg-red-50/30';
                statusHtml = `<span class="px-2 py-0.5 inline-flex text-[10px] leading-4 font-bold rounded bg-red-50 text-red-700 border border-red-100" title="${student.errors.join(', ')}">Error</span>`;
            } else {
                statusHtml = `<span class="px-2 py-0.5 inline-flex text-[10px] leading-4 font-bold rounded bg-green-50 text-green-700 border border-green-100">Listo</span>`;
            }

            tr.innerHTML = `
                <td class="px-2 py-2 text-center text-gray-500 font-bold">${i}</td>
                <td class="px-3 py-2 font-bold truncate max-w-xs" title="${nombre}">${nombre}</td>
                <td class="px-3 py-2 truncate max-w-xs" title="${correo}">${correo}</td>
                <td class="px-3 py-2 font-mono">${matricula}</td>
                <td class="px-3 py-2 truncate max-w-xs" title="${carrera}">${carrera}</td>
                <td class="px-3 py-2 text-center font-bold">${semestreRaw}</td>
                <td class="px-3 py-2 text-center font-bold">${grupo}</td>
                <td class="px-3 py-2 text-center">${statusHtml}</td>
            `;

            // If row has errors, show full list as helper text in a subrow or title
            if (student.errors.length > 0) {
                tr.setAttribute('title', 'Errores: ' + student.errors.join(' | '));
            }
            
            tableBody.appendChild(tr);
        }

        // Show table area
        document.getElementById('previewArea').classList.remove('hidden');
        document.getElementById('rowCountBadge').textContent = `${parsedStudents.length} filas`;
        
        // Show validation summary
        const summaryDiv = document.getElementById('validationSummary');
        if (errorsCount > 0) {
            summaryDiv.className = 'text-xs font-bold text-red-600';
            summaryDiv.textContent = `⚠️ Se encontraron ${errorsCount} filas con errores de formato. Por favor corrígelos.`;
            document.getElementById('btnSubmitImport').disabled = true;
            document.getElementById('btnSubmitImport').className = 'bg-gray-400 text-white cursor-not-allowed px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg transition-all flex items-center gap-2';
        } else {
            summaryDiv.className = 'text-xs font-bold text-green-600';
            summaryDiv.textContent = `✅ Todos los registros (${parsedStudents.length}) son válidos y listos para importar.`;
            document.getElementById('btnSubmitImport').disabled = false;
            document.getElementById('btnSubmitImport').className = 'bg-[#4E7D24] text-white hover:bg-[#2E5417] px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 cursor-pointer';
        }
    }

    function clearFile() {
        document.getElementById('excelFile').value = '';
        document.getElementById('selectedFileBar').classList.remove('flex');
        document.getElementById('selectedFileBar').classList.add('hidden');
        document.getElementById('dropZone').classList.remove('hidden');
        document.getElementById('previewArea').classList.add('hidden');
        document.getElementById('previewTableBody').innerHTML = '';
        document.getElementById('btnSubmitImport').disabled = true;
        document.getElementById('btnSubmitImport').className = 'bg-gray-400 text-white cursor-not-allowed px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg transition-all flex items-center gap-2';
        document.getElementById('bulkErrorAlert').classList.add('hidden');
        document.getElementById('bulkErrorList').innerHTML = '';
        parsedStudents = [];
    }

    function closeBulkUploadModal() {
        document.getElementById('bulkUploadModal').classList.add('hidden');
        clearFile();
    }

    function downloadBulkTemplate() {
        // Build dynamic CSV Content with UTF-8 BOM
        const headers = ['Correo', 'Matricula', 'Nombre Completo', 'Carrera', 'Semestre', 'Grupo'];
        const rows = [
            ['estudiante1@ucol.mx', '20214820', 'Carlos Alberto Gomez Vazquez', 'Ingeniería de Software', '6', 'E'],
            ['estudiante2@ucol.mx', '20215904', 'Maria Fernanda Lopez Perez', 'Ingeniería en Mecatrónica', '8', 'A']
        ];
        
        let csvContent = "\uFEFF"; // UTF-8 BOM so Excel decodes Spanish accents correctly
        csvContent += headers.join(',') + '\r\n';
        rows.forEach(r => {
            csvContent += r.join(',') + '\r\n';
        });

        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement("a");
        const url = URL.createObjectURL(blob);
        link.setAttribute("href", url);
        link.setAttribute("download", "plantilla_estudiantes.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function submitImport() {
        if (parsedStudents.length === 0) return;

        const btn = document.getElementById('btnSubmitImport');
        const btnText = document.getElementById('btnText');
        const btnLoader = document.getElementById('btnLoader');
        const alertBox = document.getElementById('bulkErrorAlert');
        const errorList = document.getElementById('bulkErrorList');

        // Set Loading State
        btn.disabled = true;
        btn.classList.add('opacity-75', 'cursor-wait');
        btnText.textContent = 'Procesando...';
        btnLoader.classList.remove('hidden');
        alertBox.classList.add('hidden');
        errorList.innerHTML = '';

        // Dispatch fetch API POST request
        fetch("{{ route('admin.usuarios.bulk-store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: JSON.stringify({ students: parsedStudents })
        })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(res => {
            if (res.status === 200 && res.body.success) {
                // Bulk import completed successfully, reload page to display success flash alert
                window.location.reload();
            } else {
                // Show errors returned from server validation
                btn.disabled = false;
                btn.classList.remove('opacity-75', 'cursor-wait');
                btnText.textContent = 'Importar Estudiantes';
                btnLoader.classList.add('hidden');

                alertBox.classList.remove('hidden');
                
                const errors = res.body.errors || ['Ocurrió un error inesperado al procesar la solicitud en el servidor.'];
                errors.forEach(err => {
                    const li = document.createElement('li');
                    li.textContent = err;
                    errorList.appendChild(li);
                });
                
                // Scroll up inside modal to let the user see the alert
                document.querySelector('#bulkUploadModal .overflow-y-auto').scrollTop = 0;
            }
        })
        .catch(err => {
            console.error(err);
            btn.disabled = false;
            btn.classList.remove('opacity-75', 'cursor-wait');
            btnText.textContent = 'Importar Estudiantes';
            btnLoader.classList.add('hidden');

            alertBox.classList.remove('hidden');
            const li = document.createElement('li');
            li.textContent = 'Error de conexión. No se pudo establecer comunicación con el servidor.';
            errorList.appendChild(li);
            
            document.querySelector('#bulkUploadModal .overflow-y-auto').scrollTop = 0;
        });
    }

    // Expose functions globally for inline HTML event handlers
    window.handleFileSelect = handleFileSelect;
    window.clearFile = clearFile;
    window.closeBulkUploadModal = closeBulkUploadModal;
    window.downloadBulkTemplate = downloadBulkTemplate;
    window.submitImport = submitImport;
})();
</script>
