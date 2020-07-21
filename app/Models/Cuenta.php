<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cuenta extends Model
{
    protected $table = 'cuentas';

    public function getFechaFormatAttribute()
    {
        return Carbon::parse($this->fecha_solicitud)->format('d/m/Y');
    }

    /**
     * Eloquent relationships
     */

    public function trabajador()
    {
        return $this->belongsTo('App\Models\Trabajador');
    }

    public function banco()
    {
        return $this->belongsTo('App\Models\Banco');
    }

    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario');
    }

    public static function _create(array $data)
    {
        DB::beginTransaction();
        try {
            $banco_id = Banco::findOrCreate($data['banco']);
            $trabajador_id = Trabajador::findOrCreate($data['trabajador']);

            $cuenta = new Cuenta();
            $cuenta->numero_cuenta = $data['numero_cuenta'];
            $cuenta->fecha_solicitud = $data['fecha_solicitud'];
            $cuenta->empresa_id = $data['empresa_id'];
            $cuenta->usuario_id = $data['usuario_id'];
            $cuenta->banco_id = $banco_id;
            $cuenta->trabajador_id = $trabajador_id;

            if ($cuenta->save()) {
                DB::commit();
                return [
                    'error' => false,
                    'message' => 'Cuenta creada correctamente',
                    'cuenta_id' => $cuenta->id
                ];
            }
            DB::rollBack();
            return 0;
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => true,
                'message' => $e->getMessage() . ' -- ' . $e->getLine()
            ];
        }
    }
}
