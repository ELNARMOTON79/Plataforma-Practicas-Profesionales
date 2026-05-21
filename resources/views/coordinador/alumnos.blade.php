@extends('layouts.coordinador', ['active' => 'alumnos', 'title' => 'Alumnos - Coordinador'])

@section('content')
    <!-- Header Section -->
    <x-page-header title="Listado de Alumnos" description="Directorio y gestión de estudiantes en prácticas">
        <x-slot:actions>
            <div class="relative group">
                <button class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-3 border border-[#2E5417]">
                    Filtrar
                    <div class="bg-white/20 p-0.5 rounded border border-white/30">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </button>
                <!-- Dropdown Menu (Hover) -->
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                    <div class="py-2">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-[#6BA53A]/10 hover:text-[#4E7D24] font-bold">Carrera</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-[#6BA53A]/10 hover:text-[#4E7D24] font-bold">Extemporáneos</a>
                    </div>
                </div>
            </div>
        </x-slot>
    </x-page-header>

    <!-- Filters & Search (Buscador Premium) -->
    <div class="glass-card rounded-2xl p-4 mb-6 fade-in-up delay-100">
        <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" id="search-input" class="block w-full pl-10 pr-3 py-3.5 border border-gray-200 rounded-xl leading-5 bg-white/50 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-[#6BA53A] focus:ring-2 focus:ring-[#6BA53A]/20 sm:text-sm transition-all shadow-inner" placeholder="Buscar por nombre, no. de cuenta, carrera o estatus...">
        </div>
    </div>

    <!-- Table Container (Glassmorphic) -->
    <div class="glass-card rounded-3xl p-6 md:p-8 border-t-4 border-[#6BA53A] fade-in-up delay-200 shadow-sm">
        <div class="overflow-x-auto">
            <table id="alumnos-table" class="min-w-full divide-y divide-gray-200/50">
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
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl whitespace-nowrap">Proyecto</th>
                    </tr>
                </thead>
                <tbody class="bg-transparent divide-y divide-gray-100/50">
                    <!-- Fila 1 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">
                            20206744
                        </td>
                        <td class="px-3 py-4 whitespace-normal text-left max-w-[150px]">
                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors leading-tight uppercase break-words">DOMINGUEZ MARCOS JAZMIN</div>
                        </td>
                        <td class="px-3 py-4 text-center max-w-[140px] whitespace-normal">
                            <div class="text-[10px] text-gray-600 font-bold leading-tight break-words uppercase">FACULTAD DE INGENIERIA ELECTROMECANICA</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-500 uppercase">
                            AGO-2026/ENE-2027
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-800">
                            6°E
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">
                            FEMENINO
                        </td>
                        <td class="px-3 py-4 text-center max-w-[130px] whitespace-normal">
                            <div class="text-xs text-gray-600 font-semibold leading-tight break-words uppercase">INGENIERO DE SOFTWARE</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <span class="px-2.5 py-1 inline-flex text-[10px] leading-5 font-bold rounded-lg bg-green-50 text-green-700 border border-green-200">ACTIVO</span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <button class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-4 py-1.5 rounded-xl text-[10px] font-bold shadow-sm transition-all hover:scale-105 uppercase tracking-wider">Ver Registro</button>
                        </td>
                    </tr>

                    <!-- Fila 2 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">
                            20194852
                        </td>
                        <td class="px-3 py-4 whitespace-normal text-left max-w-[150px]">
                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors leading-tight uppercase break-words">HERRERA RUIZ ALEJANDRO</div>
                        </td>
                        <td class="px-3 py-4 text-center max-w-[140px] whitespace-normal">
                            <div class="text-[10px] text-gray-600 font-bold leading-tight break-words uppercase">FACULTAD DE INGENIERIA ELECTROMECANICA</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-500 uppercase">
                            AGO-2026/ENE-2027
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-800">
                            8°A
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">
                            MASCULINO
                        </td>
                        <td class="px-3 py-4 text-center max-w-[130px] whitespace-normal">
                            <div class="text-xs text-gray-600 font-semibold leading-tight break-words uppercase">INGENIERO ELÉCTRICO</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <span class="px-2.5 py-1 inline-flex text-[10px] leading-5 font-bold rounded-lg bg-blue-50 text-blue-700 border border-blue-200">ASIGNADO</span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <button class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-4 py-1.5 rounded-xl text-[10px] font-bold shadow-sm transition-all hover:scale-105 uppercase tracking-wider">Ver Registro</button>
                        </td>
                    </tr>

                    <!-- Fila 3 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">
                            20213094
                        </td>
                        <td class="px-3 py-4 whitespace-normal text-left max-w-[150px]">
                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors leading-tight uppercase break-words">FLORES SILVA MARIANA</div>
                        </td>
                        <td class="px-3 py-4 text-center max-w-[140px] whitespace-normal">
                            <div class="text-[10px] text-gray-600 font-bold leading-tight break-words uppercase">FACULTAD DE INGENIERIA ELECTROMECANICA</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-500 uppercase">
                            SIN REGISTRO
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-800">
                            6°B
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">
                            FEMENINO
                        </td>
                        <td class="px-3 py-4 text-center max-w-[130px] whitespace-normal">
                            <div class="text-xs text-gray-600 font-semibold leading-tight break-words uppercase">INGENIERO MECÁNICO</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <span class="px-2.5 py-1 inline-flex text-[10px] leading-5 font-bold rounded-lg bg-yellow-50 text-yellow-700 border border-yellow-200">PENDIENTE</span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <button class="bg-[#38bdf8] text-white hover:bg-[#0284c7] px-4 py-1.5 rounded-xl text-[10px] font-bold shadow-sm transition-all hover:scale-105 uppercase tracking-wider">Registrar</button>
                        </td>
                    </tr>

                    <!-- Fila 4 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">
                            20205842
                        </td>
                        <td class="px-3 py-4 whitespace-normal text-left max-w-[150px]">
                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors leading-tight uppercase break-words">ALONSO CÁRDENAS HÉCTOR</div>
                        </td>
                        <td class="px-3 py-4 text-center max-w-[140px] whitespace-normal">
                            <div class="text-[10px] text-gray-600 font-bold leading-tight break-words uppercase">FACULTAD DE INGENIERIA ELECTROMECANICA</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-500 uppercase">
                            AGO-2026/ENE-2027
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-800">
                            6°E
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">
                            MASCULINO
                        </td>
                        <td class="px-3 py-4 text-center max-w-[130px] whitespace-normal">
                            <div class="text-xs text-gray-600 font-semibold leading-tight break-words uppercase">INGENIERO DE SOFTWARE</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <span class="px-2.5 py-1 inline-flex text-[10px] leading-5 font-bold rounded-lg bg-green-50 text-green-700 border border-green-200">ACTIVO</span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <button class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-4 py-1.5 rounded-xl text-[10px] font-bold shadow-sm transition-all hover:scale-105 uppercase tracking-wider">Ver Registro</button>
                        </td>
                    </tr>

                    <!-- Fila 5 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">
                            20214951
                        </td>
                        <td class="px-3 py-4 whitespace-normal text-left max-w-[150px]">
                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors leading-tight uppercase break-words">RAMÍREZ MENDOZA SOFÍA</div>
                        </td>
                        <td class="px-3 py-4 text-center max-w-[140px] whitespace-normal">
                            <div class="text-[10px] text-gray-600 font-bold leading-tight break-words uppercase">FACULTAD DE INGENIERIA ELECTROMECANICA</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-500 uppercase">
                            SIN REGISTRO
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-800">
                            4°C
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">
                            FEMENINO
                        </td>
                        <td class="px-3 py-4 text-center max-w-[130px] whitespace-normal">
                            <div class="text-xs text-gray-600 font-semibold leading-tight break-words uppercase">INGENIERO MECATRÓNICO</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <span class="px-2.5 py-1 inline-flex text-[10px] leading-5 font-bold rounded-lg bg-red-50 text-red-700 border border-red-200">INACTIVO</span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <button class="bg-[#38bdf8] text-white hover:bg-[#0284c7] px-4 py-1.5 rounded-xl text-[10px] font-bold shadow-sm transition-all hover:scale-105 uppercase tracking-wider">Registrar</button>
                        </td>
                    </tr>

                    <!-- Fila 6 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">
                            20203014
                        </td>
                        <td class="px-3 py-4 whitespace-normal text-left max-w-[150px]">
                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors leading-tight uppercase break-words">GÓMEZ OROZCO LUIS FERNANDO</div>
                        </td>
                        <td class="px-3 py-4 text-center max-w-[140px] whitespace-normal">
                            <div class="text-[10px] text-gray-600 font-bold leading-tight break-words uppercase">FACULTAD DE INGENIERIA ELECTROMECANICA</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-500 uppercase">
                            AGO-2026/ENE-2027
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-800">
                            8°B
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">
                            MASCULINO
                        </td>
                        <td class="px-3 py-4 text-center max-w-[130px] whitespace-normal">
                            <div class="text-xs text-gray-600 font-semibold leading-tight break-words uppercase">INGENIERO DE SOFTWARE</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <span class="px-2.5 py-1 inline-flex text-[10px] leading-5 font-bold rounded-lg bg-green-50 text-green-700 border border-green-200">ACTIVO</span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <button class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-4 py-1.5 rounded-xl text-[10px] font-bold shadow-sm transition-all hover:scale-105 uppercase tracking-wider">Ver Registro</button>
                        </td>
                    </tr>

                    <!-- Fila 7 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">
                            20197412
                        </td>
                        <td class="px-3 py-4 whitespace-normal text-left max-w-[150px]">
                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors leading-tight uppercase break-words">PÉREZ VARGAS DIANA</div>
                        </td>
                        <td class="px-3 py-4 text-center max-w-[140px] whitespace-normal">
                            <div class="text-[10px] text-gray-600 font-bold leading-tight break-words uppercase">FACULTAD DE INGENIERIA ELECTROMECANICA</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-500 uppercase">
                            AGO-2026/ENE-2027
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-800">
                            8°A
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">
                            FEMENINO
                        </td>
                        <td class="px-3 py-4 text-center max-w-[130px] whitespace-normal">
                            <div class="text-xs text-gray-600 font-semibold leading-tight break-words uppercase">INGENIERO ELÉCTRICO</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <span class="px-2.5 py-1 inline-flex text-[10px] leading-5 font-bold rounded-lg bg-blue-50 text-blue-700 border border-blue-200">ASIGNADO</span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <button class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-4 py-1.5 rounded-xl text-[10px] font-bold shadow-sm transition-all hover:scale-105 uppercase tracking-wider">Ver Registro</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts de DataTables e Inicialización Dinámica -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inicializar DataTable
            let table = $('#alumnos-table').DataTable({
                searching: true,     // Habilitar búsqueda
                lengthChange: false,  // Ocultar cantidad de registros nativa
                pageLength: 5,       // Limitar a 5 registros por página por defecto
                ordering: true,      // Habilitar ordenación
                info: false,         // Ocultar info nativa
                dom: 'rtp',          // Mostrar solo tabla (r, t) y paginación (p)
                columnDefs: [
                    { orderable: false, targets: [8] } // Deshabilitar ordenación en columna "Proyecto" (índice 8)
                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                }
            });

            // Conectar el buscador personalizado al DataTable de Alumnos
            $('#search-input').on('keyup', function() {
                table.search(this.value).draw();
            });
        });
    </script>
@endsection
