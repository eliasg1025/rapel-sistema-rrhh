<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'actividades';

    public static function findOrCreate(array $data=[])
    {
        try {
            $actividad = Actividad::where([
                'code' => $data['id'],
                'empresa_id' => $data['empresa_id']
            ])->first();

            if ($actividad) {
                return $actividad->id;
            }

            $actividad = new Actividad();
            $actividad->code = $data['id'];
            $actividad->empresa_id = $data['empresa_id'];
            $actividad->cod_cuenta = $data['cod_cuenta'] ?? null;
            $actividad->name = $data['name'];

            if ($actividad->save()) {
                return $actividad->id;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
