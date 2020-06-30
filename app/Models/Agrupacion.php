<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agrupacion extends Model
{
    protected $table = 'agrupaciones';

    public static function findOrCreate(array $data=[])
    {
        try {
            $agrupacion = Agrupacion::where([
                'code' => $data['id'],
                'empresa_id' => $data['empresa_id']
            ])->first();

            if ($agrupacion) {
                return $agrupacion->id;
            }

            $agrupacion = new Agrupacion();
            $agrupacion->code = $data['id'];
            $agrupacion->empresa_id = $data['empresa_id'];
            $agrupacion->name = $data['name'];

            if ($agrupacion->save()) {
                return $agrupacion->id;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
