@extends('layouts.empresa', ['active' => 'reportes', 'title' => 'Reportes - Unidad Receptora'])

@section('content')
    <!-- Header Section -->
    <div class="mb-6">
        <h1 class="text-3xl font-extrabold text-[#005e20] mb-1">Reportes y Exportación</h1>
        <p class="text-gray-500 font-medium">Genera y exporta reportes detallados en formato PDF o Excel</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Configuración de Reporte -->
        <div class="glass-card rounded-3xl p-8 border-t-4 border-[#6BA53A] relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-40 h-40 bg-[#6BA53A]/5 rounded-full blur-3xl -mr-10 -mt-10 transition-all group-hover:bg-[#6BA53A]/10"></div>
            <div class="relative z-10">
                <h2 class="text-xl font-extrabold text-[#005e20] mb-1">Configuración de Reporte</h2>
                <p class="text-sm text-gray-500 font-medium mb-8">Selecciona el tipo de reporte y periodo</p>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tipo de Reporte</label>
                        <div class="relative">
                            <select class="block w-full px-4 py-3 bg-white/60 border border-gray-200 rounded-xl appearance-none focus:outline-none focus:ring-2 focus:ring-[#6BA53A] focus:border-[#6BA53A] text-sm font-semibold text-gray-900 shadow-inner cursor-pointer transition-colors">
                                <option>Reporte de Estudiantes Activos</option>
                                <option>Reporte de Convenios</option>
                                <option>Reporte de Solicitudes</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Carrera</label>
                        <div class="relative">
                            <select class="block w-full px-4 py-3 bg-white/60 border border-gray-200 rounded-xl appearance-none focus:outline-none focus:ring-2 focus:ring-[#6BA53A] focus:border-[#6BA53A] text-sm font-semibold text-gray-900 shadow-inner cursor-pointer transition-colors">
                                <option>Ingeniería de Software</option>
                                <option>Ingeniería en Sistemas Computacionales</option>
                                <option>Licenciatura en Informática</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Opciones de Exportación -->
        <div class="glass-card rounded-3xl p-8 border-t-4 border-[#005e20] relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-40 h-40 bg-[#005e20]/5 rounded-full blur-3xl -mr-10 -mt-10 transition-all group-hover:bg-[#005e20]/10"></div>
            <div class="relative z-10">
                <h2 class="text-xl font-extrabold text-[#005e20] mb-1">Opciones de Exportación</h2>
                <p class="text-sm text-gray-500 font-medium mb-8">Descarga los reportes en tu formato preferido</p>

                <div class="space-y-4">
                    <!-- PDF Button -->
                    <button class="w-full bg-[#005e20] hover:bg-[#004718] text-white p-4 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center gap-4 text-left group/btn relative overflow-hidden">
                        <div class="absolute inset-0 bg-white/10 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-500"></div>
                        <div class="bg-white/10 p-3 rounded-lg shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 14h6M9 18h6M13 3v5h5"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-base mb-0.5">Exportar a PDF</h3>
                            <p class="text-white/70 text-xs font-medium">Generar un documento PDF formateado</p>
                        </div>
                    </button>

                    <!-- Excel Button -->
                    <button class="w-full bg-[#005e20] hover:bg-[#004718] text-white p-4 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center gap-4 text-left group/btn relative overflow-hidden">
                        <div class="absolute inset-0 bg-white/10 translate-x-[-100%] group-hover/btn:translate-x-[100%] transition-transform duration-500"></div>
                        <div class="bg-white/10 p-3 rounded-lg shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-base mb-0.5">Exportar a Excel</h3>
                            <p class="text-white/70 text-xs font-medium">Generar una hoja de cálculo con los datos</p>
                        </div>
                    </button>
                </div>
            </div>
        </div>

    </div>
@endsection
