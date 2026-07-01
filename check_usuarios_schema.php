<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

$db = \Illuminate\Support\Facades\DB::connection()->getPdo();
$result = $db->query('DESCRIBE usuarios');
$columns = $result->fetchAll(\PDO::FETCH_ASSOC);

echo "=== ESTRUCTURA TABLA usuarios ===" . PHP_EOL;
foreach ($columns as $col) {
    echo $col['Field'] . " | " . $col['Type'] . PHP_EOL;
}
?>
