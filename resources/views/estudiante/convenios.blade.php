@extends('layouts.estudiante', ['title' => 'Convenios Disponibles - Prácticas Profesionales UdeC', 'active' => 'convenios'])

@section('content')
    <!-- Page Header -->
    <x-page-header title="Empresas y Convenios" description="Consulta las empresas vinculadas y solicita tu participación en proyectos de prácticas profesionales."></x-page-header>

    @include('estudiante.convenios._search')

    @if($unidades->isEmpty())
        @include('estudiante.convenios._empty-state')
    @else
        @include('estudiante.convenios._list')
    @endif
@endsection
