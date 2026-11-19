<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Algunas bases de datos quedaron con columnas opcionales como NOT NULL (y
 * solicitudes.observaciones como varchar(50)), distinto al esquema documentado.
 * Con STRICT_TRANS_TABLES eso provoca error 500 al enviar una solicitud sin
 * observaciones o al crear una empresa sin todos los datos de contacto.
 * Esta migración solo amplía/relaja columnas; no elimina datos.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('solicitudes', function (Blueprint $table) {
            $table->text('observaciones')->nullable()->change();
        });

        Schema::table('unidades_receptoras', function (Blueprint $table) {
            $table->string('sistema', 50)->nullable()->change();
            $table->string('sector', 50)->nullable()->change();
            $table->string('unidad_receptora', 100)->nullable()->change();
            $table->string('titular', 100)->nullable()->change();
            $table->string('cargo', 100)->nullable()->change();
            $table->string('colonia', 50)->nullable()->change();
            $table->integer('cp')->nullable()->change();
            $table->string('estado', 20)->nullable()->change();
            $table->string('municipio', 100)->nullable()->change();
            $table->string('telefono', 50)->nullable()->change();
            $table->string('convenio', 50)->nullable()->change();
        });
    }

    public function down(): void
    {
        // Sin reversa: volver a NOT NULL reintroduciría los errores.
    }
};
