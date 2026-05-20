@props(['active' => 'dashboard'])

@php
    $links = [
        'principal' => [
            ['key' => 'dashboard', 'label' => 'Dashboard', 'route' => 'estudiante.dashboard', 'icon' => 'home'],
        ],
        'gestion' => [
            ['key' => 'nueva-solicitud', 'label' => 'Nueva solicitud', 'route' => 'estudiante.nuevaSolicitud', 'icon' => 'plus'],
            ['key' => 'mis-solicitudes', 'label' => 'Mis solicitudes', 'route' => 'estudiante.misSolicitudes', 'icon' => 'clipboard'],
            ['key' => 'avance-horas', 'label' => 'Avance de horas', 'route' => 'estudiante.avanceHoras', 'icon' => 'clock'],
            ['key' => 'documentacion', 'label' => 'Documentación', 'route' => 'estudiante.nuevaSolicitudDocumentacion', 'icon' => 'document'],
        ],
        'comunicacion' => [
            ['key' => 'mensajes', 'label' => 'Mensajes', 'route' => 'estudiante.mensajes', 'icon' => 'chat'],
            ['key' => 'notificaciones', 'label' => 'Notificaciones', 'route' => 'estudiante.notificaciones', 'icon' => 'bell'],
        ],
        'reportes' => [
            ['key' => 'reportes', 'label' => 'Reportes', 'route' => 'estudiante.reportes', 'icon' => 'chart'],
        ],
    ];

    $sections = [
        'principal' => 'Principal',
        'gestion' => 'Gestión',
        'comunicacion' => 'Comunicación',
        'reportes' => 'Reportes',
    ];
@endphp

<aside class="estudiante-sidebar w-64 shrink-0 flex flex-col min-h-screen text-white">
    <div class="px-5 pt-6 pb-8 border-b border-white/10">
        <img src="{{ asset('images/logo_verde.png') }}" alt="Universidad de Colima" class="h-14 w-auto brightness-0 invert object-contain">
        <p class="mt-3 text-[10px] font-bold tracking-widest text-white/70 uppercase leading-tight"></p>
    </div>

    <nav class="flex-1 px-3 py-4 overflow-y-auto">
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

    <div class="p-4 border-t border-white/10">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-semibold text-white bg-[#e35d5d] hover:bg-[#d04a4a] transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Cerrar Sesión
            </button>
        </form>
    </div>
</aside>
