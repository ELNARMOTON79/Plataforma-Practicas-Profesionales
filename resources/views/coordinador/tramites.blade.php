@extends('layouts.coordinador', ['active' => 'tramites', 'title' => 'Trámites - Coordinador'])

@section('content')
    <!-- Header Section -->
    <div class="mb-4 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Trámites y Expedientes</h1>
            <p class="text-gray-500 font-medium">Gestiona las solicitudes de inicio de prácticas y la validación de documentos oficiales</p>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200 mb-6 mt-4">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button onclick="switchTab('solicitudes')" id="tab-solicitudes" class="border-[#6BA53A] text-[#4E7D24] whitespace-nowrap py-4 px-2 border-b-4 font-extrabold text-sm transition-colors flex items-center gap-2">
                Solicitudes de Prácticas
                <span class="bg-red-100 text-red-600 py-0.5 px-2.5 rounded-full text-xs ml-1 shadow-sm">3</span>
            </button>
            <button onclick="switchTab('documentos')" id="tab-documentos" class="border-transparent text-gray-500 hover:text-[#4E7D24] hover:border-gray-300 whitespace-nowrap py-4 px-2 border-b-4 font-bold text-sm transition-colors flex items-center gap-2">
                Validación de Documentos
                <span class="bg-yellow-100 text-yellow-700 py-0.5 px-2.5 rounded-full text-xs ml-1 shadow-sm">5</span>
            </button>
        </nav>
    </div>

    <!-- ============================================== -->
    <!-- TAB 1: SOLICITUDES DE PRÁCTICAS                -->
    <!-- ============================================== -->
    <div id="content-solicitudes" class="block animate-fade-in">
        <div class="glass-card rounded-3xl p-6 md:p-8 border-t-4 border-[#6BA53A]">
            <h2 class="text-xl font-extrabold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-[#6BA53A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Solicitudes Pendientes
            </h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl whitespace-nowrap">Estudiante</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">No. Cuenta</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Institución</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Periodo</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Hrs/Semana</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Observaciones</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl whitespace-nowrap">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-transparent divide-y divide-gray-100">
                        <!-- Row 1 -->
                        <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                            <td class="px-3 py-4 whitespace-nowrap text-center">
                                <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors">DOMINGUEZ MARCOS JAZMIN</div>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-medium text-gray-600">
                                20206744
                            </td>
                            <td class="px-3 py-4 text-center min-w-[150px]">
                                <div class="text-xs text-gray-600 font-medium leading-tight">H. AYUNTAMIENTO DE COLIMA</div>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-500">
                                AGO-2026/ENE-2027
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-800">
                                20 Hrs
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center min-w-[200px]">
                                <input type="text" class="block w-full px-3 py-2 text-xs border border-gray-200 rounded-lg bg-white/50 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A]" placeholder="Añadir observaciones..">
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center">
                                <div class="flex justify-center gap-2">
                                    <button class="bg-green-100 text-green-600 hover:bg-green-600 hover:text-white p-2 rounded-full transition-colors shadow-sm" title="Aprobar Solicitud">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                    <button class="bg-red-100 text-red-600 hover:bg-red-600 hover:text-white p-2 rounded-full transition-colors shadow-sm" title="Rechazar Solicitud">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-[#6BA53A]/5 transition-colors"><td class="px-3 py-6" colspan="7"></td></tr>
                        <tr class="hover:bg-[#6BA53A]/5 transition-colors"><td class="px-3 py-6" colspan="7"></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- TAB 2: VALIDACIÓN DE DOCUMENTOS                -->
    <!-- ============================================== -->
    <div id="content-documentos" class="hidden animate-fade-in">
        
        <!-- Documentos Pendientes -->
        <div class="glass-card rounded-3xl p-6 md:p-8 mb-8 border-l-4 border-yellow-400">
            <h2 class="text-xl font-extrabold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Documentos Pendientes de Validar
            </h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl whitespace-nowrap">Estudiante</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Tipo de documento</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Nombre de Documento</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Fecha de carga</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Acciones</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Notas</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl whitespace-nowrap">Validar</th>
                        </tr>
                    </thead>
                    <tbody class="bg-transparent divide-y divide-gray-100">
                        <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                            <td class="px-3 py-4 whitespace-nowrap text-center">
                                <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors">DOMINGUEZ MARCOS JAZMIN</div>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-medium text-gray-600">
                                CARTA DE ACEPTACIÓN
                            </td>
                            <td class="px-3 py-4 text-center min-w-[150px]">
                                <div class="text-xs text-blue-600 font-bold hover:underline cursor-pointer">carta_aceptacion_jazmin.pdf</div>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-500">
                                16/05/2026
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center gap-3">
                                    <button class="text-[#38bdf8] hover:text-[#0284c7] hover:scale-110 transition-transform" title="Ver Documento">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                    <button class="text-gray-400 hover:text-gray-700 hover:scale-110 transition-transform" title="Descargar">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    </button>
                                </div>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center min-w-[180px]">
                                <input type="text" class="block w-full px-3 py-2 text-xs border border-gray-200 rounded-lg bg-white/50 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A]" placeholder="Añadir observaciones..">
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center">
                                <div class="flex justify-center gap-2">
                                    <button class="bg-green-100 text-green-600 hover:bg-green-600 hover:text-white p-2 rounded-full transition-colors shadow-sm" title="Validar Documento">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                    <button class="bg-red-100 text-red-600 hover:bg-red-600 hover:text-white p-2 rounded-full transition-colors shadow-sm" title="Rechazar Documento">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-[#6BA53A]/5 transition-colors"><td class="px-3 py-6" colspan="7"></td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Documentos Validados -->
        <div class="glass-card rounded-3xl p-6 md:p-8 border-l-4 border-green-500">
            <h2 class="text-xl font-extrabold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Historial de Documentos Validados
            </h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl whitespace-nowrap">Estudiante</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Tipo de documento</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Nombre de Documento</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Estado</th>
                            <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl whitespace-nowrap">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-transparent divide-y divide-gray-100">
                        <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                            <td class="px-3 py-4 whitespace-nowrap text-center">
                                <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors">PEREZ LOPEZ JUAN</div>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-medium text-gray-600">
                                OFICIO DE ASIGNACIÓN
                            </td>
                            <td class="px-3 py-4 text-center min-w-[150px]">
                                <div class="text-xs text-blue-600 font-bold hover:underline cursor-pointer">oficio_asignacion_juan.pdf</div>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-xs font-bold text-gray-500">
                                <span class="bg-[#3ee055] text-white px-4 py-1.5 rounded-full text-[10px] font-bold shadow-sm uppercase">Aprobado</span>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center gap-3">
                                    <button class="text-[#38bdf8] hover:text-[#0284c7] hover:scale-110 transition-transform" title="Ver Documento">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                    <button class="text-gray-400 hover:text-gray-700 hover:scale-110 transition-transform" title="Descargar">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-[#6BA53A]/5 transition-colors"><td class="px-3 py-6" colspan="5"></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Script para cambiar pestañas -->
    <script>
        function switchTab(tab) {
            // Ocultar contenidos
            document.getElementById('content-solicitudes').classList.add('hidden');
            document.getElementById('content-solicitudes').classList.remove('block');
            document.getElementById('content-documentos').classList.add('hidden');
            document.getElementById('content-documentos').classList.remove('block');
            
            // Reiniciar estilos de pestañas (quitar activo)
            document.getElementById('tab-solicitudes').classList.remove('border-[#6BA53A]', 'text-[#4E7D24]', 'font-extrabold');
            document.getElementById('tab-solicitudes').classList.add('border-transparent', 'text-gray-500', 'font-bold');
            
            document.getElementById('tab-documentos').classList.remove('border-[#6BA53A]', 'text-[#4E7D24]', 'font-extrabold');
            document.getElementById('tab-documentos').classList.add('border-transparent', 'text-gray-500', 'font-bold');
            
            // Mostrar contenido seleccionado y activar pestaña
            if(tab === 'solicitudes') {
                document.getElementById('content-solicitudes').classList.remove('hidden');
                document.getElementById('content-solicitudes').classList.add('block');
                document.getElementById('tab-solicitudes').classList.add('border-[#6BA53A]', 'text-[#4E7D24]', 'font-extrabold');
                document.getElementById('tab-solicitudes').classList.remove('border-transparent', 'text-gray-500', 'font-bold');
            } else {
                document.getElementById('content-documentos').classList.remove('hidden');
                document.getElementById('content-documentos').classList.add('block');
                document.getElementById('tab-documentos').classList.add('border-[#6BA53A]', 'text-[#4E7D24]', 'font-extrabold');
                document.getElementById('tab-documentos').classList.remove('border-transparent', 'text-gray-500', 'font-bold');
            }
        }
    </script>
@endsection
