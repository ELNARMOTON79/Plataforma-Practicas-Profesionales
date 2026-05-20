@extends('layouts.estudiante', ['active' => 'dashboard'])

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
<div class="space-y-6 max-w-6xl">

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <x-estudiante.stat-card
            label="Horas completadas"
            :value="$horasCompletadas . '/' . $horasMeta"
            icon="clock"
            iconBg="bg-blue-50"
            iconColor="text-blue-500"
            :progress="$porcentajeHoras"
            :progressLabel="$porcentajeHoras . '% completado'"
        />
        <x-estudiante.stat-card
            label="Solicitudes activas"
            :value="(string) $solicitudesActivas"
            icon="document"
            iconBg="bg-green-50"
            iconColor="text-[#4E7D24]"
        />
        <x-estudiante.stat-card
            label="Documentos pendientes"
            :value="(string) $documentosPendientes"
            icon="alert"
            iconBg="bg-red-50"
            iconColor="text-red-500"
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="estudiante-panel">
            <h2 class="text-base font-bold text-gray-900 mb-4">Acciones Rápidas</h2>
            <div class="grid grid-cols-2 gap-3">
                @php
                    $acciones = [
                        ['titulo' => 'Nueva Solicitud', 'sub' => 'Registrar práctica', 'route' => 'estudiante.nuevaSolicitud', 'color' => 'text-blue-500', 'bg' => 'bg-blue-50', 'icon' => 'M12 4v16m8-8H4'],
                        ['titulo' => 'Registrar Horas', 'sub' => 'Bitácora semanal', 'route' => null, 'color' => 'text-blue-500', 'bg' => 'bg-blue-50', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['titulo' => 'Subir Documentos', 'sub' => 'Cartas y formatos', 'route' => null, 'color' => 'text-[#4E7D24]', 'bg' => 'bg-green-50', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['titulo' => 'Contactar Coordinador', 'sub' => 'Enviar mensaje', 'route' => null, 'color' => 'text-purple-500', 'bg' => 'bg-purple-50', 'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
                    ];
                @endphp
                @foreach ($acciones as $accion)
                    <a href="{{ $accion['route'] ? route($accion['route']) : '#' }}"
                       class="flex items-start gap-3 p-4 rounded-lg border border-gray-100 hover:border-[#6BA53A]/40 hover:bg-gray-50/80 transition-all group">
                        <div class="w-9 h-9 rounded-lg {{ $accion['bg'] }} {{ $accion['color'] }} flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $accion['icon'] }}"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-gray-900 leading-tight">{{ $accion['titulo'] }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $accion['sub'] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="estudiante-panel">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h2 class="text-base font-bold text-gray-900">Próximos Vencimientos</h2>
            </div>
            <div class="space-y-3">
                @forelse ($proximosVencimientos as $vencimiento)
                    <div class="flex items-center justify-between gap-3 p-3.5 rounded-lg {{ $vencimiento['urgente'] ? 'bg-amber-50/80' : 'bg-blue-50/60' }}">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $vencimiento['titulo'] }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $vencimiento['fecha'] }}</p>
                        </div>
                        <span class="shrink-0 text-xs font-bold px-2.5 py-1 rounded-full {{ $vencimiento['urgente'] ? 'bg-amber-200 text-amber-800' : 'bg-blue-100 text-blue-700' }}">
                            {{ $vencimiento['dias'] }} {{ $vencimiento['dias'] === 1 ? 'día' : 'días' }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 text-center py-6">No hay vencimientos próximos</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="estudiante-panel">
        <h2 class="text-base font-bold text-gray-900 mb-4">Actividad Reciente</h2>
        <div class="divide-y divide-gray-100">
            @forelse ($actividadReciente as $item)
                @php
                    $dotColor = match ($item['color']) {
                        'green' => 'bg-[#4E7D24]',
                        'orange' => 'bg-orange-400',
                        default => 'bg-blue-400',
                    };
                @endphp
                <div class="flex items-center gap-3 py-3.5 first:pt-0 last:pb-0">
                    <span class="w-2 h-2 rounded-full shrink-0 {{ $dotColor }}"></span>
                    <p class="flex-1 text-sm text-gray-700">{{ $item['titulo'] }}</p>
                    <span class="text-xs text-gray-400 shrink-0">{{ $item['tiempo'] }}</span>
                </div>
            @empty
                <p class="text-sm text-gray-400 text-center py-6">Aún no hay actividad registrada</p>
            @endforelse
        </div>
    </div>

</div>
@endsection
