@extends('layouts.coordinador', ['active' => 'alumnos', 'title' => 'Alumnos - Coordinador'])

@section('content')
    <!-- Header Section -->
    <div class="mb-4 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Listado de Alumnos</h1>
            <p class="text-gray-500 font-medium">Directorio y gestión de estudiantes en prácticas</p>
        </div>
        
        <div class="relative group">
            <button class="bg-[#005e20] text-white hover:bg-[#004718] px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-3 border border-[#004718]">
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
    </div>

    <!-- Filters & Search -->
    <div class="glass-card rounded-2xl p-4 mb-6">
        <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl leading-5 bg-white/50 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] sm:text-sm transition-colors shadow-inner" placeholder="Buscar por nombre o No. Cuenta...">
        </div>
    </div>

    <!-- Table -->
    <div class="glass-card rounded-3xl p-6 md:p-8 border-t-4 border-[#6BA53A]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl whitespace-nowrap">Cuenta</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Nombre</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Plantel</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Sem. Inscripción</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Sem / Gpo</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Sexo</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Carrera</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Estatus</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl whitespace-nowrap">Proyecto</th>
                    </tr>
                </thead>
                <tbody class="bg-transparent divide-y divide-gray-100">
                    <!-- Row 1 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-2 py-4 whitespace-nowrap text-center text-xs font-medium text-gray-600">
                            20206744
                        </td>
                        <td class="px-2 py-4 whitespace-nowrap text-center">
                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors">DOMINGUEZ MARCOS JAZMIN</div>
                        </td>
                        <td class="px-2 py-4 text-center min-w-[150px]">
                            <div class="text-xs text-gray-600 font-medium leading-tight">FACULTAD DE INGENIERIA<br>ELECTROMECANICA</div>
                        </td>
                        <td class="px-2 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-500">
                            SIN REGISTRO
                        </td>
                        <td class="px-2 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-800">
                            6°E
                        </td>
                        <td class="px-2 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-600">
                            FEMENINO
                        </td>
                        <td class="px-2 py-4 text-center min-w-[120px]">
                            <div class="text-xs text-gray-600 font-medium leading-tight">INGENIERO DE<br>SOFTWARE</div>
                        </td>
                        <td class="px-2 py-4 whitespace-nowrap text-center">
                            <!-- Estatus vacío según mockup -->
                        </td>
                        <td class="px-2 py-4 whitespace-nowrap text-center">
                            <button class="bg-[#3ee055] text-white hover:bg-[#2ebc41] px-4 py-1.5 rounded-full text-[10px] font-bold shadow-sm transition-all hover:shadow hover:scale-105 uppercase tracking-wider">Ver Registro</button>
                        </td>
                    </tr>
                    
                    <!-- Row 2 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-2 py-6" colspan="8"></td>
                        <td class="px-2 py-4 whitespace-nowrap text-center">
                            <button class="bg-[#38bdf8] text-white hover:bg-[#0284c7] px-5 py-1.5 rounded-full text-[10px] font-bold shadow-sm transition-all hover:shadow hover:scale-105 uppercase tracking-wider">Registrar</button>
                        </td>
                    </tr>
                    
                    <!-- Empty rows to simulate the mockup -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors"><td class="px-2 py-6" colspan="9"></td></tr>
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors"><td class="px-2 py-6" colspan="9"></td></tr>
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors"><td class="px-2 py-6" colspan="9"></td></tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
