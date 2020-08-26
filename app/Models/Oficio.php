<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

            if (!$oficio) {
                $oficio = new Oficio();
            }

            $oficio->code = $data['id'];
            $oficio->empresa_id = $data['empresa_id'];
            $oficio->cod_equ = $data['cod_equ'] ?? null;
            $oficio->name = $data['name'];
            if (isset($data['sctr'])) {
                $oficio->sctr = $data['sctr'];
            }

            if ($oficio->save()) {
                return $oficio->id;
            }
        } catch (\Exception $e) {
            return $e->getMessage() . ' -- ' . $e->getLine();
        }
    }

    public static function getWithSctr()
    {
        return DB::table('oficios as o')
            ->select(
                'o.id',
                'o.name as oficio',
                'e.shortname as empresa'
            )
            ->join('empresas as e', 'e.id', '=', 'o.empresa_id')
            ->where('o.sctr', true)
            ->get();
    }

    public static function disableSctr($id)
    {
        try {
            $oficio = Oficio::find($id);
            $oficio->sctr = false;

            if ($oficio->save()) {
                return $oficio->id;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
