@extends('layouts.estudiante', ['title' => 'Mi Perfil - Prácticas Profesionales UdeC', 'active' => 'perfil'])

@section('content')

    {{-- Server-side alerts --}}
    <x-estudiante.alert-flash />

    @include('estudiante.perfil._header')
    @include('estudiante.perfil._password-form')
    @include('estudiante.perfil._academic-info')

@endsection

@include('estudiante.perfil._scripts')
