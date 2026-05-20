@extends('layouts.estudiante', ['active' => 'reportes'])

@section('header')
<header class="bg-white border-b border-gray-200 px-6 py-5 flex items-center justify-between shrink-0">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Bienvenido, {{ $nombre }}</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ $carrera }} - Matrícula: {{ $matricula }}</p>
    </div>
    <div class="flex items-center gap-4">
        <a href="{{ route('estudiante.notificaciones') }}" class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-50 transition-colors" title="Notificaciones" aria-label="Notificaciones">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
        </a>
            <div class="relative">
                <button type="button" onclick="toggleProfileMenu()" class="flex items-center gap-2.5 pl-2 border-l border-gray-200 text-gray-900 hover:text-gray-700 transition-colors rounded-md hover:bg-gray-100 hover:shadow-sm" aria-haspopup="true" aria-expanded="false">
                    <div class="w-9 h-9 rounded-full bg-[#4E7D24] flex items-center justify-center text-white text-sm font-bold shrink-0">
                        {{ $iniciales }}
                    </div>
                    <span class="text-sm font-semibold text-gray-800 hidden sm:block">{{ $nombre }}</span>
                </button>

                <div id="profile-menu" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-100 z-50">
                    <div class="p-4 border-b">
                        <p class="text-sm font-semibold text-gray-900">{{ $nombre }}</p>
                        <p class="text-xs text-gray-500">{{ $carrera }}</p>
                    </div>
                    <a href="{{ route('estudiante.miPerfil') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">Mi Perfil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-gray-50">Cerrar Sesión</button>
                    </form>
                </div>
            </div>
    </div>
