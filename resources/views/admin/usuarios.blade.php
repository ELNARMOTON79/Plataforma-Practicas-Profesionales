@extends('layouts.admin', ['title' => 'Gestión de Usuarios - Administrador UdeC', 'active' => 'usuarios'])

@section('content')
    <!-- Header Section -->
    <x-page-header title="Gestión de Usuarios" description="Administra los accesos y roles de la plataforma.">
        <x-slot:actions>
            <button type="button" onclick="document.getElementById('registerUserModal').classList.remove('hidden')" class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Registrar Usuario
            </button>
        </x-slot>
    </x-page-header>

    <!-- Users Table & Filters -->
    <div class="glass-card rounded-3xl p-6 md:p-8 fade-in-up delay-100">
        <!-- Filters & Search -->
        <div class="flex flex-col sm:flex-row gap-4 items-center justify-between mb-6">
            <div class="relative w-full sm:w-96">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-white/50 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] sm:text-sm transition-colors" placeholder="Buscar por nombre, correo o matrícula...">
            </div>
            
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <select class="block w-full sm:w-auto pl-3 pr-10 py-2 text-sm border-gray-200 focus:outline-none focus:ring-[#6BA53A] focus:border-[#6BA53A] font-medium rounded-xl bg-white/50 text-gray-700">
                    <option value="">Todos los Roles</option>
                    <option value="admin">Administrador</option>
                    <option value="coordinador">Coordinador</option>
                    <option value="empresa">Empresa</option>
                    <option value="alumno">Alumno</option>
                </select>
                <select class="block w-full sm:w-auto pl-3 pr-10 py-2 text-sm border-gray-200 focus:outline-none focus:ring-[#6BA53A] focus:border-[#6BA53A] font-medium rounded-xl bg-white/50 text-gray-700">
                    <option value="">Estado</option>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl">Usuario</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Rol</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Fecha Registro</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Estado</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-transparent divide-y divide-gray-100">
                    
                    <!-- User Row 1 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 md:h-12 md:w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold shadow-sm">CA</div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors">Carlos Alonso</div>
                                    <div class="text-xs text-gray-500">coordinador_fime@ucol.mx</div>
                                    <div class="text-xs text-gray-400 mt-0.5">ID: 20154879</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg bg-blue-50 text-blue-700 border border-blue-100">Coordinador</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                            12 May 2026
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg bg-green-50 text-green-700 border border-green-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5 mt-1.5"></span> Activo
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end gap-2">
                                <button class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Editar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Suspender">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- User Row 2 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 md:h-12 md:w-12 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 font-bold shadow-sm">TS</div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors">Tech Solutions SA</div>
                                    <div class="text-xs text-gray-500">contacto@techsolutions.com</div>
                                    <div class="text-xs text-gray-400 mt-0.5">RFC: TSO190214XYZ</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg bg-yellow-50 text-yellow-700 border border-yellow-100">Empresa</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                            08 May 2026
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg bg-green-50 text-green-700 border border-green-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5 mt-1.5"></span> Activo
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end gap-2">
                                <button class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Editar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Suspender">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- User Row 3 -->
                    <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 md:h-12 md:w-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-bold shadow-sm">JP</div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors">Juan Pérez</div>
                                    <div class="text-xs text-gray-500">jperez45@ucol.mx</div>
                                    <div class="text-xs text-gray-400 mt-0.5">Matrícula: 20205849</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg bg-purple-50 text-purple-700 border border-purple-100">Alumno</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                            01 May 2026
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg bg-red-50 text-red-700 border border-red-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5 mt-1.5"></span> Inactivo
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end gap-2">
                                <button class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Editar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all" title="Reactivar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                     <!-- User Row 4 -->
                     <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 md:h-12 md:w-12 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 font-bold shadow-sm">
                                    <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors">Admin Principal</div>
                                    <div class="text-xs text-gray-500">admin@ucol.mx</div>
                                    <div class="text-xs text-gray-400 mt-0.5">Sistema</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg bg-gray-100 text-gray-800 border border-gray-200">Administrador</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                            01 Ene 2026
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg bg-green-50 text-green-700 border border-green-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5 mt-1.5"></span> Activo
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end gap-2">
                                <button class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Editar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex items-center justify-between border-t border-gray-100 pt-6">
            <div class="flex-1 flex justify-between sm:hidden">
                <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-200 text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    Anterior
                </a>
                <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-200 text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    Siguiente
                </a>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700 font-medium">
                        Mostrando <span class="font-bold text-gray-900">1</span> a <span class="font-bold text-gray-900">4</span> de <span class="font-bold text-gray-900">1,500</span> usuarios
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-xl shadow-sm -space-x-px" aria-label="Pagination">
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-xl border border-gray-200 bg-white/50 text-sm font-medium text-gray-500 hover:bg-white transition-colors">
                            <span class="sr-only">Anterior</span>
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </a>
                        <a href="#" aria-current="page" class="z-10 bg-[#6BA53A]/10 border-[#6BA53A]/50 text-[#4E7D24] relative inline-flex items-center px-4 py-2 border text-sm font-bold">
                            1
                        </a>
                        <a href="#" class="bg-white/50 border-gray-200 text-gray-500 hover:bg-white relative inline-flex items-center px-4 py-2 border text-sm font-medium transition-colors">
                            2
                        </a>
                        <a href="#" class="bg-white/50 border-gray-200 text-gray-500 hover:bg-white relative inline-flex items-center px-4 py-2 border text-sm font-medium transition-colors">
                            3
                        </a>
                        <span class="relative inline-flex items-center px-4 py-2 border border-gray-200 bg-white/50 text-sm font-medium text-gray-700">
                            ...
                        </span>
                        <a href="#" class="bg-white/50 border-gray-200 text-gray-500 hover:bg-white relative inline-flex items-center px-4 py-2 border text-sm font-medium transition-colors">
                            375
                        </a>
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-xl border border-gray-200 bg-white/50 text-sm font-medium text-gray-500 hover:bg-white transition-colors">
                            <span class="sr-only">Siguiente</span>
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for User Registration -->
    <div id="registerUserModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-500/75 backdrop-blur-sm" aria-hidden="true" onclick="document.getElementById('registerUserModal').classList.add('hidden')"></div>

            <!-- Modal panel -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block w-full max-w-3xl overflow-hidden text-left align-bottom transition-all transform bg-white rounded-3xl shadow-2xl sm:my-8 sm:align-middle glass-card">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-xl font-bold text-gray-900" id="modal-title">Registrar Nuevo Usuario</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-500 transition-colors" onclick="document.getElementById('registerUserModal').classList.add('hidden')">
                        <span class="sr-only">Cerrar</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                
                <div class="px-6 py-6 md:px-8">
                    <form action="#" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Información Personal -->
                            <div class="space-y-5">
                                <h4 class="text-md font-bold text-[#4E7D24] border-b border-gray-100 pb-2">Información del Usuario</h4>
                                
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo</label>
                                    <input type="text" id="name" name="name" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors" placeholder="Ej. Juan Pérez">
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                                    <input type="email" id="email" name="email" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors" placeholder="ejemplo@ucol.mx">
                                </div>

                                <div>
                                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Rol en el Sistema</label>
                                    <select id="role" name="role" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors text-gray-700" onchange="toggleDynamicFields(this.value)">
                                        <option value="">Selecciona un rol</option>
                                        <option value="1">Administrador</option>
                                        <option value="2">Coordinador</option>
                                        <option value="3">Alumno</option>
                                        <option value="4">Empresa</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Seguridad y Detalles -->
                            <div class="space-y-5">
                                <h4 class="text-md font-bold text-[#4E7D24] border-b border-gray-100 pb-2">Seguridad</h4>
                                
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                                    <input type="password" id="password" name="password" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors" placeholder="••••••••">
                                    <p class="mt-1 text-xs text-gray-500">Mínimo 8 caracteres.</p>
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Contraseña</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors" placeholder="••••••••">
                                </div>
                                
                                <div class="pt-2">
                                    <label class="flex items-start gap-3">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" class="w-4 h-4 text-[#4E7D24] bg-gray-50 border-gray-300 rounded focus:ring-[#6BA53A]">
                                        </div>
                                        <div class="text-sm">
                                            <span class="text-gray-700 font-medium">Notificar al usuario</span>
                                            <p class="text-gray-500 text-xs">Enviar credenciales por correo electrónico.</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Campos Dinámicos -->
                        <div id="dynamic-fields-modal" class="mt-6 pt-4 border-t border-gray-100 hidden">
                            <h4 class="text-md font-bold text-[#4E7D24] mb-4">Información Adicional</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="alumno-field-modal hidden">
                                    <label for="matricula" class="block text-sm font-medium text-gray-700 mb-1">Matrícula</label>
                                    <input type="text" id="matricula" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors" placeholder="Ej. 20182345">
                                </div>
                                <div class="empresa-field-modal hidden">
                                    <label for="rfc" class="block text-sm font-medium text-gray-700 mb-1">RFC</label>
                                    <input type="text" id="rfc" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] sm:text-sm transition-colors" placeholder="Ej. ABCD123456EF7">
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-5 border-t border-gray-100 flex justify-end gap-3">
                            <button type="button" onclick="document.getElementById('registerUserModal').classList.add('hidden')" class="px-5 py-2.5 border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors text-sm">
                                Cancelar
                            </button>
                            <button type="submit" class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Guardar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleDynamicFields(value) {
            const dynamicFields = document.getElementById('dynamic-fields-modal');
            const alumnoFields = document.querySelectorAll('.alumno-field-modal');
            const empresaFields = document.querySelectorAll('.empresa-field-modal');

            // Ocultar todos
            dynamicFields.classList.add('hidden');
            alumnoFields.forEach(el => el.classList.add('hidden'));
            empresaFields.forEach(el => el.classList.add('hidden'));

            // Mostrar según selección
            if (value === '3') { // Alumno
                dynamicFields.classList.remove('hidden');
                alumnoFields.forEach(el => el.classList.remove('hidden'));
            } else if (value === '4') { // Empresa
                dynamicFields.classList.remove('hidden');
                empresaFields.forEach(el => el.classList.remove('hidden'));
            }
        }
    </script>
@endsection
