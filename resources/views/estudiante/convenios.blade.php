@extends('layouts.estudiante', ['title' => 'Convenios Disponibles - Prácticas Profesionales UdeC', 'active' => 'convenios'])

@section('content')
    <!-- Page Header -->
    <x-page-header title="Empresas y Convenios" description="Consulta las empresas vinculadas y solicita tu participación en proyectos de prácticas profesionales."></x-page-header>

    <!-- Search and Filters -->
    <div class="glass-card rounded-3xl p-6 fade-in-up delay-100">
        <div class="flex flex-col lg:flex-row gap-4 items-center justify-between w-full">
            <!-- Search Input -->
            <div class="relative w-full lg:max-w-md">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" id="companySearch" class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl leading-5 bg-white/70 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/20 focus:border-[#6BA53A] sm:text-sm transition-all shadow-sm" placeholder="Buscar por empresa, proyecto o palabra clave...">
            </div>
            
            <!-- Filters Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 w-full lg:w-auto lg:flex lg:flex-row lg:items-center">
                <!-- Sector Filter -->
                <div class="relative w-full lg:w-56">
                    <select id="sectorFilter" class="block w-full py-3.5 pl-4 pr-10 border border-gray-200 rounded-2xl bg-white/70 text-gray-600 sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/20 focus:border-[#6BA53A] appearance-none transition-all cursor-pointer shadow-sm">
                        <option value="">Todos los sectores</option>
                        <option value="tecnologia">Tecnología / Software</option>
                        <option value="publico">Sector Público</option>
                        <option value="servicios">Servicios / Consultoría</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="relative w-full lg:w-56">
                    <select id="statusFilter" class="block w-full py-3.5 pl-4 pr-10 border border-gray-200 rounded-2xl bg-white/70 text-gray-600 sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/20 focus:border-[#6BA53A] appearance-none transition-all cursor-pointer shadow-sm">
                        <option value="">Todos los convenios</option>
                        <option value="vigente">Convenio Vigente</option>
                        <option value="caducado">Convenio Caducado</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Success Simulation (hidden by default) -->
    <div id="simulatedSuccessAlert" class="hidden fixed top-5 right-5 z-[100] bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl shadow-xl max-w-md fade-in-up flex items-start gap-3">
        <div class="p-1 bg-green-100 text-green-600 rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <div>
            <h4 class="font-bold text-green-950 text-sm">¡Solicitud Enviada con Éxito!</h4>
            <p class="text-xs text-green-900/90 mt-0.5">Tu postulación ha sido registrada en el sistema. Podrás dar seguimiento a su estado en el panel de inicio.</p>
        </div>
        <button onclick="document.getElementById('simulatedSuccessAlert').classList.add('hidden')" class="text-green-500 hover:text-green-800 transition-colors ml-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <!-- Grid of Companies -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 fade-in-up delay-200" id="companiesGrid">
        
        <!-- Company Card 1 -->
        <div class="glass-card rounded-3xl p-6 flex flex-col justify-between border-transparent hover:border-[#6BA53A]/20 transition-colors" data-sector="tecnologia" data-status="vigente">
            <div>
                <div class="flex justify-between items-start gap-4 mb-4">
                    <div>
                        <span class="inline-block text-[10px] font-bold text-blue-600 bg-blue-50 border border-blue-100 px-2 py-0.5 rounded-md mb-2">Tecnología / Software</span>
                        <h3 class="text-xl font-bold text-gray-900">Tech Solutions S.A.</h3>
                    </div>
                    <span class="inline-flex items-center gap-1 text-xs font-bold text-green-700 bg-green-50 border border-green-100 px-2.5 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Vigente
                    </span>
                </div>
                
                <p class="text-sm text-gray-500 font-medium mb-6">Empresa líder en desarrollo de soluciones corporativas, especialidad en aplicaciones móviles y migración a la nube.</p>
                
                <!-- Projects List -->
                <div class="mb-6 bg-white/50 border border-gray-100 rounded-2xl p-4">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Proyectos Disponibles (2)</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center text-sm border-b border-gray-100/50 pb-2">
                            <div>
                                <span class="font-bold text-gray-800 block">Desarrollo de App Móvil</span>
                                <span class="text-[11px] text-gray-500 font-medium">Vacantes: 2 de 3</span>
                            </div>
                            <button onclick="openRequestModal('Tech Solutions S.A.', 'Desarrollo de App Móvil')" class="text-xs font-bold text-[#4E7D24] bg-[#6BA53A]/10 px-3 py-1.5 rounded-lg hover:bg-[#4E7D24] hover:text-white transition-all shadow-sm">Postularse</button>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <div>
                                <span class="font-bold text-gray-800 block">Soporte y QA Automatizado</span>
                                <span class="text-[11px] text-gray-500 font-medium">Vacantes: 1 de 2</span>
                            </div>
                            <button onclick="openRequestModal('Tech Solutions S.A.', 'Soporte y QA Automatizado')" class="text-xs font-bold text-[#4E7D24] bg-[#6BA53A]/10 px-3 py-1.5 rounded-lg hover:bg-[#4E7D24] hover:text-white transition-all shadow-sm">Postularse</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-xs text-gray-400 font-medium pt-3 border-t border-gray-100/50 flex justify-between">
                <span>Razón Social: Tech Solutions de Colima S.A. de C.V.</span>
                <span>Vigencia: 24/Nov/2026</span>
            </div>
        </div>

        <!-- Company Card 2 -->
        <div class="glass-card rounded-3xl p-6 flex flex-col justify-between border-transparent hover:border-[#6BA53A]/20 transition-colors" data-sector="tecnologia" data-status="vigente">
            <div>
                <div class="flex justify-between items-start gap-4 mb-4">
                    <div>
                        <span class="inline-block text-[10px] font-bold text-blue-600 bg-blue-50 border border-blue-100 px-2 py-0.5 rounded-md mb-2">Tecnología / Software</span>
                        <h3 class="text-xl font-bold text-gray-900">Innova Tech</h3>
                    </div>
                    <span class="inline-flex items-center gap-1 text-xs font-bold text-green-700 bg-green-50 border border-green-100 px-2.5 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Vigente
                    </span>
                </div>
                
                <p class="text-sm text-gray-500 font-medium mb-6">Agencia de desarrollo web y consultoría ágil enfocada en el diseño de interfaces interactivas y arquitecturas robustas.</p>
                
                <!-- Projects List -->
                <div class="mb-6 bg-white/50 border border-gray-100 rounded-2xl p-4">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Proyectos Disponibles (1)</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center text-sm">
                            <div>
                                <span class="font-bold text-gray-800 block">Automatización de Pruebas QA</span>
                                <span class="text-[11px] text-gray-500 font-medium">Vacantes: 1 de 2</span>
                            </div>
                            <button onclick="openRequestModal('Innova Tech', 'Automatización de Pruebas QA')" class="text-xs font-bold text-[#4E7D24] bg-[#6BA53A]/10 px-3 py-1.5 rounded-lg hover:bg-[#4E7D24] hover:text-white transition-all shadow-sm">Postularse</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-xs text-gray-400 font-medium pt-3 border-t border-gray-100/50 flex justify-between">
                <span>Razón Social: Innovación Tecnológica del Pacífico S.A.</span>
                <span>Vigencia: 15/Ene/2027</span>
            </div>
        </div>

        <!-- Company Card 3 -->
        <div class="glass-card rounded-3xl p-6 flex flex-col justify-between border-transparent hover:border-red-200 transition-colors opacity-75 hover:opacity-100 transition-opacity" data-sector="servicios" data-status="caducado">
            <div>
                <div class="flex justify-between items-start gap-4 mb-4">
                    <div>
                        <span class="inline-block text-[10px] font-bold text-purple-600 bg-purple-50 border border-purple-100 px-2 py-0.5 rounded-md mb-2">Servicios / Consultoría</span>
                        <h3 class="text-xl font-bold text-gray-900">Consultores de Colima</h3>
                    </div>
                    <span class="inline-flex items-center gap-1 text-xs font-bold text-red-700 bg-red-50 border border-red-100 px-2.5 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Caducado
                    </span>
                </div>
                
                <p class="text-sm text-gray-500 font-medium mb-6">Despacho contable y administrativo con más de 15 años de experiencia brindando auditorías financieras y consultoría fiscal.</p>
                
                <!-- Projects List -->
                <div class="mb-6 bg-gray-50/50 border border-dashed border-gray-200 rounded-2xl p-4">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Proyectos Disponibles (0)</h4>
                    <p class="text-xs text-gray-400 font-medium">No se pueden solicitar prácticas en esta empresa debido a convenio inactivo.</p>
                </div>
            </div>

            <div class="text-xs text-gray-400 font-medium pt-3 border-t border-gray-100/50 flex justify-between">
                <span>Razón Social: Consultores Asociados del Estado S.C.</span>
                <span>Vigencia: 10/Mar/2026 (Expirado)</span>
            </div>
        </div>

        <!-- Company Card 4 -->
        <div class="glass-card rounded-3xl p-6 flex flex-col justify-between border-transparent hover:border-[#6BA53A]/20 transition-colors" data-sector="publico" data-status="vigente">
            <div>
                <div class="flex justify-between items-start gap-4 mb-4">
                    <div>
                        <span class="inline-block text-[10px] font-bold text-orange-600 bg-orange-50 border border-orange-100 px-2 py-0.5 rounded-md mb-2">Sector Público</span>
                        <h3 class="text-xl font-bold text-gray-900">Gobierno del Estado</h3>
                    </div>
                    <span class="inline-flex items-center gap-1 text-xs font-bold text-green-700 bg-green-50 border border-green-100 px-2.5 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Vigente
                    </span>
                </div>
                
                <p class="text-sm text-gray-500 font-medium mb-6">Secretaría de Fomento y Vinculación, encargada del desarrollo digital y modernización de trámites y portales estatales.</p>
                
                <!-- Projects List -->
                <div class="mb-6 bg-white/50 border border-gray-100 rounded-2xl p-4">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Proyectos Disponibles (1)</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center text-sm">
                            <div>
                                <span class="font-bold text-gray-800 block">Rediseño de Portal Ciudadano</span>
                                <span class="text-[11px] text-gray-500 font-medium">Vacantes: 3 de 5</span>
                            </div>
                            <button onclick="openRequestModal('Gobierno del Estado', 'Rediseño de Portal Ciudadano')" class="text-xs font-bold text-[#4E7D24] bg-[#6BA53A]/10 px-3 py-1.5 rounded-lg hover:bg-[#4E7D24] hover:text-white transition-all shadow-sm">Postularse</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-xs text-gray-400 font-medium pt-3 border-t border-gray-100/50 flex justify-between">
                <span>Razón Social: Gobierno Constitucional del Estado de Colima</span>
                <span>Vigencia: 05/Sep/2027</span>
            </div>
        </div>

    </div>

    <!-- Request Modal (Simulated overlay) -->
    <div id="requestModal" class="hidden fixed inset-0 z-[99] bg-black/40 backdrop-blur-sm flex items-center justify-center p-4 transition-all">
        <div class="bg-white/95 rounded-3xl shadow-2xl border border-gray-200 max-w-lg w-full overflow-hidden fade-in-up">
            <div class="bg-gradient-to-r from-[#4E7D24] to-[#6BA53A] p-6 text-white flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-extrabold" id="modalCompanyTitle">Solicitud de Prácticas</h3>
                    <p class="text-xs text-white/80 mt-1 font-semibold" id="modalProjectSubtitle">Proyecto: Cargando...</p>
                </div>
                <button onclick="closeRequestModal()" class="text-white/80 hover:text-white transition-colors bg-white/10 hover:bg-white/20 p-2 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 space-y-5">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Detalles Académicos</label>
                    <div class="bg-gray-50 border border-gray-100 rounded-2xl p-4 text-sm space-y-1.5 text-gray-700 font-medium">
                        <p><span class="text-gray-450 font-semibold">Postulante:</span> {{ auth()->user()->correo }}</p>
                        <p><span class="text-gray-450 font-semibold">Carrera:</span> Ingeniería en Software (6° Semestre)</p>
                    </div>
                </div>

                <div>
                    <label for="motivationLetter" class="block text-xs font-bold text-gray-450 uppercase tracking-wider mb-2">Carta de Exposición de Motivos (Opcional)</label>
                    <textarea id="motivationLetter" rows="4" class="block w-full border border-gray-200 rounded-2xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/20 focus:border-[#6BA53A] placeholder-gray-400 transition-all font-medium" placeholder="Escribe brevemente por qué te interesa participar en este proyecto y qué habilidades puedes aportar..."></textarea>
                </div>

                <div class="flex items-start gap-3">
                    <input type="checkbox" id="acceptTerms" class="mt-1 rounded border-gray-300 text-[#4E7D24] focus:ring-[#6BA53A]">
                    <label for="acceptTerms" class="text-xs text-gray-500 font-medium leading-relaxed">
                        Confirmo que cumplo con el avance de créditos necesarios para iniciar mis prácticas profesionales y me comprometo a cumplir con los reglamentos de la institución receptora.
                    </label>
                </div>
            </div>

            <div class="p-6 bg-gray-50/50 border-t border-gray-100 flex gap-3">
                <button onclick="closeRequestModal()" class="flex-1 bg-white border border-gray-200 hover:bg-gray-50 text-gray-600 font-bold py-3 px-4 rounded-xl text-sm transition-colors shadow-sm">Cancelar</button>
                <button onclick="submitRequest()" class="flex-1 bg-[#4E7D24] hover:bg-[#3A5D1B] text-white font-bold py-3 px-4 rounded-xl text-sm transition-all shadow-md shadow-green-900/10">Enviar Postulación</button>
            </div>
        </div>
    </div>

    <!-- Client-side filtering script -->
    <script>
        // Modal management
        function openRequestModal(company, project) {
            document.getElementById('modalCompanyTitle').textContent = `Solicitar en: ${company}`;
            document.getElementById('modalProjectSubtitle').textContent = `Proyecto: ${project}`;
            document.getElementById('motivationLetter').value = '';
            document.getElementById('acceptTerms').checked = false;
            document.getElementById('requestModal').classList.remove('hidden');
        }

        function closeRequestModal() {
            document.getElementById('requestModal').classList.add('hidden');
        }

        function submitRequest() {
            const acceptTerms = document.getElementById('acceptTerms').checked;
            if (!acceptTerms) {
                alert('Por favor, acepta los términos del reglamento para continuar.');
                return;
            }
            
            // Close modal
            closeRequestModal();
            
            // Show success notification
            const alertBox = document.getElementById('simulatedSuccessAlert');
            alertBox.classList.remove('hidden');
            
            // Hide notification after 8 seconds
            setTimeout(() => {
                alertBox.classList.add('hidden');
            }, 8000);
        }

        // Live Search & Filtering
        const searchInput = document.getElementById('companySearch');
        const sectorFilter = document.getElementById('sectorFilter');
        const statusFilter = document.getElementById('statusFilter');
        const companiesGrid = document.getElementById('companiesGrid');
        const cards = companiesGrid.getElementsByClassName('glass-card');

        function filterList() {
            const searchQuery = searchInput.value.toLowerCase();
            const sectorValue = sectorFilter.value;
            const statusValue = statusFilter.value;

            for (let card of cards) {
                const title = card.querySelector('h3').textContent.toLowerCase();
                const description = card.querySelector('p').textContent.toLowerCase();
                const sector = card.getAttribute('data-sector');
                const status = card.getAttribute('data-status');
                
                const matchesSearch = title.includes(searchQuery) || description.includes(searchQuery);
                const matchesSector = sectorValue === "" || sector === sectorValue;
                const matchesStatus = statusValue === "" || status === statusValue;

                if (matchesSearch && matchesSector && matchesStatus) {
                    card.style.display = 'flex';
                } else {
                    card.style.style = 'none'; // Fallback
                    card.style.setProperty('display', 'none', 'important');
                }
            }
        }

        searchInput.addEventListener('input', filterList);
        sectorFilter.addEventListener('change', filterList);
        statusFilter.addEventListener('change', filterList);
    </script>
@endsection
