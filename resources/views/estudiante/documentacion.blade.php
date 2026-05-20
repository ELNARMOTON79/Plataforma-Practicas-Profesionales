@extends('layouts.estudiante', ['active' => 'documentacion'])

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
                <h2 class="text-2xl font-bold text-gray-900">Documentación</h2>
                <p class="mt-2 text-sm text-gray-500">Gestiona tus documentos de prácticas profesionales</p>
            </div>
            <button type="button" class="inline-flex items-center gap-2 rounded-2xl bg-[#4E7D24] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#3b6620]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Subir documento
            </button>
        </div>

        <div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-3xl border border-gray-200 bg-gray-50 p-5 shadow-sm">
                <div class="flex items-center gap-3 text-sm font-semibold text-gray-900">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-3xl bg-white text-[#4E7D24] shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h6l6 6v10a2 2 0 01-2 2z"/>
                        </svg>
                    </span>
                    Total de documentos
                </div>
                <p class="mt-4 text-3xl font-bold text-gray-900">4</p>
            </div>
            <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3 text-sm font-semibold text-gray-900">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-3xl bg-[#E7F5DD] text-[#4E7D24] shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m12-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </span>
                    Aprobados
                </div>
                <p class="mt-4 text-3xl font-bold text-gray-900">1</p>
            </div>
            <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3 text-sm font-semibold text-gray-900">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-3xl bg-[#FEF3C7] text-[#B45309] shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </span>
                    Pendientes
                </div>
                <p class="mt-4 text-3xl font-bold text-gray-900">1</p>
            </div>
            <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3 text-sm font-semibold text-gray-900">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-3xl bg-[#FFE4E6] text-[#B91C1C] shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </span>
                    Rechazados
                </div>
                <p class="mt-4 text-3xl font-bold text-gray-900">1</p>
            </div>
        </div>

        <div class="mt-8 rounded-[28px] border border-gray-200 bg-gray-50 p-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <label class="relative block w-full max-w-md">
                    <span class="sr-only">Buscar documento</span>
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </span>
                    <input type="search" placeholder="Buscar documento..." class="w-full rounded-full border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm text-gray-700 shadow-sm focus:border-[#4E7D24] focus:outline-none focus:ring-2 focus:ring-[#4E7D24]/20" />
                </label>
                <div class="inline-flex overflow-hidden rounded-full border border-gray-200 bg-white text-sm font-semibold">
                    <button type="button" class="px-4 py-2 bg-[#F4F9F1] text-[#4E7D24]">Todos</button>
                    <button type="button" class="px-4 py-2 text-gray-500">Pendientes</button>
                    <button type="button" class="px-4 py-2 text-gray-500">Aprobados</button>
                    <button type="button" class="px-4 py-2 text-gray-500">Rechazados</button>
                </div>
            </div>
        </div>

        <div class="mt-8 grid gap-4 md:grid-cols-2">
            <article class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-3xl bg-[#E7F5DD] text-[#4E7D24]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h6l6 6v10a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-base font-semibold text-gray-900">Carta de Presentación</h3>
                        <p class="mt-2 text-sm text-gray-500">Subido: 10 Mar 2026 · 245 KB</p>
                    </div>
                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Aprobado</span>
                </div>
                <div class="mt-6 flex flex-wrap items-center gap-4 text-sm text-gray-500">
                    <button type="button" class="inline-flex items-center gap-2 text-[#111827] hover:text-[#4E7D24]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m3-3v6m7 3H6a2 2 0 01-2-2V7a2 2 0 012-2h11l5 5v7a2 2 0 01-2 2z"/>
                        </svg>
                        Ver
                    </button>
                    <button type="button" class="inline-flex items-center gap-2 text-[#111827] hover:text-[#4E7D24]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Descargar
                    </button>
                </div>
            </article>

            <article class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-3xl bg-[#F7F0E6] text-[#92400E]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h6l6 6v10a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-base font-semibold text-gray-900">Informe Mensual - Marzo</h3>
                        <p class="mt-2 text-sm text-gray-500">Subido: 28 Mar 2026 · 1.2 MB</p>
                    </div>
                    <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">En Revisión</span>
                </div>
                <div class="mt-6 flex flex-wrap items-center gap-4 text-sm text-gray-500">
                    <button type="button" class="inline-flex items-center gap-2 text-[#111827] hover:text-[#4E7D24]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m3-3v6m7 3H6a2 2 0 01-2-2V7a2 2 0 012-2h11l5 5v7a2 2 0 01-2 2z"/>
                        </svg>
                        Ver
                    </button>
                    <button type="button" class="inline-flex items-center gap-2 text-[#111827] hover:text-[#4E7D24]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Descargar
                    </button>
                </div>
            </article>

            <article class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-3xl bg-[#DBEAFE] text-[#1D4ED8]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h6l6 6v10a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-base font-semibold text-gray-900">Evaluación de Desempeño</h3>
                        <p class="mt-2 text-sm text-gray-500">Vence: 30 Abr 2026</p>
                    </div>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">Pendiente</span>
                </div>
                <div class="mt-6 flex flex-wrap items-center gap-4 text-sm text-gray-500">
                    <button type="button" class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-4 py-2 text-[#4E7D24] hover:bg-gray-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Subir ahora
                    </button>
                </div>
            </article>

            <article class="rounded-[28px] border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-3xl bg-[#FEE2E2] text-[#B91C1C]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h6l6 6v10a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-base font-semibold text-gray-900">Constancia de Seguro Médico</h3>
                        <p class="mt-2 text-sm text-gray-500">Subido: 05 Feb 2026 · 156 KB</p>
                    </div>
                    <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-700">Rechazado</span>
                </div>
                <div class="mt-6 flex flex-wrap items-center gap-4 text-sm text-gray-500">
                    <button type="button" class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-4 py-2 text-[#dc2626] hover:bg-red-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Volver a subir
                    </button>
                </div>
            </article>
        </div>
    </div>
</div>
@endsection
