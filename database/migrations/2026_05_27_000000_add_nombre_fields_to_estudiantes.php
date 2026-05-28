<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            if (!Schema::hasColumn('estudiantes', 'primer_nombre')) {
                $table->string('primer_nombre', 150)->nullable()->after('nombre_completo');
            }
            if (!Schema::hasColumn('estudiantes', 'apellidos')) {
                $table->string('apellidos', 150)->nullable()->after('primer_nombre');
            }
        });
    }

    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            if (Schema::hasColumn('estudiantes', 'apellidos')) {
                $table->dropColumn('apellidos');
            }
            if (Schema::hasColumn('estudiantes', 'primer_nombre')) {
                $table->dropColumn('primer_nombre');
            }
        });
    }
};
