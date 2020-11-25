<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Finiquito extends Model
{
    protected $table = 'finiquitos';

    public function grupoFiniquito()
    {
        return $this->belongsTo(GrupoFiniquito::class, 'grupo_finiquito_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function tipoCese()
    {
        return $this->belongsTo(TipoCese::class, 'tipo_cese_id');
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    public function regimen()
    {
        return $this->belongsTo(Regimen::class, 'regimen_id');
    }

    public function oficio()
    {
        return $this->belongsTo(Oficio::class, 'oficio_id');
    }

    public function getFechaInicioPeriodoLargaAttribute($value)
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon::parse($this->fecha_inicio_periodo);
        $mes = $meses[($fecha->format('n')) - 1];
        return $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');
    }
}
