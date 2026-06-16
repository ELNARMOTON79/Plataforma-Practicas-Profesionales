<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Unidad Receptora Asociada</title>
    <style>
        body {
            font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, Helvetica, Arial, sans-serif;
            background-color: #f6f9fc;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .wrapper {
            width: 100%;
            background-color: #f6f9fc;
            padding: 40px 0;
        }
        .container {
            max-width: 580px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        .header {
            background-color: #ffffff;
            padding: 40px 30px 20px 30px;
            text-align: center;
            border-bottom: 1px solid #e2e8f0;
        }
        .header-logo {
            max-height: 55px;
            width: auto;
            display: inline-block;
        }
        .header p {
            color: #4E7D24;
            font-size: 14px;
            font-weight: 600;
            margin: 15px 0 0 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .content {
            padding: 40px 35px;
        }
        .content h2 {
            color: #1a1a1a;
            font-size: 20px;
            font-weight: 700;
            margin-top: 0;
            margin-bottom: 15px;
        }
        .content p {
            color: #525f7f;
            font-size: 15px;
            line-height: 1.6;
            margin-top: 0;
            margin-bottom: 20px;
        }
        .units-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            margin: 25px 0;
        }
        .unit-row {
            margin-bottom: 12px;
            border-bottom: 1px dashed #e2e8f0;
            padding-bottom: 12px;
        }
        .unit-row:last-child {
            margin-bottom: 0;
            border-bottom: none;
            padding-bottom: 0;
        }
        .unit-label {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }
        .unit-value {
            font-size: 15px;
            color: #0f172a;
            font-weight: 600;
            margin-top: 2px;
        }
        .button-container {
            text-align: center;
            margin: 35px 0 15px;
        }
        .btn-primary {
            display: inline-block;
            background-color: #4E7D24;
            color: #ffffff !important;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(78, 125, 36, 0.25);
            transition: all 0.2s ease;
        }
        .btn-primary:hover {
            background-color: #2E5417;
            box-shadow: 0 6px 15px rgba(46, 84, 23, 0.35);
        }
        .footer {
            background-color: #f8fafc;
            padding: 25px 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        .footer p {
            font-size: 13px;
            color: #64748b;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <!-- Header -->
            <div class="header">
                <img src="{{ $message->embed(public_path('images/logo_verde.png')) }}" alt="Universidad de Colima" class="header-logo" style="max-height: 55px; width: auto; display: inline-block;">
                <p>Plataforma de Prácticas Profesionales</p>
            </div>
            
            <!-- Content -->
            <div class="content">
                <h2>¡Hola, {{ $name }}!</h2>
                <p>Te informamos que se han asociado nuevas unidades receptoras a tu cuenta en la Plataforma de Prácticas Profesionales de la UdeC. Ya que tu correo ya se encuentra registrado, puedes acceder a ellas con tus credenciales de acceso habituales.</p>
                
                <!-- Associated Units -->
                <div class="units-card">
                    <p style="margin-top: 0; margin-bottom: 15px; font-weight: bold; color: #4E7D24; font-size: 14px;">Nuevas Unidades Receptoras Vinculadas:</p>
                    @foreach($units as $unit)
                        <div class="unit-row">
                            <div class="unit-label">Unidad Receptora</div>
                            <div class="unit-value">{{ $unit['unidad_receptora'] }}</div>
                            <div class="unit-label" style="margin-top: 4px;">Institución</div>
                            <div class="unit-value" style="font-size: 13px; font-weight: normal; color: #525f7f;">{{ $unit['nombre_empresa'] }}</div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Button -->
                <div class="button-container">
                    <a href="{{ url('/') }}" class="btn-primary" target="_blank">Acceder al Sistema</a>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="footer">
                <p>© {{ date('Y') }} Universidad de Colima. Todos los derechos reservados.</p>
            </div>
        </div>
    </div>
</body>
</html>
