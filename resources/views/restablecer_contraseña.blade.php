<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña - Prácticas Profesionales UdeC</title>
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

            <!-- Right Content: Reset Password Form -->
            <div class="col-span-1 lg:col-span-5 flex flex-col justify-center p-8 sm:p-12 lg:p-16 relative bg-white z-10 shadow-[-20px_0_40px_-10px_rgba(0,0,0,0.05)]">
                
                <!-- Mobile Header -->
                <div class="lg:hidden flex flex-col items-center text-center mb-8 fade-in-up w-full">
                    <img src="{{ asset('images/logo_verde.png') }}" alt="Logo UdeC" class="w-50 h-auto object-contain mb-4">
                    <h1 class="text-2xl font-bold text-gray-900">Control de Prácticas</h1>
                </div>

                <div class="w-full max-w-sm mx-auto">
                    <div class="mb-8 fade-in-up">
                        <h3 class="text-3xl font-extrabold text-gray-900 mb-3">Nueva Contraseña</h3>
                        <p class="text-gray-500 font-medium text-sm leading-relaxed">
                            Crea una contraseña segura para restablecer tu acceso a la plataforma.
                        </p>
                    </div>

                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm flex items-start gap-3 fade-in-up">
                            <svg class="w-5 h-5 text-red-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <div class="flex-1">
                                <span class="font-bold">Ocurrió un problema:</span>
                                <ul class="list-disc list-inside mt-1 space-y-0.5 text-xs text-red-700">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('restablecer-contrasena.post') }}" class="space-y-5 fade-in-up delay-100">
                        @csrf
                        
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="correo" value="{{ $email }}">

                        <!-- Read Only Email Display -->
                        <div class="space-y-2 input-field group opacity-75">
                            <label class="text-sm font-semibold text-gray-700 ml-1">Correo Electrónico</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                                <input
                                    type="email"
                                    value="{{ $email }}"
                                    class="w-full bg-gray-100 border border-gray-200 text-gray-500 text-sm rounded-xl block pl-11 p-3.5 outline-none cursor-not-allowed"
                                    readonly
                                >
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="space-y-2 input-field group">
                            <label for="password_input" class="text-sm font-semibold text-gray-700 ml-1">Nueva Contraseña</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#6BA53A] transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input
                                    type="password"
                                    id="password_input"
                                    name="contraseña"
                                    placeholder="••••••••"
                                    class="w-full bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] block pl-11 pr-12 p-3.5 transition-all outline-none"
                                    required
                                >
                                <button type="button" id="togglePassword" aria-label="Mostrar contraseña" aria-pressed="false" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-[#6BA53A] focus:outline-none transition-colors duration-300">
                                    <svg id="eyeIcon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="space-y-2 input-field group">
                            <label for="password_confirmation_input" class="text-sm font-semibold text-gray-700 ml-1">Confirmar Nueva Contraseña</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#6BA53A] transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input
                                    type="password"
                                    id="password_confirmation_input"
                                    name="contraseña_confirmation"
                                    placeholder="••••••••"
                                    class="w-full bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] block pl-11 pr-12 p-3.5 transition-all outline-none"
                                    required
                                >
                                <button type="button" id="togglePasswordConfirm" aria-label="Mostrar contraseña" aria-pressed="false" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-[#6BA53A] focus:outline-none transition-colors duration-300">
                                    <svg id="eyeIconConfirm" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="w-full btn-primary text-white font-bold rounded-xl text-base px-5 py-4 text-center inline-flex items-center justify-center gap-2 mt-4 shadow-lg group">
                            <span>Actualizar Contraseña</span>
                            <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
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

    <script>
        // Password visibility toggles
        function setupToggle(buttonId, inputId, iconId) {
            const btn = document.getElementById(buttonId);
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            btn.addEventListener('click', function () {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                btn.setAttribute('aria-label', type === 'text' ? 'Ocultar contraseña' : 'Mostrar contraseña');
                btn.setAttribute('aria-pressed', type === 'text' ? 'true' : 'false');

                if (type === 'text') {
                    icon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    `;
                } else {
                    icon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    `;
                }
            });
        }

        setupToggle('togglePassword', 'password_input', 'eyeIcon');
        setupToggle('togglePasswordConfirm', 'password_confirmation_input', 'eyeIconConfirm');
    </script>
</body>
</html>
