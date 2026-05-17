@extends('layouts.coordinador', ['active' => 'instituciones', 'title' => 'Instituciones - Coordinador'])

@section('content')
    <!-- Header Section -->
    <div class="mb-4 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Listado de Instituciones</h1>
            <p class="text-gray-500 font-medium">Gestiona las empresas e instituciones vinculadas</p>
        </div>
        <button class="bg-[#005e20] text-white hover:bg-[#004718] px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Nueva Institución
        </button>
    </div>

    <!-- Filters & Search -->
    <div class="glass-card rounded-2xl p-4 mb-6">
        <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl leading-5 bg-white/50 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] sm:text-sm transition-colors shadow-inner" placeholder="Buscar Institucion .....">
        </div>
    </div>

    <!-- Table -->
    <div class="glass-card rounded-3xl p-6 md:p-8 border-t-4 border-[#6BA53A]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl">Nombre</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Convenio</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Fecha vencimiento</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Sistema</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Sector</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl">UR</th>
                    </tr>
                </thead>
                <tbody class="bg-transparent divide-y divide-gray-100">
                    <!-- Row 1 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors">H. AYUNTAMIENTO CONSTITUCIONAL DE COLIMA</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg bg-[#3ee055] text-white shadow-sm">AYTO. COLIMA</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg bg-[#3ee055] text-white shadow-sm">31/01/2029</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-center text-gray-500 font-medium">
                            MUNICIPAL
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-center text-gray-500 font-medium">
                            PÚBLICO
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-center font-medium text-gray-600">
                            <div class="flex items-center justify-center gap-1.5">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                4 UR
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Empty rows to simulate the mockup -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors"><td class="px-6 py-6" colspan="6"></td></tr>
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors"><td class="px-6 py-6" colspan="6"></td></tr>
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors"><td class="px-6 py-6" colspan="6"></td></tr>
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors"><td class="px-6 py-6" colspan="6"></td></tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
