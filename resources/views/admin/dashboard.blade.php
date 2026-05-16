@extends('layouts.admin', ['title' => 'Dashboard Administrador - Prácticas Profesionales UdeC', 'active' => 'dashboard'])

@section('content')
    <!-- Welcome Header -->
    <x-page-header title="Panel de Administración" description="Monitoreo general y gestión del sistema de prácticas.">
        <x-slot:actions>
            <button class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Nuevo Coordinador
            </button>
        </x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Metrics & Users (60%) -->
        <div class="lg:col-span-2 flex flex-col gap-8">
            <!-- Metrics Grid -->
            @include('admin.metrics')

            <!-- User Management Shortcut -->
            @include('admin.gestuser')

        </div>

        <!-- Right Column: System Logs (40%) -->
        <div class="flex flex-col gap-8 h-full">

            @include('admin.logs')

        </div>
    </div>
@endsection
