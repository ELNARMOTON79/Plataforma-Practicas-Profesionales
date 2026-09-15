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
        Schema::create('proyectos', function (Blueprint $table) {
            $table->increments('id'); // unsigned integer auto_increment primary key
            $table->integer('unidad_receptora_id')->unsigned();
            $table->string('titulo', 255);
            $table->text('objetivo');
            $table->text('justificacion');
            $table->text('actividades');
            $table->text('impacto_social');
            $table->string('tipo_proyecto', 150);
            $table->string('tipo_modalidad', 150);
            $table->string('plan', 50);
            $table->string('ciclo_escolar', 100);
            $table->tinyInteger('cupos_totales')->unsigned()->default(1);
            $table->tinyInteger('cupos_ocupados')->unsigned()->default(0);
            $table->enum('publico_internet', ['SI', 'NO'])->default('SI');
            $table->boolean('activo')->default(true);
            $table->timestamps();

            $table->foreign('unidad_receptora_id')
                  ->references('id')
                  ->on('unidades_receptoras')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyectos');
    }
};
