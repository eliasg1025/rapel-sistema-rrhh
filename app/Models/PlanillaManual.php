<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class PlanillaManual extends Model
{
    protected $table = 'planillas_manuales';

    protected $fillable = [
        'tipo_entidad',
        'entidad_id'
    ];

    public function trabajador() {
        return $this->belongsTo(Trabajador::class, 'trabajador_id');
    }

    public function usuario() {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function motivo() {
        return $this->belongsTo(MotivoPlanillaManual::class, 'motivo_planilla_manual_id');
    }

    public function empresa() {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
}
