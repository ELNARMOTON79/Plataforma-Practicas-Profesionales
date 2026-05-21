<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard Estudiante - Prácticas Profesionales UdeC' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen relative overflow-x-hidden flex flex-col selection:bg-[#6BA53A] selection:text-white bg-[#f4f7f2]">

    <!-- Animated Background -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMCwwLDAsMC4wMikiLz48L3N2Zz4=')] opacity-40"></div>
    </div>

    <div class="flex min-h-screen relative z-10">
        <x-estudiante.sidebar :active="$active ?? 'dashboard'" />

        <div class="flex flex-1 flex-col min-w-0">
            @yield('header')

            <main class="relative z-10 flex-1 max-w-[1600px] w-full mx-auto py-10 px-4 sm:px-6 lg:px-8 flex flex-col gap-8">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vanilla-js-toggle-class@1.0.0/dist/index.min.js"></script>
    <script>
        function toggleProfileMenu() {
            const menu = document.getElementById('profile-menu');
            if (!menu) return;
            const isHidden = menu.classList.contains('hidden');
            if (isHidden) {
                menu.classList.remove('hidden');
                menu.setAttribute('aria-expanded', 'true');
            } else {
                menu.classList.add('hidden');
                menu.setAttribute('aria-expanded', 'false');
            }
        }

        document.addEventListener('click', function (e) {
            const menu = document.getElementById('profile-menu');
            if (!menu) return;
            const button = document.querySelector('[onclick="toggleProfileMenu()"]');
            if (menu.classList.contains('hidden')) return;
            if (menu.contains(e.target) || (button && button.contains(e.target))) return;
            menu.classList.add('hidden');
            menu.setAttribute('aria-expanded', 'false');
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                const menu = document.getElementById('profile-menu');
                if (menu && !menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                    menu.setAttribute('aria-expanded', 'false');
                }
            }
        });
    </script>
</body>
</html>