</header>
@endsection

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
    <div class="rounded-[32px] bg-white border border-gray-200 p-8 shadow-sm">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Reportes</h2>
                <p class="mt-2 text-sm text-gray-500">Genera y descarga reportes de tus prácticas profesionales.</p>
            </div>
        </div>

        <div class="mt-8 grid gap-4 lg:grid-cols-2">
            <article class="rounded-[28px] border border-gray-200 bg-[#f8fafb] p-6 shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-3xl bg-[#eff6ff] text-[#1d4ed8]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6M9 7h6"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Reporte de Horas</p>
                        <p class="mt-2 text-sm text-gray-600">Detalle completo de horas registradas, aprobadas y pendientes.</p>
                    </div>
                </div>
                <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <select class="w-full rounded-full border border-gray-200 bg-white px-4 py-3 text-sm text-gray-700 focus:border-[#4E7D24] focus:outline-none focus:ring-2 focus:ring-[#4E7D24]/20 sm:w-auto">
                        <option>PDF</option>
                        <option>Excel</option>
                    </select>
                    <button type="button" class="inline-flex items-center justify-center rounded-full bg-[#4E7D24] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#3b6620]">
                        Generar
                    </button>
                </div>
                <p class="mt-4 text-xs text-gray-400">Último generado: 10 Abr 2026</p>
            </article>

            <article class="rounded-[28px] border border-gray-200 bg-[#f8fafb] p-6 shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-3xl bg-[#dcfce7] text-[#166534]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6M9 7h6"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Reporte de Actividades</p>
                        <p class="mt-2 text-sm text-gray-600">Listado de todas las actividades realizadas durante las prácticas.</p>
                    </div>
                </div>
                <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <select class="w-full rounded-full border border-gray-200 bg-white px-4 py-3 text-sm text-gray-700 focus:border-[#4E7D24] focus:outline-none focus:ring-2 focus:ring-[#4E7D24]/20 sm:w-auto">
                        <option>PDF</option>
                        <option>Excel</option>
                    </select>
                    <button type="button" class="inline-flex items-center justify-center rounded-full bg-[#4E7D24] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#3b6620]">
                        Generar
                    </button>
                </div>
                <p class="mt-4 text-xs text-gray-400">Último generado: 05 Abr 2026</p>
            </article>

            <article class="rounded-[28px] border border-gray-200 bg-[#f8fafb] p-6 shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-3xl bg-[#f0fdf4] text-[#15803d]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7M12 5v6"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Reporte de Progreso</p>
                        <p class="mt-2 text-sm text-gray-600">Resumen gráfico del avance general en las prácticas profesionales.</p>
                    </div>
                </div>
                <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <select class="w-full rounded-full border border-gray-200 bg-white px-4 py-3 text-sm text-gray-700 focus:border-[#4E7D24] focus:outline-none focus:ring-2 focus:ring-[#4E7D24]/20 sm:w-auto">
                        <option>PDF</option>
                        <option>Excel</option>
                    </select>
                    <button type="button" class="inline-flex items-center justify-center rounded-full bg-[#4E7D24] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#3b6620]">
                        Generar
                    </button>
                </div>
                <p class="mt-4 text-xs text-gray-400">Último generado: 08 Abr 2026</p>
            </article>

            <article class="rounded-[28px] border border-gray-200 bg-[#f8fafb] p-6 shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-3xl bg-[#eef2ff] text-[#4338ca]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h8m-8 4h6M5 6h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Constancia de Prácticas</p>
                        <p class="mt-2 text-sm text-gray-600">Documento oficial que acredita tu participación en las prácticas.</p>
                    </div>
                </div>
                <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <select class="w-full rounded-full border border-gray-200 bg-white px-4 py-3 text-sm text-gray-700 focus:border-[#4E7D24] focus:outline-none focus:ring-2 focus:ring-[#4E7D24]/20 sm:w-auto">
                        <option>PDF</option>
                        <option>Word</option>
                    </select>
                    <button type="button" class="inline-flex items-center justify-center rounded-full bg-[#4E7D24] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#3b6620]">
                        Generar
                    </button>
                </div>
                <p class="mt-4 text-xs text-gray-400">Último generado: 01 Abr 2026</p>
            </article>
        </div>

        <div class="mt-10">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Historial de Reportes</h3>
                    <p class="mt-2 text-sm text-gray-500">Accede a reportes ya generados y descárgalos cuando lo necesites.</p>
                </div>
            </div>

            <div class="mt-6 space-y-4">
                <article class="rounded-[28px] border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-4">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-red-50 text-red-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M9 8h6M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Reporte de Horas - Abril 2026</p>
                                <p class="mt-1 text-xs text-gray-500">10 Abr 2026 · 245 KB</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
                            <span class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1">PDF</span>
                            <button type="button" class="text-gray-700 hover:text-gray-900">Ver</button>
                            <button type="button" class="text-gray-700 hover:text-gray-900">Descargar</button>
                        </div>
                    </div>
                </article>

                <article class="rounded-[28px] border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-4">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M9 8h6M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Reporte de Actividades - Marzo 2026</p>
                                <p class="mt-1 text-xs text-gray-500">05 Abr 2026 · 128 KB</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
                            <span class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1">PDF</span>
                            <button type="button" class="text-gray-700 hover:text-gray-900">Ver</button>
                            <button type="button" class="text-gray-700 hover:text-gray-900">Descargar</button>
                        </div>
                    </div>
                </article>

                <article class="rounded-[28px] border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-4">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-red-50 text-red-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M9 8h6M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Reporte de Horas - Marzo 2026</p>
                                <p class="mt-1 text-xs text-gray-500">01 Abr 2026 · 198 KB</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
                            <span class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1">PDF</span>
                            <button type="button" class="text-gray-700 hover:text-gray-900">Ver</button>
                            <button type="button" class="text-gray-700 hover:text-gray-900">Descargar</button>
                        </div>
                    </div>
                </article>

                <article class="rounded-[28px] border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-4">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M9 8h6M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Reporte de Progreso - Q1 2026</p>
                                <p class="mt-1 text-xs text-gray-500">31 Mar 2026 · 512 KB</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
                            <span class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1">PDF</span>
                            <button type="button" class="text-gray-700 hover:text-gray-900">Ver</button>
                            <button type="button" class="text-gray-700 hover:text-gray-900">Descargar</button>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>
@endsection
