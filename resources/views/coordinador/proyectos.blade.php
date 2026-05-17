@extends('layouts.coordinador', ['active' => 'proyectos', 'title' => 'Proyectos - Coordinador'])

@section('content')
    <!-- Header Section -->
    <div class="mb-4 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Listado de Proyectos</h1>
            <p class="text-gray-500 font-medium">Catálogo de proyectos disponibles para prácticas</p>
        </div>
        <button class="bg-[#005e20] text-white hover:bg-[#004718] px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 border border-[#004718]">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Registrar
        </button>
    </div>

    <!-- Filters & Search -->
    <div class="glass-card rounded-2xl p-4 mb-6">
        <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl leading-5 bg-white/50 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] sm:text-sm transition-colors shadow-inner" placeholder="Buscar Proyecto.....">
        </div>
    </div>

    <!-- Table -->
    <div class="glass-card rounded-3xl p-6 md:p-8 border-t-4 border-[#6BA53A]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th scope="col" class="px-3 py-4 text-center text-[12px] font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl whitespace-nowrap">Proyecto</th>
                        <th scope="col" class="px-3 py-4 text-center text-[12px] font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Nombre</th>
                        <th scope="col" class="px-3 py-4 text-center text-[12px] font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Plantel / Plan</th>
                        <th scope="col" class="px-3 py-4 text-center text-[12px] font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Ciclo Escolar</th>
                        <th scope="col" class="px-3 py-4 text-center text-[12px] font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Alumnos / Cupo</th>
                        <th scope="col" class="px-3 py-4 text-center text-[12px] font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Activo Internet</th>
                        <th scope="col" class="px-3 py-4 text-center text-[12px] font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl whitespace-nowrap">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-transparent divide-y divide-gray-100">
                    <!-- Row 1 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-medium text-gray-600">
                            425
                        </td>
                        <td class="px-3 py-4 text-center min-w-[200px]">
                            <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors uppercase leading-tight">PLATAFORMA WEB PARA ADMINISTRACIÓN<br>DE PRÁCTICAS</div>
                        </td>
                        <td class="px-3 py-4 text-center min-w-[180px]">
                            <div class="text-xs text-gray-600 font-medium leading-tight">FACULTAD DE INGENIERIA<br>ELECTROMECANICA / E906</div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-xs text-gray-500 font-bold tracking-wide">
                            AGO-2026/ENE-2027
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <span class="bg-[#38bdf8] text-white px-5 py-1.5 rounded-full text-xs font-bold shadow-sm inline-block tracking-wider">1/1</span>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center">
                            <!-- Toggle switch off -->
                            <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" name="toggle" id="toggle1" class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 appearance-none cursor-pointer border-gray-300"/>
                                <label for="toggle1" class="toggle-label block overflow-hidden h-5 rounded-full bg-gray-300 cursor-pointer"></label>
                            </div>
                        </td>
                        <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex justify-center gap-3">
                                <button class="text-[#3ee055] hover:text-[#2ebc41] hover:scale-110 transition-transform" title="Editar">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button class="text-[#38bdf8] hover:text-[#0284c7] hover:scale-110 transition-transform" title="Ver Detalles">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Empty rows to simulate the mockup -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors"><td class="px-3 py-6" colspan="7"></td></tr>
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors"><td class="px-3 py-6" colspan="7"></td></tr>
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors"><td class="px-3 py-6" colspan="7"></td></tr>
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors"><td class="px-3 py-6" colspan="7"></td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <style>
        /* CSS para el toggle switch estilo iOS */
        .toggle-checkbox:checked {
            right: 0;
            border-color: #6BA53A;
        }
        .toggle-checkbox:checked + .toggle-label {
            background-color: #6BA53A;
        }
        .toggle-checkbox {
            right: 0;
            z-index: 1;
            border-color: #e5e7eb;
            transition: all 0.3s;
            top: 0;
            left: 0;
        }
        .toggle-label {
            transition: all 0.3s;
        }
    </style>
@endsection
