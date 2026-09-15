@extends('layouts.coordinador', ['active' => 'instituciones', 'title' => 'Instituciones - Coordinador'])

@section('content')
    {{-- ========== SUCCESS / ERROR ALERTS ========== --}}
    @if(session('success'))
        <div id="successAlert" class="mb-6 bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl shadow-sm flex items-center gap-3 transition-all duration-300 fade-in-up">
            <svg class="w-6 h-6 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-semibold text-sm">{{ session('success') }}</span>
            <button onclick="document.getElementById('successAlert').remove()" class="text-green-500 hover:text-green-800 transition-colors ml-auto">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div id="errorAlert" class="mb-6 bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-2xl shadow-sm flex flex-col gap-2 transition-all duration-300 fade-in-up">
            <div class="flex items-center gap-3 w-full">
                <svg class="w-6 h-6 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <span class="font-bold text-sm">Por favor corrige los siguientes errores:</span>
                <button onclick="document.getElementById('errorAlert').remove()" class="text-red-500 hover:text-red-800 transition-colors ml-auto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <ul class="list-disc pl-9 text-xs font-semibold space-y-1 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <!-- Header Section -->
    <x-page-header title="Listado de Instituciones" description="Gestiona las empresas e instituciones vinculadas a las prácticas profesionales">
        <x-slot:actions>
            <button
                onclick="openBulkUploadModal()"
                class="bg-white text-[#4E7D24] border border-[#4E7D24] hover:bg-[#6BA53A]/5 px-5 py-2.5 rounded-xl text-sm font-bold shadow-sm hover:shadow transition-all flex items-center gap-2 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                Importar Instituciones
            </button>
            <button
                onclick="document.getElementById('modal-registrar-institucion').classList.remove('hidden')"
                class="bg-[#4E7D24] text-white hover:bg-[#2E5417] px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Registrar Institución
            </button>
        </x-slot>
    </x-page-header>


    <!-- Main Instituciones Container (Glassmorphic) -->
    <div class="glass-card rounded-3xl p-6 md:p-8 fade-in-up delay-100">
        
        <!-- Filters & Search -->
        <form method="GET" action="{{ route('coordinador.instituciones') }}" class="flex flex-col md:flex-row gap-4 items-center justify-between mb-6 w-full">
            <!-- Left side: Show entries -->
            <div class="flex items-center gap-2 text-sm text-gray-600 font-medium w-full md:w-auto">
                <span>Mostrar</span>
                <select name="per_page" onchange="this.form.submit()" class="pl-3 pr-8 py-1.5 text-sm border border-gray-200 focus:outline-none focus:ring-[#6BA53A] focus:border-[#6BA53A] font-medium rounded-xl bg-white/50 text-gray-700">
                    <option value="5" {{ request('per_page', '5') == '5' ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page', '5') == '100' ? 'selected' : '' }}>100</option>
                </select>
                <span>registros</span>
            </div>

            <!-- Right side: Search and Filters -->
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
                <!-- Sector Select -->
                <select name="sector" onchange="this.form.submit()" class="block w-full sm:w-auto pl-3 pr-10 py-2 text-sm border border-gray-200 focus:outline-none focus:ring-[#6BA53A] focus:border-[#6BA53A] font-medium rounded-xl bg-white/50 text-gray-700">
                    <option value="">Todos los Sectores</option>
                    <option value="publico" {{ request('sector') == 'publico' ? 'selected' : '' }}>PÚBLICO</option>
                    <option value="privado" {{ request('sector') == 'privado' ? 'selected' : '' }}>PRIVADO</option>
                </select>

                <!-- Tipo Persona Select -->
                <select name="tipo_persona" onchange="this.form.submit()" class="block w-full sm:w-auto pl-3 pr-10 py-2 text-sm border border-gray-200 focus:outline-none focus:ring-[#6BA53A] focus:border-[#6BA53A] font-medium rounded-xl bg-white/50 text-gray-700">
                    <option value="">Todos los Tipos</option>
                    <option value="moral" {{ request('tipo_persona') == 'moral' ? 'selected' : '' }}>MORAL</option>
                    <option value="fisica" {{ request('tipo_persona') == 'fisica' ? 'selected' : '' }}>FÍSICA</option>
                </select>

                <!-- Convenio Select -->
                <select name="convenio" onchange="this.form.submit()" class="block w-full sm:w-auto pl-3 pr-10 py-2 text-sm border border-gray-200 focus:outline-none focus:ring-[#6BA53A] focus:border-[#6BA53A] font-medium rounded-xl bg-white/50 text-gray-700">
                    <option value="">Todos los Convenios</option>
                    <option value="con" {{ request('convenio') == 'con' ? 'selected' : '' }}>CON CONVENIO</option>
                    <option value="sin" {{ request('convenio') == 'sin' ? 'selected' : '' }}>SIN CONVENIO</option>
                </select>

                <!-- Search Input -->
                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-white/50 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-[#6BA53A] focus:ring-1 focus:ring-[#6BA53A] sm:text-sm transition-colors restrict-search" placeholder="Buscar..." pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s@.]+$" title="El buscador solo acepta letras, números, espacios, @ y puntos." onkeypress="return (event.ctrlKey || event.metaKey || event.altKey) || /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s@.]$/.test(event.key) || ['Backspace', 'Enter', 'Tab', 'Delete', 'ArrowLeft', 'ArrowRight'].includes(event.key)" oninput="this.value = this.value.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ\s@.]/g, '')">
                </div>
                <button type="submit" class="hidden">Buscar</button>
            </div>
        </form>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th scope="col" class="px-3 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl max-w-[200px] whitespace-normal">Nombre de la Institución</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Convenio</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Tipo Persona</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Sistema</th>
                        <th scope="col" class="px-3 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Sector</th>
                        <th scope="col" class="px-3 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl">Unidades Receptoras</th>
                    </tr>
                </thead>
                <tbody class="bg-transparent divide-y divide-gray-100">
                    @forelse($instituciones as $inst)
                        @php
                            // Smart heuristics for Sistema and Sector
                            $nombre = strtoupper($inst->nombre_empresa);
                            
                            $isPublic = preg_match('/(AYUNTAMIENTO|SECRETARIA|SECRETARÍA|IMSS|DIF|GOBIERNO|UNIVERSIDAD|FACULTAD)/i', $nombre);
                            
                            $sistema = 'PRIVADA';
                            if ($isPublic) {
                                if (str_contains($nombre, 'AYUNTAMIENTO')) {
                                    $sistema = 'MUNICIPAL';
                                } elseif (str_contains($nombre, 'IMSS') || str_contains($nombre, 'FEDERAL')) {
                                    $sistema = 'FEDERAL';
                                } else {
                                    $sistema = 'ESTATAL';
                                }
                            }
                            
                            $sector = $isPublic ? 'PÚBLICO' : 'PRIVADO';
                            
                            // Convenio: check convenios table (keyed by nombre_empresa), then field
                            $convenioList = $convenios[$inst->nombre_empresa] ?? null;
                            $codigoConvenio = 'SIN CONVENIO';

                            if ($convenioList && $convenioList->count() > 0) {
                                $conv = $convenioList->first();
                                $codigoConvenio = strtoupper($conv->codigo_convenio);
                            } elseif (!empty($inst->convenio)) {
                                $codigoConvenio = strtoupper($inst->convenio);
                            }

                            // List of unidad_receptora names for this empresa
                            $urList = $unidades[$inst->nombre_empresa] ?? collect();
                            
                            // ur_count comes from COUNT(nombre_empresa) GROUP BY nombre_empresa
                            $urText = $inst->ur_count . ' UR';
                        @endphp
                        <tr class="hover:bg-[#6BA53A]/5 transition-colors group">
                            <td class="px-3 py-4 whitespace-normal max-w-[200px]">
                                <div class="text-xs font-bold text-gray-900 group-hover:text-[#4E7D24] transition-colors leading-tight break-words uppercase">{{ $inst->nombre_empresa }}</div>
                                <div class="text-[10px] text-gray-400 normal-case">{{ $inst->direccion }}</div>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center">
                                @if($codigoConvenio == 'SIN CONVENIO')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg bg-red-50 text-red-700 border border-red-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5 mt-1.5"></span> Sin Convenio
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg bg-green-50 text-green-700 border border-green-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5 mt-1.5"></span> {{ $codigoConvenio }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-center">
                                @if(strcasecmp($inst->tipo_persona, 'moral') === 0 || str_contains(strtolower($inst->tipo_persona), 'moral'))
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg bg-blue-50 text-blue-700 border border-blue-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5 mt-1.5"></span> Moral
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-lg bg-purple-50 text-purple-700 border border-purple-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-purple-500 mr-1.5 mt-1.5"></span> Física
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-xs text-center text-gray-500 font-bold uppercase">
                                {{ $sistema }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-xs text-center text-gray-500 font-bold uppercase">
                                {{ $sector }}
                            </td>
                            <td class="px-3 py-4 text-center">
                                <button
                                    type="button"
                                    class="open-ur-modal inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#4E7D24]/10 text-[#4E7D24] border border-[#4E7D24]/20 rounded-xl text-xs font-bold hover:bg-[#4E7D24] hover:text-white transition-all"
                                    data-empresa="{{ $inst->nombre_empresa }}"
                                    data-unidades="{{ $urList->values()->toJson() }}">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    Ver {{ $inst->ur_count }} UR
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-sm text-gray-500 font-medium">
                                No se encontraron instituciones con los criterios de búsqueda seleccionados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $instituciones->appends(request()->query())->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-ocultar alerta de éxito a los 5 segundos
            const successAlert = document.getElementById('successAlert');
            if (successAlert) {
                setTimeout(function() {
                    successAlert.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                    setTimeout(function() {
                        successAlert.remove();
                    }, 500);
                }, 5000);
            }

            // Auto-ocultar alerta de error a los 5 segundos
            const errorAlert = document.getElementById('errorAlert');
            if (errorAlert) {
                setTimeout(function() {
                    errorAlert.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                    setTimeout(function() {
                        errorAlert.remove();
                    }, 500);
                }, 5000);
            }
        });
    </script>

    <script>
        // Modal: Unidades Receptoras
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.open-ur-modal').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const empresa = this.dataset.empresa;
                    const unidades = JSON.parse(this.dataset.unidades);
                    openUnidadesModal(empresa, unidades);
                });
            });
        });

        function openUnidadesModal(empresa, unidades) {
            document.getElementById('unidadesModalTitle').textContent = empresa;

            const fields = [
                { key: 'unidad_receptora',  label: 'Unidad Receptora' },
                { key: 'titular',           label: 'Titular' },
                { key: 'cargo',             label: 'Cargo' },
                { key: 'telefono',          label: 'Teléfono' },
                { key: 'direccion',         label: 'Dirección' },
                { key: 'colonia',           label: 'Colonia' },
                { key: 'cp',                label: 'C.P.' },
                { key: 'municipio',         label: 'Municipio' },
                { key: 'estado',            label: 'Estado' },
                { key: 'tipo_persona',      label: 'Tipo Persona' },
                { key: 'sistema',           label: 'Sistema' },
                { key: 'sector',            label: 'Sector' },
                { key: 'convenio',          label: 'Convenio' },
                { key: 'fecha_vencimiento', label: 'Fecha de Vencimiento' },
            ];

            const body = document.getElementById('unidadesModalBody');
            body.innerHTML = '';

            if (!unidades || unidades.length === 0) {
                body.innerHTML = '<p class="text-sm text-gray-500 text-center py-8">No hay unidades receptoras registradas.</p>';
            } else {
                unidades.forEach(function (ur, index) {
                    const card = document.createElement('div');
                    card.className = 'bg-gray-50 border border-gray-200 rounded-2xl p-5';

                    const header = document.createElement('div');
                    header.className = 'flex items-center gap-2 mb-4';
                    header.innerHTML = `
                        <span class="w-6 h-6 rounded-full bg-[#4E7D24]/10 text-[#4E7D24] text-xs font-bold flex items-center justify-center">${index + 1}</span>
                        <span class="text-sm font-bold text-gray-800">${ur.unidad_receptora || 'General'}</span>
                    `;
                    card.appendChild(header);

                    const grid = document.createElement('div');
                    grid.className = 'grid grid-cols-2 sm:grid-cols-3 gap-3';

                    fields.slice(1).forEach(function (field) {
                        let val = ur[field.key];
                        if (!val && val !== 0) return;

                        // Format date if key is fecha_vencimiento
                        if (field.key === 'fecha_vencimiento' && typeof val === 'string') {
                            const parts = val.split('-');
                            if (parts.length === 3) {
                                val = `${parts[2]}/${parts[1]}/${parts[0]}`;
                            }
                        }

                        const item = document.createElement('div');
                        item.innerHTML = `
                            <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">${field.label}</span>
                            <span class="block text-xs font-semibold text-gray-700 mt-0.5">${val}</span>
                        `;
                        grid.appendChild(item);
                    });

                    card.appendChild(grid);
                    body.appendChild(card);
                });
            }

            document.getElementById('unidadesModal').classList.remove('hidden');
            // Push the sticky navbar behind the modal overlay
            const navbar = document.querySelector('nav');
            if (navbar) navbar.style.zIndex = '0';
        }

        function closeUnidadesModal() {
            document.getElementById('unidadesModal').classList.add('hidden');
            // Restore the navbar z-index
            const navbar = document.querySelector('nav');
            if (navbar) navbar.style.zIndex = '';
        }
    </script>
