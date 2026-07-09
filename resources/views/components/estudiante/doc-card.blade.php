{{--
    Document Card Component
    Props (required):
      $docId    – integer, unique ID used for DOM targeting (e.g. 1–6)
      $title    – string, document name shown in the UI
      $status   – string: 'pending'|'review'|'approved'|'system'
                   pending  → "Sin Subir"  (dashed border, upload button)
                    review   → "En Revisión" (yellow icon, re-upload button)
                   approved → "Aprobado"   (green icon, view button)
                   system   → "Listo para Generar" (blue icon, generate button)
                   rejected → "Rechazado" (red icon, view & re-upload buttons)
    Props (optional):
      $onGenerate – JS string to call when status === 'system', e.g. "simulateViewPdf('Carta de Presentación','Generado por Sistema')"
      $onUpload   – JS string to call for upload, e.g. "openUploadModal(2,'Carta de Aceptación')"
    Usage:
      <x-estudiante.doc-card :doc-id="1" title="Carta de Presentación" status="system"
          on-generate="simulateViewPdf('Carta de Presentación', 'Generado por Sistema')" />
      <x-estudiante.doc-card :doc-id="2" title="Carta de Aceptación" status="pending"
          on-upload="openUploadModal(2, 'Carta de Aceptación')" />
--}}
@props([
    'docId',
    'title',
    'status',
    'onGenerate' => '',
    'onUpload' => '',
    'onView' => ''
])

@php
    $statusMap = [
        'system'   => ['label' => 'Listo para Generar', 'badgeClass' => 'text-blue-700 bg-blue-50/80 border-blue-150',   'iconBg' => 'bg-blue-50 text-blue-600',   'rowClass' => 'border-gray-100',        'dashed' => false],
        'approved' => ['label' => 'Aprobado',           'badgeClass' => 'text-green-700 bg-green-50 border-green-200',   'iconBg' => 'bg-green-50 text-green-600', 'rowClass' => 'border-gray-100',        'dashed' => false],
        'review'   => ['label' => 'En Revisión',        'badgeClass' => 'text-yellow-700 bg-yellow-50 border-yellow-100','iconBg' => 'bg-yellow-50 text-yellow-600','rowClass' => 'border-gray-100 hover:border-yellow-300', 'dashed' => false],
        'rejected' => ['label' => 'Rechazado',          'badgeClass' => 'text-red-700 bg-red-50 border-red-200',         'iconBg' => 'bg-red-50 text-red-600',     'rowClass' => 'border-red-100 hover:border-red-300', 'dashed' => true],
        'pending'  => ['label' => 'Sin Subir',          'badgeClass' => 'text-gray-500 bg-gray-50 border-gray-200',      'iconBg' => 'bg-gray-50 text-gray-400',   'rowClass' => 'border-dashed border-gray-250 hover:border-[#6BA53A]/45', 'dashed' => true],
        'locked'   => ['label' => 'Bloqueado',          'badgeClass' => 'text-gray-400 bg-gray-100 border-gray-200',     'iconBg' => 'bg-gray-100 text-gray-400',  'rowClass' => 'border-gray-200 bg-gray-50/50 opacity-60 pointer-events-none grayscale-[0.5]', 'dashed' => false],
    ];

    $cfg      = $statusMap[$status] ?? $statusMap['pending'];
    $rowBorder = $cfg['dashed'] ? 'border-dashed border-gray-250 hover:border-[#6BA53A]/45' : $cfg['rowClass'];
@endphp

<div class="bg-white/60 border {{ $rowBorder }} rounded-2xl p-4 flex flex-col justify-between shadow-sm transition-colors"
     id="docRow-{{ $docId }}">

    {{-- Header: icon + title + badge --}}
    <div class="flex items-center justify-between gap-2 mb-4">
        <div class="flex items-center gap-3">
            <div class="{{ $cfg['iconBg'] }} p-2 rounded-xl" id="docIconContainer-{{ $docId }}">
                @if($status === 'system')
                    {{-- Document icon --}}
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                @elseif($status === 'approved')
                    {{-- Checkmark icon --}}
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                @elseif($status === 'review')
                    {{-- Clock icon --}}
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                @elseif($status === 'rejected')
                    {{-- X icon --}}
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                @elseif($status === 'locked')
                    {{-- Lock icon --}}
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                @else
                    {{-- Upload / pending icon --}}
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                @endif
            </div>

            <div>
                <h5 class="text-xs font-extrabold text-gray-900">{{ $title }}</h5>
                <span class="inline-block text-[9px] font-bold {{ $cfg['badgeClass'] }} px-2 py-0.5 rounded mt-1 border"
                      id="docBadge-{{ $docId }}">
                    {{ $cfg['label'] }}
                </span>
            </div>
        </div>

        {{-- View button (only for approved / review / rejected docs) --}}
        @if(in_array($status, ['approved', 'review', 'rejected']) && !empty($onView))
            <button onclick="{{ $onView }}" class="text-gray-400 hover:text-gray-700 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </button>
        @endif
    </div>

    {{-- Action button --}}
    <div id="docActions-{{ $docId }}">
        @if($status === 'system' && !empty($onGenerate))
            <div class="flex flex-col gap-2 w-full">
                <button onclick="{{ $onGenerate }}"
                        class="w-full text-center py-2.5 bg-[#4E7D24] hover:bg-[#3A5D1B] text-white text-xs font-bold rounded-xl transition-all shadow-md flex items-center justify-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Generar Carta
                </button>
                @if(!empty($onUpload))
                    <button onclick="{{ $onUpload }}"
                            class="w-full text-center py-2 border border-[#4E7D24]/30 hover:bg-[#4E7D24]/5 text-[#4E7D24] text-xs font-bold rounded-xl transition-all shadow-sm">
                        Subir Carta Firmada
                    </button>
                @endif
            </div>

        @elseif($status === 'pending' && !empty($onUpload))
            <button onclick="{{ $onUpload }}"
                    class="w-full text-center py-2.5 bg-[#4E7D24] hover:bg-[#2E5417] text-white text-xs font-bold rounded-xl transition-all shadow-md">
                Subir Archivo
            </button>

        @elseif($status === 'rejected' && !empty($onUpload))
            <div class="flex flex-col gap-2 w-full">
                @if(!empty($onView))
                <button onclick="{{ $onView }}"
                        class="w-full text-center py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs font-bold rounded-xl transition-all shadow-sm">
                    Ver Rechazado
                </button>
                @endif
                <button onclick="{{ $onUpload }}"
                        class="w-full text-center py-2.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-all shadow-md">
                    Volver a Subir
                </button>
            </div>

        @elseif(in_array($status, ['approved', 'review']) && !empty($onView))
            <button onclick="{{ $onView }}"
                    class="w-full text-center py-2.5 bg-[#4E7D24] hover:bg-[#3A5D1B] text-white text-xs font-bold rounded-xl transition-all shadow-md">
                Ver Documento
            </button>
            
        @elseif($status === 'locked')
            <div class="w-full text-center py-2.5 bg-gray-200 text-gray-500 text-[11px] font-bold rounded-xl flex items-center justify-center gap-2 border border-gray-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Requiere aprobación previa
            </div>
        @endif
    </div>
</div>
