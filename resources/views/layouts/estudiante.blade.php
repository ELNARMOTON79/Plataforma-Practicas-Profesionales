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
<body class="min-h-screen bg-[#e8e8e8] selection:bg-[#6BA53A] selection:text-white">

    <div class="flex min-h-screen">
        <x-estudiante.sidebar :active="$active ?? 'dashboard'" />

        <div class="flex flex-1 flex-col min-w-0">
            @yield('header')

            <main class="flex-1 p-6 overflow-y-auto">
                @yield('content')
            </main>
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
                        // If click inside menu or on button, do nothing
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
        </div>
    </div>

</body>
</html>
