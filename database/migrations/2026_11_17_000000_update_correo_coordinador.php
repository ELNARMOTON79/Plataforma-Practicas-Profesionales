<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Point the coordinator account to the shared test Gmail inbox so
     * pending-validation notifications can be received in development.
     */
    public function up(): void
    {
        DB::table('usuarios')
            ->where('rol_id', 2)
            ->whereIn('correo', ['coordinador@ucol.mx', 'coordinadorpracticas.prueba@gmail.com'])
            ->update(['correo' => 'coordinadorpracticas.pruebas@gmail.com']);
    }

    public function down(): void
    {
        DB::table('usuarios')
            ->where('rol_id', 2)
            ->where('correo', 'coordinadorpracticas.pruebas@gmail.com')
            ->update(['correo' => 'coordinador@ucol.mx']);
    }
};
