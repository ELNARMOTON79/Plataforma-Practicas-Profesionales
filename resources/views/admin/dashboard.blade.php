@extends('layouts.admin', ['title' => 'Dashboard Administrador - Prácticas Profesionales UdeC', 'active' => 'dashboard'])

@section('content')
    <!-- Welcome Header -->
    <x-page-header title="Panel de Administración" description="Monitoreo general y gestión del sistema de prácticas."></x-page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:items-stretch">
        <!-- Left Column: Metrics & Users (60%) -->
        <div class="lg:col-span-2 flex flex-col gap-8 h-full min-h-0">
            <!-- Metrics Grid -->
            @include('admin.metrics')

            <!-- User Management Shortcut -->
            @include('admin.gestuser')

        </div>

        <!-- Right Column: System Logs (40%) -->
        <div class="flex flex-col h-full min-h-0">

            @include('admin.logs')

        </div>
    </div>
@endsection
