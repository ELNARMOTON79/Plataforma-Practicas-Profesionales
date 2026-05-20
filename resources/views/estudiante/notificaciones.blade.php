@extends('layouts.estudiante', ['active' => 'notificaciones'])

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
                <h2 class="text-2xl font-bold text-gray-900">Notificaciones</h2>
                <p class="mt-2 text-sm text-gray-500">Revisa tus últimas alertas y mensajes importantes del programa de prácticas.</p>
            </div>
            <button type="button" class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Marcar todas como leídas
            </button>
        </div>

        <div class="mt-8 grid gap-4 sm:grid-cols-4">
            <div class="rounded-[28px] border border-gray-200 bg-[#f8fafb] p-5">
                <p class="text-sm font-medium text-gray-500">Total</p>
                <p class="mt-4 text-3xl font-bold text-gray-900">7</p>
            </div>
            <div class="rounded-[28px] border border-gray-200 bg-[#f8fafb] p-5">
                <p class="text-sm font-medium text-gray-500">Sin leer</p>
                <p class="mt-4 text-3xl font-bold text-[#2563eb]">3</p>
            </div>
            <div class="rounded-[28px] border border-gray-200 bg-[#f8fafb] p-5">
                <p class="text-sm font-medium text-gray-500">Aprobaciones</p>
                <p class="mt-4 text-3xl font-bold text-[#16a34a]">2</p>
            </div>
            <div class="rounded-[28px] border border-gray-200 bg-[#f8fafb] p-5">
                <p class="text-sm font-medium text-gray-500">Recordatorios</p>
                <p class="mt-4 text-3xl font-bold text-[#d97706]">2</p>
            </div>
        </div>

        <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex flex-wrap items-center gap-3">
                <span class="inline-flex items-center rounded-full bg-[#eff6ff] px-4 py-2 text-sm font-semibold text-[#1d4ed8]">Todas</span>
                <span class="inline-flex items-center rounded-full bg-[#fef3c7] px-4 py-2 text-sm font-semibold text-[#b45309]">No leídas</span>
            </div>
            <p class="text-sm text-gray-500">Mostrando 7 notificaciones</p>
        </div>

        <div class="mt-6 space-y-6">
            <section class="space-y-4">
                <div class="flex items-center gap-3 text-sm font-semibold text-gray-500 uppercase tracking-[0.2em]">
                    <span class="inline-flex h-2.5 w-2.5 rounded-full bg-[#22c55e]"></span>
                    Hoy
                </div>

                <article class="rounded-[28px] border border-green-100 bg-[#f6f9f1] p-5 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M12 5v6"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Registro de horas aprobado</p>
                                <p class="mt-2 text-sm text-gray-600">Tu registro de 8 horas del 10 de abril ha sido aprobado por el coordinador.</p>
                            </div>
                        </div>
                        <button type="button" class="text-sm font-semibold text-[#4e7d24] hover:text-[#3b6620]">Marcar como leída</button>
                    </div>
                </article>

                <article class="rounded-[28px] border border-blue-100 bg-[#eff6ff] p-5 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-50 text-blue-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h8m-8 4h5m4 1V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Nuevo mensaje del coordinador</p>
                                <p class="mt-2 text-sm text-gray-600">Dr. Carlos Martínez te ha enviado un mensaje sobre tu informe mensual.</p>
                            </div>
                        </div>
                        <button type="button" class="text-sm font-semibold text-[#2563eb] hover:text-[#1d4ed8]">Marcar como leída</button>
                    </div>
                </article>

                <article class="rounded-[28px] border border-amber-100 bg-[#fffbeb] p-5 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-50 text-amber-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l2 2M12 5.5A6.5 6.5 0 105.5 12 6.508 6.508 0 0012 5.5z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Recordatorio: Informe mensual</p>
                                <p class="mt-2 text-sm text-gray-600">Tienes 5 días para subir tu informe mensual de marzo. No olvides incluir todas las actividades.</p>
                            </div>
                        </div>
                        <button type="button" class="text-sm font-semibold text-[#b45309] hover:text-[#92400e]">Marcar como leída</button>
                    </div>
                </article>
            </section>

            <section class="space-y-4">
                <div class="flex items-center gap-3 text-sm font-semibold text-gray-500 uppercase tracking-[0.2em]">
                    <span class="inline-flex h-2.5 w-2.5 rounded-full bg-[#60a5fa]"></span>
                    Ayer
                </div>

                <article class="rounded-[28px] border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="flex items-start gap-4">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gray-100 text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Solicitud aprobada</p>
                            <p class="mt-2 text-sm text-gray-600">Tu solicitud de prácticas en Tech Solutions S.A. ha sido aprobada. Puedes comenzar el 01 de abril.</p>
                        </div>
                    </div>
                </article>

                <article class="rounded-[28px] border border-red-100 bg-[#fef2f2] p-5 shadow-sm">
                    <div class="flex items-start gap-4">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-red-50 text-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Documento rechazado</p>
                            <p class="mt-2 text-sm text-gray-600">Tu constancia de seguro médico ha sido rechazada. Por favor, sube una versión actualizada.</p>
                        </div>
                    </div>
                </article>
            </section>

            <section class="space-y-4">
                <div class="flex items-center gap-3 text-sm font-semibold text-gray-500 uppercase tracking-[0.2em]">
                    <span class="inline-flex h-2.5 w-2.5 rounded-full bg-[#94a3b8]"></span>
                    Esta semana
                </div>

                <article class="rounded-[28px] border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="flex items-start gap-4">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gray-100 text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-.343 2-3 2m0-8v8"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Actualización del sistema</p>
                            <p class="mt-2 text-sm text-gray-600">Se han actualizado los formatos de reportes. Revisa las nuevas plantillas disponibles.</p>
                        </div>
                    </div>
                </article>

                <article class="rounded-[28px] border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="flex items-start gap-4">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gray-100 text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-.343 2-3 2m0-8v8"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Recordatorio: Evaluación de desempeño</p>
                            <p class="mt-2 text-sm text-gray-600">Tu evaluación de desempeño vence el 30 de abril. Coordina con tu supervisor.</p>
                        </div>
                    </div>
                </article>
            </section>
        </div>
    </div>
</div>
@endsection
