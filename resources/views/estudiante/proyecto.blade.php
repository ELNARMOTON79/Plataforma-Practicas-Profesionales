@extends('layouts.estudiante', ['title' => 'Mi Proyecto de Prácticas - Prácticas Profesionales UdeC', 'active' => 'proyecto'])

@section('content')
    <!-- Simulated Notifications Toast -->
    <div id="projectSuccessToast" class="hidden fixed top-5 right-5 z-[100] bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl shadow-xl max-w-md fade-in-up flex items-start gap-3">
        <div class="p-1 bg-green-100 text-green-600 rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <div>
            <h4 class="font-bold text-green-950 text-sm" id="toastTitle">¡Operación Exitosa!</h4>
            <p class="text-xs text-green-900/90 mt-0.5" id="toastMessage">Cambios aplicados correctamente en tu proyecto.</p>
        </div>
        <button onclick="document.getElementById('projectSuccessToast').classList.add('hidden')" class="text-green-500 hover:text-green-800 transition-colors ml-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <!-- Top Hero Banner (Ancho Completo) -->
    <div class="glass-card rounded-3xl p-8 relative overflow-hidden bg-gradient-to-r from-white via-white to-[#6BA53A]/5 border border-[#6BA53A]/25 fade-in-up">
        <div class="absolute -right-10 -top-10 w-44 h-44 bg-[#4E7D24] rounded-full mix-blend-multiply filter blur-2xl opacity-10"></div>
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="text-[10px] font-bold text-[#4E7D24] bg-[#6BA53A]/10 px-2.5 py-0.5 rounded-md border border-[#6BA53A]/20">Fase de Desarrollo</span>
                    <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-md text-[10px] font-bold bg-yellow-50 text-yellow-750 border border-yellow-150">
                        <span class="relative flex h-1.5 w-1.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-yellow-500"></span>
                        </span>
                        En Curso
                    </span>
                </div>
                <h1 class="text-3xl font-extrabold text-gray-900 leading-tight">Desarrollo de App Móvil</h1>
                <p class="text-sm font-bold text-gray-500 mt-1">Tech Solutions de Colima S.A. de C.V.</p>
            </div>

            <!-- Global Stats Columns inside Hero -->
            <div class="grid grid-cols-3 gap-6 lg:gap-12 border-t lg:border-t-0 lg:border-l border-gray-200/65 pt-6 lg:pt-0 lg:pl-12">
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Horas Totales</span>
                    <span class="text-2xl font-extrabold text-gray-900 flex items-baseline gap-1">
                        <span id="heroHoursLabel">120</span>
                        <span class="text-xs font-semibold text-gray-450">/ 360 h</span>
                    </span>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Días Transcurridos</span>
                    <span class="text-2xl font-extrabold text-gray-900 flex items-baseline gap-1">
                        30
                        <span class="text-xs font-semibold text-gray-450">/ 120 d</span>
                    </span>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Expediente</span>
                    <span class="text-2xl font-extrabold text-[#4E7D24] flex items-baseline gap-1" id="heroDocsLabel">
                        2
                        <span class="text-xs font-semibold text-gray-450">/ 6 docs</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Two-Column Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        
        <!-- Left: Objectives, Bitácora & Phases (2 Columns) -->
        <div class="lg:col-span-2 flex flex-col gap-6">
            
            <!-- Objective and Activities -->
            <div class="glass-card rounded-3xl p-6 fade-in-up delay-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Objetivo y Actividades a Realizar
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Objetivo General</span>
                        <p class="text-xs text-gray-700 leading-relaxed font-medium bg-gray-50/50 p-3.5 rounded-2xl border border-gray-150/40">
                            Diseñar y desarrollar una aplicación móvil híbrida (iOS y Android) para el control y seguimiento interno del inventario de hardware y licencias de software, facilitando la asignación eficiente de recursos tecnológicos.
                        </p>
                    </div>
                    
                    <div class="border-t border-gray-100 pt-3">
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2.5">Actividades Autorizadas</span>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs text-gray-700 font-semibold">
                            <label class="flex items-center gap-2.5 p-2 bg-white rounded-xl border border-gray-100">
                                <input type="checkbox" checked disabled class="rounded border-gray-300 text-[#4E7D24] focus:ring-[#6BA53A] cursor-not-allowed">
                                <span>Levantamiento de requerimientos</span>
                            </label>
                            <label class="flex items-center gap-2.5 p-2 bg-white rounded-xl border border-gray-100">
                                <input type="checkbox" checked disabled class="rounded border-gray-300 text-[#4E7D24] focus:ring-[#6BA53A] cursor-not-allowed">
                                <span>Diseño UX/UI de vistas móviles</span>
                            </label>
                            <label class="flex items-center gap-2.5 p-2 bg-white rounded-xl border border-gray-100">
                                <input type="checkbox" checked disabled class="rounded border-gray-300 text-[#4E7D24] focus:ring-[#6BA53A] cursor-not-allowed">
                                <span>Modelado y creación de BD y API</span>
                            </label>
                            <label class="flex items-center gap-2.5 p-2 bg-white rounded-xl border border-[#6BA53A]/20 bg-[#6BA53A]/5">
                                <input type="checkbox" disabled class="rounded border-gray-300 text-[#4E7D24] focus:ring-[#6BA53A] cursor-not-allowed">
                                <span class="text-[#4E7D24]">Programación móvil (Flutter)</span>
                            </label>
                            <label class="flex items-center gap-2.5 p-2 bg-white rounded-xl border border-gray-100">
                                <input type="checkbox" disabled class="rounded border-gray-300 text-[#4E7D24] focus:ring-[#6BA53A] cursor-not-allowed">
                                <span>Ejecución de pruebas y QA</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bitácora de Horas e Actividades -->
            <div class="glass-card rounded-3xl p-6 fade-in-up delay-150">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        Bitácora y Reporte de Horas
                    </span>
                    <button onclick="toggleBitacoraForm()" id="btnToggleBitacora" class="text-xs font-bold text-[#4E7D24] bg-[#6BA53A]/10 px-3 py-1.5 rounded-xl hover:bg-[#4E7D24] hover:text-white transition-all flex items-center gap-1 shadow-sm">
                        Registrar Actividades
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </h3>

                <!-- Simulated Form (Hidden by default, expandable) -->
                <div id="bitacoraFormContainer" class="hidden bg-gray-50 border border-gray-150/50 rounded-2xl p-5 mb-5 space-y-4 fade-in-up">
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Añadir Actividad a Bitácora</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="sm:col-span-2">
                            <label for="bitacoraDesc" class="block text-[11px] font-bold text-gray-400 mb-1">Descripción de la Tarea</label>
                            <input type="text" id="bitacoraDesc" class="block w-full border border-gray-200 rounded-xl px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/20 focus:border-[#6BA53A] font-semibold" placeholder="Ej. Diseño de UI para la pantalla de Login...">
                        </div>
                        <div>
                            <label for="bitacoraHours" class="block text-[11px] font-bold text-gray-400 mb-1">Horas Dedicadas</label>
                            <input type="number" id="bitacoraHours" class="block w-full border border-gray-200 rounded-xl px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/20 focus:border-[#6BA53A] font-bold text-center" value="10" min="1" max="60">
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <button onclick="toggleBitacoraForm()" class="bg-white border border-gray-200 text-gray-550 text-xs font-bold px-4 py-2 rounded-xl hover:bg-gray-50 transition-colors">Cancelar</button>
                        <button onclick="addBitacoraEntry()" class="bg-[#4E7D24] text-white text-xs font-bold px-5 py-2 rounded-xl hover:bg-[#3A5D1B] transition-all shadow-sm">Guardar Registro</button>
                    </div>
                </div>

                <!-- Bitacora Table Logs -->
                <div class="overflow-hidden bg-white/60 border border-gray-100 rounded-2xl shadow-inner">
                    <table class="min-w-full divide-y divide-gray-200" id="bitacoraTable">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th scope="col" class="px-5 py-3 text-left text-[10px] font-bold text-gray-450 uppercase tracking-wider">Fecha / Periodo</th>
                                <th scope="col" class="px-5 py-3 text-left text-[10px] font-bold text-gray-450 uppercase tracking-wider">Actividades Reportadas</th>
                                <th scope="col" class="px-5 py-3 text-center text-[10px] font-bold text-gray-450 uppercase tracking-wider">Horas</th>
                                <th scope="col" class="px-5 py-3 text-center text-[10px] font-bold text-gray-450 uppercase tracking-wider">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="bg-transparent divide-y divide-gray-155" id="bitacoraBody">
                            <tr class="hover:bg-[#6BA53A]/5 transition-colors">
                                <td class="px-5 py-3 whitespace-nowrap text-xs font-bold text-gray-500">Semana 4 (Reciente)</td>
                                <td class="px-5 py-3 text-xs font-semibold text-gray-700">Creación de base de datos relacional en PostgreSQL e integración de llaves foráneas.</td>
                                <td class="px-5 py-3 whitespace-nowrap text-center text-xs font-extrabold text-gray-900">30 h</td>
                                <td class="px-5 py-3 whitespace-nowrap text-center">
                                    <span class="text-[9px] font-bold text-green-700 bg-green-50 border border-green-150 px-2 py-0.5 rounded-md">Validado</span>
                                </td>
                            </tr>
                            <tr class="hover:bg-[#6BA53A]/5 transition-colors">
                                <td class="px-5 py-3 whitespace-nowrap text-xs font-bold text-gray-500">Semana 3</td>
                                <td class="px-5 py-3 text-xs font-semibold text-gray-700">Diseño de prototipo de interfaces de usuario para app móvil en Figma.</td>
                                <td class="px-5 py-3 whitespace-nowrap text-center text-xs font-extrabold text-gray-900">30 h</td>
                                <td class="px-5 py-3 whitespace-nowrap text-center">
                                    <span class="text-[9px] font-bold text-green-700 bg-green-50 border border-green-150 px-2 py-0.5 rounded-md">Validado</span>
                                </td>
                            </tr>
                            <tr class="hover:bg-[#6BA53A]/5 transition-colors">
                                <td class="px-5 py-3 whitespace-nowrap text-xs font-bold text-gray-500">Semana 2</td>
                                <td class="px-5 py-3 text-xs font-semibold text-gray-700">Levantamiento de requerimientos y juntas de análisis de la lógica del sistema.</td>
                                <td class="px-5 py-3 whitespace-nowrap text-center text-xs font-extrabold text-gray-900">35 h</td>
                                <td class="px-5 py-3 whitespace-nowrap text-center">
                                    <span class="text-[9px] font-bold text-green-700 bg-green-50 border border-green-150 px-2 py-0.5 rounded-md">Validado</span>
                                </td>
                            </tr>
                            <tr class="hover:bg-[#6BA53A]/5 transition-colors">
                                <td class="px-5 py-3 whitespace-nowrap text-xs font-bold text-gray-500">Semana 1</td>
                                <td class="px-5 py-3 text-xs font-semibold text-gray-700">Inducción a la empresa y capacitación sobre lineamientos internos del departamento.</td>
                                <td class="px-5 py-3 whitespace-nowrap text-center text-xs font-extrabold text-gray-900">25 h</td>
                                <td class="px-5 py-3 whitespace-nowrap text-center">
                                    <span class="text-[9px] font-bold text-green-700 bg-green-50 border border-green-150 px-2 py-0.5 rounded-md">Validado</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>

        <!-- Right Column: Visual Hours Wheel & Technical Info (1 Column) -->
        <div class="flex flex-col gap-6">
            
            <!-- Circular Progress Ring (Anillo Circular) -->
            <div class="glass-card rounded-3xl p-6 fade-in-up delay-250 flex flex-col items-center justify-center text-center">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-6 w-full text-left">Porcentaje de Avance</h3>
                
                <!-- Circular Chart SVG -->
                <div class="relative w-40 h-40 flex items-center justify-center">
                    <svg class="w-full h-full transform -rotate-95" viewBox="0 0 100 100">
                        <!-- Background Circle -->
                        <circle class="text-gray-100" stroke-width="8" stroke="currentColor" fill="transparent" r="40" cx="50" cy="50"/>
                        <!-- Foreground Circle -->
                        <circle class="text-blue-500 transition-all duration-700 ease-out" id="circularProgressRing" stroke-width="8" stroke-dasharray="251.2" stroke-dashoffset="167.4" stroke-linecap="round" stroke="currentColor" fill="transparent" r="40" cx="50" cy="50"/>
                    </svg>
                    
                    <!-- Center Labels -->
                    <div class="absolute flex flex-col items-center justify-center">
                        <span class="text-3xl font-extrabold text-gray-900" id="circularHoursText">120 h</span>
                        <span class="text-[10px] text-gray-450 font-bold uppercase tracking-wider mt-0.5">de 360 totales</span>
                    </div>
                </div>

                <div class="mt-6 w-full bg-blue-50/50 rounded-2xl p-4 border border-blue-100/50">
                    <span class="block text-xs font-bold text-blue-900 mb-0.5" id="circularPercentageText">33.3% Completado</span>
                    <span class="text-[11px] text-blue-800/80 font-medium" id="circularHoursRemaining">Faltan 240 horas para acreditar tus prácticas.</span>
                </div>
            </div>

            <!-- Ficha Técnica del Convenio y Asesor -->
            <div class="glass-card rounded-3xl p-6 fade-in-up delay-300">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Información del Asesor</h3>
                
                <div class="flex items-center gap-3.5 mb-5 pb-5 border-b border-gray-150/50">
                    <div class="w-11 h-11 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 shadow-sm border border-gray-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div>
                        <span class="block text-sm font-extrabold text-gray-900">Ing. Roberto Medina</span>
                        <span class="block text-xs text-gray-500 font-semibold mt-0.5">Asesor de Desarrollo, Tech Solutions</span>
                    </div>
                </div>

                <div class="space-y-4 text-xs text-gray-700 font-semibold mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 font-bold">Correo:</span>
                        <a href="mailto:rmedina@techsolutions.com" class="text-[#4E7D24] hover:underline">rmedina@techsolutions.com</a>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 font-bold">Departamento:</span>
                        <span class="text-gray-900">Desarrollo e Innovación</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 font-bold">Horas Diarias:</span>
                        <span class="text-gray-900">5 horas diarias</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 font-bold">Horario:</span>
                        <span class="text-gray-900">08:00 AM - 01:00 PM</span>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <a href="mailto:rmedina@techsolutions.com" class="w-full text-center py-3 bg-[#4E7D24] hover:bg-[#3A5D1B] text-white text-xs font-bold rounded-xl transition-all shadow-md">Redactar Correo</a>
                    <a href="mailto:aramos@ucol.mx" class="w-full text-center py-3 border border-gray-200 hover:bg-gray-55 text-gray-750 text-xs font-bold rounded-xl transition-colors shadow-sm">Reportar con Coordinador</a>
                </div>
            </div>

        </div>
    </div>

    <!-- Phase-based Digital Folder (Timeline) - Full Width below Grid -->
    <div class="glass-card rounded-3xl p-6 fade-in-up delay-350">
        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
            <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            Expediente Digital por Fases del Trámite
        </h3>

        <!-- Phase Groups in 3 Columns on Widescreen -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 relative">
            
            <!-- Phase 1: Fase Inicial -->
            <div class="relative pl-6 border-l-2 border-green-400 flex flex-col gap-4">
                <!-- Bullet Indicator -->
                <div class="absolute -left-[9px] top-1 w-4 h-4 bg-green-500 rounded-full border-4 border-white shadow-md"></div>
                
                <h4 class="text-xs font-extrabold text-green-800 uppercase tracking-widest mb-1">Fase Inicial (Apertura)</h4>
                
                <!-- Doc 1 -->
                <div class="bg-white/60 border border-gray-100 rounded-2xl p-4 flex justify-between items-center hover:border-green-300 transition-colors shadow-sm" id="docRow-1">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-green-50 text-green-600 rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <h5 class="text-xs font-extrabold text-gray-900">Carta de Presentación</h5>
                            <span class="inline-block text-[9px] font-bold text-green-700 bg-green-50/50 px-2 py-0.5 rounded mt-1">Aprobado</span>
                        </div>
                    </div>
                    <button onclick="simulateViewPdf('Carta de Presentación', 'Aprobado')" class="text-[#4E7D24] hover:bg-[#6BA53A]/10 p-2 rounded-xl transition-all" title="Ver Documento">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </button>
                </div>

                <!-- Doc 2 -->
                <div class="bg-white/60 border border-gray-100 rounded-2xl p-4 flex justify-between items-center hover:border-green-300 transition-colors shadow-sm" id="docRow-2">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-green-50 text-green-600 rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <h5 class="text-xs font-extrabold text-gray-900">Carta de Aceptación</h5>
                            <span class="inline-block text-[9px] font-bold text-green-700 bg-green-50/50 px-2 py-0.5 rounded mt-1">Aprobado</span>
                        </div>
                    </div>
                    <button onclick="simulateViewPdf('Carta de Aceptación', 'Aprobado')" class="text-[#4E7D24] hover:bg-[#6BA53A]/10 p-2 rounded-xl transition-all" title="Ver Documento">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Phase 2: Fase de Avance -->
            <div class="relative pl-6 border-l-2 border-yellow-450 flex flex-col gap-4">
                <!-- Bullet Indicator -->
                <div class="absolute -left-[9px] top-1 w-4 h-4 bg-yellow-500 rounded-full border-4 border-white shadow-md"></div>
                
                <h4 class="text-xs font-extrabold text-yellow-800 uppercase tracking-widest mb-1">Fase de Avance (Ejecución)</h4>
                
                <!-- Doc 3 (Plan de Trabajo - Rechazado) -->
                <div class="bg-white/60 border border-gray-100 rounded-2xl p-4 flex flex-col justify-between hover:border-red-300 transition-colors shadow-sm" id="docRow-3">
                    <div class="flex items-start justify-between gap-2 mb-3">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-red-50 text-red-500 rounded-xl" id="docIconContainer-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </div>
                            <div>
                                <h5 class="text-xs font-extrabold text-gray-900">Plan de Trabajo</h5>
                                <span class="inline-block text-[9px] font-bold text-red-700 bg-red-50 px-2 py-0.5 rounded mt-1 border border-red-100" id="docBadge-3">Rechazado</span>
                            </div>
                        </div>
                        <button onclick="simulateViewPdf('Plan de Trabajo', 'Rechazado')" class="text-gray-400 hover:text-gray-700 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                    </div>
                    <p class="text-[10px] text-red-500 font-bold mb-3.5 p-2 bg-red-50/50 rounded-xl border border-red-100/50">Motivo: Error en firmas del asesor de empresa.</p>
                    <div id="docActions-3">
                        <button onclick="openUploadModal(3, 'Plan de Trabajo')" class="w-full text-center py-2 bg-gray-900 hover:bg-black text-white text-xs font-bold rounded-xl transition-all shadow-sm">Reemplazar Archivo</button>
                    </div>
                </div>

                <!-- Doc 4 (Memoria - En revisión) -->
                <div class="bg-white/60 border border-gray-100 rounded-2xl p-4 flex flex-col justify-between hover:border-yellow-300 transition-colors shadow-sm" id="docRow-4">
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-yellow-50 text-yellow-600 rounded-xl" id="docIconContainer-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h5 class="text-xs font-extrabold text-gray-900">Memoria de Prácticas</h5>
                                <span class="inline-block text-[9px] font-bold text-yellow-750 bg-yellow-50 px-2 py-0.5 rounded mt-1 border border-yellow-100" id="docBadge-4">En Revisión</span>
                            </div>
                        </div>
                        <button onclick="simulateViewPdf('Memoria de Prácticas', 'En Revisión')" class="text-gray-400 hover:text-gray-700 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                    </div>
                    <div id="docActions-4">
                        <button onclick="openUploadModal(4, 'Memoria de Prácticas')" class="w-full text-center py-2 border border-gray-200 hover:bg-gray-55 text-gray-600 text-xs font-bold rounded-xl transition-all shadow-sm">Volver a Subir</button>
                    </div>
                </div>
            </div>

            <!-- Phase 3: Fase Final -->
            <div class="relative pl-6 border-l-2 border-gray-300 flex flex-col gap-4">
                <!-- Bullet Indicator -->
                <div class="absolute -left-[9px] top-1 w-4 h-4 bg-gray-300 rounded-full border-4 border-white shadow-md" id="docBullet-5"></div>
                
                <h4 class="text-xs font-extrabold text-gray-400 uppercase tracking-widest mb-1">Fase Final (Cierre y Acreditación)</h4>
                
                <!-- Doc 5 (Evaluación - Sin subir) -->
                <div class="bg-white/60 border border-dashed border-gray-250 rounded-2xl p-4 flex flex-col justify-between hover:border-[#6BA53A]/45 transition-colors shadow-sm" id="docRow-5">
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-gray-50 text-gray-400 rounded-xl" id="docIconContainer-5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            </div>
                            <div>
                                <h5 class="text-xs font-extrabold text-gray-900">Evaluación de Desempeño</h5>
                                <span class="inline-block text-[9px] font-bold text-gray-500 bg-gray-50 px-2 py-0.5 rounded mt-1 border border-gray-200" id="docBadge-5">Sin Subir</span>
                            </div>
                        </div>
                    </div>
                    <div id="docActions-5">
                        <button onclick="openUploadModal(5, 'Evaluación de Desempeño')" class="w-full text-center py-2.5 bg-[#4E7D24] hover:bg-[#2E5417] text-white text-xs font-bold rounded-xl transition-all shadow-md">Subir Archivo</button>
                    </div>
                </div>

                <!-- Doc 6 (Carta de término - Sin subir) -->
                <div class="bg-white/60 border border-dashed border-gray-250 rounded-2xl p-4 flex flex-col justify-between hover:border-[#6BA53A]/45 transition-colors shadow-sm" id="docRow-6">
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-gray-50 text-gray-400 rounded-xl" id="docIconContainer-6">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            </div>
                            <div>
                                <h5 class="text-xs font-extrabold text-gray-900">Carta de Término</h5>
                                <span class="inline-block text-[9px] font-bold text-gray-500 bg-gray-50 px-2 py-0.5 rounded mt-1 border border-gray-200" id="docBadge-6">Sin Subir</span>
                            </div>
                        </div>
                    </div>
                    <div id="docActions-6">
                        <button onclick="openUploadModal(6, 'Carta de Término')" class="w-full text-center py-2.5 bg-[#4E7D24] hover:bg-[#2E5417] text-white text-xs font-bold rounded-xl transition-all shadow-md">Subir Archivo</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Upload Document Modal (Simulated overlay) -->
    <div id="uploadModal" class="hidden fixed inset-0 z-[99] bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl border border-gray-200 max-w-md w-full overflow-hidden fade-in-up">
            <div class="bg-gradient-to-r from-gray-950 to-gray-850 p-5 text-white flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold">Subir Documento</h3>
                    <p class="text-xs text-gray-300 mt-0.5" id="uploadModalDocName">Cargando...</p>
                </div>
                <button onclick="closeUploadModal()" class="text-gray-300 hover:text-white transition-colors bg-white/10 hover:bg-white/20 p-2 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 space-y-4">
                <div class="border-2 border-dashed border-gray-300 rounded-2xl p-8 flex flex-col items-center justify-center text-center hover:border-[#6BA53A] transition-colors cursor-pointer" onclick="document.getElementById('simPdfInput').click()">
                    <input type="file" id="simPdfInput" accept=".pdf" class="hidden" onchange="fileSelected(this)">
                    <div class="w-12 h-12 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mb-3" id="uploadIconContainer">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    </div>
                    <span class="block text-sm font-bold text-gray-800" id="uploadFileText">Seleccionar Archivo PDF</span>
                    <span class="text-xs text-gray-400 mt-1">Peso máximo: 5MB</span>
                </div>
            </div>

            <div class="p-6 bg-gray-50/50 border-t border-gray-100 flex gap-3">
                <button onclick="closeUploadModal()" class="flex-1 bg-white border border-gray-200 hover:bg-gray-50 text-gray-650 font-bold py-3.5 px-4 rounded-xl text-xs transition-colors shadow-sm">Cancelar</button>
                <button onclick="submitUpload()" class="flex-1 bg-[#4E7D24] hover:bg-[#3A5D1B] text-white font-bold py-3.5 px-4 rounded-xl text-xs transition-all shadow-md">Subir Archivo</button>
            </div>
        </div>
    </div>

    <!-- View PDF Modal (Simulated overlay) -->
    <div id="pdfModal" class="hidden fixed inset-0 z-[99] bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl border border-gray-200 max-w-3xl w-full h-[85vh] overflow-hidden flex flex-col fade-in-up">
            <div class="bg-gray-900 p-5 text-white flex justify-between items-center">
                <div>
                    <h3 class="text-base font-bold" id="pdfModalTitle">Visor de Documentos (Simulado)</h3>
                    <p class="text-xs text-gray-400 mt-0.5" id="pdfModalSubtitle">Cargando...</p>
                </div>
                <button onclick="closePdfModal()" class="text-gray-300 hover:text-white transition-colors bg-white/10 hover:bg-white/20 p-2 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="flex-1 bg-gray-100 overflow-y-auto p-8 flex flex-col items-center justify-start custom-scrollbar">
                <div class="max-w-2xl w-full bg-white shadow-lg border border-gray-200 rounded-xl p-10 min-h-[750px] relative flex flex-col justify-between">
                    
                    <div class="flex justify-between items-start border-b-2 border-gray-200 pb-5">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('images/logo_verde.png') }}" alt="Logo" class="h-14 w-auto object-contain">
                            <div>
                                <h4 class="font-bold text-xs text-gray-900 uppercase">Universidad de Colima</h4>
                                <h5 class="text-[10px] text-gray-500 uppercase font-semibold">Facultad de Ingeniería Mecánica y Eléctrica</h5>
                                <h5 class="text-[9px] text-gray-450 uppercase font-bold">Dirección General de Prácticas Profesionales</h5>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-[9px] font-bold text-gray-450 bg-gray-100 border border-gray-200 px-2 py-0.5 rounded">DOCUMENTO OFICIAL</span>
                            <p class="text-[9px] text-gray-400 font-medium mt-1">Folio: UDEC-PP-2026-0429</p>
                        </div>
                    </div>

                    <div class="my-8 flex-1">
                        <h3 class="text-center font-bold text-sm text-gray-800 uppercase tracking-wider mb-6" id="pdfDocDocName">CARTA DE PRESENTACIÓN DE PRÁCTICAS</h3>
                        
                        <p class="text-xs text-right text-gray-600 font-medium mb-6">Colima, Col., a 12 de Abril del 2026.</p>
                        
                        <p class="text-xs text-gray-800 font-bold mb-4">
                            ING. ROBERTO MEDINA<br>
                            ASIGNADOR DE PROYECTOS EXTERNOS<br>
                            TECH SOLUTIONS S.A.<br>
                            PRESENTE.
                        </p>

                        <p class="text-xs text-gray-700 leading-relaxed text-justify font-medium mb-4">
                            Por medio de la presente, la Coordinación de Prácticas Profesionales de la Universidad de Colima tiene el honor de presentar al estudiante <strong>{{ auth()->user()->correo }}</strong> con matrícula <strong>20183492</strong>, de la carrera de <strong>Ingeniería en Software</strong> (6° semestre), para que realice su periodo de prácticas profesionales en su distinguida empresa.
                        </p>

                        <p class="text-xs text-gray-700 leading-relaxed text-justify font-medium mb-4">
                            Las prácticas profesionales constan de cubrir un total de <strong>360 horas</strong>, realizando actividades afines a su perfil de egreso en el área de desarrollo web/móvil, las cuales se llevarán a cabo en el periodo establecido y bajo la supervisión del asesor que sea designado.
                        </p>

                        <p class="text-xs text-gray-700 leading-relaxed text-justify font-medium mb-6">
                            Agradeciendo de antemano el apoyo que se sirva brindar a nuestro estudiante en su formación integral, quedo de usted para cualquier aclaración o duda.
                        </p>
                    </div>

                    <div class="border-t border-gray-150 pt-5">
                        <div class="grid grid-cols-2 gap-8 text-center">
                            <div class="flex flex-col items-center">
                                <span class="text-[9px] font-bold text-[#4E7D24] mb-12">AUTORIZACIÓN INSTITUCIONAL</span>
                                <div class="w-32 border-b border-gray-400"></div>
                                <span class="text-[9px] text-gray-800 font-bold mt-1">Mtro. Alejandro Ramos</span>
                                <span class="text-[8px] text-gray-500 font-semibold">Coordinador UdeC</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <span class="text-[9px] font-bold text-gray-450 mb-12">RECIBIDO POR LA EMPRESA</span>
                                <div class="w-32 border-b border-gray-400"></div>
                                <span class="text-[9px] text-gray-800 font-bold mt-1">Ing. Roberto Medina</span>
                                <span class="text-[8px] text-gray-500 font-semibold">Tech Solutions S.A.</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
            <div class="p-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-2">
                <button onclick="closePdfModal()" class="bg-gray-900 text-white font-bold py-2.5 px-6 rounded-xl text-xs hover:bg-black transition-colors shadow-sm">Cerrar Visor</button>
            </div>
        </div>
    </div>

    <!-- Client-side Interactive Logic -->
    <script>
        // Circular Progress Ring calculations
        const maxCircleOffset = 251.2; // 2 * PI * r = 2 * PI * 40 = 251.2
        const totalHours = 360;
        let currentHours = 120;
        let approvedDocs = 2;

        function updateCircularProgress(newHours) {
            currentHours = newHours;
            
            // Limit hours
            if (currentHours > totalHours) currentHours = totalHours;

            // UI text update
            document.getElementById('circularHoursText').textContent = `${currentHours} h`;
            document.getElementById('heroHoursLabel').textContent = currentHours;

            const percentage = ((currentHours / totalHours) * 100).toFixed(1);
            document.getElementById('circularPercentageText').textContent = `${percentage}% Completado`;
            
            const remaining = totalHours - currentHours;
            if (remaining > 0) {
                document.getElementById('circularHoursRemaining').textContent = `Faltan ${remaining} horas para acreditar tus prácticas.`;
            } else {
                document.getElementById('circularHoursRemaining').textContent = `¡Felicidades! Has cubierto las 360 horas necesarias.`;
                document.getElementById('circularHoursRemaining').className = "text-[11px] text-green-800/80 font-bold block";
            }

            // SVG offset update: percentage = 100% means stroke-dashoffset = 0.
            // stroke-dashoffset = maxCircleOffset - (percentage / 100 * maxCircleOffset)
            const offset = maxCircleOffset - (currentHours / totalHours * maxCircleOffset);
            document.getElementById('circularProgressRing').setAttribute('stroke-dashoffset', offset);
        }

        // Toggle Bitacora Form
        function toggleBitacoraForm() {
            const form = document.getElementById('bitacoraFormContainer');
            const btn = document.getElementById('btnToggleBitacora');
            
            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
                btn.innerHTML = `Cerrar Bitácora <svg class="w-3.5 h-3.5 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>`;
            } else {
                form.classList.add('hidden');
                btn.innerHTML = `Registrar Actividades <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>`;
            }
        }

        // Add Bitacora entry dynamically and sum hours
        let weekCounter = 5;
        function addBitacoraEntry() {
            const descInput = document.getElementById('bitacoraDesc');
            const hoursInput = document.getElementById('bitacoraHours');
            
            const desc = descInput.value.trim();
            const hrs = parseInt(hoursInput.value);

            if (!desc) {
                alert('Escribe una descripción para la actividad.');
                return;
            }
            if (isNaN(hrs) || hrs <= 0) {
                alert('Ingresa una cantidad válida de horas.');
                return;
            }
            if (currentHours + hrs > totalHours) {
                alert(`No puedes registrar más de las ${totalHours} horas totales del proyecto.`);
                return;
            }

            // Insert new row into the table body (at the top)
            const tbody = document.getElementById('bitacoraBody');
            const newRow = document.createElement('tr');
            newRow.className = "hover:bg-[#6BA53A]/5 transition-colors fade-in-up";
            newRow.innerHTML = `
                <td class="px-5 py-3 whitespace-nowrap text-xs font-bold text-gray-500">Semana ${weekCounter} (Reciente)</td>
                <td class="px-5 py-3 text-xs font-semibold text-gray-700">${desc}</td>
                <td class="px-5 py-3 whitespace-nowrap text-center text-xs font-extrabold text-gray-900">${hrs} h</td>
                <td class="px-5 py-3 whitespace-nowrap text-center">
                    <span class="text-[9px] font-bold text-yellow-750 bg-yellow-50 border border-yellow-150 px-2 py-0.5 rounded-md">Enviado</span>
                </td>
            `;

            // Remove the "(Reciente)" tag from the previous top row if exists
            const prevTopRow = tbody.querySelector('tr');
            if (prevTopRow) {
                const dateCell = prevTopRow.querySelector('td');
                dateCell.textContent = dateCell.textContent.replace(' (Reciente)', '');
            }

            tbody.insertBefore(newRow, tbody.firstChild);

            // Increment week count
            weekCounter++;
            
            // Update hours globally
            updateCircularProgress(currentHours + hrs);

            // Reset and close form
            descInput.value = '';
            hoursInput.value = '10';
            toggleBitacoraForm();

            showToast('¡Bitácora Registrada!', `Se han registrado ${hrs} horas para su validación por el asesor externo.`);
        }

        // Upload Modal handling
        let activeDocId = null;
        let activeDocName = "";

        function openUploadModal(docId, docName) {
            activeDocId = docId;
            activeDocName = docName;
            document.getElementById('uploadModalDocName').textContent = docName;
            document.getElementById('uploadFileText').textContent = "Seleccionar Archivo PDF";
            document.getElementById('simPdfInput').value = "";
            document.getElementById('uploadIconContainer').innerHTML = `
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
            `;
            document.getElementById('uploadIconContainer').className = "w-12 h-12 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mb-3";
            document.getElementById('uploadModal').classList.remove('hidden');
        }

        function closeUploadModal() {
            document.getElementById('uploadModal').classList.add('hidden');
        }

        function fileSelected(input) {
            if (input.files && input.files[0]) {
                const filename = input.files[0].name;
                document.getElementById('uploadFileText').textContent = filename;
                document.getElementById('uploadIconContainer').className = "w-12 h-12 bg-green-50 text-green-500 rounded-full flex items-center justify-center mb-3";
                document.getElementById('uploadIconContainer').innerHTML = `
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                `;
            }
        }

        function submitUpload() {
            const input = document.getElementById('simPdfInput');
            if (input.files.length === 0 && document.getElementById('uploadFileText').textContent === "Seleccionar Archivo PDF") {
                alert('Por favor selecciona un archivo PDF de tu equipo.');
                return;
            }
            
            closeUploadModal();
            
            const badgeId = `docBadge-${activeDocId}`;
            const rowId = `docRow-${activeDocId}`;
            const actionsId = `docActions-${activeDocId}`;
            const iconContainerId = `docIconContainer-${activeDocId}`;
            
            const badge = document.getElementById(badgeId);
            const row = document.getElementById(rowId);
            const actions = document.getElementById(actionsId);
            const icon = document.getElementById(iconContainerId);

            // Change status to "En Revisión"
            if (badge) {
                badge.className = "inline-block text-[9px] font-bold text-yellow-750 bg-yellow-50 px-2 py-0.5 rounded mt-1 border border-yellow-100";
                badge.textContent = "En Revisión";
            }

            if (row.classList.contains('border-dashed')) {
                // If it was "Sin Subir", change border/icon and add view button
                row.className = "bg-white/60 border border-gray-100 rounded-2xl p-4 flex flex-col justify-between hover:border-yellow-300 transition-colors";
                
                if (icon) {
                    icon.className = "p-2 bg-yellow-50 text-yellow-600 rounded-xl";
                    icon.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;
                }
                
                // Add header flex container
                const topDiv = row.querySelector('.flex.items-center.gap-2.mb-4') || row.querySelector('.flex');
                if (topDiv) {
                    topDiv.className = "flex items-center justify-between gap-2 mb-4 w-full";
                    // Append small view button
                    const viewBtn = document.createElement('button');
                    viewBtn.onclick = () => simulateViewPdf(activeDocName, 'En Revisión');
                    viewBtn.className = "text-gray-400 hover:text-gray-700 transition-all";
                    viewBtn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>`;
                    topDiv.appendChild(viewBtn);
                }

                if (actions) {
                    actions.innerHTML = `<button onclick="openUploadModal(${activeDocId}, '${activeDocName}')" class="w-full text-center py-2 border border-gray-200 hover:bg-gray-50 text-gray-600 text-xs font-bold rounded-xl transition-all shadow-sm">Volver a Subir</button>`;
                }
            } else if (activeDocId === 3) {
                // If it was Plan de Trabajo (Rechazado), remove the observation block and convert card
                const obsBox = row.querySelector('p');
                if (obsBox) obsBox.remove();
                
                if (icon) {
                    icon.className = "p-2 bg-yellow-50 text-yellow-600 rounded-xl";
                    icon.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;
                }

                row.className = "bg-white/60 border border-gray-100 rounded-2xl p-4 flex flex-col justify-between hover:border-yellow-300 transition-colors shadow-sm";
                
                if (actions) {
                    actions.innerHTML = `<button onclick="openUploadModal(3, 'Plan de Trabajo')" class="w-full text-center py-2 border border-gray-200 hover:bg-gray-50 text-gray-600 text-xs font-bold rounded-xl transition-all shadow-sm">Volver a Subir</button>`;
                }
                
                // Update top row buttons
                const header = row.querySelector('.flex.items-start.justify-between.gap-2.mb-3') || row.querySelector('.flex');
                if (header) {
                    header.className = "flex items-center justify-between gap-2 mb-4 w-full";
                    const viewBtn = header.querySelector('button');
                    if (viewBtn) {
                        viewBtn.onclick = () => simulateViewPdf('Plan de Trabajo', 'En Revisión');
                    }
                }
            }

            showToast('¡Expediente Actualizado!', `El documento "${activeDocName}" ha sido cargado. Su estado de validación ahora es "En Revisión".`);
        }

        // View PDF Modal
        function simulateViewPdf(docName, status) {
            document.getElementById('pdfModalTitle').textContent = `Visor de Documentos: ${docName}`;
            document.getElementById('pdfModalSubtitle').textContent = `Estado de Validación: ${status} | Previsualización Digital`;
            document.getElementById('pdfDocDocName').textContent = docName.toUpperCase();
            document.getElementById('pdfModal').classList.remove('hidden');
        }

        function closePdfModal() {
            document.getElementById('pdfModal').classList.add('hidden');
        }

        // Toast helpers
        function showToast(title, message) {
            document.getElementById('toastTitle').textContent = title;
            document.getElementById('toastMessage').textContent = message;
            const toast = document.getElementById('projectSuccessToast');
            toast.classList.remove('hidden');
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 6000);
        }
    </script>
@endsection
