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
                        <option value="">Todos los ciclos</option>
                        @foreach($ciclosEscolares as $ciclo)
                            <option value="{{ $ciclo }}">{{ $ciclo }}</option>
                        @endforeach
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

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8 fade-in-up delay-200">
        <!-- Carreras Distribution (62.5% SW, 25% Info, 12.5% Tele) -->
        <div class="glass-card rounded-3xl p-6 flex flex-col justify-between">
            <div>
                <h3 class="text-md font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Distribución por Carrera
                </h3>
                <div class="space-y-4 overflow-y-auto max-h-[160px] pr-2 custom-scrollbar">
                    @foreach($carrerasStats as $carrera => $count)
                        @php
                            $percentage = $totalAlumnos > 0 ? round(($count / $totalAlumnos) * 100) : 0;
                            // Generate a consistent color based on the string length or just use a default palette
                            $colors = ['bg-[#6BA53A]', 'bg-blue-500', 'bg-orange-500', 'bg-purple-500', 'bg-teal-500'];
                            $colorIndex = crc32($carrera) % count($colors);
                            $barColor = $colors[$colorIndex];
                            
                            $textColors = ['text-[#4E7D24]', 'text-blue-600', 'text-orange-600', 'text-purple-600', 'text-teal-600'];
                            $textColor = $textColors[$colorIndex];
                        @endphp
                        <div>
                            <div class="flex justify-between items-center text-xs font-bold text-gray-700 mb-1">
                                <span>{{ $carrera }}</span>
                                <span class="{{ $textColor }}">{{ $count }} alumnos ({{ $percentage }}%)</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-3">
                                <div class="{{ $barColor }} h-3 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <span class="text-[10px] text-gray-400 font-semibold mt-4">Actualizado dinámicamente según filtros.</span>
        </div>

        <!-- Genero Distribution -->
        <div class="glass-card rounded-3xl p-6 flex flex-col justify-between">
            <div>
                <h3 class="text-md font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Distribución por Género
                </h3>
                
                <div class="space-y-6 py-2">
                    @php
                        $countF = $generosStats['FEMENINO'] ?? 0;
                        $countM = $generosStats['MASCULINO'] ?? 0;
                        $totalGen = $countF + $countM;
                        $pctF = $totalGen > 0 ? round(($countF / $totalGen) * 100) : 0;
                        $pctM = $totalGen > 0 ? round(($countM / $totalGen) * 100) : 0;
                    @endphp
                    <div class="flex items-center justify-between text-xs font-bold text-gray-700">
                        <span class="flex items-center gap-1.5 text-purple-600"><span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span> Femenino: {{ $countF }} ({{ $pctF }}%)</span>
                        <span class="flex items-center gap-1.5 text-blue-600"><span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span> Masculino: {{ $countM }} ({{ $pctM }}%)</span>
                    </div>

                    <!-- Split Progress Bar -->
                    <div class="w-full bg-gray-100 rounded-full h-5 overflow-hidden flex">
                        <div class="bg-purple-500 h-full transition-all duration-500" style="width: {{ $pctF }}%" title="Femenino"></div>
                        <div class="bg-blue-500 h-full transition-all duration-500" style="width: {{ $pctM }}%" title="Masculino"></div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-center text-xs">
                        <div class="bg-purple-50 p-2.5 rounded-2xl border border-purple-100">
                            <span class="text-[10px] text-purple-500 block font-bold">Mujeres</span>
                            <span class="font-extrabold text-purple-800 text-lg">{{ $countF }}</span>
                        </div>
                        <div class="bg-blue-50 p-2.5 rounded-2xl border border-blue-100">
                            <span class="text-[10px] text-blue-500 block font-bold">Hombres</span>
                            <span class="font-extrabold text-blue-800 text-lg">{{ $countM }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <span class="text-[10px] text-gray-400 font-semibold mt-4">Métrica global del periodo actual.</span>
        </div>

        <!-- Modalidad Distribucion -->
        <div class="glass-card rounded-3xl p-6 flex flex-col justify-between">
            <div>
                <h3 class="text-md font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Distribución por Modalidad
                </h3>
                <div class="space-y-4 overflow-y-auto max-h-[160px] pr-2 custom-scrollbar">
                    @foreach($modalidadesStats as $modalidad => $count)
                        @php
                            $percentage = $totalProyectos > 0 ? round(($count / $totalProyectos) * 100) : 0;
                            
                            $modLower = strtolower($modalidad);
                            if (str_contains($modLower, 'hibrido') || str_contains($modLower, 'híbrido')) {
                                $gradient = 'from-blue-400 to-indigo-500';
                            } elseif (str_contains($modLower, 'remoto') || str_contains($modLower, 'virtual')) {
                                $gradient = 'from-green-400 to-[#6BA53A]';
                            } else {
                                $gradient = 'from-yellow-400 to-orange-500';
                            }
                        @endphp
                        <div>
                            <div class="flex justify-between items-center text-xs font-bold text-gray-700 mb-1">
                                <span class="capitalize">{{ $modalidad }}</span>
                                <span class="text-gray-800">{{ $count }} proyectos ({{ $percentage }}%)</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-3">
                                <div class="bg-gradient-to-r {{ $gradient }} h-3 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <span class="text-[10px] text-gray-400 font-semibold mt-4">Modalidades del catálogo activo.</span>
        </div>
    </div>

    <!-- Panel previo -->
    <div class="glass-card rounded-3xl p-6 md:p-8 text-left fade-in-up delay-300">
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
                   
                </thead>
                <tbody class="bg-transparent divide-y divide-gray-100" id="preview-tbody">
                    
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const mockDatabase = {!! $dbDataJson !!};

        function updateReportPreview() {
            const reportType = document.getElementById('tipo-reporte').value;
            const db = mockDatabase[reportType];
            
            let theadHtml = '<tr>';
            db.headers.forEach((header, index) => {
                let borderClass = '';
                if (index === 0) borderClass = 'rounded-tl-xl';
                if (index === db.headers.length - 1) borderClass = 'rounded-tr-xl';
                theadHtml += `<th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider ${borderClass}">${header}</th>`;
            });
            theadHtml += '</tr>';
            document.getElementById('preview-thead').innerHTML = theadHtml;

            const carrera = document.getElementById('filtro-carrera').value;
            const genero = document.getElementById('filtro-genero').value;
            const ciclo = document.getElementById('filtro-ciclo').value;
            const modalidad = document.getElementById('filtro-modalidad').value;

            let tbodyHtml = '';
            let count = 0;

            db.rows.forEach(row => {
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

 
            document.getElementById('preview-badge').innerText = `${count} de muestra`;
        }

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

            btn.style.pointerEvents = 'none';
            icon.classList.add('hidden');
            spinner.classList.remove('hidden');

            setTimeout(() => {

                btn.style.pointerEvents = '';
                spinner.classList.add('hidden');
                icon.classList.remove('hidden');


                const toast = document.getElementById('export-toast');
                document.getElementById('toast-message').innerText = `El "${reportName}" en formato ${format} se ha generado y descargado correctamente.`;
                toast.classList.remove('translate-x-[150%]');


                setTimeout(() => {
                    toast.classList.add('translate-x-[150%]');
                }, 4500);

            }, 1500);
        }


        document.addEventListener('DOMContentLoaded', function() {
            updateReportPreview();
        });
    </script>

    <style>

        select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%239ca3af' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 1rem center;
            background-repeat: no-repeat;
            background-size: 1.2em 1.2em;
            padding-right: 2.5rem;
        }
    </style>
@endsection
