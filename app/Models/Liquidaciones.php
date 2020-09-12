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
            ->select(
                'l.id', 'l.rut', 'l.nombre', 'l.apellido_paterno', 'l.apellido_materno',
                'l.mes', 'l.ano', 'l.monto', 'l.estado', 'e.shortname as empresa', 'l.banco', 'l.numero_cuenta',
                DB::raw('DATE_FORMAT(l.fecha_hora_marca_firmado, "%d/%m/%Y") fecha_firmado'),
                DB::raw('DATE_FORMAT(l.fecha_hora_marca_para_pago, "%d/%m/%Y") fecha_para_pago'),
                DB::raw('DATE_FORMAT(l.fecha_hora_marca_pagado, "%d/%m/%Y") fecha_pagado'),
                DB::raw('DATE_FORMAT(l.fecha_hora_marca_pagado, "%d/%m/%Y") fecha_pagado'),
                DB::raw('DATE_FORMAT(l.fecha_hora_marca_rechazado, "%d/%m/%Y") fecha_rechazado'),
                DB::raw('DATE_FORMAT(l.fecha_pago, "%d/%m/%Y") fecha_pago')
            )
            ->join('empresas as e', 'e.id', '=', 'l.empresa_id')
            ->where('l.estado', $estado)
            ->when($empresa_id !== 0, function($query) use($empresa_id) {
                $query->where('l.empresa_id', $empresa_id);
            })
            ->when($estado === 0, function($query) use ($fechas) {
                $query->whereBetween('l.fecha_emision', [$fechas['desde'], $fechas['hasta']]);
            })
            ->when($estado === 1, function($query) use ($fechas) {
                $query->whereDate('l.fecha_hora_marca_firmado', '>=' , $fechas['desde'])
                    ->whereDate('l.fecha_hora_marca_firmado', '<=', $fechas['hasta']);
            })
            ->when($estado === 2, function($query) use ($fechas) {
                $query->whereBetween('l.fecha_pago', [$fechas['desde'], $fechas['hasta']]);
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
                DB::table('liquidaciones')->updateOrInsert(
                    [
                        'id' => $liquidacion['IdLiquidacion']
                    ],
                    [
                        'finiquito_id' => $liquidacion['IdFiniquito'],
                        'rut' => $liquidacion['RutTrabajador'],
                        'nombre' => $liquidacion['Nombre'],
                        'apellido_paterno' => $liquidacion['ApellidoPaterno'],
                        'apellido_materno' => $liquidacion['ApellidoMaterno'],
                        'ano' => $liquidacion['Ano'],
                        'mes' => $liquidacion['Mes'],
                        'monto' => $liquidacion['MontoAPagar'],
                        'empresa_id' => $liquidacion['IdEmpresa'],
                        'fecha_emision' => date($liquidacion['FechaEmision']),
                        'banco' => $liquidacion['Banco'],
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

    public static function marcarPagadoMasivo(array $finiquitos)
    {
        try {
            return DB::table('liquidaciones')
                ->whereIn('id', $finiquitos)
                ->update([
                    'estado' => 3,
                    'fecha_hora_marca_pagado' => now()->toDateTimeString()
                ]);
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }
}
