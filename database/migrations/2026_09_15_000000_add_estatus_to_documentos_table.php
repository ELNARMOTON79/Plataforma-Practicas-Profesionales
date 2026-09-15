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
        Schema::table('documentos', function (Blueprint $table) {
            if (! Schema::hasColumn('documentos', 'estatus')) {
                $table->string('estatus', 20)->default('pendiente')->after('fecha_carga');
            }
            if (! Schema::hasColumn('documentos', 'observaciones')) {
                $table->text('observaciones')->nullable()->after('estatus');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documentos', function (Blueprint $table) {
            $columns = ['estatus', 'observaciones'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('documentos', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
