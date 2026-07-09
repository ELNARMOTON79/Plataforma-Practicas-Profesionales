        <!-- Grid of Companies -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 fade-in-up delay-200">
            @foreach($unidades as $unidad)
                @php
                    $esMoral = strtolower($unidad->tipo_persona ?? '') === 'moral';
                    $tipoLabel = $esMoral ? 'Persona Moral' : 'Persona Física';
                    $tipoColor = $esMoral ? 'blue' : 'orange';
                @endphp
                <div class="glass-card rounded-3xl p-6 flex flex-col justify-between border-transparent hover:border-[#6BA53A]/20 transition-colors">
                    <div>
                        <div class="flex justify-between items-start gap-4 mb-4">
                            <div>
                                <span class="inline-block text-[10px] font-bold text-{{ $tipoColor }}-600 bg-{{ $tipoColor }}-50 border border-{{ $tipoColor }}-100 px-2 py-0.5 rounded-md mb-2">{{ $tipoLabel }}</span>
                                <h3 class="text-xl font-bold text-gray-900">{{ $unidad->nombre_empresa }}</h3>
                            </div>
                            <span class="inline-flex items-center gap-1 text-xs font-bold text-green-700 bg-green-50 border border-green-100 px-2.5 py-1 rounded-full shrink-0">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Vigente
                            </span>
                        </div>

                        @if($unidad->direccion)
                            <p class="text-sm text-gray-500 font-medium mb-4 flex items-start gap-1.5">
                                <svg class="w-4 h-4 mt-0.5 shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $unidad->direccion }}
                            </p>
                        @endif
                    </div>

                    <div class="pt-4 border-t border-gray-100/50 flex items-center justify-between">
                        <span class="text-xs text-gray-400 font-medium truncate max-w-[130px]" title="{{ $unidad->nombre_empresa }}">{{ $unidad->nombre_empresa }}</span>
                        <div class="flex items-center gap-2 shrink-0">
                            <button type="button" 
                                    data-unidad="{{ json_encode($unidad) }}"
                                    onclick="openUnidadModal(JSON.parse(this.getAttribute('data-unidad')))" 
                                    class="text-xs font-bold text-[#4E7D24] bg-[#6BA53A]/10 px-3 py-1.5 rounded-xl hover:bg-[#4E7D24] hover:text-white transition-all shadow-sm cursor-pointer">
                                Ver detalle
                            </button>
                            @if(isset($tieneSolicitud) && $tieneSolicitud)
                            <button type="button" disabled class="text-xs font-bold text-gray-400 bg-gray-100 border border-gray-200 px-3 py-1.5 rounded-xl cursor-not-allowed select-none" title="Ya cuentas con una solicitud registrada (Límite: 1)">
                                Solicitud activa
                            </button>
                            @else
                            <a href="{{ route('estudiante.nuevaSolicitud', ['ur_id' => $unidad->id]) }}" 
                               class="text-xs font-bold text-white bg-[#4E7D24] px-3 py-1.5 rounded-xl hover:bg-[#3b6620] transition-all shadow-sm">
                                Iniciar solicitud
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <p class="text-center text-sm text-gray-400 fade-in-up delay-300">
            {{ $unidades->count() }} empresa{{ $unidades->count() !== 1 ? 's' : '' }} registrada{{ $unidades->count() !== 1 ? 's' : '' }}
        </p>
