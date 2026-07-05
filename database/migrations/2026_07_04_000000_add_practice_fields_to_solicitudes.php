<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('solicitudes', function (Blueprint $table) {
            $table->string('titulo')->nullable()->after('responsable');
            $table->text('objetivo')->nullable()->after('titulo');
            $table->text('justificacion')->nullable()->after('objetivo');
            $table->text('actividades')->nullable()->after('justificacion');
            $table->text('impacto_social')->nullable()->after('actividades');
        });
    }

    public function down(): void
    {
        Schema::table('solicitudes', function (Blueprint $table) {
            $table->dropColumn(['titulo', 'objetivo', 'justificacion', 'actividades', 'impacto_social']);
        });
    }
};
