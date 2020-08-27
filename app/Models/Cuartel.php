<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

            if (!$cuartel) {
                $cuartel = new Cuartel();
            }

            $cuartel->code = $data['id'];
            $cuartel->empresa_id = $data['empresa_id'];
            $cuartel->cod_subcentro = $data['cod_subcentro'] ?? null;
            $cuartel->nom_subcentro = $data['nom_subcentro'] ?? null;
            $cuartel->name = $data['name'];
            if (isset($data['sctr'])) {
                $cuartel->sctr = $data['sctr'];
            }
            $cuartel->zona_labor_id = $zona_labor_id;

            if ($cuartel->save()) {
                return $cuartel->id;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getWithSctr()
    {
        return DB::table('cuarteles as c')
            ->select(
                'c.id',
                'zl.name as zona_labor',
                'c.name as cuartel',
                'e.shortname as empresa'
            )
            ->join('empresas as e', 'e.id', '=', 'c.empresa_id')
            ->join('zona_labores as zl', [
                'zl.empresa_id' => 'c.empresa_id',
                'zl.id' => 'c.zona_labor_id'
            ])
            ->where('c.sctr', true)
            ->orderBy('e.shortname', 'ASC')
            ->orderBy('zl.name', 'ASC')
            ->orderBy('c.name', 'ASC')
            ->get();
    }

    public static function getIndexesWithSctr($empresa_id)
    {
        $cuarteles = DB::table('cuarteles as c')
            ->select(DB::raw("CONCAT(zl.code, '@', c.code) as id"))
            ->join('zona_labores as zl', [
                'zl.empresa_id' => 'c.empresa_id',
                'zl.id' => 'c.zona_labor_id'
            ])
            ->where('c.sctr', true)
            ->where('c.empresa_id', $empresa_id)
            ->get()->toArray();

        $cuarteles_indexes = array_column($cuarteles, 'id'); // Obteniendo solo los valor de los pk
        return $cuarteles_indexes;
    }

    public static function disableSctr($id)
    {
        try {
            $cuartel = Cuartel::find($id);
            $cuartel->sctr = false;

            if ($cuartel->save()) {
                return $cuartel->id;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
