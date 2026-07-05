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
@if(session('solicitud_registrada'))
<div id="modal-confirmacion-solicitud" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 animate-fade-in">
    <div class="bg-white rounded-[32px] p-8 max-w-md w-full shadow-2xl border border-gray-100 text-center transform transition-all">
        <div class="w-16 h-16 rounded-full bg-[#E7F5DD] text-[#4E7D24] flex items-center justify-center mx-auto mb-5 shadow-inner">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <h3 class="text-2xl font-extrabold text-gray-900 mb-2">¡Solicitud Registrada!</h3>
        <p class="text-sm text-gray-600 leading-relaxed mb-6">Tu solicitud de prácticas profesionales ha sido almacenada correctamente en el sistema y se encuentra pendiente de revisión por el coordinador.</p>
        <button type="button" onclick="document.getElementById('modal-confirmacion-solicitud').remove()" class="w-full py-3.5 px-6 rounded-2xl bg-[#4E7D24] hover:bg-[#3b6620] text-white font-bold text-sm shadow-md transition-all cursor-pointer">
            Entendido
        </button>
    </div>
</div>
@endif
<div class="space-y-6 max-w-6xl mx-auto">
    <div class="rounded-[32px] bg-white border border-gray-200 shadow-sm p-6">
        <x-page-header title="Mis Solicitudes" description="Consulta el estado de tus solicitudes de prácticas profesionales.">
            <x-slot:actions>
                @if($solicitudes->isEmpty())
                <a href="{{ route('estudiante.nuevaSolicitud') }}" class="inline-flex items-center rounded-full bg-[#4E7D24] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#3b6620]">
                    Nueva solicitud
                </a>
                @else
                <button type="button" disabled class="inline-flex items-center gap-2 rounded-full bg-gray-100 border border-gray-200 px-5 py-2.5 text-sm font-bold text-gray-400 cursor-not-allowed select-none shadow-none" title="Ya cuentas con una solicitud registrada (Límite: 1 por estudiante)">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Solicitud Única Registrada
                </button>
                @endif
            </x-slot:actions>
        </x-page-header>

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
