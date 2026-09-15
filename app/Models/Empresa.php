<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'unidades_receptoras';

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
