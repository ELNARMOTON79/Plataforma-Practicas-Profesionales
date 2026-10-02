<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConvenioSeeder extends Seeder
{
    public function run(): void
    {
        $convenios = [
            [
                'id'              => 1,
                'ur_id'           => 4,
                'codigo_convenio' => 'CONV-2024-118',
                'fecha_inicio'    => '2024-11-24',
                'fecha_termino'   => '2026-11-24',
                'estatus'         => 'activo',
            ],
        ];

        foreach ($convenios as $c) {
            DB::table('convenios')->updateOrInsert(['id' => $c['id']], $c);
        }
    }
}
