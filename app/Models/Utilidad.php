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

    public static function forPayment(string $fecha, array $utilidades)
    {
        try {
            return DB::table('utilidades')
                ->whereIn('id', $utilidades)
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

    public static function marcarPagadoMasivo($empresa_id, $fecha_pago)
    {
        try {
            return DB::table('utilidades')
                ->where('empresa_id', $empresa_id)
                ->where('fecha_pago', $fecha_pago)
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

    public static function getByTrabajador($rut)
    {
        return DB::table('utilidades as l')
            ->select(
                'l.id', 'l.rut',
                DB::raw("CONCAT(l.id, '@', 2) AS _id"),
                DB::raw("'UTILIDAD' as tipo_pago"),
                'l.mes', 'l.ano', 'l.monto', 'l.estado', 'e.shortname as empresa', 'l.banco', 'l.numero_cuenta',
                DB::raw('DATE_FORMAT(l.fecha_hora_marca_firmado, "%d/%m/%Y %H:%i:%s") fecha_firmado'),
                DB::raw('DATE_FORMAT(l.fecha_pago, "%d/%m/%Y") fecha_pago')
            )
            ->join('empresas as e', 'e.id', '=', 'l.empresa_id')
            ->where('l.rut', $rut)
            ->get();
    }

    public static function getPagados($empresa_id, $fecha_pago, $banco='TODOS')
    {
        return DB::table('utilidades as l')
            ->select(
                'l.id as key', 'l.id', 'l.rut', 'l.nombre', 'l.apellido_paterno', 'l.apellido_materno',
                'l.mes', 'l.ano', 'l.monto', 'l.estado', 'e.shortname as empresa', 'l.banco', 'l.numero_cuenta',
                DB::raw('DATE_FORMAT(l.fecha_pago, "%d/%m/%Y") fecha_pago'),
                DB::raw("'UTILIDAD' AS tipo_pago")
            )
            ->join('empresas as e', 'e.id', '=', 'l.empresa_id')
            ->whereIn('l.estado', [3, 4])
            ->where('l.fecha_pago', $fecha_pago)
            ->where('l.empresa_id', $empresa_id)
            ->when($banco !== 'TODOS', function($query) use ($banco) {
                $query->where('l.banco', $banco);
            })
            ->orderBy('l.apellido_paterno', 'ASC')
            ->get();
    }

    public static function toggleRechazo(int $tipo, $finiquitos)
    {
        try {
            if ($tipo === 1) {
                return DB::table('utilidades')
                    ->whereIn('id', $finiquitos)
                    ->update([
                        'estado' => 4,
                        'fecha_hora_marca_rechazado' => now()->toDateTimeString()
                    ]);
            } else {
                return DB::table('utilidades')
                    ->whereIn('id', $finiquitos)
                    ->update([
                        'estado' => 3,
                        'fecha_hora_marca_rechazado' => null
                    ]);
            }
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    public static function terminarProceso(array $finiquitos)
    {
        DB::beginTransaction();
        try {
            foreach ($finiquitos as $finiquitosId) {
                $finiquito = Utilidad::where('id', $finiquitosId)->first();

                if ($finiquito->estado === 3) {
                    $finiquito->estado = 5;
                    $finiquito->fecha_hora_marca_archivado = now()->toDateTimeString();
                    $finiquito->save();
                } else {

                    $rechazo = new UtilidadRechazo();
                    $rechazo->rut = $finiquito->rut;
                    $rechazo->nombre = $finiquito->nombre;
                    $rechazo->apellido_paterno = $finiquito->apellido_paterno;
                    $rechazo->apellido_materno = $finiquito->apellido_materno;
                    $rechazo->mes = $finiquito->mes;
                    $rechazo->ano = $finiquito->ano;
                    $rechazo->banco = $finiquito->banco;
                    $rechazo->numero_cuenta = $finiquito->numero_cuenta;
                    $rechazo->monto = $finiquito->monto;
                    $rechazo->fecha_pago = $finiquito->fecha_pago;
                    $rechazo->empresa_id = $finiquito->empresa_id;
                    $rechazo->utilidad_id = $finiquitosId;
                    $rechazo->save();

                    $finiquito->estado = 1;
                    $finiquito->save();
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => $e->getMessage() . ' -- ' . $e->getLine()
            ];
        }
    }

    public static function getRechazados($empresa_id = 9)
    {
        $dataset = DB::table('utilidades_rechazos as l')
            ->select(
                'l.id', 'l.rut', 'l.nombre', 'l.apellido_paterno', 'l.apellido_materno',
                'l.mes', 'l.ano', 'l.monto', 'e.shortname as empresa', 'l.banco', 'l.numero_cuenta',
                'l.utilidad_id',
                DB::raw("CONCAT(l.id, '@', 2) as _id"),
                DB::raw('DATE_FORMAT(l.fecha_pago, "%d/%m/%Y") fecha_pago'),
                DB::raw("'UTILIDAD' AS tipo_pago")
            )
            ->join('empresas as e', 'e.id', '=', 'l.empresa_id')
            //->where('l.empresa_id', $empresa_id)
            ->orderBy('l.apellido_paterno', 'ASC')
            ->get();

        $dataset->transform(function($item) {
            $children = DB::table('utilidades as l')
                ->where('l.id', $item->utilidad_id)
                ->first();

            if ( $children ) {
                $item->estado = $children->estado;
            }

            return $item;
        });

        return $dataset;
    }
}
