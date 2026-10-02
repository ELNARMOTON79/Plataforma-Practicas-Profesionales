<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonalSeeder extends Seeder
{
    public function run(): void
    {
        $personal = [
            ['id' => 1, 'usuario_id' => 1, 'nombre_completo' => 'Administrador General'],
            ['id' => 2, 'usuario_id' => 2, 'nombre_completo' => 'Coordinador de Prácticas Profesionales'],
        ];

        foreach ($personal as $p) {
            DB::table('personal')->updateOrInsert(['id' => $p['id']], $p);
        }
    }
}
