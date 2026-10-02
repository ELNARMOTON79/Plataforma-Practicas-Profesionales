<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SolicitudSeeder extends Seeder
{
    public function run(): void
    {
        $solicitudes = [
            [
                'id'            => 1,
                'estudiante_id' => 35,
                'ur_id'         => 4,
                'responsable'   => 'Arq. Patricia Orozco Vega',
                'fecha_inicio'  => '2026-09-17',
                'fecha_fin'     => '2027-02-15',
                'estatus'       => 'pendiente',
                'observaciones' => 'Area de TI, Desarrollo de pagina web.',
            ],
            [
                'id'            => 2,
                'estudiante_id' => 37,
                'ur_id'         => 4,
                'responsable'   => 'Lic. Jimena Lopez',
                'fecha_inicio'  => '2026-09-16',
                'fecha_fin'     => '2027-03-16',
                'estatus'       => 'aprobada',
                'observaciones' => 'Recuerda traer tu documento del proyecto.',
            ],
            [
                'id'            => 3,
                'estudiante_id' => 38,
                'ur_id'         => 4,
                'responsable'   => 'Ing. Martin Pérez',
                'fecha_inicio'  => '2026-10-13',
                'fecha_fin'     => '2027-06-13',
                'estatus'       => 'aprobada',
                'observaciones' => 'No olvides subir tus documentos',
            ],
        ];

        foreach ($solicitudes as $s) {
            DB::table('solicitudes')->updateOrInsert(['id' => $s['id']], $s);
        }
    }
}
