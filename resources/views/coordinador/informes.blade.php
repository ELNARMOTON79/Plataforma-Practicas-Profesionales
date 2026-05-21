@extends('layouts.coordinador', ['active' => 'informes', 'title' => 'Informes - Coordinador'])

@section('content')
    <!-- Header Section -->
    <x-page-header title="Reportes y Exportación" description="Genera y exporta reportes detallados en formato PDF o Excel." />


    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Panel 1: Configuración -->
        <div class="glass-card rounded-3xl p-8 border-t-4 border-[#6BA53A] shadow-sm hover:shadow-md transition-shadow">
            <div class="mb-6">
                <h2 class="text-xl font-extrabold text-gray-800 flex items-center gap-2">
                    <div class="bg-[#6BA53A]/10 p-2 rounded-lg">
                        <svg class="w-6 h-6 text-[#6BA53A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    Configuración de Reporte
                </h2>
                <p class="text-sm text-gray-500 mt-1">Selecciona el tipo de reporte y los filtros que deseas aplicar.</p>
            </div>

            <form class="space-y-5">
                <!-- Tipo de Reporte -->
                <div>
                    <label for="tipo-reporte" class="block text-sm font-bold text-gray-700 mb-2">Tipo de Reporte</label>
                    <div class="relative">
                        <select id="tipo-reporte" name="tipo_reporte" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white/60 focus:ring-2 focus:ring-[#6BA53A] focus:border-[#6BA53A] outline-none transition-all text-sm font-medium text-gray-800 shadow-inner appearance-none cursor-pointer">
                            <option>Reporte de Estudiantes Activos</option>
                            <option>Reporte de Instituciones</option>
                            <option>Reporte de Proyectos</option>
                        </select>
                    </div>
                </div>

                <!-- Carrera -->
                <div>
                    <label for="filtro-carrera" class="block text-sm font-bold text-gray-700 mb-2">Carrera</label>
                    <div class="relative">
                        <select id="filtro-carrera" name="carrera" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white/60 focus:ring-2 focus:ring-[#6BA53A] focus:border-[#6BA53A] outline-none transition-all text-sm font-medium text-gray-800 shadow-inner appearance-none cursor-pointer">
                            <option value="">Todas las carreras</option>
                            <option>Ingeniería de Software</option>
                            <option>Ingeniería en Computación</option>
                            <option>Ingeniería Electromecánica</option>
                        </select>
                    </div>
                </div>

                <!-- Género -->
                <div>
                    <label for="filtro-genero" class="block text-sm font-bold text-gray-700 mb-2">Género</label>
                    <div class="relative">
                        <select id="filtro-genero" name="genero" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white/60 focus:ring-2 focus:ring-[#6BA53A] focus:border-[#6BA53A] outline-none transition-all text-sm font-medium text-gray-800 shadow-inner appearance-none cursor-pointer">
                            <option value="">Todos los géneros</option>
                            <option>Femenino</option>
                            <option>Masculino</option>
                            <option>Otro</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <!-- Panel 2: Exportación -->
        <div class="glass-card rounded-3xl p-8 border-t-4 border-[#4E7D24] shadow-sm hover:shadow-md transition-shadow flex flex-col">
            <div class="mb-8">
                <h2 class="text-xl font-extrabold text-gray-800 flex items-center gap-2">
                    <div class="bg-[#4E7D24]/10 p-2 rounded-lg">
                        <svg class="w-6 h-6 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    </div>
                    Opciones de Exportación
                </h2>
                <p class="text-sm text-gray-500 mt-1">Descarga los reportes en tu formato preferido con los filtros aplicados.</p>
            </div>

            <div class="space-y-4 flex-grow flex flex-col justify-center">
                <!-- PDF Export -->
                <button class="w-full group bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white p-4 rounded-2xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 flex items-center gap-4" aria-label="Exportar reporte a PDF">
                    <div class="bg-white/20 p-3 rounded-xl group-hover:scale-110 transition-transform shadow-inner">
                        <svg class="w-8 h-8 text-white" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="text-left">
                        <h3 class="font-extrabold text-lg tracking-wide uppercase">Exportar a PDF</h3>
                        <p class="text-blue-100 text-sm font-medium mt-0.5">Generar un documento PDF formateado para imprimir</p>
                    </div>
                </button>

                <!-- Excel Export -->
                <button class="w-full group bg-gradient-to-r from-[#2E5417] to-[#4E7D24] hover:from-[#1f380f] hover:to-[#2E5417] text-white p-4 rounded-2xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 flex items-center gap-4" aria-label="Exportar reporte a Excel">
                    <div class="bg-white/20 p-3 rounded-xl group-hover:scale-110 transition-transform shadow-inner">
                        <svg class="w-8 h-8 text-white" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div class="text-left">
                        <h3 class="font-extrabold text-lg tracking-wide uppercase">Exportar a Excel</h3>
                        <p class="text-green-100 text-sm font-medium mt-0.5">Generar una hoja de cálculo (.xlsx) con los datos completos</p>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <style>
        /* Flecha personalizada para los select */
        select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 1rem center;
            background-repeat: no-repeat;
            background-size: 1.2em 1.2em;
            padding-right: 2.5rem;
        }
    </style>
@endsection
