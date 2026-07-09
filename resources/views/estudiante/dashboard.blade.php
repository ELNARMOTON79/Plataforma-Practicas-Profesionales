@extends('layouts.estudiante', ['title' => 'Panel Estudiante - Prácticas Profesionales UdeC', 'active' => 'dashboard'])

@section('content')
    @include('estudiante.dashboard._header')

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch mt-6">
        
        <!-- Left 2 Columns -->
        <div class="lg:col-span-2 flex flex-col gap-6">
            @include('estudiante.dashboard._progress')
            @include('estudiante.dashboard._expediente-status')
        </div>

        <!-- Right Column: Request Details & Quick Links -->
        <div class="flex flex-col gap-6">
            @include('estudiante.dashboard._quick-links')
            @include('estudiante.dashboard._active-request')
        </div>
    </div>
@endsection
