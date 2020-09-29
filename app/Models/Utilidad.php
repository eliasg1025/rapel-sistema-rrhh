<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Utilidad extends Model
{
    protected $table = 'utilidades';

    public $timestamps = false;

    public $fillable = ['rut', 'mes', 'ano', 'monto', 'empresa_id'];

    public static function get(array $fechas, int $estado, int $empresa_id)
    {
        return DB::table('utilidades as l')
            ->select(
                'l.id', 'l.rut', 'l.nombre', 'l.apellido_paterno', 'l.apellido_materno',
                'l.mes', 'l.ano', 'l.monto', 'l.estado', 'e.shortname as empresa', 'l.banco', 'l.numero_cuenta',
                DB::raw("'UTILIDAD' AS tipo_pago"),
                DB::raw('DATE_FORMAT(l.fecha_hora_marca_firmado, "%d/%m/%Y") fecha_firmado'),
                DB::raw('DATE_FORMAT(l.fecha_hora_marca_para_pago, "%d/%m/%Y") fecha_para_pago'),
                DB::raw('DATE_FORMAT(l.fecha_hora_marca_pagado, "%d/%m/%Y") fecha_pagado'),
                DB::raw('DATE_FORMAT(l.fecha_hora_marca_pagado, "%d/%m/%Y") fecha_pagado'),
                DB::raw('DATE_FORMAT(l.fecha_hora_marca_rechazado, "%d/%m/%Y") fecha_rechazado'),
                DB::raw('DATE_FORMAT(l.fecha_pago, "%d/%m/%Y") fecha_pago')
            )
            ->join('empresas as e', 'e.id', '=', 'l.empresa_id')
            ->where('l.estado', $estado)
            ->orderBy('l.ano', 'DESC')
            ->orderBy('l.mes', 'DESC')
            ->orderBy('l.apellido_paterno', 'ASC')
            ->when($empresa_id !== 0, function($query) use($empresa_id) {
                $query->where('l.empresa_id', $empresa_id);
            })
            ->when($estado === 0, function($query) use ($fechas) {
                $query->whereBetween('l.ano', [
                    Carbon::parse($fechas['desde'])->format('Y'),
                    Carbon::parse($fechas['hasta'])->format('Y')
                ]);
            })
            ->when($estado === 1, function($query) use ($fechas) {
                $query->whereDate('l.fecha_hora_marca_firmado', '>=' , $fechas['desde'])
                    ->whereDate('l.fecha_hora_marca_firmado', '<=', $fechas['hasta']);
            })
            ->when($estado === 2, function($query) use ($fechas) {
                $query->whereBetween('l.fecha_pago', [$fechas['desde'], $fechas['hasta']]);
            })
            ->get()->toArray();
    }

    public static function montosPorEstado($empresa_id = 9)
    {
        return DB::table('utilidades as l')
            ->select(
                'e.shortname as empresa',
                DB::raw('round( sum(case l.estado when 5 then l.monto else 0 end), 2 ) as pagados'),
                DB::raw('round( sum(case l.estado when 2 then l.monto else 0 end), 2 ) as para_pago'),
                DB::raw('round( sum(case l.estado when 1 then l.monto else 0 end), 2 ) as firmados'),
                DB::raw('round( sum(case l.estado when 0 then l.monto else 0 end), 2 ) as pendiente'),
                DB::raw('round( sum(l.monto), 2 ) as total')
            )
            ->join('empresas as e', 'e.id', '=', 'l.empresa_id')
            ->where('l.empresa_id', [$empresa_id])
            ->groupBy('l.empresa_id')
            ->first();
    }

    public static function montosPorEstadoPorAnio(int $empresa_id)
    {
        $dataset = DB::table('utilidades as l')
            ->select(
                'l.ano as key',
                'l.ano as id',
                'l.ano as anio',
                DB::raw('round( sum(case l.estado when 5 then l.monto else 0 end), 2 ) as pagados'),
                DB::raw('round( sum(case l.estado when 2 then l.monto else 0 end), 2 ) as para_pago'),
                DB::raw('round( sum(case l.estado when 1 then l.monto else 0 end), 2 ) as firmados'),
                DB::raw('round( sum(case l.estado when 0 then l.monto else 0 end), 2 ) as pendiente'),
                DB::raw('round( sum(l.monto), 2 ) as total')
            )
            ->where('l.empresa_id', [$empresa_id])
            ->groupBy('l.ano')
            ->get();
        return $dataset;
    }

    public static function cantidadPagosPorDia($empresa_id, $desde, $hasta)
    {
        $dataset = DB::table('utilidades as l')
            ->select(
                DB::raw('DATE(l.fecha_pago) as dia'),
                DB::raw('COUNT(*) as cantidad')
            )
            ->where('l.empresa_id', $empresa_id)
            ->whereIn('l.estado', [3, 5])
            ->whereDate('l.fecha_pago', '>=', $desde)
            ->whereDate('l.fecha_pago', '<=', $hasta)
            ->groupBy('dia')
            ->get()->toArray();

        //return $dataset;

        $dias = array_column($dataset, 'dia');
        $cantidades = array_column($dataset, 'cantidad');

        $periodo = CarbonPeriod::create($desde, $hasta);
        $tmp = [];

        foreach ($periodo as $dia) {
            $str_dia = $dia->format('Y-m-d');
            $index = array_search($str_dia, $dias);

            if ( !is_bool($index) ) {
                array_push($tmp, [
                    'dia' => $str_dia,
                    'cantidad' => $cantidades[$index]
                ]);
            } else {
                array_push($tmp, [
                    'dia' => $str_dia,
                    'cantidad' => 0
                ]);
            }
        }

        return $tmp;
    }
}
