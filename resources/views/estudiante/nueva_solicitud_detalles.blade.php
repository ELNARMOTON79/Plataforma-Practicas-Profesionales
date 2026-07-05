@extends('layouts.estudiante', ['active' => 'nueva-solicitud'])

@section('header')
<header class="bg-white border-b border-gray-200 px-6 py-5 flex items-center justify-between shrink-0">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Bienvenido, {{ $nombre }}</h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ $carrera }} — Matrícula: {{ $matricula }}</p>
    </div>
    <div class="flex items-center gap-4">
        <a href="{{ route('estudiante.miPerfil') }}" class="flex items-center gap-2.5 pl-2 border-l border-gray-200 text-gray-900 hover:text-gray-700 transition-colors">
            <div class="w-9 h-9 rounded-full bg-[#4E7D24] flex items-center justify-center text-white text-sm font-bold shrink-0">
                {{ $iniciales }}
            </div>
            <span class="text-sm font-semibold text-gray-800 hidden sm:block">{{ $nombre }}</span>
        </a>
    </div>
</header>
@endsection

@section('content')
<div class="w-full space-y-6">
    <!-- Header / Titles -->
    <div class="text-left px-2">
        <h1 class="text-3xl font-extrabold text-gray-900">Nueva Solicitud de Practicas</h1>
        <p class="text-sm text-gray-500 mt-1">Completa el formulario para registrar tu solicitud</p>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-[32px] shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-8 sm:px-16 md:px-20 py-12">
            <div class="max-w-7xl mx-auto">
                <!-- Circular Step Progress Indicator -->
                <div class="relative flex items-center justify-between w-full max-w-md mx-auto mt-4 mb-16">
                    <!-- Line segment background -->
                    <div class="absolute left-[25%] right-[25%] top-7 h-[2px] bg-gray-200 z-0"></div>
                    
                    <!-- Line segment active -->
                    <div class="absolute left-[25%] top-7 h-[2px] bg-[#8cc772] z-0 transition-all duration-300" style="width: 50%;"></div>

                    <!-- Step 1 (Completed) -->
                    <div class="relative z-10 flex flex-col items-center w-1/2">
                        <div class="flex items-center justify-center w-14 h-14 rounded-full border-2 border-[#8cc772] bg-white text-[#4E7D24] shadow-sm transition-all duration-200">
                            <!-- Ícono de Checkmark -->
                            <svg class="w-6 h-6 text-[#6BA53A]" fill="none" stroke="currentColor" stroke-width="3.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="mt-4 text-xs sm:text-sm font-bold text-[#6BA53A] text-center max-w-[150px] leading-tight">Informacion de la Empresa</span>
                    </div>

                    <!-- Step 2 (Active) -->
                    <div class="relative z-10 flex flex-col items-center w-1/2">
                        <div class="flex items-center justify-center w-14 h-14 rounded-full border-2 border-[#8cc772] bg-white text-[#4E7D24] shadow-sm transition-all duration-200">
                            <!-- Ícono de Detalles (Documento) -->
                            <svg class="w-6 h-6 text-[#6BA53A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span class="mt-4 text-xs sm:text-sm font-bold text-[#6BA53A] text-center max-w-[150px] leading-tight">Detalles de la Practica</span>
                    </div>
                </div>

                <form action="{{ route('estudiante.storeSolicitud') }}" method="POST" class="mt-10 space-y-6">
                    @csrf
                    @foreach(request()->only(['ur_id', 'empresa_nombre', 'empresa_direccion', 'supervisor_nombre', 'supervisor_telefono', 'supervisor_email']) as $k => $v)
                        @if($v)
                            <input type="hidden" name="{{ $k }}" value="{{ $v }}" />
                        @endif
                    @endforeach

                    <div class="grid gap-5">
                        <!-- Banner Resumen de Cálculo Automático -->
                        <div id="resumen-calculo-dias" class="hidden p-4 rounded-2xl bg-gradient-to-r from-[#4E7D24]/10 via-[#6BA53A]/10 to-transparent border border-[#4E7D24]/20 flex items-center justify-between gap-4 shadow-sm fade-in-up">
                            <div class="flex items-center gap-3.5">
                                <div class="w-11 h-11 rounded-xl bg-[#4E7D24] text-white flex items-center justify-center font-bold shadow-sm shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <span class="inline-block bg-[#4E7D24] text-white text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-md mb-1">⚡ Cálculo Automático (Colima, MX)</span>
                                    <p class="text-xs font-bold text-gray-800">
                                        Fin estimado: <span id="resumen-fecha-fin-texto" class="text-[#4E7D24] font-extrabold text-sm"></span> 
                                        (<span id="resumen-dias-habiles">0 días hábiles</span> a <span id="resumen-horas-diarias">6 hrs/día</span>)
                                    </p>
                                    <p class="text-[11px] text-gray-600 mt-0.5">Excluye fines de semana y feriados oficiales (LFT / Estatales Colima / UdeC).</p>
                                </div>
                            </div>
                        </div>

                        <!-- Fecha de Inicio & Fecha de Finalización -->
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Fecha de Inicio <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio" min="{{ date('Y-m-d') }}" onclick="this.showPicker && this.showPicker()" onchange="calcularFechaFin()" class="w-full rounded-xl border border-gray-200 bg-white py-3 px-4 text-sm text-gray-700 shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all cursor-pointer" required />
                            </div>
                            <div class="space-y-2">
                                <label class="flex items-center justify-between text-sm font-semibold text-gray-700">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Fecha de Finalización <span class="text-red-500">*</span>
                                    </span>
                                </label>
                                <input type="date" name="fecha_fin" id="fecha_fin" class="w-full rounded-xl border bg-gray-100/80 border-gray-300 text-gray-600 font-semibold cursor-not-allowed select-none py-3 px-4 text-sm shadow-sm transition-all" readonly required />
                            </div>
                        </div>

                        <!-- Horas Previstas (Fijo UdeC: 480 hrs) -->
                        <div class="space-y-2">
                            <label class="flex items-center justify-between text-sm font-semibold text-gray-700">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Horas Previstas <span class="text-red-500">*</span>
                                </span>
                            </label>
                            <input type="text" value="480 horas (80 días hábiles a 6 hrs/día)" class="w-full rounded-xl border bg-gray-100/80 border-gray-300 text-gray-600 font-semibold cursor-not-allowed select-none py-3 px-4 text-sm shadow-sm transition-all" readonly />
                            <input type="hidden" name="horas_previstas" id="horas_previstas" value="480" />
                        </div>

                        <!-- Título -->
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h10M7 12h6"/>
                                </svg>
                                Título <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="titulo" id="titulo" placeholder="Título de la práctica profesional" class="w-full rounded-xl border border-gray-200 bg-white py-3 px-4 text-sm text-gray-700 shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all" required />
                        </div>

                        <!-- Objetivo -->
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Objetivo <span class="text-red-500">*</span>
                            </label>
                            <textarea name="objetivo" id="objetivo" rows="3" placeholder="¿Qué se pretende lograr con esta práctica profesional?" class="w-full rounded-xl border border-gray-200 bg-white py-3 px-4 text-sm text-gray-700 shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all" required></textarea>
                        </div>

                        <!-- Justificación -->
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Justificación <span class="text-red-500">*</span>
                            </label>
                            <textarea name="justificacion" id="justificacion" rows="3" placeholder="¿Por qué es importante realizar esta práctica?" class="w-full rounded-xl border border-gray-200 bg-white py-3 px-4 text-sm text-gray-700 shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all" required></textarea>
                        </div>

                        <!-- Actividades -->
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10"/>
                                </svg>
                                Actividades <span class="text-red-500">*</span>
                            </label>
                            <textarea name="actividades" id="actividades" rows="4" placeholder="Describe las actividades que realizarás durante las prácticas..." class="w-full rounded-xl border border-gray-200 bg-white py-3 px-4 text-sm text-gray-700 shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all" required></textarea>
                        </div>

                        <!-- Impacto Social -->
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Impacto Social <span class="text-red-500">*</span>
                            </label>
                            <textarea name="impacto_social" id="impacto_social" rows="3" placeholder="¿Qué beneficio aportará esta práctica a la sociedad o comunidad?" class="w-full rounded-xl border border-gray-200 bg-white py-3 px-4 text-sm text-gray-700 shadow-sm focus:border-[#8cc772] focus:outline-none focus:ring-2 focus:ring-[#8cc772]/20 transition-all" required></textarea>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between items-center pt-4">
                        <a href="{{ route('estudiante.nuevaSolicitud') }}" class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-6 py-2.5 text-sm font-semibold text-gray-600 shadow-sm transition hover:bg-gray-50">
                            <span class="mr-2 font-bold">&lt;</span> Anterior
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#4E7D24] hover:bg-[#3b6620] px-8 py-3 text-sm font-bold text-white shadow-md transition-all duration-250 cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Solicitar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function calcularFechaFin() {
        const elInicio = document.getElementById('fecha_inicio');
        const elFin = document.getElementById('fecha_fin');
        const elHoras = document.getElementById('horas_previstas');
        const elResumen = document.getElementById('resumen-calculo-dias');

        if (!elInicio || !elFin || !elHoras) return;

        const valInicio = elInicio.value;
        const valHoras = parseInt(elHoras.value, 10);

        if (!valInicio || isNaN(valHoras) || valHoras <= 0) {
            if (elResumen) elResumen.classList.add('hidden');
            elFin.value = '';
            return;
        }

        const parts = valInicio.split('-');
        if (parts.length !== 3) return;
        const fecha = new Date(parseInt(parts[0], 10), parseInt(parts[1], 10) - 1, parseInt(parts[2], 10));

        if (isNaN(fecha.getTime())) {
            if (elResumen) elResumen.classList.add('hidden');
            return;
        }

        // Validar que no sea una fecha pasada (anterior a hoy en hora local)
        const hoy = new Date();
        hoy.setHours(0, 0, 0, 0);
        if (fecha < hoy) {
            alert('Por favor selecciona una fecha de inicio a partir del día de hoy. No es posible iniciar prácticas en fechas pasadas.');
            elInicio.value = '';
            elFin.value = '';
            if (elResumen) elResumen.classList.add('hidden');
            return;
        }

        // Días hábiles necesarios (6 horas diarias, lunes a viernes)
        const diasNecesarios = Math.ceil(valHoras / 6);
        let diasContados = 0;
        let diaActual = new Date(fecha.getTime());

        // Feriados fijos oficiales en México y Colima (LFT / UdeC) en formato MM-DD
        const feriadosFijos = [
            '01-01', // Año Nuevo
            '05-01', // Día del Trabajo
            '05-05', // Batalla de Puebla
            '05-10', // Día de las Madres (tradición en Colima / escolar)
            '05-15', // Día del Maestro
            '09-16', // Día de la Independencia
            '10-12', // Día de la Raza / Hispanidad
            '11-01', // Todos los Santos
            '11-02', // Día de Muertos
            '12-12', // Virgen de Guadalupe / Día Empleado Universitario
            '12-24', // Nochebuena
            '12-25', // Navidad
            '12-31'  // Fin de Año
        ];

        // Feriados móviles (Lunes festivos LFT y Semana Santa para 2025, 2026 y 2027) en formato YYYY-MM-DD
        const feriadosMoviles = [
            // 2025
            '2025-02-03', '2025-03-17', '2025-04-17', '2025-04-18', '2025-11-17',
            // 2026
            '2026-02-02', '2026-03-16', '2026-04-02', '2026-04-03', '2026-11-16',
            // 2027
            '2027-02-01', '2027-03-15', '2027-03-25', '2027-03-26', '2027-11-15'
        ];

        function esInhabil(d) {
            const diaSemana = d.getDay();
            if (diaSemana === 0 || diaSemana === 6) return true; // 0=Domingo, 6=Sábado

            const yyyy = d.getFullYear();
            const mm = String(d.getMonth() + 1).padStart(2, '0');
            const dd = String(d.getDate()).padStart(2, '0');
            const mdStr = `${mm}-${dd}`;
            const ymdStr = `${yyyy}-${mm}-${dd}`;

            return feriadosFijos.includes(mdStr) || feriadosMoviles.includes(ymdStr);
        }

        // Conteo de días hábiles desde la fecha de inicio
        while (diasContados < diasNecesarios) {
            if (!esInhabil(diaActual)) {
                diasContados++;
            }
            if (diasContados < diasNecesarios) {
                diaActual.setDate(diaActual.getDate() + 1);
            }
        }

        const yRes = diaActual.getFullYear();
        const mRes = String(diaActual.getMonth() + 1).padStart(2, '0');
        const dRes = String(diaActual.getDate()).padStart(2, '0');

        elFin.value = `${yRes}-${mRes}-${dRes}`;

        if (elResumen) {
            document.getElementById('resumen-dias-habiles').textContent = `${diasNecesarios} días hábiles`;
            document.getElementById('resumen-horas-diarias').textContent = `6 hrs/día`;
            document.getElementById('resumen-fecha-fin-texto').textContent = `${dRes}/${mRes}/${yRes}`;
            elResumen.classList.remove('hidden');
        }
    }

    // Calcular si la fecha y horas tienen valores al cargar y fijar min actual en cliente
    document.addEventListener('DOMContentLoaded', () => {
        const elInicio = document.getElementById('fecha_inicio');
        if (elInicio) {
            const hoyIso = new Date().toISOString().split('T')[0];
            elInicio.setAttribute('min', hoyIso);
        }
        calcularFechaFin();
    });
</script>
@endsection
