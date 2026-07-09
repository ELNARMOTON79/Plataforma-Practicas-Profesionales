            <!-- Active Request Widget -->
            <div class="glass-card rounded-3xl p-6 fade-in-up delay-300">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Mi Solicitud de Proyecto
                </h3>

                @if($solicitudesActivas > 0 && isset($solicitud))
                    @if(in_array($solicitud->estatus, ['aprobada', 'en_proceso', 'finalizada']))
                    <div class="bg-gradient-to-br from-green-50 to-green-100/50 border border-green-150 rounded-2xl p-5 flex flex-col items-center text-center shadow-inner">
                        <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center mb-3 text-[#4E7D24] shadow-sm border border-green-50">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h4 class="font-bold text-green-950 mb-1">Solicitud Aprobada</h4>
                        <p class="text-xs text-green-900/90 font-medium mb-3">Tu solicitud de prácticas ha sido aprobada e iniciaste tu periodo.</p>
                        <a href="{{ route('estudiante.proyecto') }}" class="w-full text-center py-2.5 bg-[#4E7D24] text-white text-xs font-bold rounded-xl hover:bg-[#3d6320] transition-colors block">Ver Proyecto</a>
                    </div>
                    @elseif($solicitud->estatus === 'pendiente')
                    <div class="bg-gradient-to-br from-amber-50 to-amber-100/50 border border-amber-150 rounded-2xl p-5 flex flex-col items-center text-center shadow-inner">
                        <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center mb-3 text-amber-600 shadow-sm border border-amber-50">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h4 class="font-bold text-amber-950 mb-1">Solicitud Pendiente</h4>
                        <p class="text-xs text-amber-900/90 font-medium mb-3">En espera de revisión y firma del Coordinador de prácticas.</p>
                        <a href="{{ route('estudiante.proyecto') }}" class="w-full text-center py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-xl transition-colors block">Ver Detalles</a>
                    </div>
                    @elseif($solicitud->estatus === 'rechazada')
                    <div class="bg-gradient-to-br from-red-50 to-red-100/50 border border-red-150 rounded-2xl p-5 flex flex-col items-center text-center shadow-inner">
                        <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center mb-3 text-red-600 shadow-sm border border-red-50">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h4 class="font-bold text-red-950 mb-1">Solicitud Rechazada</h4>
                        <p class="text-xs text-red-900/90 font-medium mb-3">Tu solicitud ha sido rechazada. Revisa las observaciones.</p>
                        <a href="{{ route('estudiante.proyecto') }}" class="w-full text-center py-2.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-colors block">Ver Observaciones</a>
                    </div>
                    @endif
                @else
                <div class="flex flex-col items-center justify-center py-8 text-center">
                    <div class="w-14 h-14 bg-gray-50 rounded-full flex items-center justify-center mb-3 text-gray-300 border border-gray-100">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-400">Sin proyecto asignado</p>
                    <p class="text-xs text-gray-300 mt-1 mb-4">Aún no tienes una solicitud de prácticas activa.</p>
                    <a href="{{ route('estudiante.convenios') }}" class="text-xs font-bold text-[#4E7D24] hover:underline">Buscar convenios →</a>
                </div>
                @endif
            </div>
