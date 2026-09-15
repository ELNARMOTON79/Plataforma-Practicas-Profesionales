<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coordinador extends Model
{
    protected $table = 'personal';

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
