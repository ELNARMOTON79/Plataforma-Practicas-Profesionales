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
            
            <div class="hidden lg:flex items-center space-x-1">
                <a href="{{ route('empresa.dashboard') }}" class="{{ (isset($active) && $active === 'dashboard') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-4 py-2 rounded-xl text-sm font-semibold transition-all' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-4 py-2 rounded-xl text-sm font-medium transition-all' }}">Dashboard</a>
                <a href="{{ route('empresa.proyectos') }}" class="{{ (isset($active) && $active === 'proyectos') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-4 py-2 rounded-xl text-sm font-semibold transition-all' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-4 py-2 rounded-xl text-sm font-medium transition-all' }}">Proyectos</a>
                <a href="{{ route('empresa.solicitudes') }}" class="{{ (isset($active) && $active === 'solicitudes') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-4 py-2 rounded-xl text-sm font-semibold transition-all' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-4 py-2 rounded-xl text-sm font-medium transition-all' }}">Solicitudes</a>
                <a href="{{ route('empresa.convenios') }}" class="{{ (isset($active) && $active === 'convenios') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-4 py-2 rounded-xl text-sm font-semibold transition-all' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-4 py-2 rounded-xl text-sm font-medium transition-all' }}">Convenio</a>
                <a href="{{ route('empresa.reportes') }}" class="{{ (isset($active) && $active === 'reportes') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-4 py-2 rounded-xl text-sm font-semibold transition-all' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-4 py-2 rounded-xl text-sm font-medium transition-all' }}">Reportes</a>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden md:flex flex-col items-end">
                    <span class="text-sm font-bold text-gray-900">{{ auth()->user()->correo ?? 'Representante' }}</span>
                    <span class="text-xs font-medium text-blue-700 bg-blue-50 px-2 py-0.5 rounded-md mt-1 border border-blue-100">Empresa</span>
                </div>
                
                <a href="{{ route('empresa.perfil') }}" title="Mi Perfil" class="h-10 w-10 rounded-full bg-gradient-to-tr from-blue-500 to-blue-700 p-[2px] shadow-md hover:scale-105 transition-transform">
                    <div class="h-full w-full rounded-full bg-white flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
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
</nav>