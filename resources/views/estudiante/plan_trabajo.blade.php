<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan de Trabajo - {{ $solicitud->estudiante->nombre_completo ?? '' }}</title>
    
    <!-- Fonts from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (for layout and utility classes) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }

        /* Styles for printing */
        @media print {
            @page {
                size: letter;
                margin: 0; /* Hides default browser headers/footers */
            }
            body {
                background-color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                margin: 0 !important;
                padding: 1.5cm 1.5cm 1.5cm 1.5cm !important; /* Margins for Plan de Trabajo */
            }
            .no-print {
                display: none !important;
            }
            .print-container {
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
                border: none !important;
                max-width: 100% !important;
                width: 100% !important;
                min-height: 0 !important;
                height: auto !important;
            }
        }

        .udec-shield {
            width: 76px;
            height: 76px;
            object-fit: cover;
            object-position: left;
        }

        .section-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin-bottom: 8px;
        }
        
        .section-table th, .section-table td {
            border: none;
            padding: 2px 4px;
        }

        .section-header {
            background-color: #e5e7eb;
            color: #374151;
            text-align: center;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            padding: 4px;
            margin-bottom: 4px;
            margin-top: 6px;
        }

        .label-col {
            width: 15%;
            color: #4b5563;
            text-align: right;
            padding-right: 8px;
        }

        .val-col {
            font-weight: 600;
            color: #111827;
        }
    </style>
