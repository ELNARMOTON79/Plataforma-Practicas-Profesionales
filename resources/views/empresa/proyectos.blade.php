@extends('layouts.empresa', ['title' => 'Proyectos - Prácticas Profesionales UdeC', 'active' => 'proyectos'])

@section('content')
    <x-page-header title="Proyectos" description="Proyectos registrados por la coordinación para tus unidades receptoras y los alumnos asignados a cada uno." />

    @if($proyectos->isEmpty())
        <div class="glass-card rounded-3xl p-10 text-center fade-in-up">
            <p class="text-base font-bold text-gray-800">Aún no hay proyectos registrados</p>
            <p class="text-sm text-gray-500 mt-1">La coordinación de prácticas registra los proyectos de cada unidad receptora.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 fade-in-up delay-100">
            @foreach($proyectos as $proyecto)
                <div class="glass-card rounded-3xl p-6 flex flex-col gap-3">
                    <div class="flex items-start justify-between gap-3">
                        <h3 class="text-base font-bold text-gray-900">{{ $proyecto->titulo }}</h3>
                        <span class="shrink-0 px-2.5 py-1 rounded-lg border text-[11px] font-bold {{ $proyecto->activo ? 'text-green-700 bg-green-50 border-green-200' : 'text-gray-500 bg-gray-50 border-gray-200' }}">
                            {{ $proyecto->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 font-medium">
                        {{ collect([$proyecto->empresa?->unidad_receptora ?: 'General', $proyecto->tipo_proyecto, $proyecto->tipo_modalidad, $proyecto->ciclo_escolar])->filter()->implode(' · ') }}
                    </p>

                    <div class="rounded-2xl bg-white/60 border border-gray-100 px-4 py-3">
                        <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Alumno asignado</span>
                        @if($proyecto->estudiante)
                            <p class="text-sm font-bold text-gray-900">{{ $proyecto->estudiante->nombre_completo }}</p>
                            <p class="text-xs text-gray-500">{{ $proyecto->estudiante->matricula }} · {{ $proyecto->estudiante->carrera }}</p>
                        @else
                            <p class="text-sm text-gray-500">Sin alumno asignado</p>
                        @endif
                        <p class="text-[11px] text-gray-400 mt-1">Cupo: {{ $proyecto->cupos_ocupados }} de {{ $proyecto->cupos_totales }}</p>
                    </div>

                    <details class="group">
                        <summary class="cursor-pointer text-xs font-bold text-[#4E7D24] hover:underline list-none">Ver detalles del proyecto</summary>
                        <div class="mt-3 space-y-2 text-sm text-gray-700">
                            @foreach(['objetivo' => 'Objetivo', 'justificacion' => 'Justificación', 'actividades' => 'Actividades', 'impacto_social' => 'Impacto social'] as $campo => $etiqueta)
                                @if($proyecto->$campo)
                                    <div>
                                        <span class="block text-[11px] font-bold text-gray-400 uppercase tracking-wide">{{ $etiqueta }}</span>
                                        <p class="whitespace-pre-line">{{ $proyecto->$campo }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </details>
                </div>
            @endforeach
        </div>
    @endif
@endsection
