<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadReceptoraSeeder extends Seeder
{
    public function run(): void
    {
        $unidades = [
            [
                'id'               => 4,
                'usuario_id'       => 5,
                'nombre_empresa'   => 'Tech Solutions S.A. de C.V.',
                'direccion'        => 'Av. Universidad 333',
                'tipo_persona'     => 'Moral',
                'sistema'          => 'PRIVADA',
                'sector'           => 'PRIVADO',
                'unidad_receptora' => 'Departamento de Sistemas',
                'titular'          => 'Lic. Martín Corona V.',
                'cargo'            => 'Representante Legal',
                'colonia'          => 'Las Víboras',
                'cp'               => 28040,
                'estado'           => 'Colima',
                'municipio'        => 'Colima',
                'telefono'         => '312-316-1234',
                'convenio'         => 'CONV-2024-118',
            ],
            [
                'id'               => 6,
                'usuario_id'       => 5,
                'nombre_empresa'   => 'Tech Solutions S.A. de C.V.',
                'direccion'        => 'Av. Universidad 333',
                'tipo_persona'     => 'Moral',
                'sistema'          => 'PRIVADA',
                'sector'           => 'PRIVADO',
                'unidad_receptora' => 'Departamento de Marketing',
                'titular'          => 'Lic. Jimena Lopez',
                'cargo'            => 'Directora General de Marketing',
                'colonia'          => 'Las Víboras',
                'cp'               => 28040,
                'estado'           => 'Colima',
                'municipio'        => 'Colima',
                'telefono'         => '312-316-1234',
                'convenio'         => 'CONV-2024-118',
            ],
        ];

        foreach ($unidades as $u) {
            DB::table('unidades_receptoras')->updateOrInsert(['id' => $u['id']], $u);
        }
    }
}
