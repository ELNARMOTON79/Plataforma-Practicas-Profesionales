@extends('layouts.estudiante', ['title' => 'Convenios Disponibles - Prácticas Profesionales UdeC', 'active' => 'convenios'])

@section('content')
    <x-page-header title="Empresas y Convenios" description="Consulta las empresas vinculadas y solicita tu participación en proyectos de prácticas profesionales."></x-page-header>

    {{-- Search & Filters --}}
    <div class="glass-card rounded-3xl p-6 fade-in-up delay-100">
        <form method="GET" action="{{ route('estudiante.convenios') }}" id="convenios-form" class="flex flex-col gap-4">

            {{-- Search row --}}
            <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center">
                <div class="relative w-full">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" name="q" id="search-input" value="{{ $search }}"
                        class="block w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl bg-white/70 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/20 focus:border-[#6BA53A] sm:text-sm transition-all shadow-sm"
                        placeholder="Buscar por empresa o dirección..."
                        autocomplete="off">
                    <p id="search-error" class="hidden absolute -bottom-5 left-1 text-xs text-red-500 font-medium"></p>
                </div>
                <button type="submit" onclick="return validateSearch()" class="shrink-0 px-6 py-3.5 bg-[#4E7D24] text-white text-sm font-semibold rounded-2xl hover:bg-[#3b6620] transition-all shadow-sm">
                    Buscar
                </button>
                @if($search || $carreraFilter)
                    <a href="{{ route('estudiante.convenios') }}" class="shrink-0 text-sm text-gray-500 hover:text-gray-700 font-medium whitespace-nowrap">
                        Limpiar filtros
                    </a>
                @endif
            </div>

            {{-- Carrera filter --}}
            @if($carreras->isNotEmpty())
            <div class="flex flex-wrap gap-2 items-center pt-1">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Filtrar por carrera:</span>
                <a href="{{ route('estudiante.convenios', array_filter(['q' => $search])) }}"
                    class="text-xs font-semibold px-3 py-1.5 rounded-xl border transition-all
                        {{ !$carreraFilter ? 'bg-[#4E7D24] text-white border-[#4E7D24]' : 'bg-white text-gray-600 border-gray-200 hover:border-[#4E7D24]/40 hover:text-[#4E7D24]' }}">
                    Todas
                </a>
                @foreach($carreras as $carrera)
                    <a href="{{ route('estudiante.convenios', array_filter(['q' => $search, 'carrera' => $carrera])) }}"
                        class="text-xs font-semibold px-3 py-1.5 rounded-xl border transition-all
                            {{ $carreraFilter === $carrera ? 'bg-[#4E7D24] text-white border-[#4E7D24]' : 'bg-white text-gray-600 border-gray-200 hover:border-[#4E7D24]/40 hover:text-[#4E7D24]' }}">
                        {{ $carrera }}
                    </a>
                @endforeach
            </div>
            @endif

        </form>
    </div>

    @if($unidades->isEmpty())
        <div class="glass-card rounded-3xl p-14 text-center fade-in-up delay-200">
            <svg class="w-14 h-14 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            <h3 class="text-lg font-bold text-gray-500">No se encontraron empresas</h3>
            <p class="text-sm text-gray-400 mt-1">
                @if($search && $carreraFilter)
                    Ninguna empresa de "{{ $carreraFilter }}" coincide con "{{ $search }}".
                @elseif($search)
                    Ninguna empresa coincide con "{{ $search }}".
                @elseif($carreraFilter)
                    Aún no hay empresas registradas con estudiantes de "{{ $carreraFilter }}".
                @else
                    Aún no hay unidades receptoras registradas.
                @endif
            </p>
            @if($search || $carreraFilter)
                <a href="{{ route('estudiante.convenios') }}" class="mt-4 inline-block text-sm font-semibold text-[#4E7D24] hover:underline">
                    Ver todas las empresas
                </a>
            @endif
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 fade-in-up delay-200">
            @foreach($unidades as $unidad)
                @php
                    $esMoral   = strtolower($unidad->tipo_persona ?? '') === 'moral';
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

                        {{-- Convenios --}}
                        @if($unidad->convenios->isNotEmpty())
                            <div class="mt-4 space-y-2">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Convenios disponibles:</p>
                                @foreach($unidad->convenios as $convenio)
                                    @php
                                        $esVigente = $convenio->estatus === 'activo' && $convenio->fecha_termino > now()->toDateString();
                                    @endphp
                                    <div class="text-xs bg-gray-50 border border-gray-150 rounded-lg p-2.5 flex justify-between items-start gap-2">
                                        <div>
                                            <p class="font-semibold text-gray-700">{{ $convenio->codigo_convenio }}</p>
                                            <p class="text-gray-500 mt-0.5">{{ $convenio->fecha_inicio->format('d/m/Y') }} - {{ $convenio->fecha_termino->format('d/m/Y') }}</p>
                                        </div>
                                        <span class="shrink-0 px-2 py-1 rounded text-white text-[10px] font-bold {{ $esVigente ? 'bg-green-500' : 'bg-gray-400' }}">
                                            {{ $esVigente ? 'Vigente' : 'Vencido' }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-gray-400 mt-4 italic">Sin convenios registrados</p>
                        @endif
                    </div>

                    <div class="pt-4 border-t border-gray-100/50 flex items-center justify-between">
                        <span class="text-xs text-gray-400 font-medium">{{ $unidad->tipo_persona ? ucfirst($unidad->tipo_persona) : '' }}</span>
                        <button
                            type="button"
                            data-unidad='{{ json_encode($unidad->only(['id', 'nombre_empresa', 'direccion', 'tipo_persona']), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) }}'
                            data-convenios='{{ json_encode($unidad->convenios, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) }}'
                            onclick="showConvenioModal(this)"
                            class="text-xs font-bold text-[#4E7D24] bg-[#6BA53A]/10 px-4 py-2 rounded-xl hover:bg-[#4E7D24] hover:text-white transition-all shadow-sm"
                        >
                            Ver detalle
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <p class="text-center text-sm text-gray-400 fade-in-up delay-300">
            {{ $unidades->count() }} empresa{{ $unidades->count() !== 1 ? 's' : '' }} encontrada{{ $unidades->count() !== 1 ? 's' : '' }}
        </p>
    @endif

    {{-- Modal Solicitar Práctica --}}
    <div id="solicitudModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeSolicitudModal()"></div>
        <div class="relative bg-white rounded-3xl shadow-2xl border border-gray-100 w-full max-w-lg overflow-hidden">
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                <div>
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Solicitar práctica en</p>
                    <h3 class="text-lg font-bold text-gray-900 mt-0.5" id="solicitudEmpresaNombre"></h3>
                </div>
                <button onclick="closeSolicitudModal()" class="text-gray-400 hover:text-gray-600 p-2 rounded-xl transition-colors hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form id="solicitudForm" class="p-6 space-y-4">
                @csrf
                <input type="hidden" id="solicitudUrId" name="ur_id">

                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-gray-700">Nombre del responsable / asesor <span class="text-red-500">*</span></label>
                    <input type="text" name="responsable" id="solicitudResponsable"
                        placeholder="Ej: Ing. María González"
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 py-3 px-4 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/30 focus:border-[#6BA53A] transition-all">
                    <p id="errResponsable" class="hidden text-xs text-red-500 font-medium"></p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold text-gray-700">Fecha de inicio <span class="text-red-500">*</span></label>
                        <input type="date" name="fecha_inicio" id="solicitudFechaInicio"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 py-3 px-4 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/30 focus:border-[#6BA53A] transition-all">
                        <p id="errFechaInicio" class="hidden text-xs text-red-500 font-medium"></p>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold text-gray-700">Fecha de fin <span class="text-red-500">*</span></label>
                        <input type="date" name="fecha_fin" id="solicitudFechaFin"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 py-3 px-4 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/30 focus:border-[#6BA53A] transition-all">
                        <p id="errFechaFin" class="hidden text-xs text-red-500 font-medium"></p>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-gray-700">Observaciones <span class="text-gray-400 font-normal">(opcional)</span></label>
                    <textarea name="observaciones" id="solicitudObservaciones" rows="3"
                        placeholder="Describe brevemente el área o proyecto donde realizarás tus prácticas..."
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 py-3 px-4 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/30 focus:border-[#6BA53A] transition-all resize-none"></textarea>
                </div>

                <div id="solicitudError" class="hidden rounded-xl bg-red-50 border border-red-100 p-3 text-sm text-red-700 font-medium"></div>
            </form>

            <div class="px-6 pb-6 flex gap-3">
                <button onclick="closeSolicitudModal()" type="button"
                    class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-4 rounded-xl text-sm transition-colors">
                    Cancelar
                </button>
                <button onclick="submitSolicitud()" type="button" id="solicitudSubmitBtn"
                    class="flex-1 bg-[#4E7D24] hover:bg-[#3b6620] text-white font-bold py-3 px-4 rounded-xl text-sm transition-colors shadow-sm flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    Enviar solicitud
                </button>
            </div>
        </div>
    </div>

    {{-- Toast éxito --}}
    <div id="convenioToast" class="hidden fixed top-5 right-5 z-[200]">
        <div id="convenioToastCard" class="bg-green-50 border border-green-200 text-green-900 px-4 py-3 rounded-2xl shadow-md max-w-sm flex items-start gap-3 transform transition-all duration-300 opacity-0 translate-y-2">
            <div class="p-2 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div class="flex-1">
                <h4 class="font-bold text-sm">¡Solicitud enviada!</h4>
                <p id="convenioToastMsg" class="text-xs text-green-900/80 mt-0.5"></p>
            </div>
        </div>
    </div>

    <script>
        function validateSearch() {
            var val = document.getElementById('search-input').value.trim();
            var err = document.getElementById('search-error');
            if (val.length === 1) {
                err.textContent = 'Ingresa al menos 2 caracteres para buscar.';
                err.classList.remove('hidden');
                return false;
            }
            err.classList.add('hidden');
            return true;
        }

        document.getElementById('search-input').addEventListener('input', function() {
            var err = document.getElementById('search-error');
            if (this.value.trim().length !== 1) {
                err.classList.add('hidden');
            }
        });

        function showConvenioModal(button) {
            const unidad = JSON.parse(button.getAttribute('data-unidad') || '{}');
            const convenios = JSON.parse(button.getAttribute('data-convenios') || '[]');

            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 overflow-auto';
            modal.onclick = function(e) {
                if (e.target === modal) modal.remove();
            };

            let conveniosHTML = '';
            if (convenios && convenios.length > 0) {
                conveniosHTML = convenios.map(c => {
                    const esVigente = c.estatus === 'activo' && new Date(c.fecha_termino) > new Date();
                    return `
                        <div class="border border-gray-150 rounded-3xl p-4 mb-3 bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="flex flex-col sm:flex-row justify-between items-start gap-3">
                                <div>
                                    <p class="font-semibold text-black">${c.codigo_convenio}</p>
                                    <p class="text-sm text-black/70 mt-1">
                                        <strong>Vigencia:</strong> ${new Date(c.fecha_inicio).toLocaleDateString('es-MX')} - ${new Date(c.fecha_termino).toLocaleDateString('es-MX')}
                                    </p>
                                </div>
                                <span class="inline-flex items-center gap-2 text-xs font-semibold ${esVigente ? 'text-green-700 bg-green-50 border border-green-100' : 'text-gray-600 bg-gray-100 border border-gray-200'} px-3 py-1 rounded-full shrink-0">
                                    <span class="w-2 h-2 rounded-full ${esVigente ? 'bg-green-500' : 'bg-gray-400'}"></span>
                                    ${esVigente ? 'Vigente' : 'Vencido'}
                                </span>
                            </div>
                        </div>
                    `;
                }).join('');
            } else {
                conveniosHTML = '<p class="text-black text-sm">Sin convenios registrados</p>';
            }

            modal.innerHTML = `
                <div class="relative w-full max-w-3xl bg-white rounded-[32px] shadow-2xl border border-white/60 overflow-hidden">
                    <div class="sticky top-0 z-10 bg-white border-b border-gray-100 px-6 py-5 flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm text-black/70">Empresa</p>
                            <h2 class="text-2xl font-bold text-black leading-tight">${unidad.nombre_empresa}</h2>
                        </div>
                        <button type="button" onclick="document.querySelector('.convenio-modal-root')?.remove()" class="text-gray-400 hover:text-gray-600 rounded-full p-2 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="rounded-3xl bg-[#F7FDF1] border border-green-100 p-4">
                                <p class="text-xs uppercase tracking-wide text-black font-semibold mb-2">Dirección</p>
                                <p class="text-sm text-black">${unidad.direccion || 'No especificada'}</p>
                            </div>
                            <div class="rounded-3xl bg-[#F5FAFF] border border-blue-100 p-4">
                                <p class="text-xs uppercase tracking-wide text-black font-semibold mb-2">Tipo</p>
                                <p class="text-sm text-black">${unidad.tipo_persona ? unidad.tipo_persona.charAt(0).toUpperCase() + unidad.tipo_persona.slice(1) : 'No especificado'}</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Convenios Disponibles</h3>
                            ${conveniosHTML}
                        </div>

                        <div class="pt-4 border-t border-gray-100 flex gap-3">
                            <button type="button" onclick="document.querySelector('.convenio-modal-root')?.remove()" class="flex-1 inline-flex items-center justify-center gap-2 rounded-2xl border border-gray-200 bg-white px-6 py-3 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">
                                Cerrar
                            </button>
                            <button type="button"
                                onclick="openSolicitudModal(${unidad.id}, '${unidad.nombre_empresa.replace(/'/g, "\\'")}'); document.querySelector('.convenio-modal-root')?.remove();"
                                class="flex-1 inline-flex items-center justify-center gap-2 rounded-2xl bg-[#4E7D24] px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-[#4E7D24]/10 hover:bg-[#3B6620] transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                Solicitar práctica
                            </button>
                        </div>
                    </div>
                </div>
            `;
            modal.classList.add('convenio-modal-root');
            document.body.appendChild(modal);
        }

        function openSolicitudModal(urId, nombre) {
            document.getElementById('solicitudUrId').value = urId;
            document.getElementById('solicitudEmpresaNombre').textContent = nombre;
            document.getElementById('solicitudResponsable').value = '';
            document.getElementById('solicitudFechaInicio').value = '';
            document.getElementById('solicitudFechaFin').value = '';
            document.getElementById('solicitudObservaciones').value = '';
            document.getElementById('solicitudError').classList.add('hidden');
            ['errResponsable','errFechaInicio','errFechaFin'].forEach(function(id) {
                document.getElementById(id).classList.add('hidden');
            });
            document.getElementById('solicitudModal').classList.remove('hidden');
        }

        function closeSolicitudModal() {
            document.getElementById('solicitudModal').classList.add('hidden');
        }

        function submitSolicitud() {
            var btn = document.getElementById('solicitudSubmitBtn');
            var errBox = document.getElementById('solicitudError');
            ['errResponsable','errFechaInicio','errFechaFin'].forEach(function(id) {
                document.getElementById(id).classList.add('hidden');
            });
            errBox.classList.add('hidden');

            var urId       = document.getElementById('solicitudUrId').value;
            var responsable= document.getElementById('solicitudResponsable').value.trim();
            var fechaInicio= document.getElementById('solicitudFechaInicio').value;
            var fechaFin   = document.getElementById('solicitudFechaFin').value;
            var observaciones = document.getElementById('solicitudObservaciones').value.trim();

            var hasError = false;
            if (!responsable) {
                document.getElementById('errResponsable').textContent = 'El nombre del responsable es obligatorio.';
                document.getElementById('errResponsable').classList.remove('hidden');
                hasError = true;
            }
            if (!fechaInicio) {
                document.getElementById('errFechaInicio').textContent = 'La fecha de inicio es obligatoria.';
                document.getElementById('errFechaInicio').classList.remove('hidden');
                hasError = true;
            }
            if (!fechaFin) {
                document.getElementById('errFechaFin').textContent = 'La fecha de fin es obligatoria.';
                document.getElementById('errFechaFin').classList.remove('hidden');
                hasError = true;
            } else if (fechaInicio && fechaFin <= fechaInicio) {
                document.getElementById('errFechaFin').textContent = 'La fecha de fin debe ser posterior a la fecha de inicio.';
                document.getElementById('errFechaFin').classList.remove('hidden');
                hasError = true;
            }
            if (hasError) return;

            btn.disabled = true;
            btn.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg> Enviando...';

            var token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            var formData = new FormData();
            formData.append('_token', token);
            formData.append('ur_id', urId);
            formData.append('responsable', responsable);
            formData.append('fecha_inicio', fechaInicio);
            formData.append('fecha_fin', fechaFin);
            if (observaciones) formData.append('observaciones', observaciones);

            fetch('{{ route("estudiante.storeSolicitud") }}', {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': token },
                body: formData,
            })
            .then(function(r) {
                return r.json().then(function(d) { if (!r.ok) throw d; return d; });
            })
            .then(function(data) {
                closeSolicitudModal();
                showConvenioToast(data.message || 'Solicitud enviada correctamente.');
            })
            .catch(function(err) {
                btn.disabled = false;
                btn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg> Enviar solicitud';
                if (err && err.errors) {
                    var msgs = Object.values(err.errors).flat().join(' ');
                    errBox.textContent = msgs;
                } else if (err && err.error) {
                    errBox.textContent = err.error;
                } else {
                    errBox.textContent = 'Ocurrió un error al enviar la solicitud. Intenta nuevamente.';
                }
                errBox.classList.remove('hidden');
            });
        }

        function showConvenioToast(msg) {
            var toast = document.getElementById('convenioToast');
            var card  = document.getElementById('convenioToastCard');
            document.getElementById('convenioToastMsg').textContent = msg;
            toast.classList.remove('hidden');
            void card.offsetWidth;
            card.classList.remove('opacity-0','translate-y-2');
            card.classList.add('opacity-100','translate-y-0');
            setTimeout(function() {
                card.classList.remove('opacity-100','translate-y-0');
                card.classList.add('opacity-0','translate-y-2');
                setTimeout(function() { toast.classList.add('hidden'); }, 300);
            }, 4500);
        }
    </script>
@endsection
