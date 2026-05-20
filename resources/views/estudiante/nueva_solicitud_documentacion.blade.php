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
                    <div class="rounded-3xl border border-[#4E7D24] p-5 text-center bg-[#e8f7e9]">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 0a2 2 0 110 4H7a2 2 0 110-4m4-7a3 3 0 100 6 3 3 0 000-6z"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-[#4E7D24]">Detalles de la Práctica</p>
                    </div>

                    <div class="h-1 w-full bg-[#4E7D24] hidden lg:block"></div>

                    <div class="rounded-3xl border border-[#4E7D24] p-5 text-center bg-[#f2fbf2]">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#def1d8] text-[#4E7D24] mb-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 13v6a2 2 0 01-2 2H8a2 2 0 01-2-2v-6"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v10m0 0l-3-3m3 3l3-3"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-[#4E7D24]">Documentación</p>
                    </div>
                </div>

                <form action="#" method="POST" class="mt-10 space-y-6">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label class="text-sm font-semibold text-gray-900">Carta de Presentación <span class="text-red-500">*</span></label>
                            <div class="mt-3 rounded-3xl border border-dashed border-[#c6dfc3] bg-[#f7fbf7] p-8 text-center text-sm text-gray-500">
                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-white text-[#8f9c8c] shadow-sm mb-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v12m0 0l-3-3m3 3l3-3M8 21h8"/>
                                    </svg>
                                </div>
                                <p class="font-medium text-gray-700">Haz clic para subir o arrastra el archivo</p>
                                <p class="text-xs text-gray-400 mt-2">PDF (Max. 5MB)</p>
                            </div>
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-gray-900">Convenio Firmado <span class="text-gray-400">(Opcional)</span></label>
                            <div class="mt-3 rounded-3xl border border-dashed border-[#c6dfc3] bg-[#f7fbf7] p-8 text-center text-sm text-gray-500">
                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-white text-[#8f9c8c] shadow-sm mb-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 11h10M7 15h6"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3h3.5a1.5 1.5 0 011.5 1.5V9"/>
                                    </svg>
                                </div>
                                <p class="font-medium text-gray-700">Haz clic para subir o arrastra el archivo</p>
                                <p class="text-xs text-gray-400 mt-2">PDF (Max. 5MB)</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-[#f2e5c9] bg-[#fffbf1] p-4 text-sm text-gray-700">
                        <p><span class="font-semibold">Nota:</span> Una vez enviada la solicitud, será revisada por el coordinador. Recibirás una notificación con la respuesta en 2-3 días hábiles.</p>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:justify-between">
                        <a href="{{ route('estudiante.nuevaSolicitudDetalles') }}" class="inline-flex items-center justify-center rounded-full border border-[#d3e8d0] bg-[#f5fbf5] px-6 py-3 text-sm font-semibold text-[#4E7D24] shadow-sm transition hover:bg-[#e9f7e9]">
                            &lt; Anterior
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center rounded-full bg-[#4E7D24] px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#3b6620] focus:outline-none focus:ring-2 focus:ring-[#4E7D24]/50">
                            Enviar Solicitud
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
