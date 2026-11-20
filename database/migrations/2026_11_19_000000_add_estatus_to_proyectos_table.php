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
        if (!Schema::hasColumn('proyectos', 'estatus')) {
            Schema::table('proyectos', function (Blueprint $table) {
                // Los proyectos que ya existen (registrados por el coordinador) quedan aprobados
                $table->enum('estatus', ['pendiente', 'aprobado', 'rechazado'])->default('aprobado')->after('activo');
                $table->text('observaciones')->nullable()->after('estatus');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('proyectos', 'estatus')) {
            Schema::table('proyectos', function (Blueprint $table) {
                $table->dropColumn(['estatus', 'observaciones']);
            });
        }
    }
};
