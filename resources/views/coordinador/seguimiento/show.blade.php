@extends('layouts.coordinador', ['active' => 'seguimiento', 'title' => 'Detalle Seguimiento - Coordinador'])

@section('content')
    <!-- Back Navigation -->
    <div class="mb-6 text-left animate-fade-in">
        <a href="{{ route('coordinador.seguimiento') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-50 border border-gray-200 hover:border-[#6BA53A] text-gray-700 hover:text-[#4E7D24] rounded-2xl text-xs font-bold transition-all shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Regresar al Listado
        </a>
    </div>

    <!-- Success / Error Alerts -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl flex items-center gap-3 font-semibold text-sm animate-fade-in">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Student Header Summary -->
    @php
        $wordsShow = explode(' ', trim($student['nombre_completo']));
        $initialsShow = strtoupper(substr($wordsShow[0] ?? 'A', 0, 1) . (isset($wordsShow[1]) ? substr($wordsShow[1], 0, 1) : ''));
    @endphp
    <div class="glass-card rounded-3xl p-6 md:p-8 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 border border-gray-100 shadow-sm fade-in-up delay-100">
        <div class="flex items-center gap-4">
            <div class="h-14 w-14 rounded-full bg-gradient-to-tr from-[#4E7D24] to-[#6BA53A] text-white flex items-center justify-center font-extrabold text-lg shadow-md select-none">
                {{ $initialsShow }}
            </div>
            <div class="text-left">
                <h1 class="text-xl font-extrabold text-gray-900 uppercase leading-none">{{ $student['nombre_completo'] }}</h1>
                <p class="text-xs text-gray-500 font-semibold mt-2">Matrícula: <span class="text-gray-800 font-bold">{{ $student['matricula'] }}</span> | Periodo: <span class="text-gray-800 font-bold">{{ $student['fecha_inicio'] }} - {{ $student['fecha_termino'] }}</span></p>
            </div>
        </div>
        <div>
            @if($student['estatus'] === 'ACREDITADO')
                <span class="px-4 py-2 inline-flex text-xs font-bold leading-5 rounded-full bg-green-50 text-green-700 border border-green-200 uppercase tracking-widest shadow-sm">
                    ESTATUS: ACREDITADO
                </span>
            @else
                <span class="px-4 py-2 inline-flex text-xs font-bold leading-5 rounded-full bg-yellow-50 text-yellow-700 border border-yellow-200 uppercase tracking-widest shadow-sm">
                    ESTATUS: EN PROCESO
                </span>
            @endif
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8 fade-in-up delay-200">
        
        <!-- Left 2 Columns: Project details -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Ficha del Proyecto -->
            <div class="glass-card rounded-3xl p-6 md:p-8 border border-gray-100 shadow-sm text-left">
                <h2 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2 border-b border-gray-100 pb-3">
                    <svg class="w-5 h-5 text-[#6BA53A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Información del Proyecto Asignado
                </h2>
                
                <div class="space-y-4 text-xs">
                    <div>
                        <span class="text-[10px] text-gray-400 block font-bold uppercase tracking-wider">Título del Proyecto</span>
                        <span class="font-extrabold text-gray-800 text-sm uppercase leading-tight">{{ $student['titulo_proyecto'] }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-gray-400 block font-bold uppercase tracking-wider">Descripción del Proyecto</span>
                        <p class="text-gray-600 font-medium leading-relaxed text-justify">{{ $student['proyecto_detalle']['descripcion'] }}</p>
                    </div>
                    <div>
                        <span class="text-[10px] text-gray-400 block font-bold uppercase tracking-wider">Objetivo</span>
                        <p class="text-gray-600 font-medium leading-relaxed text-justify">{{ $student['proyecto_detalle']['objetivo'] }}</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <span class="text-[10px] text-gray-400 block font-bold uppercase tracking-wider">Justificación</span>
                            <p class="text-gray-600 font-medium leading-relaxed text-justify">{{ $student['proyecto_detalle']['justificacion'] }}</p>
                        </div>
                        <div>
                            <span class="text-[10px] text-gray-400 block font-bold uppercase tracking-wider">Actividades</span>
                            <p class="text-gray-600 font-medium leading-relaxed text-justify">{{ $student['proyecto_detalle']['actividades'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Institution & Observaciones -->
        <div class="space-y-8">
            <!-- Institución / Unidad Receptora -->
            <div class="glass-card rounded-3xl p-6 border border-gray-100 shadow-sm text-left">
                <h2 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2 border-b border-gray-100 pb-3">
                    <svg class="w-5 h-5 text-[#6BA53A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Institución / Unidad Receptora
                </h2>
                
                <div class="space-y-3 text-xs">
                    <div>
                        <span class="text-[10px] text-gray-400 block font-bold uppercase tracking-wider">Institución</span>
                        <span class="font-bold text-gray-800 uppercase leading-snug block">{{ $student['institucion'] }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-gray-400 block font-bold uppercase tracking-wider">Unidad Receptora</span>
                        <span class="font-bold text-gray-800 uppercase leading-snug block">{{ $student['unidad_receptora'] }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-gray-400 block font-bold uppercase tracking-wider">Titular</span>
                        <span class="font-bold text-gray-800 uppercase leading-snug block">{{ $student['proyecto_detalle']['titular'] }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-gray-400 block font-bold uppercase tracking-wider">Domicilio</span>
                        <span class="font-bold text-gray-800 leading-snug block">{{ $student['proyecto_detalle']['domicilio'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Observaciones del Coordinador (Notes) -->
            <div class="glass-card rounded-3xl p-6 border border-gray-100 shadow-sm text-left">
                <h2 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2 border-b border-gray-100 pb-3">
                    <svg class="w-5 h-5 text-[#6BA53A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Observaciones y Folio Oficial
                </h2>
                
                <form action="{{ route('coordinador.seguimiento.save-notes', $student['id']) }}" method="POST" class="m-0 space-y-4">
                    @csrf
                    <div>
                        <label for="notes" class="sr-only">Comentarios de observaciones</label>
                        <textarea id="notes" name="notes" rows="6" class="block w-full px-3 py-2 text-xs border border-gray-200 rounded-2xl bg-white/50 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] focus:outline-none placeholder-gray-400 font-medium" placeholder="Escribe el folio y notas oficiales aquí...">{{ $student['folio_observaciones'] }}</textarea>
                    </div>
                    <div>
                        <button type="submit" class="w-full py-2 bg-[#4E7D24] hover:bg-[#2E5417] text-white rounded-xl text-xs font-bold transition-all shadow-md">
                            Guardar Observaciones
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Document Repository Section (Pills at the bottom) -->
    <div class="glass-card rounded-3xl p-6 md:p-8 text-left fade-in-up delay-300 mb-8">
        <h2 class="text-base font-bold text-gray-800 mb-6 flex items-center gap-2 border-b border-gray-100 pb-3">
            <svg class="w-5 h-5 text-[#6BA53A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Expediente de Documentos del Estudiante
        </h2>
        
        <!-- Dynamic list of 6 standard student documents -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
            @foreach($student['documentos'] as $docKey => $doc)
                @php
                    $estatus = is_array($doc) ? ($doc['estatus'] ?? 'Sin Subir') : (string)$doc;
                    $label = is_array($doc) ? ($doc['label'] ?? ucwords(str_replace('_', ' ', $docKey))) : ucwords(str_replace('_', ' ', $docKey));
                    $url = is_array($doc) ? ($doc['url'] ?? null) : null;
                    $fecha = is_array($doc) ? ($doc['fecha'] ?? null) : null;

                    $colorClasses = match($estatus) {
                        'Aceptada', 'Validado', 'Aprobado' => 'border-green-300 bg-green-50/80 text-green-900 hover:bg-green-100 hover:border-green-400',
                        'Pendiente', 'En Revisión' => 'border-amber-300 bg-amber-50/80 text-amber-900 hover:bg-amber-100 hover:border-amber-400',
                        'Rechazada', 'Rechazado' => 'border-red-300 bg-red-50/80 text-red-900 hover:bg-red-100 hover:border-red-400',
                        default => 'border-gray-200 bg-gray-50/50 text-gray-400 cursor-not-allowed opacity-75',
                    };

                    $badgeBg = match($estatus) {
                        'Aceptada', 'Validado', 'Aprobado' => 'bg-green-600 text-white',
                        'Pendiente', 'En Revisión' => 'bg-amber-500 text-white',
                        'Rechazada', 'Rechazado' => 'bg-red-500 text-white',
                        default => 'bg-gray-200 text-gray-500',
                    };
                @endphp

                <div class="relative group">
                    @if($url)
                        <a href="{{ $url }}" target="_blank" title="Abrir/Descargar {{ $label }}" class="w-full flex flex-col justify-between p-3.5 border {{ $colorClasses }} rounded-2xl shadow-sm hover:shadow-md transition-all text-xs font-bold min-h-[82px] group">
                            <div class="flex items-start justify-between gap-1">
                                <span class="leading-tight group-hover:underline">{{ $label }}</span>
                                <svg class="w-4 h-4 text-green-700 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </div>
                            <div class="flex items-center justify-between mt-2 pt-2 border-t border-black/5">
                                <span class="text-[9px] font-extrabold uppercase px-2 py-0.5 rounded-full {{ $badgeBg }}">
                                    {{ $estatus }}
                                </span>
                                @if($fecha)
                                    <span class="text-[9px] text-gray-500 font-semibold">{{ $fecha }}</span>
                                @endif
                            </div>
                        </a>
                    @else
                        <div class="w-full flex flex-col justify-between p-3.5 border {{ $colorClasses }} rounded-2xl text-xs font-bold min-h-[82px]">
                            <div class="flex items-start justify-between gap-1">
                                <span class="leading-tight">{{ $label }}</span>
                                <svg class="w-4 h-4 text-gray-400 opacity-50 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <div class="flex items-center justify-between mt-2 pt-2 border-t border-black/5">
                                <span class="text-[9px] font-extrabold uppercase px-2 py-0.5 rounded-full {{ $badgeBg }}">
                                    Sin Subir
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection
