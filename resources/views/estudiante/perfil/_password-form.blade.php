    {{-- Change password card --}}
    <div class="glass-card rounded-3xl p-8 fade-in-up delay-200">
        <div class="mb-6 pb-4 border-b border-gray-100">
            <h2 class="text-base font-bold text-gray-900">Cambiar Contraseña</h2>
            <p class="text-sm text-gray-500 mt-0.5">Ingresa tu contraseña actual y define una nueva.</p>
        </div>

        <form id="password-form" class="grid gap-5 sm:grid-cols-2">
            @csrf

            {{-- Current password --}}
            <div class="sm:col-span-2">
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                    Contraseña actual <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </span>
                    <input type="password" id="current_password" name="current_password"
                        placeholder="Tu contraseña actual"
                        class="w-full rounded-2xl border border-gray-200 bg-gray-50/80 pl-10 pr-4 py-3 text-sm text-gray-800 font-medium transition-all focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/20 focus:border-[#6BA53A]" />
                </div>
                <p id="error-current_password" class="hidden mt-1.5 text-xs text-red-500 font-medium"></p>
            </div>

            {{-- New password --}}
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                    Nueva contraseña <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                    </span>
                    <input type="password" id="new_password" name="new_password"
                        placeholder="Mínimo 8 caracteres"
                        class="w-full rounded-2xl border border-gray-200 bg-gray-50/80 pl-10 pr-4 py-3 text-sm text-gray-800 font-medium transition-all focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/20 focus:border-[#6BA53A]" />
                </div>
                <p id="error-new_password" class="hidden mt-1.5 text-xs text-red-500 font-medium"></p>
            </div>

            {{-- Confirm password --}}
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                    Confirmar contraseña <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </span>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                        placeholder="Repite la nueva contraseña"
                        class="w-full rounded-2xl border border-gray-200 bg-gray-50/80 pl-10 pr-4 py-3 text-sm text-gray-800 font-medium transition-all focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/20 focus:border-[#6BA53A]" />
                </div>
                <p id="error-new_password_confirmation" class="hidden mt-1.5 text-xs text-red-500 font-medium"></p>
            </div>

            <div class="sm:col-span-2 flex justify-end">
                <button type="button" onclick="openConfirmModal()"
                    class="flex items-center gap-2 rounded-xl bg-[#4E7D24] px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#3b6620] transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Cambiar contraseña
                </button>
            </div>
        </form>
    </div>
