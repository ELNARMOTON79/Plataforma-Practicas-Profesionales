@extends('layouts.empresa', ['title' => 'Reportes - Prácticas Profesionales UdeC', 'active' => 'reportes'])

@php
    $formatoHoras = fn ($h) => rtrim(rtrim(number_format((float) $h, 2), '0'), '.');
    $hayFiltros = collect($filtros)->filter()->isNotEmpty();
@endphp

@section('content')
    <x-page-header title="Reportes y Estadísticas" description="Información de tus practicantes, filtrada por carrera, género, periodo y proyecto.">
        <x-slot name="actions">
            <div class="flex gap-2 no-print">
                <a href="{{ route('empresa.reportes', array_merge(collect($filtros)->filter()->all(), ['formato' => 'csv'])) }}" hx-boost="false"
                    class="bg-[#4E7D24] hover:bg-[#2E5417] text-white text-sm font-bold py-2.5 px-4 rounded-2xl transition-colors">Descargar Excel (CSV)</a>
                <button type="button" onclick="window.print()"
                    class="bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-bold py-2.5 px-4 rounded-2xl transition-colors">Imprimir / PDF</button>
            </div>
        </x-slot>
    </x-page-header>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('empresa.reportes') }}" class="glass-card rounded-3xl p-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end no-print fade-in-up">
        @foreach([
            'carrera' => ['Carrera', $opciones['carreras']],
            'genero' => ['Género', collect(['Femenino', 'Masculino'])],
            'periodo' => ['Periodo', $opciones['periodos']],
            'proyecto' => ['Proyecto', $opciones['proyectos']],
        ] as $campo => [$etiqueta, $valores])
            <label class="block">
                <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">{{ $etiqueta }}</span>
                <select name="{{ $campo }}" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 focus:ring-2 focus:ring-[#6BA53A] outline-none">
                    <option value="">Todos</option>
                    @foreach($valores as $valor)
                        <option value="{{ $valor }}" @selected(($filtros[$campo] ?? '') === $valor)>{{ $valor }}</option>
                    @endforeach
                </select>
            </label>
        @endforeach
        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-[#4E7D24] hover:bg-[#2E5417] text-white text-sm font-bold py-2 px-4 rounded-xl transition-colors">Filtrar</button>
            @if($hayFiltros)
                <a href="{{ route('empresa.reportes') }}" class="px-3 py-2 text-sm font-bold text-gray-500 hover:text-gray-800">Limpiar</a>
            @endif
        </div>
    </form>

    {{-- Estadísticas --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 fade-in-up delay-100">
        @foreach([
            ['Practicantes', $estadisticas['total']],
            ['Horas registradas', $formatoHoras($estadisticas['horas'])],
            ['Avance promedio', $estadisticas['avancePromedio'] . '%'],
            ['Concluidos', $estadisticas['concluidos']],
        ] as [$titulo, $valor])
            <div class="glass-card rounded-3xl p-5">
                <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider">{{ $titulo }}</span>
                <span class="text-3xl font-extrabold text-gray-900">{{ $valor }}</span>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 fade-in-up delay-100">
        @foreach(['Por carrera' => $estadisticas['porCarrera'], 'Por género' => $estadisticas['porGenero']] as $titulo => $conteo)
            <div class="glass-card rounded-3xl p-5">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">{{ $titulo }}</h3>
                @forelse($conteo as $etiqueta => $n)
                    @php $pct = $estadisticas['total'] ? round($n / $estadisticas['total'] * 100) : 0; @endphp
                    <div class="mb-2">
                        <div class="flex justify-between text-xs font-bold text-gray-600 mb-1"><span>{{ $etiqueta }}</span><span>{{ $n }} ({{ $pct }}%)</span></div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden"><div class="bg-[#6BA53A] h-full rounded-full" style="width: {{ $pct }}%"></div></div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Sin datos.</p>
                @endforelse
            </div>
        @endforeach
    </div>

    {{-- Detalle --}}
    <div class="glass-card rounded-3xl overflow-hidden fade-in-up delay-200">
        <div class="overflow-x-auto">
            <table class="min-w-[900px] w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-gray-50/60">
                    <tr class="text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                        <th class="px-5 py-3">Alumno</th>
                        <th class="px-5 py-3">Carrera</th>
                        <th class="px-5 py-3">Género</th>
                        <th class="px-5 py-3">Periodo</th>
                        <th class="px-5 py-3">Proyecto</th>
                        <th class="px-5 py-3">Horas</th>
                        <th class="px-5 py-3">Estatus</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($filtradas as $f)
                        <tr>
                            <td class="px-5 py-3"><span class="font-bold text-gray-900">{{ $f['alumno'] }}</span><span class="block text-xs text-gray-500">{{ $f['matricula'] }}</span></td>
                            <td class="px-5 py-3 text-gray-700">{{ $f['carrera'] }}</td>
                            <td class="px-5 py-3 text-gray-700">{{ $f['genero'] }}</td>
                            <td class="px-5 py-3 text-gray-700 whitespace-nowrap">{{ $f['periodo'] }}</td>
                            <td class="px-5 py-3 text-gray-700">{{ $f['proyecto'] }}</td>
                            <td class="px-5 py-3 text-gray-700 whitespace-nowrap">{{ $formatoHoras($f['horas']) }} / {{ $f['meta'] }} ({{ $f['avance'] }}%)</td>
                            <td class="px-5 py-3 text-gray-700">{{ $f['estatus'] }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-5 py-8 text-center text-gray-500">No hay practicantes con los filtros seleccionados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        @media print {
            nav, .no-print { display: none !important; }
            body { background: #fff !important; }
            .glass-card { box-shadow: none !important; border: 1px solid #ddd !important; }
        }
    </style>
@endsection
