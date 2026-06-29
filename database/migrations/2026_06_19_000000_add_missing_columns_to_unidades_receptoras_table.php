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
        Schema::table('unidades_receptoras', function (Blueprint $table) {
            if (!Schema::hasColumn('unidades_receptoras', 'sistema')) {
                $table->string('sistema', 50)->nullable()->after('tipo_persona');
            }
            if (!Schema::hasColumn('unidades_receptoras', 'sector')) {
                $table->string('sector', 50)->nullable()->after('sistema');
            }
            if (!Schema::hasColumn('unidades_receptoras', 'unidad_receptora')) {
                $table->string('unidad_receptora', 100)->nullable()->after('sector');
            }
            if (!Schema::hasColumn('unidades_receptoras', 'titular')) {
                $table->string('titular', 100)->nullable()->after('unidad_receptora');
            }
            if (!Schema::hasColumn('unidades_receptoras', 'cargo')) {
                $table->string('cargo', 100)->nullable()->after('titular');
            }
            if (!Schema::hasColumn('unidades_receptoras', 'colonia')) {
                $table->string('colonia', 50)->nullable()->after('cargo');
            }
            if (!Schema::hasColumn('unidades_receptoras', 'cp')) {
                $table->integer('cp')->nullable()->after('colonia');
            }
            if (!Schema::hasColumn('unidades_receptoras', 'estado')) {
                $table->string('estado', 20)->nullable()->after('cp');
            }
            if (!Schema::hasColumn('unidades_receptoras', 'municipio')) {
                $table->string('municipio', 100)->nullable()->after('estado');
            }
            if (!Schema::hasColumn('unidades_receptoras', 'telefono')) {
                $table->string('telefono', 50)->nullable()->after('municipio');
            }
            if (!Schema::hasColumn('unidades_receptoras', 'convenio')) {
                $table->string('convenio', 50)->nullable()->after('telefono');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unidades_receptoras', function (Blueprint $table) {
            $columns = [
                'sistema',
                'sector',
                'unidad_receptora',
                'titular',
                'cargo',
                'colonia',
                'cp',
                'estado',
                'municipio',
                'telefono',
                'convenio',
            ];
            foreach ($columns as $column) {
                if (Schema::hasColumn('unidades_receptoras', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
