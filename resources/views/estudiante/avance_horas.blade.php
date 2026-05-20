@extends('layouts.estudiante', ['active' => 'avance-horas'])

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
<div class="flex justify-center px-4 py-6 sm:px-6 lg:px-8">
    <div class="w-full max-w-5xl rounded-[32px] bg-white p-8 shadow-sm border border-gray-200">
        <div class="space-y-6">
            <div class="text-center max-w-2xl mx-auto">
                <h2 class="text-2xl font-bold text-gray-900">Avance de Horas</h2>
                <p class="mt-2 text-sm text-gray-500">Consulta tus horas de práctica profesional</p>
            </div>
        </div>

        <div class="mt-10 mx-auto w-full max-w-3xl">
            <div class="rounded-[28px] bg-[#FBFDF7] border border-gray-100 p-8 shadow-sm">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Progreso General</h3>
                        <p class="text-sm text-gray-500 mt-1">Tu avance en horas de práctica</p>
                    </div>
                    <div class="rounded-3xl bg-white px-5 py-4 shadow-sm border border-gray-200 text-center">
                        <div class="text-3xl font-bold text-[#4E7D24]">53%</div>
                        <p class="text-xs uppercase tracking-[0.15em] text-gray-400 mt-1">completado</p>
                    </div>
                </div>

                <div class="mt-8">
                    <div class="h-3 rounded-full bg-gray-200 overflow-hidden">
                        <div class="h-full w-[53%] rounded-full bg-[#4E7D24]"></div>
                    </div>
                    <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                        <span class="font-medium text-gray-900">Horas completadas</span>
                        <span>256 / 480 horas</span>
                    </div>
                </div>

                <div class="mt-8 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-3xl bg-white border border-gray-200 p-4 text-center">
                        <div class="text-2xl font-bold text-[#4E7D24]">232</div>
                        <p class="text-xs uppercase tracking-[0.2em] text-gray-400 mt-1">Aprobadas</p>
                    </div>
                    <div class="rounded-3xl bg-white border border-gray-200 p-4 text-center">
                        <div class="text-2xl font-bold text-orange-500">24</div>
                        <p class="text-xs uppercase tracking-[0.2em] text-gray-400 mt-1">Pendientes</p>
                    </div>
                    <div class="rounded-3xl bg-white border border-gray-200 p-4 text-center">
                        <div class="text-2xl font-bold text-red-500">4</div>
                        <p class="text-xs uppercase tracking-[0.2em] text-gray-400 mt-1">Rechazadas</p>
                    </div>
                </div>

                <div class="mt-10 flex items-center justify-between">
                    <div>
                        <h4 class="text-base font-semibold text-gray-900">Historial de Registros</h4>
                        <p class="text-sm text-gray-500 mt-1">Tus registros de horas recientes</p>
                    </div>
                    <button type="button" class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                        Filtrar
                    </button>
                </div>

                <div class="mt-6 space-y-4">
                    <article class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm">
                        <div class="flex items-start gap-4">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gray-100 text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">10 Abr 2026</p>
                                        <p class="text-xs text-gray-500 mt-1">8 horas</p>
                                    </div>
                                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Aprobado</span>
                                </div>
                                <p class="mt-3 text-sm text-gray-500">Desarrollo de módulo de autenticación</p>
                            </div>
                        </div>
                    </article>

                    <article class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm">
                        <div class="flex items-start gap-4">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gray-100 text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">09 Abr 2026</p>
                                        <p class="text-xs text-gray-500 mt-1">8 horas</p>
                                    </div>
                                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Aprobado</span>
                                </div>
                                <p class="mt-3 text-sm text-gray-500">Diseño de base de datos y diagramas ER</p>
                            </div>
                        </div>
                    </article>

                    <article class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm">
                        <div class="flex items-start gap-4">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gray-100 text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">08 Abr 2026</p>
                                        <p class="text-xs text-gray-500 mt-1">6 horas</p>
                                    </div>
                                    <span class="rounded-full bg-yellow-50 px-3 py-1 text-xs font-semibold text-amber-700">Pendiente</span>
                                </div>
                                <p class="mt-3 text-sm text-gray-500">Reunión con equipo y planificación de sprint</p>
                            </div>
                        </div>
                    </article>

                    <article class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm">
                        <div class="flex items-start gap-4">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gray-100 text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">07 Abr 2026</p>
                                        <p class="text-xs text-gray-500 mt-1">6 horas</p>
                                    </div>
                                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Aprobado</span>
                                </div>
                                <p class="mt-3 text-sm text-gray-500">Implementación de API REST para usuarios</p>
                            </div>
                        </div>
                    </article>

                    <article class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm">
                        <div class="flex items-start gap-4">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gray-100 text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">05 Abr 2026</p>
                                        <p class="text-xs text-gray-500 mt-1">4 horas</p>
                                    </div>
                                    <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">Rechazado</span>
                                </div>
                                <p class="mt-3 text-sm text-gray-500">Documentación técnica del proyecto</p>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
