<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Prácticas Profesionales UdeC</title>
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
            background-color: #f8fafc;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }

        /* Animated Background Orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.6;
            animation: float 20s infinite ease-in-out alternate;
            z-index: 0;
        }

        .orb-1 {
            width: 400px;
            height: 400px;
            background: var(--udc-primary);
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 500px;
            height: 500px;
            background: var(--udc-secondary);
            bottom: -150px;
            right: -100px;
            animation-delay: -5s;
        }

        .orb-3 {
            width: 300px;
            height: 300px;
            background: #A4D65E;
            top: 40%;
            left: 30%;
            animation-delay: -10s;
            opacity: 0.4;
        }

        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0, 0) scale(1); }
        }

        /* Glassmorphism */
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
        }

        /* Input styling */
        .input-field {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .input-field:focus-within {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(107, 165, 58, 0.15), 0 8px 10px -6px rgba(107, 165, 58, 0.1);
        }

        /* Animations */
        .fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
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

        /* Custom Button */
        .btn-primary {
            background-size: 200% auto;
            background-image: linear-gradient(to right, var(--udc-primary) 0%, var(--udc-secondary) 51%, var(--udc-primary) 100%);
            transition: 0.5s;
        }
        .btn-primary:hover {
            background-position: right center;
            box-shadow: 0 10px 20px -5px rgba(78, 125, 36, 0.4);
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="min-h-screen relative overflow-hidden flex items-center justify-center selection:bg-[#6BA53A] selection:text-white">

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

                    <p class="text-gray-600 text-lg max-w-lg mb-10 fade-in-up delay-200 leading-relaxed font-light">
                        Una plataforma moderna diseñada para optimizar y dar seguimiento al desarrollo profesional de nuestros estudiantes en el sector laboral.
                    </p>                    
                </div>

            </div>

            <!-- Right Content: Login Form -->
            <div class="col-span-1 lg:col-span-5 flex flex-col justify-center p-8 sm:p-12 lg:p-16 relative bg-white z-10 shadow-[-20px_0_40px_-10px_rgba(0,0,0,0.05)]">
                
                <!-- Mobile Header -->
                <div class="lg:hidden flex flex-col items-center text-center mb-8 fade-in-up w-full">
                    <img src="{{ asset('images/logo_verde.png') }}" alt="Logo UdeC" class="w-50 h-auto object-contain mb-4">
                    <h1 class="text-2xl font-bold text-gray-900">Control de Prácticas</h1>
                </div>

                <div class="w-full max-w-sm mx-auto">
                    <div class="mb-10 fade-in-up">
                        <h3 class="text-3xl font-extrabold text-gray-900 mb-3">Iniciar Sesión</h3>
                        <p class="text-gray-500 font-medium">Ingresa con tu cuenta institucional.</p>
                    </div>

                    <form method="POST" action="{{ route('login.post') }}" class="space-y-6 fade-in-up delay-100">
                        @csrf
                        <div class="space-y-2 input-field group">
                            <label class="text-sm font-semibold text-gray-700 ml-1">Correo Electrónico</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#6BA53A] transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                                <input
                                    type="email"
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

                        <div class="space-y-2 input-field group">
                            <div class="flex items-center justify-between ml-1">
                                <label class="text-sm font-semibold text-gray-700">Contraseña</label>
                                <a href="#" class="text-sm font-semibold text-[#6BA53A] hover:text-[#4E7D24] transition-colors">¿Olvidaste tu contraseña?</a>
                            </div>
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
                                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-[#6BA53A] focus:outline-none transition-colors duration-300">
                                    <svg id="eyeIcon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2">
                            <div class="flex items-center">
                                <input id="remember" name="remember" type="checkbox" class="w-4 h-4 text-[#6BA53A] bg-gray-100 border-gray-300 rounded focus:ring-[#6BA53A] focus:ring-2 cursor-pointer transition-colors">
                                <label for="remember" class="ml-2 text-sm font-medium text-gray-600 cursor-pointer">Recordarme</label>
                            </div>
                        </div>

                        <button type="submit" class="w-full btn-primary text-white font-bold rounded-xl text-base px-5 py-4 text-center inline-flex items-center justify-center gap-2 mt-4 shadow-lg group">
                            <span>Ingresar al Sistema</span>
                            <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </form>
                    
                    <div class="mt-8 text-center fade-in-up delay-200">
                        <p class="text-sm text-gray-500">
                            ¿Problemas para acceder? <br>
                            <a href="#" class="font-semibold text-[#6BA53A] hover:text-[#4E7D24] transition-colors">Contacta a soporte técnico</a>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password_input');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // toggle the eye icon
            if (type === 'text') {
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                `;
            } else {
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        });
    </script>
</body>
</html>