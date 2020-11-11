<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bono extends Model
{
    protected $table = 'bonos';

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id');
    }
}
