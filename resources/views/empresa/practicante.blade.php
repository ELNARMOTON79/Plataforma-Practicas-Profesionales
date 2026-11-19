@extends('layouts.empresa', ['title' => 'Horas del Practicante - Prácticas Profesionales UdeC', 'active' => 'practicantes'])

@php
    $meta = $solicitud->horasMeta();
    $horas = $solicitud->horasCompletadas();
    $porcentaje = $meta > 0 ? min(100, round($horas / $meta * 100)) : 0;
    $formatoHoras = fn ($h) => rtrim(rtrim(number_format((float) $h, 2), '0'), '.');
    $documentosRequeridos = ['Carta de Presentación', 'Carta de Aceptación', 'Plan de Trabajo', 'Memoria de Prácticas', 'Evaluación de Desempeño', 'Carta de Término'];
    $estadoDoc = function ($nombre) use ($solicitud) {
        $doc = $solicitud->documentos->first(fn ($d) => mb_strtolower(trim($d->nombre_doc)) === mb_strtolower($nombre));
        return match (true) {
            ! $doc => ['Sin subir', 'text-gray-500 bg-gray-50 border-gray-200'],
            in_array($doc->estatus, ['validado', 'aprobado'], true) => ['Validado', 'text-green-700 bg-green-50 border-green-200'],
            $doc->estatus === 'rechazado' => ['Rechazado', 'text-red-700 bg-red-50 border-red-200'],
            default => ['En revisión', 'text-amber-700 bg-amber-50 border-amber-200'],
        };
    };
    $semanasRegistradas = $semanas->whereNotNull('registradas')->count();
@endphp

