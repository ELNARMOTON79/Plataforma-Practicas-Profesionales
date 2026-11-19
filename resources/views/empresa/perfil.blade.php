@extends('layouts.empresa', ['title' => 'Mi Perfil - Prácticas Profesionales UdeC', 'active' => 'perfil'])

@section('content')
    <x-page-header title="Mi Perfil" description="Datos de tu empresa y seguridad de tu cuenta." />

    @if(session('success'))
        <div class="glass-card rounded-2xl px-5 py-3 text-sm font-semibold text-green-700 border border-green-200 bg-green-50/80">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Datos de la empresa (los administra la coordinación) --}}
        <div class="glass-card rounded-3xl p-6 fade-in-up">
            <h3 class="text-lg font-bold text-gray-900">{{ $empresa }}</h3>
            <p class="text-sm text-gray-500 mb-4">{{ auth()->user()->correo }}</p>

            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Unidades receptoras</h4>
            <ul class="space-y-3">
                @forelse($unidades as $ur)
                    <li class="rounded-2xl bg-white/60 border border-gray-100 px-4 py-3 text-sm">
                        <p class="font-bold text-gray-900">{{ $ur->unidad_receptora ?: 'General' }}</p>
                        <p class="text-gray-600">{{ $ur->titular }}{{ $ur->cargo ? ' · ' . $ur->cargo : '' }}</p>
                        <p class="text-xs text-gray-500">{{ collect([$ur->direccion, $ur->colonia, $ur->municipio, $ur->estado])->filter()->implode(', ') }}</p>
                        @if($ur->telefono)<p class="text-xs text-gray-500">Tel. {{ $ur->telefono }}</p>@endif
                    </li>
                @empty
                    <li class="text-sm text-gray-500">Sin unidades registradas.</li>
                @endforelse
            </ul>
            <p class="text-[11px] text-gray-400 italic mt-4">Estos datos los administra la coordinación de prácticas. Si necesitas corregir algo, comunícate con ellos.</p>
        </div>

        {{-- Cambio de contraseña --}}
        <form method="POST" action="{{ route('empresa.perfil.password') }}" class="glass-card rounded-3xl p-6 fade-in-up delay-100 flex flex-col gap-4">
            @csrf
            <div>
                <h3 class="text-lg font-bold text-gray-900">Cambiar contraseña</h3>
                <p class="text-sm text-gray-500">Al cambiarla se cerrará tu sesión en otros dispositivos.</p>
            </div>

            @foreach(['current_password' => 'Contraseña actual', 'password' => 'Nueva contraseña', 'password_confirmation' => 'Confirmar nueva contraseña'] as $campo => $etiqueta)
                <label class="block">
                    <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">{{ $etiqueta }}</span>
                    <input type="password" name="{{ $campo }}" required {{ $campo !== 'current_password' ? 'minlength=8' : '' }} autocomplete="{{ $campo === 'current_password' ? 'current-password' : 'new-password' }}"
                        class="w-full px-3 py-2.5 bg-white border {{ $errors->has($campo) ? 'border-red-300' : 'border-gray-200' }} rounded-xl text-sm focus:ring-2 focus:ring-[#6BA53A] outline-none">
                    @error($campo)<span class="block text-xs text-red-600 mt-1">{{ $message }}</span>@enderror
                </label>
            @endforeach

            <button type="submit" class="self-end bg-[#4E7D24] hover:bg-[#2E5417] text-white text-sm font-bold py-2.5 px-5 rounded-xl transition-colors">Actualizar contraseña</button>
        </form>
    </div>
@endsection
