<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

echo "=== VERIFICACIÓN DE DATOS DE PRUEBA ===" . PHP_EOL . PHP_EOL;

// Verificar usuario
$user = \App\Models\User::where('correo', 'estudiante@test.com')->first();
echo "✓ Usuario: " . $user->correo . " (ID: " . $user->id . ")" . PHP_EOL;

// Verificar estudiante
$estudiante = \App\Models\Estudiante::where('usuario_id', $user->id)->first();
echo "✓ Estudiante: " . $estudiante->nombre_completo . " (ID: " . $estudiante->id . ")" . PHP_EOL;

// Verificar solicitud
$solicitud = \App\Models\Solicitud::where('estudiante_id', $estudiante->id)->first();
echo "✓ Solicitud: ID " . $solicitud->id . " | Estatus: " . $solicitud->estatus . PHP_EOL;

// Verificar empresa y convenios
$ur = $solicitud->unidadReceptora;
echo "✓ Unidad Receptora: " . $ur->nombre . " (ID: " . $ur->id . ")" . PHP_EOL;

$convenios = $ur->convenios()->get();
echo "✓ Convenios: " . $convenios->count() . " registros" . PHP_EOL;
foreach ($convenios as $conv) {
    echo "   - " . $conv->codigo_convenio . " | " . $conv->estatus . " | Inicio: " . $conv->fecha_inicio->format('Y-m-d') . " | Término: " . $conv->fecha_termino->format('Y-m-d') . PHP_EOL;
}

// Verificar horas
$horas = \App\Models\Hora::where('solicitud_id', $solicitud->id)->get();
echo "✓ Horas: " . $horas->count() . " registros | Total: " . $horas->sum('cantidad') . " horas" . PHP_EOL;

// Verificar documentos
$docs = $solicitud->documentos()->get();
echo "✓ Documentos: " . $docs->count() . " registros" . PHP_EOL;
foreach ($docs as $doc) {
    echo "   - " . $doc->tipo . " | Estatus: " . $doc->estatus . PHP_EOL;
}

echo PHP_EOL . "✅ VERIFICACIÓN COMPLETADA" . PHP_EOL;
?>
