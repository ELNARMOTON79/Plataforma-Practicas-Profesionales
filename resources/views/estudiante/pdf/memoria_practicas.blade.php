<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Memoria de Práctica Profesional</title>
    <style>
        @page { margin: 70px 70px 60px 70px; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11.5px;
            color: #1a1a1a;
            line-height: 1.6;
        }
        .portada {
            text-align: center;
        }
        .portada .logo {
            height: 55px;
            margin-bottom: 14px;
        }
        .portada .universidad {
            font-size: 17px;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .portada .facultad {
            font-size: 13px;
            margin-bottom: 40px;
        }
        .portada .tipo-doc {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 36px;
        }
        .portada .titulo-proyecto {
            font-size: 13px;
            font-weight: bold;
            max-width: 420px;
            margin: 0 auto 8px;
        }
        .portada .empresa {
            font-size: 11.5px;
            color: #333;
            margin-bottom: 34px;
        }
        .portada .presenta {
            font-size: 11.5px;
            margin-bottom: 10px;
        }
        .portada .nombre-estudiante {
            font-size: 13px;
            font-weight: bold;
        }
        .portada .matricula {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 34px;
        }
        .portada .asesores-titulo {
            font-size: 11.5px;
            margin-bottom: 14px;
        }
        .asesor-block {
            margin-bottom: 18px;
        }
        .asesor-block .nombre {
            font-weight: bold;
            font-size: 12px;
        }
        .asesor-block .rol {
            font-size: 11px;
            color: #333;
        }
        .linea-vacia {
            display: inline-block;
            border-bottom: 1px solid #999;
            min-width: 220px;
            height: 14px;
        }
        .lugar-fecha {
            margin-top: 40px;
            font-size: 11px;
            color: #444;
        }
        .salto { page-break-after: always; }

        .firmas-titulo {
            text-align: center;
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 40px;
        }
        table.firmas-tabla {
            width: 100%;
            border-collapse: collapse;
        }
        table.firmas-tabla td {
            width: 50%;
            text-align: center;
            padding: 0 20px 55px;
            vertical-align: bottom;
        }
        .firma-linea {
            border-top: 1px solid #333;
            width: 85%;
            margin: 0 auto 6px;
        }
        .firma-nombre {
            font-weight: bold;
            font-size: 11px;
        }
        .firma-rol {
            font-size: 10px;
            color: #444;
        }
        .practicante-firma {
            margin-top: 50px;
            text-align: center;
        }
        .aviso {
            margin-top: 45px;
            padding: 10px 12px;
            border: 1px dashed #999;
            font-size: 9px;
            color: #555;
        }
    </style>
</head>
<body>
    {{-- Página 1: Portada --}}
    <div class="portada">
        <img src="{{ public_path('images/logo_verde.png') }}" class="logo" alt="Logo">
        <div class="universidad">UNIVERSIDAD DE COLIMA</div>
        <div class="facultad">{{ $facultad ?: 'Facultad' }}</div>

        <div class="tipo-doc">Memoria de Práctica Profesional</div>

        <div class="titulo-proyecto">&nbsp;</div>
        <div class="empresa">{{ $empresaNombre }}</div>

        <div class="presenta">Presenta</div>
        <div class="nombre-estudiante">{{ $nombreEstudiante }}</div>
        <div class="matricula">{{ $matricula }}</div>

        <div class="asesores-titulo">Asesores</div>

        <div class="asesor-block">
            <div class="nombre">{{ $asesorEmpresa ?: '—' }}</div>
            <div class="rol">Asesor de Unidad Receptora</div>
        </div>

        <div class="asesor-block">
            <div class="linea-vacia">&nbsp;</div>
            <div class="rol">Asesor(a) de Prácticas Profesionales del Plantel</div>
        </div>

        <div class="asesor-block">
            <div class="linea-vacia">&nbsp;</div>
            <div class="rol">{{ $facultad ?: 'Facultad' }}<br>Coordinador(a) de Prácticas Profesionales</div>
        </div>

        <div class="lugar-fecha">{{ $lugar }}, {{ $fecha }}</div>
    </div>

    <div class="salto"></div>

    {{-- Página 2: Firmas --}}
    <div class="firmas-titulo">Firmas autorizadas</div>

    <table class="firmas-tabla">
        <tr>
            <td>
                <div class="firma-linea"></div>
                <div class="firma-nombre">{{ $asesorEmpresa ?: '—' }}</div>
                <div class="firma-rol">Asesor de Unidad Receptora</div>
            </td>
            <td>
                <div class="firma-linea"></div>
                <div class="firma-nombre">&nbsp;</div>
                <div class="firma-rol">Asesor(a) de Prácticas Profesionales del Plantel</div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="firma-linea"></div>
                <div class="firma-nombre">&nbsp;</div>
                <div class="firma-rol">{{ $facultad ?: 'Facultad' }}<br>Coordinador(a) de Prácticas Profesionales</div>
            </td>
            <td></td>
        </tr>
    </table>

    <div class="practicante-firma">
        <div class="firma-linea" style="width: 260px;"></div>
        <div class="firma-nombre">{{ $nombreEstudiante }}</div>
        <div class="firma-rol">Practicante</div>
    </div>

    <div class="aviso">
        Este documento es una plantilla generada automáticamente por la Plataforma de Prácticas Profesionales.
        Debe completarse con el desarrollo de la memoria (título del proyecto y contenido del reporte), imprimirse,
        recabar las firmas autorizadas correspondientes, y posteriormente subirse de nuevo en formato PDF escaneado
        en la sección "Expediente Digital" para su validación.
    </div>
</body>
</html>
