@extends('layouts.coordinador', ['active' => 'instituciones', 'title' => 'Instituciones - Coordinador'])

@section('content')


    <!-- Header Section -->
    <x-page-header title="Listado de Instituciones" description="Gestiona las empresas e instituciones vinculadas a las prácticas profesionales">
        <x-slot:actions>
            <button class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nueva Institución
            </button>
        </x-slot>
    </x-page-header>


    <!-- Filters & Search (Buscador Premium) -->
    <div class="glass-card rounded-2xl p-4 mb-6 fade-in-up delay-100">
        <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" id="search-input" class="block w-full pl-10 pr-3 py-3.5 border border-gray-200 rounded-xl leading-5 bg-white/50 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-[#6BA53A] focus:ring-2 focus:ring-[#6BA53A]/20 sm:text-sm transition-all shadow-inner" placeholder="Escribe el nombre de una institución, sector o estatus para buscar dinámicamente...">
        </div>
    </div>

    <!-- Table Container (Glassmorphic) -->
    <div class="glass-card rounded-3xl p-6 md:p-8 border-t-4 border-[#6BA53A] fade-in-up delay-200 shadow-sm">
        <div class="overflow-x-auto">
            <table id="instituciones-table" class="min-w-full divide-y divide-gray-200/50">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th scope="col" class="px-3 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl max-w-[200px] whitespace-normal">Nombre de la Institución</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Convenio</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Fecha Vencimiento</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Sistema</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Sector</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl whitespace-nowrap">Unidad Receptora (UR)</th>
                    </tr>
                </thead>
                <tbody class="bg-transparent divide-y divide-gray-100/50">
                    <!-- Registro 1 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-3 py-4 whitespace-normal max-w-[200px]">
                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors leading-tight break-words uppercase">H. AYUNTAMIENTO CONSTITUCIONAL DE COLIMA</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <span class="px-3 py-1 inline-flex text-[11px] leading-5 font-bold rounded-lg bg-green-50 text-green-700 border border-green-200 shadow-sm">AYTO. COLIMA</span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs text-gray-700 font-semibold">
                            31/01/2029
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-xs text-center text-gray-500 font-bold uppercase">
                            MUNICIPAL
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-xs text-center text-gray-500 font-bold uppercase">
                            PÚBLICO
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-xs text-center font-medium text-gray-600">
                            <div class="flex items-center justify-center gap-1.5 bg-gray-100/50 rounded-lg py-1 px-2.5 w-fit mx-auto border border-gray-200/50">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                <span class="font-bold text-gray-700">4 UR</span>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Registro 2 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-3 py-4 whitespace-normal max-w-[200px]">
                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors leading-tight break-words uppercase">TERNIUM MÉXICO S.A. DE C.V.</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <span class="px-3 py-1 inline-flex text-[11px] leading-5 font-bold rounded-lg bg-blue-50 text-blue-700 border border-blue-200 shadow-sm">TERNIUM-2028</span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs text-gray-700 font-semibold">
                            15/08/2028
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-xs text-center text-gray-500 font-bold uppercase">
                            PRIVADA
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-xs text-center text-gray-500 font-bold uppercase">
                            PRIVADO
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-xs text-center font-medium text-gray-600">
                            <div class="flex items-center justify-center gap-1.5 bg-gray-100/50 rounded-lg py-1 px-2.5 w-fit mx-auto border border-gray-200/50">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                <span class="font-bold text-gray-700">2 UR</span>
                            </div>
                        </td>
                    </tr>

                    <!-- Registro 3 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-3 py-4 whitespace-normal max-w-[200px]">
                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors leading-tight break-words uppercase">CONSORCIO MINERO BENITO JUÁREZ PEÑA COLORADA S.A. DE C.V.</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <span class="px-3 py-1 inline-flex text-[11px] leading-5 font-bold rounded-lg bg-orange-50 text-orange-700 border border-orange-200 shadow-sm">PEÑA-2027</span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs text-gray-700 font-semibold">
                            20/12/2027
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-xs text-center text-gray-500 font-bold uppercase">
                            PRIVADA
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-xs text-center text-gray-500 font-bold uppercase">
                            PRIVADO
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-xs text-center font-medium text-gray-600">
                            <div class="flex items-center justify-center gap-1.5 bg-gray-100/50 rounded-lg py-1 px-2.5 w-fit mx-auto border border-gray-200/50">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                <span class="font-bold text-gray-700">5 UR</span>
                            </div>
                        </td>
                    </tr>

                    <!-- Registro 4 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-3 py-4 whitespace-normal max-w-[200px]">
                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors leading-tight break-words uppercase">SECRETARÍA DE EDUCACIÓN DEL ESTADO DE COLIMA</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <span class="px-3 py-1 inline-flex text-[11px] leading-5 font-bold rounded-lg bg-green-50 text-green-700 border border-green-200 shadow-sm">SECOL-2030</span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs text-gray-700 font-semibold">
                            10/05/2030
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-xs text-center text-gray-500 font-bold uppercase">
                            ESTATAL
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-xs text-center text-gray-500 font-bold uppercase">
                            PÚBLICO
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-xs text-center font-medium text-gray-600">
                            <div class="flex items-center justify-center gap-1.5 bg-gray-100/50 rounded-lg py-1 px-2.5 w-fit mx-auto border border-gray-200/50">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                <span class="font-bold text-gray-700">8 UR</span>
                            </div>
                        </td>
                    </tr>

                    <!-- Registro 5 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-3 py-4 whitespace-normal max-w-[200px]">
                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors leading-tight break-words uppercase">COMPAÑÍA MINERA AUTLÁN S.A. DE C.V.</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <span class="px-3 py-1 inline-flex text-[11px] leading-5 font-bold rounded-lg bg-purple-50 text-purple-700 border border-purple-200 shadow-sm">AUTLAN-2029</span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs text-gray-700 font-semibold">
                            01/11/2029
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-xs text-center text-gray-500 font-bold uppercase">
                            PRIVADA
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-xs text-center text-gray-500 font-bold uppercase">
                            PRIVADO
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-xs text-center font-medium text-gray-600">
                            <div class="flex items-center justify-center gap-1.5 bg-gray-100/50 rounded-lg py-1 px-2.5 w-fit mx-auto border border-gray-200/50">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                <span class="font-bold text-gray-700">1 UR</span>
                            </div>
                        </td>
                    </tr>

                    <!-- Registro 6 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-3 py-4 whitespace-normal max-w-[200px]">
                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors leading-tight break-words uppercase">INSTITUTO MEXICANO DEL SEGURO SOCIAL (IMSS) - DELEGACIÓN COLIMA</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <span class="px-3 py-1 inline-flex text-[11px] leading-5 font-bold rounded-lg bg-pink-50 text-pink-700 border border-pink-200 shadow-sm">IMSS-COLIMA</span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs text-gray-700 font-semibold">
                            14/07/2028
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-xs text-center text-gray-500 font-bold uppercase">
                            FEDERAL
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-xs text-center text-gray-500 font-bold uppercase">
                            PÚBLICO
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-xs text-center font-medium text-gray-600">
                            <div class="flex items-center justify-center gap-1.5 bg-gray-100/50 rounded-lg py-1 px-2.5 w-fit mx-auto border border-gray-200/50">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                <span class="font-bold text-gray-700">12 UR</span>
                            </div>
                        </td>
                    </tr>

                    <!-- Registro 7 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-3 py-4 whitespace-normal max-w-[200px]">
                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors leading-tight break-words uppercase">SISTEMA PARA EL DESARROLLO INTEGRAL DE LA FAMILIA (DIF ESTATAL COLIMA)</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <span class="px-3 py-1 inline-flex text-[11px] leading-5 font-bold rounded-lg bg-orange-50 text-orange-700 border border-orange-200 shadow-sm">DIF-ESTATAL</span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs text-gray-700 font-semibold">
                            25/02/2030
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-xs text-center text-gray-500 font-bold uppercase">
                            ESTATAL
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-xs text-center text-gray-500 font-bold uppercase">
                            PÚBLICO
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-xs text-center font-medium text-gray-600">
                            <div class="flex items-center justify-center gap-1.5 bg-gray-100/50 rounded-lg py-1 px-2.5 w-fit mx-auto border border-gray-200/50">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                <span class="font-bold text-gray-700">3 UR</span>
                            </div>
                        </td>
                    </tr>

                    <!-- Registro 8 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-3 py-4 whitespace-normal max-w-[200px]">
                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors leading-tight break-words uppercase">INTEL TECNOLOGÍA DE MÉXICO S.A. DE C.V.</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <span class="px-3 py-1 inline-flex text-[11px] leading-5 font-bold rounded-lg bg-blue-50 text-blue-700 border border-blue-200 shadow-sm">INTEL-2029</span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs text-gray-700 font-semibold">
                            30/09/2029
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-xs text-center text-gray-500 font-bold uppercase">
                            INTERNACIONAL
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-xs text-center text-gray-500 font-bold uppercase">
                            PRIVADO
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-xs text-center font-medium text-gray-600">
                            <div class="flex items-center justify-center gap-1.5 bg-gray-100/50 rounded-lg py-1 px-2.5 w-fit mx-auto border border-gray-200/50">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                <span class="font-bold text-gray-700">2 UR</span>
                            </div>
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
            let table = $('#instituciones-table').DataTable({
                searching: true,     // Habilitar búsqueda
                lengthChange: false,  // Ocultar la cantidad de registros por página nativa
                pageLength: 5,       // Limitar a 5 registros por página por defecto
                ordering: true,      // Habilitar ordenación
                info: false,         // Ocultar info nativa
                dom: 'rtp',          // Mostrar solo tabla (r, t) y paginación (p). Oculta el buscador nativo (f)
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                }
            });

            // Conectar el buscador personalizado al DataTable
            $('#search-input').on('keyup', function() {
                table.search(this.value).draw();
            });
        });
    </script>
@endsection
