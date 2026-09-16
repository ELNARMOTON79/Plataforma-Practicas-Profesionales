<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

$db = \Illuminate\Support\Facades\DB::connection()->getPdo();
$result = $db->query('DESCRIBE convenios');
$columns = $result->fetchAll(\PDO::FETCH_ASSOC);

echo "=== ESTRUCTURA TABLA convenios ===" . PHP_EOL;
foreach ($columns as $col) {
    echo $col['Field'] . " | " . $col['Type'] . " | Null: " . $col['Null'] . " | Default: " . $col['Default'] . PHP_EOL;
}
?>
