<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Liquidaciones extends Model
{
    protected $table = 'liquidaciones';

    public $incrementing = false;

    public $timestamps = false;

    public $fillable = ['id', 'finiquito_id', 'rut', 'mes', 'ano', 'monto', 'empresa_id', 'fecha_emision'];

    public static function get(array $fechas, int $estado, int $empresa_id)
    {
        return DB::table('liquidaciones as l')
            ->select('l.id', 'l.rut', 'l.mes', 'l.ano', 'l.monto', 'l.estado', 'e.shortname as empresa',
                DB::raw('DATE_FORMAT(l.fecha_hora_marca_firmado, "%d/%m/%Y") fecha_firmado'),
                DB::raw('DATE_FORMAT(l.fecha_hora_marca_para_pago, "%d/%m/%Y") fecha_para_pago'),
                DB::raw('DATE_FORMAT(l.fecha_hora_marca_pagado, "%d/%m/%Y") fecha_pagado'),
                DB::raw('DATE_FORMAT(l.fecha_hora_marca_pagado, "%d/%m/%Y") fecha_pagado'),
                DB::raw('DATE_FORMAT(l.fecha_hora_marca_rechazado, "%d/%m/%Y") fecha_rechazado'),
                DB::raw('DATE_FORMAT(l.fecha_pago, "%d/%m/%Y") fecha_pago')
            )
            ->join('empresas as e', 'e.id', '=', 'l.empresa_id')
            ->whereBetween('l.fecha_emision', [$fechas['desde'], $fechas['hasta']])
            ->where('l.estado', $estado)
            ->when($empresa_id !== 0, function($query) use($empresa_id) {
                $query->where('l.empresa_id', $empresa_id);
            })
            ->get();
    }
}
