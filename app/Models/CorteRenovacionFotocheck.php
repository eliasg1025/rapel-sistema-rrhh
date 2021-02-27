<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorteRenovacionFotocheck extends Model
{
    protected $table = 'cortes_renovaciones_fotocheck';

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
