@extends('layouts.estudiante', ['active' => 'documentacion'])

@section('header')
<header class="bg-white border-b border-gray-200 px-6 py-5 flex items-center justify-between shrink-0">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Bienvenido, {{ $nombre }}</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ $carrera }} - Matrícula: {{ $matricula }}</p>
    </div>
    <div class="flex items-center gap-4">
        <div class="relative">
            <button type="button" onclick="toggleProfileMenu()" class="flex items-center gap-2.5 pl-2 border-l border-gray-200 text-gray-900 hover:text-gray-700 transition-colors rounded-md hover:bg-gray-100 hover:shadow-sm" aria-haspopup="true" aria-expanded="false">
                <div class="w-9 h-9 rounded-full bg-[#4E7D24] flex items-center justify-center text-white text-sm font-bold shrink-0">
                    {{ $iniciales }}
                </div>
                <span class="text-sm font-semibold text-gray-800 hidden sm:block">{{ $nombre }}</span>
            </button>

            <div id="profile-menu" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-100 z-50">
                <div class="p-4 border-b">
                    <p class="text-sm font-semibold text-gray-900">{{ $nombre }}</p>
                    <p class="text-xs text-gray-500">{{ $carrera }}</p>
                </div>
                <a href="{{ route('estudiante.miPerfil') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">Mi Perfil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-gray-50">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </div>
