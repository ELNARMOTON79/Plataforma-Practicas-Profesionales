<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Coordinador - Prácticas Profesionales</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <!-- Top Header -->
    <header class="bg-[#005e20] text-white px-6 py-3 flex justify-between items-center border-b border-[#004e1a]">
        <!-- Logo -->
        <div class="flex items-center">
            <!-- Usamos filtro para hacer blanco el logo verde si es necesario, o puedes cambiar a logo_blanco.png -->
            <img src="{{ asset('images/logo_verde.png') }}" alt="Logo UdeC" class="h-12 w-auto object-contain brightness-0 invert">
        </div>
        
        <!-- Right Icons -->
        <div class="flex items-center gap-6">
            <!-- Notificaciones -->
            <button class="relative hover:opacity-80 transition">
                <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">1</span>
            </button>

            <!-- Perfil Badge -->
            <div class="flex items-center bg-[#7cb342] rounded-full px-3 py-1.5 gap-2 shadow-inner">
                <div class="w-7 h-7 rounded-full border border-black/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-black/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <span class="text-sm font-semibold text-white drop-shadow-md">Coordinador</span>
            </div>

            <!-- Cerrar Sesión -->
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="text-sm font-medium border border-white rounded-full px-5 py-2 hover:bg-white/10 transition-colors">
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </header>

    <!-- Sub Navigation -->
    <nav class="bg-[#005e20] px-6 py-3">
        <ul class="flex flex-wrap items-center gap-2 text-sm font-medium text-white/90">
            <li>
                <a href="#" class="bg-[#d4a017] text-white px-5 py-2 rounded-md hover:bg-[#c29215] transition shadow-sm">Inicio</a>
            </li>
            <li><a href="#" class="px-4 py-2 rounded-md hover:bg-white/10 transition">Instituciones</a></li>
            <li><a href="#" class="px-4 py-2 rounded-md hover:bg-white/10 transition">Alumnos</a></li>
            <li><a href="#" class="px-4 py-2 rounded-md hover:bg-white/10 transition">Proyectos</a></li>
            <li><a href="#" class="px-4 py-2 rounded-md hover:bg-white/10 transition">Trámites</a></li>
            <li><a href="#" class="px-4 py-2 rounded-md hover:bg-white/10 transition">Responsables</a></li>
            <li><a href="#" class="px-4 py-2 rounded-md hover:bg-white/10 transition">Seguimiento</a></li>
            <li><a href="#" class="px-4 py-2 rounded-md hover:bg-white/10 transition">Informes</a></li>
            <li><a href="#" class="px-4 py-2 rounded-md hover:bg-white/10 transition">Mi Perfil</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 max-w-[1400px] w-full mx-auto py-8 px-6">
        <!-- Títulos -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#005e20] mb-1">Inicio</h1>
            <p class="text-gray-500 font-medium">Resumen general del programa de prácticas</p>
        </div>

        <!-- Estadísticas (KPIs) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <!-- Card 1 -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 flex flex-col justify-between shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <span class="text-gray-500 font-medium text-sm">Estudiantes Activos</span>
                    <svg class="w-6 h-6 text-[#7cb342]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <h3 class="text-3xl font-bold text-[#005e20]">100</h3>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 flex flex-col justify-between shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <span class="text-gray-500 font-medium text-sm">Instituciones Vinculadas</span>
                    <svg class="w-6 h-6 text-[#005e20]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <h3 class="text-3xl font-bold text-[#005e20]">30</h3>
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 flex flex-col justify-between shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <span class="text-gray-500 font-medium text-sm">Solicitudes Pendientes</span>
                    <svg class="w-6 h-6 text-[#d4a017]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-3xl font-bold text-[#005e20]">10</h3>
            </div>

            <!-- Card 4 -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 flex flex-col justify-between shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <span class="text-gray-500 font-medium text-sm">Proyectos Finalizados</span>
                    <svg class="w-6 h-6 text-[#7cb342]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-3xl font-bold text-[#005e20]">20</h3>
            </div>
        </div>

        <!-- Actividad Reciente -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-xl border border-gray-200 p-8 shadow-sm">
                <h2 class="text-xl font-bold text-[#005e20] mb-6">Actividad Reciente</h2>
                
                <div class="space-y-6">
                    <!-- Item 1 -->
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-[#b2df8a] rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-[#005e20]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">Nueva solicitud recibida</p>
                            <p class="text-sm text-gray-400">Hace 2 horas</p>
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-[#b2df8a] rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-[#005e20]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">Nueva solicitud recibida</p>
                            <p class="text-sm text-gray-400">Hace 4 horas</p>
                        </div>
                    </div>

                    <!-- Item 3 -->
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-[#b2df8a] rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-[#005e20]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">Nueva solicitud recibida</p>
                            <p class="text-sm text-gray-400">Hace 6 horas</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Columna vacía o para futuro contenido -->
            <div></div>
        </div>
    </main>
</body>
</html>