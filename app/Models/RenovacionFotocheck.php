<?php

namespace App\Models;

use App\Traits\HasEstado;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class RenovacionFotocheck extends Model
{
    use HasEstado;

    protected $table = 'renovaciones_fotocheck';

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function regimen()
    {
        return $this->belongsTo(Regimen::class, 'regimen_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class, 'trabajador_id');
    }

    public function zonaLabor()
    {
        return $this->belongsTo(ZonaLabor::class, 'zona_labor_id');
    }

    public function motivo()
    {
        return $this->belongsTo(MotivoFotocheck::class, 'motivo_perdida_fotocheck_id');
    }

    public function color()
    {
        return $this->belongsTo(ColorFotocheck::class, 'color_fotocheck_id');
    }

    public function getFechaSolicitudLargaAttribute($value)
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon::parse($this->fecha_solicitud);
        $mes = $meses[($fecha->format('n')) - 1];
        return $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');
    }

    public function getMesPagoAttribute($value)
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon::parse($this->fecha_solicitud);
        $mes = $meses[($fecha->format('n')) - 1];
        return $mes . ' - ' . $fecha->format('Y');
    }
}
