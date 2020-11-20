<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoFiniquito extends Model
{
    protected $table = 'grupos_finiquitos';

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
