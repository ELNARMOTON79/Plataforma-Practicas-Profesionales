@extends('layouts.admin', ['title' => 'Configuración - Administrador UdeC', 'active' => 'configuracion'])

@section('content')
    <!-- Header Section -->
    <x-page-header title="Configuración General" description="Administra tus datos personales, seguridad y las preferencias de mantenimiento del sistema.">
    </x-page-header>

    <!-- Alert Messages -->
    @if(session('success'))
        <div id="successAlert" class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl shadow-sm flex items-center gap-3 transition-all duration-300 fade-in-up">
            <svg class="w-6 h-6 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-semibold text-sm">{{ session('success') }}</span>
            <button onclick="document.getElementById('successAlert').remove()" class="text-green-500 hover:text-green-800 transition-colors ml-auto">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div id="errorAlert" class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-2xl shadow-sm flex flex-col gap-1 transition-all duration-300 fade-in-up">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <span class="font-bold text-sm">Por favor corrige los siguientes errores:</span>
                <button onclick="document.getElementById('errorAlert').remove()" class="text-red-500 hover:text-red-800 transition-colors ml-auto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <ul class="list-disc list-inside text-xs text-red-700 ml-9 space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Ajax Action Alerts (Hidden by default) -->
    <div id="ajaxAlert" class="hidden px-6 py-4 rounded-2xl shadow-sm flex items-center gap-3 transition-all duration-300 fade-in-up">
        <svg id="ajaxAlertIcon" class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"></svg>
        <span id="ajaxAlertMessage" class="font-semibold text-sm"></span>
        <button onclick="document.getElementById('ajaxAlert').classList.add('hidden')" class="transition-colors ml-auto">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Configuration Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start fade-in-up delay-100 relative z-10">
        
        <!-- Tab Navigation Sidebar (3 Cols) -->
        <div class="lg:col-span-3 bg-white/80 backdrop-blur-md p-4 rounded-3xl border border-gray-200/50 shadow-sm flex flex-col gap-2">
            <div class="px-3 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Menú de Opciones</div>
            
            <button onclick="switchTab('profile')" id="btn-profile" class="w-full text-left px-4 py-3.5 rounded-2xl text-sm font-semibold flex items-center gap-3 transition-all duration-200 {{ request('tab', 'profile') === 'profile' ? 'text-[#4E7D24] bg-[#6BA53A]/10' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span>Perfil y Seguridad</span>
            </button>
            
            <button onclick="switchTab('system')" id="btn-system" class="w-full text-left px-4 py-3.5 rounded-2xl text-sm font-semibold flex items-center gap-3 transition-all duration-200 {{ request('tab', 'profile') === 'system' ? 'text-[#4E7D24] bg-[#6BA53A]/10' : 'text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>Mantenimiento y Preferencias</span>
            </button>
        </div>

        <!-- Tab Content Area (9 Cols) -->
        <div class="lg:col-span-9 flex flex-col gap-8">
            
            <!-- TAB 1: Profile & Security -->
            <div id="tab-profile" class="{{ request('tab', 'profile') === 'profile' ? '' : 'hidden' }} flex flex-col gap-8">
                
                <!-- Profile Information Card -->
                <div class="glass-card rounded-3xl p-6 md:p-8 bg-white/70 border border-gray-200/50 shadow-md">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="p-3 bg-[#6BA53A]/10 rounded-2xl">
                            <svg class="w-6 h-6 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Datos Personales</h2>
                            <p class="text-xs font-semibold text-gray-500">Visualiza los datos personales de tu cuenta institucional.</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="profile_name" class="text-sm font-semibold text-gray-700 ml-1">Nombre Completo</label>
                                <input 
                                    type="text" 
                                    id="profile_name" 
                                    name="name" 
                                    value="{{ old('name', $adminName) }}"
                                    class="w-full bg-gray-50 border border-gray-200 text-gray-500 text-sm rounded-xl block p-3.5 outline-none cursor-not-allowed"
                                    readonly
                                >
                            </div>

                            <div class="space-y-2">
                                <label for="profile_email" class="text-sm font-semibold text-gray-700 ml-1">Correo Electrónico</label>
                                <input 
                                    type="email" 
                                    id="profile_email" 
                                    name="email" 
                                    value="{{ old('email', $user->correo) }}"
                                    class="w-full bg-gray-50 border border-gray-200 text-gray-500 text-sm rounded-xl block p-3.5 outline-none cursor-not-allowed"
                                    readonly
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Card -->
                <div class="glass-card rounded-3xl p-6 md:p-8 bg-white/70 border border-gray-200/50 shadow-md">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="p-3 bg-[#6BA53A]/10 rounded-2xl">
                            <svg class="w-6 h-6 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Seguridad de la Cuenta</h2>
                            <p class="text-xs font-semibold text-gray-500">Mantén tu cuenta protegida cambiando tu contraseña periódicamente.</p>
                        </div>
                    </div>

                    <form id="passwordForm" action="{{ route('admin.config.password') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="space-y-2 max-w-md">
                            <label for="current_password" class="text-sm font-semibold text-gray-700 ml-1">Contraseña Actual</label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="current_password" 
                                    name="current_password" 
                                    class="w-full bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] block p-3.5 pr-11 transition-all outline-none"
                                    required
                                >
                                <button type="button" onclick="togglePasswordVisibility('current_password', this)" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-[#4E7D24] transition-colors focus:outline-none">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="new_password" class="text-sm font-semibold text-gray-700 ml-1">Nueva Contraseña</label>
                                <div class="relative">
                                    <input 
                                        type="password" 
                                        id="new_password" 
                                        name="password" 
                                        placeholder="Mínimo 8 caracteres"
                                        class="w-full bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] block p-3.5 pr-11 transition-all outline-none"
                                        required
                                    >
                                    <button type="button" onclick="togglePasswordVisibility('new_password', this)" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-[#4E7D24] transition-colors focus:outline-none">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label for="password_confirmation" class="text-sm font-semibold text-gray-700 ml-1">Confirmar Nueva Contraseña</label>
                                <div class="relative">
                                    <input 
                                        type="password" 
                                        id="password_confirmation" 
                                        name="password_confirmation" 
                                        placeholder="Mínimo 8 caracteres"
                                        class="w-full bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] block p-3.5 pr-11 transition-all outline-none"
                                        required
                                    >
                                    <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-[#4E7D24] transition-colors focus:outline-none">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="button" onclick="confirmPasswordChange()" class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-6 py-3 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all">
                                Actualizar Contraseña
                            </button>
                        </div>
                    </form>
                </div>

            </div>

            <!-- TAB 2: Maintenance & Preferencias -->
            <div id="tab-system" class="{{ request('tab', 'profile') === 'system' ? '' : 'hidden' }} flex flex-col gap-8">
                
                <!-- Global Settings Form Card -->
                <div class="glass-card rounded-3xl p-6 md:p-8 bg-white/70 border border-gray-200/50 shadow-md">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="p-3 bg-[#6BA53A]/10 rounded-2xl">
                            <svg class="w-6 h-6 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Control de Mantenimiento y Notificaciones</h2>
                            <p class="text-xs font-semibold text-gray-500">Ajusta la disponibilidad global del sistema y las reglas de correos automáticos.</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.config.settings') }}" method="POST" hx-boost="false" class="space-y-8">
                        @csrf
                        
                        <!-- Toggle Switch: Modo Mantenimiento -->
                        <div class="flex items-start justify-between gap-6 p-4 rounded-2xl bg-slate-50 border border-gray-100">
                            <div class="space-y-1">
                                <label for="maintenance_mode" class="text-base font-bold text-gray-900 flex items-center gap-2">
                                    <span>Modo de Mantenimiento</span>
                                    <span id="maintenance_status_badge" class="px-2 py-0.5 text-2xs font-extrabold rounded-md uppercase tracking-wider {{ ($settings['maintenance_mode'] ?? false) ? 'bg-amber-100 text-amber-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ($settings['maintenance_mode'] ?? false) ? 'Activo' : 'Desactivado' }}
                                    </span>
                                </label>
                                <p class="text-xs font-medium text-gray-500 leading-relaxed">
                                    Al activarse, el acceso se restringe únicamente para administradores generales. Los coordinadores, estudiantes y empresas con sesión activa serán desconectados inmediatamente y no podrán iniciar sesión.
                                </p>
                            </div>
                            <div class="flex items-center h-6">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input 
                                        type="checkbox" 
                                        id="maintenance_mode" 
                                        name="maintenance_mode" 
                                        value="1" 
                                        class="sr-only peer"
                                        {{ ($settings['maintenance_mode'] ?? false) ? 'checked' : '' }}
                                        onchange="updateToggleBadge('maintenance_mode', 'maintenance_status_badge', 'Activo', 'Desactivado')"
                                    >
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#4E7D24]"></div>
                                </label>
                            </div>
                        </div>

                        <!-- Toggle Switch: Envío de Correos -->
                        <div class="flex items-start justify-between gap-6 p-4 rounded-2xl bg-slate-50 border border-gray-100">
                            <div class="space-y-1">
                                <label for="send_emails" class="text-base font-bold text-gray-900 flex items-center gap-2">
                                    <span>Envío de Credenciales por Correo</span>
                                    <span id="email_status_badge" class="px-2 py-0.5 text-2xs font-extrabold rounded-md uppercase tracking-wider {{ ($settings['send_emails'] ?? true) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ($settings['send_emails'] ?? true) ? 'Habilitado' : 'Deshabilitado' }}
                                    </span>
                                </label>
                                <p class="text-xs font-medium text-gray-500 leading-relaxed">
                                    Habilita o deshabilita el envío automático de correos electrónicos con contraseñas temporales y accesos cuando creas o importas nuevos usuarios en la plataforma.
                                </p>
                            </div>
                            <div class="flex items-center h-6">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input 
                                        type="checkbox" 
                                        id="send_emails" 
                                        name="send_emails" 
                                        value="1" 
                                        class="sr-only peer"
                                        {{ ($settings['send_emails'] ?? true) ? 'checked' : '' }}
                                        onchange="updateToggleBadge('send_emails', 'email_status_badge', 'Habilitado', 'Deshabilitado')"
                                    >
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#4E7D24]"></div>
                                </label>
                            </div>
                        </div>

                        <!-- Dropdown Select: Retención de Logs -->
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                            <div class="md:col-span-8 space-y-1">
                                <label for="clean_logs_days" class="text-sm font-bold text-gray-900 block">Período de Retención de la Bitácora</label>
                                <p class="text-xs font-medium text-gray-500 leading-relaxed">
                                    Define por cuánto tiempo deseas conservar los eventos de actividad en el sistema antes de que se consideren obsoletos.
                                </p>
                            </div>
                            <div class="md:col-span-4">
                                <select 
                                    id="clean_logs_days" 
                                    name="clean_logs_days" 
                                    class="w-full bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#6BA53A] focus:border-[#6BA53A] block p-3.5 outline-none font-semibold transition-all"
                                >
                                    <option value="30" {{ ($settings['clean_logs_days'] ?? 180) == '30' ? 'selected' : '' }}>30 días (1 mes)</option>
                                    <option value="90" {{ ($settings['clean_logs_days'] ?? 180) == '90' ? 'selected' : '' }}>90 días (3 meses)</option>
                                    <option value="180" {{ ($settings['clean_logs_days'] ?? 180) == '180' ? 'selected' : '' }}>180 días (6 meses)</option>
                                    <option value="365" {{ ($settings['clean_logs_days'] ?? 180) == '365' ? 'selected' : '' }}>365 días (1 año)</option>
                                    <option value="all" {{ ($settings['clean_logs_days'] ?? 180) == 'all' ? 'selected' : '' }}>Conservar todos</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end pt-4 border-t border-gray-200/50">
                            <button type="submit" class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-6 py-3 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all">
                                Guardar Preferencias
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Manual Maintenance Operations Card -->
                <div class="glass-card rounded-3xl p-6 md:p-8 bg-white/70 border border-gray-200/50 shadow-md">
                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-amber-50 border border-amber-200 rounded-2xl text-amber-600 mt-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </div>
                        <div class="space-y-4 flex-1">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Mantenimiento de Datos: Limpieza Manual</h3>
                                <p class="text-xs font-semibold text-gray-500">
                                    Elimina de forma permanente todos los registros antiguos de la bitácora que superen el tiempo de retención seleccionado arriba.
                                </p>
                            </div>

                            <div class="flex items-center gap-3">
                                <button 
                                    type="button" 
                                    id="btn-clean-now"
                                    onclick="openModal('cleanupModal')" 
                                    class="bg-amber-600 text-white hover:bg-amber-700 px-5 py-2.5 rounded-xl text-xs font-bold shadow-sm transition-all"
                                >
                                    Limpiar registros antiguos ahora
                                </button>
                                <span class="text-2xs font-semibold text-gray-400">
                                    Esta acción es irreversible y quedará registrada en el sistema.
                                </span >
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- MODAL: Confirmation for Cleanup -->
    @push('modals')
        <div id="cleanupModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-sm hidden transition-opacity duration-300">
            <div class="bg-white rounded-3xl max-w-md w-full p-6 md:p-8 shadow-2xl border border-gray-100 flex flex-col gap-6 transform scale-95 transition-transform duration-300">
                <div class="flex items-center gap-4 text-amber-600">
                    <div class="p-3 bg-amber-50 rounded-2xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">¿Confirmar limpieza?</h3>
                </div>

                <p class="text-sm font-medium text-gray-600 leading-relaxed">
                    Estás a punto de eliminar de la base de datos todos los registros de actividad que tengan una antigüedad mayor a la definida en tus preferencias.
                </p>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeModal('cleanupModal')" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-xl text-sm font-bold transition-all">
                        Cancelar
                    </button>
                    <button type="button" onclick="executeCleanup()" class="bg-amber-600 hover:bg-amber-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md transition-all">
                        Sí, limpiar registros
                    </button>
                </div>
            </div>
        </div>

        <!-- MODAL: Confirmation for Password Change -->
        <div id="passwordModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-sm hidden transition-opacity duration-300">
            <div class="bg-white rounded-3xl max-w-md w-full p-6 md:p-8 shadow-2xl border border-gray-100 flex flex-col gap-6 transform scale-95 transition-transform duration-300">
                <div class="flex items-center gap-4 text-[#4E7D24]">
                    <div class="p-3 bg-[#6BA53A]/10 rounded-2xl">
                        <svg class="w-6 h-6 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">¿Confirmar cambio?</h3>
                </div>

                <p class="text-sm font-medium text-gray-600 leading-relaxed">
                    ¿Estás seguro de que deseas actualizar tu contraseña? Se cerrará tu sesión actual en otros dispositivos y deberás ingresar con tus nuevas credenciales en tu próximo inicio de sesión.
                </p>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeModal('passwordModal')" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-xl text-sm font-bold transition-all">
                        Cancelar
                    </button>
                    <button type="button" onclick="submitPasswordForm()" class="bg-[#4E7D24] hover:bg-[#2E5417] text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md transition-all">
                        Sí, cambiar contraseña
                    </button>
                </div>
            </div>
        </div>
    @endpush

    <!-- Script Block for Tabs & Operations -->
    <script>
        // Tab Switching Logic
        function switchTab(tabId) {
            const tabs = ['profile', 'system'];
            tabs.forEach(t => {
                const view = document.getElementById(`tab-${t}`);
                const btn = document.getElementById(`btn-${t}`);
                if (!view || !btn) return;
                
                if (t === tabId) {
                    view.classList.remove('hidden');
                    btn.className = "w-full text-left px-4 py-3.5 rounded-2xl text-sm font-semibold flex items-center gap-3 transition-all duration-200 text-[#4E7D24] bg-[#6BA53A]/10";
                } else {
                    view.classList.add('hidden');
                    btn.className = "w-full text-left px-4 py-3.5 rounded-2xl text-sm font-semibold flex items-center gap-3 transition-all duration-200 text-gray-600 hover:text-[#4E7D24] hover:bg-[#6BA53A]/5";
                }
            });
        }
        window.switchTab = switchTab;

        // Toggle Switch Dynamic Badges
        function updateToggleBadge(checkboxId, badgeId, checkedText, uncheckedText) {
            const checkbox = document.getElementById(checkboxId);
            const badge = document.getElementById(badgeId);
            if (!checkbox || !badge) return;
            
            if (checkbox.checked) {
                badge.innerText = checkedText;
                badge.className = "px-2 py-0.5 text-2xs font-extrabold rounded-md uppercase tracking-wider bg-green-100 text-green-800";
                if (checkboxId === 'maintenance_mode') {
                    badge.className = "px-2 py-0.5 text-2xs font-extrabold rounded-md uppercase tracking-wider bg-amber-100 text-amber-800";
                }
            } else {
                badge.innerText = uncheckedText;
                badge.className = "px-2 py-0.5 text-2xs font-extrabold rounded-md uppercase tracking-wider bg-red-100 text-red-800";
                if (checkboxId === 'maintenance_mode') {
                    badge.className = "px-2 py-0.5 text-2xs font-extrabold rounded-md uppercase tracking-wider bg-green-100 text-green-800";
                }
            }
        }
        window.updateToggleBadge = updateToggleBadge;

        // Modal Helpers
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;
            modal.classList.remove('hidden');
            setTimeout(() => {
                if (modal.firstElementChild) {
                    modal.firstElementChild.classList.remove('scale-95');
                    modal.firstElementChild.classList.add('scale-100');
                }
            }, 10);
        }
        window.openModal = openModal;

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;
            if (modal.firstElementChild) {
                modal.firstElementChild.classList.remove('scale-100');
                modal.firstElementChild.classList.add('scale-95');
            }
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 150);
        }
        window.closeModal = closeModal;

        // Password confirmation helper
        function confirmPasswordChange() {
            const form = document.getElementById('passwordForm');
            if (!form) return;
            if (form.checkValidity()) {
                openModal('passwordModal');
            } else {
                form.reportValidity();
            }
        }
        window.confirmPasswordChange = confirmPasswordChange;

        function submitPasswordForm() {
            closeModal('passwordModal');
            const form = document.getElementById('passwordForm');
            if (form) form.submit();
        }
        window.submitPasswordForm = submitPasswordForm;

        // Toggle password visibility helper
        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            if (!input) return;
            
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            
            // Toggle SVG icon
            if (isPassword) {
                // Eye slashed (closed)
                btn.innerHTML = `
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                    </svg>
                `;
            } else {
                // Eye open
                btn.innerHTML = `
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                `;
            }
        }
        window.togglePasswordVisibility = togglePasswordVisibility;

        // Fetch Execute Log Cleanup
        function executeCleanup() {
            closeModal('cleanupModal');
            
            const btn = document.getElementById('btn-clean-now');
            const alertBox = document.getElementById('ajaxAlert');
            const alertMsg = document.getElementById('ajaxAlertMessage');
            const alertIcon = document.getElementById('ajaxAlertIcon');
            if (!btn || !alertBox || !alertMsg || !alertIcon) return;
            
            // Set loading state
            btn.disabled = true;
            btn.innerText = "Limpiando...";
            
            fetch("{{ route('admin.config.clean-logs') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('La respuesta del servidor no fue correcta.');
                }
                return response.json();
            })
            .then(data => {
                alertBox.classList.remove('hidden');
                
                if (data.success) {
                    // Success alert styling
                    alertBox.className = "bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl shadow-sm flex items-center gap-3 transition-all duration-300 fade-in-up";
                    alertIcon.className = "w-6 h-6 text-green-600 flex-shrink-0";
                    alertIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
                    alertMsg.innerText = data.message;
                } else {
                    // Warning style
                    alertBox.className = "bg-amber-50 border border-amber-200 text-amber-800 px-6 py-4 rounded-2xl shadow-sm flex items-center gap-3 transition-all duration-300 fade-in-up";
                    alertIcon.className = "w-6 h-6 text-amber-600 flex-shrink-0";
                    alertIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>';
                    alertMsg.innerText = data.message;
                }
            })
            .catch(error => {
                alertBox.classList.remove('hidden');
                alertBox.className = "bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-2xl shadow-sm flex items-center gap-3 transition-all duration-300 fade-in-up";
                alertIcon.className = "w-6 h-6 text-red-600 flex-shrink-0";
                alertIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
                alertMsg.innerText = "Error de red: no se pudo completar la solicitud de limpieza.";
                console.error(error);
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerText = "Limpiar registros antiguos ahora";
                // Scroll page back up to show alert nicely
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
        window.executeCleanup = executeCleanup;

        // Default to active tab on load/swap unless specified in query parameter
        const urlParams = new URLSearchParams(window.location.search);
        const activeTab = urlParams.get('tab') || 'profile';
        switchTab(activeTab);

        // Auto-dismiss success alert after 5 seconds
        const successAlert = document.getElementById('successAlert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                successAlert.style.opacity = '0';
                successAlert.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    successAlert.remove();
                }, 500);
            }, 5000);
        }
    </script>
@endsection
