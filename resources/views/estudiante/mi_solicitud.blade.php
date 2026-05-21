@extends('layouts.estudiante', ['active' => 'mis-solicitudes'])

@section('header')
<header class="bg-white border-b border-gray-200 px-6 py-5 flex items-center justify-between shrink-0">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Bienvenido, {{ $nombre }}</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ $carrera }} — Matrícula: {{ $matricula }}</p>
    </div>
    <div class="flex items-center gap-4">
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
    <div class="rounded-[32px] bg-white border border-gray-200 shadow-sm p-6">
        <x-page-header title="Mis Solicitudes" description="Consulta el estado de tus solicitudes de prácticas profesionales.">
            <x-slot:actions>
                <a href="{{ route('estudiante.nuevaSolicitud') }}" class="inline-flex items-center rounded-full bg-[#4E7D24] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#3b6620]">
                    Nueva solicitud
                </a>
            </x-slot:actions>
        </x-page-header>

        <div class="mt-6">
            <form method="GET" action="{{ route('estudiante.misSolicitudes') }}">
                <label for="q" class="sr-only">Buscar por empresa</label>
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </span>
                    <input id="q" name="q" type="search" value="{{ request('q') }}" placeholder="Buscar por empresa..." class="w-full rounded-full border border-gray-200 bg-gray-50 py-3 pl-12 pr-4 text-sm text-gray-700 shadow-sm focus:border-[#4E7D24] focus:outline-none focus:ring-2 focus:ring-[#4E7D24]/20" />
                </div>
            </form>
        </div>

        <div class="mt-8 space-y-4">
            @if($solicitudes->isEmpty())
                <div class="rounded-3xl border border-dashed border-gray-200 bg-gray-50 p-8 text-center text-gray-500">
                    Aún no tienes solicitudes registradas. Inicia una nueva solicitud para comenzar tu proceso.
                </div>
            @else
                @foreach($solicitudes as $solicitud)
                    <x-estudiante.solicitud-card :solicitud="$solicitud" />
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
