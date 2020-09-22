<?php

namespace App\Models;

use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pago extends Model
{
    protected $table = 'pagos';

    public $incrementing = false;

    public $timestamps = false;

    public $fillable = ['code', 'finiquito_id', 'rut', 'mes', 'ano', 'monto', 'empresa_id', 'fecha_emision'];

    public static function get(array $fechas, int $estado, int $empresa_id, int $tipo_pago_id)
    {
        return DB::table('pagos as l')
            ->select(
                'l.id', 'tp.name as tipo_pago', 'l.rut', 'l.nombre', 'l.apellido_paterno', 'l.apellido_materno',
                'l.mes', 'l.ano', 'l.monto', 'l.estado', 'e.shortname as empresa', 'l.banco', 'l.numero_cuenta',
                DB::raw('DATE_FORMAT(l.fecha_hora_marca_firmado, "%d/%m/%Y") fecha_firmado'),
                DB::raw('DATE_FORMAT(l.fecha_hora_marca_para_pago, "%d/%m/%Y") fecha_para_pago'),
                DB::raw('DATE_FORMAT(l.fecha_hora_marca_pagado, "%d/%m/%Y") fecha_pagado'),
                DB::raw('DATE_FORMAT(l.fecha_hora_marca_pagado, "%d/%m/%Y") fecha_pagado'),
                DB::raw('DATE_FORMAT(l.fecha_hora_marca_rechazado, "%d/%m/%Y") fecha_rechazado'),
                DB::raw('DATE_FORMAT(l.fecha_pago, "%d/%m/%Y") fecha_pago')
            )
            ->join('empresas as e', 'e.id', '=', 'l.empresa_id')
            ->join('tipos_pago as tp', 'tp.id', '=', 'tipo_pago_id')
            ->where('l.estado', $estado)
            ->when($empresa_id !== 0, function($query) use($empresa_id) {
                $query->where('l.empresa_id', $empresa_id);
            })
            ->when($tipo_pago_id !== 0, function ($query) use ($tipo_pago_id) {
                $query->where('l.tipo_pago_id', $tipo_pago_id);
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

    public static function getResumenPorFechaPago($fecha_pago)
    {
        $dataset = DB::table('pagos as l')
            ->select(
                'l.banco', 'l.empresa_id',
                DB::raw('COUNT(DISTINCT l.rut) as cantidad_personas'),
                DB::raw('SUM(l.monto) as monto')
            )
            ->where('l.fecha_pago', $fecha_pago)
            ->whereIn('l.estado', [3])
            ->groupBy('l.empresa_id', 'l.banco')
            ->get();

        $rapel = [];
        $verfrut = [];

        foreach ($dataset as $value) {
            if ($value->empresa_id === 9) {
                array_push($rapel, $value);
            } else if ($value->empresa_id === 14) {
                array_push($verfrut, $value);
            }
        }

        return [
            'rapel' => $rapel,
            'verfrut' => $verfrut
        ];
    }

    public static function getByTrabajador($rut)
    {
        return DB::table('pagos as l')
            ->select(
                'l.id as key', 'l.id', 'l.rut',
                'l.mes', 'l.ano', 'l.monto', 'l.estado', 'e.shortname as empresa', 'l.banco', 'l.numero_cuenta',
                DB::raw('DATE_FORMAT(l.fecha_hora_marca_firmado, "%d/%m/%Y %H:%i:%s") fecha_firmado'),
                DB::raw('DATE_FORMAT(l.fecha_pago, "%d/%m/%Y") fecha_pago')
            )
            ->join('empresas as e', 'e.id', '=', 'l.empresa_id')
            ->where('l.rut', $rut)
            ->get();
    }

    public static function getPagados($empresa_id, $fecha_pago, $rut='', $banco='TODOS')
    {
        return DB::table('pagos as l')
            ->select(
                'l.id as key', 'tp.name as tipo_pago', 'l.id', 'l.rut', 'l.nombre', 'l.apellido_paterno', 'l.apellido_materno',
                'l.mes', 'l.ano', 'l.monto', 'l.estado', 'e.shortname as empresa', 'l.banco', 'l.numero_cuenta',
                DB::raw('DATE_FORMAT(l.fecha_pago, "%d/%m/%Y") fecha_pago')
            )
            ->join('empresas as e', 'e.id', '=', 'l.empresa_id')
            ->join('tipos_pago as tp', 'tp.id', '=', 'l.tipo_pago_id')
            ->whereIn('l.estado', [3, 4])
            ->where('l.fecha_pago', $fecha_pago)
            ->where('l.empresa_id', $empresa_id)
            ->when($banco !== 'TODOS', function($query) use ($banco) {
                $query->where('l.banco', $banco);
            })
            ->orderBy('l.apellido_paterno', 'ASC')
            ->get();
    }

    public static function getRechazados($empresa_id = 9)
    {
        return DB::table('pagos_rechazos as l')
            ->select(
                'l.id as key', 'l.id', 'l.rut', 'l.nombre', 'l.apellido_paterno', 'l.apellido_materno',
                'l.mes', 'l.ano', 'l.monto', 'e.shortname as empresa', 'l.banco', 'l.numero_cuenta',
                DB::raw('DATE_FORMAT(l.fecha_pago, "%d/%m/%Y") fecha_pago')
            )
            ->join('empresas as e', 'e.id', '=', 'l.empresa_id')
            ->where('l.empresa_id', $empresa_id)
            ->orderBy('l.apellido_paterno', 'ASC')
            ->get();
    }

    public static function toggleRechazo(int $tipo, $finiquitos)
    {
        try {
            if ($tipo === 1) {
                return DB::table('pagos')
                    ->whereIn('id', $finiquitos)
                    ->update([
                        'estado' => 4,
                        'fecha_hora_marca_rechazado' => now()->toDateTimeString()
                    ]);
            } else {
                return DB::table('pagos')
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

    public static function forPayment(string $fecha, array $finiquitos)
    {
        try {
            return DB::table('pagos')
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

    public static function massiveCreate(array $pagos, $tipo_pago_id)
    {
        $count = 0;
        $total = sizeof($pagos);
        $errors = [];

        foreach($pagos as $liquidacion)
        {
            try {
                DB::table('pagos')->updateOrInsert(
                    [
                        'code' => $liquidacion['IdLiquidacion']
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
                        'numero_cuenta' => $liquidacion['NumeroCuentaBancaria'],
                        'tipo_pago_id' => $tipo_pago_id
                    ]
                );

                $count++;
            } catch (\Exception $e) {
                array_push($errors, [
                    'code' => $liquidacion['IdLiquidacion'],
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

    public static function insertarTuRecibo(array $pagos)
    {
        $count = 0;
        $total = sizeof($pagos);
        $errors = [];

        foreach($pagos as $liquidacion)
        {
            try {
                DB::table('pagos')->updateOrInsert(
                    [
                        'id' => $liquidacion['id']
                    ],
                    [
                        'estado' => 1,
                        'fecha_hora_marca_firmado' => $liquidacion['fecha_firma']
                    ]
                );

                $count++;
            } catch (\Exception $e) {
                array_push($errors, [
                    'id' => $liquidacion['id'],
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

    public static function marcarPagadoMasivo($empresa_id, $fecha_pago)
    {
        try {
            return DB::table('pagos')
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

    public static function terminarProceso(array $finiquitos)
    {
        DB::beginTransaction();
        try {
            foreach ($finiquitos as $finiquitosId) {
                $finiquito = Pago::where('id', $finiquitosId)->first();

                if ($finiquito->estado === 3) {
                    $finiquito->estado = 5;
                    $finiquito->fecha_hora_marca_archivado = now()->toDateTimeString();
                    $finiquito->save();
                } else {

                    $rechazo = new PagoRechazo();
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
                    $rechazo->pago_id = $finiquito->id;
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

    public static function montosPorEstado(int $empresa_id = 9, int $tipo_pago_id = 0)
    {
        return DB::table('pagos as l')
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
            ->when($tipo_pago_id !== 0, function($query) use($tipo_pago_id) {
                $query->where('l.tipo_pago_id', $tipo_pago_id);
            })
            ->groupBy('l.empresa_id')
            ->first();
    }

    public static function montosPorEstadoPorAnio(int $empresa_id, int $tipo_pago_id)
    {
        $dataset = DB::table('pagos as l')
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
            ->when($tipo_pago_id !== 0, function($query) use ($tipo_pago_id) {
                $query->where('tipo_pago_id', $tipo_pago_id);
            })
            ->groupBy('l.ano')
            ->get();

        $dataset->transform(function($item) use ($empresa_id, $tipo_pago_id) {
            $children = DB::table('pagos as l')
                ->select(
                    'l.mes as id',
                    'l.mes as mes',
                    'l.ano as anio',
                    DB::raw('round( sum(case l.estado when 0 then l.monto else 0 end), 2 ) as pendiente'),
                    DB::raw('round( sum(case l.estado when 1 then l.monto else 0 end), 2 ) as firmados'),
                    DB::raw('round( sum(case l.estado when 2 then l.monto else 0 end), 2 ) as para_pago'),
                    DB::raw('round( sum(case l.estado when 5 then l.monto else 0 end), 2 ) as pagados'),
                    DB::raw('round( sum(l.monto), 2 ) as total')
                )
                ->where('l.empresa_id', [$empresa_id])
                ->where('l.ano', $item->anio)
                ->when($tipo_pago_id !== 0, function($query) use ($tipo_pago_id) {
                    $query->where('tipo_pago_id', $tipo_pago_id);
                })
                ->groupBy('l.mes')
                ->get();

            if ($children->count()) {
                foreach ($children as &$child) {
                    $child->key = $child->mes . '-' . $child->anio;
                }
                $item->children = $children;
            }

            return $item;
        });

        return $dataset;
    }

    public static function cantidadPagosPorDia($empresa_id, $desde, $hasta)
    {
        $dataset = DB::table('pagos as l')
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
