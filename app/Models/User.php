<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['correo', 'contraseña', 'activo', 'rol_id'])]
#[Hidden(['contraseña'])]
class User extends Authenticatable
{
    use Notifiable;

    // 1. Apuntar a tu tabla real
    protected $table = 'usuarios';

    // 2. Desactivar timestamps porque tu tabla no tiene created_at ni updated_at
    public $timestamps = false;

    // 3. Indicarle a Laravel cuál es la columna de la contraseña
    public function getAuthPasswordName()
    {
        return 'contraseña';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // Laravel necesita saber que tu campo contraseña está encriptado con un Hash
            'contraseña' => 'hashed',
            'activo' => 'boolean',
            // Las comparaciones estrictas (rol_id !== 1) dependen de que sea entero
            'rol_id' => 'integer',
        ];
    }

    public function alumno()
    {
        return $this->hasOne(Alumno::class, 'usuario_id');
    }

    public function coordinador()
    {
        return $this->hasOne(Coordinador::class, 'usuario_id');
    }

    public function empresa()
    {
        return $this->hasOne(Empresa::class, 'usuario_id');
    }

    public function estudiante(): HasOne
    {
        return $this->hasOne(Estudiante::class, 'usuario_id');
    }
}
