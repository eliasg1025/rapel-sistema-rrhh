<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oficio extends Model
{
    protected $table = 'oficios';

    public static function findOrCreate(array $data=[])
    {
        try {
            $oficio = Oficio::where([
                'code' => $data['id'],
                'empresa_id' => $data['empresa_id']
            ])->first();

            if ($oficio) {
                return $oficio->id;
            }

            $oficio = new Oficio();
            $oficio->code = $data['id'];
            $oficio->empresa_id = $data['empresa_id'];
            $oficio->cod_equ = $data['cod_equ'] ?? null;
            $oficio->name = $data['name'];

            if ($oficio->save()) {
                return $oficio->id;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