</head>
<body class="p-4 md:p-8 flex flex-col items-center">

    <!-- Floating Actions Panel (No Print) -->
    <div class="no-print bg-white/80 backdrop-blur-md border border-gray-200/80 shadow-xl rounded-2xl p-4 mb-8 max-w-3xl w-full flex items-center justify-between gap-4 sticky top-4 z-50">
        <div class="flex items-center gap-3">
            <div class="p-2.5 bg-[#4E7D24]/10 text-[#4E7D24] rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-bold text-gray-900">Plan de Trabajo</h2>
                <p class="text-xs text-gray-500 font-medium mt-0.5">Generado automáticamente</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.close()" class="px-4 py-2 border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-bold rounded-xl transition-all">
                Cerrar
            </button>
            <button onclick="window.print()" class="px-5 py-2.5 bg-[#4E7D24] hover:bg-[#3b6620] text-white text-xs font-bold rounded-xl shadow-md hover:shadow-lg transition-all flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Imprimir / PDF
            </button>
        </div>
    </div>

    <!-- Letter Container -->
    <div class="print-container bg-white border border-gray-200 shadow-2xl p-10 max-w-[21.59cm] w-full min-h-[27.94cm] relative flex flex-col font-sans">
        
        <!-- Centered Official Header -->
        <div class="flex flex-col items-center text-center mb-4">
            <img src="{{ asset('images/logo_verde.png') }}" class="udec-shield mb-2" alt="Logo Universidad de Colima">
            <h1 class="text-lg font-serif font-semibold tracking-wider text-gray-900 uppercase">UNIVERSIDAD DE COLIMA</h1>
            <h2 class="text-sm font-sans font-bold text-gray-900 mt-2 uppercase">PLAN DE TRABAJO PRACTICA PROFESIONAL</h2>
        </div>

        <!-- DATOS DEL ESTUDIANTE -->
        <div class="section-header">DATOS DEL ESTUDIANTE</div>
        <table class="section-table">
            <tr>
                <td class="label-col">Número de cuenta</td>
                <td class="val-col" style="width: 20%;">{{ $solicitud->estudiante->matricula }}</td>
                <td class="label-col" style="width: 10%;">Nombre</td>
                <td class="val-col" colspan="3">{{ mb_strtoupper($solicitud->estudiante->nombre_completo) }}</td>
            </tr>
            <tr>
                <td class="label-col">Plantel</td>
                <td class="val-col" colspan="2">FACULTAD DE INGENIERIA ELECTROMECANICA</td>
                <td class="label-col" style="width: 10%;">Ciclo Escolar</td>
                <td class="val-col">AGO-2026/ENE-2027</td>
            </tr>
            <tr>
                <td class="label-col">Carrera</td>
                <td class="val-col" colspan="2">{{ mb_strtoupper($solicitud->estudiante->carrera) }}</td>
                <td class="label-col">Sem/Gpo</td>
                <td class="val-col">{{ $solicitud->estudiante->semestre }}° {{ mb_strtoupper($solicitud->estudiante->grupo) }}</td>
            </tr>
        </table>

        <!-- DATOS DEL COORDINADOR -->
        <div class="section-header">DATOS DEL COORDINADOR DE PRACTICA PROFESIONAL</div>
        <table class="section-table">
            <tr>
                <td class="label-col">Nombre</td>
                <td class="val-col" style="width: 50%;">{{ mb_strtoupper($coordinadorName) }}</td>
                <td class="label-col">Correo</td>
                <td class="val-col">{{ $coordinadorEmail }}</td>
            </tr>
        </table>

        <!-- DATOS DE LA UNIDAD RECEPTORA -->
        <div class="section-header">DATOS DE LA UNIDAD RECEPTORA</div>
        <table class="section-table">
            <tr>
                <td class="label-col">Nombre</td>
                <td class="val-col" colspan="3">{{ mb_strtoupper($solicitud->unidadReceptora->nombre_empresa ?? '') }}</td>
                <td class="label-col">Sector</td>
                <td class="val-col">PÚBLICO / PRIVADO</td>
            </tr>
            <tr>
                <td class="label-col">Titular</td>
                <td class="val-col" colspan="5">{{ mb_strtoupper($solicitud->unidadReceptora->titular ?? '') }}</td>
            </tr>
            <tr>
                <td class="label-col">Cargo</td>
                <td class="val-col" colspan="5">{{ mb_strtoupper($solicitud->unidadReceptora->cargo ?? '') }}</td>
            </tr>
            <tr>
                <td class="label-col">Nombre del Responsable</td>
                <td class="val-col" colspan="3">{{ mb_strtoupper($solicitud->responsable ?? '') }}</td>
                <td class="label-col">Sistema</td>
                <td class="val-col">ESTATAL / FEDERAL</td>
            </tr>
            <tr>
                <td class="label-col">Departamento</td>
                <td class="val-col" colspan="5">{{ mb_strtoupper($solicitud->unidadReceptora->unidad_receptora ?? '') }}</td>
            </tr>
            <tr>
                <td class="label-col">Domicilio</td>
                <td class="val-col" colspan="5">{{ mb_strtoupper($solicitud->unidadReceptora->direccion ?? '') }}</td>
            </tr>
            <tr>
                <td class="label-col">Colonia</td>
                <td class="val-col" colspan="2">{{ mb_strtoupper($solicitud->unidadReceptora->colonia ?? '') }}</td>
                <td class="label-col">Municipio</td>
                <td class="val-col" colspan="2">{{ mb_strtoupper($solicitud->unidadReceptora->municipio ?? 'MANZANILLO') }}</td>
            </tr>
            <tr>
                <td class="label-col">CP</td>
                <td class="val-col">{{ $solicitud->unidadReceptora->cp ?? '' }}</td>
                <td class="label-col" colspan="2">Correo electrónico</td>
                <td class="val-col" colspan="2">{{ mb_strtolower($solicitud->unidadReceptora->correo ?? '') }}</td>
            </tr>
        </table>

        <!-- DATOS DEL PROYECTO -->
        <div class="section-header">DATOS DEL PROYECTO</div>
        <table class="section-table">
            <tr>
                <td class="label-col">Nombre</td>
                <td class="val-col" colspan="5">{{ mb_strtoupper($solicitud->titulo ?? '') }}</td>
            </tr>
            <tr>
                <td class="label-col">Periodo solicitado</td>
                <td class="val-col" colspan="3">{{ $solicitud->fecha_inicio ? \Carbon\Carbon::parse($solicitud->fecha_inicio)->translatedFormat('d \d\e F \d\e Y') : '' }} al {{ $solicitud->fecha_fin ? \Carbon\Carbon::parse($solicitud->fecha_fin)->translatedFormat('d \d\e F \d\e Y') : '' }}</td>
                <td class="label-col">Modalidad</td>
                <td class="val-col">ESTANCIA PROFESIONAL</td>
            </tr>
            <tr>
                <td class="label-col">Horario</td>
                <td class="val-col" colspan="3">A convenir (480 horas en total)</td>
                <td class="label-col">Modo presentación</td>
                <td class="val-col">NUEVO</td>
            </tr>
        </table>

        <!-- OBJETIVO -->
        <div class="section-header text-left bg-transparent mb-0 pb-0" style="background: transparent; color: #111827;">OBJETIVO</div>
        <div class="text-[10px] text-justify text-gray-900 leading-tight mb-2">
            {{ $solicitud->objetivo }}
        </div>

        <!-- ACTIVIDADES -->
        <div class="section-header text-left bg-transparent mb-0 pb-0 mt-2" style="background: transparent; color: #111827;">ACTIVIDADES</div>
        <div class="text-[10px] text-justify text-gray-900 leading-tight flex-grow">
            {{ $solicitud->actividades }}
        </div>

        <!-- Firmas -->
        <div class="mt-8 pt-8 flex justify-between items-end text-center w-full px-4" style="margin-top: auto;">
            
            <div class="w-1/3 px-2">
                <div class="border-b border-black mb-1 h-10"></div>
                <div class="text-[9px] font-bold uppercase leading-tight">{{ mb_strtoupper($solicitud->estudiante->nombre_completo) }}</div>
            </div>
            
            <div class="w-1/3 px-2">
                <div class="border-b border-black mb-1 h-10"></div>
                <div class="text-[9px] font-bold uppercase leading-tight">{{ mb_strtoupper($coordinadorName) }}<br><span class="font-normal capitalize">Coordinador de la práctica profesional</span></div>
            </div>
            
            <div class="w-1/3 px-2 relative">
                <!-- Espacio para sello -->
                <div class="absolute -top-12 left-1/2 transform -translate-x-1/2 w-16 h-16 border border-dashed border-gray-400 rounded-full flex items-center justify-center text-[7px] text-gray-400 opacity-50 select-none z-[-1]">
                    SELLO
                </div>
                <div class="border-b border-black mb-1 h-10"></div>
                <div class="text-[9px] font-bold uppercase leading-tight">Responsable de la Unidad Receptora</div>
            </div>

        </div>

    </div>

    <!-- Auto Print Script -->
    <script class="no-print">
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.print();
            }, 800);
        });
    </script>
</body>
</html>
