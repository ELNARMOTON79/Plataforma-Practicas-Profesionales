                <form action="{{ route('estudiante.storeSolicitud') }}" method="POST" class="mt-10 space-y-6">
                    @csrf
                    @foreach(request()->only(['ur_id', 'empresa_nombre', 'empresa_direccion', 'supervisor_nombre', 'supervisor_telefono', 'supervisor_email']) as $k => $v)
                        @if($v)
                            <input type="hidden" name="{{ $k }}" value="{{ $v }}" />
                        @endif
                    @endforeach

                    <div class="grid gap-5">
                        <!-- Banner Resumen de Cálculo Automático -->
                        <div id="resumen-calculo-dias" class="hidden p-4 rounded-2xl bg-gradient-to-r from-[#4E7D24]/10 via-[#6BA53A]/10 to-transparent border border-[#4E7D24]/20 flex items-center justify-between gap-4 shadow-sm fade-in-up">
                            <div class="flex items-center gap-3.5">
                                <div class="w-11 h-11 rounded-xl bg-[#4E7D24] text-white flex items-center justify-center font-bold shadow-sm shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <span class="inline-block bg-[#4E7D24] text-white text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-md mb-1">⚡ Cálculo Automático (Colima, MX)</span>
                                    <p class="text-xs font-bold text-gray-800">
                                        Fin estimado: <span id="resumen-fecha-fin-texto" class="text-[#4E7D24] font-extrabold text-sm"></span> 
                                        (<span id="resumen-dias-habiles">0 días hábiles</span> a <span id="resumen-horas-diarias">6 hrs/día</span>)
                                    </p>
                                    <p class="text-[11px] text-gray-600 mt-0.5">Excluye fines de semana y feriados oficiales (LFT / Estatales Colima / UdeC).</p>
                                </div>
                            </div>
                        </div>

                        <!-- Fecha de Inicio & Fecha de Finalización -->
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Fecha de Inicio <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio" min="{{ date('Y-m-d') }}" onclick="this.showPicker && this.showPicker()" onchange="calcularFechaFin()" class="w-full rounded-xl border border-gray-200 bg-white py-3 px-4 text-sm text-gray-700 shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all cursor-pointer" required />
                            </div>
                            <div class="space-y-2">
                                <label class="flex items-center justify-between text-sm font-semibold text-gray-700">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Fecha de Finalización <span class="text-red-500">*</span>
                                    </span>
                                </label>
                                <input type="date" name="fecha_fin" id="fecha_fin" class="w-full rounded-xl border bg-gray-100/80 border-gray-300 text-gray-600 font-semibold cursor-not-allowed select-none py-3 px-4 text-sm shadow-sm transition-all" readonly required />
                            </div>
                        </div>

                        <!-- Horas Previstas (Fijo UdeC: 480 hrs) -->
                        <div class="space-y-2">
                            <label class="flex items-center justify-between text-sm font-semibold text-gray-700">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Horas Previstas <span class="text-red-500">*</span>
                                </span>
                            </label>
                            <input type="text" value="480 horas (80 días hábiles a 6 hrs/día)" class="w-full rounded-xl border bg-gray-100/80 border-gray-300 text-gray-600 font-semibold cursor-not-allowed select-none py-3 px-4 text-sm shadow-sm transition-all" readonly />
                            <input type="hidden" name="horas_previstas" id="horas_previstas" value="480" />
                        </div>

                        <!-- Título -->
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h10M7 12h6"/>
                                </svg>
                                Título <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="titulo" id="titulo" placeholder="Título de la práctica profesional" class="w-full rounded-xl border border-gray-200 bg-white py-3 px-4 text-sm text-gray-700 shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all" required />
                        </div>

                        <!-- Objetivo -->
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Objetivo <span class="text-red-500">*</span>
                            </label>
                            <textarea name="objetivo" id="objetivo" rows="3" placeholder="¿Qué se pretende lograr con esta práctica profesional?" class="w-full rounded-xl border border-gray-200 bg-white py-3 px-4 text-sm text-gray-700 shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all" required></textarea>
                        </div>

                        <!-- Justificación -->
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Justificación <span class="text-red-500">*</span>
                            </label>
                            <textarea name="justificacion" id="justificacion" rows="3" placeholder="¿Por qué es importante realizar esta práctica?" class="w-full rounded-xl border border-gray-200 bg-white py-3 px-4 text-sm text-gray-700 shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all" required></textarea>
                        </div>

                        <!-- Actividades -->
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10"/>
                                </svg>
                                Actividades <span class="text-red-500">*</span>
                            </label>
                            <textarea name="actividades" id="actividades" rows="4" placeholder="Describe las actividades que realizarás durante las prácticas..." class="w-full rounded-xl border border-gray-200 bg-white py-3 px-4 text-sm text-gray-700 shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all" required></textarea>
                        </div>

                        <!-- Impacto Social -->
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Impacto Social <span class="text-red-500">*</span>
                            </label>
                            <textarea name="impacto_social" id="impacto_social" rows="3" placeholder="¿Qué beneficio aportará esta práctica a la sociedad o comunidad?" class="w-full rounded-xl border border-gray-200 bg-white py-3 px-4 text-sm text-gray-700 shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all" required></textarea>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between items-center pt-4">
                        <a href="{{ route('estudiante.nuevaSolicitud') }}" class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-6 py-2.5 text-sm font-semibold text-gray-600 shadow-sm transition hover:bg-gray-50">
                            <span class="mr-2 font-bold">&lt;</span> Anterior
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#4E7D24] hover:bg-[#3b6620] px-8 py-3 text-sm font-bold text-white shadow-md transition-all duration-250 cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Solicitar
                        </button>
                    </div>
                </form>
