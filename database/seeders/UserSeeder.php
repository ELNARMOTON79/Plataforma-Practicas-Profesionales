<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Inserta TODOS los usuarios y sus registros de estudiante reales.
 * Las contraseñas están almacenadas como bcrypt (ya hasheadas).
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        // =============================================
        // 1. TABLA: usuarios
        // =============================================
        $usuarios = [
            ['id' => 1,  'correo' => 'admin@ucol.mx',          'contraseña' => '$2y$12$uQZVFfo0wAWgFcIK5gDusu0W1GBNq.lb6jyw//ygqNFoGZzTtGUoe', 'activo' => 1, 'rol_id' => 1],
            ['id' => 2,  'correo' => 'coordinador@ucol.mx',    'contraseña' => '$2y$12$nD/o.O4bptqTBby1KCqCyOorkqXz8aQ5WuqlALMk5.AAoaD2moY7S', 'activo' => 1, 'rol_id' => 2],
            ['id' => 3,  'correo' => 'alumno@ucol.mx',         'contraseña' => '$2y$12$cm5JoZ341msAnEIhlv5Ul.WUo0YtE0k9UqJfJWKrnZ8QcMHxNq.ni', 'activo' => 1, 'rol_id' => 3],
            ['id' => 5,  'correo' => 'empresa@tech.com',       'contraseña' => '$2y$12$hkvQRP.AXOiWektGtN426.cnXOZxpodLvBYGuEJnOVD2uKNC5TRLe', 'activo' => 1, 'rol_id' => 4],
            ['id' => 48, 'correo' => 'estudiante@test.com',    'contraseña' => '$2y$12$syG9iXSPkHLoZb6IhrpYrudgOWFUzSHKdyHIBlIbm.c3Sz2jCEB.q',  'activo' => 1, 'rol_id' => 3],
            ['id' => 49, 'correo' => 'mindguez98@gmail.com',   'contraseña' => '$2y$12$zuknuyvoi/jK4Zkwl/x12OjfLljGK91dqeKpJ99E1v5siKq8bIr.i',  'activo' => 1, 'rol_id' => 3],
            ['id' => 50, 'correo' => 'estefani@ucol.mx',       'contraseña' => '$2y$12$9KFw0UljaMMb70Q0YFORrOSsUOBZa3bQxLnAlJ5WBwYjWK5iEEW7.',  'activo' => 1, 'rol_id' => 3],
            ['id' => 51, 'correo' => 'whosdep@gmail.com',      'contraseña' => '$2y$12$AK1R8jZkQ7cBhebpH9rHOuVsVZq4210MK119Vc0Z5Wmlhr0/WSubS',  'activo' => 1, 'rol_id' => 3],
            ['id' => 52, 'correo' => 'heidygm131202@gmail.com','contraseña' => '$2y$12$AK1R8jZkQ7cBhebpH9rHOuVsVZq4210MK119Vc0Z5Wmlhr0/WSubS',  'activo' => 1, 'rol_id' => 3],
        ];

        foreach ($usuarios as $u) {
            DB::table('usuarios')->updateOrInsert(
                ['id' => $u['id']],
                ['correo' => $u['correo'], 'contraseña' => $u['contraseña'], 'activo' => $u['activo'], 'rol_id' => $u['rol_id']]
            );
        }

        // =============================================
        // 2. TABLA: estudiantes
        // =============================================
        $estudiantes = [

            ['id' => 35, 'usuario_id' => 49, 'nombre_completo' => 'Estudiante Prueba',                  'matricula' => '20216744', 'carrera' => 'Ingeniería de Software',         'semestre' => 7, 'grupo' => 'E', 'activo_practica' => 0, 'asesor' => 'Dr. Juan Carlos', 'coasesor' => 'Mtr. Ana maría'],
            ['id' => 36, 'usuario_id' => 50, 'nombre_completo' => 'Estefania Ramirez',                  'matricula' => '19285633', 'carrera' => 'Ingeniería Mecánico Electricista','semestre' => 8, 'grupo' => 'B', 'activo_practica' => 0, 'asesor' => 'dfsdfsgasdgd',  'coasesor' => 'dsagddddd'],
            ['id' => 37, 'usuario_id' => 51, 'nombre_completo' => 'Prueba Estudiante',                  'matricula' => '23456789', 'carrera' => 'Ingeniería en Tecnologías Electrónicas', 'semestre' => 10,'grupo' => 'C', 'activo_practica' => 0, 'asesor' => 'Dr. Rosario Salasar', 'coasesor' => null],
            ['id' => 38, 'usuario_id' => 52, 'nombre_completo' => 'Prueba Heidy Gonzalez',              'matricula' => '20204321', 'carrera' => 'Ingeniería Mecánico Electricista', 'semestre' => 9, 'grupo' => 'C', 'activo_practica' => 0, 'asesor' => 'Dr. Miguel Rodriguez', 'coasesor' => null],
        ];

        foreach ($estudiantes as $e) {
            DB::table('estudiantes')->updateOrInsert(
                ['id' => $e['id']],
                [
                    'usuario_id'      => $e['usuario_id'],
                    'nombre_completo' => $e['nombre_completo'],
                    'primer_nombre'   => null,
                    'apellidos'       => null,
                    'matricula'       => $e['matricula'],
                    'carrera'         => $e['carrera'],
                    'semestre'        => $e['semestre'],
                    'grupo'           => $e['grupo'],
                    'direccion'       => null,
                    'telefono'        => null,
                    'activo_practica' => $e['activo_practica'],
                    'asesor'          => $e['asesor'],
                    'coasesor'        => $e['coasesor'],
                ]
            );
        }
    }
}