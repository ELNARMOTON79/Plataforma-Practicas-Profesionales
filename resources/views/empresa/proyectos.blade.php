@extends('layouts.empresa', ['title' => 'Proyectos - Prácticas Profesionales UdeC', 'active' => 'proyectos'])

@section('content')
    <!-- Header -->
    <x-page-header title="Gestión de Proyectos" description="Registra y administra proyectos disponibles para estudiantes de prácticas profesionales.">
        <x-slot name="actions">
            <button onclick="openModal('create')" class="flex items-center gap-2 bg-[#6BA53A] hover:bg-[#4E7D24] text-white font-bold py-2.5 px-5 rounded-2xl transition-all duration-300 shadow-md hover:shadow-lg hover:scale-[1.02] transform cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Registrar Proyecto
            </button>
        </x-slot>
    </x-page-header>

    <!-- Metrics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 fade-in-up delay-100">
        <!-- Proyectos Registrados -->
        <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group border-transparent hover:border-[#6BA53A]/30 transition-colors">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-[#4E7D24]" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path></svg>
            </div>
            <span class="text-sm font-bold text-gray-500 mb-2">Total Proyectos</span>
            <div class="flex items-end gap-3 mb-2">
                <span class="text-4xl font-extrabold text-gray-900">4</span>
            </div>
            <span class="text-xs text-gray-400 font-medium">Proyectos en catálogo</span>
        </div>

        <!-- Cupos Totales -->
        <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group border-transparent hover:border-blue-300 transition-colors">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4 15a4 4 0 018 0v3H4v-3z"></path></svg>
            </div>
            <span class="text-sm font-bold text-gray-500 mb-2">Cupos Ofertados</span>
            <div class="flex items-end gap-3 mb-2">
                <span class="text-4xl font-extrabold text-gray-900">14</span>
            </div>
            <span class="text-xs text-gray-400 font-medium">Capacidad total autorizada</span>
        </div>

        <!-- Cupos Asignados -->
        <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group border-transparent hover:border-green-300 transition-colors">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            </div>
            <span class="text-sm font-bold text-gray-500 mb-2">Cupos Ocupados</span>
            <div class="flex items-end gap-3 mb-2">
                <span class="text-4xl font-extrabold text-gray-900">6</span>
                <span class="flex items-center text-sm font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-md mb-1 border border-green-100">
                    42%
                </span>
            </div>
            <span class="text-xs text-gray-400 font-medium">Estudiantes ya asignados</span>
        </div>

        <!-- Proyectos Activos -->
        <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group border-transparent hover:border-purple-300 transition-colors">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-purple-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path></svg>
            </div>
            <span class="text-sm font-bold text-gray-500 mb-2">Proyectos Activos</span>
            <div class="flex items-end gap-3 mb-2">
                <span class="text-4xl font-extrabold text-gray-900">3</span>
            </div>
            <span class="text-xs text-gray-400 font-medium">Visibles para los estudiantes</span>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="glass-card rounded-3xl p-6 fade-in-up delay-200">
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="relative w-full md:flex-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" id="projectSearch" placeholder="Buscar proyectos por título, tutor o tecnología..." class="w-full pl-11 pr-4 py-2.5 bg-white/50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#6BA53A] focus:border-transparent transition-all text-sm font-medium">
            </div>
            
            <div class="flex flex-wrap md:flex-nowrap gap-3 w-full md:w-auto">
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
                        <option value="activo">Activo</option>
                        <option value="borrador">Borrador</option>
                        <option value="lleno">Lleno</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Projects Grid -->
    <div id="projectsGrid" class="grid grid-cols-1 md:grid-cols-2 gap-8 fade-in-up delay-300">
        
        <!-- Project 1: Active -->
        <div class="glass-card rounded-3xl p-6 flex flex-col justify-between group border border-gray-200/50 hover:border-[#6BA53A]/40" data-status="activo" data-carrera="software informatica">
            <div>
                <div class="flex justify-between items-start mb-4">
                    <span class="px-3 py-1 bg-green-50 text-green-700 border border-green-200 rounded-full text-xs font-bold uppercase tracking-wide">Activo</span>
                    <span class="text-xs font-semibold text-gray-400 flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Creado: Hace 5 días
                    </span>
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors mb-2">Desarrollo de App Móvil de Inventario</h3>
                <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                    Creación y optimización de una aplicación móvil corporativa para el control de stock, inventarios y generación de reportes en tiempo real. Utilizando Flutter y Firebase.
                </p>

                <!-- Tags / Careers -->
                <div class="flex flex-wrap gap-2 mb-6">
                    <span class="text-xs font-bold text-[#6BA53A] bg-[#6BA53A]/10 px-3 py-1 rounded-lg">Ing. en Software</span>
                    <span class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-lg">Lic. en Informática</span>
                    <span class="text-xs font-semibold text-gray-500 bg-gray-100 px-3 py-1 rounded-lg">Híbrido</span>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-2 gap-4 py-4 border-t border-b border-gray-100 mb-6 text-sm">
                    <div>
                        <span class="text-xs text-gray-400 block font-medium">Tutor Responsable</span>
                        <span class="font-bold text-gray-800">Ing. Carlos Mendoza</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 block font-medium">Horario sugerido</span>
                        <span class="font-bold text-gray-800">08:00 AM - 02:00 PM</span>
                    </div>
                </div>

                <!-- Progress / Slot allocation -->
                <div class="mb-6">
                    <div class="flex justify-between items-center text-xs font-bold text-gray-500 mb-1.5">
                        <span>Cupos cubiertos</span>
                        <span class="text-[#4E7D24]">3 de 5 alumnos</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                        <div class="bg-[#6BA53A] h-2.5 rounded-full transition-all duration-500" style="width: 60%"></div>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="flex gap-3 mt-4 pt-4 border-t border-gray-100">
                <a href="{{ route('empresa.solicitudes') }}" class="flex-1 text-center bg-[#6BA53A]/10 text-[#4E7D24] text-xs font-bold py-2.5 rounded-xl hover:bg-[#6BA53A]/20 transition-all">Ver Postulantes (3)</a>
                <button onclick="openModal('edit', 1)" class="p-2.5 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 text-gray-500 hover:text-gray-900 transition-all cursor-pointer" title="Editar proyecto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </button>
                <button onclick="confirmDelete(1)" class="p-2.5 bg-white border border-gray-200 rounded-xl hover:bg-red-50 text-gray-400 hover:text-red-600 transition-all cursor-pointer" title="Eliminar proyecto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>
        </div>

        <!-- Project 2: Active & Full -->
        <div class="glass-card rounded-3xl p-6 flex flex-col justify-between group border border-gray-200/50 hover:border-[#6BA53A]/40" data-status="lleno" data-carrera="software telematica">
            <div>
                <div class="flex justify-between items-start mb-4">
                    <span class="px-3 py-1 bg-blue-50 text-blue-700 border border-blue-200 rounded-full text-xs font-bold uppercase tracking-wide">Cupos Llenos</span>
                    <span class="text-xs font-semibold text-gray-400 flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Creado: Hace 10 días
                    </span>
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors mb-2">Migración e Integración Cloud AWS</h3>
                <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                    Proyecto enfocado en la migración de microservicios heredados (On-Premise) hacia una arquitectura serverless en AWS. Creación de pipelines CI/CD y monitoreo con CloudWatch.
                </p>

                <!-- Tags / Careers -->
                <div class="flex flex-wrap gap-2 mb-6">
                    <span class="text-xs font-bold text-[#6BA53A] bg-[#6BA53A]/10 px-3 py-1 rounded-lg">Ing. en Software</span>
                    <span class="text-xs font-bold text-purple-600 bg-purple-50 px-3 py-1 rounded-lg">Ing. en Telemática</span>
                    <span class="text-xs font-semibold text-gray-500 bg-gray-100 px-3 py-1 rounded-lg">Remoto</span>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-2 gap-4 py-4 border-t border-b border-gray-100 mb-6 text-sm">
                    <div>
                        <span class="text-xs text-gray-400 block font-medium">Tutor Responsable</span>
                        <span class="font-bold text-gray-800">Ing. Laura Rodríguez</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 block font-medium">Horario sugerido</span>
                        <span class="font-bold text-gray-800">09:00 AM - 01:00 PM</span>
                    </div>
                </div>

                <!-- Progress / Slot allocation -->
                <div class="mb-6">
                    <div class="flex justify-between items-center text-xs font-bold text-gray-500 mb-1.5">
                        <span>Cupos cubiertos</span>
                        <span class="text-blue-600">3 de 3 alumnos</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                        <div class="bg-blue-500 h-2.5 rounded-full transition-all duration-500" style="width: 100%"></div>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="flex gap-3 mt-4 pt-4 border-t border-gray-100">
                <a href="{{ route('empresa.solicitudes') }}" class="flex-1 text-center bg-gray-100 text-gray-400 text-xs font-bold py-2.5 rounded-xl cursor-not-allowed">Proyecto Completo</a>
                <button onclick="openModal('edit', 2)" class="p-2.5 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 text-gray-500 hover:text-gray-900 transition-all cursor-pointer" title="Editar proyecto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </button>
                <button onclick="confirmDelete(2)" class="p-2.5 bg-white border border-gray-200 rounded-xl hover:bg-red-50 text-gray-400 hover:text-red-600 transition-all cursor-pointer" title="Eliminar proyecto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>
        </div>

        <!-- Project 3: Draft -->
        <div class="glass-card rounded-3xl p-6 flex flex-col justify-between group border border-gray-200/50 hover:border-[#6BA53A]/40" data-status="borrador" data-carrera="software informatica">
            <div>
                <div class="flex justify-between items-start mb-4">
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 border border-gray-200 rounded-full text-xs font-bold uppercase tracking-wide">Borrador</span>
                    <span class="text-xs font-semibold text-gray-400 flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Creado: Hace 1 día
                    </span>
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors mb-2">Optimización y Seguridad en Base de Datos</h3>
                <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                    Auditoría de seguridad y afinamiento de índices en el motor de base de datos PostgreSQL de la empresa. Creación de vistas materializadas y triggers de control.
                </p>

                <!-- Tags / Careers -->
                <div class="flex flex-wrap gap-2 mb-6">
                    <span class="text-xs font-bold text-[#6BA53A] bg-[#6BA53A]/10 px-3 py-1 rounded-lg">Ing. en Software</span>
                    <span class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-lg">Lic. en Informática</span>
                    <span class="text-xs font-semibold text-gray-500 bg-gray-100 px-3 py-1 rounded-lg">Presencial</span>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-2 gap-4 py-4 border-t border-b border-gray-100 mb-6 text-sm">
                    <div>
                        <span class="text-xs text-gray-400 block font-medium">Tutor Responsable</span>
                        <span class="font-bold text-gray-800">M.C. Jorge Alcaraz</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 block font-medium">Horario sugerido</span>
                        <span class="font-bold text-gray-800">10:00 AM - 04:00 PM</span>
                    </div>
                </div>

                <!-- Progress / Slot allocation -->
                <div class="mb-6">
                    <div class="flex justify-between items-center text-xs font-bold text-gray-500 mb-1.5">
                        <span>Cupos cubiertos</span>
                        <span class="text-gray-500">0 de 2 alumnos</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                        <div class="bg-gray-300 h-2.5 rounded-full transition-all duration-500" style="width: 0%"></div>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="flex gap-3 mt-4 pt-4 border-t border-gray-100">
                <button onclick="publishProject(3)" class="flex-1 text-center bg-[#6BA53A] text-white text-xs font-bold py-2.5 rounded-xl hover:bg-[#4E7D24] transition-all cursor-pointer">Publicar Proyecto</button>
                <button onclick="openModal('edit', 3)" class="p-2.5 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 text-gray-500 hover:text-gray-900 transition-all cursor-pointer" title="Editar proyecto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </button>
                <button onclick="confirmDelete(3)" class="p-2.5 bg-white border border-gray-200 rounded-xl hover:bg-red-50 text-gray-400 hover:text-red-600 transition-all cursor-pointer" title="Eliminar proyecto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>
        </div>

        <!-- Project 4: Active -->
        <div class="glass-card rounded-3xl p-6 flex flex-col justify-between group border border-gray-200/50 hover:border-[#6BA53A]/40" data-status="activo" data-carrera="software telematica">
            <div>
                <div class="flex justify-between items-start mb-4">
                    <span class="px-3 py-1 bg-green-50 text-green-700 border border-green-200 rounded-full text-xs font-bold uppercase tracking-wide">Activo</span>
                    <span class="text-xs font-semibold text-gray-400 flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Creado: Hace 12 días
                    </span>
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors mb-2">Automatización de Pruebas QA</h3>
                <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                    Implementación de un plan de pruebas automatizado de extremo a extremo (E2E) con Cypress en nuestro portal web comercial y microservicios backend.
                </p>

                <!-- Tags / Careers -->
                <div class="flex flex-wrap gap-2 mb-6">
                    <span class="text-xs font-bold text-[#6BA53A] bg-[#6BA53A]/10 px-3 py-1 rounded-lg">Ing. en Software</span>
                    <span class="text-xs font-bold text-purple-600 bg-purple-50 px-3 py-1 rounded-lg">Ing. en Telemática</span>
                    <span class="text-xs font-semibold text-gray-500 bg-gray-100 px-3 py-1 rounded-lg">Remoto</span>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-2 gap-4 py-4 border-t border-b border-gray-100 mb-6 text-sm">
                    <div>
                        <span class="text-xs text-gray-400 block font-medium">Tutor Responsable</span>
                        <span class="font-bold text-gray-800">Ing. Pedro Ortiz</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 block font-medium">Horario sugerido</span>
                        <span class="font-bold text-gray-800">09:00 AM - 01:00 PM</span>
                    </div>
                </div>

                <!-- Progress / Slot allocation -->
                <div class="mb-6">
                    <div class="flex justify-between items-center text-xs font-bold text-gray-500 mb-1.5">
                        <span>Cupos cubiertos</span>
                        <span class="text-[#4E7D24]">0 de 4 alumnos</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                        <div class="bg-[#6BA53A] h-2.5 rounded-full transition-all duration-500" style="width: 0%"></div>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="flex gap-3 mt-4 pt-4 border-t border-gray-100">
                <a href="{{ route('empresa.solicitudes') }}" class="flex-1 text-center bg-[#6BA53A]/10 text-[#4E7D24] text-xs font-bold py-2.5 rounded-xl hover:bg-[#6BA53A]/20 transition-all">Ver Postulantes (0)</a>
                <button onclick="openModal('edit', 4)" class="p-2.5 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 text-gray-500 hover:text-gray-900 transition-all cursor-pointer" title="Editar proyecto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </button>
                <button onclick="confirmDelete(4)" class="p-2.5 bg-white border border-gray-200 rounded-xl hover:bg-red-50 text-gray-400 hover:text-red-600 transition-all cursor-pointer" title="Eliminar proyecto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>
        </div>

    </div>

    <!-- Modal for Create/Edit Project -->
    <div id="projectModal" class="fixed inset-0 z-50 overflow-y-auto hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-all duration-300">
        <div class="bg-white rounded-3xl border border-gray-200 shadow-2xl max-w-2xl w-full max-h-[90vh] flex flex-col relative overflow-hidden transition-all duration-300 scale-95 opacity-0" id="modalCard">
            <!-- Modal Header -->
            <div class="px-8 py-5 bg-gradient-to-r from-gray-50 to-white border-b border-gray-150 flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2" id="modalTitle">
                    <svg class="w-6 h-6 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Registrar Nuevo Proyecto
                </h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 p-1.5 rounded-full transition-all cursor-pointer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Modal Body (Scrollable) -->
            <div class="flex-1 overflow-y-auto px-8 py-6 space-y-5">
                <form id="projectForm" class="space-y-5" onsubmit="event.preventDefault();">
                    <!-- Title -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nombre del Proyecto</label>
                        <input type="text" id="formTitle" placeholder="Ej. Sistema de Control de Clientes" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#6BA53A] focus:bg-white transition-all text-sm font-medium">
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Descripción General</label>
                        <textarea id="formDescription" rows="3" placeholder="Describe brevemente las actividades, tecnologías y objetivos del proyecto..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#6BA53A] focus:bg-white transition-all text-sm font-medium resize-none"></textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Tutor -->
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tutor / Responsable</label>
                            <input type="text" id="formTutor" placeholder="Nombre completo y cargo" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#6BA53A] focus:bg-white transition-all text-sm font-medium">
                        </div>

                        <!-- Horario -->
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Horario Sugerido</label>
                            <input type="text" id="formHorario" placeholder="Ej. 08:00 AM - 02:00 PM" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#6BA53A] focus:bg-white transition-all text-sm font-medium">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Modalidad -->
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Modalidad</label>
                            <select id="formModalidad" class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-4 py-2.5 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#6BA53A] focus:bg-white transition-all cursor-pointer">
                                <option value="Presencial">Presencial</option>
                                <option value="Remoto">Remoto</option>
                                <option value="Híbrido">Híbrido</option>
                            </select>
                        </div>

                        <!-- Cupos -->
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Cupos Totales</label>
                            <input type="number" id="formCupos" min="1" max="20" placeholder="Ej. 3" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#6BA53A] focus:bg-white transition-all text-sm font-medium">
                        </div>
                    </div>

                    <!-- Carreras Afines -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Carreras Afines</label>
                        <div class="grid grid-cols-2 gap-3 bg-gray-50 p-4 rounded-2xl border border-gray-150">
                            <label class="flex items-center gap-3 text-sm font-medium text-gray-700 cursor-pointer">
                                <input type="checkbox" name="carreras" value="software" checked class="rounded text-[#6BA53A] focus:ring-[#6BA53A] h-4 w-4">
                                Ing. en Software
                            </label>
                            <label class="flex items-center gap-3 text-sm font-medium text-gray-700 cursor-pointer">
                                <input type="checkbox" name="carreras" value="informatica" class="rounded text-[#6BA53A] focus:ring-[#6BA53A] h-4 w-4">
                                Lic. en Informática
                            </label>
                            <label class="flex items-center gap-3 text-sm font-medium text-gray-700 cursor-pointer">
                                <input type="checkbox" name="carreras" value="telematica" class="rounded text-[#6BA53A] focus:ring-[#6BA53A] h-4 w-4">
                                Ing. en Telemática
                            </label>
                            <label class="flex items-center gap-3 text-sm font-medium text-gray-700 cursor-pointer">
                                <input type="checkbox" name="carreras" value="diseno" class="rounded text-[#6BA53A] focus:ring-[#6BA53A] h-4 w-4">
                                Lic. en Diseño
                            </label>
                        </div>
                    </div>

                    <!-- Estado Inicial -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Estado del Proyecto</label>
                        <div class="flex gap-4">
                            <label class="flex-1 flex items-center justify-between p-3.5 bg-gray-50 border border-gray-200 rounded-2xl cursor-pointer hover:bg-gray-100/50 transition-all">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="estado" value="activo" checked class="text-[#6BA53A] focus:ring-[#6BA53A] h-4 w-4">
                                    <div class="text-left">
                                        <span class="block text-sm font-bold text-gray-800">Publicado (Activo)</span>
                                        <span class="block text-[11px] text-gray-400">Estudiantes pueden postularse.</span>
                                    </div>
                                </div>
                            </label>
                            <label class="flex-1 flex items-center justify-between p-3.5 bg-gray-50 border border-gray-200 rounded-2xl cursor-pointer hover:bg-gray-100/50 transition-all">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="estado" value="borrador" class="text-gray-600 focus:ring-gray-600 h-4 w-4">
                                    <div class="text-left">
                                        <span class="block text-sm font-bold text-gray-800">Borrador</span>
                                        <span class="block text-[11px] text-gray-400">Invisible temporalmente.</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="px-8 py-5 bg-gray-50 border-t border-gray-150 flex gap-3 justify-end">
                <button onclick="closeModal()" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-2xl hover:bg-gray-100 transition-all cursor-pointer">
                    Cancelar
                </button>
                <button onclick="submitForm()" class="px-5 py-2.5 bg-[#6BA53A] hover:bg-[#4E7D24] text-white text-sm font-bold rounded-2xl transition-all shadow-sm cursor-pointer">
                    Guardar Proyecto
                </button>
            </div>
        </div>
    </div>

    <!-- JS Logic for interaction -->
    <script>
        // Modal Handling
        function openModal(mode, projectId = null) {
            const modal = document.getElementById('projectModal');
            const card = document.getElementById('modalCard');
            const titleEl = document.getElementById('modalTitle');
            
            // Set text depending on mode
            if (mode === 'create') {
                titleEl.innerHTML = `
                    <svg class="w-6 h-6 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Registrar Nuevo Proyecto
                `;
                document.getElementById('projectForm').reset();
            } else if (mode === 'edit') {
                titleEl.innerHTML = `
                    <svg class="w-6 h-6 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Editar Detalles de Proyecto
                `;
                
                // Pre-populate with mock data depending on ID
                if (projectId === 1) {
                    document.getElementById('formTitle').value = "Desarrollo de App Móvil de Inventario";
                    document.getElementById('formDescription').value = "Creación y optimización de una aplicación móvil corporativa para el control de stock, inventarios y generación de reportes en tiempo real. Utilizando Flutter y Firebase.";
                    document.getElementById('formTutor').value = "Ing. Carlos Mendoza";
                    document.getElementById('formHorario').value = "08:00 AM - 02:00 PM";
                    document.getElementById('formModalidad').value = "Híbrido";
                    document.getElementById('formCupos').value = 5;
                } else if (projectId === 2) {
                    document.getElementById('formTitle').value = "Migración e Integración Cloud AWS";
                    document.getElementById('formDescription').value = "Proyecto enfocado en la migración de microservicios heredados (On-Premise) hacia una arquitectura serverless en AWS. Creación de pipelines CI/CD y monitoreo con CloudWatch.";
                    document.getElementById('formTutor').value = "Ing. Laura Rodríguez";
                    document.getElementById('formHorario').value = "09:00 AM - 01:00 PM";
                    document.getElementById('formModalidad').value = "Remoto";
                    document.getElementById('formCupos').value = 3;
                } else if (projectId === 3) {
                    document.getElementById('formTitle').value = "Optimización y Seguridad en Base de Datos";
                    document.getElementById('formDescription').value = "Auditoría de seguridad y afinamiento de índices en el motor de base de datos PostgreSQL de la empresa. Creación de vistas materializadas y triggers de control.";
                    document.getElementById('formTutor').value = "M.C. Jorge Alcaraz";
                    document.getElementById('formHorario').value = "10:00 AM - 04:00 PM";
                    document.getElementById('formModalidad').value = "Presencial";
                    document.getElementById('formCupos').value = 2;
                } else if (projectId === 4) {
                    document.getElementById('formTitle').value = "Automatización de Pruebas QA";
                    document.getElementById('formDescription').value = "Implementación de un plan de pruebas automatizado de extremo a extremo (E2E) con Cypress en nuestro portal web comercial y microservicios backend.";
                    document.getElementById('formTutor').value = "Ing. Pedro Ortiz";
                    document.getElementById('formHorario').value = "09:00 AM - 01:00 PM";
                    document.getElementById('formModalidad').value = "Remoto";
                    document.getElementById('formCupos').value = 4;
                }
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Micro-animation trigger
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const modal = document.getElementById('projectModal');
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
                closeModal();
            }
        });

        // Mock functions for actions
        function submitForm() {
            alert('¡Simulación: Proyecto guardado exitosamente!');
            closeModal();
        }

        function confirmDelete(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este proyecto de manera permanente?')) {
                alert('¡Simulación: Proyecto eliminado!');
            }
        }

        function publishProject(id) {
            alert('¡Simulación: Proyecto publicado y ahora es visible para los estudiantes!');
        }

        // Live search and filters simulation
        const searchInput = document.getElementById('projectSearch');
        const selectCarrera = document.getElementById('filterCarrera');
        const selectEstado = document.getElementById('filterEstado');

        function filterProjects() {
            const query = searchInput.value.toLowerCase();
            const carreraFilter = selectCarrera.value;
            const estadoFilter = selectEstado.value;
            const cards = document.querySelectorAll('#projectsGrid > div');

            cards.forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                const description = card.querySelector('p').textContent.toLowerCase();
                const tutor = card.querySelector('.font-bold.text-gray-800').textContent.toLowerCase();
                const status = card.getAttribute('data-status');
                const careers = card.getAttribute('data-carrera');

                const matchesSearch = title.includes(query) || description.includes(query) || tutor.includes(query);
                const matchesCarrera = !carreraFilter || careers.includes(carreraFilter);
                const matchesEstado = !estadoFilter || status === estadoFilter;

                if (matchesSearch && matchesCarrera && matchesEstado) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', filterProjects);
        selectCarrera.addEventListener('change', filterProjects);
        selectEstado.addEventListener('change', filterProjects);
    </script>
@endsection
