@extends('layouts.estudiante', ['active' => 'mensajes'])

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
                <h2 class="text-2xl font-bold text-gray-900">Mensajería</h2>
                <p class="mt-2 text-sm text-gray-500">Comunicación con el coordinador de prácticas</p>
            </div>
        </div>

        <div class="mt-8 rounded-[32px] bg-[#F8FAFB] p-6 shadow-sm border border-gray-200">
            <div class="flex items-center gap-4 rounded-[28px] bg-white p-5 shadow-sm border border-gray-200">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#E7F5DD] text-[#4E7D24] font-semibold">RM</div>
                <div>
                    <p class="text-base font-semibold text-gray-900">Dr. Ricardo Martínez</p>
                    <p class="text-sm text-gray-500">Coordinador de Prácticas</p>
                </div>
            </div>

            <div class="mt-8 space-y-6">
                <div class="flex items-start gap-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#E7F5DD] text-[#4E7D24] font-semibold">RM</div>
                    <div class="rounded-[28px] bg-white p-5 shadow-sm border border-gray-200 max-w-2xl">
                        <p class="text-sm text-gray-700">Hola Juan Pérez, he revisado tu solicitud de prácticas en Tech Solutions. Todo está en orden y ha sido aprobada.</p>
                    </div>
                </div>
                <p class="text-xs text-gray-400">10 Abr 2026 · 09:30 am</p>

                <div class="flex justify-end gap-4">
                    <div class="rounded-[28px] bg-[#dcfce7] p-5 shadow-sm border border-[#d1fae5] max-w-2xl">
                        <p class="text-sm text-gray-900">Muchas gracias, Dr. Martínez. ¿Cuándo puedo comenzar oficialmente?</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#4E7D24] text-white font-semibold">JP</div>
                </div>
                <p class="text-right text-xs text-gray-400">10 Abr 2026 · 10:15 am</p>

                <div class="flex items-start gap-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#E7F5DD] text-[#4E7D24] font-semibold">RM</div>
                    <div class="rounded-[28px] bg-white p-5 shadow-sm border border-gray-200 max-w-2xl">
                        <p class="text-sm text-gray-700">Puedes iniciar a partir del 1 de abril como indicaste en tu solicitud. Recuerda registrar tus horas semanalmente.</p>
                    </div>
                </div>
                <p class="text-xs text-gray-400">10 Abr 2026 · 11:00 am</p>

                <div class="flex justify-end gap-4">
                    <div class="rounded-[28px] bg-[#dcfce7] p-5 shadow-sm border border-[#d1fae5] max-w-2xl">
                        <p class="text-sm text-gray-900">Perfecto, así lo haré. ¿Necesito presentar algún informe mensual?</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#4E7D24] text-white font-semibold">JP</div>
                </div>
                <p class="text-right text-xs text-gray-400">10 Abr 2026 · 11:30 am</p>

                <div class="flex items-start gap-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#E7F5DD] text-[#4E7D24] font-semibold">RM</div>
                    <div class="rounded-[28px] bg-white p-5 shadow-sm border border-gray-200 max-w-2xl">
                        <p class="text-sm text-gray-700">Sí, debes subir un informe mensual antes del día 20 de cada mes. El formato lo encuentras en la sección de Reportes.</p>
                    </div>
                </div>
                <p class="text-xs text-gray-400">10 Abr 2026 · 12:00 pm</p>
            </div>

            <div class="mt-8 rounded-[28px] border border-gray-200 bg-white p-4 shadow-sm">
                <form action="#" method="POST" class="flex gap-4">
                    <input type="text" placeholder="Escribe tu mensaje..." class="flex-1 rounded-full border border-gray-200 bg-gray-50 px-5 py-3 text-sm text-gray-700 focus:border-[#4E7D24] focus:outline-none focus:ring-2 focus:ring-[#4E7D24]/20" />
                    <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-[#4E7D24] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#3b6620]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l7-7-7-7m0 0H5m7 7h14"/>
                        </svg>
                        Enviar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
