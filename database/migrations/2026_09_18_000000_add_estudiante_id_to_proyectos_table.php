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
        if (!Schema::hasColumn('proyectos', 'estudiante_id')) {
            Schema::table('proyectos', function (Blueprint $table) {
                $table->integer('estudiante_id')->unsigned()->nullable()->after('unidad_receptora_id');
                $table->foreign('estudiante_id')
                      ->references('id')
                      ->on('estudiantes')
                      ->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('proyectos', 'estudiante_id')) {
            Schema::table('proyectos', function (Blueprint $table) {
                $table->dropForeign(['estudiante_id']);
                $table->dropColumn('estudiante_id');
            });
        }
    }
};
