                <form action="#" method="POST" class="mt-10 space-y-6">
                    @csrf
                    <div class="space-y-6">
                        <!-- Carta de Presentación -->
                        <div>
                            <label class="text-sm font-semibold text-gray-700">Carta de Presentación <span class="text-red-500">*</span></label>
                            <div class="mt-3 rounded-xl border border-dashed border-[#c0e6af] bg-[#fcfdfa] p-8 text-center text-sm text-gray-500 transition hover:bg-[#f6faf1] hover:border-[#8cc772] cursor-pointer">
                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-white text-gray-400 shadow-sm mb-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0l-3-3m3 3l3-3M8 21h8"/>
                                    </svg>
                                </div>
                                <p class="font-medium text-gray-700">Haz clic para subir o arrastra el archivo</p>
                                <p class="text-xs text-gray-400 mt-2">PDF (Max. 5MB)</p>
                            </div>
                        </div>

                        <!-- Convenio Firmado -->
                        <div>
                            <label class="text-sm font-semibold text-gray-700">Convenio Firmado <span class="text-gray-400">(Opcional)</span></label>
                            <div class="mt-3 rounded-xl border border-dashed border-[#c0e6af] bg-[#fcfdfa] p-8 text-center text-sm text-gray-500 transition hover:bg-[#f6faf1] hover:border-[#8cc772] cursor-pointer">
                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-white text-gray-400 shadow-sm mb-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h10M7 11h10M7 15h6"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 3h3.5a1.5 1.5 0 011.5 1.5V9"/>
                                    </svg>
                                </div>
                                <p class="font-medium text-gray-700">Haz clic para subir o arrastra el archivo</p>
                                <p class="text-xs text-gray-400 mt-2">PDF (Max. 5MB)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Nota Informativa -->
                    <div class="rounded-xl border border-[#f2e5c9] bg-[#fffbf1] p-4 text-sm text-gray-750">
                        <p><span class="font-semibold text-amber-800">Nota:</span> Una vez enviada la solicitud, será revisada por el coordinador. Recibirás una notificación con la respuesta en 2-3 días hábiles.</p>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between items-center pt-4">
                        <a href="{{ route('estudiante.nuevaSolicitudDetalles') }}" class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-6 py-2.5 text-sm font-semibold text-gray-600 shadow-sm transition hover:bg-gray-50">
                            <span class="mr-2 font-bold">&lt;</span> Anterior
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#a2d98a] hover:bg-[#8cc772] px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-250">
                            Enviar Solicitud
                        </button>
                    </div>
                </form>
