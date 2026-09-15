<!-- 2. VISTA DE LÍNEA DE TIEMPO -->
<div id="container-timeline-view" class="@if(request('view', 'table') != 'timeline') hidden @endif flex-1 flex flex-col min-h-0">
    <div class="relative flex-1 overflow-y-auto pr-2 space-y-8 py-4">
        <!-- Timeline Central Line -->
        <div class="absolute left-6 md:left-8 top-4 bottom-4 w-px bg-gray-200"></div>

        <div id="timeline-body" class="space-y-8">
            @foreach($logs as $log)
                <!-- Timeline Item -->
                <div class="timeline-row relative pl-14 md:pl-20 transition-all duration-300"
                     data-level="{{ $log->level }}" 
                     data-module="{{ $log->module }}"
                     data-date-group="{{ $log->timestamp->isToday() ? 'today' : ($log->timestamp->isYesterday() ? 'yesterday' : 'older') }}">
                    
                    <!-- Dot Icon -->
                    <div class="absolute left-3.5 md:left-5 top-1.5 w-6 h-6 rounded-full border-2 border-white flex items-center justify-center shadow shadow-gray-200 z-10 
                        @if($log->level == 'success') bg-green-500 text-white ring-4 ring-green-50
                        @elseif($log->level == 'info') bg-blue-500 text-white ring-4 ring-blue-50
                        @elseif($log->level == 'warning') bg-yellow-500 text-white ring-4 ring-yellow-50
                        @else bg-red-500 text-white ring-4 ring-red-50 @endif">
                        
                        @if($log->level == 'success')
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        @elseif($log->level == 'info')
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        @elseif($log->level == 'warning')
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        @else
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                        @endif
                    </div>

                    <!-- Card container -->
                    <div class="bg-white/60 hover:bg-white/95 rounded-2xl p-5 border border-gray-100 hover:shadow-md transition-all duration-300 max-w-4xl relative group">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3">
                            <div class="flex items-center gap-2.5">
                                <span class="text-xs font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wider
                                    @if($log->level == 'success') bg-green-50 text-green-700
                                    @elseif($log->level == 'info') bg-blue-50 text-blue-700
                                    @elseif($log->level == 'warning') bg-yellow-50 text-yellow-700
                                    @else bg-red-50 text-red-700 @endif">
                                    {{ $log->module }}
                                </span>
                                <span class="text-xs text-gray-400 font-bold">{{ $log->timestamp->translatedFormat('d M Y H:i:s') }}</span>
                            </div>
                        </div>

                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 h-9 w-9 rounded-full {{ $log->user_avatar_bg }} flex items-center justify-center font-extrabold text-sm shadow-xs mt-0.5">
                                    {{ $log->user_avatar_txt }}
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 mb-1 group-hover:text-[#4E7D24] transition-colors">{{ $log->action }}</h4>
                                    <p class="text-xs text-gray-600 font-medium leading-relaxed">{{ $log->description }}</p>
                                    <span class="text-[10px] text-gray-400 block mt-2 font-medium">Realizado por: <strong class="text-gray-600">{{ $log->user }}</strong> ({{ $log->user_role }} &bull; {{ $log->user_email }})</span>
                                </div>
                            </div>
                            <button type="button" 
                                    data-log="{{ json_encode($log) }}"
                                    onclick="inspectLog(JSON.parse(this.dataset.log))"
                                    class="px-3 py-1.5 bg-gray-50 hover:bg-[#6BA53A]/10 text-xs font-bold text-gray-600 hover:text-[#4E7D24] border border-gray-200/60 hover:border-[#6BA53A]/30 rounded-lg transition-all self-end sm:self-center"
                                    title="Inspeccionar Payload">
                                Ver Detalles
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
