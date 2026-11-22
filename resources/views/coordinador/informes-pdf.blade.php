<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $titulo }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #1f2937; background: #fff; }
        .header { background: #4E7D24; color: #fff; padding: 18px 24px; margin-bottom: 20px; border-radius: 6px; }
        .header h1 { font-size: 16px; font-weight: bold; margin-bottom: 2px; }
        .header p  { font-size: 9px; opacity: 0.85; }
        .meta { display: flex; gap: 20px; margin-bottom: 14px; font-size: 9px; color: #6b7280; }
        .meta span { background: #f3f4f6; border: 1px solid #e5e7eb; padding: 3px 8px; border-radius: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 6px; }
        thead th {
            background: #4E7D24;
            color: #fff;
            padding: 8px 10px;
            text-align: left;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        tbody tr:nth-child(even) { background: #f9fafb; }
        tbody td { padding: 7px 10px; border-bottom: 1px solid #e5e7eb; vertical-align: top; }
        .badge { display: inline-block; padding: 2px 7px; border-radius: 9px; font-size: 8px; font-weight: bold; }
        .badge-green  { background: #dcfce7; color: #166534; }
        .badge-red    { background: #fee2e2; color: #991b1b; }
        .badge-yellow { background: #fef9c3; color: #854d0e; }
        .footer { margin-top: 20px; font-size: 8px; color: #9ca3af; text-align: right; border-top: 1px solid #e5e7eb; padding-top: 8px; }
        .no-data { text-align: center; padding: 24px; color: #9ca3af; font-style: italic; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $titulo }}</h1>
        <p>Universidad de Colima — Prácticas Profesionales &nbsp;|&nbsp; Generado el {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="meta">
        @if(!empty($filtros['carrera']))   <span>Carrera: {{ $filtros['carrera'] }}</span>@endif
        @if(!empty($filtros['genero']))    <span>Género: {{ ucfirst($filtros['genero']) }}</span>@endif
        @if(!empty($filtros['ciclo']))     <span>Ciclo: {{ $filtros['ciclo'] }}</span>@endif
        @if(!empty($filtros['modalidad'])) <span>Modalidad: {{ ucfirst($filtros['modalidad']) }}</span>@endif
        <span>Total registros: {{ count($filas) }}</span>
    </div>

    @if(count($filas) > 0)
        <table>
            <thead>
                <tr>
                    @foreach($columnas as $col)
                        <th>{{ $col }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($filas as $fila)
                    <tr>
                        @foreach($fila as $celda)
                            <td>{{ $celda }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="no-data">No se encontraron registros con los filtros aplicados.</p>
    @endif

    <div class="footer">
        Plataforma de Prácticas Profesionales — UCOL &nbsp;|&nbsp; Reporte generado automáticamente
    </div>
</body>
</html>
