<?php

namespace App\Models;

use App\Traits\HasEstado;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Finiquito extends Model
{
    use HasEstado;

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

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
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
    
    public function getFechaFiniquitoLargaAttribute($value)
    {
        if ($this->grupo_finiquito_id) {
            return $this->grupoFiniquito->fecha_finiquito_larga;
        }

        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon::parse($this->fecha_finiquito);
        $mes = $meses[($fecha->format('n')) - 1];
        return $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');
    }
}
