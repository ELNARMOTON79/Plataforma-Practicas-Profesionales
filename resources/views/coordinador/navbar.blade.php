<!-- Navigation -->
<nav class="relative z-50 bg-white/90 backdrop-blur-md border-b border-gray-200/50 shadow-sm sticky top-0" id="coordinator-navbar">
    @php
        $activeSection = $active ?? '';
        $isGestionActive = in_array($activeSection, ['instituciones', 'proyectos', 'alumnos']);
        $isPracticasActive = in_array($activeSection, ['tramites', 'seguimiento']);
    @endphp

    <!-- Top Bar: Logo & Profile -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 border-b border-gray-100/60">
        <div class="flex justify-between h-16 items-center">
            <!-- Left: Logo & Title -->
            <a href="{{ route('coordinador.dashboard') }}" class="flex items-center shrink-0 group transition-transform hover:scale-[1.01]">
                <img src="{{ asset('images/logo_verde.png') }}" alt="Logo UdeC" class="h-10 w-auto object-contain transition-transform group-hover:scale-105 duration-300">
                <div class="ml-3 flex flex-col justify-center">
                    <span class="text-lg font-extrabold text-gray-900 leading-none whitespace-nowrap">Control de Prácticas</span>
                    <span class="text-[10px] font-bold text-[#4E7D24] uppercase tracking-wider mt-0.5">Panel Coordinación</span>
                </div>
            </a>
            
            <!-- Right: User Profile & Actions -->
            <div class="flex items-center gap-3 shrink-0">
                <!-- User Profile Quick Link -->
                <a href="{{ Route::has('coordinador.perfil') ? route('coordinador.perfil') : '#' }}" 
                   class="flex items-center gap-3 py-1.5 px-3 rounded-2xl hover:bg-gray-100/70 transition-all duration-200 group {{ $activeSection === 'perfil' ? 'bg-[#6BA53A]/10 ring-1 ring-[#4E7D24]/20' : '' }}"
                   title="Ver Mi Perfil">
                    <div class="hidden md:flex flex-col items-end">
                        <span class="text-xs font-bold text-gray-900 leading-none group-hover:text-[#4E7D24] transition-colors">
                            {{ auth()->user()->correo ?? 'Coordinador' }}
                        </span>
                        <span class="text-[10px] font-medium text-[#4E7D24] bg-[#6BA53A]/10 px-2 py-0.5 rounded-md mt-1">
                            Mi Perfil
                        </span>
                    </div>
                    <!-- Avatar Circular Badge -->
                    <div class="h-9 w-9 rounded-full bg-gradient-to-tr from-[#4E7D24] to-[#6BA53A] p-[2px] shadow-sm transition-transform group-hover:scale-105">
                        <div class="h-full w-full rounded-full bg-white flex items-center justify-center">
                            <svg class="w-4.5 h-4.5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                </a>
                
                <div class="h-6 w-px bg-gray-200 mx-0.5 hidden sm:block"></div>
                
                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200/60 rounded-xl text-xs font-bold shadow-sm transition-all flex items-center gap-1.5 hover:scale-105">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span class="hidden sm:inline">Cerrar sesión</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Bottom Bar: Navigation Links (Desktop) -->
    <div class="hidden xl:block bg-white/40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center h-12 gap-2 py-1">
                
                <!-- 1. Inicio Directo -->
                <a href="{{ route('coordinador.dashboard') }}" 
                   class="{{ $activeSection === 'dashboard' ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-4 py-1.5 rounded-xl text-sm font-semibold shadow-xs' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-4 py-1.5 rounded-xl text-sm font-medium transition-all' }}">
                    Inicio
                </a>

                <!-- 2. Menú Desplegable: Gestión -->
                <div class="relative" data-dropdown="gestion">
                    <button type="button" 
                            id="dropdown-btn-gestion"
                            class="flex items-center gap-1.5 px-4 py-1.5 rounded-xl text-sm transition-all cursor-pointer {{ $isGestionActive ? 'text-[#4E7D24] bg-[#6BA53A]/10 font-semibold ring-1 ring-[#4E7D24]/20' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 font-medium' }}"
                            aria-expanded="false"
                            aria-haspopup="true">
                        <span>Gestión</span>
                        <svg class="dropdown-arrow w-3.5 h-3.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Dropdown Panel (with top-full bridge to avoid mouse deadzone) -->
                    <div id="dropdown-menu-gestion"
                         class="dropdown-panel absolute left-1/2 -translate-x-1/2 top-full pt-1.5 w-64 z-50 transition-all duration-200 opacity-0 invisible translate-y-1 pointer-events-none">
                        <div class="rounded-2xl bg-white/95 backdrop-blur-xl border border-gray-100/80 shadow-xl p-2">
                            <div class="px-3 py-1.5 mb-1 border-b border-gray-100/60">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Catálogos y Directorio</span>
                            </div>
                            
                            <!-- Instituciones -->
                            <a href="{{ route('coordinador.instituciones') }}" 
                               class="flex items-start gap-3 p-2.5 rounded-xl transition-all {{ $activeSection === 'instituciones' ? 'bg-[#6BA53A]/10 text-[#4E7D24] font-semibold' : 'text-gray-700 hover:bg-gray-50 hover:text-[#4E7D24]' }}">
                                <div class="p-2 rounded-lg {{ $activeSection === 'instituciones' ? 'bg-[#4E7D24] text-white' : 'bg-gray-100 text-gray-500 hover:text-[#4E7D24]' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs font-bold leading-tight">Instituciones</div>
                                    <div class="text-[10px] text-gray-400 mt-0.5 font-normal">Empresas y Unidades Receptoras</div>
                                </div>
                            </a>

                            <!-- Proyectos -->
                            <a href="{{ route('coordinador.proyectos') }}" 
                               class="flex items-start gap-3 p-2.5 rounded-xl transition-all {{ $activeSection === 'proyectos' ? 'bg-[#6BA53A]/10 text-[#4E7D24] font-semibold' : 'text-gray-700 hover:bg-gray-50 hover:text-[#4E7D24]' }}">
                                <div class="p-2 rounded-lg {{ $activeSection === 'proyectos' ? 'bg-[#4E7D24] text-white' : 'bg-gray-100 text-gray-500 hover:text-[#4E7D24]' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs font-bold leading-tight">Proyectos</div>
                                    <div class="text-[10px] text-gray-400 mt-0.5 font-normal">Plazas y ofertas de prácticas</div>
                                </div>
                            </a>

                            <!-- Alumnos -->
                            <a href="{{ route('coordinador.alumnos') }}" 
                               class="flex items-start gap-3 p-2.5 rounded-xl transition-all {{ $activeSection === 'alumnos' ? 'bg-[#6BA53A]/10 text-[#4E7D24] font-semibold' : 'text-gray-700 hover:bg-gray-50 hover:text-[#4E7D24]' }}">
                                <div class="p-2 rounded-lg {{ $activeSection === 'alumnos' ? 'bg-[#4E7D24] text-white' : 'bg-gray-100 text-gray-500 hover:text-[#4E7D24]' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs font-bold leading-tight">Alumnos</div>
                                    <div class="text-[10px] text-gray-400 mt-0.5 font-normal">Padrón de estudiantes</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 3. Menú Desplegable: Prácticas -->
                <div class="relative" data-dropdown="practicas">
                    <button type="button" 
                            id="dropdown-btn-practicas"
                            class="flex items-center gap-1.5 px-4 py-1.5 rounded-xl text-sm transition-all cursor-pointer {{ $isPracticasActive ? 'text-[#4E7D24] bg-[#6BA53A]/10 font-semibold ring-1 ring-[#4E7D24]/20' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 font-medium' }}"
                            aria-expanded="false"
                            aria-haspopup="true">
                        <span>Prácticas</span>
                        <svg class="dropdown-arrow w-3.5 h-3.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Dropdown Panel (with top-full bridge to avoid mouse deadzone) -->
                    <div id="dropdown-menu-practicas"
                         class="dropdown-panel absolute left-1/2 -translate-x-1/2 top-full pt-1.5 w-64 z-50 transition-all duration-200 opacity-0 invisible translate-y-1 pointer-events-none">
                        <div class="rounded-2xl bg-white/95 backdrop-blur-xl border border-gray-100/80 shadow-xl p-2">
                            <div class="px-3 py-1.5 mb-1 border-b border-gray-100/60">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Flujo Operativo</span>
                            </div>

                            <!-- Trámites -->
                            <a href="{{ route('coordinador.tramites') }}" 
                               class="flex items-start gap-3 p-2.5 rounded-xl transition-all {{ $activeSection === 'tramites' ? 'bg-[#6BA53A]/10 text-[#4E7D24] font-semibold' : 'text-gray-700 hover:bg-gray-50 hover:text-[#4E7D24]' }}">
                                <div class="p-2 rounded-lg {{ $activeSection === 'tramites' ? 'bg-[#4E7D24] text-white' : 'bg-gray-100 text-gray-500 hover:text-[#4E7D24]' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs font-bold leading-tight">Trámites</div>
                                    <div class="text-[10px] text-gray-400 mt-0.5 font-normal">Validación de solicitudes y docs</div>
                                </div>
                            </a>

                            <!-- Seguimiento -->
                            <a href="{{ route('coordinador.seguimiento') }}" 
                               class="flex items-start gap-3 p-2.5 rounded-xl transition-all {{ $activeSection === 'seguimiento' ? 'bg-[#6BA53A]/10 text-[#4E7D24] font-semibold' : 'text-gray-700 hover:bg-gray-50 hover:text-[#4E7D24]' }}">
                                <div class="p-2 rounded-lg {{ $activeSection === 'seguimiento' ? 'bg-[#4E7D24] text-white' : 'bg-gray-100 text-gray-500 hover:text-[#4E7D24]' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs font-bold leading-tight">Seguimiento</div>
                                    <div class="text-[10px] text-gray-400 mt-0.5 font-normal">Alumnos activos y horas</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 4. Informes Directo -->
                <a href="{{ route('coordinador.informes') }}" 
                   class="{{ $activeSection === 'informes' ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-4 py-1.5 rounded-xl text-sm font-semibold shadow-xs' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-4 py-1.5 rounded-xl text-sm font-medium transition-all' }}">
                    Informes
                </a>

            </div>
        </div>
    </div>
    
    <!-- Mobile/Tablet Navigation (Streamlined Pills with Group Indicators) -->
    <div class="xl:hidden border-t border-gray-100 bg-white/95 py-2.5 overflow-x-auto whitespace-nowrap scrollbar-none flex items-center px-4 gap-2">
        <a href="{{ route('coordinador.dashboard') }}" 
           class="{{ $activeSection === 'dashboard' ? 'text-[#4E7D24] bg-[#6BA53A]/15 font-bold' : 'text-gray-600 hover:text-[#4E7D24]' }} px-3 py-1.5 rounded-lg text-xs transition-all">
            Inicio
        </a>
        
        <span class="text-gray-300 text-xs">|</span>

        <!-- Grupo Gestión (Mobile Links) -->
        <a href="{{ route('coordinador.instituciones') }}" 
           class="{{ $activeSection === 'instituciones' ? 'text-[#4E7D24] bg-[#6BA53A]/15 font-bold' : 'text-gray-600 hover:text-[#4E7D24]' }} px-3 py-1.5 rounded-lg text-xs transition-all">
            Instituciones
        </a>
        <a href="{{ route('coordinador.proyectos') }}" 
           class="{{ $activeSection === 'proyectos' ? 'text-[#4E7D24] bg-[#6BA53A]/15 font-bold' : 'text-gray-600 hover:text-[#4E7D24]' }} px-3 py-1.5 rounded-lg text-xs transition-all">
            Proyectos
        </a>
        <a href="{{ route('coordinador.alumnos') }}" 
           class="{{ $activeSection === 'alumnos' ? 'text-[#4E7D24] bg-[#6BA53A]/15 font-bold' : 'text-gray-600 hover:text-[#4E7D24]' }} px-3 py-1.5 rounded-lg text-xs transition-all">
            Alumnos
        </a>

        <span class="text-gray-300 text-xs">|</span>

        <!-- Grupo Prácticas (Mobile Links) -->
        <a href="{{ route('coordinador.tramites') }}" 
           class="{{ $activeSection === 'tramites' ? 'text-[#4E7D24] bg-[#6BA53A]/15 font-bold' : 'text-gray-600 hover:text-[#4E7D24]' }} px-3 py-1.5 rounded-lg text-xs transition-all">
            Trámites
        </a>
        <a href="{{ route('coordinador.seguimiento') }}" 
           class="{{ $activeSection === 'seguimiento' ? 'text-[#4E7D24] bg-[#6BA53A]/15 font-bold' : 'text-gray-600 hover:text-[#4E7D24]' }} px-3 py-1.5 rounded-lg text-xs transition-all">
            Seguimiento
        </a>

        <span class="text-gray-300 text-xs">|</span>

        <a href="{{ route('coordinador.informes') }}" 
           class="{{ $activeSection === 'informes' ? 'text-[#4E7D24] bg-[#6BA53A]/15 font-bold' : 'text-gray-600 hover:text-[#4E7D24]' }} px-3 py-1.5 rounded-lg text-xs transition-all">
            Informes
        </a>
    </div>
