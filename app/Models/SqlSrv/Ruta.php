<?php

namespace App\Models\Sqlsrv;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ruta extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'dbo.RUTAS';

    public static function getAll()
    {
        return DB::connection('sqlsrv')->table('dbo.RUTAS as r')
            ->select(
                DB::raw('DISTINCT r.DESCRIPCION as name')
            )
            ->whereIn('r.IdEmpresa', [9, 14])
            ->get();
    }
}
