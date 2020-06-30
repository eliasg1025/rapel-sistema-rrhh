<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Labor extends Model
{
    protected $table = 'labores';

    public static function findOrCreate(array $data=[], $actividad_id)
    {
        try {
            $labor = Labor::where([
                'code' => $data['id'],
                'empresa_id' => $data['empresa_id'],
                'actividad_id' => $actividad_id
            ])->first();

            if ($labor) {
                return $labor->id;
            }

            $labor = new Labor();
            $labor->code = $data['id'];
            $labor->empresa_id = $data['empresa_id'];
            $labor->unidad_medida = $data['unidad_medida'] ?? null;
            $labor->name = $data['name'];
            $labor->actividad_id = $actividad_id;

            if ($labor->save()) {
                return $labor->id;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
