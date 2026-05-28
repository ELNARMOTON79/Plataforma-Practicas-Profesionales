@props([
    'label',
    'value',
    'icon' => 'clock',
    'iconBg' => 'bg-blue-50',
    'iconColor' => 'text-blue-500',
    'progress' => null,
    'progressLabel' => null,
])

<div class="estudiante-stat-card flex items-center justify-between gap-4">
    <div class="min-w-0 flex-1">
        <p class="text-sm text-gray-500 font-medium mb-1">{{ $label }}</p>
        <p class="text-2xl font-bold text-gray-900">{{ $value }}</p>
        @if($progress !== null)
            <div class="mt-3">
                <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-blue-500 rounded-full transition-all duration-500" style="width: {{ min(100, $progress) }}%"></div>
                </div>
                @if($progressLabel)
                    <p class="text-xs text-gray-400 mt-1.5">{{ $progressLabel }}</p>
                @endif
            </div>
        @endif
    </div>
    <div class="shrink-0 w-11 h-11 rounded-full {{ $iconBg }} flex items-center justify-center {{ $iconColor }}">
        @if($icon === 'clock')
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        @elseif($icon === 'document')
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        @else
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        @endif
    </div>
</div>
