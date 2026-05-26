<!-- Modal for Confirm Deactivation -->
<div id="confirmDeactivateModal" class="fixed inset-0 z-[110] hidden overflow-y-auto" aria-labelledby="deactivate-modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500/75 backdrop-blur-sm" aria-hidden="true" onclick="closeConfirmDeactivateModal()"></div>

        <!-- Modal panel -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block w-full max-w-md overflow-hidden text-left align-bottom transition-all transform bg-white rounded-3xl shadow-2xl sm:my-8 sm:align-middle glass-card flex flex-col p-6">
            <!-- Header -->
            <div class="flex items-center gap-3 mb-4">
                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900" id="deactivate-modal-title">¿Deshabilitar Usuario?</h3>
            </div>
            
            <!-- Content -->
            <div class="mb-6">
                <p class="text-sm text-gray-500 leading-relaxed">
                    ¿Estás seguro de que deseas deshabilitar al usuario <span id="deactivate_user_name" class="font-bold text-gray-800"></span>? 
                    El usuario no podrá iniciar sesión en la plataforma hasta que sea habilitado nuevamente.
                </p>
            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeConfirmDeactivateModal()" class="px-4 py-2 border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors text-sm">
                    Cancelar
                </button>
                <button type="button" onclick="submitDeactivateUser()" class="bg-red-600 text-white hover:bg-red-700 px-5 py-2 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Sí, Deshabilitar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden form for toggling user status -->
<form id="toggleStatusForm" action="" method="POST" class="hidden">
    @csrf
    @method('PATCH')
</form>
