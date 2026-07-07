<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> </title>
    
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
                margin: 0; /* Hides default browser headers/footers (localhost, date, page numbers) */
            }
            body {
                background-color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                margin: 0 !important;
                padding: 1.5cm 2.0cm 1.5cm 2.0cm !important; /* Simulates standard page margins */
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
                min-height: 0 !important; /* Reset height constraints to fit on a single page */
                height: auto !important;
            }
        }

        .udec-shield {
            width: 76px;
            height: 76px;
            object-fit: cover;
            object-position: left;
        }
    </style>
</head>
<body class="p-4 md:p-8 flex flex-col items-center">

    <!-- Floating Actions Panel (No Print) -->
    <div class="no-print bg-white/80 backdrop-blur-md border border-gray-200/80 shadow-xl rounded-2xl p-4 mb-8 max-w-3xl w-full flex items-center justify-between gap-4 sticky top-4 z-50">
        <div class="flex items-center gap-3">
            <div class="p-2.5 bg-[#4E7D24]/10 text-[#4E7D24] rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-bold text-gray-900">Carta de Presentación Oficial</h2>
                <p class="text-xs text-gray-500 font-medium mt-0.5">Formato oficial de la Facultad de Ingeniería Electromecánica</p>
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
    <div class="print-container bg-white border border-gray-200 shadow-2xl rounded-[16px] p-12 md:p-16 max-w-[21.59cm] w-full min-h-[27.94cm] relative flex flex-col justify-between text-gray-900 leading-relaxed text-[13px]">
        
        <div>
            <!-- Centered Official Header -->
            <div class="flex flex-col items-center text-center">
                <img src="{{ asset('images/logo_verde.png') }}" class="udec-shield mb-3" alt="Logo Universidad de Colima">
                <h1 class="text-base font-serif font-semibold tracking-wider text-gray-900 uppercase">UNIVERSIDAD DE COLIMA</h1>
                <h2 class="text-[10px] font-sans font-extrabold tracking-wider text-gray-500 mt-0.5">FACULTAD DE INGENIERÍA ELECTROMECÁNICA</h2>
            </div>

            <!-- Folio and Asunto Block -->
            <div class="text-right mt-6 text-xs text-gray-900 space-y-0.5 font-sans">
                <p><span class="font-bold">Folio:</span> 6E.1.1/703000/{{ str_pad($solicitud->id, 3, '0', STR_PAD_LEFT) }}/{{ now()->format('Y') }}</p>
                <p><span class="font-bold">Asunto:</span> Prácticas profesionales</p>
            </div>

            <!-- Recipient Block -->
            <div class="mt-8 text-xs text-gray-905 space-y-0.5 font-sans">
                <p class="font-bold">{{ $solicitud->responsable }}</p>
                @if($solicitud->unidadReceptora && $solicitud->unidadReceptora->cargo)
                    <p class="font-bold">{{ $solicitud->unidadReceptora->cargo }}</p>
                @endif
                @if($solicitud->unidadReceptora && $solicitud->unidadReceptora->nombre_empresa)
                    <p class="font-bold">{{ $solicitud->unidadReceptora->nombre_empresa }}</p>
                @endif
                @if($solicitud->unidadReceptora && $solicitud->unidadReceptora->direccion)
                    <p class="font-bold">{{ $solicitud->unidadReceptora->direccion }}</p>
                @endif
            </div>

            <!-- Body Text -->
            <div class="mt-8 space-y-5 text-justify text-xs text-gray-800 leading-relaxed font-sans font-medium">
                <p style="text-indent: 2rem;">
                    De conformidad con el acuerdo de Rectoría No. 18, de fecha 17 de diciembre de 1983, en el cual se establece y normaliza la Práctica Profesional de esta Universidad, por este conducto, tengo a bien presentar a su fina consideración a <span class="font-bold text-gray-900">{{ $solicitud->estudiante->nombre_completo }}</span>, con número de cuenta <span class="font-bold text-gray-900">{{ $solicitud->estudiante->matricula }}</span>, estudiante de la carrera de <span class="font-bold text-gray-900">{{ $solicitud->estudiante->carrera }}</span>, quien cumple con los requisitos establecidos en la normatividad aplicable y desea realizar sus prácticas profesionales en <span class="font-bold text-gray-900">{{ $solicitud->unidadReceptora->nombre_empresa ?? 'la empresa' }}{{ $solicitud->unidadReceptora->direccion ? ', ' . $solicitud->unidadReceptora->direccion : '' }}</span>.
                </p>
                <p style="text-indent: 2rem;">
                    En caso de ser favorable dicha solicitud, ruego a usted, informar el día de inicio, fecha de término, horario, departamento, jefe inmediato y programa de actividades que realizará, el cual deberá apegarse al perfil y la pertinencia de la carrera que está cursando, y cumplir con un total de 480 horas.
                </p>
                <p style="text-indent: 2rem;">
                    Agradeciendo las atenciones que le brinde al portador de la presente, aprovecho la ocasión para expresarle mi más alta y distinguida consideración.
                </p>
            </div>

            <!-- Signature and Stamp Block -->
            <div class="mt-16 relative flex justify-center items-start font-sans">
                <!-- Centered Signature -->
                <div class="text-center w-full">
                    <p class="font-bold text-xs uppercase tracking-wider text-gray-900">ATENTAMENTE</p>
                    <p class="font-bold text-[10px] uppercase tracking-wide text-gray-800 mt-0.5">ESTUDIA LUCHA Y TRABAJA</p>
                    <p class="text-xs text-gray-900 mt-0.5 font-semibold">Manzanillo, Col. a {{ now()->locale('es')->translatedFormat('d \d\e F \d\e Y') }}</p>
                    
                    <!-- Space for physical signature -->
                    <div class="h-20"></div>
                    
                    <p class="text-xs font-bold text-gray-900 border-t border-gray-400 pt-1 inline-block px-12">D. en I. Janeth A. Alcalá Rodríguez</p>
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mt-0.5">DIRECTORA</p>
                </div>
                
                <!-- Right: Seal space -->
                <div class="absolute right-0 top-2 flex flex-col items-center justify-center">
                    <div class="w-24 h-24 border border-dashed border-gray-300 rounded-full flex flex-col items-center justify-center text-center p-2 text-gray-300 select-none">
                        <span class="text-[8px] font-bold uppercase tracking-wider">SELLO DE LA</span>
                        <span class="text-[8px] font-bold uppercase tracking-wider">INSTITUCIÓN</span>
                    </div>
                </div>
            </div>

            <!-- CCP notes -->
            <div class="mt-8 text-[9px] text-gray-500 font-sans leading-tight">
                <p>C.C.P. Expediente</p>
                <p>JAAR/JPMV*azaf</p>
            </div>
        </div>

        <!-- Footer Line and Details -->
        <div class="mt-6 pt-3 border-t border-gray-200 text-center font-sans text-[9px] text-gray-500 leading-normal">
            <p class="italic font-medium text-gray-600 mb-0.5">Pertinencia que transforma</p>
            <p>Km 20 . Carretera Manzanillo-Barra de Navidad C.P. 28860 Manzanillo, Colima, México Teléfono 314 331 12 07, 314 331 1200 Ext. 53121</p>
            <p class="text-blue-500 hover:underline">fie@ucol.mx</p>
        </div>

    </div>

    <!-- Auto Print Script -->
    <script class="no-print">
        window.addEventListener('DOMContentLoaded', () => {
            // Automatically launch print window after a brief delay so fonts render
            setTimeout(() => {
                window.print();
            }, 800);
        });
    </script>
</body>
</html>
