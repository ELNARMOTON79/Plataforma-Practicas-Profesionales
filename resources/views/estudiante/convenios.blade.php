@extends('layouts.estudiante', ['title' => 'Convenios Disponibles - Prácticas Profesionales UdeC', 'active' => 'convenios'])

@section('content')
    <x-page-header title="Empresas e instituciones" description="Consulta las empresas vinculadas y solicita tu participación en proyectos de prácticas profesionales."></x-page-header>

    {{-- Estilos de esta vista; no dependen de clases de Tailwind no compiladas --}}
    <style>
        .cv-alert { display: flex; align-items: center; gap: 14px; padding: 14px 18px; border-radius: 18px; background: linear-gradient(90deg, #fffbeb, #fff7ed); border: 1px solid #fde68a; }
        .cv-alert-icon { width: 38px; height: 38px; border-radius: 12px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .cv-alert-title { font-size: 13px; font-weight: 700; color: #92400e; margin: 0; }
        .cv-alert-text { font-size: 12.5px; color: #b45309; margin: 2px 0 0; }
        .cv-alert-link { margin-left: auto; flex-shrink: 0; font-size: 12px; font-weight: 700; color: #92400e; background: #fff; border: 1px solid #fde68a; padding: 7px 14px; border-radius: 10px; text-decoration: none; white-space: nowrap; transition: background .15s; }
        .cv-alert-link:hover { background: #fef3c7; }

        .cv-card { background: #fff; border: 1px solid #eef0f3; border-radius: 24px; padding: 18px 20px; box-shadow: 0 4px 20px rgba(17, 24, 39, .04); }
        .cv-head { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px; padding-bottom: 14px; margin-bottom: 14px; border-bottom: 1px solid #f1f2f4; }
        .cv-head-main { display: flex; align-items: center; gap: 14px; min-width: 0; }
        .cv-head-icon { width: 46px; height: 46px; border-radius: 14px; background: linear-gradient(135deg, #6BA53A, #4E7D24); color: #fff; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 6px 14px rgba(78, 125, 36, .25); }
        .cv-label { font-size: 10.5px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #9ca3af; margin: 0; }
        .cv-folio { font-size: 19px; font-weight: 800; color: #111827; margin: 1px 0 0; line-height: 1.2; }
        .cv-vigencia { display: inline-flex; align-items: center; gap: 6px; font-size: 12.5px; color: #6b7280; margin-top: 4px; }
        .cv-status { display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 700; padding: 5px 12px; border-radius: 999px; flex-shrink: 0; }
        .cv-status-dot { width: 7px; height: 7px; border-radius: 999px; }
        .cv-status.is-vigente { color: #15803d; background: #f0fdf4; border: 1px solid #bbf7d0; }
        .cv-status.is-vigente .cv-status-dot { background: #22c55e; box-shadow: 0 0 0 3px rgba(34, 197, 94, .18); }
        .cv-status.is-vencido { color: #6b7280; background: #f3f4f6; border: 1px solid #e5e7eb; }
        .cv-status.is-vencido .cv-status-dot { background: #9ca3af; }

        .cv-section { display: flex; align-items: center; gap: 8px; margin-bottom: 14px; }
        .cv-count { font-size: 11px; font-weight: 700; color: #4E7D24; background: #f0f7e9; border-radius: 999px; padding: 2px 9px; }
        .cv-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 12px; }
        @media (max-width: 420px) { .cv-grid { grid-template-columns: 1fr; } }

        .cv-empresa { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px 16px; padding: 14px 16px; border-radius: 18px; background: #fafbfa; border: 1px solid #edf0ea; transition: border-color .2s, box-shadow .2s, transform .2s; }
        .cv-empresa:hover { border-color: #cfe3bd; box-shadow: 0 8px 22px rgba(78, 125, 36, .08); transform: translateY(-2px); }
        .cv-empresa-top { display: flex; align-items: flex-start; gap: 12px; flex: 1 1 220px; min-width: 0; }
        .cv-avatar { width: 42px; height: 42px; border-radius: 12px; background: #fff; border: 1px solid #e5e7eb; color: #4E7D24; font-size: 14px; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .cv-tipo { display: inline-block; font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 6px; }
        .cv-tipo.is-moral { color: #1d4ed8; background: #eff6ff; border: 1px solid #dbeafe; }
        .cv-tipo.is-fisica { color: #c2410c; background: #fff7ed; border: 1px solid #fed7aa; }
        .cv-empresa-name { font-size: 15px; font-weight: 700; color: #111827; margin: 5px 0 0; line-height: 1.3; }
        .cv-dir { display: flex; align-items: flex-start; gap: 5px; font-size: 12.5px; color: #6b7280; margin: 4px 0 0; }
        .cv-btn { display: flex; align-items: center; justify-content: center; gap: 6px; flex: 0 0 auto; margin-left: auto; white-space: nowrap; font-size: 12.5px; font-weight: 700; color: #4E7D24; background: #fff; border: 1px solid #cfe3bd; padding: 9px 16px; border-radius: 12px; cursor: pointer; transition: background .2s, color .2s, border-color .2s; }
        .cv-btn:hover { background: #4E7D24; border-color: #4E7D24; color: #fff; }
        .cv-btn svg { transition: transform .2s; }
        .cv-btn:hover svg { transform: translateX(3px); }
        .cv-total { text-align: center; font-size: 13px; color: #9ca3af; }
    </style>

    @if($bloqueoSolicitud)
        <div class="cv-alert fade-in-up">
            <div class="cv-alert-icon">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div style="min-width: 0;">
                <p class="cv-alert-title">No puedes enviar una nueva solicitud</p>
                <p class="cv-alert-text">{{ $bloqueoSolicitud }}</p>
            </div>
            <a href="{{ route('estudiante.proyecto') }}" class="cv-alert-link">Ver Mi Proyecto</a>
        </div>
    @endif

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

    @if($conveniosAgrupados->isEmpty())
        <div class="glass-card rounded-3xl p-14 text-center fade-in-up delay-200">
            <svg class="w-14 h-14 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            <h3 class="text-lg font-bold text-gray-500">No se encontraron convenios</h3>
            <p class="text-sm text-gray-400 mt-1">
                @if($search && $carreraFilter)
                    Ningún convenio con empresas de "{{ $carreraFilter }}" coincide con "{{ $search }}".
                @elseif($search)
                    Ningún convenio coincide con "{{ $search }}".
                @elseif($carreraFilter)
                    Aún no hay convenios registrados con estudiantes de "{{ $carreraFilter }}".
                @else
                    Aún no hay convenios registrados.
                @endif
            </p>
            @if($search || $carreraFilter)
                <a href="{{ route('estudiante.convenios') }}" class="mt-4 inline-block text-sm font-semibold text-[#4E7D24] hover:underline">
                    Ver todos los convenios
                </a>
            @endif
        </div>
    @else
        <div class="space-y-6 fade-in-up delay-200">
            @foreach($conveniosAgrupados as $convenio)
                <div class="cv-card">
                    <div class="cv-head">
                        <div class="cv-head-main">
                            <div class="cv-head-icon">
                                <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div style="min-width: 0;">
                                <p class="cv-label">Convenio</p>
                                <h3 class="cv-folio">{{ $convenio->folio }}</h3>
                                <span class="cv-vigencia">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Vigencia: {{ $convenio->fecha_inicio->format('d/m/Y') }} — {{ $convenio->fecha_termino->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>
                        <span class="cv-status {{ $convenio->vigente ? 'is-vigente' : 'is-vencido' }}">
                            <span class="cv-status-dot"></span>
                            {{ $convenio->vigente ? 'Vigente' : 'Vencido' }}
                        </span>
                    </div>

                    <div class="cv-section">
                        <p class="cv-label">Empresas en este convenio</p>
                        <span class="cv-count">{{ $convenio->empresas->count() }}</span>
                    </div>

                    <div class="cv-grid">
                        @foreach($convenio->empresas as $unidad)
                            @php
                                $esMoral   = strtolower($unidad->tipo_persona ?? '') === 'moral';
                                $tipoLabel = $esMoral ? 'Persona Moral' : 'Persona Física';
                                $inicialesEmpresa = collect(preg_split('/\s+/', trim($unidad->nombre_empresa ?? '')))
                                    ->filter()->take(2)->map(fn ($p) => mb_strtoupper(mb_substr($p, 0, 1)))->implode('');
                            @endphp
                            <div class="cv-empresa">
                                <div class="cv-empresa-top">
                                    <div class="cv-avatar">{{ $inicialesEmpresa ?: '—' }}</div>
                                    <div style="min-width: 0;">
                                        <span class="cv-tipo {{ $esMoral ? 'is-moral' : 'is-fisica' }}">{{ $tipoLabel }}</span>
                                        <h4 class="cv-empresa-name">{{ $unidad->nombre_empresa }}</h4>
                                        @if($unidad->direccion)
                                            <p class="cv-dir">
                                                <svg width="14" height="14" style="margin-top: 2px; flex-shrink: 0; color: #9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                {{ $unidad->direccion }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <button
                                    type="button"
                                    data-empresa="{{ $unidad->nombre_empresa }}"
                                    data-unidades='{{ json_encode($unidad->unidades, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) }}'
                                    onclick="showUnidadesModal(this)"
                                    class="cv-btn"
                                >
                                    Ver unidades receptoras
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <p class="cv-total fade-in-up delay-300">
            {{ $conveniosAgrupados->count() }} convenio{{ $conveniosAgrupados->count() !== 1 ? 's' : '' }} encontrado{{ $conveniosAgrupados->count() !== 1 ? 's' : '' }}
        </p>
    @endif

    {{-- Modal Solicitar Práctica --}}
    <div id="solicitudModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeSolicitudModal()"></div>
        <div class="relative bg-white rounded-3xl shadow-2xl border border-gray-100 w-full overflow-hidden" style="max-width: 42rem; max-height: 100%; display: flex; flex-direction: column;">
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                <div>
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Solicitar práctica en</p>
                    <h3 class="text-lg font-bold text-gray-900 mt-0.5" id="solicitudEmpresaNombre"></h3>
                </div>
                <button onclick="closeSolicitudModal()" class="text-gray-400 hover:text-gray-600 p-2 rounded-xl transition-colors hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form id="solicitudForm" class="p-6 space-y-4" style="overflow-y: auto; flex: 1 1 auto; min-height: 0;">
                @csrf
                <input type="hidden" id="solicitudUrId" name="ur_id">

                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-gray-700">Nombre del responsable / asesor <span class="text-red-500">*</span></label>
                    <input type="text" name="responsable" id="solicitudResponsable" maxlength="50"
                        placeholder="Ej: Ing. María González"
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 py-3 px-4 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/30 focus:border-[#6BA53A] transition-all">
                    <p id="errResponsable" class="hidden text-xs text-red-500 font-medium"></p>
                </div>

                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-gray-700">Tipo de modalidad</label>
                    <div class="w-full rounded-xl border border-[#6BA53A] bg-[#6BA53A]/5 py-3 px-4 text-sm font-semibold text-gray-800">
                        {{ \App\Models\Solicitud::MODALIDADES[$modalidadEstudiante] }}
                    </div>
                    <p class="text-xs text-gray-400">Asignada automáticamente según tu carrera.</p>
                </div>

                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-gray-700">¿Ya trabajas en esta empresa? <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center gap-2.5 rounded-xl border border-gray-200 bg-gray-50 py-3 px-4 text-sm text-gray-800 cursor-pointer transition-all hover:border-[#6BA53A]/50 has-[:checked]:border-[#6BA53A] has-[:checked]:bg-[#6BA53A]/5 has-[:checked]:font-semibold">
                            <input type="radio" name="ya_labora" value="0" class="solicitud-ya-labora accent-[#4E7D24]" checked>
                            No, soy nuevo
                        </label>
                        <label class="flex items-center gap-2.5 rounded-xl border border-gray-200 bg-gray-50 py-3 px-4 text-sm text-gray-800 cursor-pointer transition-all hover:border-[#6BA53A]/50 has-[:checked]:border-[#6BA53A] has-[:checked]:bg-[#6BA53A]/5 has-[:checked]:font-semibold">
                            <input type="radio" name="ya_labora" value="1" class="solicitud-ya-labora accent-[#4E7D24]">
                            Sí, ya trabajo ahí
                        </label>
                    </div>
                </div>

                <div id="solicitudYaLaboraAviso" class="hidden rounded-xl border border-[#6BA53A]/20 bg-[#6BA53A]/5 px-4 py-3">
                    <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wide">Fechas y horario</p>
                    <p class="text-sm text-gray-700">La empresa definirá tus fechas de inicio y fin y tus horas por día. Después, en <strong>Mi Proyecto</strong>, deberás subir el documento del proyecto donde vienen anotadas.</p>
                </div>

                <div id="solicitudPeriodoBox" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold text-gray-700">Fecha de inicio <span class="text-red-500">*</span></label>
                        <input type="date" name="fecha_inicio" id="solicitudFechaInicio"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 py-3 px-4 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/30 focus:border-[#6BA53A] transition-all">
                        <p id="errFechaInicio" class="hidden text-xs text-red-500 font-medium"></p>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-sm font-semibold text-gray-700">Horas por día <span class="text-red-500">*</span></label>
                        <select name="horas_por_dia" id="solicitudHorasPorDia"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 py-3 px-4 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/30 focus:border-[#6BA53A] transition-all">
                            <option value="8">8 horas</option>
                            <option value="6">6 horas</option>
                        </select>
                        <p id="errHorasPorDia" class="hidden text-xs text-red-500 font-medium"></p>
                    </div>
                </div>

                <div id="solicitudFechaFinBox" class="rounded-xl border border-[#6BA53A]/20 bg-[#6BA53A]/5 px-4 py-3 flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-[#4E7D24] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <div>
                        <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wide">Fecha de finalización estimada</p>
                        <p id="solicitudFechaFinTexto" class="text-sm font-semibold text-gray-800">Selecciona la fecha de inicio para calcularla</p>
                    </div>
                </div>
                <p class="text-xs text-gray-400 -mt-2">
                    Se calcula automáticamente para completar {{ $horasMeta ?? 480 }} horas, contando solo días hábiles (sin fines de semana ni días festivos).
                </p>
                </div>

                <div class="space-y-1.5">
                    <label class="text-sm font-semibold text-gray-700">Observaciones <span class="text-gray-400 font-normal">(opcional)</span></label>
                    <textarea name="observaciones" id="solicitudObservaciones" rows="3" maxlength="200"
                        placeholder="Describe brevemente el área o proyecto donde realizarás tus prácticas..."
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 py-3 px-4 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#6BA53A]/30 focus:border-[#6BA53A] transition-all resize-none"></textarea>
                    <p id="errObservaciones" class="hidden text-xs text-red-500 font-medium"></p>
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
    <div id="convenioToast" class="hidden fixed inset-0 flex items-center justify-center p-4" style="z-index: 9999;">
        <div class="absolute inset-0" style="background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);" onclick="hideConvenioToast()"></div>
        <div id="convenioToastCard" class="relative bg-white rounded-3xl shadow-2xl border border-gray-100 w-full p-8 text-center" style="max-width: 26rem; opacity: 0; transform: scale(0.95); transition: opacity .25s ease, transform .25s ease;">
            <div class="mx-auto flex items-center justify-center rounded-full bg-green-100 text-green-600" style="width: 4rem; height: 4rem;">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h4 class="text-xl font-bold text-gray-900 mt-4">¡Solicitud enviada!</h4>
            <p id="convenioToastMsg" class="text-sm text-gray-600 mt-2"></p>
            <button type="button" onclick="hideConvenioToast()" class="mt-6 w-full bg-[#4E7D24] hover:bg-[#3b6620] text-white font-bold py-3 px-4 rounded-xl text-sm transition-colors shadow-sm">
                Entendido
            </button>
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

        function escapeHtml(value) {
            return String(value ?? '').replace(/[&<>"']/g, function(c) {
                return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
            });
        }

        function closeUnidadesModal() {
            document.querySelector('.unidades-modal-root')?.remove();
        }

        function solicitarDesdeUnidad(button) {
            openSolicitudModal(button.dataset.id, button.dataset.nombre);
            closeUnidadesModal();
        }

        function showUnidadesModal(button) {
            const empresa  = button.getAttribute('data-empresa') || '';
            const unidades = JSON.parse(button.getAttribute('data-unidades') || '[]');

            const items = unidades.length ? unidades.map(function(u) {
                const nombreUnidad = u.unidad_receptora || u.nombre_empresa;
                const ubicacion = [u.direccion, u.colonia, u.municipio, u.estado].filter(Boolean).join(', ');
                const titular = [u.titular, u.cargo].filter(Boolean).join(' · ');
                const etiquetaSolicitud = u.unidad_receptora ? (u.nombre_empresa + ' — ' + u.unidad_receptora) : u.nombre_empresa;
                return `
                    <div class="rounded-2xl border border-gray-200 bg-gray-50/60 p-4 flex flex-col gap-3">
                        <div>
                            <h4 class="font-bold text-gray-900">${escapeHtml(nombreUnidad)}</h4>
                            ${titular ? `<p class="text-sm text-gray-600 mt-1">${escapeHtml(titular)}</p>` : ''}
                            ${ubicacion ? `<p class="text-sm text-gray-500 mt-1">${escapeHtml(ubicacion)}</p>` : ''}
                            ${u.telefono ? `<p class="text-sm text-gray-500 mt-1">Tel. ${escapeHtml(u.telefono)}</p>` : ''}
                        </div>
                        ${SOLICITUD_BLOQUEO ? `
                        <button type="button" disabled
                            class="self-end text-xs font-bold text-gray-400 bg-gray-100 border border-gray-200 px-4 py-2 rounded-xl cursor-not-allowed">
                            Solicitar práctica
                        </button>` : `
                        <button type="button"
                            data-id="${escapeHtml(u.id)}"
                            data-nombre="${escapeHtml(etiquetaSolicitud)}"
                            onclick="solicitarDesdeUnidad(this)"
                            class="self-end text-xs font-bold text-white bg-[#4E7D24] px-4 py-2 rounded-xl hover:bg-[#3b6620] transition-all shadow-sm">
                            Solicitar práctica
                        </button>`}
                    </div>`;
            }).join('') : '<p class="text-sm text-gray-500 text-center py-6">Esta empresa no tiene unidades receptoras registradas.</p>';

            const modal = document.createElement('div');
            modal.className = 'unidades-modal-root fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 overflow-auto';
            modal.onclick = function(e) {
                if (e.target === modal) modal.remove();
            };

            modal.innerHTML = `
                <div class="relative w-full max-w-lg bg-white rounded-[32px] shadow-2xl border border-white/60 overflow-hidden">
                    <div class="bg-white border-b border-gray-100 px-6 py-5 flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm text-black/70">Unidades receptoras (${unidades.length})</p>
                            <h2 class="text-2xl font-bold text-black leading-tight">${escapeHtml(empresa)}</h2>
                        </div>
                        <button type="button" onclick="closeUnidadesModal()" class="text-gray-400 hover:text-gray-600 rounded-full p-2 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    <div class="p-6 space-y-3 max-h-[60vh] overflow-y-auto">
                        ${items}
                    </div>
                    <div class="px-6 pb-6">
                        <button type="button" onclick="closeUnidadesModal()" class="w-full rounded-2xl border border-gray-200 bg-white px-6 py-3 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-all">
                            Cerrar
                        </button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }

        var SOLICITUD_BLOQUEO = @json($bloqueoSolicitud);

        function openSolicitudModal(urId, nombre) {
            if (SOLICITUD_BLOQUEO) {
                return;
            }
            document.getElementById('solicitudUrId').value = urId;
            document.getElementById('solicitudEmpresaNombre').textContent = nombre;
            document.getElementById('solicitudResponsable').value = '';
            document.getElementById('solicitudFechaInicio').value = '';
            document.getElementById('solicitudHorasPorDia').value = '8';
            document.getElementById('solicitudObservaciones').value = '';
            document.getElementById('solicitudError').classList.add('hidden');
            document.getElementById('solicitudFechaFinTexto').textContent = 'Selecciona la fecha de inicio para calcularla';
            document.querySelector('.solicitud-ya-labora[value="0"]').checked = true;
            actualizarYaLabora();
            ['errResponsable','errFechaInicio','errHorasPorDia','errObservaciones'].forEach(function(id) {
                document.getElementById(id).classList.add('hidden');
            });
            document.getElementById('solicitudFechaInicio').min = fechaHoyLocal();
            var modal = document.getElementById('solicitudModal');
            // Mismo espacio arriba (debajo del navbar) y abajo
            var nav = document.querySelector('nav');
            var navBottom = nav ? Math.max(0, nav.getBoundingClientRect().bottom) : 0;
            var gap = 24;
            modal.style.paddingTop = (navBottom + gap) + 'px';
            modal.style.paddingBottom = gap + 'px';
            modal.classList.remove('hidden');
        }

        function solicitudYaLabora() {
            var marcado = document.querySelector('.solicitud-ya-labora:checked');
            return marcado ? marcado.value === '1' : false;
        }

        // Si ya trabaja en la empresa, las fechas y horas las define la empresa
        function actualizarYaLabora() {
            var yaLabora = solicitudYaLabora();
            document.getElementById('solicitudPeriodoBox').classList.toggle('hidden', yaLabora);
            document.getElementById('solicitudYaLaboraAviso').classList.toggle('hidden', !yaLabora);
        }

        document.querySelectorAll('.solicitud-ya-labora').forEach(function(r) {
            r.addEventListener('change', actualizarYaLabora);
        });

        function closeSolicitudModal() {
            document.getElementById('solicitudModal').classList.add('hidden');
        }

        var _fechaFinRequestId = 0;

        function actualizarFechaFinEstimada() {
            var fechaInicio = document.getElementById('solicitudFechaInicio').value;
            var horasPorDia = document.getElementById('solicitudHorasPorDia').value;
            var textoEl = document.getElementById('solicitudFechaFinTexto');

            if (!fechaInicio || !horasPorDia) {
                textoEl.textContent = 'Selecciona la fecha de inicio para calcularla';
                return;
            }

            textoEl.textContent = 'Calculando...';
            var requestId = ++_fechaFinRequestId;

            var url = '{{ route("estudiante.calcularFechaFinSolicitud") }}?fecha_inicio=' + encodeURIComponent(fechaInicio) + '&horas_por_dia=' + encodeURIComponent(horasPorDia);

            fetch(url, { headers: { 'Accept': 'application/json' } })
                .then(function(r) { return r.json().then(function(d) { if (!r.ok) throw d; return d; }); })
                .then(function(data) {
                    if (requestId !== _fechaFinRequestId) return;
                    textoEl.textContent = data.fecha_fin_formateada;
                })
                .catch(function() {
                    if (requestId !== _fechaFinRequestId) return;
                    textoEl.textContent = 'No se pudo calcular la fecha. Verifica la fecha de inicio.';
                });
        }

        document.getElementById('solicitudFechaInicio').addEventListener('change', actualizarFechaFinEstimada);
        document.getElementById('solicitudHorasPorDia').addEventListener('change', actualizarFechaFinEstimada);

        // Solo letras (con acentos), espacios y punto para títulos como "Ing."
        var SOLO_LETRAS_RESPONSABLE = /^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ\s.]+$/;
        // Solo letras, espacios y puntuación básica para redactar
        var SOLO_LETRAS_OBSERVACIONES = /^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ\s.,]+$/;

        function fechaHoyLocal() {
            var d = new Date();
            return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
        }

        // Elimina al escribir/pegar cualquier caracter no permitido
        document.getElementById('solicitudResponsable').addEventListener('input', function() {
            var limpio = this.value.replace(/[^A-Za-zÁÉÍÓÚÜÑáéíóúüñ\s.]/g, '');
            if (limpio !== this.value) this.value = limpio;
        });
        document.getElementById('solicitudObservaciones').addEventListener('input', function() {
            var limpio = this.value.replace(/[^A-Za-zÁÉÍÓÚÜÑáéíóúüñ\s.,]/g, '');
            if (limpio !== this.value) this.value = limpio;
        });

        function submitSolicitud() {
            var btn = document.getElementById('solicitudSubmitBtn');
            var errBox = document.getElementById('solicitudError');
            ['errResponsable','errFechaInicio','errHorasPorDia','errObservaciones'].forEach(function(id) {
                document.getElementById(id).classList.add('hidden');
            });
            errBox.classList.add('hidden');

            var urId       = document.getElementById('solicitudUrId').value;
            var responsable= document.getElementById('solicitudResponsable').value.trim();
            var fechaInicio= document.getElementById('solicitudFechaInicio').value;
            var horasPorDia= document.getElementById('solicitudHorasPorDia').value;
            var observaciones = document.getElementById('solicitudObservaciones').value.trim();

            var hasError = false;
            if (!responsable) {
                document.getElementById('errResponsable').textContent = 'El nombre del responsable es obligatorio.';
                document.getElementById('errResponsable').classList.remove('hidden');
                hasError = true;
            } else if (!SOLO_LETRAS_RESPONSABLE.test(responsable)) {
                document.getElementById('errResponsable').textContent = 'El nombre solo puede contener letras.';
                document.getElementById('errResponsable').classList.remove('hidden');
                hasError = true;
            } else if (responsable.length > 50) {
                document.getElementById('errResponsable').textContent = 'El nombre no puede superar 50 caracteres (llevas ' + responsable.length + ').';
                document.getElementById('errResponsable').classList.remove('hidden');
                hasError = true;
            }
            if (observaciones && !SOLO_LETRAS_OBSERVACIONES.test(observaciones)) {
                document.getElementById('errObservaciones').textContent = 'Las observaciones solo pueden contener letras.';
                document.getElementById('errObservaciones').classList.remove('hidden');
                hasError = true;
            } else if (observaciones.length > 200) {
                document.getElementById('errObservaciones').textContent = 'Las observaciones no pueden superar 200 caracteres (llevas ' + observaciones.length + ').';
                document.getElementById('errObservaciones').classList.remove('hidden');
                hasError = true;
            }
            var yaLabora = solicitudYaLabora();
            if (yaLabora) {
                // Las fechas las define la empresa
            } else if (!fechaInicio) {
                document.getElementById('errFechaInicio').textContent = 'La fecha de inicio es obligatoria.';
                document.getElementById('errFechaInicio').classList.remove('hidden');
                hasError = true;
            } else if (fechaInicio < fechaHoyLocal()) {
                document.getElementById('errFechaInicio').textContent = 'La fecha de inicio no puede ser anterior a hoy.';
                document.getElementById('errFechaInicio').classList.remove('hidden');
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
            formData.append('ya_labora', yaLabora ? '1' : '0');
            if (!yaLabora) {
                formData.append('fecha_inicio', fechaInicio);
                formData.append('horas_por_dia', horasPorDia);
            }
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
                SOLICITUD_BLOQUEO = 'Ya enviaste una solicitud de práctica y está pendiente de revisión. Podrás enviar otra solo si es rechazada.';
                var msg = data.message || 'Solicitud enviada correctamente.';
                if (data.fecha_fin) { msg += ' Fecha estimada de término: ' + data.fecha_fin + '.'; }
                showConvenioToast(msg);
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
            card.style.opacity = '1';
            card.style.transform = 'scale(1)';
        }

        function hideConvenioToast() {
            var toast = document.getElementById('convenioToast');
            var card  = document.getElementById('convenioToastCard');
            card.style.opacity = '0';
            card.style.transform = 'scale(0.95)';
            setTimeout(function() { toast.classList.add('hidden'); }, 250);
        }
    </script>
@endsection
