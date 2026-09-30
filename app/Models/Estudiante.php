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
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function solicitudes(): HasMany
    {
        return $this->hasMany(Solicitud::class, 'estudiante_id');
    }

    /**
     * Required practice hours by program: Ingeniería de Software requires 600,
     * every other engineering program at the school requires 480.
     */
    public function horasMetaPractica(): int
    {
        return str_contains(mb_strtolower($this->carrera ?? ''), 'software') ? 600 : 480;
    }
}