@endsection

@push('modals')
    @include('coordinador.instituciones.bulk-upload-modal')
    @include('coordinador.instituciones.register-modal')

    {{-- Modal: Unidades Receptoras --}}
    <div id="unidadesModal" class="fixed inset-0 z-[100] hidden overflow-hidden" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-gray-950/60 backdrop-blur-md" onclick="closeUnidadesModal()"></div>
            <div class="relative w-full max-w-4xl bg-white rounded-3xl shadow-2xl overflow-hidden z-10 max-h-[90vh] flex flex-col">

                {{-- Header (Gradient Green Banner) --}}
                <div class="bg-gradient-to-r from-[#4E7D24] to-[#6BA53A] px-8 py-6 flex items-center justify-between flex-shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="bg-white/20 p-2 rounded-xl text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <div class="text-left">
                            <h3 id="unidadesModalTitle" class="text-lg font-bold text-white leading-tight">Unidades Receptoras</h3>
                            <p class="text-green-100 text-xs">Detalle completo de todas las unidades registradas</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeUnidadesModal()" class="text-white/70 hover:text-white transition-colors p-1.5 rounded-lg hover:bg-white/10">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Body --}}
                <div class="px-6 py-6 md:px-8 overflow-y-auto flex-grow custom-scrollbar">
                    <div id="unidadesModalBody" class="space-y-4">
                        {{-- Filled by JS --}}
                    </div>
                </div>

                {{-- Footer --}}
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex justify-end flex-shrink-0">
                    <button type="button" onclick="closeUnidadesModal()" class="px-5 py-2 bg-[#4E7D24] text-white text-sm font-bold rounded-xl hover:bg-[#2E5417] transition-colors">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endpush
