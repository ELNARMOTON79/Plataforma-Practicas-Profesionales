@extends('layouts.coordinador', ['active' => 'alumnos', 'title' => 'Alumnos - Coordinador'])

@section('content')
    <!-- Header Section -->
    <x-page-header title="Listado de Alumnos" description="Directorio y gestión de estudiantes en prácticas profesionales.">
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
