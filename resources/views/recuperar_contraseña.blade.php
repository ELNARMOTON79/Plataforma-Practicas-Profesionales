<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - Prácticas Profesionales UdeC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body class="login-page min-h-screen relative overflow-hidden flex items-center justify-center selection:bg-[#6BA53A] selection:text-white">

    <!-- Animated Background -->
    <div class="absolute inset-0 z-0 overflow-hidden bg-[#f1f5f9]">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMCwwLDAsMC4wNSkiLz48L3N2Zz4=')] opacity-50"></div>
    </div>

    <!-- Main Container -->
    <div class="relative z-10 w-full max-w-6xl mx-auto p-4 md:p-8 lg:p-12 h-screen max-h-[900px] flex items-center">
        
        <div class="w-full grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-0 bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-2xl border border-white/60 overflow-hidden min-h-[600px]">
            
            <!-- Left Content: Branding & Info -->
            <div class="hidden lg:flex lg:col-span-7 flex-col justify-between p-12 relative overflow-hidden bg-gradient-to-br from-[#4E7D24]/5 to-[#6BA53A]/10">
                <!-- Top Decoration -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-[#6BA53A]/20 to-transparent rounded-bl-full"></div>
                
                <div class="relative z-10">
                    <div class="flex justify-center w-full mb-10 fade-in-up">
                        <img src="{{ asset('images/logo_verde.png') }}" alt="Logo UdeC" class="w-50 h-auto object-contain">
                    </div>

                    <h2 class="text-5xl font-extrabold text-gray-900 leading-[1.15] mb-6 fade-in-up delay-100">
                        Sistema Integral de <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#4E7D24] to-[#6BA53A]">
                            Prácticas Profesionales
                        </span>
                    </h2>

                    <p class="text-gray-600 text-lg max-w-lg mb-10 fade-in-up delay-200 leading-relaxed font-light text-justify">
                        Una plataforma moderna diseñada para optimizar y dar seguimiento al desarrollo profesional de nuestros estudiantes en el sector laboral.
                    </p>                    
                </div>

            </div>

            <!-- Right Content: Password Recovery Form -->
            <div class="col-span-1 lg:col-span-5 flex flex-col justify-center p-8 sm:p-12 lg:p-16 relative bg-white z-10 shadow-[-20px_0_40px_-10px_rgba(0,0,0,0.05)]">
                
                <!-- Mobile Header -->
                <div class="lg:hidden flex flex-col items-center text-center mb-8 fade-in-up w-full">
                    <img src="{{ asset('images/logo_verde.png') }}" alt="Logo UdeC" class="w-50 h-auto object-contain mb-4">
                    <h1 class="text-2xl font-bold text-gray-900">Control de Prácticas</h1>
                </div>

                <div class="w-full max-w-sm mx-auto">
                    <div class="mb-8 fade-in-up">
                        <h3 class="text-3xl font-extrabold text-gray-900 mb-3">Recuperar Contraseña</h3>
                        <p class="text-gray-500 font-medium text-sm leading-relaxed">
                            Ingresa tu correo institucional y te enviaremos un enlace para restablecer tu contraseña.
                        </p>
                    </div>

                    <!-- Alert for status messages (e.g. Success) -->
                    @if (session('status'))
                        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-start gap-3 fade-in-up">
                            <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ session('status') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('recuperar-contrasena.post') }}" class="space-y-6 fade-in-up delay-100">
                        @csrf
                        
                        <div class="space-y-2 input-field group">
                            <label for="correo_input" class="text-sm font-semibold text-gray-700 ml-1">Correo Electrónico</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#6BA53A] transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                                <input
                                    type="email"
                                    id="correo_input"
                                    name="correo"
                                    value="{{ old('correo') }}"
                                    placeholder="usuario@ucol.mx"
                                    class="w-full bg-gray-50/50 border {{ $errors->has('correo') ? 'border-red-500' : 'border-gray-200' }} text-gray-900 text-sm rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] block pl-11 p-3.5 transition-all outline-none"
                                    required
                                >
                            </div>
                            @error('correo')
                                <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full btn-primary text-white font-bold rounded-xl text-base px-5 py-4 text-center inline-flex items-center justify-center gap-2 mt-4 shadow-lg group">
                            <span>Enviar Enlace</span>
                            <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </button>
                    </form>

                    <div class="mt-8 text-center fade-in-up delay-200">
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#4a8419] hover:text-[#4E7D24] transition-colors group">
                            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            <span>Volver al inicio de sesión</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
