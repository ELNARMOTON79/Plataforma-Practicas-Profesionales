<!-- 1. VISTA DE TABLA -->
<div id="container-table-view" class="flex-1 flex flex-col min-h-0 @if(request('view', 'table') == 'timeline') hidden @endif">
    <div class="overflow-x-auto flex-1">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50/50">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl w-44">Fecha / Hora</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-24">Nivel</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-64">Usuario</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-36">Módulo</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Acción / Descripción</th>
                    <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl w-24">Acciones</th>
                </tr>
            </thead>
            <tbody id="table-body" class="bg-transparent divide-y divide-gray-100">
                @foreach($logs as $log)
                    <tr class="log-row hover:bg-[#6BA53A]/5 transition-colors group" 
                        data-level="{{ $log->level }}" 
                        data-module="{{ $log->module }}"
                        data-date-group="{{ $log->timestamp->isToday() ? 'today' : ($log->timestamp->isYesterday() ? 'yesterday' : 'older') }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                            <div class="font-bold text-gray-800">{{ $log->timestamp->translatedFormat('d M Y') }}</div>
                            <div class="text-xs text-gray-400 mt-0.5 font-normal">{{ $log->timestamp->format('H:i:s') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($log->level == 'success')
                                <span class="px-2.5 py-1 inline-flex items-center text-xs leading-5 font-bold rounded-lg bg-green-50 text-green-700 border border-green-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span> {{ $log->level_name }}
                                </span>
                            @elseif($log->level == 'info')
                                <span class="px-2.5 py-1 inline-flex items-center text-xs leading-5 font-bold rounded-lg bg-blue-50 text-blue-700 border border-blue-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5"></span> {{ $log->level_name }}
                                </span>
                            @elseif($log->level == 'warning')
                                <span class="px-2.5 py-1 inline-flex items-center text-xs leading-5 font-bold rounded-lg bg-yellow-50 text-yellow-700 border border-yellow-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 mr-1.5"></span> {{ $log->level_name }}
                                </span>
                            @else
                                <span class="px-2.5 py-1 inline-flex items-center text-xs leading-5 font-bold rounded-lg bg-red-50 text-red-700 border border-red-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span> {{ $log->level_name }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-9 w-9 rounded-full {{ $log->user_avatar_bg }} flex items-center justify-center font-extrabold text-sm shadow-sm">
                                    {{ $log->user_avatar_txt }}
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors">{{ $log->user }}</div>
                                    <div class="text-xs text-gray-500 font-semibold">{{ $log->user_role }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-bold">
                            {{ $log->module }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-900 mb-0.5">{{ $log->action }}</div>
                            <p class="text-xs text-gray-500 font-medium line-clamp-1">{{ $log->description }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button type="button" 
                                    data-log="{{ json_encode($log) }}"
                                    onclick="inspectLog(JSON.parse(this.dataset.log))"
                                    class="p-2 text-[#4E7D24] hover:text-[#2E5417] hover:bg-[#6BA53A]/10 rounded-xl transition-all" 
                                    title="Inspeccionar Payload">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
