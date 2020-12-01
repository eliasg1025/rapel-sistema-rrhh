<?php

namespace App\Models;

use App\Traits\HasEstado;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class GrupoFiniquito extends Model
{
    use HasEstado;

    protected $table = 'grupos_finiquitos';

    public function getFechaFiniquitoLargaAttribute($value)
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon::parse($this->fecha_finiquito);
        $mes = $meses[($fecha->format('n')) - 1];
        return $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function finiquitos()
    {
        return $this->hasMany(Finiquito::class, 'grupo_finiquito_id');
    }
}
