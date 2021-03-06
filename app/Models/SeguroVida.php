<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeguroVida extends Model
{
    protected $table = 'seguros_vida';

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'id');
    }

    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class, 'trabajador_id', 'id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id');
    }

    public function regimen()
    {
        return $this->belongsTo(Regimen::class, 'regimen_id', 'id');
    }

    public function zona_labor()
    {
        return $this->belongsTo(ZonaLabor::class, 'zona_labor_id', 'id');
    }
}
