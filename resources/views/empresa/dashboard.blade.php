@extends('layouts.empresa', ['title' => 'Dashboard Empresa - Prácticas Profesionales UdeC', 'active' => 'dashboard'])

@section('content')
    <!-- Welcome Header -->
    <x-page-header title="Panel de Empresa" description="Gestión de proyectos, solicitudes y seguimiento de practicantes."></x-page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:items-stretch">
        <!-- Left Column: Metrics & Tracking (60%) -->
        <div class="lg:col-span-2 flex flex-col gap-8 h-full min-h-0">
            
            <!-- Metrics Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 fade-in-up delay-100">
                <!-- Proyectos Disponibles -->
                <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group border-transparent hover:border-[#6BA53A]/30 transition-colors">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg class="w-16 h-16 text-[#4E7D24]" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-gray-500 mb-2">Proyectos Disponibles</span>
                    <div class="flex items-end gap-3 mb-2">
                        <span class="text-4xl font-extrabold text-gray-900">5</span>
                    </div>
                    <span class="text-xs text-gray-400 font-medium">Proyectos registrados para prácticas</span>
                </div>

                <!-- Solicitudes Pendientes -->
                <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group border-transparent hover:border-yellow-300 transition-colors">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg class="w-16 h-16 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-gray-500 mb-2">Solicitudes Pendientes</span>
                    <div class="flex items-end gap-3 mb-2">
                        <span class="text-4xl font-extrabold text-gray-900">12</span>
                        <span class="flex items-center text-sm font-semibold text-yellow-600 bg-yellow-50 px-2 py-0.5 rounded-md mb-1">
                            Nuevas
                        </span>
                    </div>
                    <span class="text-xs text-gray-400 font-medium">Pendientes de revisión y respuesta</span>
                </div>

                <!-- Estudiantes Asignados -->
                <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group border-transparent hover:border-blue-300 transition-colors">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg class="w-16 h-16 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-gray-500 mb-2">Estudiantes Asignados</span>
                    <div class="flex items-end gap-3 mb-2">
                        <span class="text-4xl font-extrabold text-gray-900">8</span>
                    </div>
                    <span class="text-xs text-gray-400 font-medium">En seguimiento de actividades</span>
                </div>

                <!-- Convenio Status -->
                <div class="glass-card rounded-3xl p-6 flex flex-col relative overflow-hidden group border-green-100 hover:border-green-300 transition-colors">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg class="w-16 h-16 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-gray-500 mb-2">Estado del Convenio</span>
                    <div class="flex items-end gap-3 mb-2">
                        <span class="text-3xl font-extrabold text-green-600">Vigente</span>
                    </div>
                    <span class="text-xs text-green-500 font-medium">Expira el 24/Nov/2026</span>
                </div>
            </div>

            <!-- Estudiantes en Seguimiento -->
            <div class="glass-card rounded-3xl p-8 fade-in-up delay-200 flex-1 flex flex-col min-h-0">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-6 h-6 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Seguimiento de Practicantes
                    </h2>
                    <div class="flex gap-3">
                        <a href="{{ route('empresa.reportes') }}" class="text-sm font-bold text-gray-500 hover:text-gray-900 bg-white px-3 py-1.5 rounded-lg border border-gray-200 transition-colors">Generar Reporte</a>
                        <a href="{{ route('empresa.proyectos') }}" class="text-sm font-bold text-[#6BA53A] hover:text-[#4E7D24] transition-colors bg-[#6BA53A]/10 px-3 py-1.5 rounded-lg">Ver proyectos</a>
                    </div>
                </div>
                
                <div class="overflow-hidden bg-white/60 rounded-2xl border border-gray-100 flex-1">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Estudiante</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Proyecto Asignado</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Progreso</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="bg-transparent divide-y divide-gray-200">
                            <tr class="hover:bg-[#6BA53A]/5 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">MR</div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900">María Rodríguez</div>
                                            <div class="text-sm text-gray-500">Ing. en Software</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    App de Inventario
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-1">
                                      <div class="bg-blue-600 h-2.5 rounded-full" style="width: 45%"></div>
                                    </div>
                                    <span class="text-xs text-gray-500 font-medium">45% (A tiempo)</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="#" class="text-gray-400 hover:text-[#4E7D24] transition-colors" title="Ver detalles"><svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></a>
                                </td>
                            </tr>
                            <tr class="hover:bg-[#6BA53A]/5 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-[#4E7D24]/20 flex items-center justify-center text-[#4E7D24] font-bold">JL</div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900">Juan López</div>
                                            <div class="text-sm text-gray-500">Lic. en Informática</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    Migración a la Nube
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-1">
                                      <div class="bg-green-600 h-2.5 rounded-full" style="width: 90%"></div>
                                    </div>
                                    <span class="text-xs text-gray-500 font-medium">90% (Por concluir)</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="#" class="text-gray-400 hover:text-[#4E7D24] transition-colors" title="Ver detalles"><svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Right Column: Panel Convenio & Solicitudes (40%) -->
        <div class="flex flex-col gap-8 h-full min-h-0 fade-in-up delay-300">
            
            <!-- Convenio Action Panel -->
            <div class="glass-card rounded-3xl p-6 bg-gradient-to-br from-white to-[#6BA53A]/5 border border-[#6BA53A]/20 relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-32 h-32 bg-[#4E7D24] rounded-full mix-blend-multiply filter blur-2xl opacity-10 group-hover:opacity-20 transition-opacity"></div>
                
                <h3 class="text-lg font-bold text-gray-900 mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Gestión de Convenio
                </h3>
                <p class="text-sm text-gray-600 mb-4">Tu convenio actual está <span class="font-bold text-green-600">Vigente</span>. Podrás solicitar la renovación 30 días antes de su vencimiento.</p>
                <div class="flex gap-2 relative z-10">
                    <a href="{{ route('empresa.convenios') }}" class="flex-1 bg-white border border-[#4E7D24] text-[#4E7D24] text-center px-4 py-2 rounded-xl text-sm font-bold hover:bg-[#4E7D24] hover:text-white transition-colors">Ver Detalles</a>
                    <button disabled class="flex-1 bg-gray-100 text-gray-400 text-center px-4 py-2 rounded-xl text-sm font-bold cursor-not-allowed" title="Opción disponible 30 días antes del vencimiento">Renovar</button>
                </div>
            </div>

            <!-- Recent Requests List -->
            <div class="glass-card rounded-3xl p-6 flex-1 flex flex-col">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Solicitudes Recientes
                    </h3>
                    <a href="{{ route('empresa.solicitudes') }}" class="text-sm text-[#6BA53A] font-bold hover:text-[#4E7D24] transition-colors">Ver todas</a>
                </div>

                <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar space-y-4">
                    <!-- Solicitud Item 1 -->
                    <div class="bg-white/50 border border-gray-100 rounded-2xl p-4 hover:shadow-sm transition-shadow">
                        <div class="flex justify-between items-start mb-2">
                            <div class="font-bold text-gray-900 text-sm">Pedro Gómez</div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-yellow-600 bg-yellow-50 px-2 py-1 rounded-md">Nueva</span>
                        </div>
                        <div class="text-xs text-gray-500 mb-3">Lic. en Administración <br> <span class="font-medium text-gray-700">Para: Proyecto Optimización</span></div>
                        <div class="flex gap-2">
                            <button class="flex-1 bg-[#4E7D24] text-white text-xs font-bold py-1.5 rounded-lg hover:bg-[#3A5D1B] transition-colors shadow-sm">Aceptar</button>
                            <button class="flex-1 bg-white border border-gray-200 text-gray-600 text-xs font-bold py-1.5 rounded-lg hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-colors shadow-sm">Rechazar</button>
                        </div>
                    </div>

                    <!-- Solicitud Item 2 -->
                    <div class="bg-white/50 border border-gray-100 rounded-2xl p-4 hover:shadow-sm transition-shadow">
                        <div class="flex justify-between items-start mb-2">
                            <div class="font-bold text-gray-900 text-sm">Ana Silva</div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-2 py-1 rounded-md">Revisión</span>
                        </div>
                        <div class="text-xs text-gray-500 mb-3">Ing. en Sistemas <br> <span class="font-medium text-gray-700">Para: Migración a la Nube</span></div>
                        <div class="flex gap-2">
                            <button class="w-full bg-white border border-gray-200 text-gray-600 text-xs font-bold py-1.5 rounded-lg hover:bg-gray-50 transition-colors shadow-sm">Añadir Observación</button>
                        </div>
                    </div>
                    
                    <!-- Solicitud Item 3 -->
                    <div class="bg-white/50 border border-gray-100 rounded-2xl p-4 hover:shadow-sm transition-shadow">
                        <div class="flex justify-between items-start mb-2">
                            <div class="font-bold text-gray-900 text-sm">Luis Fernando</div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-yellow-600 bg-yellow-50 px-2 py-1 rounded-md">Nueva</span>
                        </div>
                        <div class="text-xs text-gray-500 mb-3">Lic. en Informática <br> <span class="font-medium text-gray-700">Para: App de Inventario</span></div>
                        <div class="flex gap-2">
                            <button class="flex-1 bg-[#4E7D24] text-white text-xs font-bold py-1.5 rounded-lg hover:bg-[#3A5D1B] transition-colors shadow-sm">Aceptar</button>
                            <button class="flex-1 bg-white border border-gray-200 text-gray-600 text-xs font-bold py-1.5 rounded-lg hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-colors shadow-sm">Rechazar</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection