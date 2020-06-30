<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoContrato extends Model
{
    protected $table = 'tipo_contratos';

    public static function findOrCreate(array $data=[])
    {
        try {
            $tipo_contrato = TipoContrato::where([
                'code' => $data['id'],
                'empresa_id' => $data['empresa_id']
            ])->first();

            if ($tipo_contrato) {
                return $tipo_contrato->id;
            }

            $tipo_contrato = new TipoContrato();
            $tipo_contrato->code = $data['id'];
            $tipo_contrato->empresa_id = $data['empresa_id'];
            $tipo_contrato->cod_equ = $data['cod_equ'] ?? null;
            $tipo_contrato->name = $data['name'];

            if ($tipo_contrato->save()) {
                return $tipo_contrato->id;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
