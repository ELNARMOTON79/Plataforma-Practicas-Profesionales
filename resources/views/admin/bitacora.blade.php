@extends('layouts.admin', ['title' => 'Bitácora del Sistema - Administrador UdeC', 'active' => 'bitacora'])

@section('content')
    <!-- Page Header Section -->
    <x-page-header title="Bitácora del Sistema" description="Monitoreo de actividades, auditoría de seguridad e historial de eventos en tiempo real.">
        <x-slot:actions>
            <div class="flex flex-wrap gap-2">
                <button type="button" onclick="exportLogs('CSV')" class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 px-4 py-2.5 rounded-xl text-sm font-bold shadow-sm hover:shadow transition-all flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Exportar CSV
                </button>
                <button type="button" onclick="exportLogs('PDF')" class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 px-4 py-2.5 rounded-xl text-sm font-bold shadow-sm hover:shadow transition-all flex items-center gap-2">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    Exportar PDF
                </button>
                <button type="button" onclick="openClearLogsConfirm()" class="bg-red-50 hover:bg-red-100 text-red-700 border border-red-100 px-4 py-2.5 rounded-xl text-sm font-bold shadow-sm transition-all flex items-center gap-2">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Limpiar Bitácora
                </button>
            </div>
        </x-slot>
    </x-page-header>

    @include('admin.bitacora.kpis')

    <!-- Filters & Main Panel -->
    <div class="glass-card rounded-3xl p-6 md:p-8 fade-in-up delay-200 relative z-30 flex-1 flex flex-col min-h-0">
        @include('admin.bitacora.filters')
        @include('admin.bitacora.table-view')
        @include('admin.bitacora.timeline-view')

        <!-- Vista Vacía (No results state) -->
        @if($logs->isEmpty())
            <div id="no-results-state" class="flex flex-col items-center justify-center py-16 text-center">
                <div class="h-16 w-16 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mb-4 border border-gray-100">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h4 class="text-base font-bold text-gray-900 mb-1">No se encontraron logs</h4>
                <p class="text-sm text-gray-500 max-w-xs mx-auto">Prueba cambiando los criterios de filtrado o buscando otros términos.</p>
            </div>
        @endif

        @if(!$logs->isEmpty())
            <!-- Dynamic Laravel Pagination -->
            <div id="pagination-panel" class="mt-6">
                {{ $logs->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    @push('modals')
        @include('admin.bitacora.detail-modal')
        @include('admin.bitacora.clear-modal')
    @endpush

    @include('admin.bitacora.scripts')
@endsection
