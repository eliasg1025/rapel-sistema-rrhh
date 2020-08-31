<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RegistroSctr extends Model
{
    protected $table = 'registros_sctr';

    public static function _create(array $data)
    {
        try {
            return DB::table('registros_sctr')
                ->updateOrInsert(
                    [
                        'rut' => $data['rut'],
                        'corte_sctr_id' => $data['corte_sctr_id']
                    ],
                    [
                        'cargo' => $data['cargo'],
                        'sueldo' => $data['sueldo'],
                        'fecha_ingreso' => Carbon::createFromFormat('d/m/Y', $data['fecha_ingreso']),
                        'fecha_hora_corte' => $data['fecha_hora_corte']
                    ]
                );
        } catch (\Exception $e){
            return false;
        }
    }

    public static function massiveCreate(array $asegurados, int $corte_sctr_id)
    {
        function registrosSctrGenerator($asegurados) {
            foreach ($asegurados as $asegurado) {
                yield $asegurado;
            }
        }

        $generador = registrosSctrGenerator($asegurados);

        $corte_sctr = CorteSctr::find($corte_sctr_id);

        $count = 0;
        foreach ($generador as $value) {
            $result  = self::_create([
                'rut' => $value['rut'],
                'cargo' => $value['cargo'],
                'sueldo' => $value['sueldo'],
                'fecha_ingreso' => $value['fecha_ingreso'],
                'fecha_hora_corte' => $corte_sctr->fecha_hora_corte,
                'corte_sctr_id' => $corte_sctr_id
            ]);

            if ($result) {
                $count++;
            }
        }

        return [
            'total' => sizeof($asegurados),
            'correctos' => $count
        ];
    }
}
