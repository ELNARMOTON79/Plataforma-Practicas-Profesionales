<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Índices para las consultas más frecuentes:
 * - bitacora: siempre se ordena por timestamp (dashboard, listado, exportación) y se cuenta por nivel.
 * - solicitudes y documentos: casi todos los conteos y listados filtran por estatus.
 */
return new class extends Migration
{
    private array $indices = [
        'bitacora' => [
            'bitacora_timestamp_index' => ['timestamp'],
            'bitacora_level_index' => ['level'],
        ],
        'solicitudes' => [
            'solicitudes_estatus_index' => ['estatus'],
        ],
        'documentos' => [
            'documentos_estatus_index' => ['estatus'],
        ],
    ];

    public function up(): void
    {
        foreach ($this->indices as $tabla => $indices) {
            foreach ($indices as $nombre => $columnas) {
                if (! Schema::hasIndex($tabla, $nombre)) {
                    Schema::table($tabla, fn (Blueprint $table) => $table->index($columnas, $nombre));
                }
            }
        }
    }

    public function down(): void
    {
        foreach ($this->indices as $tabla => $indices) {
            foreach (array_keys($indices) as $nombre) {
                if (Schema::hasIndex($tabla, $nombre)) {
                    Schema::table($tabla, fn (Blueprint $table) => $table->dropIndex($nombre));
                }
            }
        }
    }
};
