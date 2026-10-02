<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * NOTA: Los archivos físicos (PDFs) referenciados en ruta_archivo NO se copian
 * con el seeder. Tu compañera deberá copiar manualmente la carpeta
 * storage/app/public/documentos/ de tu máquina a la suya.
 */
class DocumentoSeeder extends Seeder
{
    public function run(): void
    {
        $documentos = [
            [
                'id'            => 1,
                'solicitud_id'  => 2,
                'ur_id'         => 4,
                'nombre_doc'    => 'Carta de Presentación',
                'ruta_archivo'  => 'documentos/estudiante_51/1790620666_carta-presentacion-prueba-estudiante.pdf',
                'fecha_carga'   => '2026-09-28',
                'estatus'       => 'pendiente',
                'observaciones' => null,
            ],
            [
                'id'            => 2,
                'solicitud_id'  => 3,
                'ur_id'         => 4,
                'nombre_doc'    => 'Carta de Presentación',
                'ruta_archivo'  => 'documentos/estudiante_52/1790896152_actividad-4.pdf',
                'fecha_carga'   => '2026-10-01',
                'estatus'       => 'rechazado',
                'observaciones' => 'Holaaaaaaa',
            ],
            [
                'id'            => 3,
                'solicitud_id'  => 3,
                'ur_id'         => 4,
                'nombre_doc'    => 'Carta de Aceptación',
                'ruta_archivo'  => 'documentos/estudiante_52/1790896264_puertos-de-red.pdf',
                'fecha_carga'   => '2026-10-01',
                'estatus'       => 'rechazado',
                'observaciones' => 'ola',
            ],
        ];

        foreach ($documentos as $d) {
            DB::table('documentos')->updateOrInsert(['id' => $d['id']], $d);
        }
    }
}
