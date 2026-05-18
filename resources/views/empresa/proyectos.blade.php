@extends('layouts.empresa', ['active' => 'proyectos', 'title' => 'Gestión de Proyectos - Unidad Receptora'])

@section('content')
    <!-- Header Section -->
    <div class="mb-4 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-[#005e20] mb-1">Gestión de Proyectos</h1>
            <p class="text-gray-500 font-medium">Registra y administra proyectos disponibles para estudiantes</p>
        </div>
        <button class="bg-[#005e20] text-white hover:bg-[#004718] px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 border border-[#004718]">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Nuevo Proyecto
        </button>
    </div>

    <!-- Filters & Search -->
    <div class="glass-card rounded-2xl p-4 mb-6 flex flex-col sm:flex-row gap-4">
        <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl leading-5 bg-white/50 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] sm:text-sm transition-colors shadow-inner" placeholder="Buscar Proyectos...">
        </div>
        <button class="bg-white/80 border border-gray-200 text-gray-700 hover:bg-white px-6 py-3 rounded-xl text-sm font-bold shadow-sm hover:shadow transition-all flex items-center justify-center min-w-[120px]">
            Filtros
        </button>
    </div>

    <!-- Table -->
    <div class="glass-card rounded-3xl p-6 md:p-8 border-t-4 border-[#6BA53A]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th scope="col" class="px-3 py-4 text-center text-[12px] font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl whitespace-nowrap">Proyecto</th>
                        <th scope="col" class="px-3 py-4 text-center text-[12px] font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Área</th>
                        <th scope="col" class="px-3 py-4 text-center text-[12px] font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Vacantes</th>
                        <th scope="col" class="px-3 py-4 text-center text-[12px] font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Estado</th>
                        <th scope="col" class="px-3 py-4 text-center text-[12px] font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl whitespace-nowrap">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-transparent divide-y divide-gray-100">
                    <!-- Row 1 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-3 py-4 text-center">
                            <div class="text-sm font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors leading-tight">Desarrollo de Plataforma Web</div>
                        </td>
                        <td class="px-3 py-4 text-center">
                            <div class="text-sm text-gray-600 font-medium leading-tight">Sistemas y Tecnología</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <span class="bg-[#38bdf8] text-white px-5 py-1.5 rounded-full text-xs font-bold shadow-sm inline-block tracking-wider">1</span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <span class="bg-[#22c55e] text-white px-5 py-1.5 rounded-full text-xs font-bold shadow-sm inline-block tracking-wider">Activo</span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <button class="text-[#005e20] hover:text-[#6BA53A] font-bold transition-colors">
                                Ver detalles
                            </button>
                        </td>
                    </tr>
                    
                    <!-- Empty rows to simulate the mockup layout -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors"><td class="px-3 py-6" colspan="5"></td></tr>
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors"><td class="px-3 py-6" colspan="5"></td></tr>
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors"><td class="px-3 py-6" colspan="5"></td></tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
