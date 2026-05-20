@extends('layouts.empresa', ['title' => 'Reportes y Estadísticas - Prácticas Profesionales UdeC', 'active' => 'reportes'])

@section('content')
    <!-- Header -->
    <x-page-header title="Reportes y Estadísticas" description="Monitorea el progreso de tus practicantes, visualiza métricas clave y genera informes descargables.">
        <x-slot name="actions">
            <div class="relative inline-block text-left" id="exportDropdownContainer">
                <button onclick="toggleExportMenu()" class="flex items-center gap-2 bg-[#6BA53A] hover:bg-[#4E7D24] text-white font-bold py-2.5 px-5 rounded-2xl transition-all duration-300 shadow-md hover:shadow-lg cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Exportar Reporte
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <!-- Dropdown menu -->
                <div id="exportMenu" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-2xl shadow-xl z-50 overflow-hidden scale-95 opacity-0 transition-all duration-150">
                    <div class="py-1">
                        <button onclick="triggerExport('PDF')" class="w-full text-left px-4 py-3 text-xs font-bold text-gray-700 hover:bg-[#6BA53A]/10 hover:text-[#4E7D24] transition-colors flex items-center gap-2.5 cursor-pointer">
                            <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h2a2 2 0 002-2V4a2 2 0 00-2-2H9zM4 6a2 2 0 012-2h1v10H6a2 2 0 01-2-2V6zm10 2a2 2 0 00-2 2v4a2 2 0 002 2h1a2 2 0 002-2v-4a2 2 0 00-2-2h-1z"></path></svg>
                            Exportar a PDF
                        </button>
                        <button onclick="triggerExport('Excel')" class="w-full text-left px-4 py-3 text-xs font-bold text-gray-700 hover:bg-[#6BA53A]/10 hover:text-[#4E7D24] transition-colors flex items-center gap-2.5 cursor-pointer">
                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5zm4 4.5a.5.5 0 00-1 0v3a.5.5 0 001 0v-3zm2 2a.5.5 0 01.5-.5h2a.5.5 0 010 1h-2a.5.5 0 01-.5-.5z" clip-rule="evenodd"></path></svg>
                            Exportar a Excel
                        </button>
                        <button onclick="triggerExport('CSV')" class="w-full text-left px-4 py-3 text-xs font-bold text-gray-700 hover:bg-[#6BA53A]/10 hover:text-[#4E7D24] transition-colors flex items-center gap-2.5 cursor-pointer">
                            <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-9.707a1 1 0 011.414 0L9 9.586V3a1 1 0 112 0v6.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            Exportar a CSV
                        </button>
                    </div>
                </div>
            </div>
        </x-slot>
    </x-page-header>

    <!-- Metrics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 fade-in-up delay-100">
        <!-- Practicantes Activos -->
        <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group border-transparent hover:border-blue-300 transition-colors">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>
            </div>
            <span class="text-sm font-bold text-gray-500 mb-2">Practicantes Asignados</span>
            <div class="flex items-end gap-3 mb-2">
                <span class="text-4xl font-extrabold text-gray-900" id="statStudents">6</span>
            </div>
            <span class="text-xs text-gray-400 font-medium">Estudiantes en seguimiento activo</span>
        </div>

        <!-- Horas Totales -->
        <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group border-transparent hover:border-[#6BA53A]/30 transition-colors">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-[#4E7D24]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.8 2.8a1 1 0 101.414-1.414L11 9.586V6z" clip-rule="evenodd"></path></svg>
            </div>
            <span class="text-sm font-bold text-gray-500 mb-2">Horas Acumuladas</span>
            <div class="flex items-end gap-3 mb-2">
                <span class="text-4xl font-extrabold text-gray-900" id="statHours">1,080</span>
                <span class="text-xs text-gray-400 font-bold mb-1">hrs</span>
            </div>
            <span class="text-xs text-gray-400 font-medium">Suma total de horas aprobadas</span>
        </div>

        <!-- Progreso Promedio -->
        <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group border-transparent hover:border-green-300 transition-colors">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L10 10.586 13.586 7H12z" clip-rule="evenodd"></path></svg>
            </div>
            <span class="text-sm font-bold text-gray-500 mb-2">Progreso Promedio</span>
            <div class="flex items-end gap-3 mb-2">
                <span class="text-4xl font-extrabold text-gray-900" id="statProgress">37.5%</span>
            </div>
            <span class="text-xs text-green-500 font-semibold">Desempeño general estable</span>
        </div>

        <!-- Proyectos con Practicantes -->
        <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group border-transparent hover:border-purple-300 transition-colors">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-purple-500" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path></svg>
            </div>
            <span class="text-sm font-bold text-gray-500 mb-2">Proyectos Cubiertos</span>
            <div class="flex items-end gap-3 mb-2">
                <span class="text-4xl font-extrabold text-gray-900" id="statProjects">3</span>
            </div>
            <span class="text-xs text-gray-400 font-medium">Proyectos con alumnos asignados</span>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 fade-in-up delay-200">
        <!-- Carreras Distribution (62.5% SW, 25% Info, 12.5% Tele) -->
        <div class="glass-card rounded-3xl p-6 flex flex-col justify-between">
            <div>
                <h3 class="text-md font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Distribución por Carrera
                </h3>
                <div class="space-y-4">
                    <!-- SW -->
                    <div>
                        <div class="flex justify-between items-center text-xs font-bold text-gray-700 mb-1">
                            <span>Ing. en Software</span>
                            <span class="text-[#4E7D24]">3 alumnos (50%)</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-3">
                            <div class="bg-[#6BA53A] h-3 rounded-full" style="width: 50%"></div>
                        </div>
                    </div>
                    <!-- Info -->
                    <div>
                        <div class="flex justify-between items-center text-xs font-bold text-gray-700 mb-1">
                            <span>Lic. en Informática</span>
                            <span class="text-blue-600">2 alumnos (33%)</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-3">
                            <div class="bg-blue-500 h-3 rounded-full" style="width: 33%"></div>
                        </div>
                    </div>
                    <!-- Tele -->
                    <div>
                        <div class="flex justify-between items-center text-xs font-bold text-gray-700 mb-1">
                            <span>Ing. en Telemática</span>
                            <span class="text-orange-600">1 alumno (17%)</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-3">
                            <div class="bg-orange-500 h-3 rounded-full" style="width: 17%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <span class="text-[10px] text-gray-400 font-semibold mt-4">Actualizado dinámicamente según filtros.</span>
        </div>

        <!-- Genero Distribution (50% F, 50% M) -->
        <div class="glass-card rounded-3xl p-6 flex flex-col justify-between">
            <div>
                <h3 class="text-md font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Distribución por Género
                </h3>
                
                <div class="space-y-6 py-2">
                    <div class="flex items-center justify-between text-xs font-bold text-gray-700">
                        <span class="flex items-center gap-1.5 text-purple-600"><span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span> Femenino: 3 (50%)</span>
                        <span class="flex items-center gap-1.5 text-blue-600"><span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span> Masculino: 3 (50%)</span>
                    </div>

                    <!-- Split Progress Bar -->
                    <div class="w-full bg-gray-100 rounded-full h-5 overflow-hidden flex">
                        <div class="bg-purple-500 h-full" style="width: 50%" title="Femenino"></div>
                        <div class="bg-blue-500 h-full" style="width: 50%" title="Masculino"></div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-center text-xs">
                        <div class="bg-purple-50 p-2.5 rounded-2xl border border-purple-100">
                            <span class="text-[10px] text-purple-500 block font-bold">Mujeres</span>
                            <span class="font-extrabold text-purple-800 text-lg">3</span>
                        </div>
                        <div class="bg-blue-50 p-2.5 rounded-2xl border border-blue-100">
                            <span class="text-[10px] text-blue-500 block font-bold">Hombres</span>
                            <span class="font-extrabold text-blue-800 text-lg">3</span>
                        </div>
                    </div>
                </div>
            </div>
            <span class="text-[10px] text-gray-400 font-semibold mt-4">Métrica global del periodo actual.</span>
        </div>

        <!-- Modalidad Distribution (1 Presencial, 3 Hibrido, 2 Remoto) -->
        <div class="glass-card rounded-3xl p-6 flex flex-col justify-between">
            <div>
                <h3 class="text-md font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Distribución por Modalidad
                </h3>
                <div class="space-y-4">
                    <!-- Hibrido -->
                    <div>
                        <div class="flex justify-between items-center text-xs font-bold text-gray-700 mb-1">
                            <span>Híbrido</span>
                            <span class="text-gray-800">3 alumnos (50%)</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-3">
                            <div class="bg-gradient-to-r from-blue-400 to-indigo-500 h-3 rounded-full" style="width: 50%"></div>
                        </div>
                    </div>
                    <!-- Remoto -->
                    <div>
                        <div class="flex justify-between items-center text-xs font-bold text-gray-700 mb-1">
                            <span>Remoto</span>
                            <span class="text-gray-800">2 alumnos (33%)</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-3">
                            <div class="bg-gradient-to-r from-green-400 to-[#6BA53A] h-3 rounded-full" style="width: 33%"></div>
                        </div>
                    </div>
                    <!-- Presencial -->
                    <div>
                        <div class="flex justify-between items-center text-xs font-bold text-gray-700 mb-1">
                            <span>Presencial</span>
                            <span class="text-gray-800">1 alumno (17%)</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-3">
                            <div class="bg-gradient-to-r from-yellow-400 to-orange-500 h-3 rounded-full" style="width: 17%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <span class="text-[10px] text-gray-400 font-semibold mt-4">Modalidades del catálogo activo.</span>
        </div>
    </div>

    <!-- Filter and Detail Table Section -->
    <div class="glass-card rounded-3xl p-6 fade-in-up delay-300 flex flex-col gap-6">
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                Seguimiento de Practicantes
            </h3>
            
            <!-- Filters -->
            <div class="flex flex-wrap md:flex-nowrap gap-3 w-full md:w-auto">
                <div class="relative flex-1 md:flex-none md:w-64">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" id="reportSearch" placeholder="Buscar por alumno o proyecto..." class="w-full pl-9 pr-3 py-2 bg-white/50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#6BA53A] focus:border-transparent text-xs font-semibold">
                </div>

                <select id="reportCarrera" class="bg-white/50 border border-gray-200 rounded-xl px-3 py-2 text-xs font-semibold text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#6BA53A] cursor-pointer">
                    <option value="">Todas las Carreras</option>
                    <option value="software">Ingeniería en Software</option>
                    <option value="informatica">Licenciatura en Informática</option>
                    <option value="telematica">Ingeniería en Telemática</option>
                </select>

                <select id="reportGenero" class="bg-white/50 border border-gray-200 rounded-xl px-3 py-2 text-xs font-semibold text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#6BA53A] cursor-pointer">
                    <option value="">Todos los Géneros</option>
                    <option value="femenino">Femenino</option>
                    <option value="masculino">Masculino</option>
                </select>

                <select id="reportDesempeno" class="bg-white/50 border border-gray-200 rounded-xl px-3 py-2 text-xs font-semibold text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#6BA53A] cursor-pointer">
                    <option value="">Todos los Rendimientos</option>
                    <option value="excelente">Excelente</option>
                    <option value="a tiempo">A tiempo</option>
                    <option value="en riesgo">En riesgo</option>
                </select>
            </div>
        </div>

        <!-- Datatable -->
        <div class="overflow-x-auto bg-white/60 border border-gray-150 rounded-2xl">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Estudiante</th>
                        <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Proyecto & Tutor</th>
                        <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Progreso de Horas</th>
                        <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Desempeño</th>
                        <th class="px-6 py-3.5 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Bitácora</th>
                    </tr>
                </thead>
                <tbody class="bg-transparent divide-y divide-gray-200" id="reportTableBody">
                    
                    <!-- Student 1: María Rodríguez -->
                    <tr class="hover:bg-gray-50/50 transition-colors" data-carrera="software" data-genero="femenino" data-desempeno="a tiempo">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-9 w-9 rounded-full bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-sm select-none">MR</div>
                                <div class="ml-3">
                                    <div class="text-sm font-bold text-gray-900">María Rodríguez</div>
                                    <div class="text-[11px] text-gray-500 font-semibold">Ing. en Software · Femenino</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-800">App de Inventario</div>
                            <div class="text-[11px] text-gray-400 font-medium">Tutor: Carlos Mendoza</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-between text-xs font-bold text-gray-500 mb-1">
                                <span>240 / 480 hrs</span>
                                <span class="text-[#4E7D24]">50%</span>
                            </div>
                            <div class="w-36 bg-gray-150 rounded-full h-2">
                                <div class="bg-[#6BA53A] h-2 rounded-full" style="width: 50%"></div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-0.5 bg-green-50 text-green-700 border border-green-150 rounded-md text-xs font-bold uppercase tracking-wide">A tiempo</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-bold">
                            <button onclick="openActivitiesModal(1)" class="text-[#6BA53A] hover:text-[#4E7D24] transition-all cursor-pointer">Ver Reportes</button>
                        </td>
                    </tr>

                    <!-- Student 2: Juan López -->
                    <tr class="hover:bg-gray-50/50 transition-colors" data-carrera="informatica" data-genero="masculino" data-desempeno="excelente">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-9 w-9 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm select-none">JL</div>
                                <div class="ml-3">
                                    <div class="text-sm font-bold text-gray-900">Juan López</div>
                                    <div class="text-[11px] text-gray-500 font-semibold">Lic. en Informática · Masculino</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-800">Migración AWS</div>
                            <div class="text-[11px] text-gray-400 font-medium">Tutor: Laura Rodríguez</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-between text-xs font-bold text-gray-500 mb-1">
                                <span>432 / 480 hrs</span>
                                <span class="text-blue-600">90%</span>
                            </div>
                            <div class="w-36 bg-gray-150 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: 90%"></div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-0.5 bg-blue-50 text-blue-700 border border-blue-150 rounded-md text-xs font-bold uppercase tracking-wide">Excelente</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-bold">
                            <button onclick="openActivitiesModal(2)" class="text-[#6BA53A] hover:text-[#4E7D24] transition-all cursor-pointer">Ver Reportes</button>
                        </td>
                    </tr>

                    <!-- Student 3: Sofía Castro -->
                    <tr class="hover:bg-gray-50/50 transition-colors" data-carrera="software" data-genero="femenino" data-desempeno="a tiempo">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-9 w-9 rounded-full bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-sm select-none">SC</div>
                                <div class="ml-3">
                                    <div class="text-sm font-bold text-gray-900">Sofía Castro</div>
                                    <div class="text-[11px] text-gray-500 font-semibold">Ing. en Software · Femenino</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-800">App de Inventario</div>
                            <div class="text-[11px] text-gray-400 font-medium">Tutor: Carlos Mendoza</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-between text-xs font-bold text-gray-500 mb-1">
                                <span>120 / 480 hrs</span>
                                <span class="text-[#4E7D24]">25%</span>
                            </div>
                            <div class="w-36 bg-gray-150 rounded-full h-2">
                                <div class="bg-[#6BA53A] h-2 rounded-full" style="width: 25%"></div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-0.5 bg-green-50 text-green-700 border border-green-150 rounded-md text-xs font-bold uppercase tracking-wide">A tiempo</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-bold">
                            <button onclick="openActivitiesModal(3)" class="text-[#6BA53A] hover:text-[#4E7D24] transition-all cursor-pointer">Ver Reportes</button>
                        </td>
                    </tr>

                    <!-- Student 4: Pedro Gómez -->
                    <tr class="hover:bg-gray-50/50 transition-colors" data-carrera="informatica" data-genero="masculino" data-desempeno="a tiempo">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-9 w-9 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm select-none">PG</div>
                                <div class="ml-3">
                                    <div class="text-sm font-bold text-gray-900">Pedro Gómez</div>
                                    <div class="text-[11px] text-gray-500 font-semibold">Lic. en Informática · Masculino</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-800">App de Inventario</div>
                            <div class="text-[11px] text-gray-400 font-medium">Tutor: Carlos Mendoza</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-between text-xs font-bold text-gray-500 mb-1">
                                <span>48 / 480 hrs</span>
                                <span class="text-[#4E7D24]">10%</span>
                            </div>
                            <div class="w-36 bg-gray-150 rounded-full h-2">
                                <div class="bg-[#6BA53A] h-2 rounded-full" style="width: 10%"></div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-0.5 bg-green-50 text-green-700 border border-green-150 rounded-md text-xs font-bold uppercase tracking-wide">A tiempo</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-bold">
                            <button onclick="openActivitiesModal(4)" class="text-[#6BA53A] hover:text-[#4E7D24] transition-all cursor-pointer">Ver Reportes</button>
                        </td>
                    </tr>

                    <!-- Student 5: Ana Silva -->
                    <tr class="hover:bg-gray-50/50 transition-colors" data-carrera="software" data-genero="femenino" data-desempeno="en riesgo">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-9 w-9 rounded-full bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-sm select-none">AS</div>
                                <div class="ml-3">
                                    <div class="text-sm font-bold text-gray-900">Ana Silva</div>
                                    <div class="text-[11px] text-gray-500 font-semibold">Ing. en Software · Femenino</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-800">Migración AWS</div>
                            <div class="text-[11px] text-gray-400 font-medium">Tutor: Laura Rodríguez</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-between text-xs font-bold text-gray-500 mb-1">
                                <span>96 / 480 hrs</span>
                                <span class="text-red-500">20%</span>
                            </div>
                            <div class="w-36 bg-gray-150 rounded-full h-2">
                                <div class="bg-red-500 h-2 rounded-full" style="width: 20%"></div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-0.5 bg-red-50 text-red-700 border border-red-150 rounded-md text-xs font-bold uppercase tracking-wide">En riesgo</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-bold">
                            <button onclick="openActivitiesModal(5)" class="text-[#6BA53A] hover:text-[#4E7D24] transition-all cursor-pointer">Ver Reportes</button>
                        </td>
                    </tr>

                    <!-- Student 6: Luis Martínez -->
                    <tr class="hover:bg-gray-50/50 transition-colors" data-carrera="telematica" data-genero="masculino" data-desempeno="a tiempo">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-9 w-9 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm select-none">LM</div>
                                <div class="ml-3">
                                    <div class="text-sm font-bold text-gray-900">Luis Martínez</div>
                                    <div class="text-[11px] text-gray-500 font-semibold">Ing. en Telemática · Masculino</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-800">Automatización QA</div>
                            <div class="text-[11px] text-gray-400 font-medium">Tutor: Pedro Ortiz</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-between text-xs font-bold text-gray-500 mb-1">
                                <span>144 / 480 hrs</span>
                                <span class="text-[#4E7D24]">30%</span>
                            </div>
                            <div class="w-36 bg-gray-150 rounded-full h-2">
                                <div class="bg-[#6BA53A] h-2 rounded-full" style="width: 30%"></div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-0.5 bg-green-50 text-green-700 border border-green-150 rounded-md text-xs font-bold uppercase tracking-wide">A tiempo</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-bold">
                            <button onclick="openActivitiesModal(6)" class="text-[#6BA53A] hover:text-[#4E7D24] transition-all cursor-pointer">Ver Reportes</button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    <!-- Activities Tracking Modal -->
    <div id="activitiesModal" class="fixed inset-0 z-50 overflow-y-auto hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-all duration-300">
        <div class="bg-white rounded-3xl border border-gray-200 shadow-2xl max-w-2xl w-full max-h-[90vh] flex flex-col relative overflow-hidden transition-all duration-300 scale-95 opacity-0" id="modalCard">
            <!-- Modal Header -->
            <div class="px-8 py-5 bg-gradient-to-r from-gray-50 to-white border-b border-gray-150 flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2" id="modalTitle">
                    <svg class="w-6 h-6 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Historial de Actividades (Bitácoras)
                </h3>
                <button onclick="closeActivitiesModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 p-1.5 rounded-full transition-all cursor-pointer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Modal Body (Scrollable) -->
            <div class="flex-1 overflow-y-auto px-8 py-6 space-y-6">
                <!-- Estudiante Detalle -->
                <div class="bg-gray-50 border border-gray-150 p-4 rounded-2xl flex justify-between items-center text-sm">
                    <div>
                        <span class="text-xs text-gray-400 block font-bold uppercase tracking-wider">Estudiante</span>
                        <span class="font-extrabold text-gray-800 text-base" id="modalStudentName">María Rodríguez</span>
                        <span class="text-xs text-gray-500 block" id="modalStudentProject">Proyecto: App de Inventario</span>
                    </div>
                    <div class="text-right">
                        <span class="text-xs text-gray-400 block font-bold uppercase tracking-wider">Total Aprobado</span>
                        <span class="font-extrabold text-[#4E7D24] text-lg" id="modalStudentHours">240 hrs / 480 hrs</span>
                    </div>
                </div>

                <!-- Timeline / Bitácoras -->
                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Reportes Semanales Recientes</h4>
                    
                    <div class="space-y-4 border-l-2 border-gray-250 ml-4 pl-6 relative">
                        <!-- Log 1 -->
                        <div class="relative">
                            <div class="absolute -left-9 top-1.5 w-4.5 h-4.5 rounded-full bg-[#6BA53A] border-4 border-white"></div>
                            <div class="bg-white border border-gray-150 p-4 rounded-2xl shadow-sm">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-xs font-bold text-gray-800">Semana 3: Integración de Vistas y Firebase</span>
                                    <span class="px-2 py-0.5 bg-green-50 text-green-700 border border-green-150 rounded text-[10px] font-bold">Aprobado</span>
                                </div>
                                <p class="text-xs text-gray-500 leading-relaxed mb-3">
                                    Se integraron las maquetas de pantallas de stock de inventario con Firebase Firestore. Se implementó la lógica de autenticación básica de usuarios y el manejo de estados de conexión en la app móvil.
                                </p>
                                <div class="flex justify-between items-center text-[10px] text-gray-400 font-bold">
                                    <span>Horas reportadas: 40 hrs</span>
                                    <span>Fecha: 18/May/2026</span>
                                </div>
                            </div>
                        </div>

                        <!-- Log 2 -->
                        <div class="relative">
                            <div class="absolute -left-9 top-1.5 w-4.5 h-4.5 rounded-full bg-[#6BA53A] border-4 border-white"></div>
                            <div class="bg-white border border-gray-150 p-4 rounded-2xl shadow-sm">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-xs font-bold text-gray-800">Semana 2: Diseño UI/UX y Setup Flutter</span>
                                    <span class="px-2 py-0.5 bg-green-50 text-green-700 border border-green-150 rounded text-[10px] font-bold">Aprobado</span>
                                </div>
                                <p class="text-xs text-gray-500 leading-relaxed mb-3">
                                    Creación del wireframe y flujo de la aplicación. Configuración del entorno de desarrollo e inicialización del repositorio Git de Flutter. Creación del diseño inicial de botones y paleta de colores.
                                </p>
                                <div class="flex justify-between items-center text-[10px] text-gray-400 font-bold">
                                    <span>Horas reportadas: 40 hrs</span>
                                    <span>Fecha: 11/May/2026</span>
                                </div>
                            </div>
                        </div>

                        <!-- Log 3 -->
                        <div class="relative">
                            <div class="absolute -left-9 top-1.5 w-4.5 h-4.5 rounded-full bg-[#6BA53A] border-4 border-white"></div>
                            <div class="bg-white border border-gray-150 p-4 rounded-2xl shadow-sm">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-xs font-bold text-gray-800">Semana 1: Análisis de Requerimientos</span>
                                    <span class="px-2 py-0.5 bg-green-50 text-green-700 border border-green-150 rounded text-[10px] font-bold">Aprobado</span>
                                </div>
                                <p class="text-xs text-gray-500 leading-relaxed mb-3">
                                    Reuniones semanales iniciales con el tutor de la empresa. Definición del alcance del proyecto de inventario corporativo, casos de uso iniciales y arquitectura del backend.
                                </p>
                                <div class="flex justify-between items-center text-[10px] text-gray-400 font-bold">
                                    <span>Horas reportadas: 40 hrs</span>
                                    <span>Fecha: 04/May/2026</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-8 py-5 bg-gray-50 border-t border-gray-150 flex justify-end">
                <button onclick="closeActivitiesModal()" class="px-5 py-2.5 bg-[#6BA53A] hover:bg-[#4E7D24] text-white text-sm font-bold rounded-2xl transition-all shadow-sm cursor-pointer">
                    Cerrar Historial
                </button>
            </div>
        </div>
    </div>

    <!-- JS Handling for Reports page -->
    <script>
        // Toggle Export Menu dropdown
        function toggleExportMenu() {
            const menu = document.getElementById('exportMenu');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                setTimeout(() => {
                    menu.classList.remove('scale-95', 'opacity-0');
                    menu.classList.add('scale-100', 'opacity-100');
                }, 10);
            } else {
                menu.classList.remove('scale-100', 'opacity-100');
                menu.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    menu.classList.add('hidden');
                }, 150);
            }
        }

        // Close export menu when clicking outside
        window.addEventListener('click', function(e) {
            const dropdown = document.getElementById('exportDropdownContainer');
            if (dropdown && !dropdown.contains(e.target)) {
                const menu = document.getElementById('exportMenu');
                if (!menu.classList.contains('hidden')) {
                    menu.classList.remove('scale-100', 'opacity-100');
                    menu.classList.add('scale-95', 'opacity-0');
                    setTimeout(() => {
                        menu.classList.add('hidden');
                    }, 150);
                }
            }
        });

        // Trigger file export simulation
        function triggerExport(format) {
            alert(`¡Simulación: Generando y descargando reporte corporativo en formato ${format}!`);
            toggleExportMenu();
        }

        // Mock data for student logs
        const studentLogs = {
            1: { name: "María Rodríguez", project: "App de Inventario", hoursText: "240 hrs / 480 hrs" },
            2: { name: "Juan López", project: "Migración AWS", hoursText: "432 hrs / 480 hrs" },
            3: { name: "Sofía Castro", project: "App de Inventario", hoursText: "120 hrs / 480 hrs" },
            4: { name: "Pedro Gómez", project: "App de Inventario", hoursText: "48 hrs / 480 hrs" },
            5: { name: "Ana Silva", project: "Migración AWS", hoursText: "96 hrs / 480 hrs" },
            6: { name: "Luis Martínez", project: "Automatización QA", hoursText: "144 hrs / 480 hrs" }
        };

        // Open Activities Timeline Modal
        function openActivitiesModal(id) {
            const data = studentLogs[id];
            document.getElementById('modalStudentName').textContent = data.name;
            document.getElementById('modalStudentProject').textContent = `Proyecto: ${data.project}`;
            document.getElementById('modalStudentHours').textContent = data.hoursText;

            const modal = document.getElementById('activitiesModal');
            const card = document.getElementById('modalCard');

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            document.body.style.overflow = 'hidden';
        }

        function closeActivitiesModal() {
            const modal = document.getElementById('activitiesModal');
            const card = document.getElementById('modalCard');
            
            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = 'auto';
            }, 200);
        }

        // Handle Escape Key to close modal
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeActivitiesModal();
            }
        });

        // Live Table Search and Filters
        const tableSearchInput = document.getElementById('reportSearch');
        const selectReportCarrera = document.getElementById('reportCarrera');
        const selectReportGenero = document.getElementById('reportGenero');
        const selectReportDesempeno = document.getElementById('reportDesempeno');

        function filterReportTable() {
            const query = tableSearchInput.value.toLowerCase();
            const carreraFilter = selectReportCarrera.value;
            const generoFilter = selectReportGenero.value;
            const desempenoFilter = selectReportDesempeno.value;
            
            const rows = document.querySelectorAll('#reportTableBody > tr');
            let visibleCount = 0;
            let totalHours = 0;
            let sumPercent = 0;

            rows.forEach(row => {
                const name = row.querySelector('.text-sm.font-bold.text-gray-900').textContent.toLowerCase();
                const project = row.querySelector('.text-sm.font-semibold.text-gray-800').textContent.toLowerCase();
                const carrera = row.getAttribute('data-carrera');
                const genero = row.getAttribute('data-genero');
                const desempeno = row.getAttribute('data-desempeno');
                
                const matchesSearch = name.includes(query) || project.includes(query);
                const matchesCarrera = !carreraFilter || carrera === carreraFilter;
                const matchesGenero = !generoFilter || genero === generoFilter;
                const matchesDesempeno = !desempenoFilter || desempeno === desempenoFilter;

                if (matchesSearch && matchesCarrera && matchesGenero && matchesDesempeno) {
                    row.style.display = 'table-row';
                    visibleCount++;
                    
                    // Pull hours from text
                    const hrsText = row.querySelector('.flex.items-center.justify-between.text-xs.font-bold.text-gray-500 span').textContent;
                    const hoursVal = parseInt(hrsText.split('/')[0].trim());
                    totalHours += hoursVal;

                    // Pull percent
                    const percentText = row.querySelector('.flex.items-center.justify-between.text-xs.font-bold.text-gray-500 span:nth-child(2)').textContent;
                    const percentVal = parseInt(percentText.replace('%', ''));
                    sumPercent += percentVal;
                } else {
                    row.style.display = 'none';
                }
            });

            // Dynamically update metrics based on filtered subset
            document.getElementById('statStudents').textContent = visibleCount;
            document.getElementById('statHours').textContent = totalHours.toLocaleString();
            
            const avgProgress = visibleCount > 0 ? (sumPercent / visibleCount).toFixed(1) + '%' : '0%';
            document.getElementById('statProgress').textContent = avgProgress;
        }

        tableSearchInput.addEventListener('input', filterReportTable);
        selectReportCarrera.addEventListener('change', filterReportTable);
        selectReportGenero.addEventListener('change', filterReportTable);
        selectReportDesempeno.addEventListener('change', filterReportTable);
    </script>
@endsection
