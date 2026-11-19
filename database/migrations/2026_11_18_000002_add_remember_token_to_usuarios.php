<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Sin esta columna, iniciar sesión con "Recordarme" daba error 500
 * (Laravel guarda ahí el token de la cookie de recordar sesión).
 * También permite invalidar la sesión recordada en otros dispositivos
 * cuando el usuario cambia su contraseña.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('usuarios', 'remember_token')) {
            Schema::table('usuarios', function (Blueprint $table) {
                $table->rememberToken()->after('rol_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('usuarios', 'remember_token')) {
            Schema::table('usuarios', function (Blueprint $table) {
                $table->dropColumn('remember_token');
            });
        }
    }
};
