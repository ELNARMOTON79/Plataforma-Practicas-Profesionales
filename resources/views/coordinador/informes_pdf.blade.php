<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Coordinador - UdeC</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        outfit: ['Outfit', 'sans-serif'],
                        inter: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        udec: {
                            primary: '#4E7D24',
                            secondary: '#6BA53A',
                            dark: '#1C310D',
                            light: '#F4F9EE',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fff;
            color: #1f2937;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 0;
                margin: 0;
            }
            @page {
                size: letter portrait;
                margin: 12mm 15mm 12mm 15mm;
            }
            tr {
                page-break-inside: avoid;
            }
            thead {
                display: table-header-group;
            }
        }
    </style>
</head>
<body class="p-6 md:p-10 max-w-7xl mx-auto">

    <!-- Top Action Bar (Hidden when printing) -->
    <div class="no-print mb-8 flex justify-between items-center bg-gray-50 border border-gray-150 p-4 rounded-2xl">
        <div class="flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-[#6BA53A] animate-ping"></span>
            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Vista de Impresión</span>
        </div>
        <div class="flex gap-3">
            <button onclick="window.close()" class="px-4 py-2 border border-gray-300 hover:bg-gray-100 text-gray-700 font-bold rounded-xl transition-all text-xs flex items-center gap-1.5 cursor-pointer">
                Cerrar Ventana
            </button>
            <button onclick="window.print()" class="bg-[#4E7D24] hover:bg-[#2E5417] text-white px-5 py-2 rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition-all flex items-center gap-1.5 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Imprimir / Guardar como PDF
            </button>
        </div>
    </div>

    <!-- Header Section -->
    <header class="flex justify-between items-center border-b-2 border-udec-primary/20 pb-5 mb-6">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/logo_verde.png') }}" alt="Universidad de Colima" class="h-12 w-auto">
            <div class="border-l-2 border-udec-primary/20 pl-4 py-1">
                <p class="text-xs font-bold text-udec-primary uppercase tracking-wide">Plataforma de Prácticas Profesionales</p>
                <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider">Sistema de Control Escolar e Innovación Tecnológica</p>
            </div>
        </div>
        <div class="text-right">
            <h2 class="text-lg font-extrabold text-gray-800 uppercase tracking-wider">{{ $tipoReporte }}</h2>
            <p class="text-[10px] text-gray-400 font-medium mt-1">Exportado: {{ \Carbon\Carbon::now()->translatedFormat('d M Y, H:i:s') }}</p>
        </div>
    </header>

    <!-- Metadata & Filters Box -->
    <section class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 bg-gray-50 border border-gray-100 p-4 rounded-2xl text-xs">
        <div>
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Filtros Activos</h3>
            <p class="text-gray-800 font-bold bg-white px-3 py-2 rounded-xl border border-gray-200/60 inline-block">
                {{ $filterText }}
            </p>
        </div>
        <div class="text-right md:text-right">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Detalles de Generación</h3>
            <p class="text-gray-600 font-semibold">Generado por: <strong class="text-gray-800 font-bold">{{ $coordinadorName }}</strong></p>
            <p class="text-gray-500 font-medium mt-0.5">Zona Horaria: {{ config('app.timezone') }}</p>
        </div>
    </section>

    <!-- Data Table -->
    <main class="border border-gray-100 rounded-2xl overflow-hidden shadow-xs">
        <table class="min-w-full divide-y divide-gray-200 text-xs">
            <thead class="bg-gray-50">
                <tr>
                    @if($tipoReporte === 'Reporte de Instituciones')
                        <th scope="col" class="px-4 py-3 text-left font-bold text-gray-500 uppercase tracking-wider">Empresa / Institución</th>
                        <th scope="col" class="px-4 py-3 text-left font-bold text-gray-500 uppercase tracking-wider">Dirección</th>
                        <th scope="col" class="px-3 py-3 text-left font-bold text-gray-500 uppercase tracking-wider">Tipo</th>
                    @elseif($tipoReporte === 'Reporte de Proyectos')
                        <th scope="col" class="px-4 py-3 text-left font-bold text-gray-500 uppercase tracking-wider">Estudiante</th>
                        <th scope="col" class="px-3 py-3 text-left font-bold text-gray-500 uppercase tracking-wider">Institución</th>
                        <th scope="col" class="px-4 py-3 text-left font-bold text-gray-500 uppercase tracking-wider">Proyecto Propuesto</th>
                        <th scope="col" class="px-3 py-3 text-left font-bold text-gray-500 uppercase tracking-wider">Periodo</th>
                    @else
                        <th scope="col" class="px-4 py-3 text-left font-bold text-gray-500 uppercase tracking-wider">Nombre Completo</th>
                        <th scope="col" class="px-3 py-3 text-left font-bold text-gray-500 uppercase tracking-wider">Matrícula</th>
                        <th scope="col" class="px-4 py-3 text-left font-bold text-gray-500 uppercase tracking-wider">Carrera</th>
                        <th scope="col" class="px-3 py-3 text-left font-bold text-gray-500 uppercase tracking-wider">Semestre/Grupo</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($data as $item)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                    @if($tipoReporte === 'Reporte de Instituciones')
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="font-bold text-gray-900">{{ $item->nombre_empresa }}</div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-gray-600">
                            {{ $item->direccion }}
                        </td>
                        <td class="px-3 py-3 whitespace-nowrap text-gray-800">
                            {{ $item->tipo_persona }}
                        </td>
                    @elseif($tipoReporte === 'Reporte de Proyectos')
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="font-bold text-gray-900">{{ mb_strtoupper($item->estudiante->nombre_completo ?? 'Sin Nombre') }}</div>
                            <div class="text-[10px] text-gray-400">Cuenta: {{ $item->estudiante->matricula ?? '—' }}</div>
                        </td>
                        <td class="px-3 py-3 whitespace-nowrap text-gray-800">
                            {{ mb_strtoupper($item->unidadReceptora->nombre_empresa ?? 'No especificada') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="font-bold text-gray-900 truncate max-w-xs" title="{{ $item->titulo ?? 'Sin título' }}">{{ $item->titulo ?? 'Sin título' }}</div>
                            <div class="text-[10px] text-gray-400">Resp: {{ $item->responsable ?? '—' }}</div>
                        </td>
                        <td class="px-3 py-3 whitespace-nowrap text-gray-500 font-bold">
                            {{ $item->fecha_inicio ? $item->fecha_inicio->format('d/m/Y') : '—' }} - {{ $item->fecha_fin ? $item->fecha_fin->format('d/m/Y') : '—' }}
                        </td>
                    @else
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="font-bold text-gray-900">{{ $item->nombre_completo }}</div>
                            <div class="text-[10px] text-gray-400">{{ $item->user->correo ?? 'Sin correo' }}</div>
                        </td>
                        <td class="px-3 py-3 whitespace-nowrap font-bold text-gray-700">
                            {{ $item->matricula }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-gray-800">
                            {{ $item->carrera }}
                        </td>
                        <td class="px-3 py-3 whitespace-nowrap text-gray-500">
                            {{ $item->semestre }} "{{ $item->grupo }}"
                        </td>
                    @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-400 font-medium">
                            No se encontraron registros para los filtros seleccionados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </main>

    <!-- Report Footer -->
    <footer class="mt-8 pt-4 border-t border-gray-150 flex justify-between items-center text-[10px] text-gray-400 font-semibold uppercase tracking-wider">
        <div>Plataforma de Prácticas Profesionales &bull; UdeC Coordinador</div>
        <div>Reporte Académico Institucional</div>
    </footer>

    <!-- Auto Print Script -->
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.print();
            }, 500);
        });

        window.addEventListener('afterprint', () => {
            window.close();
        });
    </script>
</body>
</html>
