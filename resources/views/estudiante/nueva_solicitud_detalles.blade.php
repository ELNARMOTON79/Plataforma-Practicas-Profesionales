@extends('layouts.estudiante', ['active' => 'nueva-solicitud'])

@section('header')
<header class="bg-white border-b border-gray-200 px-6 py-5 flex items-center justify-between shrink-0">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Bienvenido, {{ $nombre }}</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ $carrera }} — Matrícula: {{ $matricula }}</p>
    </div>
    <div class="flex items-center gap-4">
        <a href="{{ route('estudiante.notificaciones') }}" class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-50 transition-colors" title="Notificaciones" aria-label="Notificaciones">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
        </a>
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
<div class="space-y-6 max-w-6xl mx-auto">
    <div class="bg-white rounded-[32px] shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-8 py-8">
            <div class="max-w-4xl mx-auto">
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-gray-900">Nueva Solicitud de Prácticas</h2>
                    <p class="text-sm text-gray-500 mt-2">Completa el formulario para registrar tu solicitud</p>
                </div>

                <div class="mt-10 grid grid-cols-1 lg:grid-cols-[1fr_auto_1fr_auto_1fr] items-center gap-4">
                    <div class="rounded-3xl border border-gray-200 p-5 text-center bg-[#e8f7e9]">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#def1d8] text-[#4E7D24] mb-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-[#4E7D24]">Información de la Empresa</p>
                    </div>

                    <div class="h-1 w-full bg-[#4E7D24] hidden lg:block"></div>

                    <div class="rounded-3xl border border-[#4E7D24] p-5 text-center bg-[#f2fbf2]">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-white text-[#4E7D24] border border-[#4E7D24] mb-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10v10H7z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7l5-5 5 5"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-[#4E7D24]">Detalles de la Práctica</p>
                    </div>

                    <div class="h-1 w-full bg-gray-200 hidden lg:block"></div>

                    <div class="rounded-3xl border border-gray-200 p-5 text-center bg-white">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-500 mb-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15.5V19a2 2 0 002 2h12a2 2 0 002-2v-3.5"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 10l5-5 5 5"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v10"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-500">Documentación</p>
                    </div>
                </div>

                <form action="{{ route('estudiante.nuevaSolicitudDocumentacion') }}" method="GET" class="mt-10 space-y-6">
                    <div class="grid gap-4 lg:grid-cols-2">
                        <div class="space-y-3">
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Fecha de Inicio <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="fecha_inicio" placeholder="dd/mm/aaaa" class="w-full rounded-2xl border border-gray-200 bg-white py-3 px-4 text-sm text-gray-700 shadow-sm focus:border-[#4E7D24] focus:outline-none focus:ring-2 focus:ring-[#4E7D24]/20" />
                        </div>
                        <div class="space-y-3">
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Fecha de Finalización
                            </label>
                            <input type="text" name="fecha_fin" placeholder="dd/mm/aaaa" class="w-full rounded-2xl border border-gray-200 bg-white py-3 px-4 text-sm text-gray-700 shadow-sm focus:border-[#4E7D24] focus:outline-none focus:ring-2 focus:ring-[#4E7D24]/20" />
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h10"/>
                            </svg>
                            Horas Previstas <span class="text-red-500">*</span>
                        </label>
                        <select class="w-full rounded-2xl border border-gray-200 bg-white py-3 px-4 text-sm text-gray-700 shadow-sm focus:border-[#4E7D24] focus:outline-none focus:ring-2 focus:ring-[#4E7D24]/20">
                            <option>Selecciona las horas</option>
                            <option>80 horas</option>
                            <option>160 horas</option>
                            <option>240 horas</option>
                        </select>
                    </div>

                    <div class="space-y-3">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h8m-8 4h6"/>
                            </svg>
                            Descripción de Actividades <span class="text-red-500">*</span>
                        </label>
                        <textarea rows="4" placeholder="Describe las actividades que realizarás durante las prácticas..." class="w-full rounded-3xl border border-gray-200 bg-white py-3 px-4 text-sm text-gray-700 shadow-sm focus:border-[#4E7D24] focus:outline-none focus:ring-2 focus:ring-[#4E7D24]/20"></textarea>
                    </div>

                    <div class="space-y-3">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h8m-8 4h6"/>
                            </svg>
                            Objetivos de la Práctica
                        </label>
                        <textarea rows="4" placeholder="Qué esperas lograr con esta práctica profesional?" class="w-full rounded-3xl border border-gray-200 bg-white py-3 px-4 text-sm text-gray-700 shadow-sm focus:border-[#4E7D24] focus:outline-none focus:ring-2 focus:ring-[#4E7D24]/20"></textarea>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:justify-between">
                        <a href="{{ route('estudiante.nuevaSolicitud') }}" class="inline-flex items-center justify-center rounded-full border border-[#d3e8d0] bg-[#f5fbf5] px-6 py-3 text-sm font-semibold text-[#4E7D24] shadow-sm transition hover:bg-[#e9f7e9]">
                            &lt; Anterior
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center rounded-full bg-[#4E7D24] px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#3b6620] focus:outline-none focus:ring-2 focus:ring-[#4E7D24]/50">
                            Siguiente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
