<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['id' => 1, 'nombre_rol' => 'Administrador'],
            ['id' => 2, 'nombre_rol' => 'Personal'],
            ['id' => 3, 'nombre_rol' => 'Estudiante'],
            ['id' => 4, 'nombre_rol' => 'Empresa'],
        ];

        foreach ($roles as $rol) {
            DB::table('roles')->updateOrInsert(['id' => $rol['id']], $rol);
        }
    }
}
