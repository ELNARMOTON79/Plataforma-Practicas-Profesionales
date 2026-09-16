<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Plan de Trabajo</title>
    <style>
        @page { margin: 60px 55px 70px 55px; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10.5px;
            color: #1a1a1a;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 18px;
        }
        .header .logo {
            height: 38px;
            margin-bottom: 6px;
        }
        .header h1 {
            font-size: 15px;
            margin: 0;
            letter-spacing: 0.5px;
        }
        .header h2 {
            font-size: 12px;
            font-weight: normal;
            margin: 4px 0 0;
            color: #333;
        }
        table.datos {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }
        table.datos caption {
            text-align: left;
            font-weight: bold;
            font-size: 10.5px;
            background: #eef1ea;
            border: 1px solid #999;
            padding: 4px 8px;
            caption-side: top;
        }
        table.datos td, table.datos th {
            border: 1px solid #999;
            padding: 5px 8px;
            vertical-align: top;
        }
        table.datos th {
            width: 26%;
            text-align: left;
            background: #f7f8f5;
            font-weight: bold;
            font-size: 9.5px;
            color: #444;
        }
        .seccion-titulo {
            font-weight: bold;
            font-size: 10.5px;
            background: #eef1ea;
            border: 1px solid #999;
            border-bottom: none;
            padding: 4px 8px;
        }
        .seccion-contenido {
            border: 1px solid #999;
            padding: 10px 8px;
            margin-bottom: 14px;
            min-height: 60px;
        }
        .seccion-contenido.corta { min-height: 40px; }
        .linea-escritura {
            border-bottom: 1px solid #ccc;
            height: 16px;
        }
        .linea-escritura:last-child { border-bottom: none; }
        .firmas {
            margin-top: 55px;
            width: 100%;
        }
        .firmas td {
            width: 33.33%;
            text-align: center;
            font-size: 9.5px;
            padding-top: 0;
        }
        .firmas .linea {
            border-top: 1px solid #333;
            width: 85%;
            margin: 0 auto 6px;
        }
        .lugar-fecha {
            text-align: right;
            font-size: 10.5px;
            margin: 18px 0 0;
        }
        .aviso {
            margin-top: 40px;
            padding: 10px 12px;
            border: 1px dashed #999;
            font-size: 9px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo_verde.png') }}" class="logo" alt="Logo">
        <h1>UNIVERSIDAD DE COLIMA</h1>
        <h2>PLAN DE TRABAJO — PRÁCTICA PROFESIONAL</h2>
    </div>

    <table class="datos">
        <caption>DATOS DEL ESTUDIANTE</caption>
        <tr>
            <th>Número de cuenta</th>
            <td>{{ $matricula }}</td>
            <th>Nombre</th>
            <td>{{ $nombreEstudiante }}</td>
        </tr>
        <tr>
            <th>Carrera</th>
            <td>{{ $carrera }}</td>
            <th>Semestre / Grupo</th>
            <td>{{ $semestre ?: '—' }} {{ $grupo ? '/ '.$grupo : '' }}</td>
        </tr>
    </table>

    <table class="datos">
        <caption>DATOS DE LA UNIDAD RECEPTORA</caption>
        <tr>
            <th>Nombre</th>
            <td colspan="3">{{ $empresaNombre }}</td>
        </tr>
        <tr>
            <th>Sector</th>
            <td>{{ $empresaSector ?: '—' }}</td>
            <th>Titular</th>
            <td>{{ $empresaTitular ?: '—' }}</td>
        </tr>
        <tr>
            <th>Cargo del titular</th>
            <td>{{ $empresaCargo ?: '—' }}</td>
            <th>Responsable / Asesor</th>
            <td>{{ $responsable ?: '—' }}</td>
        </tr>
        <tr>
            <th>Domicilio</th>
            <td colspan="3">{{ $empresaDireccion ?: '—' }}</td>
        </tr>
    </table>

    <table class="datos">
        <caption>DATOS DEL PROYECTO</caption>
        <tr>
            <th>Periodo solicitado</th>
            <td colspan="3">{{ $fechaInicio }} al {{ $fechaFin }}</td>
        </tr>
        <tr>
            <th>Nombre del proyecto</th>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <th>Horario</th>
            <td>&nbsp;</td>
            <th>Modalidad</th>
            <td>&nbsp;</td>
        </tr>
    </table>

    <div class="seccion-titulo">OBJETIVO</div>
    <div class="seccion-contenido">
        <div class="linea-escritura"></div>
        <div class="linea-escritura"></div>
        <div class="linea-escritura"></div>
        <div class="linea-escritura"></div>
    </div>

    <div class="seccion-titulo">ACTIVIDADES</div>
    <div class="seccion-contenido">
        <div class="linea-escritura"></div>
        <div class="linea-escritura"></div>
        <div class="linea-escritura"></div>
        <div class="linea-escritura"></div>
        <div class="linea-escritura"></div>
        <div class="linea-escritura"></div>
    </div>

    <div class="lugar-fecha">
        {{ $lugar }}, a {{ $fecha }}
    </div>

    <table class="firmas">
        <tr>
            <td>
                <div class="linea"></div>
                {{ $nombreEstudiante }}<br>Estudiante
            </td>
            <td>
                <div class="linea"></div>
                Responsable de la Unidad Receptora
            </td>
            <td>
                <div class="linea"></div>
                Coordinador(a) de Prácticas Profesionales
            </td>
        </tr>
    </table>

    <div class="aviso">
        Este documento es una plantilla generada automáticamente por la Plataforma de Prácticas Profesionales.
        Debe completarse a mano, imprimirse, ser firmado por el estudiante, el responsable de la unidad receptora
        y el coordinador de la práctica profesional, y posteriormente subirse de nuevo en formato PDF escaneado
        en la sección "Expediente Digital" para su validación.
    </div>
</body>
</html>
