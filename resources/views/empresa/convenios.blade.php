@extends('layouts.empresa', ['title' => 'Convenio Institucional - Prácticas Profesionales UdeC', 'active' => 'convenios'])

@section('content')
    <!-- Header -->
    <x-page-header title="Convenio Institucional" description="Consulta la vigencia de tu convenio de prácticas y gestiona solicitudes de renovación con la Universidad de Colima.">
        <!-- Developer Controls to demo states -->
        <x-slot name="actions">
            <div class="bg-white/80 border border-gray-200 p-2 rounded-2xl flex items-center gap-2 shadow-sm text-xs font-semibold text-gray-500">
                <span class="pl-2">Simular Estado:</span>
                <button onclick="changeAgreementStatus('vigente')" class="px-2.5 py-1.5 rounded-lg bg-green-50 text-green-700 hover:bg-green-100 transition-colors cursor-pointer">Vigente</button>
                <button onclick="changeAgreementStatus('caducado')" class="px-2.5 py-1.5 rounded-lg bg-red-50 text-red-700 hover:bg-red-100 transition-colors cursor-pointer">Caducado</button>
                <button onclick="changeAgreementStatus('proceso')" class="px-2.5 py-1.5 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 transition-colors cursor-pointer">En Proceso</button>
            </div>
        </x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column (65%): Status Banner & History -->
        <div class="lg:col-span-2 flex flex-col gap-8">
            
            <!-- Dynamic Agreement Banner -->
            <div id="statusBanner" class="glass-card rounded-3xl p-8 transition-all duration-300 bg-gradient-to-br from-white to-green-50/20 border-l-4 border-l-green-500">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <div>
                        <span id="statusBadge" class="px-3 py-1 bg-green-100 text-green-800 border border-green-200 rounded-full text-xs font-extrabold uppercase tracking-wider">Convenio Vigente</span>
                        <h2 class="text-2xl font-bold text-gray-900 mt-2">Convenio General UdeC-Empresa</h2>
                        <p class="text-sm text-gray-500 font-medium">Folio de Registro: <span class="font-bold text-gray-700" id="folioNumber">CONV-2024-118</span></p>
                    </div>
                    
                    <!-- Time Remaining Circle Indicator -->
                    <div class="flex items-center gap-3 bg-white/60 p-3 rounded-2xl border border-gray-150">
                        <div class="relative w-12 h-12 flex items-center justify-center">
                            <!-- Circular progress svg -->
                            <svg class="w-full h-full transform -rotate-90">
                                <circle cx="24" cy="24" r="20" stroke="#f1f5f9" stroke-width="4" fill="transparent"></circle>
                                <circle id="circleProgress" cx="24" cy="24" r="20" stroke="#6BA53A" stroke-width="4" fill="transparent" stroke-linecap="round" stroke-dasharray="125" stroke-dashoffset="35"></circle>
                            </svg>
                            <span class="absolute text-[10px] font-extrabold text-gray-700" id="percentRemaining">72%</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-gray-400 block font-bold uppercase">Restante</span>
                            <span class="text-sm font-extrabold text-gray-800" id="daysRemaining">188 días</span>
                        </div>
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 py-6 border-t border-b border-gray-150 mb-6 text-sm">
                    <div>
                        <span class="text-xs text-gray-400 block font-bold uppercase tracking-wider mb-1">Fecha de Inicio</span>
                        <span class="font-bold text-gray-800" id="startDateText">24 de Noviembre de 2024</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 block font-bold uppercase tracking-wider mb-1">Fecha de Término</span>
                        <span class="font-bold text-gray-800" id="endDateText">24 de Noviembre de 2026</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 block font-bold uppercase tracking-wider mb-1">Tipo de Convenio</span>
                        <span class="font-bold text-gray-800">Prácticas Profesionales</span>
                    </div>
                </div>

                <!-- Document link & action -->
                <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-red-50 text-red-600 rounded-xl">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A1 1 0 0112 2.586L15.414 6A1 1 0 0116 6.586V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                        </div>
                        <div>
                            <span class="text-sm font-bold text-gray-800 block">Convenio_General_Firmado.pdf</span>
                            <span class="text-xs text-gray-400 font-semibold">PDF firmado por Rectoría y Representante · 2.4 MB</span>
                        </div>
                    </div>
                    <button onclick="downloadMockPDF()" class="w-full sm:w-auto bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 font-bold px-4 py-2.5 rounded-2xl text-xs flex items-center justify-center gap-2 transition-all cursor-pointer shadow-sm">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Descargar Convenio
                    </button>
                </div>
            </div>

            <!-- Agreement History -->
            <div class="glass-card rounded-3xl p-6 flex flex-col">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Historial de Convenios
                </h3>

                <div class="overflow-x-auto bg-white/60 border border-gray-100 rounded-2xl">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Folio</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Período</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tipo</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Estatus</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Documento</th>
                            </tr>
                        </thead>
                        <tbody class="bg-transparent divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-800">CONV-2022-045</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600 font-medium">24/Nov/2022 - 24/Nov/2024</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">Prácticas Prof.</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded text-xs font-semibold">Expirado</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <button onclick="downloadMockPDF()" class="text-xs font-bold text-[#6BA53A] hover:text-[#4E7D24] transition-all cursor-pointer">PDF</button>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-800">CONV-2020-012</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600 font-medium">10/Oct/2020 - 10/Oct/2022</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">Convenio Inicial</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded text-xs font-semibold">Expirado</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <button onclick="downloadMockPDF()" class="text-xs font-bold text-[#6BA53A] hover:text-[#4E7D24] transition-all cursor-pointer">PDF</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Right Column (35%): Company Profile Details & Renewal Actions -->
        <div class="flex flex-col gap-8">
            
            <!-- Renewal / Action Panel -->
            <div id="renewalActionPanel" class="glass-card rounded-3xl p-6 bg-gradient-to-br from-white to-[#6BA53A]/5 border border-[#6BA53A]/15 relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-32 h-32 bg-[#4E7D24] rounded-full mix-blend-multiply filter blur-2xl opacity-10 group-hover:opacity-15 transition-opacity"></div>
                
                <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center gap-2 relative z-10">
                    <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 8H18.2"></path></svg>
                    Gestión de Renovación
                </h3>
                
                <div id="renewalPanelContent" class="space-y-4 relative z-10 text-sm">
                    <!-- Default (Vigente) -->
                    <div id="renewalDefault">
                        <p class="text-gray-600 leading-relaxed mb-4">
                            Tu convenio de colaboración está <span class="text-green-600 font-bold">Vigente</span>. La renovación se habilitará 30 días antes de su vencimiento automático.
                        </p>
                        <button disabled class="w-full bg-gray-100 text-gray-400 py-3 rounded-2xl text-xs font-bold cursor-not-allowed border border-gray-200">
                            Renovación No Disponible
                        </button>
                    </div>

                    <!-- Expired Form (Caducado) -->
                    <div id="renewalForm" class="hidden space-y-4">
                        <p class="text-red-600 font-semibold leading-relaxed">
                            ¡ATENCIÓN! Tu convenio actual ha caducado. Es indispensable solicitar una renovación para poder continuar registrando proyectos y recibiendo alumnos.
                        </p>
                        <form id="renewalRequestForm" onsubmit="event.preventDefault();" class="space-y-4">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Comentarios para el Coordinador</label>
                                <textarea id="renewalComment" rows="3" placeholder="Ej. Solicitamos la renovación del convenio debido a que iniciamos periodo de prácticas..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-2xl text-xs font-medium resize-none focus:outline-none focus:ring-2 focus:ring-[#6BA53A] focus:bg-white transition-all"></textarea>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Carta de Petición (Opcional - PDF)</label>
                                <div class="border border-dashed border-gray-300 bg-gray-50 p-4 rounded-2xl flex flex-col items-center justify-center cursor-pointer hover:bg-gray-100/50 transition-all">
                                    <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    <span class="text-[11px] font-bold text-gray-600">Arrastrar archivo o Buscar</span>
                                    <span class="text-[9px] text-gray-400 font-semibold mt-0.5">Formatos aceptados: PDF (.pdf)</span>
                                </div>
                            </div>
                            <button onclick="submitRenewal()" class="w-full bg-[#6BA53A] hover:bg-[#4E7D24] text-white py-3 rounded-2xl text-xs font-bold transition-all shadow-sm cursor-pointer">
                                Enviar Solicitud de Renovación
                            </button>
                        </form>
                    </div>

                    <!-- In process (En Proceso) -->
                    <div id="renewalInProcess" class="hidden">
                        <div class="p-4 bg-blue-50 border border-blue-100 rounded-2xl text-blue-700 space-y-3 mb-4">
                            <span class="text-xs font-extrabold uppercase block tracking-wider">Solicitud Enviada</span>
                            <p class="text-xs leading-relaxed">
                                Tu solicitud de renovación se encuentra en revisión por el Coordinador de Prácticas. Se te notificará una vez sea autorizada y firmada.
                            </p>
                        </div>
                        <div class="text-xs text-gray-400 font-semibold text-center border-t border-gray-150 pt-4">
                            Fecha de Solicitud: Hoy
                        </div>
                    </div>
                </div>
            </div>

            <!-- Company Registered Data -->
            <div class="glass-card rounded-3xl p-6 flex flex-col">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Datos de la Empresa
                </h3>

                <div class="space-y-4 text-sm">
                    <div>
                        <span class="text-[10px] text-gray-400 block font-bold uppercase tracking-wider">Razón Social</span>
                        <span class="font-bold text-gray-800">Tech Solutions S.A. de C.V.</span>
                    </div>

                    <div>
                        <span class="text-[10px] text-gray-400 block font-bold uppercase tracking-wider">RFC / Identificación Fiscal</span>
                        <span class="font-bold text-gray-800">TSO120405H43</span>
                    </div>

                    <div>
                        <span class="text-[10px] text-gray-400 block font-bold uppercase tracking-wider">Giro Comercial</span>
                        <span class="font-bold text-gray-800">Desarrollo de Software y Consultoría TI</span>
                    </div>

                    <div class="border-t border-gray-100 pt-4">
                        <span class="text-[10px] text-gray-400 block font-bold uppercase tracking-wider">Representante Legal</span>
                        <span class="font-bold text-gray-800">Lic. Martín Corona V.</span>
                        <span class="text-xs text-gray-500 block">mcorona@techsolutions.com</span>
                    </div>

                    <div>
                        <span class="text-[10px] text-gray-400 block font-bold uppercase tracking-wider">Teléfono de Oficina</span>
                        <span class="font-bold text-gray-800">312-316-1234</span>
                    </div>

                    <div class="border-t border-gray-100 pt-4">
                        <span class="text-[10px] text-gray-400 block font-bold uppercase tracking-wider">Dirección Física</span>
                        <span class="font-medium text-gray-600 text-xs leading-relaxed block">Av. Universidad 333, Las Víboras, Colima, Col. C.P. 28040</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- JS Handling for Mock States -->
    <script>
        function changeAgreementStatus(status) {
            const banner = document.getElementById('statusBanner');
            const badge = document.getElementById('statusBadge');
            const folio = document.getElementById('folioNumber');
            const circle = document.getElementById('circleProgress');
            const percent = document.getElementById('percentRemaining');
            const days = document.getElementById('daysRemaining');
            const startDate = document.getElementById('startDateText');
            const endDate = document.getElementById('endDateText');
            
            // Renewal blocks
            const renewalDefault = document.getElementById('renewalDefault');
            const renewalForm = document.getElementById('renewalForm');
            const renewalInProcess = document.getElementById('renewalInProcess');
            
            // Clean up banner classes
            banner.className = "glass-card rounded-3xl p-8 transition-all duration-300";

            if (status === 'vigente') {
                // Banner styles
                banner.classList.add('bg-gradient-to-br', 'from-white', 'to-green-50/20', 'border-l-4', 'border-l-green-500');
                badge.className = "px-3 py-1 bg-green-100 text-green-800 border border-green-200 rounded-full text-xs font-extrabold uppercase tracking-wider";
                badge.textContent = "Convenio Vigente";
                folio.textContent = "CONV-2024-118";
                
                // SVG Progress
                circle.setAttribute('stroke', '#6BA53A');
                circle.setAttribute('stroke-dashoffset', '35'); // 72%
                percent.textContent = "72%";
                days.textContent = "188 días";
                
                startDate.textContent = "24 de Noviembre de 2024";
                endDate.textContent = "24 de Noviembre de 2026";
                
                // Renewal panel
                renewalDefault.classList.remove('hidden');
                renewalForm.classList.add('hidden');
                renewalInProcess.classList.add('hidden');
            } 
            else if (status === 'caducado') {
                // Banner styles
                banner.classList.add('bg-gradient-to-br', 'from-white', 'to-red-50/20', 'border-l-4', 'border-l-red-500');
                badge.className = "px-3 py-1 bg-red-100 text-red-800 border border-red-200 rounded-full text-xs font-extrabold uppercase tracking-wider";
                badge.textContent = "Convenio Caducado";
                folio.textContent = "CONV-2022-045";
                
                // SVG Progress
                circle.setAttribute('stroke', '#ef4444');
                circle.setAttribute('stroke-dashoffset', '125'); // 0%
                percent.textContent = "0%";
                days.textContent = "0 días (Vencido)";
                
                startDate.textContent = "24 de Noviembre de 2022";
                endDate.textContent = "24 de Noviembre de 2024";
                
                // Renewal panel
                renewalDefault.classList.add('hidden');
                renewalForm.classList.remove('hidden');
                renewalInProcess.classList.add('hidden');
            } 
            else if (status === 'proceso') {
                // Banner styles
                banner.classList.add('bg-gradient-to-br', 'from-white', 'to-blue-50/20', 'border-l-4', 'border-l-blue-500');
                badge.className = "px-3 py-1 bg-blue-100 text-blue-800 border border-blue-200 rounded-full text-xs font-extrabold uppercase tracking-wider";
                badge.textContent = "En Renovación";
                folio.textContent = "CONV-2026-PEND";
                
                // SVG Progress
                circle.setAttribute('stroke', '#3b82f6');
                circle.setAttribute('stroke-dashoffset', '125'); // 0% but blue
                percent.textContent = "0%";
                days.textContent = "Espera Firma";
                
                startDate.textContent = "En Proceso";
                endDate.textContent = "Pendiente Autorización";
                
                // Renewal panel
                renewalDefault.classList.add('hidden');
                renewalForm.classList.add('hidden');
                renewalInProcess.classList.remove('hidden');
            }
        }

        function submitRenewal() {
            const comment = document.getElementById('renewalComment').value.trim();
            alert('¡Simulación: Petición de renovación enviada con éxito al Coordinador de Prácticas!');
            changeAgreementStatus('proceso');
        }

        function downloadMockPDF() {
            alert('¡Simulación: Iniciando la descarga del documento firmado en PDF!');
        }
    </script>
@endsection
