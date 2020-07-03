<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    protected $table = 'rutas';

    public static function findOrCreate(array $data=[], $troncal_id)
    {
        try {
            $ruta = Ruta::where([
                'code' => $data['id'],
                'empresa_id' => $data['empresa_id'],
                'troncal_id' => $troncal_id
            ])->first();

            if ($ruta) {
                return $ruta->id;
            }

            $ruta = new Ruta();
            $ruta->code = $data['id'];
            $ruta->empresa_id = $data['empresa_id'];
            $ruta->name = $data['name'];
            $ruta->troncal_id = $troncal_id;

            if ($ruta->save()) {
                return $ruta->id;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
