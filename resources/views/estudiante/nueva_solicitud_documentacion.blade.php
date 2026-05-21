@extends('layouts.estudiante', ['active' => 'nueva-solicitud'])

@section('header')
<header class="bg-white border-b border-gray-200 px-6 py-5 flex items-center justify-between shrink-0">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Bienvenido, {{ $nombre }}</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ $carrera }} — Matrícula: {{ $matricula }}</p>
    </div>
    <div class="flex items-center gap-4">
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
<div class="w-full space-y-6">
    <!-- Header / Titles -->
    <div class="text-left px-2">
        <h1 class="text-3xl font-extrabold text-gray-900">Nueva Solicitud de Practicas</h1>
        <p class="text-sm text-gray-500 mt-1">Completa el formulario para registrar tu solicitud</p>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-[32px] shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-8 sm:px-16 md:px-20 py-12">
            <div class="max-w-7xl mx-auto">
                <!-- Circular Step Progress Indicator -->
                <div class="relative flex items-center justify-between w-full max-w-5xl mx-auto mt-4 mb-16">
                    <!-- Line segment background -->
                    <div class="absolute left-[16.67%] right-[16.67%] top-7 h-[2px] bg-gray-200 z-0"></div>
                    
                    <!-- Line segment active (Paso 1 & 2 completed, so progress line is 100% active) -->
                    <div class="absolute left-[16.67%] top-7 h-[2px] bg-[#8cc772] z-0 transition-all duration-300" style="width: 100%;"></div>

                    <!-- Step 1 (Completed) -->
                    <div class="relative z-10 flex flex-col items-center w-1/3">
                        <div class="flex items-center justify-center w-14 h-14 rounded-full border-2 border-[#8cc772] bg-white text-[#4E7D24] shadow-sm transition-all duration-200">
                            <!-- Ícono de Checkmark -->
                            <svg class="w-6 h-6 text-[#6BA53A]" fill="none" stroke="currentColor" stroke-width="3.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="mt-4 text-xs sm:text-sm font-bold text-[#6BA53A] text-center max-w-[150px] leading-tight">Informacion de la Empresa</span>
                    </div>

                    <!-- Step 2 (Completed) -->
                    <div class="relative z-10 flex flex-col items-center w-1/3">
                        <div class="flex items-center justify-center w-14 h-14 rounded-full border-2 border-[#8cc772] bg-white text-[#4E7D24] shadow-sm transition-all duration-200">
                            <!-- Ícono de Checkmark -->
                            <svg class="w-6 h-6 text-[#6BA53A]" fill="none" stroke="currentColor" stroke-width="3.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="mt-4 text-xs sm:text-sm font-bold text-[#6BA53A] text-center max-w-[150px] leading-tight">Detalles de la Practica</span>
                    </div>

                    <!-- Step 3 (Active) -->
                    <div class="relative z-10 flex flex-col items-center w-1/3">
                        <div class="flex items-center justify-center w-14 h-14 rounded-full border-2 border-[#8cc772] bg-white text-[#4E7D24] shadow-sm transition-all duration-200">
                            <!-- Ícono de Documentación (Subir) -->
                            <svg class="w-6 h-6 text-[#6BA53A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                        </div>
                        <span class="mt-4 text-xs sm:text-sm font-bold text-[#6BA53A] text-center max-w-[150px] leading-tight">Documentacion</span>
                    </div>
                </div>

                <form action="#" method="POST" class="mt-10 space-y-6">
                    @csrf
                    <div class="space-y-6">
                        <!-- Carta de Presentación -->
                        <div>
                            <label class="text-sm font-semibold text-gray-700">Carta de Presentación <span class="text-red-500">*</span></label>
                            <div class="mt-3 rounded-xl border border-dashed border-[#c0e6af] bg-[#fcfdfa] p-8 text-center text-sm text-gray-500 transition hover:bg-[#f6faf1] hover:border-[#8cc772] cursor-pointer">
                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-white text-gray-400 shadow-sm mb-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0l-3-3m3 3l3-3M8 21h8"/>
                                    </svg>
                                </div>
                                <p class="font-medium text-gray-700">Haz clic para subir o arrastra el archivo</p>
                                <p class="text-xs text-gray-400 mt-2">PDF (Max. 5MB)</p>
                            </div>
                        </div>

                        <!-- Convenio Firmado -->
                        <div>
                            <label class="text-sm font-semibold text-gray-700">Convenio Firmado <span class="text-gray-400">(Opcional)</span></label>
                            <div class="mt-3 rounded-xl border border-dashed border-[#c0e6af] bg-[#fcfdfa] p-8 text-center text-sm text-gray-500 transition hover:bg-[#f6faf1] hover:border-[#8cc772] cursor-pointer">
                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-white text-gray-400 shadow-sm mb-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h10M7 11h10M7 15h6"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 3h3.5a1.5 1.5 0 011.5 1.5V9"/>
                                    </svg>
                                </div>
                                <p class="font-medium text-gray-700">Haz clic para subir o arrastra el archivo</p>
                                <p class="text-xs text-gray-400 mt-2">PDF (Max. 5MB)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Nota Informativa -->
                    <div class="rounded-xl border border-[#f2e5c9] bg-[#fffbf1] p-4 text-sm text-gray-750">
                        <p><span class="font-semibold text-amber-800">Nota:</span> Una vez enviada la solicitud, será revisada por el coordinador. Recibirás una notificación con la respuesta en 2-3 días hábiles.</p>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between items-center pt-4">
                        <a href="{{ route('estudiante.nuevaSolicitudDetalles') }}" class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-6 py-2.5 text-sm font-semibold text-gray-600 shadow-sm transition hover:bg-gray-50">
                            <span class="mr-2 font-bold">&lt;</span> Anterior
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#a2d98a] hover:bg-[#8cc772] px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-250">
                            Enviar Solicitud
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
