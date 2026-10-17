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
                <img src="{{ asset('images/logo_verde.png') }}" alt="Logo UdeC" class="h-9 sm:h-10 w-auto object-contain transition-transform group-hover:scale-105 duration-300">
                <div class="ml-2.5 sm:ml-3 flex flex-col justify-center">
                    <span class="text-sm sm:text-lg font-extrabold text-gray-900 leading-tight whitespace-nowrap">Control de Prácticas</span>
                    <span class="text-[9px] sm:text-[10px] font-bold text-[#4E7D24] uppercase tracking-wider">Panel Coordinación</span>
                </div>
            </a>
            
            <!-- Right: Desktop Profile & Actions (>= xl) -->
            <div class="hidden xl:flex items-center gap-3 shrink-0">
                <!-- User Profile Quick Link -->
                <a href="{{ Route::has('coordinador.perfil') ? route('coordinador.perfil') : '#' }}" 
                   class="flex items-center gap-3 py-1.5 px-3 rounded-2xl hover:bg-gray-100/70 transition-all duration-200 group {{ $activeSection === 'perfil' ? 'bg-[#6BA53A]/10 ring-1 ring-[#4E7D24]/20' : '' }}"
                   title="Ver Mi Perfil">
                    <div class="flex flex-col items-end">
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
                
                <div class="h-6 w-px bg-gray-200 mx-0.5"></div>
                
                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200/60 rounded-xl text-xs font-bold shadow-sm transition-all flex items-center gap-1.5 hover:scale-105 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Cerrar sesión</span>
                    </button>
                </form>
            </div>

            <!-- Mobile Hamburger Button & Quick Avatar (< xl) -->
            <div class="flex xl:hidden items-center gap-2">
                <!-- User Profile Quick Icon -->
                <a href="{{ Route::has('coordinador.perfil') ? route('coordinador.perfil') : '#' }}" 
                   class="h-9 w-9 rounded-full bg-gradient-to-tr from-[#4E7D24] to-[#6BA53A] p-[2px] shadow-sm flex items-center justify-center transition-transform hover:scale-105"
                   title="Ver Mi Perfil">
                    <div class="h-full w-full rounded-full bg-white flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </a>

                <!-- Hamburger Button (☰ / ✕) -->
                <button type="button" 
                        id="mobile-menu-btn"
                        class="p-2 rounded-xl text-gray-700 hover:text-[#4E7D24] hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/30 cursor-pointer"
                        aria-label="Abrir menú de navegación"
                        aria-expanded="false">
                    <!-- Icon 3 bars (Open) -->
                    <svg id="hamburger-icon-open" class="w-6 h-6 block transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <!-- Icon X (Close) -->
                    <svg id="hamburger-icon-close" class="w-6 h-6 hidden transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
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
    
    <!-- Mobile Navigation Drawer (< xl) -->
    <div id="mobile-menu-drawer" 
         class="xl:hidden hidden border-t border-gray-100 bg-white/95 backdrop-blur-xl shadow-2xl transition-all duration-300 max-h-[85vh] overflow-y-auto">
        <div class="px-4 py-3 space-y-3">
            
            <!-- 1. Inicio -->
            <div>
                <a href="{{ route('coordinador.dashboard') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-bold transition-all {{ $activeSection === 'dashboard' ? 'bg-[#6BA53A]/15 text-[#4E7D24] ring-1 ring-[#4E7D24]/20' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="p-1.5 rounded-lg {{ $activeSection === 'dashboard' ? 'bg-[#4E7D24] text-white' : 'bg-gray-100 text-gray-500' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <span>Inicio (Dashboard)</span>
                </a>
            </div>

            <!-- 2. Catálogos y Directorio (Gestión) -->
            <div class="pt-2 border-t border-gray-100">
                <div class="px-3 pb-1 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                    Catálogos y Directorio
                </div>
                <div class="space-y-1">
                    <a href="{{ route('coordinador.instituciones') }}" 
                       class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-sm font-semibold transition-all {{ $activeSection === 'instituciones' ? 'bg-[#6BA53A]/15 text-[#4E7D24]' : 'text-gray-700 hover:bg-gray-50' }}">
                        <div class="p-1.5 rounded-lg {{ $activeSection === 'instituciones' ? 'bg-[#4E7D24] text-white' : 'bg-gray-100 text-gray-500' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="leading-tight">Instituciones</div>
                            <div class="text-[10px] text-gray-400 font-normal">Empresas y Unidades Receptoras</div>
                        </div>
                    </a>

                    <a href="{{ route('coordinador.proyectos') }}" 
                       class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-sm font-semibold transition-all {{ $activeSection === 'proyectos' ? 'bg-[#6BA53A]/15 text-[#4E7D24]' : 'text-gray-700 hover:bg-gray-50' }}">
                        <div class="p-1.5 rounded-lg {{ $activeSection === 'proyectos' ? 'bg-[#4E7D24] text-white' : 'bg-gray-100 text-gray-500' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="leading-tight">Proyectos</div>
                            <div class="text-[10px] text-gray-400 font-normal">Plazas y ofertas de prácticas</div>
                        </div>
                    </a>

                    <a href="{{ route('coordinador.alumnos') }}" 
                       class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-sm font-semibold transition-all {{ $activeSection === 'alumnos' ? 'bg-[#6BA53A]/15 text-[#4E7D24]' : 'text-gray-700 hover:bg-gray-50' }}">
                        <div class="p-1.5 rounded-lg {{ $activeSection === 'alumnos' ? 'bg-[#4E7D24] text-white' : 'bg-gray-100 text-gray-500' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="leading-tight">Alumnos</div>
                            <div class="text-[10px] text-gray-400 font-normal">Padrón de estudiantes</div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- 3. Flujo Operativo (Prácticas) -->
            <div class="pt-2 border-t border-gray-100">
                <div class="px-3 pb-1 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                    Flujo Operativo
                </div>
                <div class="space-y-1">
                    <a href="{{ route('coordinador.tramites') }}" 
                       class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-sm font-semibold transition-all {{ $activeSection === 'tramites' ? 'bg-[#6BA53A]/15 text-[#4E7D24]' : 'text-gray-700 hover:bg-gray-50' }}">
                        <div class="p-1.5 rounded-lg {{ $activeSection === 'tramites' ? 'bg-[#4E7D24] text-white' : 'bg-gray-100 text-gray-500' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="leading-tight">Trámites</div>
                            <div class="text-[10px] text-gray-400 font-normal">Validación de solicitudes y docs</div>
                        </div>
                    </a>

                    <a href="{{ route('coordinador.seguimiento') }}" 
                       class="flex items-center gap-3 px-3.5 py-2 rounded-xl text-sm font-semibold transition-all {{ $activeSection === 'seguimiento' ? 'bg-[#6BA53A]/15 text-[#4E7D24]' : 'text-gray-700 hover:bg-gray-50' }}">
                        <div class="p-1.5 rounded-lg {{ $activeSection === 'seguimiento' ? 'bg-[#4E7D24] text-white' : 'bg-gray-100 text-gray-500' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="leading-tight">Seguimiento</div>
                            <div class="text-[10px] text-gray-400 font-normal">Alumnos activos y horas</div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- 4. Informes -->
            <div class="pt-2 border-t border-gray-100">
                <a href="{{ route('coordinador.informes') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition-all {{ $activeSection === 'informes' ? 'bg-[#6BA53A]/15 text-[#4E7D24]' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="p-1.5 rounded-lg {{ $activeSection === 'informes' ? 'bg-[#4E7D24] text-white' : 'bg-gray-100 text-gray-500' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span>Informes y Reportes</span>
                </a>
            </div>

            <!-- 5. Perfil y Cerrar Sesión en Móvil -->
            <div class="pt-3 border-t border-gray-100 flex flex-col gap-2 pb-1">
                <a href="{{ Route::has('coordinador.perfil') ? route('coordinador.perfil') : '#' }}" 
                   class="flex items-center justify-between p-2.5 rounded-xl bg-gray-50 hover:bg-gray-100 transition-all">
                    <div class="flex items-center gap-2.5">
                        <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-[#4E7D24] to-[#6BA53A] p-[2px]">
                            <div class="h-full w-full rounded-full bg-white flex items-center justify-center">
                                <svg class="w-4 h-4 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="text-left">
                            <div class="text-xs font-bold text-gray-900 leading-none truncate max-w-[190px]">{{ auth()->user()->correo ?? 'Coordinador' }}</div>
                            <div class="text-[10px] text-[#4E7D24] font-medium mt-0.5">Mi Perfil</div>
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="w-full py-2 px-4 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200/60 rounded-xl text-xs font-bold shadow-xs transition-all flex items-center justify-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Cerrar sesión</span>
                    </button>
                </form>
            </div>

        </div>
    </div>
</nav>

<script>
    (function() {
        let activeDropdown = null;
        let closeTimeout = null;

        // --- Desktop Dropdown Functions ---
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

                container.addEventListener('mouseenter', () => {
                    openDropdown(name);
                });

                container.addEventListener('mouseleave', () => {
                    scheduleClose();
                });

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

                container.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        closeAll();
                    });
                });
            });
        }

        // --- Mobile Hamburger Drawer Logic ---
        const mobileBtn = document.getElementById('mobile-menu-btn');
        const mobileDrawer = document.getElementById('mobile-menu-drawer');
        const iconOpen = document.getElementById('hamburger-icon-open');
        const iconClose = document.getElementById('hamburger-icon-close');

        function toggleMobileMenu() {
            if (!mobileDrawer) return;
            const isClosed = mobileDrawer.classList.contains('hidden');
            if (isClosed) {
                openMobileMenu();
            } else {
                closeMobileMenu();
            }
        }

        function openMobileMenu() {
            if (!mobileDrawer) return;
            closeAll(); // close any open desktop dropdowns
            mobileDrawer.classList.remove('hidden');
            if (iconOpen) iconOpen.classList.add('hidden');
            if (iconClose) iconClose.classList.remove('hidden');
            if (mobileBtn) mobileBtn.setAttribute('aria-expanded', 'true');
        }

        function closeMobileMenu() {
            if (!mobileDrawer) return;
            mobileDrawer.classList.add('hidden');
            if (iconOpen) iconOpen.classList.remove('hidden');
            if (iconClose) iconClose.classList.add('hidden');
            if (mobileBtn) mobileBtn.setAttribute('aria-expanded', 'false');
        }

        if (mobileBtn) {
            mobileBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                toggleMobileMenu();
            });
        }

        // Close mobile drawer when any link inside it is clicked
        if (mobileDrawer) {
            mobileDrawer.querySelectorAll('a, button[type="submit"]').forEach(el => {
                el.addEventListener('click', () => {
                    closeMobileMenu();
                });
            });
        }

        // Close on outside click
        document.addEventListener('click', (e) => {
            if (!e.target.closest('[data-dropdown]')) {
                closeAll();
            }
            if (mobileDrawer && !mobileDrawer.contains(e.target) && mobileBtn && !mobileBtn.contains(e.target)) {
                closeMobileMenu();
            }
        });

        // Close on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeAll();
                closeMobileMenu();
            }
        });

        // HTMX compatibility: close dropdowns & mobile drawer when navigating
        document.addEventListener('htmx:beforeSwap', () => {
            closeAll();
            closeMobileMenu();
        });
        document.addEventListener('htmx:afterSettle', initDropdowns);

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initDropdowns);
        } else {
            initDropdowns();
        }
    })();
</script>
