            <!-- Progress Section -->
            <div class="glass-card rounded-3xl p-6 fade-in-up delay-100">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Progreso del Periodo de Prácticas
                    </h2>
                    @if($solicitudesActivas > 0)
                    <a href="{{ route('estudiante.proyecto') }}" class="text-xs font-bold text-[#4E7D24] hover:text-[#2E5417] hover:underline flex items-center gap-0.5">
                        Ver Detalles
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    @endif
                </div>

                @if($solicitudesActivas > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Hours -->
                    <div class="bg-white/60 p-5 rounded-2xl border border-gray-100 flex flex-col justify-between">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-sm font-bold text-gray-500">Horas Acumuladas</span>
                            <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-0.5 rounded-full">{{ $porcentajeHoras }}% Completado</span>
                        </div>
                        <div class="flex items-baseline gap-1 mb-3">
                            <span class="text-3xl font-extrabold text-gray-900">{{ $horasCompletadas }}</span>
                            <span class="text-sm font-medium text-gray-500">/ {{ $horasMeta }} horas</span>
                        </div>
                        <div class="w-full bg-gray-150 rounded-full h-3 overflow-hidden border border-gray-100">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-full rounded-full" style="width: {{ $porcentajeHoras }}%"></div>
                        </div>
                    </div>
                    <!-- Pending docs -->
                    <div class="bg-white/60 p-5 rounded-2xl border border-gray-100 flex flex-col justify-between">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-sm font-bold text-gray-500">Progreso de Expediente</span>
                            <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-0.5 rounded-full">{{ $porcentajeDocumentos }}%</span>
                        </div>
                        <div class="flex items-baseline gap-1 mb-3">
                            <span class="text-3xl font-extrabold text-gray-900">
                                {{ isset($expediente) ? count(array_filter($expediente, fn($d) => in_array($d['status'], ['approved', 'system']))) : 0 }}
                            </span>
                            <span class="text-sm font-medium text-gray-500">/ 6 listos o aprobados</span>
                        </div>
                        <div class="w-full bg-gray-150 rounded-full h-3 overflow-hidden border border-gray-100">
                            <div class="bg-gradient-to-r from-[#4E7D24] to-[#6BA53A] h-full rounded-full" style="width: {{ $porcentajeDocumentos }}%"></div>
                        </div>
                    </div>
                </div>
                @else
                <div class="flex flex-col items-center justify-center py-8 text-center">
                    <svg class="w-12 h-12 text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    <p class="text-sm font-semibold text-gray-400">Sin prácticas activas</p>
                    <p class="text-xs text-gray-300 mt-1">El progreso se mostrará cuando tengas una solicitud aprobada.</p>
                    <a href="{{ route('estudiante.convenios') }}" class="mt-4 text-xs font-bold text-[#4E7D24] hover:underline">Buscar convenios →</a>
                </div>
                @endif
            </div>
