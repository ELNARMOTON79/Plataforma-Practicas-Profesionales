<!-- Navigation -->
<nav class="relative z-50 bg-white/80 backdrop-blur-md border-b border-gray-200/50 shadow-sm sticky top-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <img src="{{ asset('images/logo_verde.png') }}" alt="Logo UdeC" class="h-12 w-auto object-contain transition-transform hover:scale-105 duration-300">
                <div class="ml-4 hidden sm:flex flex-col justify-center">
                    <span class="text-xl font-extrabold text-gray-900 leading-tight">Control de Prácticas</span>
                </div>
            </div>
            
            <div class="hidden md:flex items-center space-x-1">
                <a href="{{ route('estudiante.dashboard') }}" class="{{ (isset($active) && $active === 'dashboard') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-4 py-2 rounded-xl text-sm font-semibold transition-all' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-4 py-2 rounded-xl text-sm font-medium transition-all' }}">Inicio</a>
                <a href="{{ route('estudiante.convenios') }}" class="{{ (isset($active) && $active === 'convenios') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-4 py-2 rounded-xl text-sm font-semibold transition-all' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-4 py-2 rounded-xl text-sm font-medium transition-all' }}">Convenios</a>
                <a href="{{ route('estudiante.proyecto') }}" class="{{ (isset($active) && $active === 'proyecto') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-4 py-2 rounded-xl text-sm font-semibold transition-all' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-4 py-2 rounded-xl text-sm font-medium transition-all' }}">Mi Proyecto</a>
                <a href="{{ route('estudiante.miPerfil') }}" class="{{ (isset($active) && $active === 'perfil') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-4 py-2 rounded-xl text-sm font-semibold transition-all' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-4 py-2 rounded-xl text-sm font-medium transition-all' }}">Mi Perfil</a>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden md:flex flex-col items-end">
                    <span class="text-sm font-bold text-gray-900">{{ auth()->user()->correo ?? 'Estudiante' }}</span>
                    <span class="text-xs font-medium text-[#4E7D24] bg-[#6BA53A]/10 px-2 py-0.5 rounded-md mt-1 border border-[#6BA53A]/20">Estudiante</span>
                </div>
                
                <a href="{{ route('estudiante.miPerfil') }}" title="Mi Perfil" class="h-10 w-10 rounded-full bg-gradient-to-tr from-[#4E7D24] to-[#6BA53A] p-[2px] shadow-md hover:shadow-lg hover:scale-105 transition-all">
                    <div class="h-full w-full rounded-full bg-white flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                </a>
                
                <div class="h-8 w-px bg-gray-200 mx-1"></div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all" title="Cerrar Sesión">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Mobile Navigation (visible on small screens) -->
    <div class="md:hidden border-t border-gray-100 bg-white/95 px-4 py-3 flex justify-around items-center">
        <a href="{{ route('estudiante.dashboard') }}" class="flex flex-col items-center gap-1 {{ (isset($active) && $active === 'dashboard') ? 'text-[#4E7D24]' : 'text-gray-500' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span class="text-[10px] font-bold">Inicio</span>
        </a>
        <a href="{{ route('estudiante.convenios') }}" class="flex flex-col items-center gap-1 {{ (isset($active) && $active === 'convenios') ? 'text-[#4E7D24]' : 'text-gray-500' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            <span class="text-[10px] font-bold">Convenios</span>
        </a>
        <a href="{{ route('estudiante.proyecto') }}" class="flex flex-col items-center gap-1 {{ (isset($active) && $active === 'proyecto') ? 'text-[#4E7D24]' : 'text-gray-500' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span class="text-[10px] font-bold">Proyecto</span>
        </a>
        <a href="{{ route('estudiante.miPerfil') }}" class="flex flex-col items-center gap-1 {{ (isset($active) && $active === 'perfil') ? 'text-[#4E7D24]' : 'text-gray-500' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            <span class="text-[10px] font-bold">Mi Perfil</span>
        </a>
    </div>
</nav>
