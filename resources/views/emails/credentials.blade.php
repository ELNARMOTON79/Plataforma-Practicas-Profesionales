<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tus Credenciales de Acceso</title>
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
            background: linear-gradient(135deg, #4E7D24 0%, #2E5417 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.5px;
        }
        .header p {
            color: #d0e7bd;
            font-size: 14px;
            margin: 10px 0 0 0;
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
        .credentials-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            margin: 25px 0;
        }
        .credential-row {
            margin-bottom: 12px;
        }
        .credential-row:last-child {
            margin-bottom: 0;
        }
        .credential-label {
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }
        .credential-value {
            font-size: 16px;
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
        .warning-text {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 20px !important;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <!-- Header -->
            <div class="header">
                <h1>Universidad de Colima</h1>
                <p>Plataforma de Prácticas Profesionales</p>
            </div>
            
            <!-- Content -->
            <div class="content">
                <h2>¡Hola, {{ $name }}!</h2>
                <p>Te damos la bienvenida al sistema de Prácticas Profesionales de la UdeC. Un administrador ha creado tu cuenta. A continuación, se detallan tus credenciales de acceso temporal:</p>
                
                <!-- Credentials -->
                <div class="credentials-card">
                    <div class="credential-row">
                        <div class="credential-label">Correo Electrónico</div>
                        <div class="credential-value">{{ $user->correo }}</div>
                    </div>
                    <div class="credential-row" style="margin-top: 15px;">
                        <div class="credential-label">Contraseña Temporal</div>
                        <div class="credential-value" style="font-family: monospace; font-size: 18px; letter-spacing: 0.5px; color: #4E7D24;">{{ $password }}</div>
                    </div>
                </div>

                <p class="warning-text"><strong>* Nota de Seguridad:</strong> Por razones de seguridad, te recomendamos cambiar esta contraseña temporal desde tu panel de usuario al iniciar sesión por primera vez.</p>
                
                <!-- Button -->
                <div class="button-container">
                    <a href="{{ url('/') }}" class="btn-primary" target="_blank">Iniciar Sesión</a>
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
