            <!-- Documents Checklist Summary -->
            <div class="glass-card rounded-3xl p-6 fade-in-up delay-200">
                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2 mb-6">
                    <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Estatus de Expediente de Documentos
                </h2>

                @if(isset($expediente) && count($expediente) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($expediente as $doc)
                    <a href="{{ route('estudiante.proyecto') }}#expediente-digital" class="flex items-center justify-between p-4 bg-white/70 hover:bg-[#4E7D24]/5 hover:border-[#4E7D24]/30 rounded-2xl border border-gray-100 transition-all group cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="p-2 {{ $doc['iconBg'] }} rounded-xl">
                                @if($doc['status'] === 'system')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                @elseif($doc['status'] === 'approved')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @elseif($doc['status'] === 'review')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                @endif
                            </div>
                            <span class="text-sm font-semibold text-gray-750 group-hover:text-[#4E7D24] transition-colors">{{ $doc['title'] }}</span>
                        </div>
                        <span class="text-[10px] font-bold {{ $doc['badgeClass'] }} px-2 py-0.5 rounded-md border">
                            {{ $doc['label'] }}
                        </span>
                    </a>
                    @endforeach
                </div>
                @else
                <div class="flex flex-col items-center justify-center py-8 text-center">
                    <svg class="w-12 h-12 text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <p class="text-sm font-semibold text-gray-400">Sin documentos por revisar</p>
                    <p class="text-xs text-gray-300 mt-1">Los documentos aparecerán una vez que tengas una práctica activa.</p>
                </div>
                @endif
            </div>
