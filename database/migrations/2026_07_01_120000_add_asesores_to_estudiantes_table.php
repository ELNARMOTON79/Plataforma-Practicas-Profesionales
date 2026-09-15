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
        Schema::table('estudiantes', function (Blueprint $table) {
            if (!Schema::hasColumn('estudiantes', 'asesor')) {
                $table->string('asesor', 255)->nullable()->after('activo_practica');
            }
            if (!Schema::hasColumn('estudiantes', 'coasesor')) {
                $table->string('coasesor', 255)->nullable()->after('asesor');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->dropColumn(['asesor', 'coasesor']);
        });
    }
};
