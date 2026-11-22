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

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Solicitud más reciente del alumno (mayor id). Cárgala con with('ultimaSolicitud')
     * en los listados para no hacer una consulta por alumno.
     */
    public function ultimaSolicitud()
    {
        return $this->hasOne(Solicitud::class, 'estudiante_id')->latestOfMany('id');
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

        $solicitud = $this->ultimaSolicitud;

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
     * Get the student's gender.
     * Uses the stored 'sexo' column if present; falls back to name-based detection for legacy records.
     */
    public function getSexoAttribute()
    {
        // Use real stored value if available
        if (!empty($this->attributes['sexo'])) {
            return strtoupper($this->attributes['sexo']);
        }

        // Fallback: guess from first name for records registered before this column existed
        $nombreLimpio = $this->nombre_completo ?? '';
        $unwanted_array = [
            'Á'=>'A','É'=>'E','Í'=>'I','Ó'=>'O','Ú'=>'U','Ü'=>'U','Ñ'=>'N',
            'á'=>'a','é'=>'e','í'=>'i','ó'=>'o','ú'=>'u','ü'=>'u','ñ'=>'n',
        ];
        $nombreNormalized = strtr($nombreLimpio, $unwanted_array);
        $words = explode(' ', strtoupper($nombreNormalized));

        $femeninos = [
            'MARIA','ESTEFANY','ESTEFANIA','ANA','LUISA','SOFIA','GABRIELA','LAURA','DIANA',
            'JESSICA','JAZMIN','VALERIA','MONSERRAT','KARLA','CLAUDIA','PATRICIA','LETICIA',
            'BEATRIZ','ROSA','CARMEN','TERESA','GUADALUPE','ISABEL','JUANA','ANDREA','PAOLA',
            'ESTHEFANY','YULIANA','MARIELA','ALEJANDRA','DANIELA','FERNANDA','XIMENA','BRENDA',
            'KARINA','ELIZABETH','ANNELISE','NAJARA','FLOR','JAQUELINE','HEIDY','SAMANTHA',
            'BRISA','CRISTAL',
        ];

        foreach ($words as $word) {
            if (in_array(trim($word), $femeninos)) {
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

