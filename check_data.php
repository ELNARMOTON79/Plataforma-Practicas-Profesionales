<?php
// Check database for test data
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Estudiante;
use App\Models\Solicitud;
use App\Models\Hora;
use App\Models\Documento;
use App\Models\User;

echo "=== VERIFICACIÓN DE DATOS DE PRUEBA ===" . PHP_EOL . PHP_EOL;

// Check users
$users = User::count();
echo "Usuarios totales: $users" . PHP_EOL;

// Check estudiantes
$estudiantes = Estudiante::count();
echo "Estudiantes totales: $estudiantes" . PHP_EOL . PHP_EOL;

if ($estudiantes > 0) {
    $estudiante = Estudiante::first();
    echo "Primer estudiante: " . $estudiante->nombre_completo . PHP_EOL;
    echo "  Usuario ID: " . $estudiante->usuario_id . PHP_EOL;
    echo "  Matrícula: " . $estudiante->matricula . PHP_EOL;
    
    $solicitudes = $estudiante->solicitudes;
    echo "  Solicitudes totales: " . $solicitudes->count() . PHP_EOL;
    
    if ($solicitudes->count() > 0) {
        foreach ($solicitudes as $s) {
            echo "    - ID: $s->id | Estatus: $s->estatus | Horas: " . $s->horas()->count() . " | Docs: " . $s->documentos()->count() . PHP_EOL;
        }
    }
    
    echo PHP_EOL . "=== SOLICITUDES ACTIVAS ===" . PHP_EOL;
    $activas = Solicitud::whereIn('estatus', ['aprobada', 'en_proceso'])->count();
    echo "Solicitudes aprobadas/en_proceso: $activas" . PHP_EOL;
    
    if ($activas > 0) {
        $s = Solicitud::whereIn('estatus', ['aprobada', 'en_proceso'])->first();
        echo "  - ID: $s->id | Est: $s->estatus" . PHP_EOL;
        echo "    Horas: " . $s->horas()->count() . " | Documentos: " . $s->documentos()->count() . PHP_EOL;
    }
}
?>
