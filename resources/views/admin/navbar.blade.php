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
                <a href="{{ Route::has('admin.dashboard') ? route('admin.dashboard') : '#' }}" class="{{ (isset($active) && $active === 'dashboard') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-4 py-2 rounded-xl text-sm font-semibold transition-all' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-4 py-2 rounded-xl text-sm font-medium transition-all' }}">Dashboard</a>
                <a href="{{ Route::has('admin.usuarios') ? route('admin.usuarios') : '#' }}" class="{{ (isset($active) && $active === 'usuarios') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-4 py-2 rounded-xl text-sm font-semibold transition-all' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-4 py-2 rounded-xl text-sm font-medium transition-all' }}">Usuarios</a>
                <a href="{{ Route::has('admin.bitacora') ? route ('admin.bitacora') : '#' }}" class="{{(isset($active) && $active === 'bitacora') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-4 py-2 rounded-xl text-sm font-semibold transition-all' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-4 py-2 rounded-xl text-sm font-medium transition-all' }}">Bitacora</a>
                <a href="{{ Route::has('admin.config') ? route('admin.config') : '#' }}" class="{{ (isset($active) && $active === 'configuracion') ? 'text-[#4E7D24] bg-[#6BA53A]/10 px-4 py-2 rounded-xl text-sm font-semibold transition-all' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-4 py-2 rounded-xl text-sm font-medium transition-all' }}">Configuración</a>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden md:flex flex-col items-end">
                    <span class="text-sm font-bold text-gray-900">{{ auth()->user()->correo ?? 'Administrador' }}</span>
                    <span class="text-xs font-medium text-[#4E7D24] bg-[#6BA53A]/10 px-2 py-0.5 rounded-md mt-1">Administrador General</span>
                </div>
                <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-[#4E7D24] to-[#6BA53A] p-[2px] shadow-md">
                    <div class="h-full w-full rounded-full bg-white flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                </div>
                
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
