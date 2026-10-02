<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * ============================================================
 *  DatabaseSeeder – Exportación completa de datos reales
 *  Generado el: 2026-10-01
 *
 *  Orden de ejecución (respeta llaves foráneas):
 *    1. roles
 *    2. usuarios
 *    3. personal
 *    4. estudiantes
 *    5. unidades_receptoras (empresas)
 *    6. convenios
 *    7. proyectos
 *    8. solicitudes
 *    9. documentos
 *   10. bitacora
 * ============================================================
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            PersonalSeeder::class,
            UnidadReceptoraSeeder::class,
            ConvenioSeeder::class,
            ProyectoSeeder::class,
            SolicitudSeeder::class,
            DocumentoSeeder::class,
            BitacoraSeeder::class,
        ]);
    }
}
