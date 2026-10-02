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
            ['id' => 26, 'correo' => 'gaguilar7@ucol.mx',      'contraseña' => '$2y$12$Eb4kpJiHOyzuwh7RmuSbDe7Zqg3fDKC3BcEm30eUNAWcbiI6UNr6G', 'activo' => 1, 'rol_id' => 3],
            ['id' => 27, 'correo' => 'lalaniz@ucol.mx',        'contraseña' => '$2y$12$qHTWR/FhKqKBSjP5U8Vku.2CH6XMPU7gN5zN/Xymh9Er7ukPhyhei', 'activo' => 1, 'rol_id' => 3],
            ['id' => 28, 'correo' => 'earcega@ucol.mx',        'contraseña' => '$2y$12$VDrvYHrCvxv37tnpsmsXX.wcb.fsxY//lZw0vXEdNEK0csiLU1oSK', 'activo' => 1, 'rol_id' => 3],
            ['id' => 29, 'correo' => 'acabrales@ucol.mx',      'contraseña' => '$2y$12$XoyzMcXVp9f15FMNAONfw.aF4vy7VLCAK1fDI6C/KMK1ICsZIDkq.', 'activo' => 1, 'rol_id' => 3],
            ['id' => 30, 'correo' => 'fcarmona0@ucol.mx',      'contraseña' => '$2y$12$nvtwSu803duGdlq/G9/DcOZkM3TKmiZ0wunV8MJ3qn0ZrI/JpUydK', 'activo' => 1, 'rol_id' => 3],
            ['id' => 31, 'correo' => 'gceja2@ucol.mx',         'contraseña' => '$2y$12$KSCDI89wXT.lDJYc1LC88eKFeUY./x96zwObnrSm662Iw09uJEnFO',  'activo' => 1, 'rol_id' => 3],
            ['id' => 32, 'correo' => 'dcruz0@ucol.mx',         'contraseña' => '$2y$12$V/k5AiwhXQgaTomQnUnVCOBfnVHsywLEQh4RPSiir5fEFj6AOoyJm',  'activo' => 1, 'rol_id' => 3],
            ['id' => 33, 'correo' => 'jdominguez13@ucol.mx',   'contraseña' => '$2y$12$mVIMwx.W7xYqtJ6cjnEIJ.O06/l3eZoP9KHpCmY8qKJY.LMnlRP4a', 'activo' => 1, 'rol_id' => 3],
            ['id' => 34, 'correo' => 'aelizaldi@ucol.mx',      'contraseña' => '$2y$12$AyxrDNFjNwSje5HI0E.QduTSzSaEtNgCgm/j8kohQfQU9aVvcMFaq',  'activo' => 1, 'rol_id' => 3],
            ['id' => 35, 'correo' => 'jenriquez0@ucol.mx',     'contraseña' => '$2y$12$fxqX59JeteWe35t.trd7PeuD3rSbC7eCUROtpTLfPPd2FSJmVkn02',  'activo' => 1, 'rol_id' => 3],
            ['id' => 36, 'correo' => 'efelix@ucol.mx',         'contraseña' => '$2y$12$8P4eC8P0yOkrRaAqR6gTsuDaBuoyBaMKbAV9czLI4LwSeLlZyXpDy',  'activo' => 1, 'rol_id' => 3],
            ['id' => 37, 'correo' => 'aflores59@ucol.mx',      'contraseña' => '$2y$12$FafotjCpaJzOyhrdaQ3As.mE6DUKCHyd7/c7ZjUoC6Z5/srSewcui',  'activo' => 1, 'rol_id' => 3],
            ['id' => 38, 'correo' => 'agonzalez156@ucol.mx',   'contraseña' => '$2y$12$wTB2B7ANIegAj6DNynxLRuwnesSAsfb0lkPtBm9r9/V1CUneInGRS',  'activo' => 1, 'rol_id' => 3],
            ['id' => 39, 'correo' => 'ggutierrez0@ucol.mx',    'contraseña' => '$2y$12$EX0dusSixR7QXrA5YN7Fi.WU6EcUTwh568wbrx0bGaRtr/9HjRYO6',  'activo' => 1, 'rol_id' => 3],
            ['id' => 40, 'correo' => 'hguzman2@ucol.mx',       'contraseña' => '$2y$12$HHMAeseLOB3ONN0KbUfdzullUNKro90xDJmLDZXPS8rbOGChY53Fe',  'activo' => 1, 'rol_id' => 3],
            ['id' => 41, 'correo' => 'mhuitron0@ucol.mx',      'contraseña' => '$2y$12$8ykOB3liVYat6ezk4aeRX.GNB5Hw4FgA2DCeqJv6XGq25e0Kj3KHO',  'activo' => 1, 'rol_id' => 3],
            ['id' => 42, 'correo' => 'vlarios10@ucol.mx',      'contraseña' => '$2y$12$RXVcm1ir3sPDf7yKmZ6IYO6JAG2Va0Y/4gAJOcDSS7/nxcEYxMd2S',  'activo' => 1, 'rol_id' => 3],
            ['id' => 43, 'correo' => 'bmedina1@ucol.mx',       'contraseña' => '$2y$12$nbrhvncB2VGxOUIQ5PfBxOWygyKXj8cC0kiE0EKJlkNOaWWX919FW',  'activo' => 1, 'rol_id' => 3],
            ['id' => 44, 'correo' => 'jrivera7@ucol.mx',       'contraseña' => '$2y$12$RHNht9yIQkswmAyKjIBtK.cxBYnwTluPgVv1hlia9vnhhUU9dm4Sq',  'activo' => 1, 'rol_id' => 3],
            ['id' => 46, 'correo' => 'mlarios23@ucol.mx',      'contraseña' => '$2y$12$HvUV/MmFakqowT4FqKkhQupghMstRBurJtYo/LfNZ7fDJ5GuWhSuS',  'activo' => 1, 'rol_id' => 3],
            ['id' => 47, 'correo' => 'rvuelvas@ucol.mx',       'contraseña' => '$2y$12$xXY4Rt.Ge29Xo.RF4guDdurJ8M6ogEoFZ6Rqatt3UvqElb6uPajxa',  'activo' => 1, 'rol_id' => 3],
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
            ['id' => 13, 'usuario_id' => 26, 'nombre_completo' => 'AGUILAR GUSTAVO SALVADOR',           'matricula' => '20202735', 'carrera' => 'Ingeniería de Software',         'semestre' => 6, 'grupo' => 'E', 'activo_practica' => 0, 'asesor' => null,              'coasesor' => null],
            ['id' => 14, 'usuario_id' => 27, 'nombre_completo' => 'ALANIZ MURGUIA LUIS ANGEL',          'matricula' => '20235947', 'carrera' => 'Ingeniería de Software',         'semestre' => 6, 'grupo' => 'E', 'activo_practica' => 0, 'asesor' => null,              'coasesor' => null],
            ['id' => 15, 'usuario_id' => 28, 'nombre_completo' => 'Arcega Rodriguez Eduardo',           'matricula' => '20236225', 'carrera' => 'Ingeniería de Software',         'semestre' => 6, 'grupo' => 'E', 'activo_practica' => 0, 'asesor' => null,              'coasesor' => null],
            ['id' => 16, 'usuario_id' => 29, 'nombre_completo' => 'CABRALES LÓPEZ ANNELISE NAJARA',     'matricula' => '20212407', 'carrera' => 'Ingeniería de Software',         'semestre' => 6, 'grupo' => 'E', 'activo_practica' => 0, 'asesor' => null,              'coasesor' => null],
            ['id' => 17, 'usuario_id' => 30, 'nombre_completo' => 'CARMONA CERNAS FLOR JAQUELINE',      'matricula' => '20200944', 'carrera' => 'Ingeniería de Software',         'semestre' => 6, 'grupo' => 'E', 'activo_practica' => 0, 'asesor' => null,              'coasesor' => null],
            ['id' => 18, 'usuario_id' => 31, 'nombre_completo' => 'CEJA AYALA GUSTAVO',                 'matricula' => '20202783', 'carrera' => 'Ingeniería de Software',         'semestre' => 6, 'grupo' => 'E', 'activo_practica' => 0, 'asesor' => null,              'coasesor' => null],
            ['id' => 19, 'usuario_id' => 32, 'nombre_completo' => 'CRUZ VILLANUEVA DANIEL',             'matricula' => '20192469', 'carrera' => 'Ingeniería de Software',         'semestre' => 6, 'grupo' => 'E', 'activo_practica' => 0, 'asesor' => null,              'coasesor' => null],
            ['id' => 20, 'usuario_id' => 33, 'nombre_completo' => 'DOMINGUEZ MARCOS JAZMIN',            'matricula' => '20206744', 'carrera' => 'Ingeniería de Software',         'semestre' => 6, 'grupo' => 'E', 'activo_practica' => 0, 'asesor' => null,              'coasesor' => null],
            ['id' => 21, 'usuario_id' => 34, 'nombre_completo' => 'Elizaldi Romero Alfredo',            'matricula' => '20235731', 'carrera' => 'Ingeniería de Software',         'semestre' => 6, 'grupo' => 'E', 'activo_practica' => 0, 'asesor' => null,              'coasesor' => null],
            ['id' => 22, 'usuario_id' => 35, 'nombre_completo' => 'ENRIQUEZ TINOCO JESUS ANTONIO',      'matricula' => '20201458', 'carrera' => 'Ingeniería de Software',         'semestre' => 6, 'grupo' => 'E', 'activo_practica' => 0, 'asesor' => null,              'coasesor' => null],
            ['id' => 23, 'usuario_id' => 36, 'nombre_completo' => 'FELIX CUEVAS EDSON LEONARDO',        'matricula' => '20191393', 'carrera' => 'Ingeniería de Software',         'semestre' => 6, 'grupo' => 'E', 'activo_practica' => 0, 'asesor' => null,              'coasesor' => null],
            ['id' => 24, 'usuario_id' => 37, 'nombre_completo' => 'Flores Lopez Adrian',                'matricula' => '20173360', 'carrera' => 'Ingeniería de Software',         'semestre' => 6, 'grupo' => 'E', 'activo_practica' => 0, 'asesor' => null,              'coasesor' => null],
            ['id' => 25, 'usuario_id' => 38, 'nombre_completo' => 'GONZALEZ GONZALEZ ALAN EDUARDO',     'matricula' => '20190990', 'carrera' => 'Ingeniería de Software',         'semestre' => 6, 'grupo' => 'E', 'activo_practica' => 0, 'asesor' => null,              'coasesor' => null],
            ['id' => 26, 'usuario_id' => 39, 'nombre_completo' => 'GUTIERREZ RUA GERARDO ADONAI',       'matricula' => '20151366', 'carrera' => 'Ingeniería de Software',         'semestre' => 6, 'grupo' => 'E', 'activo_practica' => 0, 'asesor' => null,              'coasesor' => null],
            ['id' => 27, 'usuario_id' => 40, 'nombre_completo' => 'GUZMAN MARQUEZ HEIDY SAMANTHA',      'matricula' => '20181243', 'carrera' => 'Ingeniería de Software',         'semestre' => 6, 'grupo' => 'E', 'activo_practica' => 0, 'asesor' => null,              'coasesor' => null],
            ['id' => 28, 'usuario_id' => 41, 'nombre_completo' => 'HUITRON VARELA MIGUEL ANGEL',        'matricula' => '20191410', 'carrera' => 'Ingeniería de Software',         'semestre' => 6, 'grupo' => 'E', 'activo_practica' => 0, 'asesor' => null,              'coasesor' => null],
            ['id' => 29, 'usuario_id' => 42, 'nombre_completo' => 'LARIOS ROSAS VICTOR JOSUE',          'matricula' => '20201026', 'carrera' => 'Ingeniería de Software',         'semestre' => 6, 'grupo' => 'E', 'activo_practica' => 0, 'asesor' => null,              'coasesor' => null],
            ['id' => 30, 'usuario_id' => 43, 'nombre_completo' => 'MEDINA LÓPEZ BRISA CRISTAL',         'matricula' => '20235846', 'carrera' => 'Ingeniería de Software',         'semestre' => 6, 'grupo' => 'E', 'activo_practica' => 0, 'asesor' => null,              'coasesor' => null],
            ['id' => 31, 'usuario_id' => 44, 'nombre_completo' => 'RIVERA MEZA JESUS GUADALUPE',        'matricula' => '20235867', 'carrera' => 'Ingeniería de Software',         'semestre' => 6, 'grupo' => 'E', 'activo_practica' => 0, 'asesor' => null,              'coasesor' => null],
            ['id' => 33, 'usuario_id' => 46, 'nombre_completo' => 'Larios de la Cruz Maria Jose',       'matricula' => '20226295', 'carrera' => 'Ingeniero en Mecatronica',       'semestre' => 8, 'grupo' => 'C', 'activo_practica' => 0, 'asesor' => null,              'coasesor' => null],
            ['id' => 34, 'usuario_id' => 47, 'nombre_completo' => 'Rafael Alexandro Vuelvas',           'matricula' => '20205120', 'carrera' => 'Ingeniería de Software',         'semestre' => 6, 'grupo' => 'E', 'activo_practica' => 0, 'asesor' => null,              'coasesor' => null],
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