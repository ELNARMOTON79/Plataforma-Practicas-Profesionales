@extends('layouts.empresa', ['title' => 'Convenio - Prácticas Profesionales UdeC', 'active' => 'convenios'])

@section('content')
    <x-page-header title="Convenio Institucional" description="Estado de tu convenio de prácticas profesionales con la Universidad de Colima." />

    @if($convenio)
        <div class="glass-card rounded-3xl p-8 fade-in-up delay-100">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Folio del convenio</span>
                    <p class="text-3xl font-extrabold text-gray-900">{{ $folio }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $empresa }}</p>
                </div>
                <span class="self-start sm:self-center inline-flex items-center gap-2 px-4 py-2 rounded-2xl border text-sm font-bold text-green-700 bg-green-50 border-green-200">
                    <span class="w-2 h-2 rounded-full bg-green-500"></span> Aprobado
                </span>
            </div>

            <div class="mt-6">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-2">Unidades receptoras incluidas</h3>
                <ul class="divide-y divide-gray-100">
                    @foreach($unidades as $ur)
                        <li class="py-2 text-sm">
                            <span class="font-semibold text-gray-800">{{ $ur->unidad_receptora ?: 'General' }}</span>
                            <span class="block text-xs text-gray-500">{{ collect([$ur->direccion, $ur->municipio, $ur->estado])->filter()->implode(', ') }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @else
        <div class="glass-card rounded-3xl p-10 text-center fade-in-up">
            <p class="text-base font-bold text-gray-800">Sin convenio registrado</p>
            <p class="text-sm text-gray-500 mt-1">Comunícate con la coordinación de prácticas profesionales para registrar tu convenio.</p>
        </div>
    @endif
@endsection
