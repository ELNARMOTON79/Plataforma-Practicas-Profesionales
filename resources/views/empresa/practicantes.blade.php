@extends('layouts.empresa', ['title' => 'Practicantes - Prácticas Profesionales UdeC', 'active' => 'practicantes'])

@php
    $estatusInfo = [
        'aprobada'   => ['Por iniciar', 'bg-amber-50 text-amber-700 border-amber-200'],
        'en_proceso' => ['En curso', 'bg-blue-50 text-blue-700 border-blue-200'],
        'finalizada' => ['Concluida', 'bg-green-50 text-green-700 border-green-200'],
    ];
@endphp

@section('content')
    <x-page-header title="Practicantes" description="Consulta a los alumnos que realizan sus prácticas en tu empresa y registra sus horas semanales." />

    @if(session('success'))
        <div class="glass-card rounded-2xl px-5 py-3 text-sm font-semibold text-green-700 border border-green-200 bg-green-50/80">{{ session('success') }}</div>
    @endif

    @if($solicitudes->isEmpty())
        <div class="glass-card rounded-3xl p-10 text-center fade-in-up">
            <p class="text-base font-bold text-gray-800">Aún no tienes practicantes</p>
            <p class="text-sm text-gray-500 mt-1">Cuando el coordinador apruebe la solicitud de un alumno en tu empresa, aparecerá aquí.</p>
        </div>
    @else
        <div class="glass-card rounded-3xl overflow-hidden fade-in-up delay-100">
            <div class="overflow-x-auto">
                <table class="min-w-[860px] w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50/60">
                        <tr class="text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-4">Alumno</th>
                            <th class="px-6 py-4">Unidad receptora</th>
                            <th class="px-6 py-4">Periodo</th>
                            <th class="px-6 py-4">Avance de horas</th>
                            <th class="px-6 py-4">Estatus</th>
                            <th class="px-6 py-4"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($solicitudes as $solicitud)
                            @php
                                $meta = $solicitud->horasMeta();
                                $horas = $solicitud->horasCompletadas();
                                $porcentaje = $meta > 0 ? min(100, round($horas / $meta * 100)) : 0;
                                [$etiqueta, $clase] = $estatusInfo[$solicitud->estatus] ?? [$solicitud->estatus, 'bg-gray-50 text-gray-600 border-gray-200'];
                                $docsOk = $solicitud->documentosInicialesValidados();
                            @endphp
                            <tr class="hover:bg-[#6BA53A]/5 transition-colors">
                                <td class="px-6 py-4 min-w-[220px]">
                                    <p class="text-sm font-bold text-gray-900">{{ $solicitud->estudiante?->nombre_completo ?? 'Alumno sin perfil' }}</p>
                                    <p class="text-xs text-gray-500">{{ $solicitud->estudiante?->matricula }} · {{ $solicitud->estudiante?->carrera }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $solicitud->unidadReceptora?->unidad_receptora ?: 'General' }}</td>
                                <td class="px-6 py-4 text-xs text-gray-600 whitespace-nowrap">
                                    {{ $solicitud->fecha_inicio?->format('d/m/Y') }} – {{ $solicitud->fecha_fin?->format('d/m/Y') }}
                                    <span class="block text-gray-400">{{ $solicitud->horasPorDia() }} h por día</span>
                                </td>
                                <td class="px-6 py-4 min-w-[180px]">
                                    @if($docsOk)
                                        <div class="flex justify-between text-xs font-bold text-gray-700 mb-1">
                                            <span>{{ rtrim(rtrim(number_format($horas, 2), '0'), '.') }} / {{ $meta }} h</span>
                                            <span>{{ $porcentaje }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                                            <div class="bg-[#6BA53A] h-full rounded-full" style="width: {{ $porcentaje }}%"></div>
                                        </div>
                                    @else
                                        <span class="text-xs text-amber-700 font-semibold">Esperando validación de documentos iniciales</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 inline-flex whitespace-nowrap text-[11px] font-bold rounded-lg border {{ $clase }}">{{ $etiqueta }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('empresa.practicantes.show', $solicitud->id) }}" class="inline-flex items-center gap-1 bg-[#4E7D24] hover:bg-[#2E5417] text-white text-xs font-bold px-4 py-2 rounded-xl transition-colors">
                                        {{ $docsOk ? 'Registrar horas' : 'Ver detalle' }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
