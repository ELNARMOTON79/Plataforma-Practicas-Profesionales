@extends('layouts.coordinador', ['active' => 'alumnos', 'title' => 'Alumnos - Coordinador'])

@section('content')
    {{-- ========== SUCCESS / ERROR ALERTS ========== --}}
    @if(session('success'))
        <div id="alert-success" class="flex items-start gap-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl px-5 py-4 mb-6 shadow-sm fade-in-up">
            <svg class="w-5 h-5 mt-0.5 flex-shrink-0 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <p class="text-sm font-semibold">{{ session('success') }}</p>
            <button onclick="document.getElementById('alert-success').remove()" class="ml-auto text-green-400 hover:text-green-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div id="alert-error" class="flex items-start gap-4 bg-red-50 border border-red-200 text-red-800 rounded-2xl px-5 py-4 mb-6 shadow-sm fade-in-up">
            <svg class="w-5 h-5 mt-0.5 flex-shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <div>
                <p class="text-sm font-bold mb-1">Corrige los siguientes errores:</p>
                <ul class="text-xs space-y-0.5 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button onclick="document.getElementById('alert-error').remove()" class="ml-auto text-red-400 hover:text-red-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    <!-- Header Section -->
    <x-page-header title="Listado de Alumnos" description="Directorio y gestión de estudiantes en prácticas profesionales.">
        <x-slot:actions>
            <button
                id="btn-abrir-modal-alumno"
                onclick="document.getElementById('modal-registrar-alumno').classList.remove('hidden')"
                class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Registrar Alumno
            </button>
        </x-slot>
    </x-page-header>

    <!-- Main Alumnos Container (Glassmorphic) -->
    <div class="glass-card rounded-3xl p-6 md:p-8 border-t-4 border-[#6BA53A] fade-in-up delay-100 shadow-sm">
        
        <!-- Filters & Search -->
        <form method="GET" action="{{ route('coordinador.alumnos') }}" class="flex flex-col lg:flex-row gap-4 items-center justify-between mb-6 w-full">
            <!-- Left side: Show entries -->
            <div class="flex items-center gap-2 text-sm text-gray-600 font-medium w-full lg:w-auto">
                <span>Mostrar</span>
                <select name="per_page" onchange="this.form.submit()" class="pl-3 pr-8 py-2 text-sm border border-gray-200 focus:outline-none focus:ring-[#6BA53A] focus:border-[#6BA53A] font-bold rounded-xl bg-white/50 text-gray-700 shadow-sm transition-all">
                    <option value="5" {{ request('per_page', '5') == '5' ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page', '5') == '100' ? 'selected' : '' }}>100</option>
                </select>
                <span>registros</span>
            </div>

            <!-- Right side: Filters & Search -->
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
                <!-- Carrera Select -->
                <select name="carrera" onchange="this.form.submit()" class="block w-full sm:w-auto pl-3 pr-10 py-2.5 text-sm border border-gray-200 focus:outline-none focus:ring-[#6BA53A] focus:border-[#6BA53A] font-bold rounded-xl bg-white/50 text-gray-700 shadow-sm transition-all">
                    <option value="">Todas las Carreras</option>
                    @foreach($carrerasDisponibles as $carr)
                        <option value="{{ $carr }}" {{ request('carrera') == $carr ? 'selected' : '' }}>{{ strtoupper($carr) }}</option>
                    @endforeach
                </select>

                <!-- Estatus Select -->
                <select name="estatus" onchange="this.form.submit()" class="block w-full sm:w-auto pl-3 pr-10 py-2.5 text-sm border border-gray-200 focus:outline-none focus:ring-[#6BA53A] focus:border-[#6BA53A] font-bold rounded-xl bg-white/50 text-gray-700 shadow-sm transition-all">
                    <option value="">Todos los Estatus</option>
                    <option value="activo" {{ request('estatus') == 'activo' ? 'selected' : '' }}>ACTIVO</option>
                    <option value="asignado" {{ request('estatus') == 'asignado' ? 'selected' : '' }}>ASIGNADO</option>
                    <option value="pendiente" {{ request('estatus') == 'pendiente' ? 'selected' : '' }}>PENDIENTE</option>
                    <option value="inactivo" {{ request('estatus') == 'inactivo' ? 'selected' : '' }}>INACTIVO</option>
                </select>

                <!-- Search Input -->
                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl leading-5 bg-white/50 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] sm:text-sm shadow-sm transition-all" placeholder="Buscar por nombre o cuenta" pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s@.]+$" title="El buscador solo acepta letras, números, espacios, @ y puntos." onkeypress="return (event.ctrlKey || event.metaKey || event.altKey) || /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s@.]$/.test(event.key) || ['Backspace', 'Enter', 'Tab', 'Delete', 'ArrowLeft', 'ArrowRight'].includes(event.key)" oninput="this.value = this.value.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s@.]/g, '')">
                </div>
                <button type="submit" class="hidden">Buscar</button>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200/50">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl whitespace-nowrap">Cuenta</th>
                        <th scope="col" class="px-3 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider max-w-[150px] whitespace-normal">Nombre del Estudiante</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider max-w-[140px] whitespace-normal">Plantel</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider max-w-[120px] whitespace-normal">Sem. Inscripción</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Sem / Gpo</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Sexo</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider max-w-[130px] whitespace-normal">Carrera</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Estatus</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl whitespace-nowrap">Acción</th>
                    </tr>
                </thead>
                <tbody class="bg-transparent divide-y divide-gray-100/50">
                    @forelse($alumnos as $alumno)
                        @php
                            $esFemenino = preg_match('/(Jazmín|Jazmin|Mariana|Diana|Sofía|Sofia|Flor|Jaqueline|Brisa|María|Maria|Annelise|Najara)/i', $alumno->nombre_completo);
                        @endphp
                        <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                            <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">
                                {{ $alumno->matricula }}
                            </td>
                            <td class="px-3 py-4 whitespace-normal text-left max-w-[150px]">
                                <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors leading-tight uppercase break-words">{{ $alumno->nombre_completo }}</div>
                                <div class="text-[10px] text-gray-400 normal-case">{{ $alumno->user->correo ?? '' }}</div>
                            </td>
                            <td class="px-3 py-4 text-center max-w-[140px] whitespace-normal">
                                <div class="text-[10px] text-gray-600 font-bold leading-tight break-words uppercase">FACULTAD DE INGENIERÍA ELECTROMECÁNICA</div>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-500 uppercase">
                                AGO-2026/ENE-2027
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-800">
                                {{ $alumno->semestre }}°{{ $alumno->grupo }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">
                                {{ $esFemenino ? 'FEMENINO' : 'MASCULINO' }}
                            </td>
                            <td class="px-3 py-4 text-center max-w-[130px] whitespace-normal">
                                <div class="text-xs text-gray-600 font-semibold leading-tight break-words uppercase">{{ $alumno->carrera }}</div>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center">
                                <span class="px-2.5 py-1 inline-flex text-[10px] leading-5 font-bold rounded-lg border {{ $alumno->estatus_class }}">{{ $alumno->estatus }}</span>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center">
                                <button class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-4 py-1.5 rounded-xl text-[10px] font-bold shadow-sm transition-all hover:scale-105 uppercase tracking-wider">Ver Registro</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center text-sm text-gray-500 font-medium">
                                No se encontraron estudiantes con los criterios de búsqueda seleccionados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $alumnos->appends(request()->query())->links() }}
        </div>
    </div>

@endsection

@push('modals')
    @include('coordinador.dashboard.register-modal')
@endpush
