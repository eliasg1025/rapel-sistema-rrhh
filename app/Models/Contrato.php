<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contrato extends Model
{
    protected $table = 'contratos';

    public function trabajador()
    {
        return $this->belongsTo('App\Models\Trabajador');
    }

    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa');
    }

    public static function _save(array $data): bool
    {
        try {
            $contrato = Contrato::firstWhere([
                'code' => $data['code'],
                'fecha_inicio' => $data['fecha_inicio'],
                'fecha_termino_c' => $data['fecha_termino_c'],
            ]);

            if (!$contrato) {
                $contrato = new Contrato();
                $contrato->code = $data['code'];
                $contrato->fecha_inicio = $data['fecha_inicio'];
                $contrato->fecha_termino_c = $data['fecha_termino_c'];
            }

            $contrato->fecha_termino = $data['fecha_termino'] ?? null;
            $contrato->sueldo_base = $data['sueldo_base'];
            $contrato->cussp = $data['cussp'];
            $contrato->trabajador_id = $data['trabajador_id'];
            $contrato->empresa_id = $data['empresa_id'];
            $contrato->zona_labor_id = $data['zona_labor_id'];

            if ($contrato->save()) {
                return true;
            }
            return false;

        } catch (\Exception $e) {
            return false;
        }
    }

    public static function masive_save(array $data): bool
    {
        $contratos = $data['contratos'];
        DB::beginTransaction();
        try {
            for ($i=0; $i < sizeof($contratos); $i++) {

                $fecha_inicio = Carbon::parse($contratos[$i]['fecha_inicio'])->format('Y-m-d');
                $fecha_termino_c = $contratos[$i]['fecha_termino_c'] ? Carbon::parse($contratos[$i]['fecha_termino_c'])->format('Y-m-d') : null;
                $fecha_termino = $contratos[$i]['fecha_termino'] ? Carbon::parse($contratos[$i]['fecha_termino'])->format('Y-m-d') : null;

                $contrato = self::where([
                    'code' => $contratos[$i]['code'],
                    'empresa_id' => $data['empresa_id'],
                    'trabajador_id' => $data['trabajador_id'],
                ])->first();

                if (!$contrato) {
                    $contrato = new Contrato();
                    $contrato->code = $contratos[$i]['code'];
                    $contrato->empresa_id = $data['empresa_id'];
                    $contrato->trabajador_id = $data['trabajador_id'];
                }

                $contrato->fecha_inicio = $fecha_inicio;
                $contrato->fecha_termino_c = $fecha_termino_c;
                $contrato->fecha_termino = $fecha_termino;
                $contrato->sueldo_base = $contratos[$i]['sueldo_base'];
                $contrato->cussp = $contratos[$i]['cussp'];
                $contrato->zona_labor_id = $data['zona_labor_id'];

                if (!$contrato->save()) {
                    DB::rollBack();
                    return false;
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
