<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo }}</title>
    <style>
        body {
            font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, Helvetica, Arial, sans-serif;
            background-color: #f6f9fc;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper { width: 100%; background-color: #f6f9fc; padding: 40px 0; }
        .container { max-width: 580px; margin: 0 auto; background-color: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); }
        .header { background-color: #ffffff; padding: 40px 30px 20px 30px; text-align: center; border-bottom: 1px solid #e2e8f0; }
        .header p { color: #4E7D24; font-size: 14px; font-weight: 600; margin: 15px 0 0 0; text-transform: uppercase; letter-spacing: 0.5px; }
        .content { padding: 40px 35px; }
        .content h2 { color: #1a1a1a; font-size: 20px; font-weight: 700; margin: 12px 0 15px; }
        .content p { color: #525f7f; font-size: 15px; line-height: 1.6; margin-top: 0; margin-bottom: 20px; }
        .badge { display: inline-block; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; padding: 4px 12px; border-radius: 999px; }
        .badge-aprobado { background-color: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
        .badge-rechazado { background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
        .badge-informativo { background-color: #f0f9ff; color: #0369a1; border: 1px solid #bae6fd; }
        .card { background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; margin: 25px 0; }
        .row { margin-bottom: 15px; }
        .row:last-child { margin-bottom: 0; }
        .label { font-size: 12px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; }
        .value { font-size: 16px; color: #0f172a; font-weight: 600; margin-top: 2px; }
        .nota { border-radius: 12px; padding: 16px 20px; margin: 0 0 20px; font-size: 14px; line-height: 1.5; }
        .nota-rechazado { background-color: #fef2f2; border: 1px solid #fecaca; color: #7f1d1d; }
        .nota-normal { background-color: #f8fafc; border: 1px solid #e2e8f0; color: #334155; }
        .button-container { text-align: center; margin: 35px 0 15px; }
        .btn-primary { display: inline-block; background-color: #4E7D24; color: #ffffff !important; font-size: 15px; font-weight: 700; text-decoration: none; padding: 14px 32px; border-radius: 12px; }
        .footer { background-color: #f8fafc; padding: 25px 30px; text-align: center; border-top: 1px solid #e2e8f0; }
        .footer p { font-size: 13px; color: #64748b; margin: 0; }
        .warning-text { font-size: 12px; color: #94a3b8; margin-top: 20px !important; line-height: 1.5; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <img src="{{ $message->embed(public_path('images/logo_verde.png')) }}" alt="Universidad de Colima" style="max-height: 55px; width: auto; display: inline-block;">
                <p>Plataforma de Prácticas Profesionales</p>
            </div>

            <div class="content">
                <span class="badge badge-{{ $resultado }}">
                    @if($resultado === 'aprobado') Aprobado @elseif($resultado === 'rechazado') Rechazado @else Aviso @endif
                </span>
                <h2>{{ $titulo }}</h2>
                <p>Hola, <strong>{{ $nombreAlumno }}</strong>. {{ $mensaje }}</p>

                @if(!empty($detalles))
                    <div class="card">
                        @foreach($detalles as $label => $value)
                            <div class="row">
                                <div class="label">{{ $label }}</div>
                                <div class="value">{{ $value }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($observaciones)
                    <div class="nota {{ $resultado === 'rechazado' ? 'nota-rechazado' : 'nota-normal' }}">
                        <strong>{{ $resultado === 'rechazado' ? 'Motivo:' : 'Comentarios:' }}</strong> {{ $observaciones }}
                    </div>
                @endif

                @if($siguientePaso)
                    <p>{{ $siguientePaso }}</p>
                @endif

                <div class="button-container">
                    <a href="{{ $urlAccion }}" class="btn-primary" target="_blank">{{ $textoBoton }}</a>
                </div>

                <p class="warning-text">Este es un mensaje automático, por favor no respondas a este correo.</p>
            </div>

            <div class="footer">
                <p>© {{ date('Y') }} Universidad de Colima. Todos los derechos reservados.</p>
            </div>
        </div>
    </div>
</body>
</html>
