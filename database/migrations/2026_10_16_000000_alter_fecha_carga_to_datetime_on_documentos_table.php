<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE documentos MODIFY fecha_carga DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP");

        // Actualizar documentos que se hayan cargado hoy con hora 00:00:00 a la hora actual
        DB::statement("UPDATE documentos SET fecha_carga = NOW() WHERE DATE(fecha_carga) = CURDATE() AND TIME(fecha_carga) = '00:00:00'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE documentos MODIFY fecha_carga DATE NOT NULL DEFAULT (CURRENT_DATE)");
    }
};
