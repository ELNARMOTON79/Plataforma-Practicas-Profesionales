<?php
// Seed test data for student dashboard
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\User;
use App\Models\Estudiante;
use App\Models\Solicitud;
use App\Models\UnidadReceptora;
use App\Models\Hora;
use App\Models\Documento;
use App\Models\Convenio;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

echo "=== CREANDO DATOS DE PRUEBA ===" . PHP_EOL . PHP_EOL;

// 1. Crear usuario de prueba
$user = User::firstOrCreate(
    ['correo' => 'estudiante@test.com'],
    [
        'nombre' => 'Estudiante Test',
        'contraseña' => Hash::make('password123'),
        'rol_id' => 3, // Estudiante
    ]
);
echo "✓ Usuario: {$user->correo} (ID: {$user->id})" . PHP_EOL;

// 2. Crear estudiante
$estudiante = Estudiante::firstOrCreate(
    ['usuario_id' => $user->id],
    [
        'nombre_completo' => 'Juan Carlos Pérez López',
        'primer_nombre' => 'Juan Carlos',
        'apellidos' => 'Pérez López',
        'matricula' => 'A00123456',
        'carrera' => 'Ingeniería en Sistemas',
        'semestre' => 6,
        'grupo' => 'A',
        'direccion' => 'Calle Principal 123',
        'telefono' => '5551234567',
    ]
);
echo "✓ Estudiante: {$estudiante->nombre_completo} (ID: {$estudiante->id})" . PHP_EOL;

// 3. Crear usuario de empresa
$user_empresa = User::firstOrCreate(
    ['correo' => 'empresa@techsolutions.com'],
    [
        'nombre' => 'Tech Solutions Inc.',
        'contraseña' => Hash::make('password123'),
        'rol_id' => 4, // Empresa
    ]
);
echo "✓ Usuario Empresa: {$user_empresa->correo} (ID: {$user_empresa->id})" . PHP_EOL;

// 4. Crear unidad receptora (empresa)
$ur = UnidadReceptora::firstOrCreate(
    ['nombre_empresa' => 'Tech Solutions Inc.'],
    [
        'usuario_id' => $user_empresa->id,
        'direccion' => 'Av. Tecnológica 500, Piso 10',
        'tipo_persona' => 'empresa',
    ]
);
echo "✓ Empresa: {$ur->nombre_empresa} (ID: {$ur->id})" . PHP_EOL;

// 5. Crear solicitud activa
$solicitud = Solicitud::firstOrCreate(
    [
        'estudiante_id' => $estudiante->id,
        'ur_id' => $ur->id,
    ],
    [
        'responsable' => 'Ing. María González',
        'fecha_inicio' => Carbon::now()->subDays(30),
        'fecha_fin' => Carbon::now()->addDays(60),
        'estatus' => 'en_proceso',
        'observaciones' => 'Práctica en desarrollo de software web',
    ]
);
echo "✓ Solicitud: ID {$solicitud->id} | Estatus: {$solicitud->estatus}" . PHP_EOL;

// 5.5 Crear convenios
$convenios_data = [
    ['codigo_convenio' => 'CONV-2026-001', 'fecha_inicio' => Carbon::now()->subDays(180), 'fecha_termino' => Carbon::now()->addDays(365)],
    ['codigo_convenio' => 'CONV-2026-002', 'fecha_inicio' => Carbon::now()->subDays(90), 'fecha_termino' => Carbon::now()->addDays(270)],
];

foreach ($convenios_data as $data) {
    if (!Convenio::where('ur_id', $ur->id)->where('codigo_convenio', $data['codigo_convenio'])->exists()) {
        Convenio::create([
            'ur_id' => $ur->id,
            'codigo_convenio' => $data['codigo_convenio'],
            'fecha_inicio' => $data['fecha_inicio'],
            'fecha_termino' => $data['fecha_termino'],
            'estatus' => 'activo',
        ]);
    }
}
echo "✓ Convenios: 2 convenios creados" . PHP_EOL;

// 6. Crear horas registradas
$horas_data = [
    ['cantidad_horas' => 8, 'fecha_registro' => Carbon::now()->subDays(20)],
    ['cantidad_horas' => 8, 'fecha_registro' => Carbon::now()->subDays(18)],
    ['cantidad_horas' => 8, 'fecha_registro' => Carbon::now()->subDays(15)],
    ['cantidad_horas' => 6, 'fecha_registro' => Carbon::now()->subDays(10)],
    ['cantidad_horas' => 8, 'fecha_registro' => Carbon::now()->subDays(5)],
    ['cantidad_horas' => 8, 'fecha_registro' => Carbon::now()->subDays(2)],
];

$total_horas = 0;
foreach ($horas_data as $data) {
    if (!Hora::where('solicitud_id', $solicitud->id)->where('fecha_registro', $data['fecha_registro'])->exists()) {
        Hora::create([
            'solicitud_id' => $solicitud->id,
            'cantidad_horas' => $data['cantidad_horas'],
            'fecha_registro' => $data['fecha_registro'],
            'descripcion' => 'Desarrollo de módulo de gestión',
        ]);
        $total_horas += $data['cantidad_horas'];
    }
}
echo "✓ Horas registradas: {$total_horas} horas (46 total)" . PHP_EOL;

// 7. Crear documentos
$docs = [
    ['nombre_doc' => 'Carta de Presentación', 'fecha_carga' => Carbon::now()->subDays(25)],
    ['nombre_doc' => 'Carta de Aceptación', 'fecha_carga' => Carbon::now()->subDays(24)],
    // Memoria de Prácticas: no cargada (pendiente)
    // Carta de Término: no cargada (pendiente)
];

foreach ($docs as $data) {
    if (!Documento::where('solicitud_id', $solicitud->id)->where('nombre_doc', $data['nombre_doc'])->exists()) {
        Documento::create([
            'solicitud_id' => $solicitud->id,
            'ur_id' => $ur->id,
            'nombre_doc' => $data['nombre_doc'],
            'fecha_carga' => $data['fecha_carga'],
            'ruta_archivo' => 'storage/uploads/' . strtolower(str_replace(' ', '_', $data['nombre_doc'])) . '.pdf',
        ]);
    }
}
echo "✓ Documentos: 2 subidos, 2 pendientes" . PHP_EOL;

echo PHP_EOL . "=== RESUMEN ===" . PHP_EOL;
echo "Credenciales de prueba:" . PHP_EOL;
echo "  Email: estudiante@test.com" . PHP_EOL;
echo "  Password: password123" . PHP_EOL;
echo PHP_EOL;
echo "Datos creados:" . PHP_EOL;
echo "  • Estudiante: $estudiante->nombre_completo" . PHP_EOL;
echo "  • Empresa: $ur->nombre_empresa" . PHP_EOL;
echo "  • Solicitud activa (en_proceso)" . PHP_EOL;
echo "  • 46 horas registradas" . PHP_EOL;
echo "  • 2 documentos subidos, 2 pendientes" . PHP_EOL;
echo PHP_EOL . "¡Listo! Inicia sesión con el usuario de prueba para ver el dashboard activo." . PHP_EOL;
?>
