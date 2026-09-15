<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Bitácora - Administrador UdeC</title>
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
                size: letter landscape;
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
            <h2 class="text-lg font-extrabold text-gray-800 uppercase tracking-wider">Reporte de Auditoría</h2>
            <div class="inline-flex items-center gap-1.5 bg-udec-light text-udec-primary px-3 py-1 rounded-lg text-xs font-bold border border-udec-secondary/15 mt-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-udec-secondary"></span>
                Bitácora del Sistema
            </div>
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
            <p class="text-gray-600 font-semibold">Generado por: <strong class="text-gray-800 font-bold">{{ $userName }}</strong></p>
            <p class="text-gray-500 font-medium mt-0.5">Zona Horaria: {{ config('app.timezone') }}</p>
        </div>
    </section>

    <!-- KPI Summary Boxes -->
    <section class="grid grid-cols-5 gap-3 mb-6">
        <div class="p-3 border border-gray-100 bg-gray-50/50 rounded-xl">
            <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Registros</span>
            <span class="text-xl font-bold text-gray-900 leading-none">{{ $summary['total'] }}</span>
        </div>
        <div class="p-3 border border-green-100 bg-green-50/20 rounded-xl">
            <span class="block text-[10px] font-bold text-green-700 uppercase tracking-wider mb-0.5">Éxito</span>
            <span class="text-xl font-bold text-green-700 leading-none">{{ $summary['success'] }}</span>
        </div>
        <div class="p-3 border border-blue-100 bg-blue-50/20 rounded-xl">
            <span class="block text-[10px] font-bold text-blue-700 uppercase tracking-wider mb-0.5">Info</span>
            <span class="text-xl font-bold text-blue-700 leading-none">{{ $summary['info'] }}</span>
        </div>
        <div class="p-3 border border-yellow-100 bg-yellow-50/20 rounded-xl">
            <span class="block text-[10px] font-bold text-yellow-700 uppercase tracking-wider mb-0.5">Advertencias</span>
            <span class="text-xl font-bold text-yellow-700 leading-none">{{ $summary['warning'] }}</span>
        </div>
        <div class="p-3 border border-red-100 bg-red-50/20 rounded-xl">
            <span class="block text-[10px] font-bold text-red-700 uppercase tracking-wider mb-0.5">Errores</span>
            <span class="text-xl font-bold text-red-700 leading-none">{{ $summary['danger'] }}</span>
        </div>
    </section>

    <!-- Audit Event Table -->
    <main class="border border-gray-100 rounded-2xl overflow-hidden shadow-xs">
        <table class="min-w-full divide-y divide-gray-200 text-xs">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-4 py-3 text-left font-bold text-gray-500 uppercase tracking-wider w-36">Fecha / Hora</th>
                    <th scope="col" class="px-3 py-3 text-left font-bold text-gray-500 uppercase tracking-wider w-24">Severidad</th>
                    <th scope="col" class="px-4 py-3 text-left font-bold text-gray-500 uppercase tracking-wider w-48">Usuario</th>
                    <th scope="col" class="px-3 py-3 text-left font-bold text-gray-500 uppercase tracking-wider w-28">Módulo</th>
                    <th scope="col" class="px-4 py-3 text-left font-bold text-gray-500 uppercase tracking-wider w-44">Acción</th>
                    <th scope="col" class="px-4 py-3 text-left font-bold text-gray-500 uppercase tracking-wider">Descripción</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($logs as $log)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap text-gray-600 font-medium">
                            {{ $log->timestamp ? $log->timestamp->translatedFormat('d M Y, H:i:s') : 'N/A' }}
                        </td>
                        <td class="px-3 py-3 whitespace-nowrap">
                            @if($log->level == 'success')
                                <span class="px-2 py-0.5 inline-flex items-center text-[10px] leading-5 font-bold rounded bg-green-50 text-green-700 border border-green-100">
                                    {{ $log->level_name }}
                                </span>
                            @elseif($log->level == 'info')
                                <span class="px-2 py-0.5 inline-flex items-center text-[10px] leading-5 font-bold rounded bg-blue-50 text-blue-700 border border-blue-100">
                                    {{ $log->level_name }}
                                </span>
                            @elseif($log->level == 'warning')
                                <span class="px-2 py-0.5 inline-flex items-center text-[10px] leading-5 font-bold rounded bg-yellow-50 text-yellow-700 border border-yellow-100">
                                    {{ $log->level_name }}
                                </span>
                            @else
                                <span class="px-2 py-0.5 inline-flex items-center text-[10px] leading-5 font-bold rounded bg-red-50 text-red-700 border border-red-100">
                                    {{ $log->level_name }}
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-bold text-gray-900 leading-tight">{{ $log->user }}</div>
                            <div class="text-[10px] text-gray-400 font-medium">{{ $log->user_email }} ({{ $log->user_role }})</div>
                        </td>
                        <td class="px-3 py-3 font-semibold text-gray-700">
                            {{ $log->module }}
                        </td>
                        <td class="px-4 py-3 font-bold text-gray-800">
                            {{ $log->action }}
                        </td>
                        <td class="px-4 py-3 text-gray-500 font-medium break-words leading-relaxed max-w-xs">
                            {{ $log->description }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-400 font-medium">
                            No se encontraron registros de auditoría en la consulta actual.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </main>

    <!-- Report Footer -->
    <footer class="mt-8 pt-4 border-t border-gray-150 flex justify-between items-center text-[10px] text-gray-400 font-semibold uppercase tracking-wider">
        <div>Plataforma de Prácticas Profesionales &bull; UdeC Administrador</div>
        <div>Reporte Confidencial de Seguridad y Auditoría</div>
    </footer>

    <!-- Auto Print Script -->
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            // Trigger browser print dialog after loading has fully finished
            setTimeout(() => {
                window.print();
            }, 500);
        });

        // Auto close tab after print or cancel
        window.addEventListener('afterprint', () => {
            window.close();
        });
    </script>
</body>
</html>