</nav>

<script>
    (function() {
        let activeDropdown = null;
        let closeTimeout = null;

        function getDropdownElements(name) {
            const container = document.querySelector(`[data-dropdown="${name}"]`);
            if (!container) return null;
            return {
                container,
                button: container.querySelector('button'),
                menu: container.querySelector('.dropdown-panel'),
                arrow: container.querySelector('.dropdown-arrow')
            };
        }

        function openDropdown(name) {
            if (closeTimeout) {
                clearTimeout(closeTimeout);
                closeTimeout = null;
            }

            // Always close any other open dropdown first
            if (activeDropdown && activeDropdown !== name) {
                closeDropdown(activeDropdown);
            }

            const els = getDropdownElements(name);
            if (!els || !els.menu) return;

            activeDropdown = name;
            els.menu.classList.remove('invisible', 'opacity-0', 'translate-y-1', 'pointer-events-none');
            els.menu.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
            if (els.arrow) els.arrow.classList.add('rotate-180');
            if (els.button) els.button.setAttribute('aria-expanded', 'true');
        }

        function closeDropdown(name) {
            const els = getDropdownElements(name);
            if (!els || !els.menu) return;

            els.menu.classList.add('invisible', 'opacity-0', 'translate-y-1', 'pointer-events-none');
            els.menu.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
            if (els.arrow) els.arrow.classList.remove('rotate-180');
            if (els.button) els.button.setAttribute('aria-expanded', 'false');

            if (activeDropdown === name) {
                activeDropdown = null;
            }
        }

        function closeAll() {
            if (closeTimeout) {
                clearTimeout(closeTimeout);
                closeTimeout = null;
            }
            document.querySelectorAll('[data-dropdown]').forEach(container => {
                const name = container.getAttribute('data-dropdown');
                if (name) closeDropdown(name);
            });
            activeDropdown = null;
        }

        function scheduleClose() {
            if (closeTimeout) clearTimeout(closeTimeout);
            closeTimeout = setTimeout(() => {
                closeAll();
            }, 180);
        }

        function initDropdowns() {
            document.querySelectorAll('[data-dropdown]').forEach(container => {
                const name = container.getAttribute('data-dropdown');
                const button = container.querySelector('button');

                // Hover in: open instantly and cancel close timeout
                container.addEventListener('mouseenter', () => {
                    openDropdown(name);
                });

                // Hover out: schedule close with smooth grace period
                container.addEventListener('mouseleave', () => {
                    scheduleClose();
                });

                // Click / Tap on button
                if (button) {
                    button.addEventListener('click', (e) => {
                        e.stopPropagation();
                        if (activeDropdown === name) {
                            closeDropdown(name);
                        } else {
                            openDropdown(name);
                        }
                    });
                }

                // Close on link click
                container.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        closeAll();
                    });
                });
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initDropdowns);
        } else {
            initDropdowns();
        }

        // Close on outside click
        document.addEventListener('click', (e) => {
            if (!e.target.closest('[data-dropdown]')) {
                closeAll();
            }
        });

        // Close on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeAll();
            }
        });

        // HTMX compatibility: close dropdowns when navigating or swapping
        document.addEventListener('htmx:beforeSwap', closeAll);
        document.addEventListener('htmx:afterSettle', initDropdowns);
    })();
</script>
