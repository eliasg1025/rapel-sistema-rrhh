<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuartel extends Model
{
    protected $table = 'cuarteles';

    public static function findOrCreate(array $data=[], $zona_labor_id)
    {
        try {
            $cuartel = Cuartel::where([
                'code' => $data['id'],
                'empresa_id' => $data['empresa_id'],
                'zona_labor_id' => $zona_labor_id
            ])->first();

            if ($cuartel) {
                return $cuartel->id;
            }

            $cuartel = new Cuartel();
            $cuartel->code = $data['id'];
            $cuartel->empresa_id = $data['empresa_id'];
            $cuartel->cod_subcentro = $data['cod_subcentro'] ?? null;
            $cuartel->nom_subcentro = $data['nom_subcentro'] ?? null;
            $cuartel->name = $data['name'];
            $cuartel->zona_labor_id = $zona_labor_id;

            if ($cuartel->save()) {
                return $cuartel->id;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
