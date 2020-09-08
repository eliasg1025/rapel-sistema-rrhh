<?php

namespace App\Models\SqlSrv;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ZonaLabor extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'dbo.Zona';

    public $incrementing = false;

    public static function getIdByTrabajador($rut, $empresa_id)
    {
        $zona = DB::connection('sqlsrv')
            ->table('dbo.Trabajador as t')
            ->where([
                't.RutTrabajador' => $rut,
                't.IdEmpresa' => $empresa_id
            ])
            ->first();

        return DB::connection('mysql')
                ->table('zona_labores as z')
                ->where([
                    'code' => $zona->IdZona,
                    'empresa_id' => $empresa_id
                ])
                ->first();
    }
}
