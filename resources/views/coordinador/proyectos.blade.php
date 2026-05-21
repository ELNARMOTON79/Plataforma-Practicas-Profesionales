@extends('layouts.coordinador', ['active' => 'proyectos', 'title' => 'Proyectos - Coordinador'])

@section('content')
    <!-- Header Section -->
    <x-page-header title="Listado de Proyectos" description="Catálogo de proyectos disponibles para prácticas">
        <x-slot:actions>
            <button class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Registrar Proyecto
            </button>
        </x-slot>
    </x-page-header>


    <!-- Filters & Search (Buscador Premium) -->
    <div class="glass-card rounded-2xl p-4 mb-6 fade-in-up delay-100">
        <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <label for="search-input" class="sr-only">Buscar proyectos</label>
            <input type="text" id="search-input" aria-label="Buscar proyectos" class="block w-full pl-10 pr-3 py-3.5 border border-gray-200 rounded-xl leading-5 bg-white/50 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-[#6BA53A] focus:ring-2 focus:ring-[#6BA53A]/20 sm:text-sm transition-all shadow-inner" placeholder="Buscar proyectos por nombre, plantel, ciclo o código para filtrar dinámicamente...">
        </div>
    </div>

    <!-- Table Container (Glassmorphic) -->
    <div class="glass-card rounded-3xl p-6 md:p-8 border-t-4 border-[#6BA53A] fade-in-up delay-200 shadow-sm">
        <div class="overflow-x-auto">
            <table id="proyectos-table" class="min-w-full divide-y divide-gray-200/50">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl whitespace-nowrap">Proyecto</th>
                        <th scope="col" class="px-3 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider max-w-[220px] whitespace-normal">Nombre del Proyecto</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider max-w-[180px] whitespace-normal">Plantel / Plan</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Ciclo Escolar</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Alumnos / Cupo</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Activo Internet</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl whitespace-nowrap">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-transparent divide-y divide-gray-100/50">
                    <!-- Row 1 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">
                            425
                        </td>
                        <td class="px-3 py-4 text-left max-w-[220px] whitespace-normal">
                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors uppercase leading-tight break-words">PLATAFORMA WEB PARA ADMINISTRACIÓN DE PRÁCTICAS</div>
                        </td>
                        <td class="px-3 py-4 text-center max-w-[180px] whitespace-normal">
                            <div class="text-xs text-gray-600 font-bold leading-tight break-words uppercase">FACULTAD DE INGENIERIA ELECTROMECANICA / E906</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs text-gray-500 font-bold tracking-wide">
                            AGO-2026/ENE-2027
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <span class="px-3 py-1 inline-flex text-[11px] leading-5 font-bold rounded-lg bg-sky-50 text-sky-700 border border-sky-200 shadow-sm">1 / 1</span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <!-- Toggle switch -->
                            <div class="relative inline-block w-10 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" name="toggle" id="toggle425" aria-label="Activar acceso a internet - Proyecto 425" class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 appearance-none cursor-pointer border-gray-300" checked/>
                                <label for="toggle425" class="toggle-label block overflow-hidden h-5 rounded-full bg-gray-300 cursor-pointer"><span class="sr-only">Activo</span></label>
                            </div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex justify-center gap-3">
                                <button class="text-[#6BA53A] hover:text-[#4E7D24] hover:scale-110 transition-transform animate-hover" title="Editar proyecto 425" aria-label="Editar proyecto 425">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button class="text-[#38bdf8] hover:text-[#0284c7] hover:scale-110 transition-transform animate-hover" title="Ver detalles del proyecto 425" aria-label="Ver detalles del proyecto 425">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Row 2 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">
                            426
                        </td>
                        <td class="px-3 py-4 text-left max-w-[220px] whitespace-normal">
                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors uppercase leading-tight break-words">DESARROLLO DE MÓDULO DE SEGUIMIENTO DE EGRESADOS</div>
                        </td>
                        <td class="px-3 py-4 text-center max-w-[180px] whitespace-normal">
                            <div class="text-xs text-gray-600 font-bold leading-tight break-words uppercase">FACULTAD DE INGENIERIA ELECTROMECANICA / E906</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs text-gray-500 font-bold tracking-wide">
                            AGO-2026/ENE-2027
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <span class="px-3 py-1 inline-flex text-[11px] leading-5 font-bold rounded-lg bg-sky-50 text-sky-700 border border-sky-200 shadow-sm">2 / 2</span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <!-- Toggle switch -->
                            <div class="relative inline-block w-10 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" name="toggle" id="toggle426" aria-label="Activar acceso a internet - Proyecto 426" class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 appearance-none cursor-pointer border-gray-300" checked/>
                                <label for="toggle426" class="toggle-label block overflow-hidden h-5 rounded-full bg-gray-300 cursor-pointer"><span class="sr-only">Activo</span></label>
                            </div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex justify-center gap-3">
                                <button class="text-[#6BA53A] hover:text-[#4E7D24] hover:scale-110 transition-transform animate-hover" title="Editar proyecto 426" aria-label="Editar proyecto 426">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button class="text-[#38bdf8] hover:text-[#0284c7] hover:scale-110 transition-transform animate-hover" title="Ver detalles del proyecto 426" aria-label="Ver detalles del proyecto 426">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Row 3 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">
                            427
                        </td>
                        <td class="px-3 py-4 text-left max-w-[220px] whitespace-normal">
                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors uppercase leading-tight break-words">IMPLEMENTACIÓN DE REDES E INFRAESTRUCTURA DE TELECOMUNICACIONES</div>
                        </td>
                        <td class="px-3 py-4 text-center max-w-[180px] whitespace-normal">
                            <div class="text-xs text-gray-600 font-bold leading-tight break-words uppercase">FACULTAD DE INGENIERIA ELECTROMECANICA / E907</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs text-gray-500 font-bold tracking-wide">
                            AGO-2026/ENE-2027
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <span class="px-3 py-1 inline-flex text-[11px] leading-5 font-bold rounded-lg bg-gray-100 text-gray-600 border border-gray-300 shadow-sm">0 / 3</span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <!-- Toggle switch -->
                            <div class="relative inline-block w-10 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" name="toggle" id="toggle427" aria-label="Activar acceso a internet - Proyecto 427" class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 appearance-none cursor-pointer border-gray-300"/>
                                <label for="toggle427" class="toggle-label block overflow-hidden h-5 rounded-full bg-gray-300 cursor-pointer"><span class="sr-only">Inactivo</span></label>
                            </div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex justify-center gap-3">
                                <button class="text-[#6BA53A] hover:text-[#4E7D24] hover:scale-110 transition-transform animate-hover" title="Editar proyecto 427" aria-label="Editar proyecto 427">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button class="text-[#38bdf8] hover:text-[#0284c7] hover:scale-110 transition-transform animate-hover" title="Ver detalles del proyecto 427" aria-label="Ver detalles del proyecto 427">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 4 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">
                            428
                        </td>
                        <td class="px-3 py-4 text-left max-w-[220px] whitespace-normal">
                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors uppercase leading-tight break-words">ANÁLISIS Y OPTIMIZACIÓN DE EFICIENCIA ENERGÉTICA EN EDIFICIOS</div>
                        </td>
                        <td class="px-3 py-4 text-center max-w-[180px] whitespace-normal">
                            <div class="text-xs text-gray-600 font-bold leading-tight break-words uppercase">FACULTAD DE INGENIERIA ELECTROMECANICA / E908</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs text-gray-500 font-bold tracking-wide">
                            AGO-2026/ENE-2027
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <span class="px-3 py-1 inline-flex text-[11px] leading-5 font-bold rounded-lg bg-amber-50 text-amber-700 border border-amber-200 shadow-sm">1 / 2</span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <!-- Toggle switch -->
                            <div class="relative inline-block w-10 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" name="toggle" id="toggle428" aria-label="Activar acceso a internet - Proyecto 428" class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 appearance-none cursor-pointer border-gray-300" checked/>
                                <label for="toggle428" class="toggle-label block overflow-hidden h-5 rounded-full bg-gray-300 cursor-pointer"><span class="sr-only">Activo</span></label>
                            </div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex justify-center gap-3">
                                <button class="text-[#6BA53A] hover:text-[#4E7D24] hover:scale-110 transition-transform animate-hover" title="Editar proyecto 428" aria-label="Editar proyecto 428">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button class="text-[#38bdf8] hover:text-[#0284c7] hover:scale-110 transition-transform animate-hover" title="Ver detalles del proyecto 428" aria-label="Ver detalles del proyecto 428">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 5 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">
                            429
                        </td>
                        <td class="px-3 py-4 text-left max-w-[220px] whitespace-normal">
                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors uppercase leading-tight break-words">SISTEMA DE MONITOREO CLIMÁTICO Y CONTROLES AUTOMATIZADOS CON IOT</div>
                        </td>
                        <td class="px-3 py-4 text-center max-w-[180px] whitespace-normal">
                            <div class="text-xs text-gray-600 font-bold leading-tight break-words uppercase">FACULTAD DE INGENIERIA ELECTROMECANICA / E906</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs text-gray-500 font-bold tracking-wide">
                            AGO-2026/ENE-2027
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <span class="px-3 py-1 inline-flex text-[11px] leading-5 font-bold rounded-lg bg-sky-50 text-sky-700 border border-sky-200 shadow-sm">1 / 1</span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <!-- Toggle switch -->
                            <div class="relative inline-block w-10 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" name="toggle" id="toggle429" aria-label="Activar acceso a internet - Proyecto 429" class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 appearance-none cursor-pointer border-gray-300"/>
                                <label for="toggle429" class="toggle-label block overflow-hidden h-5 rounded-full bg-gray-300 cursor-pointer"><span class="sr-only">Inactivo</span></label>
                            </div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex justify-center gap-3">
                                <button class="text-[#6BA53A] hover:text-[#4E7D24] hover:scale-110 transition-transform animate-hover" title="Editar proyecto 429" aria-label="Editar proyecto 429">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button class="text-[#38bdf8] hover:text-[#0284c7] hover:scale-110 transition-transform animate-hover" title="Ver detalles del proyecto 429" aria-label="Ver detalles del proyecto 429">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 6 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">
                            430
                        </td>
                        <td class="px-3 py-4 text-left max-w-[220px] whitespace-normal">
                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors uppercase leading-tight break-words">SISTEMA INTEGRAL DE CONTROL DE INVENTARIOS POR CÓDIGO QR</div>
                        </td>
                        <td class="px-3 py-4 text-center max-w-[180px] whitespace-normal">
                            <div class="text-xs text-gray-600 font-bold leading-tight break-words uppercase">FACULTAD DE INGENIERIA ELECTROMECANICA / E906</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs text-gray-500 font-bold tracking-wide">
                            AGO-2026/ENE-2027
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <span class="px-3 py-1 inline-flex text-[11px] leading-5 font-bold rounded-lg bg-amber-50 text-amber-700 border border-amber-200 shadow-sm">2 / 3</span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <!-- Toggle switch -->
                            <div class="relative inline-block w-10 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" name="toggle" id="toggle430" aria-label="Activar acceso a internet - Proyecto 430" class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 appearance-none cursor-pointer border-gray-300" checked/>
                                <label for="toggle430" class="toggle-label block overflow-hidden h-5 rounded-full bg-gray-300 cursor-pointer"><span class="sr-only">Activo</span></label>
                            </div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex justify-center gap-3">
                                <button class="text-[#6BA53A] hover:text-[#4E7D24] hover:scale-110 transition-transform animate-hover" title="Editar proyecto 430" aria-label="Editar proyecto 430">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button class="text-[#38bdf8] hover:text-[#0284c7] hover:scale-110 transition-transform animate-hover" title="Ver detalles del proyecto 430" aria-label="Ver detalles del proyecto 430">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts de DataTables e Inicialización Dinámica -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inicializar DataTable de Proyectos
            let table = $('#proyectos-table').DataTable({
                searching: true,     // Habilitar búsqueda
                lengthChange: false,  // Ocultar longitud nativa
                pageLength: 5,       // Limitar a 5 registros por página por defecto
                ordering: true,      // Habilitar ordenación
                info: false,         // Ocultar info nativa
                dom: 'rtp',          // Mostrar solo la tabla y la paginación
                columnDefs: [
                    { orderable: false, targets: [5, 6] } // Deshabilitar ordenación en las columnas Toggle (5) y Acciones (6)
                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                }
            });

            // Conectar el buscador personalizado al DataTable de Proyectos
            $('#search-input').on('keyup', function() {
                table.search(this.value).draw();
            });
        });
    </script>
@endsection
