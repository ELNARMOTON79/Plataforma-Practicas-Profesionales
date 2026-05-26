<div class="glass-card rounded-3xl p-6 fade-in-up delay-300 flex-1 flex flex-col min-h-0">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Bitácora del Sistema
                        </h3>
                        <a href="{{ route('admin.bitacora') }}" class="text-gray-400 hover:text-[#4E7D24]"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg></a>
                    </div>
                    
                    <div class="relative flex-1 min-h-0 overflow-y-auto pr-2 space-y-6">
                        <!-- Timeline Line -->
                        <div class="absolute left-4 top-2 bottom-0 w-px bg-gray-200"></div>

                        @forelse($recentLogs as $log)
                            @php
                                $dotColor = 'bg-gray-400 ring-gray-50';
                                $cardBg = 'bg-white/60 border-gray-100';
                                $textColors = 'text-gray-900';
                                $descColors = 'text-gray-600';
                                $timeColors = 'text-gray-400';

                                if ($log->level === 'success') {
                                    $dotColor = 'bg-green-500 ring-green-50';
                                } elseif ($log->level === 'info') {
                                    $dotColor = 'bg-blue-500 ring-blue-50';
                                } elseif ($log->level === 'warning') {
                                    $dotColor = 'bg-yellow-500 ring-yellow-50';
                                } elseif ($log->level === 'danger' || $log->level === 'error') {
                                    $dotColor = 'bg-red-500 ring-red-50';
                                    $cardBg = 'bg-red-50/50 border-red-100';
                                    $textColors = 'text-red-900';
                                    $descColors = 'text-red-700';
                                    $timeColors = 'text-red-400';
                                }
                            @endphp
                            <!-- Log Item -->
                            <div class="relative pl-10">
                                <div class="absolute left-2.5 top-1 w-3 h-3 {{ $dotColor }} rounded-full border-2 border-white shadow-sm ring-4"></div>
                                <div class="{{ $cardBg }} rounded-xl p-4 border hover:shadow-sm transition-shadow">
                                    <div class="flex justify-between items-start mb-1 gap-2">
                                        <h4 class="text-sm font-bold {{ $textColors }}">{{ $log->action }}</h4>
                                        <span class="text-xs font-semibold {{ $timeColors }} whitespace-nowrap">{{ $log->time_ago }}</span>
                                    </div>
                                    <p class="text-xs {{ $descColors }} font-medium">{{ $log->description }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500 text-sm">
                                No hay registros en la bitácora del sistema.
                            </div>
                        @endforelse
                    </div>
                    
                    <a href="{{ route('admin.bitacora') }}" class="mt-4 w-full py-2.5 bg-gray-50 hover:bg-gray-100 text-gray-600 font-bold rounded-xl transition-colors text-sm border border-gray-200 text-center block">
                        Cargar más actividad
                    </a>
                </div>
