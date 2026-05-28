<!-- Modal: Editar Proyecto -->
<div id="modal-editar-proyecto" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-950/60 backdrop-blur-md transition-opacity duration-300"
         onclick="document.getElementById('modal-editar-proyecto').classList.add('hidden')"></div>

    <!-- Modal Positioning -->
    <div class="flex min-h-screen items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-3xl mx-auto overflow-hidden transform transition-all duration-300 scale-100 max-h-[90vh] flex flex-col">
            
            <!-- Header (Gradient Green Banner) -->
            <div class="bg-gradient-to-r from-[#4E7D24] to-[#6BA53A] px-8 py-6 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 p-2 rounded-xl">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 id="modal-title" class="text-lg font-bold text-white">Editar Proyecto <span id="edit-id-display">#0</span></h2>
                        <p class="text-green-100 text-xs">Modifica los campos del formulario para actualizar el proyecto</p>
                    </div>
                </div>
                <button type="button" 
                        onclick="document.getElementById('modal-editar-proyecto').classList.add('hidden')"
                        class="text-white/70 hover:text-white transition-colors p-1.5 rounded-lg hover:bg-white/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Registration Form with Scrollable Body -->
            <form id="form-editar-proyecto" action="" method="POST" class="px-8 py-6 space-y-5 overflow-y-auto scrollbar-thin flex-1">
                @csrf
                @method('PUT')

                <!-- 1. Unidad Receptora Select (Dynamically loaded from DB) -->
                <div>
                    <label for="edit-unidad" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Unidad Receptora / Institución</label>
                    <div class="relative">
                        <select id="edit-unidad" name="unidad_receptora_id" required class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 shadow-sm transition-all appearance-none cursor-pointer">
                            <option value="">Selecciona la institución asociada...</option>
                            @foreach($unidadesReceptoras as $ur)
                                <option value="{{ $ur->id }}">{{ strtoupper($ur->nombre_empresa) }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- 2. Título -->
                <div>
                    <label for="edit-titulo" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Título del Proyecto</label>
                    <input type="text" id="edit-titulo" name="titulo" required placeholder="Ej. PLATAFORMA WEB PARA ADMINISTRACIÓN DE PRÁCTICAS..." class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400 shadow-sm transition-all">
                </div>

                <!-- Grid for 2-column inputs -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Tipo de Proyecto Select -->
                    <div>
                        <label for="edit-tipo-proyecto" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Tipo de Proyecto</label>
                        <div class="relative">
                            <select id="edit-tipo-proyecto" name="tipo_proyecto" required class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 shadow-sm transition-all appearance-none cursor-pointer">
                                <option value="">Selecciona el tipo...</option>
                                <option value="Desarrollo Tecnológico">Desarrollo Tecnológico</option>
                                <option value="Investigación">Investigación Académica</option>
                                <option value="Asistencia Social">Asistencia Social / Comunitaria</option>
                                <option value="Administrativo">Administrativo / Oficina</option>
                                <option value="Infraestructura">Infraestructura y Redes</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Tipo de Modalidad Select -->
                    <div>
                        <label for="edit-tipo-modalidad" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Tipo de Modalidad</label>
                        <div class="relative">
                            <select id="edit-tipo-modalidad" name="tipo_modalidad" required class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 shadow-sm transition-all appearance-none cursor-pointer">
                                <option value="">Selecciona la modalidad...</option>
                                <option value="Presencial">Presencial</option>
                                <option value="Híbrido">Híbrido</option>
                                <option value="Virtual">Virtual / Remoto</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Textareas Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Objetivo -->
                    <div>
                        <label for="edit-objetivo" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Objetivo del Proyecto</label>
                        <textarea id="edit-objetivo" name="objetivo" rows="3" required placeholder="Describe brevemente la meta principal del proyecto..." class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400 shadow-sm transition-all resize-none"></textarea>
                    </div>

                    <!-- Justificación -->
                    <div>
                        <label for="edit-justificacion" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Justificación</label>
                        <textarea id="edit-justificacion" name="justificacion" rows="3" required placeholder="¿Por qué es necesario y qué problema resuelve?..." class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400 shadow-sm transition-all resize-none"></textarea>
                    </div>

                    <!-- Actividades -->
                    <div>
                        <label for="edit-actividades" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Actividades del Alumno</label>
                        <textarea id="edit-actividades" name="actividades" rows="3" required placeholder="Listado de tareas o funciones a realizar..." class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400 shadow-sm transition-all resize-none"></textarea>
                    </div>

                    <!-- Impacto Social -->
                    <div>
                        <label for="edit-impacto" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Impacto Social</label>
                        <textarea id="edit-impacto" name="impacto_social" rows="3" required placeholder="Beneficio que aporta a la comunidad o sector social..." class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400 shadow-sm transition-all resize-none"></textarea>
                    </div>
                </div>

                <!-- Público para Internet -->
                <div>
                    <label for="edit-publico" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Público para Internet</label>
                    <div class="relative">
                        <select id="edit-publico" name="publico_internet" required class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 shadow-sm transition-all appearance-none cursor-pointer">
                            <option value="SI">SÍ - Disponible para consulta pública en internet</option>
                            <option value="NO">NO - Solo visible internamente en la plataforma</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Footer Action Buttons -->
                <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-5 mt-4">
                    <button type="button" 
                            onclick="document.getElementById('modal-editar-proyecto').classList.add('hidden')"
                            class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-bold text-gray-500 hover:bg-gray-50 transition-all cursor-pointer">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-6 py-2.5 rounded-xl bg-[#6BA53A] text-white hover:bg-[#4E7D24] text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 transform hover:-translate-y-0.5 cursor-pointer">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
