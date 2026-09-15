<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: none;
            -ms-text-size-adjust: none;
        }
        .wrapper {
            width: 100%;
            background-color: #f8fafc;
            padding: 40px 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }
        .header {
            background-color: #4E7D24;
            background-image: linear-gradient(135deg, #4E7D24 0%, #6BA53A 100%);
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .content {
            padding: 40px 30px;
            color: #334155;
            line-height: 1.6;
        }
        .content h2 {
            color: #0f172a;
            font-size: 20px;
            margin-top: 0;
            margin-bottom: 16px;
            font-weight: 700;
        }
        .content p {
            font-size: 15px;
            margin-bottom: 24px;
            color: #475569;
        }
        .btn-container {
            text-align: center;
            margin: 35px 0;
        }
        .btn {
            display: inline-block;
            background-color: #4E7D24;
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 30px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(78, 125, 36, 0.2);
            transition: background-color 0.2s;
        }
        .footer {
            background-color: #f1f5f9;
            padding: 24px 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #64748b;
        }
        .footer a {
            color: #4E7D24;
            text-decoration: none;
            font-weight: 600;
        }
        .break-link {
            font-size: 13px;
            color: #64748b;
            word-break: break-all;
            margin-top: 20px;
            padding: 12px;
            background-color: #f8fafc;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <!-- Header -->
            <div class="header">
                <h1>Prácticas Profesionales UdeC</h1>
            </div>

            <!-- Content -->
            <div class="content">
                <h2>Solicitud de restablecimiento de contraseña</h2>
                <p>Hola,</p>
                <p>Recibiste este correo porque recibimos una solicitud para restablecer la contraseña de tu cuenta en la Plataforma de Prácticas Profesionales.</p>
                
                <div class="btn-container">
                    <a href="{{ $resetUrl }}" class="btn" target="_blank">Restablecer Contraseña</a>
                </div>

                <p>Este enlace de restablecimiento de contraseña expirará en 60 minutos.</p>
                <p>Si no realizaste esta solicitud, puedes ignorar este correo de forma segura y tu contraseña actual no sufrirá cambios.</p>
                
                <div class="break-link">
                    <strong>¿El botón no funciona?</strong> Copia y pega la siguiente URL en tu navegador web:<br>
                    <a href="{{ $resetUrl }}" target="_blank">{{ $resetUrl }}</a>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p>Este es un correo automático, por favor no respondas a este mensaje.</p>
                <p>&copy; {{ date('Y') }} Universidad de Colima. Todos los derechos reservados.</p>
            </div>
        </div>
    </div>
</body>
</html>
