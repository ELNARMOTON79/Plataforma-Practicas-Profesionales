<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carta de Presentación</title>
    <style>
        @page { margin: 90px 70px 80px 70px; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #1a1a1a;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 26px;
        }
        .header .logo {
            height: 45px;
            margin-bottom: 10px;
        }
        .header h1 {
            font-size: 15px;
            margin: 0;
            letter-spacing: 0.5px;
        }
        .header h2 {
            font-size: 11px;
            font-weight: normal;
            margin: 4px 0 0;
            color: #333;
        }
        .folio-block {
            text-align: right;
            font-size: 11px;
            margin-bottom: 22px;
        }
        .destinatario {
            margin-bottom: 20px;
            font-size: 12px;
        }
        .destinatario strong { display: block; }
        p { text-align: justify; margin: 0 0 14px; }
        .firma {
            margin-top: 60px;
            text-align: center;
        }
        .firma .linea {
            border-top: 1px solid #333;
            width: 260px;
            margin: 0 auto 6px;
        }
        .motto {
            text-align: center;
            font-weight: bold;
            font-size: 11px;
            margin-bottom: 2px;
        }
        .lugar-fecha {
            text-align: center;
            font-size: 11px;
            margin-bottom: 30px;
        }
        .aviso {
            margin-top: 70px;
            padding: 10px 12px;
            border: 1px dashed #999;
            font-size: 9.5px;
            color: #555;
        }
        .folio-linea {
            display: inline-block;
            border-bottom: 1px solid #333;
            min-width: 160px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo_verde.png') }}" class="logo" alt="Logo">
        <h1>UNIVERSIDAD DE COLIMA</h1>
        <h2>{{ $carrera ?: 'Coordinación de Prácticas Profesionales' }}</h2>
    </div>

    <div class="folio-block">
        Folio: <span class="folio-linea">&nbsp;</span><br>
        Asunto: Prácticas profesionales
    </div>

    <div class="destinatario">
        <strong>{{ $destinatarioNombre }}</strong>
        @if($destinatarioCargo)
            {{ $destinatarioCargo }}<br>
        @endif
        {{ $empresaNombre }}
        @if($empresaDireccion)
            <br>{{ $empresaDireccion }}
        @endif
    </div>

    <p>
        Por este conducto, tengo a bien presentar a su fina consideración a <strong>{{ $nombreEstudiante }}</strong>,
        con número de cuenta <strong>{{ $matricula }}</strong>, estudiante de la carrera de <strong>{{ $carrera }}</strong>,
        quien cumple con los requisitos establecidos en la normatividad aplicable y desea realizar sus prácticas
        profesionales en <strong>{{ $empresaNombre }}</strong>.
    </p>

    <p>
        En caso de ser favorable dicha solicitud, ruego a usted informar el día de inicio, fecha de término, horario,
        departamento, jefe inmediato y programa de actividades que realizará, el cual deberá apegarse al perfil y la
        pertinencia de la carrera que está cursando.
    </p>

    <p>
        Agradeciendo las atenciones que le brinde al portador de la presente, aprovecho la ocasión para expresarle mi
        más alta y distinguida consideración.
    </p>

    <div class="lugar-fecha">
        {{ $lugar }}, a {{ $fecha }}
    </div>

    <div class="motto">ATENTAMENTE<br>ESTUDIA, LUCHA Y TRABAJA</div>

    <div class="firma">
        <div class="linea"></div>
        Coordinador(a) de Prácticas Profesionales
    </div>

    <div class="aviso">
        Este documento es una plantilla generada automáticamente por la Plataforma de Prácticas Profesionales.
        Debe imprimirse, ser firmado y sellado por la instancia correspondiente, y posteriormente subirse de nuevo
        en formato PDF escaneado en la sección "Expediente Digital" para su validación.
    </div>
</body>
</html>
