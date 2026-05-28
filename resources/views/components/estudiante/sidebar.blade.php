@props(['active' => 'dashboard'])

@php
    $links = [
        'principal' => [
            ['key' => 'dashboard', 'label' => 'Dashboard', 'route' => 'estudiante.dashboard', 'icon' => 'home'],
        ],
        'gestion' => [
            ['key' => 'nueva-solicitud', 'label' => 'Nueva solicitud', 'route' => 'estudiante.nuevaSolicitud', 'icon' => 'plus'],
            ['key' => 'mis-solicitudes', 'label' => 'Mis solicitudes', 'route' => 'estudiante.misSolicitudes', 'icon' => 'clipboard'],
            ['key' => 'documentacion', 'label' => 'Documentación', 'route' => 'estudiante.nuevaSolicitudDocumentacion', 'icon' => 'document'],
        ],
    ];

    $sections = [
        'principal' => 'Principal',
        'gestion' => 'Gestión',
    ];
@endphp

<aside class="estudiante-sidebar w-72 shrink-0 flex flex-col min-h-screen text-white shadow-2xl border-r border-white/10">
    <div class="px-6 pt-6 pb-8 bg-white/5 backdrop-blur-xl">
        <img src="{{ asset('images/logo_verde.png') }}" alt="Universidad de Colima" class="h-14 w-auto object-contain transition-transform duration-300 hover:scale-105">
        <p class="mt-3 text-[10px] font-bold tracking-widest text-white/70 uppercase leading-tight">Prácticas Profesionales</p>
    </div>

    <nav class="flex-1 px-4 py-5 overflow-y-auto">
        @foreach ($sections as $sectionKey => $sectionLabel)
            <p class="estudiante-nav-section">{{ $sectionLabel }}</p>
            <ul class="space-y-0.5">
                @foreach ($links[$sectionKey] as $link)
                    @php
                        $href = $link['route'] && Route::has($link['route']) ? route($link['route']) : '#';
                        $isActive = $active === $link['key'];
                    @endphp
                    <li>
                        <a href="{{ $href }}"
                           class="estudiante-nav-link {{ $isActive ? 'estudiante-nav-link--active' : '' }}">
                            <x-estudiante.icon :name="$link['icon']" class="w-5 h-5 shrink-0 opacity-90" />
                            <span>{{ $link['label'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endforeach
    </nav>

    <div class="p-5 border-t border-white/10">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-2xl text-sm font-semibold text-white bg-gradient-to-r from-[#4E7D24] via-[#6BA53A] to-[#4E7D24] hover:from-[#6BA53A] hover:to-[#4E7D24] transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Cerrar Sesión
            </button>
        </form>
    </div>
</aside>
