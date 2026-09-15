<!-- Navigation -->
<nav class="relative z-50 bg-white/80 backdrop-blur-md border-b border-gray-200/50 shadow-sm sticky top-0">
    <!-- Top Bar: Logo & Profile -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 border-b border-gray-100/50">
        <div class="flex justify-between h-16 items-center">
            <!-- Left Logo -->
            <div class="flex items-center shrink-0">
                <img src="{{ asset('images/logo_verde.png') }}" alt="Logo UdeC" class="h-10 w-auto object-contain transition-transform hover:scale-105 duration-300">
                <div class="ml-3 flex flex-col justify-center">
                    <span class="text-lg font-extrabold text-gray-900 leading-none whitespace-nowrap">Control de Prácticas</span>
                    <span class="text-[10px] font-bold text-[#4E7D24] uppercase tracking-wider mt-0.5">Coordinación</span>
                </div>
            </div>
            
            <!-- Right Info & Actions -->
            <div class="flex items-center gap-4 shrink-0">
                <!-- User Label (Desktop) -->
                <div class="hidden md:flex flex-col items-end">
                    <span class="text-xs font-bold text-gray-900 leading-none">{{ auth()->user()->correo ?? 'Coordinador' }}</span>
                    <span class="text-[10px] font-medium text-[#4E7D24] bg-[#6BA53A]/10 px-2 py-0.5 rounded-md mt-1">Coordinador de Prácticas</span>
                </div>
                
                <!-- Avatar Circular Badge -->
                <div class="h-9 w-9 rounded-full bg-gradient-to-tr from-[#4E7D24] to-[#6BA53A] p-[2px] shadow-sm">
                    <div class="h-full w-full rounded-full bg-white flex items-center justify-center">
                        <svg class="w-4.5 h-4.5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
                
                <div class="h-6 w-px bg-gray-200 mx-1"></div>
                
                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all" title="Cerrar Sesión">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Bottom Bar: Navigation Links (Desktop) -->
    <div class="hidden xl:block bg-white/40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center h-12 gap-1 py-1">
                <a href="{{ Route::has('coordinador.dashboard') ? route('coordinador.dashboard') : '#' }}" class="{{ (isset($active) && $active === 'dashboard') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-4 py-1.5 rounded-xl text-sm font-semibold transition-all' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-4 py-1.5 rounded-xl text-sm font-medium transition-all' }}">Inicio</a>
                <a href="{{ Route::has('coordinador.instituciones') ? route('coordinador.instituciones') : '#' }}" class="{{ (isset($active) && $active === 'instituciones') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-4 py-1.5 rounded-xl text-sm font-semibold transition-all' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-4 py-1.5 rounded-xl text-sm font-medium transition-all' }}">Instituciones</a>
                <a href="{{ Route::has('coordinador.alumnos') ? route('coordinador.alumnos') : '#' }}" class="{{ (isset($active) && $active === 'alumnos') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-4 py-1.5 rounded-xl text-sm font-semibold transition-all' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-4 py-1.5 rounded-xl text-sm font-medium transition-all' }}">Alumnos</a>
                <a href="{{ Route::has('coordinador.proyectos') ? route('coordinador.proyectos') : '#' }}" class="{{ (isset($active) && $active === 'proyectos') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-4 py-1.5 rounded-xl text-sm font-semibold transition-all' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-4 py-1.5 rounded-xl text-sm font-medium transition-all' }}">Proyectos</a>
                <a href="{{ Route::has('coordinador.tramites') ? route('coordinador.tramites') : '#' }}" class="{{ (isset($active) && $active === 'tramites') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-4 py-1.5 rounded-xl text-sm font-semibold transition-all' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-4 py-1.5 rounded-xl text-sm font-medium transition-all' }}">Trámites</a>
                <a href="{{ route('coordinador.seguimiento') }}" class="{{ (isset($active) && $active === 'seguimiento') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-4 py-1.5 rounded-xl text-sm font-semibold transition-all' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-4 py-1.5 rounded-xl text-sm font-medium transition-all' }}">Seguimiento</a>
                <a href="{{ Route::has('coordinador.informes') ? route('coordinador.informes') : '#' }}" class="{{ (isset($active) && $active === 'informes') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-4 py-1.5 rounded-xl text-sm font-semibold transition-all' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-4 py-1.5 rounded-xl text-sm font-medium transition-all' }}">Informes</a>
                <a href="{{ Route::has('coordinador.perfil') ? route('coordinador.perfil') : '#' }}" class="{{ (isset($active) && $active === 'perfil') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-4 py-1.5 rounded-xl text-sm font-semibold transition-all' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-4 py-1.5 rounded-xl text-sm font-medium transition-all' }}">Mi Perfil</a>
            </div>
        </div>
    </div>
    
    <!-- Mobile/Tablet Navigation Scroll (Visible only on screens smaller than xl) -->
    <div class="xl:hidden border-t border-gray-100 bg-white/95 py-2 overflow-x-auto whitespace-nowrap scrollbar-none flex items-center px-4 gap-2">
        <a href="{{ Route::has('coordinador.dashboard') ? route('coordinador.dashboard') : '#' }}" class="{{ (isset($active) && $active === 'dashboard') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-3.5 py-1.5 rounded-lg text-xs font-semibold inline-block' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-3.5 py-1.5 rounded-lg text-xs font-medium inline-block' }}">Inicio</a>
        <a href="{{ Route::has('coordinador.instituciones') ? route('coordinador.instituciones') : '#' }}" class="{{ (isset($active) && $active === 'instituciones') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-3.5 py-1.5 rounded-lg text-xs font-semibold inline-block' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-3.5 py-1.5 rounded-lg text-xs font-medium inline-block' }}">Instituciones</a>
        <a href="{{ Route::has('coordinador.alumnos') ? route('coordinador.alumnos') : '#' }}" class="{{ (isset($active) && $active === 'alumnos') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-3.5 py-1.5 rounded-lg text-xs font-semibold inline-block' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-3.5 py-1.5 rounded-lg text-xs font-medium inline-block' }}">Alumnos</a>
        <a href="{{ Route::has('coordinador.proyectos') ? route('coordinador.proyectos') : '#' }}" class="{{ (isset($active) && $active === 'proyectos') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-3.5 py-1.5 rounded-lg text-xs font-semibold inline-block' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-3.5 py-1.5 rounded-lg text-xs font-medium inline-block' }}">Proyectos</a>
        <a href="{{ Route::has('coordinador.tramites') ? route('coordinador.tramites') : '#' }}" class="{{ (isset($active) && $active === 'tramites') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-3.5 py-1.5 rounded-lg text-xs font-semibold inline-block' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-3.5 py-1.5 rounded-lg text-xs font-medium inline-block' }}">Trámites</a>
        <a href="#" class="{{ (isset($active) && $active === 'responsables') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-3.5 py-1.5 rounded-lg text-xs font-semibold inline-block' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-3.5 py-1.5 rounded-lg text-xs font-medium inline-block' }}">Responsables</a>
        <a href="{{ route('coordinador.seguimiento') }}" class="{{ (isset($active) && $active === 'seguimiento') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-3.5 py-1.5 rounded-lg text-xs font-semibold inline-block' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-3.5 py-1.5 rounded-lg text-xs font-medium inline-block' }}">Seguimiento</a>
        <a href="{{ Route::has('coordinador.informes') ? route('coordinador.informes') : '#' }}" class="{{ (isset($active) && $active === 'informes') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-3.5 py-1.5 rounded-lg text-xs font-semibold inline-block' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-3.5 py-1.5 rounded-lg text-xs font-medium inline-block' }}">Informes</a>
        <a href="{{ Route::has('coordinador.perfil') ? route('coordinador.perfil') : '#' }}" class="{{ (isset($active) && $active === 'perfil') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-3.5 py-1.5 rounded-lg text-xs font-semibold inline-block' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-3.5 py-1.5 rounded-lg text-xs font-medium inline-block' }}">Mi Perfil</a>
    </div>
</nav>
