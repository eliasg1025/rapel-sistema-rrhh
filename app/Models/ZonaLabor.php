<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ZonaLabor extends Model
{
    protected $table = 'zona_labores';

    public static function findOrCreate(array $data)
    {
        try {
            $zona_labor = ZonaLabor::where([
                'code' => $data['id'],
                'empresa_id' => $data['empresa_id']
            ])->first();

            if ( $zona_labor ) {
                return $zona_labor->id;
            }

            $zona_labor = new ZonaLabor();
            $zona_labor->code = $data['id'];
            $zona_labor->name = $data['name'];
            $zona_labor->empresa_id = $data['empresa_id'];

            if ( $zona_labor->save() ) {
                return $zona_labor->id;
            }
        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function get($empresa_id, $habilitados=1)
    {
        return DB::table('zona_labores')
        ->select(
            'code as id',
            'empresa_id',
            'name'
        )
        ->where('empresa_id', $empresa_id)
        ->where('habilitado', '1')
        ->get();
    }
}
