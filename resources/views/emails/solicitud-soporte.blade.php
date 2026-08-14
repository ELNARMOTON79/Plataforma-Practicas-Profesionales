<!DOCTYPE html>
<html>
<head>
    <title>Solicitud de Soporte</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 8px;">
        <div style="text-align: center; margin-bottom: 20px;">
            <h2 style="color: #4E7D24;">Control de Prácticas</h2>
        </div>
        
        <p>Hola Administrador,</p>
        
        <p>El Coordinador <strong>{{ $coordinador->name }}</strong> ({{ $coordinador->correo }}) ha solicitado asistencia con un registro en la plataforma.</p>
        
        <div style="background-color: #f9f9f9; padding: 15px; border-left: 4px solid #6BA53A; margin: 20px 0;">
            <p style="margin: 0 0 10px 0;"><strong>Tipo de Registro:</strong> {{ ucfirst($tipoRegistro) }}</p>
            <p style="margin: 0 0 10px 0;"><strong>Nombre / Identificador:</strong> {{ $nombreRegistro }}</p>
            <p style="margin: 0;"><strong>Motivo / Solicitud:</strong><br>
                {!! nl2br(e($mensajeSoporte)) !!}
            </p>
        </div>
        
        <p>Por favor, revisa esta solicitud desde el panel de administración.</p>
        
        <p style="margin-top: 30px; font-size: 12px; color: #777;">
            Este es un correo automático generado por el Sistema de Control de Prácticas Profesionales.
        </p>
    </div>
</body>
</html>
