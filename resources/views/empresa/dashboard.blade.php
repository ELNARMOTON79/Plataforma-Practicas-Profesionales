@extends('layouts.empresa', ['title' => 'Dashboard Empresa - Prácticas Profesionales UdeC', 'active' => 'dashboard'])

@php
    $formatoHoras = fn ($h) => rtrim(rtrim(number_format((float) $h, 2), '0'), '.');
    $metricas = [
        ['Practicantes en curso', $practicantesEnCurso, 'Alumnos realizando sus prácticas', 'hover:border-blue-300'],
        ['Practicantes concluidos', $practicantesConcluidos, 'Alcanzaron su meta de horas', 'hover:border-green-300'],
        ['Horas registradas', $formatoHoras($horasRegistradas), 'Suma de horas de tus practicantes', 'hover:border-[#6BA53A]/40'],
        ['Proyectos', $proyectosCount, 'Registrados para tus unidades', 'hover:border-purple-300'],
    ];
@endphp

@section('content')
    <x-page-header :title="$empresa" description="Consulta a tus practicantes, sus proyectos y el estado de tu convenio con la Universidad de Colima." />

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 fade-in-up delay-100">
        @foreach($metricas as [$titulo, $valor, $detalle, $hover])
            <div class="glass-card rounded-3xl p-6 flex flex-col border-transparent {{ $hover }} transition-colors">
                <span class="text-sm font-bold text-gray-500 mb-2">{{ $titulo }}</span>
                <span class="text-4xl font-extrabold text-gray-900 mb-2">{{ $valor }}</span>
                <span class="text-xs text-gray-400 font-medium">{{ $detalle }}</span>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Practicantes en curso --}}
        <div class="lg:col-span-2 glass-card rounded-3xl p-6 fade-in-up delay-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Practicantes en curso</h3>
                <a href="{{ route('empresa.practicantes') }}" class="text-sm text-[#6BA53A] font-bold hover:text-[#4E7D24] transition-colors">Ver todos</a>
            </div>

            @forelse($recientes as $solicitud)
                @php
                    $meta = $solicitud->horasMeta();
                    $horas = $solicitud->horasCompletadas();
                    $porcentaje = $meta > 0 ? min(100, round($horas / $meta * 100)) : 0;
                @endphp
                <a href="{{ route('empresa.practicantes.show', $solicitud->id) }}" class="flex items-center gap-4 py-3 border-b border-gray-100 last:border-0 hover:bg-[#6BA53A]/5 rounded-xl px-2 transition-colors">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-900 truncate">{{ $solicitud->estudiante?->nombre_completo }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $solicitud->estudiante?->carrera }} · {{ $solicitud->unidadReceptora?->unidad_receptora ?: 'General' }}</p>
                    </div>
                    <div class="w-40 shrink-0">
                        <div class="flex justify-between text-[11px] font-bold text-gray-600 mb-1">
                            <span>{{ $formatoHoras($horas) }} / {{ $meta }} h</span><span>{{ $porcentaje }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-[#6BA53A] h-full rounded-full" style="width: {{ $porcentaje }}%"></div>
                        </div>
                    </div>
                </a>
            @empty
                <p class="text-sm text-gray-500 py-6 text-center">Aún no tienes practicantes en curso.</p>
            @endforelse
        </div>

        {{-- Convenio y unidades --}}
        <div class="flex flex-col gap-6">
            <div class="glass-card rounded-3xl p-6 fade-in-up delay-200">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Convenio</h3>
                @if($convenio)
                    <span class="inline-flex px-2.5 py-1 rounded-lg border text-xs font-bold text-green-700 bg-green-50 border-green-200">Vigente</span>
                    <p class="text-lg font-extrabold text-gray-900 mt-3">{{ $folio }}</p>
                    <a href="{{ route('empresa.convenios') }}" class="text-xs font-bold text-[#4E7D24] hover:underline">Ver convenio</a>
                @else
                    <p class="text-sm text-gray-500">Sin convenio registrado. Comunícate con la coordinación de prácticas.</p>
                @endif
            </div>

            <div class="glass-card rounded-3xl p-6 fade-in-up delay-300">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Mis unidades receptoras</h3>
                <ul class="space-y-2">
                    @forelse($unidades as $ur)
                        <li class="text-sm">
                            <span class="font-semibold text-gray-800">{{ $ur->unidad_receptora ?: 'General' }}</span>
                            <span class="block text-xs text-gray-500">{{ $ur->titular }}{{ $ur->cargo ? ' · ' . $ur->cargo : '' }}</span>
                        </li>
                    @empty
                        <li class="text-sm text-gray-500">Sin unidades registradas.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
