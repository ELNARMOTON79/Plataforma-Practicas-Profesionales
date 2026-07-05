{{--
    proyecto.blade.php — Orchestrator view (Mi Proyecto de Prácticas)
    ─────────────────────────────────────────────────────────────────
    Variables passed from DashboardController::proyecto():
      $solicitud, $horasCompletadas, $horasMeta, $porcentajeHoras,
      $horasFaltantes, $diasTranscurridos, $diasTotales,
      $totalDocsSubidos, $totalDocsMeta, $objetivosTexto, $actividadesLista

    Structure:
      @section('content')
        _empty-state   — shown when $solicitud is null
        _hero          — top banner with status + global stats
        _progress-card — column 1: circular SVG ring
        _work-plan-card — column 2: objectives + activities
        _company-card  — column 3: advisor + company info
        _expediente    — full-width phase-based digital folder
      @push('modals')
        _modal-upload  — file upload overlay
        _modal-pdf     — simulated PDF viewer overlay
      @push('scripts')
        _scripts       — all client-side JS for this view
--}}
@extends('layouts.estudiante', ['title' => 'Mi Proyecto de Prácticas - Prácticas Profesionales UdeC', 'active' => 'proyecto'])

@section('content')

    {{-- Toast notification (shared by upload and PDF events) --}}
    <div id="projectSuccessToast"
         class="hidden fixed top-5 right-5 z-[100] bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl shadow-xl max-w-md fade-in-up flex items-start gap-3">
        <div class="p-1 bg-green-100 text-green-600 rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <div>
            <h4 class="font-bold text-green-950 text-sm" id="toastTitle">¡Operación Exitosa!</h4>
            <p class="text-xs text-green-900/90 mt-0.5" id="toastMessage">Cambios aplicados correctamente en tu proyecto.</p>
        </div>
        <button onclick="document.getElementById('projectSuccessToast').classList.add('hidden')"
                class="text-green-500 hover:text-green-800 transition-colors ml-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    @if(!$solicitud)
        @include('estudiante.proyecto._empty-state')
    @else
        @include('estudiante.proyecto._hero')

        {{-- Top Summary Cards (2 columns) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-stretch mb-6">
            @include('estudiante.proyecto._progress-card')
            @include('estudiante.proyecto._company-card')
        </div>

        {{-- Full-width Work Plan Card --}}
        <div class="mb-6">
            @include('estudiante.proyecto._work-plan-card')
        </div>

        @include('estudiante.proyecto._expediente')
    @endif

@endsection

@push('modals')
    @include('estudiante.proyecto._modal-upload')
    @include('estudiante.proyecto._modal-pdf')
@endpush

@push('scripts')
    @include('estudiante.proyecto._scripts')
@endpush
