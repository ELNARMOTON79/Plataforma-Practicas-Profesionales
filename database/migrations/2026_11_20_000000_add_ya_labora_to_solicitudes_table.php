<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Alumnos que ya trabajan en la empresa: las fechas y horas las define la empresa después
        if (!Schema::hasColumn('solicitudes', 'ya_labora')) {
            Schema::table('solicitudes', function (Blueprint $table) {
                $table->boolean('ya_labora')->default(false)->after('modalidad');
            });
        }

        DB::statement('ALTER TABLE solicitudes MODIFY fecha_inicio DATE NULL');
        DB::statement('ALTER TABLE solicitudes MODIFY fecha_fin DATE NULL');

        if (!Schema::hasColumn('proyectos', 'documento_ruta')) {
            Schema::table('proyectos', function (Blueprint $table) {
                $table->string('documento_ruta', 500)->nullable()->after('observaciones');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('proyectos', 'documento_ruta')) {
            Schema::table('proyectos', function (Blueprint $table) {
                $table->dropColumn('documento_ruta');
            });
        }

        DB::statement('UPDATE solicitudes SET fecha_inicio = CURDATE() WHERE fecha_inicio IS NULL');
        DB::statement('UPDATE solicitudes SET fecha_fin = CURDATE() WHERE fecha_fin IS NULL');
        DB::statement('ALTER TABLE solicitudes MODIFY fecha_inicio DATE NOT NULL');
        DB::statement('ALTER TABLE solicitudes MODIFY fecha_fin DATE NOT NULL');

        if (Schema::hasColumn('solicitudes', 'ya_labora')) {
            Schema::table('solicitudes', function (Blueprint $table) {
                $table->dropColumn('ya_labora');
            });
        }
    }
};
