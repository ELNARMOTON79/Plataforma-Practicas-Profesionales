<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'estudiantes';

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Get dynamic status of the student.
     */
    public function getEstatusAttribute()
    {
        // Cuenta deshabilitada
        if (!$this->user || !$this->user->activo) {
            return 'INACTIVO';
        }

        // Práctica formalmente aprobada
        if ($this->activo_practica == 1) {
            return 'ACTIVO';
        }

        $solicitud = \DB::table('solicitudes')
            ->where('estudiante_id', $this->id)
            ->orderBy('id', 'desc')
            ->first();

        // Tiene solicitud aprobada/en proceso → también ACTIVO
        if ($solicitud && in_array($solicitud->estatus, ['aprobada', 'en_proceso', 'finalizada'])) {
            return 'ACTIVO';
        }

        // Tiene solicitud enviada pero aún sin respuesta
        if ($solicitud && $solicitud->estatus === 'pendiente') {
            return 'PENDIENTE';
        }

        // Sin ninguna solicitud enviada
        return 'INACTIVO';
    }

    /**
     * Get dynamic gender of the student based on common female name patterns.
     */
    public function getSexoAttribute()
    {
        $nombreLimpio = $this->nombre_completo;
        // Normalization mapping to remove accents
        $unwanted_array = array(
            'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C',
            'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
            'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a',
            'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i',
            'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'á'=>'a', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
            'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y'
        );
        $nombreNormalized = strtr($nombreLimpio, $unwanted_array);
        $words = explode(' ', strtoupper($nombreNormalized));

        $femeninos = [
            'MARIA', 'ESTEFANY', 'ESTEFANIA', 'ANA', 'LUISA', 'SOFIA', 'GABRIELA', 'LAURA', 'DIANA', 
            'JESSICA', 'JAZMIN', 'VALERIA', 'MONSERRAT', 'KARLA', 'CLAUDIA', 'PATRICIA', 'LETICIA', 
            'BEATRIZ', 'ROSA', 'CARMEN', 'TERESA', 'GUADALUPE', 'ISABEL', 'JUANA', 'ANDREA', 'PAOLA', 
            'ESTHEFANY', 'YULIANA', 'MARIELA', 'ALEJANDRA', 'DANIELA', 'FERNANDA', 'XIMENA', 'BRENDA', 
            'KARINA', 'ELIZABETH', 'ANNELISE', 'NAJARA', 'FLOR', 'JAQUELINE', 'HEIDY', 'SAMANTHA',
            'BRISA', 'CRISTAL'
        ];

        foreach ($words as $word) {
            $wordClean = trim($word);
            if (in_array($wordClean, $femeninos)) {
                return 'FEMENINO';
            }
        }
        return 'MASCULINO';
    }

    /**
     * Get premium color classes for each status.
     */
    public function getEstatusClassAttribute()
    {
        $estatus = $this->estatus;
        if ($estatus === 'ACTIVO') {
            return 'bg-green-50 text-green-700 border-green-200';
        } elseif ($estatus === 'PENDIENTE') {
            return 'bg-yellow-50 text-yellow-700 border-yellow-200';
        } else {
            // INACTIVO
            return 'bg-red-50 text-red-700 border-red-200';
        }
    }
}

