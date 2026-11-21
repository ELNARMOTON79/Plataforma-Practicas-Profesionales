<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // En una instalación nueva el esquema completo puede no tener el índice viejo o ya traer el nuevo
        Schema::table('convenios', function (Blueprint $table) {
            if (Schema::hasIndex('convenios', 'codigo_convenio')) {
                $table->dropUnique('codigo_convenio');
            }
            if (! Schema::hasIndex('convenios', 'convenios_codigo_ur_unique')) {
                $table->unique(['codigo_convenio', 'ur_id'], 'convenios_codigo_ur_unique');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('convenios', function (Blueprint $table) {
            $table->dropUnique('convenios_codigo_ur_unique');
            $table->unique('codigo_convenio');
        });
    }
};
