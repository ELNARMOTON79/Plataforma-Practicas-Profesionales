<!-- Modal: Registrar Proyecto -->
<div id="modal-registrar-proyecto" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-950/60 backdrop-blur-md transition-opacity duration-300"
         onclick="document.getElementById('modal-registrar-proyecto').classList.add('hidden')"></div>

    <!-- Modal Positioning -->
    <div class="flex min-h-screen items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-3xl mx-auto overflow-hidden transform transition-all duration-300 scale-100 max-h-[90vh] flex flex-col">
            
            <!-- Header (Gradient Green Banner) -->
            <div class="bg-gradient-to-r from-[#4E7D24] to-[#6BA53A] px-8 py-6 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 p-2 rounded-xl">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 id="modal-title" class="text-lg font-bold text-white">Registrar Nuevo Proyecto</h2>
                        <p class="text-green-100 text-xs">Completa los campos para dar de alta el proyecto en el catálogo</p>
                    </div>
                </div>
                <button type="button" 
                        onclick="document.getElementById('modal-registrar-proyecto').classList.add('hidden')"
                        class="text-white/70 hover:text-white transition-colors p-1.5 rounded-lg hover:bg-white/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Registration Form with Scrollable Body -->
            <form action="{{ route('coordinador.proyectos.store') }}" method="POST" class="px-8 py-6 space-y-5 overflow-y-auto scrollbar-thin flex-1">
                @csrf

                <!-- 1. Unidad Receptora Select (Dynamically loaded from DB) -->
                <div>
                    <label for="reg-unidad" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Unidad Receptora / Institución</label>
                    <div class="relative">
                        <select id="reg-unidad" name="unidad_receptora_id" required class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 shadow-sm transition-all appearance-none cursor-pointer">
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
                    <label for="reg-titulo" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Título del Proyecto</label>
                    <input type="text" id="reg-titulo" name="titulo" required placeholder="Ej. PLATAFORMA WEB PARA ADMINISTRACIÓN DE PRÁCTICAS..." class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400 shadow-sm transition-all">
                </div>

                <!-- Grid for 2-column inputs -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Tipo de Proyecto Select -->
                    <div>
                        <label for="reg-tipo-proyecto" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Tipo de Proyecto</label>
                        <div class="relative">
                            <select id="reg-tipo-proyecto" name="tipo_proyecto" required class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 shadow-sm transition-all appearance-none cursor-pointer">
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
                        <label for="reg-tipo-modalidad" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Tipo de Modalidad</label>
                        <div class="relative">
                            <select id="reg-tipo-modalidad" name="tipo_modalidad" required class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 shadow-sm transition-all appearance-none cursor-pointer">
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
                        <label for="reg-objetivo" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Objetivo del Proyecto</label>
                        <textarea id="reg-objetivo" name="objetivo" rows="3" required placeholder="Describe brevemente la meta principal del proyecto..." class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400 shadow-sm transition-all resize-none"></textarea>
                    </div>

                    <!-- Justificación -->
                    <div>
                        <label for="reg-justificacion" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Justificación</label>
                        <textarea id="reg-justificacion" name="justificacion" rows="3" required placeholder="¿Por qué es necesario y qué problema resuelve?..." class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400 shadow-sm transition-all resize-none"></textarea>
                    </div>

                    <!-- Actividades -->
                    <div>
                        <label for="reg-actividades" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Actividades del Alumno</label>
                        <textarea id="reg-actividades" name="actividades" rows="3" required placeholder="Listado de tareas o funciones a realizar..." class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400 shadow-sm transition-all resize-none"></textarea>
                    </div>

                    <!-- Impacto Social -->
                    <div>
                        <label for="reg-impacto" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Impacto Social</label>
                        <textarea id="reg-impacto" name="impacto_social" rows="3" required placeholder="Beneficio que aporta a la comunidad o sector social..." class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 placeholder-gray-400 shadow-sm transition-all resize-none"></textarea>
                    </div>
                </div>

                <!-- Público para Internet -->
                <div>
                    <label for="reg-publico" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Público para Internet</label>
                    <div class="relative">
                        <select id="reg-publico" name="publico_internet" required class="block w-full px-4 py-3 bg-gray-50/50 border border-gray-200 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] rounded-xl text-sm font-medium text-gray-800 shadow-sm transition-all appearance-none cursor-pointer">
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
                            onclick="document.getElementById('modal-registrar-proyecto').classList.add('hidden')"
                            class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-bold text-gray-500 hover:bg-gray-50 transition-all cursor-pointer">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-6 py-2.5 rounded-xl bg-[#4E7D24] text-white hover:bg-[#2E5417] text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 transform hover:-translate-y-0.5 cursor-pointer">
                        Registrar Proyecto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
