@props(['solicitud'])

@php
    $statusMap = [
        'aprobada' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200'],
        'rechazada' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'border' => 'border-red-200'],
        'en_proceso' => ['bg' => 'bg-sky-100', 'text' => 'text-sky-700', 'border' => 'border-sky-200'],
        'pendiente' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'border' => 'border-gray-200'],
        'finalizada' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-700', 'border' => 'border-indigo-200'],
    ];

    $status = $statusMap[$solicitud->estatus] ?? $statusMap['pendiente'];
    $company = $solicitud->unidadReceptora?->nombre_empresa ?? $solicitud->responsable ?? 'Empresa';
    $comment = $solicitud->observaciones ?: match ($solicitud->estatus) {
        'aprobada' => 'Solicitud aprobada. Puede iniciar sus prácticas en la fecha indicada.',
        'rechazada' => 'La empresa no cuenta con convenio activo. Por favor, revisa la documentación y vuelve a intentarlo.',
        'en_proceso' => 'Documentación en proceso de revisión por el coordinador.',
        'pendiente' => 'Solicitud pendiente de revisión.',
        'finalizada' => 'Prácticas finalizadas. Gracias por tu participación.',
        default => 'Solicitud en proceso.',
    };
@endphp

<div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="min-w-0">
            <p class="text-base font-semibold text-gray-900">{{ $company }}</p>
            <p class="text-xs uppercase tracking-[0.18em] text-gray-400 mt-2">Solicitud #{{ str_pad($solicitud->id, 4, '0', STR_PAD_LEFT) }}</p>
        </div>
        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $status['bg'] }} {{ $status['text'] }} {{ $status['border'] }} border">
            {{ ucfirst(str_replace('_', ' ', $solicitud->estatus)) }}
        </span>
    </div>

    <div class="mt-6 grid gap-4 sm:grid-cols-3">
        <div class="rounded-3xl border border-gray-100 bg-gray-50 p-4">
            <p class="text-[11px] uppercase tracking-[0.2em] text-gray-400">Fecha de Solicitud</p>
            <p class="mt-2 text-sm font-semibold text-gray-900">{{ $solicitud->fecha_inicio->format('d M Y') }}</p>
        </div>
        <div class="rounded-3xl border border-gray-100 bg-gray-50 p-4">
            <p class="text-[11px] uppercase tracking-[0.2em] text-gray-400">Fecha de Inicio</p>
            <p class="mt-2 text-sm font-semibold text-gray-900">{{ $solicitud->fecha_inicio->format('d M Y') }}</p>
        </div>
        <div class="rounded-3xl border border-gray-100 bg-gray-50 p-4">
            <p class="text-[11px] uppercase tracking-[0.2em] text-gray-400">Horas Previstas</p>
            <p class="mt-2 text-sm font-semibold text-gray-900">480 horas</p>
        </div>
    </div>

    <div class="mt-6 rounded-3xl border border-gray-100 bg-gray-50 p-4">
        <p class="text-xs uppercase tracking-[0.18em] text-gray-400">Comentarios del Coordinador</p>
        <p class="mt-3 text-sm leading-6 text-gray-600">{{ $comment }}</p>
    </div>

    <div class="mt-6 flex justify-end">
        <a href="#" class="inline-flex items-center gap-2 rounded-full border border-[#4E7D24] bg-white px-4 py-2 text-sm font-semibold text-[#4E7D24] transition hover:bg-[#f3fbf1]">
            Ver Detalles
        </a>
    </div>
</div>
