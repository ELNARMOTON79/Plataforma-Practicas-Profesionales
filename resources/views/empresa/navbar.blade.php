<!-- Top Header -->
<header class="bg-[#005e20] text-white px-6 py-3 flex justify-between items-center border-b border-white/10 shadow-md z-20 relative">
    <!-- Logo -->
    <div class="flex items-center">
        <img src="{{ asset('images/logo_verde.png') }}" alt="Logo UdeC" class="h-12 w-auto object-contain brightness-0 invert">
    </div>
    
    <!-- Right Icons -->
    <div class="flex items-center gap-6">
        <!-- Notificaciones -->
        <button class="relative hover:opacity-80 transition">
            <svg class="w-6 h-6 text-[#C29B0C]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">1</span>
        </button>

        <!-- Perfil Badge -->
        <div class="flex items-center bg-[#6BA53A] rounded-full px-4 py-2 gap-2 shadow-inner border border-[#4E7D24]/50">
            <div class="w-7 h-7 rounded-full border border-gray-800 flex items-center justify-center bg-transparent">
                <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <span class="text-sm font-semibold text-gray-900 drop-shadow-sm">{{ auth()->user()->correo ?? 'Unidad Receptora' }}</span>
        </div>

        <!-- Cerrar Sesión -->
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" class="text-sm font-medium border border-white text-white rounded-full px-5 py-2 hover:bg-white hover:text-[#005e20] transition-colors">
                Cerrar Sesión
            </button>
        </form>
    </div>
</header>

<!-- Sub Navigation -->
<nav class="bg-[#005e20] px-6 py-3 shadow-md relative z-10">
    <ul class="flex flex-wrap items-center gap-2 text-sm font-medium text-white/90">
        <li>
            <a href="{{ Route::has('empresa.dashboard') ? route('empresa.dashboard') : '#' }}" class="{{ (isset($active) && $active === 'dashboard') ? 'bg-[#C29B0C] text-gray-900 px-6 py-2 rounded-md transition shadow-sm font-bold' : 'px-4 py-2 rounded-md hover:bg-white/10 transition text-white' }}">Inicio</a>
        </li>
        <li><a href="{{ Route::has('empresa.proyectos') ? route('empresa.proyectos') : '#' }}" class="{{ (isset($active) && $active === 'proyectos') ? 'bg-[#C29B0C] text-gray-900 px-6 py-2 rounded-md transition shadow-sm font-bold' : 'px-4 py-2 rounded-md hover:bg-white/10 transition text-white' }}">Proyectos</a></li>
        <li><a href="{{ Route::has('empresa.solicitudes') ? route('empresa.solicitudes') : '#' }}" class="{{ (isset($active) && $active === 'solicitudes') ? 'bg-[#C29B0C] text-gray-900 px-6 py-2 rounded-md transition shadow-sm font-bold' : 'px-4 py-2 rounded-md hover:bg-white/10 transition text-white' }}">Solicitudes</a></li>
        <li><a href="{{ Route::has('empresa.convenios') ? route('empresa.convenios') : '#' }}" class="{{ (isset($active) && $active === 'convenios') ? 'bg-[#C29B0C] text-gray-900 px-6 py-2 rounded-md transition shadow-sm font-bold' : 'px-4 py-2 rounded-md hover:bg-white/10 transition text-white' }}">Convenios</a></li>
        <li><a href="{{ Route::has('empresa.reportes') ? route('empresa.reportes') : '#' }}" class="{{ (isset($active) && $active === 'reportes') ? 'bg-[#C29B0C] text-gray-900 px-6 py-2 rounded-md transition shadow-sm font-bold' : 'px-4 py-2 rounded-md hover:bg-white/10 transition text-white' }}">Reportes</a></li>
        <li><a href="#" class="{{ (isset($active) && $active === 'seguimiento') ? 'bg-[#C29B0C] text-gray-900 px-6 py-2 rounded-md transition shadow-sm font-bold' : 'px-4 py-2 rounded-md hover:bg-white/10 transition text-white' }}">Seguimiento</a></li>
        <li><a href="{{ Route::has('empresa.perfil') ? route('empresa.perfil') : '#' }}" class="{{ (isset($active) && $active === 'perfil') ? 'bg-[#C29B0C] text-gray-900 px-6 py-2 rounded-md transition shadow-sm font-bold' : 'px-4 py-2 rounded-md hover:bg-white/10 transition text-white' }}">Mi Perfil</a></li>
    </ul>
</nav>
