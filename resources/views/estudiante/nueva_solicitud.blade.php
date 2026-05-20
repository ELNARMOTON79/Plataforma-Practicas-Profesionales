@extends('layouts.estudiante', ['active' => 'nueva-solicitud'])

@section('header')
<header class="bg-white border-b border-gray-200 px-6 py-5 flex items-center justify-between shrink-0">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Bienvenido, Juan Pérez Alumno</h1>
        <p class="text-sm text-gray-500 mt-0.5">Ingeniería en Software — Matrícula: 20191234</p>
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
<div class="space-y-6 max-w-6xl mx-auto">
    <div class="bg-white rounded-[32px] shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-8 py-8">
            <div class="max-w-3xl mx-auto">
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-gray-900">Nueva Solicitud de Prácticas</h2>
                    <p class="text-sm text-gray-500 mt-2">Completa el formulario para registrar tu solicitud</p>
                </div>

                <div class="mt-10 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="rounded-3xl border border-gray-200 p-5 text-center bg-[#f8fff3]">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#e5f7d6] text-[#4E7D24] mb-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 13h2v8H3zM19 3c1.105 0 2 .895 2 2v14c0 1.105-.895 2-2 2H5c-1.105 0-2-.895-2-2v-2h2v2h14V5H5v2H3V5c0-1.105.895-2 2-2h14zM7 13h2v8H7zm4-10h2v18h-2zm4 10h2v8h-2z"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-900">Información de la Empresa</p>
                    </div>
                    <div class="rounded-3xl border border-gray-200 p-5 text-center bg-white/90">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-500 mb-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                                <path d="M14 3v5h5M8 13h8M8 17h8"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-500">Detalles de la Práctica</p>
                    </div>
                    <div class="rounded-3xl border border-gray-200 p-5 text-center bg-white/90">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-500 mb-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4 4v16h16V4H4zm8 13.5l-5-5 1.41-1.41L12 13.67l5.59-5.58L19 9.5l-7 7z"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-500">Documentación</p>
                    </div>
                </div>

                <form action="{{ route('estudiante.nuevaSolicitudDetalles') }}" method="GET" class="mt-10 space-y-6">
                    <div class="grid gap-4">
                        <div class="space-y-3">
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Nombre de la Empresa <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </span>
                                <input type="text" name="empresa_nombre" placeholder="Buscar empresa..." class="w-full rounded-2xl border border-gray-200 bg-white py-3 pl-11 pr-4 text-sm text-gray-700 shadow-sm focus:border-[#4E7D24] focus:outline-none focus:ring-2 focus:ring-[#4E7D24]/20" />
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C8.134 2 5 5.134 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.866-3.134-7-7-7zm0 9.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"/>
                                </svg>
                                Dirección de la Empresa <span class="text-red-500">*</span>
                            </label>
                            <div>
                                <input type="text" name="empresa_direccion" placeholder="Ej: Miguel de la Madrid #22" class="w-full rounded-2xl border border-gray-200 bg-white py-3 px-4 text-sm text-gray-700 shadow-sm focus:border-[#4E7D24] focus:outline-none focus:ring-2 focus:ring-[#4E7D24]/20" />
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="space-y-3">
                                <label class="flex items-center gap-2 text-sm font-medium text-gray-700">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                    Nombre del Supervisor <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="supervisor_nombre" placeholder="Nombre completo" class="w-full rounded-2xl border border-gray-200 bg-white py-3 px-4 text-sm text-gray-700 shadow-sm focus:border-[#4E7D24] focus:outline-none focus:ring-2 focus:ring-[#4E7D24]/20" />
                            </div>
                            <div class="space-y-3">
                                <label class="flex items-center gap-2 text-sm font-medium text-gray-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5.75A2.75 2.75 0 015.75 3h2.5A2.75 2.75 0 0111 5.75v2.5A2.75 2.75 0 018.25 11h-.25a.75.75 0 00-.53.22l-1.5 1.5a11.09 11.09 0 005.5 5.5l1.5-1.5a.75.75 0 00.22-.53v-.25A2.75 2.75 0 0113.75 13h2.5A2.75 2.75 0 0119 15.75v2.5A2.75 2.75 0 0116.25 21h-2.5A17 17 0 013 5.75z"/>
                                    </svg>
                                    Teléfono del Supervisor
                                </label>
                                <input type="tel" name="supervisor_telefono" placeholder="(809) 123-4567" class="w-full rounded-2xl border border-gray-200 bg-white py-3 px-4 text-sm text-gray-700 shadow-sm focus:border-[#4E7D24] focus:outline-none focus:ring-2 focus:ring-[#4E7D24]/20" />
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                </svg>
                                Email del Supervisor <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="supervisor_email" placeholder="supervisor@empresa.com" class="w-full rounded-2xl border border-gray-200 bg-white py-3 px-4 text-sm text-gray-700 shadow-sm focus:border-[#4E7D24] focus:outline-none focus:ring-2 focus:ring-[#4E7D24]/20" />
                        </div>
                    </div>

                    <div class="flex justify-end">
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
