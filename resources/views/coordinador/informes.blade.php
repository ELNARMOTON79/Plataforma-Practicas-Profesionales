@extends('layouts.coordinador', ['active' => 'informes', 'title' => 'Informes y Reportes - Coordinador'])

@section('content')
    <!-- Header Section -->
    <x-page-header title="Reportes y Exportación" description="Genera y exporta reportes detallados en formato PDF o Excel de estudiantes, instituciones y proyectos." />

    <!-- Floating Toast Notification -->
    <div id="export-toast" class="fixed top-6 right-6 z-[9999] transform translate-x-[150%] transition-transform duration-500 ease-out bg-white rounded-2xl shadow-2xl border border-gray-100 p-4 max-w-sm flex items-start gap-3 text-left">
        <div class="bg-green-50 p-2 rounded-xl text-green-600 flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <h4 class="text-xs font-bold text-gray-900 uppercase">Exportación Exitosa</h4>
            <p id="toast-message" class="text-[11px] text-gray-500 font-semibold mt-1">El archivo se ha generado con éxito y tu descarga iniciará en breve.</p>
        </div>
    </div>

    <!-- Main Grid: Configuration & Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8 fade-in-up delay-100">
        
        <!-- Column 1 & 2: Configuración (Formulario) -->
        <div class="lg:col-span-2 glass-card rounded-3xl p-6 md:p-8 text-left">
            <div class="mb-6 border-b border-gray-100 pb-4">
                <h2 class="text-base font-bold text-gray-800 flex items-center gap-2">
                    <div class="bg-[#6BA53A]/10 p-2 rounded-xl text-[#4E7D24]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    </div>
                    Configuración de Reporte
                </h2>
                <p class="text-xs text-gray-400 font-medium mt-1">Personaliza tu reporte filtrando por programa, género y ciclo escolar.</p>
            </div>

            <form class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tipo de Reporte -->
                <div class="md:col-span-2">
                    <label for="tipo-reporte" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tipo de Reporte</label>
                    <select id="tipo-reporte" onchange="updateReportPreview()" name="tipo_reporte" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#6BA53A] focus:border-transparent text-xs font-semibold text-gray-700 outline-none cursor-pointer appearance-none">
                        <option value="estudiantes">Reporte de Estudiantes Activos</option>
                        <option value="instituciones">Reporte de Instituciones vinculadas</option>
                        <option value="proyectos">Reporte de Catálogo de Proyectos</option>
                    </select>
                </div>

                <!-- Carrera -->
                <div>
                    <label for="filtro-carrera" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Carrera</label>
                    <select id="filtro-carrera" onchange="updateReportPreview()" name="carrera" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#6BA53A] focus:border-transparent text-xs font-semibold text-gray-700 outline-none cursor-pointer appearance-none">
                        <option value="">Todas las carreras</option>
                        @foreach($carreras as $carrera)
                            <option value="{{ $carrera }}">{{ $carrera }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Ciclo Escolar -->
                <div>
                    <label for="filtro-ciclo" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Ciclo Escolar</label>
                    <select id="filtro-ciclo" onchange="updateReportPreview()" name="ciclo" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#6BA53A] focus:border-transparent text-xs font-semibold text-gray-700 outline-none cursor-pointer appearance-none">
                        <option value="AGO-2026/ENE-2027">AGO-2026/ENE-2027</option>
                        <option value="FEB-2026/JUL-2026">FEB-2026/JUL-2026</option>
                        <option value="AGO-2025/ENE-2026">AGO-2025/ENE-2026</option>
                    </select>
                </div>

                <!-- Género -->
                <div>
                    <label for="filtro-genero" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Género</label>
                    <select id="filtro-genero" onchange="updateReportPreview()" name="genero" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#6BA53A] focus:border-transparent text-xs font-semibold text-gray-700 outline-none cursor-pointer appearance-none">
                        <option value="">Todos los géneros</option>
                        <option value="femenino">Femenino</option>
                        <option value="masculino">Masculino</option>
                    </select>
                </div>

                <!-- Modalidad -->
                <div>
                    <label for="filtro-modalidad" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Modalidad</label>
                    <select id="filtro-modalidad" onchange="updateReportPreview()" name="modalidad" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#6BA53A] focus:border-transparent text-xs font-semibold text-gray-700 outline-none cursor-pointer appearance-none">
                        <option value="">Todas las modalidades</option>
                        <option value="presencial">Presencial</option>
                        <option value="virtual">Virtual</option>
                        <option value="hibrido">Híbrido</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Column 3: Opciones de Exportación y Mini Gráfico -->
        <div class="glass-card rounded-3xl p-6 md:p-8 flex flex-col justify-between text-left">
            <div>
                <div class="mb-6 border-b border-gray-100 pb-4">
                    <h2 class="text-base font-bold text-gray-800 flex items-center gap-2">
                        <div class="bg-[#4E7D24]/10 p-2 rounded-xl text-[#4E7D24]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        </div>
                        Opciones de Exportación
                    </h2>
                </div>

                <!-- Export Buttons -->
                <div class="space-y-4 mb-6">
                    <!-- PDF -->
                    <button onclick="triggerExport('PDF')" id="btn-pdf" class="w-full group bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white p-3 rounded-2xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 flex items-center gap-3.5" aria-label="Exportar reporte a PDF">
                        <div class="bg-white/20 p-2 rounded-xl group-hover:scale-105 transition-transform flex-shrink-0">
                            <!-- Standard PDF SVG Icon -->
                            <svg id="pdf-icon" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            <!-- Spinner (hidden by default) -->
                            <svg id="pdf-spinner" class="w-6 h-6 animate-spin text-white hidden" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </div>
                        <div class="text-left leading-tight">
                            <h3 class="font-extrabold text-sm uppercase tracking-wide">Exportar a PDF</h3>
                            <p class="text-blue-100 text-[10px] font-semibold mt-0.5">Formato oficial para impresión</p>
                        </div>
                    </button>

                    <!-- Excel -->
                    <button onclick="triggerExport('Excel')" id="btn-excel" class="w-full group bg-gradient-to-r from-[#2E5417] to-[#4E7D24] hover:from-[#1f380f] hover:to-[#2E5417] text-white p-3 rounded-2xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 flex items-center gap-3.5" aria-label="Exportar reporte a Excel">
                        <div class="bg-white/20 p-2 rounded-xl group-hover:scale-105 transition-transform flex-shrink-0">
                            <!-- Standard Excel SVG Icon -->
                            <svg id="excel-icon" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <!-- Spinner (hidden by default) -->
                            <svg id="excel-spinner" class="w-6 h-6 animate-spin text-white hidden" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </div>
                        <div class="text-left leading-tight">
                            <h3 class="font-extrabold text-sm uppercase tracking-wide">Exportar a Excel</h3>
                            <p class="text-green-100 text-[10px] font-semibold mt-0.5">Hoja de cálculo procesable (.xlsx)</p>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Mini Dashboard / Distribución de Datos -->
            <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100/50">
                <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-3">Distribución del Reporte</h4>
                <div id="stats-bars-container" class="space-y-3">
                    <!-- Progress Bar 1 -->
                    <div>
                        <div class="flex justify-between text-[10px] font-bold text-gray-600 mb-1">
                            <span>Ingeniería de Software</span>
                            <span>60%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-[#4E7D24] h-full rounded-full transition-all duration-500" style="width: 60%"></div>
                        </div>
                    </div>
                    <!-- Progress Bar 2 -->
                    <div>
                        <div class="flex justify-between text-[10px] font-bold text-gray-600 mb-1">
                            <span>Ingeniería en Computación</span>
                            <span>30%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-[#6BA53A] h-full rounded-full transition-all duration-500" style="width: 30%"></div>
                        </div>
                    </div>
                    <!-- Progress Bar 3 -->
                    <div>
                        <div class="flex justify-between text-[10px] font-bold text-gray-600 mb-1">
                            <span>Ingeniería en Telemática</span>
                            <span>10%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-yellow-500 h-full rounded-full transition-all duration-500" style="width: 10%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Live Preview Panel -->
    <div class="glass-card rounded-3xl p-6 md:p-8 text-left fade-in-up delay-200">
        <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
            <h2 class="text-base font-bold text-gray-800 flex items-center gap-2">
                <div class="bg-[#6BA53A]/10 p-2 rounded-xl text-[#4E7D24]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </div>
                Vista Previa de Datos (Muestra de 5 filas)
            </h2>
            <span id="preview-badge" class="px-2.5 py-0.5 text-[9px] font-bold rounded-lg bg-gray-100 text-gray-600">Filtros Activos</span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50/50" id="preview-thead">
                    <!-- Dynamic Headers will be rendered here -->
                </thead>
                <tbody class="bg-transparent divide-y divide-gray-100" id="preview-tbody">
                    <!-- Dynamic Rows will be rendered here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Script Block: Dynamic table updating, stat bars updates & Toast simulation -->
    <script>
        // Mock databases for the 3 report types
        const mockDatabase = {
            estudiantes: {
                headers: ['Alumno / Matrícula', 'Carrera', 'Género', 'Ciclo Escolar', 'Estatus'],
                rows: [
                    ['DOMINGUEZ MARCOS JAZMIN<br><span class="text-[9px] text-gray-400 font-semibold">20206744</span>', 'Ingeniería de Software', 'Femenino', 'AGO-2026/ENE-2027', '<span class="px-2 py-0.5 rounded text-[9px] font-bold bg-green-50 text-green-700 border border-green-100">ACTIVO</span>'],
                    ['HERRERA RUIZ ALEJANDRO<br><span class="text-[9px] text-gray-400 font-semibold">20194852</span>', 'Ingeniería de Software', 'Masculino', 'AGO-2026/ENE-2027', '<span class="px-2 py-0.5 rounded text-[9px] font-bold bg-blue-50 text-blue-700 border border-blue-100">ASIGNADO</span>'],
                    ['FLORES SILVA MARIANA<br><span class="text-[9px] text-gray-400 font-semibold">20213094</span>', 'Ingeniería de Software', 'Femenino', 'AGO-2026/ENE-2027', '<span class="px-2 py-0.5 rounded text-[9px] font-bold bg-green-50 text-green-700 border border-green-100">ACTIVO</span>'],
                    ['PEREZ LOPEZ JUAN<br><span class="text-[9px] text-gray-400 font-semibold">20184752</span>', 'Ingeniero en Mecatronica', 'Masculino', 'AGO-2025/ENE-2026', '<span class="px-2 py-0.5 rounded text-[9px] font-bold bg-blue-50 text-blue-700 border border-blue-100">ASIGNADO</span>'],
                    ['ALONSO CÁRDENAS HÉCTOR<br><span class="text-[9px] text-gray-400 font-semibold">20201104</span>', 'Ingeniero en Mecatronica', 'Masculino', 'FEB-2026/JUL-2026', '<span class="px-2 py-0.5 rounded text-[9px] font-bold bg-yellow-50 text-yellow-700 border border-yellow-100">PENDIENTE</span>']
                ],
                stats: [
                    { label: 'Ingeniería de Software', percentage: 60, colorClass: 'bg-[#4E7D24]' },
                    { label: 'Ingeniero en Mecatronica', percentage: 40, colorClass: 'bg-[#6BA53A]' }
                ]
            },
            instituciones: {
                headers: ['Institución de Vinculación', 'Contacto Principal', 'Sector', 'Ubicación', 'Estatus Convenio'],
                rows: [
                    ['H. AYUNTAMIENTO DE COLIMA', 'Lic. Alejandro Silva<br><span class="text-[9px] text-gray-400 font-semibold">Ecología</span>', 'Público', 'Colima, Col.', '<span class="px-2 py-0.5 rounded text-[9px] font-bold bg-green-50 text-green-700 border border-green-100">VIGENTE</span>'],
                    ['TERNIUM MÉXICO S.A. DE C.V.', 'Ing. Roberto Garza<br><span class="text-[9px] text-gray-400 font-semibold">Sistemas TI</span>', 'Privado', 'San Nicolás de los G., NL', '<span class="px-2 py-0.5 rounded text-[9px] font-bold bg-green-50 text-green-700 border border-green-100">VIGENTE</span>'],
                    ['IMSS - DELEGACIÓN COLIMA', 'Arq. Patricia Orozco<br><span class="text-[9px] text-gray-400 font-semibold">Infraestructura</span>', 'Público', 'Colima, Col.', '<span class="px-2 py-0.5 rounded text-[9px] font-bold bg-green-50 text-green-700 border border-green-100">VIGENTE</span>'],
                    ['BRIGHTCODERS CONSULTING S.A. DE C.V.', 'Mtro. Carlos Rocha<br><span class="text-[9px] text-gray-400 font-semibold">Director Académico</span>', 'Privado', 'Colima, Col.', '<span class="px-2 py-0.5 rounded text-[9px] font-bold bg-green-50 text-green-700 border border-green-100">VIGENTE</span>'],
                    ['UNIVERSIDAD DE COLIMA', 'Mtra. Lucía Romero<br><span class="text-[9px] text-gray-400 font-semibold">Vinculación</span>', 'Público', 'Colima, Col.', '<span class="px-2 py-0.5 rounded text-[9px] font-bold bg-red-50 text-red-700 border border-red-100">POR RENOVAR</span>']
                ],
                stats: [
                    { label: 'Sector Público', percentage: 60, colorClass: 'bg-[#4E7D24]' },
                    { label: 'Sector Privado', percentage: 40, colorClass: 'bg-[#6BA53A]' }
                ]
            },
            proyectos: {
                headers: ['Título del Proyecto', 'Unidad Receptora', 'Modalidad', 'Cupos Disponibles', 'Ciclo Escolar'],
                rows: [
                    ['PLATAFORMA WEB PARA ADMINISTRACIÓN DE PRÁCTICAS', 'BRIGHTCODERS CONSULTING', 'Virtual', '0 de 1', 'AGO-2026/ENE-2027'],
                    ['DESARROLLO DE MÓDULO DE SEGUIMIENTO DE EGRESADOS', 'TERNIUM MÉXICO', 'Híbrido', '0 de 2', 'AGO-2026/ENE-2027'],
                    ['IMPLEMENTACIÓN DE REDES E INFRAESTRUCTURA DE TELECOM.', 'H. AYUNTAMIENTO DE COLIMA', 'Presencial', '3 de 3', 'AGO-2026/ENE-2027'],
                    ['ANÁLISIS Y OPTIMIZACIÓN DE EFICIENCIA ENERGÉTICA', 'IMSS - DELEGACIÓN COLIMA', 'Híbrido', '1 de 2', 'AGO-2026/ENE-2027'],
                    ['SISTEMA DE MONITOREO CLIMÁTICO CON IOT', 'H. AYUNTAMIENTO DE COLIMA', 'Presencial', '2 de 2', 'AGO-2026/ENE-2027']
                ],
                stats: [
                    { label: 'Modalidad Presencial', percentage: 40, colorClass: 'bg-[#4E7D24]' },
                    { label: 'Modalidad Híbrida', percentage: 40, colorClass: 'bg-[#6BA53A]' },
                    { label: 'Modalidad Virtual', percentage: 20, colorClass: 'bg-yellow-500' }
                ]
            }
        };

        // Populate Table headers and rows
        function updateReportPreview() {
            const reportType = document.getElementById('tipo-reporte').value;
            const db = mockDatabase[reportType];
            
            // 1. Update Table Headers
            let theadHtml = '<tr>';
            db.headers.forEach((header, index) => {
                let borderClass = '';
                if (index === 0) borderClass = 'rounded-tl-xl';
                if (index === db.headers.length - 1) borderClass = 'rounded-tr-xl';
                theadHtml += `<th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider ${borderClass}">${header}</th>`;
            });
            theadHtml += '</tr>';
            document.getElementById('preview-thead').innerHTML = theadHtml;

            // 2. Update Table Rows (Filtering mockups loosely for Carrera and Gender)
            const carrera = document.getElementById('filtro-carrera').value;
            const genero = document.getElementById('filtro-genero').value;
            const ciclo = document.getElementById('filtro-ciclo').value;
            const modalidad = document.getElementById('filtro-modalidad').value;

            let tbodyHtml = '';
            let count = 0;

            db.rows.forEach(row => {
                // Apply mock filters to simulate real filtering
                if (reportType === 'estudiantes') {
                    if (carrera && row[1] !== carrera) return;
                    if (genero === 'femenino' && row[2] !== 'Femenino') return;
                    if (genero === 'masculino' && row[2] !== 'Masculino') return;
                    if (row[3] !== ciclo) return;
                }
                if (reportType === 'proyectos') {
                    if (modalidad === 'presencial' && row[2] !== 'Presencial') return;
                    if (modalidad === 'virtual' && row[2] !== 'Virtual') return;
                    if (modalidad === 'hibrido' && row[2] !== 'Híbrido') return;
                    if (row[4] !== ciclo) return;
                }

                tbodyHtml += `<tr class="hover:bg-[#6BA53A]/5 transition-colors">`;
                row.forEach((cell, idx) => {
                    const textAlignment = idx === 3 && reportType === 'proyectos' ? 'text-center' : 'text-left';
                    tbodyHtml += `<td class="px-6 py-4.5 whitespace-nowrap text-xs font-semibold text-gray-800 ${textAlignment}">${cell}</td>`;
                });
                tbodyHtml += '</tr>';
                count++;
            });

            if (count === 0) {
                tbodyHtml = `<tr><td colspan="${db.headers.length}" class="px-6 py-8 text-center text-xs text-gray-400 font-bold">No se encontraron registros de muestra con los filtros aplicados.</td></tr>`;
            }

            document.getElementById('preview-tbody').innerHTML = tbodyHtml;

            // 3. Update Distribution Stats Panel
            let statsHtml = '';
            db.stats.forEach(stat => {
                statsHtml += `
                    <div>
                        <div class="flex justify-between text-[10px] font-bold text-gray-600 mb-1">
                            <span>${stat.label}</span>
                            <span>${stat.percentage}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                            <div class="${stat.colorClass} h-full rounded-full transition-all duration-500" style="width: ${stat.percentage}%"></div>
                        </div>
                    </div>
                `;
            });
            document.getElementById('stats-bars-container').innerHTML = statsHtml;

            // Update badge text
            document.getElementById('preview-badge').innerText = `${count} de muestra`;
        }

        // Simula la exportación del reporte seleccionado
        function triggerExport(format) {
            const reportSelect = document.getElementById('tipo-reporte');
            const reportName = reportSelect.options[reportSelect.selectedIndex].text;
            
            let btn, spinner, icon;
            if (format === 'PDF') {
                btn = document.getElementById('btn-pdf');
                spinner = document.getElementById('pdf-spinner');
                icon = document.getElementById('pdf-icon');
            } else {
                btn = document.getElementById('btn-excel');
                spinner = document.getElementById('excel-spinner');
                icon = document.getElementById('excel-icon');
            }

            // Lock click & trigger loading spinners
            btn.style.pointerEvents = 'none';
            icon.classList.add('hidden');
            spinner.classList.remove('hidden');

            setTimeout(() => {
                // Restore normal button state
                btn.style.pointerEvents = '';
                spinner.classList.add('hidden');
                icon.classList.remove('hidden');

                // Launch floating Toast
                const toast = document.getElementById('export-toast');
                document.getElementById('toast-message').innerText = `El "${reportName}" en formato ${format} se ha generado y descargado correctamente.`;
                toast.classList.remove('translate-x-[150%]');

                // Slide out toast after 4.5 seconds
                setTimeout(() => {
                    toast.classList.add('translate-x-[150%]');
                }, 4500);

            }, 1500);
        }

        // Initialize view on load
        document.addEventListener('DOMContentLoaded', function() {
            updateReportPreview();
        });
    </script>

    <style>
        /* Personalización de la flecha nativa de los selectores */
        select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%239ca3af' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 1rem center;
            background-repeat: no-repeat;
            background-size: 1.2em 1.2em;
            padding-right: 2.5rem;
        }
    </style>
@endsection
