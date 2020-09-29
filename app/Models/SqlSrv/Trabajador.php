<?php

namespace App\Models\SqlSrv;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Trabajador extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'dbo.Trabajador';

    public $incrementing = false;

    public static function getInfoCuenta($rut)
    {
        return DB::connection('sqlsrv')
            ->table('dbo.Trabajador as t')
            ->select(
                't.RutTrabajador as rut',
                't.NumeroCuentaBancaria as numero_cuenta',
                'b.Nombre as banco'
            )
            ->join('dbo.Banco as b', [
                'b.IdEmpresa' => 't.IdEmpresa',
                'b.IdBanco' => 't.IdBanco'
            ])
            ->where('t.RutTrabajador', $rut)
            ->first();
    }
}
