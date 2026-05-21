@extends('layouts.estudiante', ['title' => 'Mi Proyecto de Prácticas - Prácticas Profesionales UdeC', 'active' => 'proyecto'])

@section('content')
    <!-- Page Header -->
    <x-page-header title="Seguimiento de Proyecto" description="Monitorea tus horas acumuladas, registra tus actividades y gestiona la documentación de tus prácticas profesionales."></x-page-header>

    <!-- Simulated Notifications -->
    <div id="projectSuccessToast" class="hidden fixed top-5 right-5 z-[100] bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl shadow-xl max-w-md fade-in-up flex items-start gap-3">
        <div class="p-1 bg-green-100 text-green-600 rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <div>
            <h4 class="font-bold text-green-950 text-sm" id="toastTitle">¡Operación Exitosa!</h4>
            <p class="text-xs text-green-900/90 mt-0.5" id="toastMessage">El documento se ha cargado correctamente para su validación.</p>
        </div>
        <button onclick="document.getElementById('projectSuccessToast').classList.add('hidden')" class="text-green-500 hover:text-green-800 transition-colors ml-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">
        
        <!-- Left: Project Info & Progress (1 Column) -->
        <div class="lg:col-span-1 flex flex-col gap-6">
            
            <!-- Project Details Card -->
            <div class="glass-card rounded-3xl p-6 bg-gradient-to-br from-white to-[#6BA53A]/5 border border-[#6BA53A]/10 fade-in-up delay-100">
                <span class="inline-block text-[10px] font-bold text-[#4E7D24] bg-[#6BA53A]/10 px-2 py-0.5 rounded-md mb-3">Proyecto Activo</span>
                <h3 class="text-xl font-bold text-gray-900 mb-1">Desarrollo de App Móvil</h3>
                <p class="text-sm font-bold text-[#4E7D24] mb-4">Tech Solutions S.A.</p>
                
                <div class="border-t border-gray-150/50 pt-4 space-y-3.5 text-xs text-gray-700 font-medium">
                    <div>
                        <span class="block text-gray-400 font-bold mb-0.5">Asesor Externo</span>
                        <span class="text-sm font-bold text-gray-900">Ing. Roberto Medina</span>
                        <span class="block text-gray-500 mt-0.5">rmedina@techsolutions.com</span>
                    </div>
                    <div>
                        <span class="block text-gray-400 font-bold mb-0.5">Departamento / Área</span>
                        <span>Departamento de Desarrollo e Innovación</span>
                    </div>
                    <div>
                        <span class="block text-gray-400 font-bold mb-0.5">Periodo</span>
                        <span>12 de Abril, 2026 - 12 de Agosto, 2026</span>
                    </div>
                    <div>
                        <span class="block text-gray-400 font-bold mb-0.5">Horario Pactado</span>
                        <span>Lunes a Viernes, 08:00 AM - 01:00 PM</span>
                    </div>
                </div>
            </div>

            <!-- Hours Progress & Simulator Card -->
            <div class="glass-card rounded-3xl p-6 fade-in-up delay-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Seguimiento de Horas
                </h3>
                
                <div class="bg-white/60 border border-gray-100 rounded-2xl p-5 mb-5 flex flex-col items-center justify-center text-center shadow-inner">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Avance de Horas</span>
                    <div class="flex items-baseline gap-1 mb-2">
                        <span class="text-4xl font-extrabold text-gray-900" id="currentHoursVal">120</span>
                        <span class="text-sm font-medium text-gray-500">/ 360 horas</span>
                    </div>
                    <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-0.5 rounded-full" id="hoursPercentageVal">33.3% Completado</span>
                    
                    <div class="w-full bg-gray-150 rounded-full h-3 overflow-hidden border border-gray-100 mt-4">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-full rounded-full transition-all duration-500" id="hoursProgressBar" style="width: 33.3%"></div>
                    </div>
                </div>

                <!-- Hours Simulator -->
                <div class="bg-gray-50 border border-gray-100 rounded-2xl p-4">
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2.5">Simulador: Registrar Horas</h4>
                    <div class="flex gap-2">
                        <input type="number" id="inputHoursSim" class="block w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/20 focus:border-[#6BA53A] placeholder-gray-400 font-bold" value="10" min="1" max="100">
                        <button onclick="simulateAddHours()" class="bg-[#4E7D24] hover:bg-[#3A5D1B] text-white text-xs font-bold px-4 py-2 rounded-xl transition-all shadow-md">Registrar</button>
                    </div>
                    <span class="text-[10px] text-gray-400 font-medium block mt-1.5">Suma horas simuladas para probar cómo avanza la barra de progreso.</span>
                </div>
            </div>

        </div>

        <!-- Right: Documents Management (2 Columns) -->
        <div class="lg:col-span-2 flex flex-col gap-6">
            
            <!-- Documents List Card -->
            <div class="glass-card rounded-3xl p-6 fade-in-up delay-150 flex-1 flex flex-col">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Manejador de Expediente Digital
                    </h3>
                    <span class="text-xs text-gray-500 font-medium bg-gray-50 border border-gray-100 rounded-lg px-2.5 py-1">6 documentos en total</span>
                </div>

                <div class="space-y-4" id="documentsList">
                    
                    <!-- Doc 1: Carta de Presentación (Aprobado) -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 bg-white/60 rounded-2xl border border-gray-100 hover:border-green-200/50 transition-colors gap-4" id="docRow-1">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-green-50 text-green-600 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">1. Carta de Presentación</h4>
                                <p class="text-xs text-gray-500 font-medium mt-0.5">Expedida por el coordinador para solicitar formalmente tu espacio.</p>
                                <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-md text-[10px] font-bold bg-green-50 text-green-700 mt-1.5 border border-green-150">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Aprobado
                                </span>
                            </div>
                        </div>
                        <button onclick="simulateViewPdf('Carta de Presentación', 'Aprobado')" class="text-[#4E7D24] hover:bg-[#6BA53A]/10 px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1">
                            Ver PDF
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                    </div>

                    <!-- Doc 2: Carta de Aceptación (Aprobado) -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 bg-white/60 rounded-2xl border border-gray-100 hover:border-green-200/50 transition-colors gap-4" id="docRow-2">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-green-50 text-green-600 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">2. Carta de Aceptación</h4>
                                <p class="text-xs text-gray-500 font-medium mt-0.5">Expedida por la empresa, acreditando que has sido seleccionado.</p>
                                <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-md text-[10px] font-bold bg-green-50 text-green-700 mt-1.5 border border-green-150">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Aprobado
                                </span>
                            </div>
                        </div>
                        <button onclick="simulateViewPdf('Carta de Aceptación', 'Aprobado')" class="text-[#4E7D24] hover:bg-[#6BA53A]/10 px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1">
                            Ver PDF
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                    </div>

                    <!-- Doc 3: Plan de Trabajo (Rechazado) -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 bg-white/60 rounded-2xl border border-gray-100 hover:border-red-200/50 transition-colors gap-4" id="docRow-3">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-red-50 text-red-600 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">3. Plan de Trabajo</h4>
                                <p class="text-xs text-gray-500 font-medium mt-0.5">Cronograma detallado con las actividades que realizarás.</p>
                                <div class="flex flex-col gap-1 items-start mt-1.5">
                                    <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-md text-[10px] font-bold bg-red-50 text-red-700 border border-red-150">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span> Rechazado
                                    </span>
                                    <p class="text-[11px] text-red-500 font-semibold bg-red-50/50 px-2 py-1 rounded-lg mt-1 border border-red-100/50">Motivo: Error en firmas. Faltó la firma del asesor externo.</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="simulateViewPdf('Plan de Trabajo', 'Rechazado')" class="text-gray-500 hover:bg-gray-100 px-3.5 py-2 rounded-xl text-xs font-bold transition-all">Ver</button>
                            <button onclick="openUploadModal(3, 'Plan de Trabajo')" class="bg-gray-900 text-white hover:bg-black px-4 py-2 rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition-all flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                Reemplazar
                            </button>
                        </div>
                    </div>

                    <!-- Doc 4: Memoria de Prácticas (En revisión / Pendiente) -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 bg-white/60 rounded-2xl border border-gray-100 hover:border-yellow-200/50 transition-colors gap-4" id="docRow-4">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-yellow-50 text-yellow-600 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">4. Memoria de Prácticas</h4>
                                <p class="text-xs text-gray-500 font-medium mt-0.5">Reporte académico del desarrollo de tus actividades.</p>
                                <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-md text-[10px] font-bold bg-yellow-50 text-yellow-750 mt-1.5 border border-yellow-150" id="docBadge-4">
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> En Revisión
                                </span>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="simulateViewPdf('Memoria de Prácticas', 'En Revisión')" class="text-gray-500 hover:bg-gray-100 px-3.5 py-2 rounded-xl text-xs font-bold transition-all">Ver</button>
                            <button onclick="openUploadModal(4, 'Memoria de Prácticas')" class="text-gray-900 hover:bg-gray-100 px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1">
                                Re-subir
                            </button>
                        </div>
                    </div>

                    <!-- Doc 5: Evaluación de Desempeño (Sin Subir) -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 bg-white/60 rounded-2xl border border-dashed border-gray-250 hover:border-[#6BA53A]/40 transition-colors gap-4" id="docRow-5">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-gray-50 text-gray-400 rounded-xl" id="docIconContainer-5">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">5. Evaluación de Desempeño</h4>
                                <p class="text-xs text-gray-500 font-medium mt-0.5">Evaluación calificada por tu asesor externo de la empresa.</p>
                                <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-md text-[10px] font-bold bg-gray-50 text-gray-500 mt-1.5 border border-gray-200" id="docBadge-5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Sin Subir
                                </span>
                            </div>
                        </div>
                        <div class="flex gap-2" id="docActions-5">
                            <button onclick="openUploadModal(5, 'Evaluación de Desempeño')" class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-4 py-2.5 rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition-all flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                Subir Archivo
                            </button>
                        </div>
                    </div>

                    <!-- Doc 6: Carta de Término (Sin Subir) -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 bg-white/60 rounded-2xl border border-dashed border-gray-250 hover:border-[#6BA53A]/40 transition-colors gap-4" id="docRow-6">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-gray-50 text-gray-400 rounded-xl" id="docIconContainer-6">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">6. Carta de Término</h4>
                                <p class="text-xs text-gray-500 font-medium mt-0.5">Expedida por la empresa para validar la conclusión formal del periodo.</p>
                                <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-md text-[10px] font-bold bg-gray-50 text-gray-500 mt-1.5 border border-gray-200" id="docBadge-6">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Sin Subir
                                </span>
                            </div>
                        </div>
                        <div class="flex gap-2" id="docActions-6">
                            <button onclick="openUploadModal(6, 'Carta de Término')" class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-4 py-2.5 rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition-all flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                Subir Archivo
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Upload Document Modal (Simulated overlay) -->
    <div id="uploadModal" class="hidden fixed inset-0 z-[99] bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl border border-gray-200 max-w-md w-full overflow-hidden fade-in-up">
            <div class="bg-gradient-to-r from-gray-900 to-gray-800 p-5 text-white flex justify-between items-center">
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
                <button onclick="closeUploadModal()" class="flex-1 bg-white border border-gray-200 hover:bg-gray-50 text-gray-600 font-bold py-3.5 px-4 rounded-xl text-xs transition-colors shadow-sm">Cancelar</button>
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
            
            <!-- Simulated PDF Document Content -->
            <div class="flex-1 bg-gray-100 overflow-y-auto p-8 flex flex-col items-center justify-start custom-scrollbar">
                <div class="max-w-2xl w-full bg-white shadow-lg border border-gray-200 rounded-xl p-10 min-h-[750px] relative flex flex-col justify-between">
                    
                    <!-- PDF Header -->
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

                    <!-- PDF Content -->
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

                    <!-- PDF Signatures -->
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
                                <span class="text-[9px] text-gray-800 font-bold mt-1" id="pdfExternalAdvisorName">Ing. Roberto Medina</span>
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
        // Hours Simulator
        let currentHours = 120;
        const totalHours = 360;

        function simulateAddHours() {
            const input = document.getElementById('inputHoursSim');
            const added = parseInt(input.value);
            
            if (isNaN(added) || added <= 0) {
                alert('Ingresa una cantidad de horas válida mayor a 0.');
                return;
            }
            
            if (currentHours + added > totalHours) {
                alert(`No puedes registrar más de las ${totalHours} horas totales.`);
                return;
            }
            
            currentHours += added;
            
            // Update HTML
            document.getElementById('currentHoursVal').textContent = currentHours;
            
            const percentage = ((currentHours / totalHours) * 100).toFixed(1);
            document.getElementById('hoursPercentageVal').textContent = `${percentage}% Completado`;
            document.getElementById('hoursProgressBar').style.width = `${percentage}%`;
            
            // Show Success toast
            showToast('¡Horas Registradas!', `Has agregado con éxito ${added} horas a tu seguimiento de prácticas.`);
        }

        // Upload Modal
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
            
            // Dynamically change row status of activeDocId to "En Revisión" in UI
            const rowId = `docRow-${activeDocId}`;
            const badgeId = `docBadge-${activeDocId}`;
            const actionsId = `docActions-${activeDocId}`;
            const containerId = `docIconContainer-${activeDocId}`;
            
            const badge = document.getElementById(badgeId);
            const row = document.getElementById(rowId);
            
            if (badge) {
                badge.className = "inline-flex items-center gap-1.5 py-0.5 px-2 rounded-md text-[10px] font-bold bg-yellow-50 text-yellow-750 mt-1.5 border border-yellow-150";
                badge.innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> En Revisión`;
            }
            
            // If it was "Sin Subir", change border/icon and add view button
            if (row.classList.contains('border-dashed')) {
                row.className = "flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 bg-white/60 rounded-2xl border border-gray-100 hover:border-yellow-200/50 transition-colors gap-4";
                
                const iconContainer = document.getElementById(containerId);
                if (iconContainer) {
                    iconContainer.className = "p-3 bg-yellow-50 text-yellow-600 rounded-xl";
                    iconContainer.innerHTML = `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;
                }
                
                const actions = document.getElementById(actionsId);
                if (actions) {
                    actions.innerHTML = `
                        <button onclick="simulateViewPdf('${activeDocName}', 'En Revisión')" class="text-gray-500 hover:bg-gray-100 px-3.5 py-2 rounded-xl text-xs font-bold transition-all">Ver</button>
                        <button onclick="openUploadModal(${activeDocId}, '${activeDocName}')" class="text-gray-900 hover:bg-gray-100 px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1">
                            Re-subir
                        </button>
                    `;
                }
            } else if (activeDocId === 3) {
                // If it was Plan de Trabajo (Rechazado), remove rejected details and change row to En Revisión
                const parent = row.querySelector('.flex-col');
                if (parent) {
                    parent.innerHTML = `
                        <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-md text-[10px] font-bold bg-yellow-50 text-yellow-750 mt-1.5 border border-yellow-150" id="docBadge-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> En Revisión
                        </span>
                    `;
                }
                // Change icon container color to yellow
                const icon = row.querySelector('.bg-red-50');
                if (icon) {
                    icon.className = "p-3 bg-yellow-50 text-yellow-600 rounded-xl";
                    icon.innerHTML = `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;
                }
                // Update actions to regular
                const btnContainer = row.querySelector('.flex.gap-2');
                if (btnContainer) {
                    btnContainer.innerHTML = `
                        <button onclick="simulateViewPdf('Plan de Trabajo', 'En Revisión')" class="text-gray-500 hover:bg-gray-100 px-3.5 py-2 rounded-xl text-xs font-bold transition-all">Ver</button>
                        <button onclick="openUploadModal(3, 'Plan de Trabajo')" class="text-gray-900 hover:bg-gray-100 px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1">
                            Re-subir
                        </button>
                    `;
                }
            }
            
            showToast('¡Expediente Actualizado!', `El documento "${activeDocName}" ha sido cargado exitosamente. Ahora su estado es "En Revisión".`);
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

        // Toast Helpers
        function showToast(title, message) {
            document.getElementById('toastTitle').textContent = title;
            document.getElementById('toastMessage').textContent = message;
            const toast = document.getElementById('projectSuccessToast');
            toast.classList.remove('hidden');
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 7000);
        }
    </script>
@endsection
