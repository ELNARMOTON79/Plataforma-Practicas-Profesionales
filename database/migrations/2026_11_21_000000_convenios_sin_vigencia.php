<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Los convenios ya no tienen vigencia: si el coordinador registra la institución, su convenio
 * queda aprobado sin fecha de inicio ni de término.
 * Además se crea el convenio de las empresas registradas que aún no tenían uno, para que
 * aparezcan en la sección de Convenios del alumno.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('convenios', function (Blueprint $table) {
            $table->date('fecha_inicio')->nullable()->change();
            $table->date('fecha_termino')->nullable()->change();
            $table->enum('estatus', ['activo', 'inactivo', 'pendiente'])->default('activo')->change();
        });

        // Un convenio por empresa (cuenta de usuario), ligado a su primera unidad receptora
        $empresasSinConvenio = DB::table('unidades_receptoras as ur')
            ->selectRaw('ur.usuario_id, MIN(ur.id) as ur_id')
            ->whereNotNull('ur.usuario_id')
            ->whereNotExists(function ($q) {
                $q->select(DB::raw(1))
                    ->from('convenios as c')
                    ->join('unidades_receptoras as u2', 'u2.id', '=', 'c.ur_id')
                    ->whereColumn('u2.usuario_id', 'ur.usuario_id');
            })
            ->groupBy('ur.usuario_id')
            ->get();

        foreach ($empresasSinConvenio as $empresa) {
            DB::table('convenios')->insert([
                'ur_id' => $empresa->ur_id,
                'codigo_convenio' => 'CONV-' . now()->year . '-' . $empresa->ur_id,
                'fecha_inicio' => null,
                'fecha_termino' => null,
                'estatus' => 'activo',
            ]);
        }
    }

    public function down(): void
    {
        // Las columnas de fecha vuelven a ser obligatorias: los convenios sin fechas se eliminan
        DB::table('convenios')->whereNull('fecha_inicio')->orWhereNull('fecha_termino')->delete();

        Schema::table('convenios', function (Blueprint $table) {
            $table->date('fecha_inicio')->nullable(false)->change();
            $table->date('fecha_termino')->nullable(false)->change();
            $table->enum('estatus', ['activo', 'inactivo', 'pendiente'])->default('pendiente')->change();
        });
    }
};
