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
        DB::statement("ALTER TABLE documentos MODIFY estatus VARCHAR(20) NOT NULL DEFAULT 'pendiente'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE documentos MODIFY estatus ENUM('pendiente', 'aprobado', 'rechazado') NOT NULL DEFAULT 'pendiente'");
    }
};
