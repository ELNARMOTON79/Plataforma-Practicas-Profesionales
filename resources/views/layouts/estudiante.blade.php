<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Portal Estudiante - Prácticas Profesionales UdeC' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/htmx.org@1.9.11"></script>
    <style>
        :root {
            --udc-primary: #4E7D24;
            --udc-secondary: #6BA53A;
            --udc-dark: #2E5417;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }

        /* Animated Background Orbs (Subtle for Dashboard) */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.25;
            animation: float 20s infinite ease-in-out alternate;
            z-index: 0;
            pointer-events: none;
        }

        .orb-1 { width: 350px; height: 350px; background: var(--udc-primary); top: -80px; left: -80px; animation-delay: 0s; }
        .orb-2 { width: 450px; height: 450px; background: var(--udc-secondary); bottom: -120px; right: -80px; animation-delay: -5s; }

        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -45px) scale(1.05); }
            66% { transform: translate(-25px, 20px) scale(0.95); }
            100% { transform: translate(0, 0) scale(1); }
        }

        /* Glassmorphism Cards */
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.04);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .glass-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -10px rgba(107, 165, 58, 0.12);
            border-color: rgba(107, 165, 58, 0.25);
        }

        /* Animations */
        .fade-in-up {
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(15px);
        }
        
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
        .delay-400 { animation-delay: 400ms; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body hx-boost="true" class="min-h-screen relative overflow-x-hidden flex flex-col selection:bg-[#6BA53A] selection:text-white">

    <!-- Animated Background -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMCwwLDAsMC4wMikiLz48L3N2Zz4=')] opacity-40"></div>
    </div>

    @include('estudiante.navbar', ['active' => $active ?? ''])

    <!-- Main Content -->
    <main class="relative z-10 flex-1 max-w-7xl w-full mx-auto py-8 px-4 sm:px-6 lg:px-8 flex flex-col gap-6">
        @yield('content')
    </main>

</body>
</html>
