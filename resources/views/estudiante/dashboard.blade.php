<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Estudiante - Prácticas Profesionales UdeC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --udc-primary: #4E7D24;
            --udc-secondary: #6BA53A;
            --udc-dark: #2E5417;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }

        /* Animated Background Orbs (Subtle for Dashboard) */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.3;
            animation: float 20s infinite ease-in-out alternate;
            z-index: 0;
            pointer-events: none;
        }

        .orb-1 { width: 300px; height: 300px; background: var(--udc-primary); top: -50px; left: -50px; animation-delay: 0s; }
        .orb-2 { width: 400px; height: 400px; background: var(--udc-secondary); bottom: -100px; right: -50px; animation-delay: -5s; }

        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(20px, -30px) scale(1.05); }
            66% { transform: translate(-15px, 15px) scale(0.95); }
            100% { transform: translate(0, 0) scale(1); }
        }

        /* Glassmorphism Cards */
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px -10px rgba(107, 165, 58, 0.15);
            border-color: rgba(107, 165, 58, 0.3);
        }

        /* Animations */
        .fade-in-up {
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
        }
        
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="min-h-screen relative overflow-x-hidden flex flex-col selection:bg-[#6BA53A] selection:text-white">

    <!-- Animated Background -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMCwwLDAsMC4wMikiLz48L3N2Zz4=')] opacity-50"></div>
    </div>

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
                    <a href="#" class="text-[#4E7D24] bg-[#6BA53A]/10 px-4 py-2 rounded-xl text-sm font-semibold transition-all">Inicio</a>
                    <a href="#" class="text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-4 py-2 rounded-xl text-sm font-medium transition-all">Convenios</a>
                    <a href="#" class="text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5 px-4 py-2 rounded-xl text-sm font-medium transition-all">Proyecto</a>
                </div>

                <div class="flex items-center gap-4">
                    <div class="hidden md:flex flex-col items-end">
                        <span class="text-sm font-bold text-gray-900">{{ auth()->user()->correo }}</span>
                        <span class="text-xs font-medium text-gray-500">Estudiante</span>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-[#4E7D24] to-[#6BA53A] p-[2px] shadow-md">
                        <div class="h-full w-full rounded-full bg-white flex items-center justify-center">
                            <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
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

    <!-- Main Content -->
    <main class="relative z-10 flex-1 max-w-7xl w-full mx-auto py-10 px-4 sm:px-6 lg:px-8 flex flex-col gap-8">
        
        <!-- Welcome & General Status -->
        <div class="glass-card rounded-3xl p-8 fade-in-up">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-2">¡Hola, {{ auth()->user()->correo }}!</h1>
                    <p class="text-gray-600 font-medium">Bienvenido a tu portal de Prácticas Profesionales.</p>
                </div>
                <div class="bg-white px-6 py-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="flex flex-col">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Estatus General</span>
                        <span class="text-lg font-extrabold text-yellow-600 flex items-center gap-2">
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-yellow-500"></span>
                            </span>
                            En Curso
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Progress & Docs -->
            <div class="lg:col-span-2 flex flex-col gap-8">
                
                <!-- Progress Section -->
                <div class="glass-card rounded-3xl p-8 fade-in-up delay-100">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-6 h-6 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Progreso de Prácticas
                        </h2>
                    </div>
                    
                    <div class="space-y-8">    
                        <!-- Días -->
                        <div>
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-sm font-bold text-gray-600">Días Transcurridos</span>
                                <span class="text-2xl font-extrabold text-[#4E7D24]">30 <span class="text-sm font-medium text-gray-500">/ 120 días</span></span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-4 overflow-hidden border border-gray-200">
                                <div class="bg-gradient-to-r from-[#4E7D24] to-[#6BA53A] h-full rounded-full relative transition-all duration-1000 ease-out" style="width: 25%">
                                    <div class="absolute inset-0 bg-white/20 animate-pulse"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Documentation Section -->
                <div class="glass-card rounded-3xl p-8 fade-in-up delay-200">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-6 h-6 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Documentación Requerida
                        </h2>
                    </div>

                    <div class="space-y-4">
                        <!-- Doc Item 1 -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 bg-white/60 rounded-2xl border border-gray-100 hover:border-[#6BA53A]/30 transition-colors gap-4">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-green-50 text-green-600 rounded-xl">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900">Carta de Presentación</h3>
                                    <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-md text-xs font-semibold bg-green-50 text-green-700 mt-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Aprobado
                                    </span>
                                </div>
                            </div>
                            <button class="text-[#4E7D24] hover:bg-[#6BA53A]/10 p-2 rounded-lg transition-colors font-medium text-sm flex items-center gap-1">
                                Ver PDF
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>

                        <!-- Doc Item 2 -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 bg-white/60 rounded-2xl border border-gray-100 hover:border-[#6BA53A]/30 transition-colors gap-4">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-yellow-50 text-yellow-600 rounded-xl">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900">Carta de Aceptación</h3>
                                    <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-md text-xs font-semibold bg-yellow-50 text-yellow-700 mt-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> En Revisión
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Doc Item 3 -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 bg-white/60 rounded-2xl border border-gray-100 hover:border-[#6BA53A]/30 transition-colors gap-4">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-red-50 text-red-600 rounded-xl">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900">Plan de Trabajo</h3>
                                    <div class="flex flex-col gap-1 items-start mt-1">
                                        <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-md text-xs font-semibold bg-red-50 text-red-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span> Rechazado
                                        </span>
                                        <span class="text-xs text-red-500 font-medium ml-1">Error de formato en firmas.</span>
                                    </div>
                                </div>
                            </div>
                            <button class="bg-gray-900 text-white hover:bg-black px-4 py-2 rounded-xl text-sm font-bold shadow-md hover:shadow-lg transition-all flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                Reemplazar
                            </button>
                        </div>

                        <!-- Doc Item 4 -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 bg-white/60 rounded-2xl border border-dashed border-gray-300 hover:border-[#6BA53A]/50 transition-colors gap-4">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-gray-50 text-gray-400 rounded-xl">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900">Memoria de Prácticas</h3>
                                    <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-md text-xs font-semibold bg-gray-100 text-gray-500 mt-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Pendiente de Subir
                                    </span>
                                </div>
                            </div>
                            <button class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-4 py-2 rounded-xl text-sm font-bold shadow-md hover:shadow-lg transition-all flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                Subir Archivo
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Actions & Status -->
            <div class="flex flex-col gap-8">

                <!-- Solicitar Participación -->
                <div class="glass-card rounded-3xl p-6 fade-in-up delay-200 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gray-900/5 rounded-full -mr-10 -mt-10 blur-xl transition-all group-hover:bg-gray-900/10"></div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 bg-gray-900 rounded-2xl flex items-center justify-center text-white mb-4 shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Solicitar Prácticas</h3>
                        <p class="text-sm text-gray-600 mb-6 font-medium">Inicia tu proceso generando una solicitud formal a una empresa.</p>
                        <button class="w-full py-3 bg-gray-900 text-white font-bold rounded-xl hover:bg-black shadow-lg hover:shadow-xl transition-all flex justify-center items-center gap-2">
                            Crear Solicitud
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Estado de Solicitud -->
                <div class="glass-card rounded-3xl p-6 fade-in-up delay-300">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Mi Solicitud Actual
                    </h3>
                    
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100/50 border border-blue-100 rounded-2xl p-5 flex flex-col items-center text-center shadow-inner">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-3 text-blue-600 shadow-sm border border-blue-50">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h4 class="font-bold text-blue-900 mb-1">Estado: Pendiente</h4>
                        <p class="text-sm text-blue-800/80 font-medium">Enviada a <strong>Tech Solutions S.A.</strong> Esperando respuesta del coordinador.</p>
                    </div>
                </div>

            </div>
        </div>
    </main>
</body>
</html>
