<!-- Top Header -->
<header class="bg-[#2E5417] text-white px-6 py-3 flex justify-between items-center border-b border-white/10 shadow-md z-20 relative">
    <!-- Logo -->
    <div class="flex items-center">
        <img src="{{ asset('images/logo_verde.png') }}" alt="Logo UdeC" class="h-12 w-auto object-contain brightness-0 invert">
    </div>
    
    <!-- Right Icons -->
    <div class="flex items-center gap-6">
        <!-- Notificaciones -->
        <button class="relative hover:opacity-80 transition">
            <svg class="w-6 h-6 text-[#A4D65E]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">1</span>
        </button>

        <!-- Perfil Badge -->
        <div class="flex items-center bg-[#6BA53A] rounded-full px-3 py-1.5 gap-2 shadow-inner border border-[#4E7D24]/50">
            <div class="w-7 h-7 rounded-full border border-white/30 flex items-center justify-center bg-white/20">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <span class="text-sm font-semibold text-white drop-shadow-sm">{{ auth()->user()->correo ?? 'Coordinador' }}</span>
        </div>

        <!-- Cerrar Sesión -->
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" class="text-sm font-medium border border-[#6BA53A] text-[#A4D65E] rounded-full px-5 py-2 hover:bg-[#6BA53A] hover:text-white transition-colors">
                Cerrar Sesión
            </button>
        </form>
    </div>
</header>

<!-- Sub Navigation -->
<nav class="bg-[#2E5417] px-6 py-3 shadow-md relative z-10">
    <ul class="flex flex-wrap items-center gap-2 text-sm font-medium text-white/90">
        <li>
            <a href="{{ Route::has('coordinador.dashboard') ? route('coordinador.dashboard') : '#' }}" class="{{ (isset($active) && $active === 'dashboard') ? 'bg-[#6BA53A] text-white px-5 py-2 rounded-md transition shadow-sm border border-[#4E7D24]/50' : 'px-4 py-2 rounded-md hover:bg-white/10 transition' }}">Inicio</a>
        </li>
        <li><a href="{{ Route::has('coordinador.instituciones') ? route('coordinador.instituciones') : '#' }}" class="{{ (isset($active) && $active === 'instituciones') ? 'bg-[#6BA53A] text-white px-5 py-2 rounded-md transition shadow-sm border border-[#4E7D24]/50' : 'px-4 py-2 rounded-md hover:bg-white/10 transition' }}">Instituciones</a></li>
        <li><a href="{{ Route::has('coordinador.alumnos') ? route('coordinador.alumnos') : '#' }}" class="{{ (isset($active) && $active === 'alumnos') ? 'bg-[#6BA53A] text-white px-5 py-2 rounded-md transition shadow-sm border border-[#4E7D24]/50' : 'px-4 py-2 rounded-md hover:bg-white/10 transition' }}">Alumnos</a></li>
        <li><a href="{{ Route::has('coordinador.proyectos') ? route('coordinador.proyectos') : '#' }}" class="{{ (isset($active) && $active === 'proyectos') ? 'bg-[#6BA53A] text-white px-5 py-2 rounded-md transition shadow-sm border border-[#4E7D24]/50' : 'px-4 py-2 rounded-md hover:bg-white/10 transition' }}">Proyectos</a></li>
        <li><a href="{{ Route::has('coordinador.tramites') ? route('coordinador.tramites') : '#' }}" class="{{ (isset($active) && $active === 'tramites') ? 'bg-[#6BA53A] text-white px-5 py-2 rounded-md transition shadow-sm border border-[#4E7D24]/50' : 'px-4 py-2 rounded-md hover:bg-white/10 transition' }}">Trámites</a></li>
        <li><a href="#" class="{{ (isset($active) && $active === 'responsables') ? 'bg-[#6BA53A] text-white px-5 py-2 rounded-md transition shadow-sm border border-[#4E7D24]/50' : 'px-4 py-2 rounded-md hover:bg-white/10 transition' }}">Responsables</a></li>
        <li><a href="#" class="{{ (isset($active) && $active === 'seguimiento') ? 'bg-[#6BA53A] text-white px-5 py-2 rounded-md transition shadow-sm border border-[#4E7D24]/50' : 'px-4 py-2 rounded-md hover:bg-white/10 transition' }}">Seguimiento</a></li>
        <li><a href="{{ Route::has('coordinador.informes') ? route('coordinador.informes') : '#' }}" class="{{ (isset($active) && $active === 'informes') ? 'bg-[#6BA53A] text-white px-5 py-2 rounded-md transition shadow-sm border border-[#4E7D24]/50' : 'px-4 py-2 rounded-md hover:bg-white/10 transition' }}">Informes</a></li>
        <li><a href="{{ Route::has('coordinador.perfil') ? route('coordinador.perfil') : '#' }}" class="{{ (isset($active) && $active === 'perfil') ? 'bg-[#6BA53A] text-white px-5 py-2 rounded-md transition shadow-sm border border-[#4E7D24]/50' : 'px-4 py-2 rounded-md hover:bg-white/10 transition' }}">Mi Perfil</a></li>
    </ul>
</nav>
