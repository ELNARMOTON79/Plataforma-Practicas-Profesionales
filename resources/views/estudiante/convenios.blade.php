@extends('layouts.estudiante', ['title' => 'Convenios Disponibles - Prácticas Profesionales UdeC', 'active' => 'convenios'])

@section('content')
    <x-page-header title="Empresas y Convenios" description="Consulta las empresas vinculadas y solicita tu participación en proyectos de prácticas profesionales."></x-page-header>

    {{-- Search & Filters --}}
    <div class="glass-card rounded-3xl p-6 fade-in-up delay-100">
        <form method="GET" action="{{ route('estudiante.convenios') }}" id="convenios-form" class="flex flex-col gap-4">

            {{-- Search row --}}
            <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center">
                <div class="relative w-full">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" name="q" id="search-input" value="{{ $search }}"
                        class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl bg-white/70 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/20 focus:border-[#6BA53A] sm:text-sm transition-all shadow-sm"
                        placeholder="Buscar por empresa o dirección..."
                        autocomplete="off">
                    <p id="search-error" class="hidden absolute -bottom-5 left-1 text-xs text-red-500 font-medium"></p>
                </div>
                <button type="submit" onclick="return validateSearch()" class="shrink-0 px-6 py-3.5 bg-[#4E7D24] text-white text-sm font-semibold rounded-2xl hover:bg-[#3b6620] transition-all shadow-sm">
                    Buscar
                </button>
                @if($search || $carreraFilter)
                    <a href="{{ route('estudiante.convenios') }}" class="shrink-0 text-sm text-gray-500 hover:text-gray-700 font-medium whitespace-nowrap">
                        Limpiar filtros
                    </a>
                @endif
            </div>

            {{-- Carrera filter --}}
            @if($carreras->isNotEmpty())
            <div class="flex flex-wrap gap-2 items-center pt-1">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Filtrar por carrera:</span>
                <a href="{{ route('estudiante.convenios', array_filter(['q' => $search])) }}"
                    class="text-xs font-semibold px-3 py-1.5 rounded-xl border transition-all
                        {{ !$carreraFilter ? 'bg-[#4E7D24] text-white border-[#4E7D24]' : 'bg-white text-gray-600 border-gray-200 hover:border-[#4E7D24]/40 hover:text-[#4E7D24]' }}">
                    Todas
                </a>
                @foreach($carreras as $carrera)
                    <a href="{{ route('estudiante.convenios', array_filter(['q' => $search, 'carrera' => $carrera])) }}"
                        class="text-xs font-semibold px-3 py-1.5 rounded-xl border transition-all
                            {{ $carreraFilter === $carrera ? 'bg-[#4E7D24] text-white border-[#4E7D24]' : 'bg-white text-gray-600 border-gray-200 hover:border-[#4E7D24]/40 hover:text-[#4E7D24]' }}">
                        {{ $carrera }}
                    </a>
                @endforeach
            </div>
            @endif

        </form>
    </div>

    @if($unidades->isEmpty())
        <div class="glass-card rounded-3xl p-14 text-center fade-in-up delay-200">
            <svg class="w-14 h-14 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            <h3 class="text-lg font-bold text-gray-500">No se encontraron empresas</h3>
            <p class="text-sm text-gray-400 mt-1">
                @if($search && $carreraFilter)
                    Ninguna empresa de "{{ $carreraFilter }}" coincide con "{{ $search }}".
                @elseif($search)
                    Ninguna empresa coincide con "{{ $search }}".
                @elseif($carreraFilter)
                    Aún no hay empresas registradas con estudiantes de "{{ $carreraFilter }}".
                @else
                    Aún no hay unidades receptoras registradas.
                @endif
            </p>
            @if($search || $carreraFilter)
                <a href="{{ route('estudiante.convenios') }}" class="mt-4 inline-block text-sm font-semibold text-[#4E7D24] hover:underline">
                    Ver todas las empresas
                </a>
            @endif
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 fade-in-up delay-200">
            @foreach($unidades as $unidad)
                @php
                    $esMoral   = strtolower($unidad->tipo_persona ?? '') === 'moral';
                    $tipoLabel = $esMoral ? 'Persona Moral' : 'Persona Física';
                    $tipoColor = $esMoral ? 'blue' : 'orange';
                @endphp
                <div class="glass-card rounded-3xl p-6 flex flex-col justify-between border-transparent hover:border-[#6BA53A]/20 transition-colors">
                    <div>
                        <div class="flex justify-between items-start gap-4 mb-4">
                            <div>
                                <span class="inline-block text-[10px] font-bold text-{{ $tipoColor }}-600 bg-{{ $tipoColor }}-50 border border-{{ $tipoColor }}-100 px-2 py-0.5 rounded-md mb-2">{{ $tipoLabel }}</span>
                                <h3 class="text-xl font-bold text-gray-900">{{ $unidad->nombre_empresa }}</h3>
                            </div>
                            <span class="inline-flex items-center gap-1 text-xs font-bold text-green-700 bg-green-50 border border-green-100 px-2.5 py-1 rounded-full shrink-0">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Vigente
                            </span>
                        </div>

                        @if($unidad->direccion)
                            <p class="text-sm text-gray-500 font-medium mb-4 flex items-start gap-1.5">
                                <svg class="w-4 h-4 mt-0.5 shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $unidad->direccion }}
                            </p>
                        @endif
                    </div>

                    <div class="pt-4 border-t border-gray-100/50 flex items-center justify-between">
                        <span class="text-xs text-gray-400 font-medium">{{ $unidad->tipo_persona ? ucfirst($unidad->tipo_persona) : '' }}</span>
                        <button class="text-xs font-bold text-[#4E7D24] bg-[#6BA53A]/10 px-4 py-2 rounded-xl hover:bg-[#4E7D24] hover:text-white transition-all shadow-sm">
                            Ver detalle
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <p class="text-center text-sm text-gray-400 fade-in-up delay-300">
            {{ $unidades->count() }} empresa{{ $unidades->count() !== 1 ? 's' : '' }} encontrada{{ $unidades->count() !== 1 ? 's' : '' }}
        </p>
    @endif

    <script>
        function validateSearch() {
            var val = document.getElementById('search-input').value.trim();
            var err = document.getElementById('search-error');
            if (val.length === 1) {
                err.textContent = 'Ingresa al menos 2 caracteres para buscar.';
                err.classList.remove('hidden');
                return false;
            }
            err.classList.add('hidden');
            return true;
        }

        document.getElementById('search-input').addEventListener('input', function() {
            var err = document.getElementById('search-error');
            if (this.value.trim().length !== 1) {
                err.classList.add('hidden');
            }
        });
    </script>
@endsection
