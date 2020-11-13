<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bono extends Model
{
    protected $table = 'bonos';

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id');
    }

    public function reglas()
    {
        return $this->hasMany(BonoRegla::class, 'bono_id', 'id');
    }
}
