<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    protected $table = 'bancos';

    public static function findOrCreate(array $data)
    {
        try {
            $banco = self::where([
                'empresa_id' => $data['empresa_id'],
                'code' => $data['id']
            ])->first();

            if (!$banco) {
                $banco = new Banco();
            }

            $banco->name = $data['name'];
            $banco->empresa_id = $data['empresa_id'];
            $banco->code = $data['id'];
            $banco->cod_equ = is_null($data['cod_equ']) ? '' : $data['cod_equ'];

            if ( $banco->save() ) {
                return $banco->id;
            }
            return 0;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
