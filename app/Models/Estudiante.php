<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estudiante extends Model
{
    protected $table = 'estudiantes';

    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'nombre_completo',
        'primer_nombre',
        'apellidos',
        'matricula',
        'carrera',
        'semestre',
        'grupo',
        'direccion',
        'telefono',
        'asesor',
        'coasesor',
        // Sin esto, TramiteController::aprobarSolicitud no podía marcar al alumno como activo
        'activo_practica',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function solicitudes(): HasMany
    {
        return $this->hasMany(Solicitud::class, 'estudiante_id');
    }

    /** Horas de práctica que exige Ingeniería de Software. */
    public const HORAS_META_SOFTWARE = 640;

    /** Horas de práctica que exigen las demás ingenierías de la facultad. */
    public const HORAS_META_GENERAL = 480;

    /**
     * Horas de práctica requeridas según la carrera del alumno.
     */
    public function horasMetaPractica(): int
    {
        return str_contains(mb_strtolower($this->carrera ?? ''), 'software')
            ? self::HORAS_META_SOFTWARE
            : self::HORAS_META_GENERAL;
    }

    /**
     * Practice modality by program: Ingeniería de Software and Ingeniería Mecánico
     * Electricista do an "estancia profesional", every other program a "práctica profesional".
     */
    public function modalidadPractica(): string
    {
        $carrera = mb_strtolower($this->carrera ?? '');

        return str_contains($carrera, 'software') || str_contains($carrera, 'electricista')
            ? 'estancia_profesional'
            : 'practica_integrativa';
    }
}
