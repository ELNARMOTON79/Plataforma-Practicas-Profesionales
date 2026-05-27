<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Panel Coordinador - Prácticas Profesionales UdeC' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/htmx.org@1.9.11"></script>
</head>
<body hx-boost="true" class="min-h-screen relative overflow-x-hidden flex flex-col selection:bg-[#6BA53A] selection:text-white">

    <!-- Animated Background -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMCwwLDAsMC4wMikiLz48L3N2Zz4=')] opacity-50"></div>
    </div>

    @include('coordinador.navbar', ['active' => $active ?? ''])

    <!-- Main Content -->
    <main class="relative z-10 flex-1 max-w-7xl w-full mx-auto py-10 px-4 sm:px-6 lg:px-8 flex flex-col gap-8">
        @yield('content')
    </main>

    {{-- Modals rendered outside main to avoid stacking context issues --}}
    @stack('modals')

</body>
</html>
