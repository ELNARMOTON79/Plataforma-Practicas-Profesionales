<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta de Presentación - {{ $solicitud->estudiante->nombre_completo }}</title>
    
    <!-- Fonts from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&family=Playfair+Display:ital,wght@0,600;1,400&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (for quick preview/styling) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f3f4f6;
        }

        /* Styles for printing */
        @media print {
            body {
                background-color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
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
            }
            @page {
                size: letter;
                margin: 2.5cm;
            }
        }

        .udec-green {
            color: #4E7D24;
        }
        .udec-border {
            border-color: #6BA53A;
        }
    </style>
</head>
<body class="p-4 md:p-8 flex flex-col items-center">

    <!-- Floating Actions Panel (No Print) -->
    <div class="no-print bg-white/80 backdrop-blur-md border border-gray-200/80 shadow-xl rounded-2xl p-4 mb-8 max-w-3xl w-full flex items-center justify-between gap-4 sticky top-4 z-50">
        <div class="flex items-center gap-3">
            <div class="p-2.5 bg-[#6BA53A]/10 text-[#4E7D24] rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-bold text-gray-900">Carta de Presentación Formal</h2>
                <p class="text-xs text-gray-500 font-medium mt-0.5">Listo para imprimir o guardar como PDF en tu navegador</p>
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
    <div class="print-container bg-white border border-gray-200 shadow-2xl rounded-[32px] p-12 md:p-16 max-w-[21.59cm] w-full min-h-[27.94cm] relative flex flex-col justify-between text-gray-800 leading-relaxed text-justify text-[14px]">
        
        <!-- Subtle background watermark for decoration -->
        <div class="absolute inset-0 opacity-[0.02] pointer-events-none flex items-center justify-center p-8">
            <span class="text-9xl font-extrabold uppercase select-none tracking-widest text-[#4E7D24] rotate-45">UNIVERSIDAD DE COLIMA</span>
        </div>

        <div>
            <!-- Official Header -->
            <div class="border-b-2 udec-border pb-6 flex items-start justify-between">
                <div>
                    <h3 class="text-xs uppercase tracking-[0.25em] font-extrabold text-gray-400">Universidad de Colima</h3>
                    <h1 class="text-lg uppercase tracking-wider font-extrabold text-gray-900 mt-1">Facultad de Ingeniería Electromecánica</h1>
                    <p class="text-[10px] font-bold text-gray-500 mt-0.5">Coordinación de Prácticas Profesionales y Vinculación</p>
                </div>
                <div class="text-right">
                    <span class="text-xs font-bold text-[#4E7D24] uppercase tracking-wider">Carta de Presentación</span>
                    <p class="text-[10px] text-gray-400 font-bold uppercase mt-1">FIE-PP-{{ str_pad($solicitud->id, 5, '0', STR_PAD_LEFT) }}-{{ now()->format('Y') }}</p>
                </div>
            </div>

            <!-- Date -->
            <div class="mt-8 text-right font-semibold text-gray-700">
                Manzanillo, Col., a {{ now()->translatedFormat('d \d\e F \d\e Y') }}
            </div>

            <!-- Recipient Block -->
            <div class="mt-8">
                <p class="font-extrabold text-gray-900 uppercase">{{ mb_strtoupper($solicitud->unidadReceptora->nombre_empresa ?? 'A QUIEN CORRESPONDA') }}</p>
                <p class="font-bold text-gray-700 mt-1">At'n: {{ mb_strtoupper($solicitud->responsable ?? 'Supervisor de Prácticas') }}</p>
                <p class="text-xs font-semibold text-gray-500 uppercase mt-0.5">Presente.—</p>
            </div>

            <!-- Body Text -->
            <div class="mt-8 space-y-4 text-justify leading-7 text-gray-700 font-medium">
                <p>
                    Por medio de la presente, nos dirigimos a usted de la manera más atenta para presentar al estudiante 
                    <strong class="text-gray-950 font-bold uppercase">{{ $solicitud->estudiante->nombre_completo }}</strong>, 
                    con número de cuenta o matrícula <strong class="text-gray-950 font-bold">{{ $solicitud->estudiante->matricula }}</strong>, 
                    quien cursa actualmente el <strong class="text-gray-950 font-bold">{{ $solicitud->estudiante->semestre }}º semestre</strong> 
                    de la carrera de <strong class="text-gray-950 font-bold uppercase">{{ $solicitud->estudiante->carrera }}</strong> 
                    en esta institución educativa.
                </p>
                <p>
                    El motivo de esta presentación es solicitar su valioso apoyo para que el mencionado alumno pueda realizar sus 
                    <strong>Prácticas Profesionales</strong> en su prestigiada organización, cubriendo un total de <strong>480 horas</strong> 
                    debidamente reglamentadas. 
                </p>
                <p>
                    El proyecto propuesto a desarrollar lleva por título <strong class="text-gray-950 font-bold uppercase">"{{ $solicitud->titulo }}"</strong>, 
                    el cual comprende la realización de actividades afines a su perfil profesional. El estudiante tiene proyectado llevar a cabo 
                    dichas actividades durante el período comprendido del <strong class="text-gray-950 font-bold">{{ $solicitud->fecha_inicio->format('d/m/Y') }}</strong> 
                    al <strong class="text-gray-950 font-bold">{{ $solicitud->fecha_fin->format('d/m/Y') }}</strong>.
                </p>
                <p>
                    Agradecemos de antemano el apoyo que se sirva brindar al estudiante en mención, lo cual contribuirá significativamente en su 
                    formación académica e integración profesional. Sin otro particular por el momento, me es grato reiterarles nuestra distinguida 
                    consideración y respeto.
                </p>
            </div>
        </div>

        <!-- Signature Block -->
        <div class="mt-16">
            <div class="text-center font-bold">
                <p class="uppercase tracking-wider text-xs text-gray-500">Atentamente</p>
                <p class="italic text-gray-650 font-serif mt-1">"Estudio, Lucha, Trabajo"</p>
                
                <!-- Spacer for physical signature -->
                <div class="w-48 h-16 mx-auto my-4 border-b border-gray-300"></div>
                
                <p class="text-gray-950 uppercase tracking-wide text-xs">M. en C. Coordinador de Prácticas</p>
                <p class="text-xs text-gray-500 font-semibold mt-0.5">Facultad de Ingeniería Electromecánica — Universidad de Colima</p>
            </div>
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
