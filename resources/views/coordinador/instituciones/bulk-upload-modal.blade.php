<!-- Modal for Bulk Institution Registration from Excel -->
<div id="institucionesBulkUploadModal" class="fixed inset-0 z-[100] hidden overflow-hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Include SheetJS Library for client-side Excel parsing -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

    <div class="flex items-center justify-center min-h-screen p-4 md:p-6 text-center">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500/75 backdrop-blur-sm" aria-hidden="true" onclick="closeBulkUploadModal()"></div>

        <!-- Modal panel -->
        <div class="relative flex flex-col w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden transition-all transform glass-card max-h-[calc(100vh-4rem)] z-10">
            
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="bg-[#4E7D24]/10 p-2 rounded-xl text-[#4E7D24]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div class="text-left">
                        <h3 class="text-xl font-bold text-gray-900" id="modal-title">Subir Instituciones desde Excel</h3>
                        <p class="text-xs text-gray-500 font-medium">Registra múltiples instituciones o empresas rápidamente mediante un archivo Excel o CSV.</p>
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
                <div id="institucionesBulkErrorAlert" class="hidden mb-6 bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-2xl shadow-sm flex flex-col gap-2 transition-all text-left">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <span class="font-bold text-sm">Errores detectados en la importación:</span>
                    </div>
                    <ul id="institucionesBulkErrorList" class="list-disc pl-9 text-xs font-semibold space-y-1 mt-1 max-h-32 overflow-y-auto custom-scrollbar">
                        <!-- Filled by JS -->
                    </ul>
                </div>

                <div class="space-y-6">
                    <!-- Template Download Tool -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-between items-center bg-[#6BA53A]/5 px-5 py-4 rounded-2xl border border-[#6BA53A]/10 text-left">
                        <div class="flex items-start gap-3">
                            <div class="bg-[#4E7D24]/10 p-1.5 rounded-lg text-[#4E7D24] mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-[#4E7D24]">¿No tienes la plantilla del Excel?</p>
                                <p class="text-xs text-gray-600">Descarga nuestro formato de plantilla oficial estructurado para evitar errores de carga.</p>
                            </div>
                        </div>
                        <button type="button" onclick="downloadInstitucionesBulkTemplate()" class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-4 py-2 rounded-xl text-xs font-bold transition-all shadow-sm hover:shadow flex items-center gap-2 w-full sm:w-auto justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Descargar Plantilla
                        </button>
                    </div>

                    <!-- Drag and Drop Zone -->
                    <div>
                        <input type="file" id="institucionesExcelFile" accept=".xlsx, .xls, .csv" class="hidden" onchange="handleInstitucionesFileSelect(event)">
                        
                        <div id="institucionesDropZone" 
                             onclick="document.getElementById('institucionesExcelFile').click()" 
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
                        <div id="institucionesSelectedFileBar" class="hidden mt-4 items-center justify-between bg-gray-50 border border-gray-200 px-5 py-3 rounded-2xl animate-fade-in">
                            <div class="flex items-center gap-3 min-w-0 text-left">
                                <svg class="w-8 h-8 text-[#4E7D24] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <div class="min-w-0">
                                    <p id="institucionesFileName" class="text-sm font-bold text-gray-900 truncate">archivo.xlsx</p>
                                    <p id="institucionesFileSize" class="text-xs text-gray-500">1.2 MB</p>
                                </div>
                            </div>
                            <button type="button" onclick="clearInstitucionesFile()" class="text-gray-400 hover:text-red-600 transition-colors p-1.5 rounded-lg hover:bg-red-50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Client-Side Excel Preview Table -->
                    <div id="institucionesPreviewArea" class="hidden space-y-4 animate-fade-in text-left">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                            <h4 class="text-md font-bold text-[#4E7D24] flex items-center gap-2">
                                <span>Vista Previa de Instituciones Encontradas</span>
                                <span id="institucionesRowCountBadge" class="bg-gray-100 text-gray-800 text-xs px-2.5 py-0.5 rounded-full font-bold">0 filas</span>
                            </h4>
                            <div id="institucionesValidationSummary" class="text-xs font-bold">
                                <!-- Filled by JS -->
                            </div>
                        </div>

                        <!-- Omitted Rows Alert Box -->
                        <div id="institucionesOmittedAlert" class="hidden bg-amber-50 border border-amber-200 text-amber-900 px-5 py-3 rounded-2xl shadow-sm flex flex-col gap-1 transition-all text-xs font-semibold">
                            <div class="flex items-center gap-2 text-amber-800 font-bold text-sm">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <span>Las siguientes instituciones no se importarán por falta de datos obligatorios:</span>
                            </div>
                            <ul id="institucionesOmittedList" class="list-disc pl-8 mt-1 space-y-0.5 max-h-32 overflow-y-auto custom-scrollbar">
                                <!-- Filled by JS -->
                            </ul>
                        </div>

                        <div class="overflow-x-auto border border-gray-200 rounded-2xl max-h-72 custom-scrollbar shadow-inner bg-white/50">
                            <table class="min-w-full divide-y divide-gray-200 table-fixed">
                                <thead class="bg-gray-50 sticky top-0 z-20">
                                    <tr>
                                        <th scope="col" class="w-8 px-2 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">#</th>
                                        <th scope="col" class="w-44 px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Institución</th>
                                        <th scope="col" class="w-44 px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">U. Receptora</th>
                                        <th scope="col" class="w-40 px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Correo</th>
                                        <th scope="col" class="w-44 px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Dirección</th>
                                        <th scope="col" class="w-32 px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Municipio</th>
                                        <th scope="col" class="w-32 px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Titular</th>
                                        <th scope="col" class="w-24 px-3 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Sistema</th>
                                        <th scope="col" class="w-24 px-3 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Sector</th>
                                        <th scope="col" class="w-24 px-3 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-2xl">Estatus</th>
                                    </tr>
                                </thead>
                                <tbody id="institucionesPreviewTableBody" class="divide-y divide-gray-100 text-xs text-gray-700 bg-white">
                                    <!-- Rows populated dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer (Fixed) -->
            <div class="px-6 py-4 border-t border-gray-100 flex justify-between items-center bg-gray-50/50 flex-shrink-0">
                <span class="text-xs text-gray-500 font-semibold italic text-left">* Se enviarán correos automáticos con accesos a cada institución.</span>
                <div class="flex gap-3">
                    <button type="button" onclick="closeBulkUploadModal()" class="px-5 py-2.5 border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors text-sm">
                        Cancelar
                    </button>
                    <button type="button" id="institucionesBtnSubmitImport" disabled class="bg-gray-400 text-white cursor-not-allowed px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg transition-all flex items-center gap-2">
                        <span id="institucionesBtnText">Importar Instituciones</span>
                        <svg id="institucionesBtnLoader" class="hidden w-5 h-5 animate-spin text-white" fill="none" viewBox="0 0 24 24">
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
    let parsedInstituciones = [];

    // Drag & Drop event bindings
    const dropZone = document.getElementById('institucionesDropZone');
    
    if (dropZone) {
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
                document.getElementById('institucionesExcelFile').files = files;
                processExcelFile(files[0]);
            }
        });
    }

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
        document.getElementById('institucionesFileName').textContent = file.name;
        document.getElementById('institucionesFileSize').textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
        document.getElementById('institucionesSelectedFileBar').classList.remove('hidden');
        document.getElementById('institucionesSelectedFileBar').classList.add('flex');
        document.getElementById('institucionesDropZone').classList.add('hidden');

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

    function findHeaderRow(rows) {
        for (let i = 0; i < Math.min(rows.length, 10); i++) {
            const row = rows[i];
            if (!row) continue;
            
            // Check if this row contains required keywords
            let matchCount = 0;
            row.forEach(cell => {
                if (cell === null || cell === undefined) return;
                const norm = cell.toString().toLowerCase().trim().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                if (['institucion', 'correo', 'email', 'direccion', 'domicilio', 'titular', 'cargo'].includes(norm)) {
                    matchCount++;
                }
            });
            
            // If it has at least 3 matches, we assume this is the header row
            if (matchCount >= 3) {
                return i;
            }
        }
        return -1; // Not found
    }

    function mapHeaders(headerRow) {
        const map = {};
        headerRow.forEach((cell, index) => {
            if (cell === null || cell === undefined) return;
            const norm = cell.toString().toLowerCase().trim().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
            
            if (norm === 'institucion' || norm === 'nombre' || norm === 'empresa' || norm === 'nombre de la institucion') {
                map.institucion = index;
            } else if (norm === 'sistema') {
                map.sistema = index;
            } else if (norm === 'sector') {
                map.sector = index;
            } else if (norm === 'unidad receptora' || norm === 'unidad_receptora' || norm === 'ur') {
                map.unidad_receptora = index;
            } else if (norm === 'titular' || norm === 'responsable') {
                map.titular = index;
            } else if (norm === 'cargo') {
                map.cargo = index;
            } else if (norm === 'correo' || norm === 'email' || norm === 'correo electronico') {
                map.correo = index;
            } else if (norm === 'direccion' || norm === 'domicilio') {
                map.direccion = index;
            } else if (norm === 'colonia') {
                map.colonia = index;
            } else if (norm === 'codigo postal' || norm === 'cp' || norm === 'c.p.' || norm === 'codigo_postal') {
                map.cp = index;
            } else if (norm === 'estado') {
                map.estado = index;
            } else if (norm === 'municipio') {
                map.municipio = index;
            } else if (norm === 'telefono' || norm === 'tel') {
                map.telefono = index;
            }
        });
        return map;
    }

    function analyzeAndPreviewData(rows) {
        const headerRowIndex = findHeaderRow(rows);
        if (headerRowIndex === -1) {
            alert('Estructura inválida. No se pudo encontrar la fila de encabezados en el archivo Excel.\n\nAsegúrate de que la tabla contenga las columnas obligatorias: INSTITUCION, CORREO, DIRECCION, TITULAR, CARGO.');
            clearFile();
            return;
        }

        const headerRow = rows[headerRowIndex];
        const headerMap = mapHeaders(headerRow);

        // Verify required columns exist
        const requiredFields = ['institucion', 'correo', 'direccion', 'titular', 'cargo'];
        const missingFields = [];
        requiredFields.forEach(field => {
            if (headerMap[field] === undefined) {
                const labelMap = {
                    institucion: 'INSTITUCION',
                    correo: 'CORREO',
                    direccion: 'DIRECCION',
                    titular: 'TITULAR',
                    cargo: 'CARGO'
                };
                missingFields.push(labelMap[field]);
            }
        });

        if (missingFields.length > 0) {
            alert(`Estructura inválida. Faltan las siguientes columnas obligatorias en la fila de encabezados encontrada (Fila ${headerRowIndex + 1}): \n- ${missingFields.join('\n- ')}\n\nPor favor, descarga y usa la plantilla de ejemplo.`);
            clearFile();
            return;
        }

        parsedInstituciones = [];
        const tableBody = document.getElementById('institucionesPreviewTableBody');
        tableBody.innerHTML = '';

        let errorsCount = 0;
        let omittedCount = 0;
        const omittedRowsList = [];
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        // Track list duplicates
        const seenEmails = new Set();
        const seenUnits = new Set();

        // Process rows (starting at headerRowIndex + 1)
        for (let i = headerRowIndex + 1; i < rows.length; i++) {
            const row = rows[i];
            
            // Skip fully empty rows
            const isEmptyRow = row.every(cell => cell === null || cell === undefined || cell.toString().trim() === '');
            if (isEmptyRow) continue;

            const institucion = (row[headerMap.institucion] || '').toString().trim();
            const sistema = (row[headerMap.sistema] || '').toString().trim();
            const sector = (row[headerMap.sector] || '').toString().trim();
            const unidad_receptora = (row[headerMap.unidad_receptora] || '').toString().trim();
            const titular = (row[headerMap.titular] || '').toString().trim();
            const cargo = (row[headerMap.cargo] || '').toString().trim();
            const correo = (row[headerMap.correo] || '').toString().trim();
            const direccion = (row[headerMap.direccion] || '').toString().trim();
            const colonia = (row[headerMap.colonia] || '').toString().trim();
            const cpRaw = (row[headerMap.cp !== undefined ? headerMap.cp : -1] || '').toString().trim();
            const estado = (row[headerMap.estado !== undefined ? headerMap.estado : -1] || '').toString().trim();
            const municipioRaw = (row[headerMap.municipio !== undefined ? headerMap.municipio : -1] || '').toString().trim();
            const telefono = (row[headerMap.telefono !== undefined ? headerMap.telefono : -1] || '').toString().trim();

            // Filter: Only allow Manzanillo (case-insensitive & accent-insensitive)
            const normalizedMunicipio = municipioRaw.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
            if (normalizedMunicipio !== 'manzanillo') {
                continue;
            }

            // Generate unique key for unit de-duplication in the file
            const normEmpresa = institucion.toLowerCase().replace(/\s+/g, ' ').trim();
            const normUr = unidad_receptora.toLowerCase().replace(/\s+/g, ' ').trim();
            const unitKey = `${normEmpresa}|${normUr}`;

            let isOmitted = false;
            let omitReason = '';

            // Check email issues
            if (!correo) {
                isOmitted = true;
                omitReason = 'Sin correo';
            } else if (!emailRegex.test(correo)) {
                isOmitted = true;
                omitReason = 'Correo inválido';
            } else if (!direccion) {
                // Check address issues
                isOmitted = true;
                omitReason = 'Sin dirección';
            } else if (seenUnits.has(unitKey)) {
                isOmitted = true;
                omitReason = 'Unidad receptora duplicada en el archivo';
            }

            const instObj = { 
                institucion, sistema, sector, unidad_receptora, titular, cargo, correo, 
                direccion, colonia, cp: 0, estado, municipio: municipioRaw, telefono, errors: [] 
            };

            if (isOmitted) {
                omittedCount++;
                omittedRowsList.push({
                    rowNum: i - headerRowIndex,
                    institucion: institucion || 'Institución sin nombre',
                    reason: omitReason
                });
            } else {
                // Client-side Validations
                if (!institucion) {
                    instObj.errors.push('Institución requerida');
                } else if (institucion.length > 255) {
                    instObj.errors.push('Institución excede 255 caracteres');
                }

                if (direccion && direccion.length > 500) {
                    instObj.errors.push('Dirección excede 500 caracteres');
                }

                if (sistema && sistema.length > 50) {
                    instObj.errors.push('Sistema excede 50 caracteres');
                }

                if (sector && sector.length > 50) {
                    instObj.errors.push('Sector excede 50 caracteres');
                }

                if (unidad_receptora && unidad_receptora.length > 100) {
                    instObj.errors.push('Unidad receptora excede 100 caracteres');
                }

                if (!titular) {
                    instObj.errors.push('Titular requerido');
                } else if (titular.length > 100) {
                    instObj.errors.push('Titular excede 100 caracteres');
                }

                if (!cargo) {
                    instObj.errors.push('Cargo requerido');
                } else if (cargo.length > 100) {
                    instObj.errors.push('Cargo excede 100 caracteres');
                }

                if (colonia && colonia.length > 50) {
                    instObj.errors.push('Colonia excede 50 caracteres');
                }

                if (estado && estado.length > 20) {
                    instObj.errors.push('Estado excede 20 caracteres');
                }

                if (municipioRaw && municipioRaw.length > 100) {
                    instObj.errors.push('Municipio excede 100 caracteres');
                }

                if (telefono && telefono.length > 50) {
                    instObj.errors.push('Teléfono excede 50 caracteres');
                }

                // Duplicate email in file is now allowed and will be linked to the same user credentials.
                seenEmails.add(correo.toLowerCase());
                seenUnits.add(unitKey);

                if (cpRaw) {
                    const parsedCp = parseInt(cpRaw, 10);
                    if (isNaN(parsedCp)) {
                        instObj.errors.push('Código Postal debe ser número');
                    } else {
                        instObj.cp = parsedCp;
                    }
                }

                parsedInstituciones.push(instObj);
            }

            // Render Preview row
            const tr = document.createElement('tr');
            
            let statusHtml = '';
            if (isOmitted) {
                tr.className = 'opacity-60 bg-gray-50/50 hover:bg-gray-100/50 transition-colors';
                statusHtml = `<span class="px-2 py-0.5 inline-flex text-[10px] leading-4 font-bold rounded bg-amber-50 text-amber-700 border border-amber-100" title="Registro Omitido: ${omitReason}">Omitido: ${omitReason}</span>`;
            } else if (instObj.errors.length > 0) {
                errorsCount++;
                tr.className = 'hover:bg-gray-50/50 transition-colors bg-red-50/30';
                statusHtml = `<span class="px-2 py-0.5 inline-flex text-[10px] leading-4 font-bold rounded bg-red-50 text-red-700 border border-red-100" title="${instObj.errors.join(', ')}">Error</span>`;
            } else {
                tr.className = 'hover:bg-gray-50/50 transition-colors';
                statusHtml = `<span class="px-2 py-0.5 inline-flex text-[10px] leading-4 font-bold rounded bg-green-50 text-green-700 border border-green-100">Listo</span>`;
            }

            tr.innerHTML = `
                <td class="px-2 py-2 text-center text-gray-500 font-bold">${i - headerRowIndex}</td>
                <td class="px-3 py-2 font-bold truncate max-w-[150px]" title="${institucion}">${institucion || '<span class="text-red-400">Sin datos</span>'}</td>
                <td class="px-3 py-2 truncate max-w-[120px]" title="${unidad_receptora}">${unidad_receptora || '-'}</td>
                <td class="px-3 py-2 truncate max-w-[150px]" title="${correo}">${correo || '<span class="text-red-400">Sin datos</span>'}</td>
                <td class="px-3 py-2 truncate max-w-[150px]" title="${direccion}">${direccion || '<span class="text-red-400">Sin datos</span>'}</td>
                <td class="px-3 py-2 font-bold text-green-700 truncate max-w-[100px]" title="${municipioRaw}">${municipioRaw}</td>
                <td class="px-3 py-2 truncate max-w-[100px]" title="${titular}">${titular || '-'}</td>
                <td class="px-3 py-2 text-center truncate max-w-[80px]" title="${sistema}">${sistema || '-'}</td>
                <td class="px-3 py-2 text-center truncate max-w-[80px]" title="${sector}">${sector || '-'}</td>
                <td class="px-3 py-2 text-center">${statusHtml}</td>
            `;

            if (!isOmitted && instObj.errors.length > 0) {
                tr.setAttribute('title', 'Errores: ' + instObj.errors.join(' | '));
            }
            
            tableBody.appendChild(tr);
        }

        // Show table area
        document.getElementById('institucionesPreviewArea').classList.remove('hidden');
        document.getElementById('institucionesRowCountBadge').textContent = `${parsedInstituciones.length + omittedCount} filas`;
        
        // Show omitted rows list
        const omittedAlert = document.getElementById('institucionesOmittedAlert');
        const omittedList = document.getElementById('institucionesOmittedList');
        
        if (omittedCount > 0) {
            omittedList.innerHTML = '';
            omittedRowsList.forEach(item => {
                const li = document.createElement('li');
                li.innerHTML = `Fila ${item.rowNum}: <strong class="text-amber-900">${item.institucion}</strong> - <span class="text-amber-800">${item.reason}</span>`;
                omittedList.appendChild(li);
            });
            omittedAlert.classList.remove('hidden');
        } else {
            omittedAlert.classList.add('hidden');
            omittedList.innerHTML = '';
        }

        // Show validation summary
        const summaryDiv = document.getElementById('institucionesValidationSummary');
        const submitBtn = document.getElementById('institucionesBtnSubmitImport');
        if (errorsCount > 0) {
            summaryDiv.className = 'text-xs font-bold text-red-600';
            summaryDiv.textContent = `⚠️ Se encontraron ${errorsCount} filas con errores. Por favor corrígelos en tu archivo.`;
            submitBtn.disabled = true;
            submitBtn.className = 'bg-gray-400 text-white cursor-not-allowed px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg transition-all flex items-center gap-2';
        } else if (parsedInstituciones.length === 0) {
            summaryDiv.className = 'text-xs font-bold text-amber-600';
            summaryDiv.textContent = `⚠️ No hay ningún registro válido para importar en este archivo (todos los ${omittedCount} registros fueron omitidos).`;
            submitBtn.disabled = true;
            submitBtn.className = 'bg-gray-400 text-white cursor-not-allowed px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg transition-all flex items-center gap-2';
        } else {
            summaryDiv.className = 'text-xs font-bold text-green-600';
            let msg = `✅ Listo para importar ${parsedInstituciones.length} instituciones.`;
            if (omittedCount > 0) {
                msg += ` (${omittedCount} serán omitidas por falta de correo o dirección).`;
            }
            summaryDiv.textContent = msg;
            submitBtn.disabled = false;
            submitBtn.className = 'bg-[#4E7D24] text-white hover:bg-[#2E5417] px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 cursor-pointer';
        }
    }

    function clearFile() {
        document.getElementById('institucionesExcelFile').value = '';
        document.getElementById('institucionesSelectedFileBar').classList.remove('flex');
        document.getElementById('institucionesSelectedFileBar').classList.add('hidden');
        document.getElementById('institucionesDropZone').classList.remove('hidden');
        document.getElementById('institucionesPreviewArea').classList.add('hidden');
        document.getElementById('institucionesPreviewTableBody').innerHTML = '';
        
        const submitBtn = document.getElementById('institucionesBtnSubmitImport');
        submitBtn.disabled = true;
        submitBtn.className = 'bg-gray-400 text-white cursor-not-allowed px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg transition-all flex items-center gap-2';
        
        document.getElementById('institucionesBulkErrorAlert').classList.add('hidden');
        document.getElementById('institucionesBulkErrorList').innerHTML = '';
        document.getElementById('institucionesOmittedAlert').classList.add('hidden');
        document.getElementById('institucionesOmittedList').innerHTML = '';
        parsedInstituciones = [];
    }

    function openBulkUploadModal() {
        document.getElementById('institucionesBulkUploadModal').classList.remove('hidden');
        const navbar = document.querySelector('nav');
        if (navbar) navbar.style.zIndex = '0';
    }

    function closeBulkUploadModal() {
        document.getElementById('institucionesBulkUploadModal').classList.add('hidden');
        const navbar = document.querySelector('nav');
        if (navbar) navbar.style.zIndex = '';
        clearFile();
    }

    function downloadBulkTemplate() {
        const headers = [
            'INSTITUCION', 'SISTEMA', 'SECTOR', 'UNIDAD RECEPTORA', 'TITULAR', 'CARGO', 
            'CORREO', 'DIRECCION', 'COLONIA', 'CODIGO POSTAL', 'ESTADO', 'MUNICIPIO', 'TELEFONO'
        ];
        const rows = [
            [
                'Universidad de Colima', 'ESTATAL', 'PÚBLICO', 'Facultad de Telemática', 'Mtro. Gerardo Alcaraz', 'Director', 
                'telematica@ucol.mx', 'Av. Universidad 333', 'Las Víboras', '28040', 'Colima', '1', '3123161100'
            ],
            [
                'Tech Solutions S.A. de C.V.', 'PRIVADA', 'PRIVADO', 'Departamento de Sistemas', 'Ing. Roberto Gomez', 'Gerente TI', 
                'contacto@techsolutions.com', 'Av. Constitución 450', 'Lomas de Circunvalación', '28010', 'Colima', '1', '3123154400'
            ]
        ];
        
        let csvContent = "\uFEFF"; // UTF-8 BOM
        csvContent += headers.join(',') + '\r\n';
        rows.forEach(r => {
            csvContent += r.map(val => `"${val.replace(/"/g, '""')}"`).join(',') + '\r\n';
        });

        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement("a");
        const url = URL.createObjectURL(blob);
        link.setAttribute("href", url);
        link.setAttribute("download", "plantilla_instituciones.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function submitImport() {
        if (parsedInstituciones.length === 0) return;

        const btn = document.getElementById('institucionesBtnSubmitImport');
        const btnText = document.getElementById('institucionesBtnText');
        const btnLoader = document.getElementById('institucionesBtnLoader');
        const alertBox = document.getElementById('institucionesBulkErrorAlert');
        const errorList = document.getElementById('institucionesBulkErrorList');

        // Set Loading State
        btn.disabled = true;
        btn.classList.add('opacity-75', 'cursor-wait');
        btnText.textContent = 'Procesando...';
        btnLoader.classList.remove('hidden');
        alertBox.classList.add('hidden');
        errorList.innerHTML = '';

        // Dispatch fetch API POST request
        fetch("{{ route('coordinador.instituciones.bulk-store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: JSON.stringify({ instituciones: parsedInstituciones })
        })
        .then(response => {
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                return response.json().then(data => ({ status: response.status, body: data }));
            } else {
                return response.text().then(text => ({ 
                    status: response.status, 
                    body: { errors: [`Error del servidor (${response.status}). El servidor no devolvió una respuesta JSON válida. Es posible que tu sesión haya expirado o haya un error de base de datos.`] } 
                }));
            }
        })
        .then(res => {
            if (res.status === 200 && res.body.success) {
                // Success, reload page
                window.location.reload();
            } else {
                // Reset states and show errors
                btn.disabled = false;
                btn.classList.remove('opacity-75', 'cursor-wait');
                btnText.textContent = 'Importar Instituciones';
                btnLoader.classList.add('hidden');

                alertBox.classList.remove('hidden');
                
                let errorsList = [];
                if (res.body.errors) {
                    if (Array.isArray(res.body.errors)) {
                        errorsList = res.body.errors;
                    } else if (typeof res.body.errors === 'object') {
                        errorsList = Object.values(res.body.errors).flat();
                    } else {
                        errorsList = [res.body.errors.toString()];
                    }
                } else {
                    errorsList = ['Ocurrió un error inesperado al procesar la solicitud en el servidor.'];
                }

                errorsList.forEach(err => {
                    const li = document.createElement('li');
                    li.textContent = err;
                    errorList.appendChild(li);
                });
                
                // Scroll up inside modal
                document.querySelector('#institucionesBulkUploadModal .overflow-y-auto').scrollTop = 0;
            }
        })
        .catch(err => {
            console.error(err);
            btn.disabled = false;
            btn.classList.remove('opacity-75', 'cursor-wait');
            btnText.textContent = 'Importar Instituciones';
            btnLoader.classList.add('hidden');

            alertBox.classList.remove('hidden');
            const li = document.createElement('li');
            li.textContent = 'Error de conexión. No se pudo establecer comunicación con el servidor.';
            errorList.appendChild(li);
            
            document.querySelector('#institucionesBulkUploadModal .overflow-y-auto').scrollTop = 0;
        });
    }

    // Expose functions globally for inline HTML event handlers
    window.openBulkUploadModal = openBulkUploadModal;
    window.closeBulkUploadModal = closeBulkUploadModal;
    window.handleInstitucionesFileSelect = handleFileSelect;
    window.clearInstitucionesFile = clearFile;
    window.downloadInstitucionesBulkTemplate = downloadBulkTemplate;
    
    // Bind click event to the submit button
    document.getElementById('institucionesBtnSubmitImport').addEventListener('click', submitImport);
})();
</script>