@section('content')
    <div>
        <a href="{{ route('empresa.practicantes') }}" class="text-xs font-bold text-[#4E7D24] hover:underline">← Volver a practicantes</a>
    </div>

    <x-page-header :title="$solicitud->estudiante?->nombre_completo ?? 'Practicante'"
        :description="collect([$solicitud->estudiante?->matricula, $solicitud->estudiante?->carrera, $solicitud->unidadReceptora?->unidad_receptora ?: 'General'])->filter()->implode(' · ')" />

    @if(session('success'))
        <div class="glass-card rounded-2xl px-5 py-3 text-sm font-semibold text-green-700 border border-green-200 bg-green-50/80">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="glass-card rounded-2xl px-5 py-3 text-sm font-semibold text-red-700 border border-red-200 bg-red-50/80">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="glass-card rounded-2xl px-5 py-3 text-sm font-semibold text-red-700 border border-red-200 bg-red-50/80">{{ $errors->first() }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Avance y documentos --}}
        <div class="flex flex-col gap-6">
            <div class="glass-card rounded-3xl p-6 fade-in-up">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Avance de horas</h3>
                <div class="flex items-baseline gap-1">
                    <span class="text-4xl font-extrabold text-gray-900">{{ $formatoHoras($horas) }}</span>
                    <span class="text-sm font-medium text-gray-500">/ {{ $meta }} horas</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden mt-3">
                    <div class="bg-[#6BA53A] h-full rounded-full" style="width: {{ $porcentaje }}%"></div>
                </div>
                <dl class="mt-4 space-y-2 text-xs text-gray-700">
                    <div class="flex justify-between"><dt class="text-gray-400 font-bold">Horas por día</dt><dd>{{ $solicitud->horasPorDia() }} h</dd></div>
                    <div class="flex justify-between"><dt class="text-gray-400 font-bold">Horas restantes</dt><dd>{{ $formatoHoras(max(0, $meta - $horas)) }} h</dd></div>
                    <div class="flex justify-between"><dt class="text-gray-400 font-bold">Semanas registradas</dt><dd>{{ $semanasRegistradas }} de {{ $semanas->count() }}</dd></div>
                    <div class="flex justify-between"><dt class="text-gray-400 font-bold">Periodo</dt><dd>{{ $solicitud->fecha_inicio?->format('d/m/Y') }} – {{ $solicitud->fecha_fin?->format('d/m/Y') }}</dd></div>
                </dl>
                <p class="text-[11px] text-gray-400 italic mt-3">La fecha de término es estimada. Las semanas sin registrar no cuentan para el avance.</p>
            </div>

            <div class="glass-card rounded-3xl p-6 fade-in-up delay-100">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Documentos</h3>
                <ul class="space-y-2">
                    @foreach($documentosRequeridos as $nombre)
                        @php [$etiqueta, $clase] = $estadoDoc($nombre); @endphp
                        <li class="flex items-center justify-between gap-2 text-xs">
                            <span class="font-semibold text-gray-700">{{ $nombre }}</span>
                            <span class="px-2 py-0.5 rounded-md border font-bold {{ $clase }}">{{ $etiqueta }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Registro semanal --}}
        <div class="lg:col-span-2 glass-card rounded-3xl p-6 fade-in-up delay-100">
            <h3 class="text-lg font-bold text-gray-900">Registro semanal de horas</h3>
            <p class="text-xs text-gray-500 mt-1 mb-4">
                Se propone días hábiles × {{ $solicitud->horasPorDia() }} h. Ajusta el número si el alumno faltó o hizo horas de más, y presiona <strong>Registrar</strong>.
            </p>

            @if(! $puedeRegistrar)
                <div class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800 font-medium">
                    @if($solicitud->estatus === 'aprobada')
                        Las prácticas de este alumno aún no inician ({{ $solicitud->fecha_inicio?->format('d/m/Y') }}).
                    @else
                        Podrás registrar horas cuando el coordinador valide los documentos iniciales del alumno (Carta de Presentación, Carta de Aceptación y Plan de Trabajo).
                    @endif
                </div>
            @elseif($semanas->isEmpty())
                <p class="text-sm text-gray-500">Todavía no hay semanas para registrar.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">
                                <th class="py-3 pr-4">Semana</th>
                                <th class="py-3 pr-4">Días hábiles</th>
                                <th class="py-3 pr-4">Estado</th>
                                <th class="py-3">Horas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($semanas as $semana)
                                @php $registrada = $semana['registradas'] !== null; @endphp
                                <tr>
                                    <td class="py-3 pr-4 whitespace-nowrap">
                                        <span class="font-semibold text-gray-800">{{ $semana['inicio']->format('d/m') }} – {{ $semana['fin']->format('d/m/Y') }}</span>
                                    </td>
                                    <td class="py-3 pr-4 text-gray-600">{{ $semana['dias'] }} <span class="text-xs text-gray-400">(sugerido {{ $semana['sugeridas'] }} h)</span></td>
                                    <td class="py-3 pr-4">
                                        @if($registrada)
                                            <span class="px-2 py-0.5 rounded-md border text-[11px] font-bold text-green-700 bg-green-50 border-green-200">Registrada</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-md border text-[11px] font-bold text-gray-500 bg-gray-50 border-gray-200">Sin registrar</span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        <form method="POST" action="{{ route('empresa.practicantes.horas', $solicitud->id) }}" class="flex items-center gap-2">
                                            @csrf
                                            <input type="hidden" name="semana" value="{{ $semana['inicio']->toDateString() }}">
                                            <input type="number" name="horas" min="0" max="60" step="0.5" required
                                                value="{{ $registrada ? $formatoHoras($semana['registradas']) : $semana['sugeridas'] }}"
                                                aria-label="Horas de la semana del {{ $semana['inicio']->format('d/m/Y') }}"
                                                class="w-20 px-2 py-1.5 border border-gray-200 rounded-lg text-sm font-semibold focus:ring-2 focus:ring-[#6BA53A] focus:border-transparent outline-none">
                                            <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors {{ $registrada ? 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' : 'bg-[#4E7D24] text-white hover:bg-[#2E5417]' }}">
                                                {{ $registrada ? 'Actualizar' : 'Registrar' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
