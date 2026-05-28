@extends('layouts.estudiante', ['active' => 'nueva-solicitud'])

@section('header')
<header class="bg-white border-b border-gray-200 px-6 py-5 flex items-center justify-between shrink-0">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Bienvenido, {{ $nombre }}</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ $carrera }} — Matrícula: {{ $matricula }}</p>
    </div>
    <div class="flex items-center gap-4">
        <a href="{{ route('estudiante.miPerfil') }}" class="flex items-center gap-2.5 pl-2 border-l border-gray-200 text-gray-900 hover:text-gray-700 transition-colors">
            <div class="w-9 h-9 rounded-full bg-[#4E7D24] flex items-center justify-center text-white text-sm font-bold shrink-0">
                {{ $iniciales }}
            </div>
            <span class="text-sm font-semibold text-gray-800 hidden sm:block">{{ $nombre }}</span>
        </a>
    </div>
</header>
@endsection

@section('content')
<div class="w-full space-y-6">
    <!-- Header / Titles -->
    <div class="text-left px-2">
        <h1 class="text-3xl font-extrabold text-gray-900">Nueva Solicitud de Practicas</h1>
        <p class="text-sm text-gray-500 mt-1">Completa el formulario para registrar tu solicitud</p>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-[32px] shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-8 sm:px-16 md:px-20 py-12">
            <div class="max-w-7xl mx-auto">
                <!-- Circular Step Progress Indicator -->
                <div class="relative flex items-center justify-between w-full max-w-5xl mx-auto mt-4 mb-16">
                    <!-- Line segment background -->
                    <div class="absolute left-[16.67%] right-[16.67%] top-7 h-[2px] bg-gray-200 z-0"></div>
                    
                    <!-- Line segment active (Paso 1 to Paso 2 is active, so progress line is 50% active) -->
                    <div class="absolute left-[16.67%] top-7 h-[2px] bg-[#8cc772] z-0 transition-all duration-300" style="width: 50%;"></div>

                    <!-- Step 1 (Completed) -->
                    <div class="relative z-10 flex flex-col items-center w-1/3">
                        <div class="flex items-center justify-center w-14 h-14 rounded-full border-2 border-[#8cc772] bg-white text-[#4E7D24] shadow-sm transition-all duration-200">
                            <!-- Ícono de Checkmark -->
                            <svg class="w-6 h-6 text-[#6BA53A]" fill="none" stroke="currentColor" stroke-width="3.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="mt-4 text-xs sm:text-sm font-bold text-[#6BA53A] text-center max-w-[150px] leading-tight">Informacion de la Empresa</span>
                    </div>

                    <!-- Step 2 (Active) -->
                    <div class="relative z-10 flex flex-col items-center w-1/3">
                        <div class="flex items-center justify-center w-14 h-14 rounded-full border-2 border-[#8cc772] bg-white text-[#4E7D24] shadow-sm transition-all duration-200">
                            <!-- Ícono de Detalles (Documento) -->
                            <svg class="w-6 h-6 text-[#6BA53A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span class="mt-4 text-xs sm:text-sm font-bold text-[#6BA53A] text-center max-w-[150px] leading-tight">Detalles de la Practica</span>
                    </div>

                    <!-- Step 3 (Inactive) -->
                    <div class="relative z-10 flex flex-col items-center w-1/3">
                        <div class="flex items-center justify-center w-14 h-14 rounded-full border border-gray-300 bg-white text-gray-400 transition-all duration-200">
                            <!-- Ícono de Documentación (Subir) -->
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                        </div>
                        <span class="mt-4 text-xs sm:text-sm font-semibold text-gray-400 text-center max-w-[150px] leading-tight">Documentacion</span>
                    </div>
                </div>

                <form action="{{ route('estudiante.nuevaSolicitudDocumentacion') }}" method="GET" class="mt-10 space-y-6">
                    <div class="grid gap-5">
                        <!-- Fecha de Inicio & Fecha de Finalización -->
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Fecha de Inicio <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="fecha_inicio" placeholder="dd/mm/aaaa" class="w-full rounded-xl border border-gray-200 bg-white py-3 px-4 text-sm text-gray-700 shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all" />
                            </div>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Fecha de Finalización
                                </label>
                                <input type="text" name="fecha_fin" placeholder="dd/mm/aaaa" class="w-full rounded-xl border border-gray-200 bg-white py-3 px-4 text-sm text-gray-700 shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all" />
                            </div>
                        </div>

                        <!-- Horas Previstas -->
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Horas Previstas <span class="text-red-500">*</span>
                            </label>
                            <select class="w-full rounded-xl border border-gray-200 bg-white py-3 px-4 text-sm text-gray-700 shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all">
                                <option>Selecciona las horas</option>
                                <option>80 horas</option>
                                <option>160 horas</option>
                                <option>240 horas</option>
                            </select>
                        </div>

                        <!-- Descripción de Actividades -->
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10"/>
                                </svg>
                                Descripción de Actividades <span class="text-red-500">*</span>
                            </label>
                            <textarea rows="4" placeholder="Describe las actividades que realizarás durante las prácticas..." class="w-full rounded-xl border border-gray-200 bg-white py-3 px-4 text-sm text-gray-700 shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all"></textarea>
                        </div>

                        <!-- Objetivos de la Práctica -->
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Objetivos de la Práctica
                            </label>
                            <textarea rows="4" placeholder="¿Qué esperas lograr con esta práctica profesional?" class="w-full rounded-xl border border-gray-200 bg-white py-3 px-4 text-sm text-gray-700 shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all"></textarea>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between items-center pt-4">
                        <a href="{{ route('estudiante.nuevaSolicitud') }}" class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-6 py-2.5 text-sm font-semibold text-gray-600 shadow-sm transition hover:bg-gray-50">
                            <span class="mr-2 font-bold">&lt;</span> Anterior
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#a2d98a] hover:bg-[#8cc772] px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-250">
                            Siguiente <span class="ml-2 font-bold">&gt;</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
