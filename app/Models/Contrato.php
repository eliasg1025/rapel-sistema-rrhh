<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contrato extends Model
{
    protected $table = 'contratos';

    public function trabajador()
    {
        return $this->belongsTo('App\Models\Trabajador');
    }

    public static function masive_save($contratos = []): bool
    {
        DB::beginTransaction();
        try {
            $bandera = true;
            for ($i=0; $i < sizeof($contratos); $i++) {
                $contrato = new Contrato();
                $contrato->code = $contratos[$i]['IdContrato'];
                $contrato->fecha_inicio = $contratos[$i]['FechaInicio'];
                $contrato->fecha_termino = $contratos[$i]['FechaTermino'];
                $contrato->fecha_termino_c = $contratos[$i]['FechaTerminoC'];
                $contrato->sueldo_base = $contratos[$i]['SueldoBase'];
                $contrato->cussp = $contratos[$i]['Cussp'];
                $contrato->trabajador_id = $contratos[$i]['RutTrabajador'];
                $contrato->empresa_id = $contratos[$i]['IdEmpresa'];
                $contrato->zona_labor_id = $contrato[$i]['IdZona'];

                if (!$contrato->save()) {
                    $bandera = false;
                }
            }

            if ($bandera) {
                DB::commit();
                return true;
            } else {
                throw new \Exception();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