</header>
@endsection

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
    @if(session('success'))
        <div class="mb-6 rounded-2xl bg-green-50 p-4 border border-green-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 rounded-2xl bg-red-50 p-4 border border-red-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif
    <div class="rounded-[32px] bg-white border border-gray-200 p-8 shadow-sm">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Documentación</h2>
                <p class="mt-2 text-sm text-gray-500">Gestiona tus documentos de prácticas profesionales</p>
            </div>
            @if($solicitud)
                <button type="button" onclick="openUploadModal('')" class="inline-flex items-center gap-2 rounded-2xl bg-[#4E7D24] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#3b6620]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Subir documento
                </button>
            @else
                <button type="button" disabled class="inline-flex items-center gap-2 rounded-2xl bg-gray-300 px-5 py-3 text-sm font-semibold text-gray-500 cursor-not-allowed">
                    Sin solicitud activa
                </button>
            @endif
        </div>

        <div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-3xl border border-gray-200 bg-gray-50 p-5 shadow-sm">
                <div class="flex items-center gap-3 text-sm font-semibold text-gray-900">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-3xl bg-white text-[#4E7D24] shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h6l6 6v10a2 2 0 01-2 2z"/>
                        </svg>
                    </span>
                    Total a subir
                </div>
                <p class="mt-4 text-3xl font-bold text-gray-900">{{ $estadisticas['total'] ?? 6 }}</p>
            </div>
            <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3 text-sm font-semibold text-gray-900">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-3xl bg-[#E7F5DD] text-[#4E7D24] shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m12-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </span>
                    Aprobados
                </div>
                <p class="mt-4 text-3xl font-bold text-gray-900">{{ $estadisticas['aprobados'] ?? 0 }}</p>
            </div>
            <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3 text-sm font-semibold text-gray-900">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-3xl bg-[#FEF3C7] text-[#B45309] shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </span>
                    Pendientes
                </div>
                <p class="mt-4 text-3xl font-bold text-gray-900">{{ $estadisticas['pendientes'] ?? 0 }}</p>
            </div>
            <div class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3 text-sm font-semibold text-gray-900">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-3xl bg-[#FFE4E6] text-[#B91C1C] shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </span>
                    Rechazados
                </div>
                <p class="mt-4 text-3xl font-bold text-gray-900">{{ $estadisticas['rechazados'] ?? 0 }}</p>
            </div>
        </div>

        <div class="mt-8 rounded-[28px] border border-gray-200 bg-gray-50 p-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <label class="relative block w-full max-w-md">
                    <span class="sr-only">Buscar documento</span>
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </span>
                    <input type="search" placeholder="Buscar documento..." class="w-full rounded-full border border-gray-200 bg-white py-3 pl-12 pr-4 text-sm text-gray-700 shadow-sm focus:border-[#4E7D24] focus:outline-none focus:ring-2 focus:ring-[#4E7D24]/20" />
                </label>
                <div class="inline-flex overflow-hidden rounded-full border border-gray-200 bg-white text-sm font-semibold">
                    <button type="button" class="px-4 py-2 bg-[#F4F9F1] text-[#4E7D24]">Todos</button>
                    <button type="button" class="px-4 py-2 text-gray-500">Pendientes</button>
                    <button type="button" class="px-4 py-2 text-gray-500">Aprobados</button>
                    <button type="button" class="px-4 py-2 text-gray-500">Rechazados</button>
                </div>
            </div>
        </div>

        <div class="mt-8 grid gap-4 md:grid-cols-2">
            @forelse($expediente as $doc)
                @php
                    $isSystem = $doc['status'] === 'system';
                    $isApproved = $doc['status'] === 'approved';
                    $isReview = $doc['status'] === 'review';
                    $isRejected = $doc['status'] === 'rejected';
                    $isLocked = $doc['status'] === 'locked';
                    
                    $bgColor = 'bg-white';
                    $iconBgColor = 'bg-gray-100 text-gray-400';
                    $badgeClass = 'bg-gray-100 text-gray-600';
                    $badgeText = 'Pendiente';
                    
                    if ($isApproved) {
                        $iconBgColor = 'bg-[#E7F5DD] text-[#4E7D24]';
                        $badgeClass = 'bg-emerald-50 text-emerald-700';
                        $badgeText = 'Aprobado';
                    } elseif ($isReview) {
                        $iconBgColor = 'bg-[#F7F0E6] text-[#92400E]';
                        $badgeClass = 'bg-amber-50 text-amber-700';
                        $badgeText = 'En Revisión';
                    } elseif ($isRejected) {
                        $iconBgColor = 'bg-[#FEE2E2] text-[#B91C1C]';
                        $badgeClass = 'bg-rose-50 text-rose-700';
                        $badgeText = 'Rechazado';
                    } elseif ($isSystem) {
                        $iconBgColor = 'bg-[#DBEAFE] text-[#1D4ED8]';
                        $badgeClass = 'bg-blue-50 text-blue-700';
                        $badgeText = 'Generado por Sistema';
                    } elseif ($isLocked) {
                        $bgColor = 'bg-gray-50 opacity-75';
                        $iconBgColor = 'bg-gray-200 text-gray-400';
                        $badgeClass = 'bg-gray-200 text-gray-500';
                        $badgeText = 'Bloqueado';
                    }
                @endphp
                <article class="rounded-[28px] border border-gray-200 {{ $bgColor }} p-6 shadow-sm">
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-3xl {{ $iconBgColor }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($isLocked)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h6l6 6v10a2 2 0 01-2 2z"/>
                                @endif
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-base font-semibold text-gray-900">{{ $doc['nombre'] }}</h3>
                            <p class="mt-2 text-sm text-gray-500">
                                @if($doc['model'])
                                    Subido: {{ $doc['model']->fecha_carga ? \Carbon\Carbon::parse($doc['model']->fecha_carga)->format('d M Y') : '—' }}
                                    @if($doc['model']->observaciones && $isRejected)
                                        <br><span class="text-red-600 font-semibold mt-1 block">Motivo: {{ $doc['model']->observaciones }}</span>
                                    @endif
                                @elseif($isLocked)
                                    Requiere aprobar documento anterior
                                @else
                                    Pendiente de subir
                                @endif
                            </p>
                        </div>
                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $badgeClass }}">{{ $badgeText }}</span>
                    </div>
                    <div class="mt-6 flex flex-wrap items-center gap-4 text-sm text-gray-500">
                        @if($doc['model'])
                            <a href="{{ asset($doc['model']->ruta_archivo) }}" target="_blank" class="inline-flex items-center gap-2 text-[#111827] hover:text-[#4E7D24]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m3-3v6m7 3H6a2 2 0 01-2-2V7a2 2 0 012-2h11l5 5v7a2 2 0 01-2 2z"/>
                                </svg>
                                Ver Archivo
                            </a>
                        @endif
                        
                        @if($isRejected)
                            <button type="button" onclick="openUploadModal('{{ $doc['nombre'] }}')" class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-4 py-2 text-[#dc2626] hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Volver a subir
                            </button>
                        @elseif($doc['status'] === 'pending')
                            <button type="button" onclick="openUploadModal('{{ $doc['nombre'] }}')" class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-4 py-2 text-[#4E7D24] hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Subir ahora
                            </button>
                        @elseif($isSystem)
                            @if($doc['nombre'] === 'Carta de Presentación' && $solicitud && in_array($solicitud->estatus, ['aprobada', 'en_proceso', 'finalizada']))
                                <a href="{{ route('estudiante.cartaPresentacion', $solicitud->id) }}" target="_blank" class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-4 py-2 text-[#1D4ED8] hover:bg-blue-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                    Generar Carta
                                </a>
                            @elseif($doc['nombre'] === 'Plan de Trabajo' && $solicitud && in_array($solicitud->estatus, ['aprobada', 'en_proceso', 'finalizada']))
                                <a href="{{ route('estudiante.planTrabajo', $solicitud->id) }}" target="_blank" class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-4 py-2 text-[#1D4ED8] hover:bg-blue-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                    Generar Plan
                                </a>
                            @endif
                        @endif
                    </div>
                </article>
            @empty
                <div class="col-span-full py-12 text-center text-gray-500">
                    No tienes documentos solicitados aún.
                </div>
            @endforelse
        </div>
    </div>
    
    @if($solicitud)
        <!-- Upload Modal -->
        <div id="upload-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="document.getElementById('upload-modal').classList.add('hidden')"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    <div>
                        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-green-100 rounded-full">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-5">
                            <h3 class="text-lg font-bold leading-6 text-gray-900" id="modal-title">Subir Documento</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Asegúrate de que el archivo esté en formato PDF y no supere los 5MB.</p>
                            </div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('estudiante.subirDocumento') }}" enctype="multipart/form-data" class="mt-5 sm:mt-6">
                        @csrf
                        <input type="hidden" name="solicitud_id" value="{{ $solicitud->id }}">
                        
                        <div class="mb-4">
                            <label for="nombre_doc" class="block text-sm font-medium text-gray-700">Tipo de Documento</label>
                            <select id="nombre_doc" name="nombre_doc" class="mt-1 block w-full rounded-xl border border-gray-200 py-3 px-4 text-sm focus:border-[#4E7D24] focus:outline-none focus:ring-2 focus:ring-[#4E7D24]/20" required>
                                <option value="">Selecciona el documento...</option>
                                <option value="Carta de Aceptación">Carta de Aceptación</option>
                                <option value="Plan de Trabajo">Plan de Trabajo (Firmado)</option>
                                <option value="Memoria de Prácticas">Memoria de Prácticas</option>
                                <option value="Evaluación de Desempeño">Evaluación de Desempeño</option>
                                <option value="Carta de Término">Carta de Término</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="archivo" class="block text-sm font-medium text-gray-700">Archivo PDF</label>
                            <input type="file" id="archivo" name="archivo" accept="application/pdf" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-[#4E7D24] hover:file:bg-green-100" required>
                        </div>

                        <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                            <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-semibold text-white bg-[#4E7D24] border border-transparent rounded-xl shadow-sm hover:bg-[#3b6620] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4E7D24] sm:col-start-2 sm:text-sm">
                                Subir Archivo
                            </button>
                            <button type="button" onclick="document.getElementById('upload-modal').classList.add('hidden')" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4E7D24] sm:mt-0 sm:col-start-1 sm:text-sm">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <script>
            function openUploadModal(docName) {
                const select = document.getElementById('nombre_doc');
                if (docName) {
                    for (let i = 0; i < select.options.length; i++) {
                        if (select.options[i].value === docName || select.options[i].text === docName) {
                            select.selectedIndex = i;
                            break;
                        }
                    }
                } else {
                    select.selectedIndex = 0;
                }
                document.getElementById('upload-modal').classList.remove('hidden');
            }
        </script>
    @endif
@endsection
