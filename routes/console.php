<?php

use App\Models\Documento;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
 * Mueve los archivos de documentos que quedaron en el disco público (accesibles por URL
 * sin iniciar sesión) al disco privado. Ejecutar una vez: php artisan documentos:privatizar
 */
Artisan::command('documentos:privatizar', function () {
    $publico = Storage::disk(Documento::DISCO_LEGADO);
    $privado = Storage::disk(Documento::DISCO);
    $movidos = 0;
    $faltantes = 0;

    Documento::query()->whereNotNull('ruta_archivo')->orderBy('id')->each(function (Documento $documento) use ($publico, $privado, &$movidos, &$faltantes) {
        $ruta = $documento->ruta_archivo;

        if ($privado->exists($ruta)) {
            if ($publico->exists($ruta)) {
                $publico->delete($ruta);
            }
            return;
        }

        if (! $publico->exists($ruta)) {
            $faltantes++;
            $this->warn("Documento #{$documento->id}: no se encontró el archivo {$ruta}");
            return;
        }

        $privado->writeStream($ruta, $publico->readStream($ruta));
        $publico->delete($ruta);
        $movidos++;
    });

    $this->info("Archivos movidos al disco privado: {$movidos}. No encontrados: {$faltantes}.");
})->purpose('Mueve los documentos de estudiantes del disco público al privado');
