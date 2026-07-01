@extends('layouts.estudiante', ['title' => 'Mi Proyecto de Prácticas - Prácticas Profesionales UdeC', 'active' => 'proyecto'])

@section('content')
    <x-page-header title="Seguimiento de Proyecto" description="Monitorea tus horas acumuladas y gestiona la documentación de tus prácticas profesionales."></x-page-header>

    @if($solicitudActiva)

    {{-- Toast notification --}}
    <div id="projectSuccessToast" class="hidden fixed top-5 right-5 z-[100] bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl shadow-xl max-w-md fade-in-up flex items-start gap-3">
        <div class="p-1 bg-green-100 text-green-600 rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <div>
            <h4 class="font-bold text-green-950 text-sm" id="toastTitle">¡Operación Exitosa!</h4>
            <p class="text-xs text-green-900/90 mt-0.5" id="toastMessage"></p>
        </div>
        <button onclick="document.getElementById('projectSuccessToast').classList.add('hidden')" class="text-green-500 hover:text-green-800 transition-colors ml-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <div id="projectData" data-current-hours="{{ $horasCompletadas ?? 0 }}" data-total-hours="{{ $horasMeta ?? 480 }}" data-porcentaje="{{ $porcentajeHoras ?? 0 }}" data-upload-url="{{ route('estudiante.subirDocumento') }}">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">

        {{-- Left column --}}
        <div class="lg:col-span-1 flex flex-col gap-6">

            {{-- Project details card --}}
            <div class="glass-card rounded-3xl p-6 bg-gradient-to-br from-white to-[#6BA53A]/5 border border-[#6BA53A]/10 fade-in-up delay-100">
                <span class="inline-block text-[10px] font-bold text-[#4E7D24] bg-[#6BA53A]/10 px-2 py-0.5 rounded-md mb-3">
                    {{ $solicitudActiva->estatus === 'aprobada' ? 'Aprobada' : 'En Proceso' }}
                </span>
                <h3 class="text-xl font-bold text-gray-900 mb-1">
                    {{ $solicitudActiva->unidadReceptora?->nombre_empresa ?? 'Sin empresa' }}
                </h3>
                @if($solicitudActiva->observaciones)
                    <p class="text-sm text-gray-500 mb-4">{{ $solicitudActiva->observaciones }}</p>
                @endif

                <div class="border-t border-gray-150/50 pt-4 space-y-3.5 text-xs text-gray-700 font-medium">
                    @if($solicitudActiva->responsable)
                    <div>
                        <span class="block text-gray-400 font-bold mb-0.5">Responsable / Asesor</span>
                        <span class="text-sm font-bold text-gray-900">{{ $solicitudActiva->responsable }}</span>
                    </div>
                    @endif
                    @if($solicitudActiva->fecha_inicio && $solicitudActiva->fecha_fin)
                    <div>
                        <span class="block text-gray-400 font-bold mb-0.5">Periodo</span>
                        <span>
                            {{ \Carbon\Carbon::parse($solicitudActiva->fecha_inicio)->format('d/m/Y') }}
                            —
                            {{ \Carbon\Carbon::parse($solicitudActiva->fecha_fin)->format('d/m/Y') }}
                        </span>
                    </div>
                    @endif
                    <div>
                        <span class="block text-gray-400 font-bold mb-0.5">Estatus</span>
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-[#4E7D24]">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#6BA53A] opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-[#4E7D24]"></span>
                            </span>
                            {{ $solicitudActiva->estatus === 'en_proceso' ? 'En Proceso' : 'Aprobada' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Hours Progress --}}
            <div class="glass-card rounded-3xl p-6 fade-in-up delay-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Seguimiento de Horas
                </h3>

                <div class="bg-white/60 border border-gray-100 rounded-2xl p-5 mb-5 flex flex-col items-center justify-center text-center shadow-inner">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Avance de Horas</span>
                    <div class="flex items-baseline gap-1 mb-2">
                        <span class="text-4xl font-extrabold text-gray-900" id="currentHoursVal">{{ $horasCompletadas }}</span>
                        <span class="text-sm font-medium text-gray-500">/ {{ $horasMeta }} horas</span>
                    </div>
                    <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-0.5 rounded-full" id="hoursPercentageVal">{{ $porcentajeHoras }}% Completado</span>
                        <div class="w-full bg-gray-150 rounded-full h-3 overflow-hidden border border-gray-100 mt-4">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-full rounded-full transition-all duration-500" id="hoursProgressBar"></div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Right column: Documents --}}
        <div class="lg:col-span-2 flex flex-col gap-6">

            <div class="glass-card rounded-3xl p-6 fade-in-up delay-150 flex-1 flex flex-col">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#4E7D24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Expediente Digital
                    </h3>
                    <span id="uploadedCountBadge" class="text-xs text-gray-500 font-medium bg-gray-50 border border-gray-100 rounded-lg px-2.5 py-1">
                        {{ $documentos->count() }} subido(s)
                    </span>
                </div>

                @php
                    $tiposDoc = [
                        ['nombre' => 'Carta de Presentación',  'desc' => 'Expedida por el coordinador para solicitar formalmente tu espacio.'],
                        ['nombre' => 'Carta de Aceptación',    'desc' => 'Expedida por la empresa, acreditando que has sido seleccionado.'],
                        ['nombre' => 'Plan de Trabajo',        'desc' => 'Cronograma detallado con las actividades que realizarás.'],
                        ['nombre' => 'Memoria de Prácticas',   'desc' => 'Reporte académico del desarrollo de tus actividades.'],
                        ['nombre' => 'Evaluación de Desempeño','desc' => 'Evaluación calificada por tu asesor externo de la empresa.'],
                        ['nombre' => 'Carta de Término',       'desc' => 'Expedida por la empresa para validar la conclusión formal del periodo.'],
                    ];
                    $docsSubidos = $documentos->keyBy('nombre_doc');
                @endphp

                <div class="space-y-4">
                    @foreach($tiposDoc as $i => $tipo)
                        @php $doc = $docsSubidos[$tipo['nombre']] ?? null; @endphp
                        <div data-doc-name="{{ $tipo['nombre'] }}" class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 bg-white/60 rounded-2xl border {{ $doc ? 'border-gray-100' : 'border-dashed border-gray-250' }} hover:border-[#6BA53A]/20 transition-colors gap-4">
                            <div class="flex items-center gap-4">
                                <div class="p-3 rounded-xl {{ $doc ? 'bg-green-50 text-green-600' : 'bg-gray-50 text-gray-400' }}" data-doc-icon>
                                    @if($doc)
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    @else
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm">{{ $i + 1 }}. {{ $tipo['nombre'] }}</h4>
                                    <p class="text-xs text-gray-500 font-medium mt-0.5">{{ $tipo['desc'] }}</p>
                                    @if($doc)
                                        <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-md text-[10px] font-bold bg-green-50 text-green-700 border border-green-150 mt-1" data-doc-status>
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Subido — {{ \Carbon\Carbon::parse($doc->fecha_carga)->format('d/m/Y') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-md text-[10px] font-bold bg-gray-50 text-gray-500 border border-gray-200 mt-1" data-doc-status>
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Sin Subir
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @if(!$doc)
                                <button type="button" data-docname="{{ e($tipo['nombre']) }}" onclick="openUploadModal(this)" class="shrink-0 bg-[#4E7D24] text-white hover:bg-[#2E5417] px-4 py-2.5 rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition-all flex items-center gap-1" data-doc-action>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    Subir
                                </button>
                            @else
                                <a href="{{ asset('storage/' . $doc->ruta_archivo) }}" target="_blank" class="shrink-0 text-[#4E7D24] hover:bg-[#6BA53A]/10 px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1" data-doc-action>
                                    Ver PDF
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    {{-- Upload Modal --}}
    <div id="uploadModal" class="hidden fixed inset-0 z-[99] bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl border border-gray-200 max-w-md w-full overflow-hidden fade-in-up">
            <div class="bg-gradient-to-r from-gray-900 to-gray-800 p-5 text-white flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold">Subir Documento</h3>
                    <p class="text-xs text-gray-300 mt-0.5" id="uploadModalDocName"></p>
                </div>
                <button onclick="closeUploadModal()" class="text-gray-300 hover:text-white transition-colors bg-white/10 hover:bg-white/20 p-2 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-6">
                <div class="border-2 border-dashed border-gray-300 rounded-2xl p-8 flex flex-col items-center justify-center text-center hover:border-[#6BA53A] transition-colors cursor-pointer" onclick="document.getElementById('simPdfInput').click()">
                    <input type="file" id="simPdfInput" accept=".pdf" class="hidden" onchange="fileSelected(this)">
                    <div class="w-12 h-12 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mb-3" id="uploadIconContainer">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    </div>
                    <span class="block text-sm font-bold text-gray-800" id="uploadFileText">Seleccionar Archivo PDF</span>
                    <span class="text-xs text-gray-400 mt-1">Peso máximo: 5MB</span>
                </div>
            </div>
            <div class="p-6 bg-gray-50/50 border-t border-gray-100 flex gap-3">
                <button onclick="closeUploadModal()" class="flex-1 bg-white border border-gray-200 hover:bg-gray-50 text-gray-600 font-bold py-3.5 px-4 rounded-xl text-xs transition-colors shadow-sm">Cancelar</button>
                <button onclick="submitUpload()" class="flex-1 bg-[#4E7D24] hover:bg-[#3A5D1B] text-white font-bold py-3.5 px-4 rounded-xl text-xs transition-all shadow-md">Subir Archivo</button>
            </div>
        </div>
    </div>

    @else
    {{-- Empty state --}}
    <div class="glass-card rounded-3xl p-14 text-center fade-in-up delay-100">
        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-5 border border-gray-100">
            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <h3 class="text-xl font-bold text-gray-500 mb-2">Sin proyecto activo</h3>
        <p class="text-sm text-gray-400 max-w-sm mx-auto mb-6">
            Aún no tienes una solicitud de prácticas aprobada. Busca empresas con convenio y solicita tu espacio.
        </p>
        <a href="{{ route('estudiante.convenios') }}" class="inline-flex items-center gap-2 bg-[#4E7D24] text-white text-sm font-semibold px-6 py-3 rounded-2xl hover:bg-[#3b6620] transition-all shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            Buscar Convenios
        </a>
    </div>
    @endif

    <script>
        var projectEl = document.getElementById('projectData');
        var currentHours = parseInt(projectEl?.dataset.currentHours || 0, 10);
        var totalHours   = parseInt(projectEl?.dataset.totalHours || 480, 10);

        var activeDocName = '';

        function openUploadModal(trigger) {
            var docName = '';
            if (typeof trigger === 'string') {
                docName = trigger;
            } else if (trigger && trigger.getAttribute) {
                docName = trigger.getAttribute('data-docname') || trigger.dataset.docname || '';
            }
            activeDocName = docName;
            document.getElementById('uploadModalDocName').textContent = docName;
            document.getElementById('uploadFileText').textContent = 'Seleccionar Archivo PDF';
            document.getElementById('simPdfInput').value = '';
            document.getElementById('uploadIconContainer').className = 'w-12 h-12 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mb-3';
            document.getElementById('uploadIconContainer').innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>';
            document.getElementById('uploadModal').classList.remove('hidden');
        }

        function closeUploadModal() {
            document.getElementById('uploadModal').classList.add('hidden');
        }

        function fileSelected(input) {
            if (input.files && input.files[0]) {
                document.getElementById('uploadFileText').textContent = input.files[0].name;
                document.getElementById('uploadIconContainer').className = 'w-12 h-12 bg-green-50 text-green-500 rounded-full flex items-center justify-center mb-3';
                document.getElementById('uploadIconContainer').innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
            }
        }

        function submitUpload() {
            var input = document.getElementById('simPdfInput');
            if (!input.files || !input.files[0]) {
                alert('Por favor selecciona un archivo PDF.');
                return;
            }

            var uploadUrl = projectEl?.dataset.uploadUrl || '';
            if (!uploadUrl) {
                alert('No se encontró la URL de subida. Recarga la página e inténtalo de nuevo.');
                return;
            }

            var formData = new FormData();
            formData.append('nombre_doc', activeDocName);
            formData.append('archivo', input.files[0]);

            var token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            fetch(uploadUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                },
                body: formData,
            })
            .then(function(response) {
                return response.json().then(function(data) {
                    if (!response.ok) {
                        throw data;
                    }
                    return data;
                });
            })
            .then(function(data) {
                closeUploadModal();
                showToast('¡Documento subido!', data.message || 'El archivo se cargó correctamente.');
                updateDocumentState(activeDocName, data.documento);
            })
            .catch(function(error) {
                if (error && error.errors) {
                    var firstError = Object.values(error.errors)[0] || 'Ocurrió un error al subir el archivo.';
                    alert(firstError);
                } else if (error && error.error) {
                    alert(error.error);
                } else {
                    alert('Ocurrió un error al subir el archivo. Intenta nuevamente.');
                }
            });
        }

        function showToast(title, message) {
            document.getElementById('toastTitle').textContent = title;
            document.getElementById('toastMessage').textContent = message;
            var toast = document.getElementById('projectSuccessToast');
            toast.classList.remove('hidden');
            setTimeout(function() { toast.classList.add('hidden'); }, 6000);
        }

        function updateDocumentState(nombreDoc, documento) {
            var card = document.querySelector('[data-doc-name="' + nombreDoc + '"]');
            if (!card) {
                return;
            }

            var statusEl = card.querySelector('[data-doc-status]');
            if (statusEl) {
                statusEl.className = 'inline-flex items-center gap-1.5 py-0.5 px-2 rounded-md text-[10px] font-bold bg-green-50 text-green-700 border border-green-150 mt-1';
                statusEl.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Subido — ' + documento.fecha_carga;
            }

            var iconEl = card.querySelector('[data-doc-icon]');
            if (iconEl) {
                iconEl.className = 'p-3 rounded-xl bg-green-50 text-green-600';
                iconEl.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
            }

            var actionEl = card.querySelector('[data-doc-action]');
            if (actionEl) {
                var anchor = document.createElement('a');
                anchor.setAttribute('href', documento.ruta_archivo);
                anchor.setAttribute('target', '_blank');
                anchor.className = 'shrink-0 text-[#4E7D24] hover:bg-[#6BA53A]/10 px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1';
                anchor.innerHTML = 'Ver PDF <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>';
                actionEl.replaceWith(anchor);
            }

            var countEl = document.getElementById('uploadedCountBadge');
            if (countEl) {
                var currentCount = parseInt(countEl.textContent || '0', 10);
                if (!isNaN(currentCount)) {
                    countEl.textContent = (currentCount + 1) + ' subido(s)';
                }
            }
        }
    </script>
@endsection
