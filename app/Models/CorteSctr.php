<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorteSctr extends Model
{
    protected $table = 'cortes_sctr';

    public static function _create($data)
    {
        $corte_sctr = self::where([
            'empresa_id' => $data['empresa_id'],
            'mes' => $data['mes'],
            'ano' => $data['ano']
        ])->first();

        if (!$corte_sctr) {
            $corte_sctr = new CorteSctr();
            $corte_sctr->empresa_id = $data['empresa_id'];
            $corte_sctr->mes = $data['mes'];
            $corte_sctr->ano = $data['ano'];
        }

        $corte_sctr->usuario_id = $data['usuario_id'];
        $corte_sctr->fecha_hora_corte = now()->toDateTimeString();

        if ($corte_sctr->save()) {
            return $corte_sctr->id;
        }
    }
}
