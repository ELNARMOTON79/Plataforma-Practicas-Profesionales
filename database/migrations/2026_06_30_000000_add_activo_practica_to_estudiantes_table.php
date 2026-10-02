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
        if (Schema::hasColumn('estudiantes', 'activo_practica')) {
            return;
        }

        Schema::table('estudiantes', function (Blueprint $table) {
            $table->boolean('activo_practica')->default(false)->after('telefono');
        });

        // Students whose solicitud was already approved are active in practices
        // (same flag TramiteController::aprobarSolicitud sets).
        DB::table('estudiantes')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('solicitudes')
                      ->whereColumn('solicitudes.estudiante_id', 'estudiantes.id')
                      ->whereIn('solicitudes.estatus', ['aprobada', 'en_proceso', 'finalizada']);
            })
            ->update(['activo_practica' => 1]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            if (Schema::hasColumn('estudiantes', 'activo_practica')) {
                $table->dropColumn('activo_practica');
            }
        });
    }
};
