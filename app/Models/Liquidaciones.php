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

    public static function forPayment(string $fecha, array $finiquitos)
    {
        try {
            return DB::table('liquidaciones')
                ->whereIn('id', $finiquitos)
                ->update([
                    'estado' => 2,
                    'fecha_pago' => date($fecha),
                    'fecha_hora_marca_para_pago' => now()->toDateTimeString()
                ]);
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    public static function massiveCreate(array $liquidaciones)
    {
        $count = 0;
        $total = sizeof($liquidaciones);
        $errors = [];

        foreach($liquidaciones as $liquidacion)
        {
            try {
                $result = DB::table('liquidaciones')->updateOrInsert(
                    [
                        'id' => $liquidacion['IdLiquidacion']
                    ],
                    [
                        'finiquito_id' => $liquidacion['IdFiniquito'],
                        'rut' => $liquidacion['RutTrabajador'],
                        'ano' => $liquidacion['Ano'],
                        'mes' => $liquidacion['Mes'],
                        'monto' => $liquidacion['MontoAPagar'],
                        'empresa_id' => $liquidacion['IdEmpresa'],
                        'fecha_emision' => date($liquidacion['FechaEmision']),
                        'banco_id' => $liquidacion['IdBanco'],
                        'numero_cuenta' => $liquidacion['NumeroCuentaBancaria']
                    ]
                );

                $count++;
            } catch (\Exception $e) {
                array_push($errors, [
                    'id' => $liquidacion['IdLiquidacion'],
                    'error' => $e->getMessage()
                ]);
            }
        }

        return [
            'total' => $total,
            'completados' => $count,
            'errores' => $errors
        ];
    }
}
