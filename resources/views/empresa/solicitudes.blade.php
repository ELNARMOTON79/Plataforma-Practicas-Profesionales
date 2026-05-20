@extends('layouts.empresa', ['title' => 'Solicitudes de Prácticas - Prácticas Profesionales UdeC', 'active' => 'solicitudes'])

@section('content')
    <!-- Header -->
    <x-page-header title="Solicitudes de Prácticas" description="Revisa, analiza y responde a las solicitudes de prácticas profesionales enviadas por los estudiantes."></x-page-header>

    <!-- Metrics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 fade-in-up delay-100">
        <!-- Pendientes -->
        <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group border-transparent hover:border-yellow-300 transition-colors">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
            </div>
            <span class="text-sm font-bold text-gray-500 mb-2">Pendientes</span>
            <div class="flex items-end gap-3 mb-2">
                <span class="text-4xl font-extrabold text-gray-900" id="metricPending">2</span>
                <span class="flex items-center text-sm font-semibold text-yellow-600 bg-yellow-50 px-2 py-0.5 rounded-md mb-1 border border-yellow-100">
                    Nuevas
                </span>
            </div>
            <span class="text-xs text-gray-400 font-medium">Esperando tu resolución</span>
        </div>

        <!-- Aceptadas -->
        <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group border-transparent hover:border-green-300 transition-colors">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            </div>
            <span class="text-sm font-bold text-gray-500 mb-2">Aceptadas</span>
            <div class="flex items-end gap-3 mb-2">
                <span class="text-4xl font-extrabold text-gray-900" id="metricAccepted">1</span>
            </div>
            <span class="text-xs text-gray-400 font-medium">Listas para firma de convenio</span>
        </div>

        <!-- Rechazadas -->
        <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group border-transparent hover:border-red-300 transition-colors">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
            </div>
            <span class="text-sm font-bold text-gray-500 mb-2">Rechazadas</span>
            <div class="flex items-end gap-3 mb-2">
                <span class="text-4xl font-extrabold text-gray-900" id="metricRejected">1</span>
            </div>
            <span class="text-xs text-gray-400 font-medium">Con comentarios de retroalimentación</span>
        </div>

        <!-- Total Recibidas -->
        <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group border-transparent hover:border-[#6BA53A]/30 transition-colors">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-[#4E7D24]" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>
            </div>
            <span class="text-sm font-bold text-gray-500 mb-2">Total Recibidas</span>
            <div class="flex items-end gap-3 mb-2">
                <span class="text-4xl font-extrabold text-gray-900" id="metricTotal">4</span>
            </div>
            <span class="text-xs text-gray-400 font-medium">Historial completo</span>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="glass-card rounded-3xl p-6 fade-in-up delay-200">
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <!-- Search bar -->
            <div class="relative w-full md:flex-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" id="solicitudSearch" placeholder="Buscar por alumno, proyecto o carrera..." class="w-full pl-11 pr-4 py-2.5 bg-white/50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#6BA53A] focus:border-transparent transition-all text-sm font-medium">
            </div>
            
            <!-- Filter selectors -->
            <div class="flex flex-wrap md:flex-nowrap gap-3 w-full md:w-auto">
                <div class="w-full sm:w-auto flex-1 md:flex-none">
                    <select id="filterProyecto" class="w-full bg-white/50 border border-gray-200 rounded-2xl px-4 py-2.5 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#6BA53A] focus:border-transparent transition-all cursor-pointer">
                        <option value="">Todos los Proyectos</option>
                        <option value="inventario">App Móvil de Inventario</option>
                        <option value="aws">Cloud AWS</option>
                        <option value="qa">Pruebas QA</option>
                    </select>
                </div>

                <div class="w-full sm:w-auto flex-1 md:flex-none">
                    <select id="filterCarrera" class="w-full bg-white/50 border border-gray-200 rounded-2xl px-4 py-2.5 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#6BA53A] focus:border-transparent transition-all cursor-pointer">
                        <option value="">Todas las Carreras</option>
                        <option value="software">Ingeniería en Software</option>
                        <option value="informatica">Licenciatura en Informática</option>
                        <option value="telematica">Ingeniería en Telemática</option>
                    </select>
                </div>
                
                <div class="w-full sm:w-auto flex-1 md:flex-none">
                    <select id="filterEstado" class="w-full bg-white/50 border border-gray-200 rounded-2xl px-4 py-2.5 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#6BA53A] focus:border-transparent transition-all cursor-pointer">
                        <option value="">Todos los Estados</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="aceptada">Aceptada</option>
                        <option value="rechazada">Rechazada</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Applications Grid -->
    <div id="solicitudesGrid" class="grid grid-cols-1 lg:grid-cols-2 gap-8 fade-in-up delay-300">
        
        <!-- Application 1: Pending (Pedro Gómez) -->
        <div class="glass-card rounded-3xl p-6 flex flex-col justify-between group border border-gray-200/50 hover:border-yellow-300" data-id="1" data-status="pendiente" data-proyecto="inventario" data-carrera="informatica">
            <div>
                <div class="flex justify-between items-start mb-4">
                    <span class="px-3 py-1 bg-yellow-50 text-yellow-700 border border-yellow-150 rounded-full text-xs font-bold uppercase tracking-wide status-badge">Pendiente</span>
                    <span class="text-xs font-semibold text-gray-400 flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Recibida: Hace 2 días
                    </span>
                </div>
                
                <div class="flex items-center gap-4 mb-4">
                    <div class="h-12 w-12 rounded-full bg-yellow-100 text-yellow-700 flex items-center justify-center font-bold text-lg select-none">
                        PG
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Pedro Gómez</h3>
                        <p class="text-xs text-gray-500 font-semibold">Lic. en Informática · 7mo Semestre</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 mb-4 text-sm">
                    <div class="mb-2">
                        <span class="text-xs text-gray-400 block font-medium">Proyecto solicitado</span>
                        <span class="font-bold text-gray-800">Desarrollo de App Móvil de Inventario</span>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-xs text-gray-400 block font-medium">Promedio General</span>
                            <span class="font-bold text-gray-800">8.9 / 10.0</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 block font-medium">Matrícula (Control)</span>
                            <span class="font-bold text-gray-800">20184596</span>
                        </div>
                    </div>
                </div>

                <div class="text-sm text-gray-600 italic line-clamp-2 leading-relaxed mb-6">
                    "Me entusiasma la idea de trabajar en proyectos móviles y aplicar mis conocimientos en Flutter. Me considero una persona proactiva y comprometida."
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-3 pt-4 border-t border-gray-100 action-buttons-container">
                <button onclick="openReviewModal(1)" class="flex-1 bg-[#6BA53A] hover:bg-[#4E7D24] text-white text-xs font-bold py-2.5 rounded-xl transition-all shadow-sm cursor-pointer text-center">
                    Revisar y Decidir
                </button>
            </div>
        </div>

        <!-- Application 2: Pending (Ana Silva) -->
        <div class="glass-card rounded-3xl p-6 flex flex-col justify-between group border border-gray-200/50 hover:border-yellow-300" data-id="2" data-status="pendiente" data-proyecto="aws" data-carrera="software">
            <div>
                <div class="flex justify-between items-start mb-4">
                    <span class="px-3 py-1 bg-yellow-50 text-yellow-700 border border-yellow-150 rounded-full text-xs font-bold uppercase tracking-wide status-badge">Pendiente</span>
                    <span class="text-xs font-semibold text-gray-400 flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Recibida: Hace 1 día
                    </span>
                </div>
                
                <div class="flex items-center gap-4 mb-4">
                    <div class="h-12 w-12 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-lg select-none">
                        AS
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Ana Silva</h3>
                        <p class="text-xs text-gray-500 font-semibold">Ing. en Software · 8vo Semestre</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 mb-4 text-sm">
                    <div class="mb-2">
                        <span class="text-xs text-gray-400 block font-medium">Proyecto solicitado</span>
                        <span class="font-bold text-gray-800">Migración e Integración Cloud AWS</span>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-xs text-gray-400 block font-medium">Promedio General</span>
                            <span class="font-bold text-gray-800">9.3 / 10.0</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 block font-medium">Matrícula (Control)</span>
                            <span class="font-bold text-gray-800">20173256</span>
                        </div>
                    </div>
                </div>

                <div class="text-sm text-gray-600 italic line-clamp-2 leading-relaxed mb-6">
                    "Tengo experiencia en despliegues básicos de Docker y me gustaría especializarme en Cloud DevOps. Este proyecto se alinea perfectamente con mis metas profesionales."
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-3 pt-4 border-t border-gray-100 action-buttons-container">
                <button onclick="openReviewModal(2)" class="flex-1 bg-[#6BA53A] hover:bg-[#4E7D24] text-white text-xs font-bold py-2.5 rounded-xl transition-all shadow-sm cursor-pointer text-center">
                    Revisar y Decidir
                </button>
            </div>
        </div>

        <!-- Application 3: Accepted (María Rodríguez) -->
        <div class="glass-card rounded-3xl p-6 flex flex-col justify-between group border border-gray-200/50 hover:border-green-300" data-id="3" data-status="aceptada" data-proyecto="inventario" data-carrera="software">
            <div>
                <div class="flex justify-between items-start mb-4">
                    <span class="px-3 py-1 bg-green-50 text-green-700 border border-green-150 rounded-full text-xs font-bold uppercase tracking-wide status-badge">Aceptada</span>
                    <span class="text-xs font-semibold text-gray-400 flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Aceptada: Hace 5 días
                    </span>
                </div>
                
                <div class="flex items-center gap-4 mb-4">
                    <div class="h-12 w-12 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold text-lg select-none">
                        MR
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">María Rodríguez</h3>
                        <p class="text-xs text-gray-500 font-semibold">Ing. en Software · 8vo Semestre</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 mb-4 text-sm">
                    <div class="mb-2">
                        <span class="text-xs text-gray-400 block font-medium">Proyecto solicitado</span>
                        <span class="font-bold text-gray-800">Desarrollo de App Móvil de Inventario</span>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-xs text-gray-400 block font-medium">Promedio General</span>
                            <span class="font-bold text-gray-800">9.5 / 10.0</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 block font-medium">Matrícula (Control)</span>
                            <span class="font-bold text-gray-800">20173845</span>
                        </div>
                    </div>
                </div>

                <div class="text-xs text-gray-500 p-3 bg-green-50/50 rounded-xl border border-green-100/50">
                    <span class="font-bold text-green-800 block mb-0.5">Observación del Tutor:</span>
                    "Excelente promedio y perfil técnico afín con Flutter."
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-3 pt-4 border-t border-gray-100 action-buttons-container">
                <button onclick="openReviewModal(3)" class="flex-1 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 text-xs font-bold py-2.5 rounded-xl transition-all cursor-pointer text-center">
                    Ver Detalles
                </button>
            </div>
        </div>

        <!-- Application 4: Rejected (Luis Fernando) -->
        <div class="glass-card rounded-3xl p-6 flex flex-col justify-between group border border-gray-200/50 hover:border-red-300" data-id="4" data-status="rechazada" data-proyecto="qa" data-carrera="telematica">
            <div>
                <div class="flex justify-between items-start mb-4">
                    <span class="px-3 py-1 bg-red-50 text-red-700 border border-red-150 rounded-full text-xs font-bold uppercase tracking-wide status-badge">Rechazada</span>
                    <span class="text-xs font-semibold text-gray-400 flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Rechazada: Hace 6 días
                    </span>
                </div>
                
                <div class="flex items-center gap-4 mb-4">
                    <div class="h-12 w-12 rounded-full bg-red-100 text-red-700 flex items-center justify-center font-bold text-lg select-none">
                        LF
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Luis Fernando</h3>
                        <p class="text-xs text-gray-500 font-semibold">Ing. en Telemática · 6to Semestre</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 mb-4 text-sm">
                    <div class="mb-2">
                        <span class="text-xs text-gray-400 block font-medium">Proyecto solicitado</span>
                        <span class="font-bold text-gray-800">Automatización de Pruebas QA</span>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-xs text-gray-400 block font-medium">Promedio General</span>
                            <span class="font-bold text-gray-800">8.2 / 10.0</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 block font-medium">Matrícula (Control)</span>
                            <span class="font-bold text-gray-800">20198642</span>
                        </div>
                    </div>
                </div>

                <div class="text-xs text-gray-500 p-3 bg-red-50/50 rounded-xl border border-red-100/50">
                    <span class="font-bold text-red-800 block mb-0.5">Motivo del rechazo:</span>
                    "Requerimos estudiantes de semestres más avanzados (7mo u 8vo) con conocimientos específicos de programación orientada a objetos."
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-3 pt-4 border-t border-gray-100 action-buttons-container">
                <button onclick="openReviewModal(4)" class="flex-1 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 text-xs font-bold py-2.5 rounded-xl transition-all cursor-pointer text-center">
                    Ver Detalles
                </button>
            </div>
        </div>

    </div>

    <!-- Review Modal -->
    <div id="reviewModal" class="fixed inset-0 z-50 overflow-y-auto hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-all duration-300">
        <div class="bg-white rounded-3xl border border-gray-200 shadow-2xl max-w-2xl w-full max-h-[90vh] flex flex-col relative overflow-hidden transition-all duration-300 scale-95 opacity-0" id="modalCard">
            <!-- Modal Header -->
            <div class="px-8 py-5 bg-gradient-to-r from-gray-50 to-white border-b border-gray-150 flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2" id="modalTitle">
                    <svg class="w-6 h-6 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Revisar Solicitud de Practicante
                </h3>
                <button onclick="closeReviewModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 p-1.5 rounded-full transition-all cursor-pointer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Modal Body (Scrollable) -->
            <div class="flex-1 overflow-y-auto px-8 py-6 space-y-6">
                <!-- Estudiante Perfil Resumen -->
                <div class="flex items-center gap-4 bg-gray-50 border border-gray-150 p-5 rounded-2xl">
                    <div class="h-16 w-16 rounded-full bg-[#6BA53A]/20 text-[#4E7D24] flex items-center justify-center font-bold text-xl select-none" id="modalStudentAvatar">
                        ?
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-900" id="modalStudentName">Nombre Estudiante</h4>
                        <p class="text-sm text-[#6BA53A] font-bold" id="modalStudentCareer">Carrera y Semestre</p>
                        <p class="text-xs text-gray-400 font-medium" id="modalStudentEmail">correo@ucol.mx</p>
                    </div>
                </div>

                <!-- Detalles de Solicitud -->
                <div class="grid grid-cols-2 gap-6 text-sm">
                    <div>
                        <span class="text-xs text-gray-400 block font-bold uppercase tracking-wide">Proyecto Solicitado</span>
                        <span class="font-bold text-gray-800" id="modalProjectName">Nombre Proyecto</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 block font-bold uppercase tracking-wide">Promedio Académico</span>
                        <span class="font-bold text-gray-800" id="modalStudentAverage">0.0 / 10.0</span>
                    </div>
                </div>

                <!-- Mensaje Estudiante -->
                <div id="studentMsgContainer">
                    <span class="text-xs text-gray-400 block font-bold uppercase tracking-wide mb-2">Mensaje de Interés / Motivación</span>
                    <div class="p-4 bg-gray-50 rounded-2xl border border-gray-150 text-sm text-gray-700 italic leading-relaxed" id="modalStudentMsg">
                        "Mensaje de ejemplo..."
                    </div>
                </div>

                <!-- Comentario / Observación form -->
                <div id="commentFormContainer">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Observaciones o Comentarios</label>
                    <textarea id="modalComment" rows="3" placeholder="Ingresa comentarios de retroalimentación para el alumno..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#6BA53A] focus:bg-white transition-all text-sm font-medium resize-none"></textarea>
                    <p class="text-[11px] text-gray-400 mt-1" id="commentHelpText">Los comentarios serán visibles para el estudiante en su consulta de estatus.</p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-8 py-5 bg-gray-50 border-t border-gray-150 flex gap-3 justify-between items-center" id="modalFooter">
                <!-- Left aligned warning/info -->
                <span class="text-[11px] text-red-500 font-bold hidden" id="rejectWarning">El comentario es obligatorio para rechazar.</span>
                
                <!-- Buttons -->
                <div class="flex gap-3 justify-end ml-auto">
                    <button onclick="closeReviewModal()" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-2xl hover:bg-gray-100 transition-all cursor-pointer">
                        Cancelar
                    </button>
                    <div class="flex gap-2" id="actionBtnContainer">
                        <button onclick="resolveRequest(false)" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-2xl transition-all shadow-sm cursor-pointer">
                            Rechazar
                        </button>
                        <button onclick="resolveRequest(true)" class="px-5 py-2.5 bg-[#6BA53A] hover:bg-[#4E7D24] text-white text-sm font-bold rounded-2xl transition-all shadow-sm cursor-pointer">
                            Aceptar Alumno
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Logic for interactions -->
    <script>
        // Mock Data Storage for current requests
        const mockRequests = {
            1: {
                id: 1,
                name: "Pedro Gómez",
                initials: "PG",
                avatarBg: "bg-yellow-100 text-yellow-700",
                career: "Lic. en Informática · 7mo Semestre",
                email: "pgomez@ucol.mx",
                projectName: "Desarrollo de App Móvil de Inventario",
                average: "8.9 / 10.0",
                message: "Me entusiasma la idea de trabajar en proyectos móviles y aplicar mis conocimientos en Flutter. Me considero una persona proactiva y comprometida.",
                status: "pendiente",
                comment: ""
            },
            2: {
                id: 2,
                name: "Ana Silva",
                initials: "AS",
                avatarBg: "bg-blue-100 text-blue-700",
                career: "Ing. en Software · 8vo Semestre",
                email: "asilva@ucol.mx",
                projectName: "Migración e Integración Cloud AWS",
                average: "9.3 / 10.0",
                message: "Tengo experiencia en despliegues básicos de Docker y me gustaría especializarme en Cloud DevOps. Este proyecto se alinea perfectamente con mis metas profesionales.",
                status: "pendiente",
                comment: ""
            },
            3: {
                id: 3,
                name: "María Rodríguez",
                initials: "MR",
                avatarBg: "bg-green-100 text-green-700",
                career: "Ing. en Software · 8vo Semestre",
                email: "mrodriguez@ucol.mx",
                projectName: "Desarrollo de App Móvil de Inventario",
                average: "9.5 / 10.0",
                message: "Aceptada anteriormente.",
                status: "aceptada",
                comment: "Excelente promedio y perfil técnico afín con Flutter."
            },
            4: {
                id: 4,
                name: "Luis Fernando",
                initials: "LF",
                avatarBg: "bg-red-100 text-red-700",
                career: "Ing. en Telemática · 6to Semestre",
                email: "lfernando@ucol.mx",
                projectName: "Automatización de Pruebas QA",
                average: "8.2 / 10.0",
                message: "Rechazada anteriormente.",
                status: "rechazada",
                comment: "Requerimos estudiantes de semestres más avanzados (7mo u 8vo) con conocimientos específicos de programación orientada a objetos."
            }
        };

        let currentActiveReviewId = null;

        // Modal triggers
        function openReviewModal(id) {
            currentActiveReviewId = id;
            const req = mockRequests[id];
            
            // Populating student details
            document.getElementById('modalStudentAvatar').textContent = req.initials;
            // Clean up avatar bg class list and add current
            document.getElementById('modalStudentAvatar').className = `h-16 w-16 rounded-full flex items-center justify-center font-bold text-xl select-none ${req.avatarBg}`;
            document.getElementById('modalStudentName').textContent = req.name;
            document.getElementById('modalStudentCareer').textContent = req.career;
            document.getElementById('modalStudentEmail').textContent = req.email;
            document.getElementById('modalProjectName').textContent = req.projectName;
            document.getElementById('modalStudentAverage').textContent = req.average;
            
            // Comment values
            document.getElementById('modalComment').value = req.comment || '';
            document.getElementById('rejectWarning').classList.add('hidden');

            const isPending = req.status === 'pendiente';
            
            if (isPending) {
                // Show message section
                document.getElementById('studentMsgContainer').classList.remove('hidden');
                document.getElementById('modalStudentMsg').textContent = `"${req.message}"`;
                
                // Show input field
                document.getElementById('commentFormContainer').classList.remove('hidden');
                document.getElementById('modalComment').disabled = false;
                document.getElementById('modalComment').placeholder = "Ingresa comentarios de retroalimentación...";
                document.getElementById('commentHelpText').textContent = "Los comentarios serán visibles para el estudiante en su consulta de estatus.";
                
                // Show decision buttons
                document.getElementById('actionBtnContainer').classList.remove('hidden');
            } else {
                // Hide message section for completed review if not needed, or show static
                document.getElementById('studentMsgContainer').classList.add('hidden');
                
                // Static read-only comment
                document.getElementById('commentFormContainer').classList.remove('hidden');
                document.getElementById('modalComment').disabled = true;
                document.getElementById('modalComment').placeholder = "";
                document.getElementById('commentHelpText').textContent = `Esta solicitud fue resuelta con estado: ${req.status.toUpperCase()}`;
                
                // Hide decision buttons
                document.getElementById('actionBtnContainer').classList.add('hidden');
            }

            const modal = document.getElementById('reviewModal');
            const card = document.getElementById('modalCard');

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            document.body.style.overflow = 'hidden';
        }

        function closeReviewModal() {
            const modal = document.getElementById('reviewModal');
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
                closeReviewModal();
            }
        });

        // Resolve request logic
        function resolveRequest(isApproved) {
            const comment = document.getElementById('modalComment').value.trim();
            const warningEl = document.getElementById('rejectWarning');
            
            // Require comment on reject
            if (!isApproved && comment === '') {
                warningEl.textContent = "El comentario es obligatorio para rechazar.";
                warningEl.classList.remove('hidden');
                return;
            }

            const req = mockRequests[currentActiveReviewId];
            req.status = isApproved ? 'aceptada' : 'rechazada';
            req.comment = comment;

            // Update UI card dynamically
            const card = document.querySelector(`#solicitudesGrid > div[data-id="${currentActiveReviewId}"]`);
            const badge = card.querySelector('.status-badge');
            
            if (isApproved) {
                badge.className = "px-3 py-1 bg-green-50 text-green-700 border border-green-150 rounded-full text-xs font-bold uppercase tracking-wide status-badge";
                badge.textContent = "Aceptada";
                card.style.borderColor = "rgba(78, 125, 36, 0.3)";
            } else {
                badge.className = "px-3 py-1 bg-red-50 text-red-700 border border-red-150 rounded-full text-xs font-bold uppercase tracking-wide status-badge";
                badge.textContent = "Rechazada";
                card.style.borderColor = "rgba(220, 38, 38, 0.3)";
            }
            
            // Update time/text
            card.querySelector('.text-xs.font-semibold.text-gray-400').innerHTML = `
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Resuelta: Ahora mismo
            `;

            // Change button from "Revisar" to "Ver Detalles"
            const btnContainer = card.querySelector('.action-buttons-container');
            btnContainer.innerHTML = `
                <button onclick="openReviewModal(${currentActiveReviewId})" class="flex-1 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 text-xs font-bold py-2.5 rounded-xl transition-all cursor-pointer text-center">
                    Ver Detalles
                </button>
            `;

            // Append or replace block content of comment
            let commentBlock = card.querySelector('.text-xs.text-gray-500');
            if (!commentBlock) {
                commentBlock = document.createElement('div');
                commentBlock.className = "text-xs text-gray-500 p-3 rounded-xl border mt-4";
                card.querySelector('.bg-gray-50').after(commentBlock);
            }
            
            if (isApproved) {
                commentBlock.className = "text-xs text-gray-500 p-3 bg-green-50/50 rounded-xl border border-green-100/50 mt-4";
                commentBlock.innerHTML = `<span class="font-bold text-green-800 block mb-0.5">Observación del Tutor:</span> "${comment || 'Sin comentarios adicionales.'}"`;
            } else {
                commentBlock.className = "text-xs text-gray-500 p-3 bg-red-50/50 rounded-xl border border-red-100/50 mt-4";
                commentBlock.innerHTML = `<span class="font-bold text-red-800 block mb-0.5">Motivo del rechazo:</span> "${comment}"`;
            }

            // Update attributes for filtering
            card.setAttribute('data-status', req.status);

            // Re-calculate metrics
            updateMetrics();

            alert(`Solicitud del estudiante ${req.name} ha sido ${isApproved ? 'ACEPTADA' : 'RECHAZADA'} con éxito.`);
            closeReviewModal();
        }

        function updateMetrics() {
            let pending = 0;
            let accepted = 0;
            let rejected = 0;
            
            Object.values(mockRequests).forEach(req => {
                if (req.status === 'pendiente') pending++;
                else if (req.status === 'aceptada') accepted++;
                else if (req.status === 'rechazada') rejected++;
            });

            document.getElementById('metricPending').textContent = pending;
            document.getElementById('metricAccepted').textContent = accepted;
            document.getElementById('metricRejected').textContent = rejected;
            document.getElementById('metricTotal').textContent = pending + accepted + rejected;
        }

        // Live search and filter implementation
        const searchInput = document.getElementById('solicitudSearch');
        const selectProyecto = document.getElementById('filterProyecto');
        const selectCarrera = document.getElementById('filterCarrera');
        const selectEstado = document.getElementById('filterEstado');

        function filterSolicitudes() {
            const query = searchInput.value.toLowerCase();
            const proyectoFilter = selectProyecto.value;
            const carreraFilter = selectCarrera.value;
            const estadoFilter = selectEstado.value;
            const cards = document.querySelectorAll('#solicitudesGrid > div');

            cards.forEach(card => {
                const name = card.querySelector('h3').textContent.toLowerCase();
                const careerText = card.querySelector('.text-xs.text-gray-500').textContent.toLowerCase();
                const projectText = card.querySelector('.font-bold.text-gray-800').textContent.toLowerCase();
                const status = card.getAttribute('data-status');
                const projectAttr = card.getAttribute('data-proyecto');
                const careerAttr = card.getAttribute('data-carrera');

                const matchesSearch = name.includes(query) || careerText.includes(query) || projectText.includes(query);
                const matchesProyecto = !proyectoFilter || projectAttr === proyectoFilter;
                const matchesCarrera = !carreraFilter || careerAttr === carreraFilter;
                const matchesEstado = !estadoFilter || status === estadoFilter;

                if (matchesSearch && matchesProyecto && matchesCarrera && matchesEstado) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', filterSolicitudes);
        selectProyecto.addEventListener('change', filterSolicitudes);
        selectCarrera.addEventListener('change', filterSolicitudes);
        selectEstado.addEventListener('change', filterSolicitudes);
    </script>
@endsection
