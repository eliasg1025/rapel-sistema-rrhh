<?php

namespace App\Services;

use App\Models\Bono;
use App\Models\BonoCondicionPago;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class BonosService
{
    private function getInfoFechas(CarbonPeriod $periodo, BonoCondicionPago $condicion)
    {
        $fechas = [];
        $recuentos = [];

        foreach ($periodo as $date) {
            $day = $date->day;
            if ($date->dayOfWeek !== 0) {
                $fechas[$day] = 0;
            } else {
                $fechas[$day] = null;
                array_push($recuentos, $day);
            }
        }

        if ($periodo->last()->dayOfWeek !== 0) {
            array_push($recuentos, $periodo->last()->day);
        };

        if ($condicion->recuento === 'quincenal') {
            $recuentos = [end($recuentos)];
        }

        return [
            (object) $fechas,
            $recuentos
        ];
    }

    public function getPermisosInasistencias(Bono $bono, $desde, $hasta, array $ruts=[])
    {
        $permisosInasistencias = DB::connection('sqlsrv')->table('dbo.PermisosInasistencias as p')
            ->select(
                'IdEmpresa as empresa_id',
                'idTrabajador as codigo',
                'RutTrabajador as rut',
                DB::raw('CAST(FechaInicio as date) as fecha'),
                DB::raw('DATEPART(DAY, FechaInicio) as dia'),
                'HoraInasistencia as horas',
                'MotivoAusencia as motivo'
            )
            ->where('p.IdEmpresa', $bono->empresa_id)
            ->whereBetween('p.FechaInicio', [$desde, $hasta])
            ->when(sizeof($ruts) !== 0, function($query) use ($ruts) {
                $query->whereIn('RutTrabajador', $ruts);
            })
            ->get();

        return $permisosInasistencias;
    }

    public function getInasistencias(Bono $bono, $desde, $hasta)
    {
        // ['FALTA', 'FALTA JUSTIFICADA', 'PERMISO']
        $permisosInasistencias = DB::connection('sqlsrv')->table('dbo.PermisosInasistencias as p')
            ->select(
                'IdEmpresa as empresa_id',
                'idTrabajador as codigo',
                'RutTrabajador as rut',
                DB::raw('CAST(FechaInicio as date) as fecha'),
                DB::raw('DATEPART(DAY, FechaInicio) as dia'),
                'MotivoAusencia as motivo'
            )
            ->where('p.IdEmpresa', $bono->empresa_id)
            ->whereIn('p.MotivoAusencia', ['FALTA', 'FALTA JUSTIFICADA', 'PERMISO'])
            ->where('p.HoraInasistencia', 8)
            ->whereBetween('p.FechaInicio', [$desde, $hasta])
            ->get();

        return $permisosInasistencias;
    }

    private function getResultados($fechas, $condicion, $recuentos, $inasistencias)
    {
        $asArr = get_object_vars($fechas);

        $acc = 0;
        $accRecuentos = 0;

        foreach ($asArr as $key => $value)
        {
            $condicional = 0;
            switch ($condicion->condicion) {
                case '>':
                    $condicional = $value > $condicion->valor_meta;
                    break;
                case '<':
                    $condicional = $value < $condicion->valor_meta;
                    break;
                case '=':
                    $condicional = $value == $condicion->valor_meta;
                    break;
                case '>=':
                    $condicional = $value >= $condicion->valor_meta;
                    break;
                case '<=':
                    $condicional = $value <= $condicion->valor_meta;
                    break;
            }

            $hayInasistencia = in_array($key, $inasistencias);

            if ($hayInasistencia) {
                $newValue = ((double) $condicion->valor_descuento) * (-1);
            } else {
                $newValue = !is_null($value) ? (
                    $condicional ? (double) $condicion->valor_bono : null
                ) : null;
            }

            $asArr[$key] = $newValue;
            $acc += $newValue;

            if (!is_bool(array_search($key, $recuentos))) {
                $valorRecuento = $acc >= 0 ? $acc : 0;
                $asArr['recuento_hasta_' . $key] = round($valorRecuento, 2);
                $accRecuentos += $valorRecuento;
                $acc = 0;
            }
        }
        $asArr['total_bono'] = round($accRecuentos, 2);

        return (object) $asArr;
    }

    private function getColumnsFromDates($fechas, $recuentos, $tipo)
    {
        $columns = [
            [
                'title' => 'Apellidos y Nombre',
                'dataIndex' => 'nombre_completo'
            ],
            [
                'title' => 'DNI',
                'dataIndex' => 'rut'
            ],
            [
                'title' => 'Cod.',
                'dataIndex' => 'codigo'
            ],
            [
                'title' => 'Banco',
                'dataIndex' => 'banco'
            ],
            [
                'title' => 'Fecha Ingreso',
                'dataIndex' => 'fecha_ingreso'
            ],
            [
                'title' => 'Fecha Finiquito',
                'dataIndex' => 'fecha_finiquito'
            ],
        ];

        if ($tipo === 'actividades') {
            $keys = array_keys(get_object_vars($fechas));

            foreach ($keys as $key) {
                array_push($columns, [
                    'title' => (string) $key,
                    'dataIndex' => (string) $key
                ]);
            }
        } else {
            $keys = array_keys(get_object_vars($fechas));

            foreach ($keys as $key) {
                array_push($columns, [
                    'title' => (string) $key,
                    'dataIndex' => (string) $key
                ]);

                if (!is_bool(array_search($key, $recuentos))) {
                    array_push($columns, [
                        'title' => 'Recuento Hasta ' . $key,
                        'dataIndex' => 'recuento_hasta_' . $key,
                    ]);
                }
            }

            array_push($columns, [
                'title' => 'Total Bono',
                'dataIndex' => 'total_bono'
            ]);
        }

        return $columns;
    }

    private function getResumen($condicion, $actividades)
    {
        foreach ($actividades as $actividad) {
            $condicional = 0;
            switch ($condicion->condicion) {
                case '>':
                    $condicional = $actividad->horas > $condicion->valor_meta;
                    break;
                case '<':
                    $condicional = $actividad->horas < $condicion->valor_meta;
                    break;
                case '=':
                    $condicional = $actividad->horas == $condicion->valor_meta;
                    break;
                case '>=':
                    $condicional = $actividad->horas >= $condicion->valor_meta;
                    break;
                case '<=':
                    $condicional = $actividad->horas <= $condicion->valor_meta;
                    break;
            }

            $valor = !is_null($actividad->horas) ? (
                $condicional ? (double) $condicion->valor_bono : null
            ) : null;

            $actividad->valor = $valor;
        }

        return $actividades;
    }

    /**
     * Permite obtener la tarja de los trabajadores a los que se les aplicará el bono
     */
    public function getPlanilla(Bono $bono, $_desde, $_hasta)
    {
        $desde = Carbon::parse($_desde)->subDay()->format('Ymd h:i:s');
        $hasta = Carbon::parse($_hasta)->format('Ymd h:i:s');
        $periodo = CarbonPeriod::create($_desde, $_hasta);

        /**
         * Recuperando la ultima condicion de pago para el bono
         */
        $bono->reglas;
        $bono->condicion = BonoCondicionPago::where('bono_id', $bono->id)->orderBy('created_at', 'DESC')->first();

        $sql = DB::connection('sqlsrv')->table('dbo.ActividadTrabajador as a')
            ->select([
                DB::raw('DATEPART(DAY, a.fechaActividad) as dia'),
                DB::raw('DATEPART(WEEK, a.fechaActividad) as semana'),
                DB::raw("(t.ApellidoPaterno + ' ' + t.ApellidoMaterno + ' ' + t.Nombre) as nombre_completo"),
                DB::raw("
                    CASE
                        WHEN t.IdTipoDctoIden = 1
                            THEN RIGHT('000000' + CAST(t.RutTrabajador as varchar), 8)
                        ELSE
                            RIGHT('000000' + CAST(t.RutTrabajador as varchar), 9)
                    END AS rut
                "),
                't.IdTrabajador as codigo',
                'a.idEmpresa as empresa_id',
                DB::raw('cast(c.FechaInicioPeriodo as date) as fecha_ingreso'),
                DB::raw('cast(c.FechaTermino as date) as fecha_finiquito'),
                'act.IdActividad as labor_id',
                'act.Nombre as labor',
                'cu.IdCuartel as cuartel_id',
                'cu.Nombre as cuartel',
                'a.'. $bono->condicion->variable_utilizada . ' as horas',
                'b.Nombre as banco',
                DB::raw("(cast(z.IdZona as varchar) + ' ' + z.Nombre) zona_labor"),
            ])
            ->join('dbo.Trabajador as t', [
                'a.idTrabajador' => 't.idTrabajador',
                'a.idEmpresa' => 't.idEmpresa'
            ])
            ->join('dbo.Contratos as c', [
                'c.idContrato' => 'a.idContrato',
                'a.idEmpresa' => 'c.idEmpresa'
            ])
            ->join('dbo.Cuartel as cu', [
                'cu.idEmpresa' => 'a.idEmpresa',
                'cu.idZona' => 'a.idZona',
                'cu.idCuartel' => 'a.idCuartel'
            ])
            ->join('dbo.Actividades as act', [
                'act.idFamilia' => 'a.idFamilia',
                'act.idEmpresa' => 'a.idEmpresa',
                'act.idActividad' => 'a.idActividad'
            ])
            ->join('dbo.Banco as b', [
                'b.idBanco' => 't.idBanco',
                'b.idEmpresa' => 't.idEmpresa'
            ])
            ->join('dbo.Zona as z', [
                'z.IdZona' => 'a.IdZona',
                'z.IdEmpresa' => 'a.IdEmpresa'
            ]);

        foreach ($bono->reglas as $regla) {
            $sql->orWhere(function($query) use ($regla, $bono, $desde, $hasta) {
                $query
                    ->where('a.idEmpresa', $bono->empresa_id)
                    ->whereBetween('a.FechaActividad', [$desde, $hasta])
                    ->when($regla->zona_id !== '0', function($query) use ($regla) {
                        $query->where('a.IdZona', $regla->zona_id);
                    })
                    ->when($regla->regimen_id !== '0', function ($query) use ($regla) {
                        $query->where('c.IdRegimen', $regla->regimen_id);
                    })
                    ->when($regla->labor_id !== '0', function($query) use ($regla) {
                        $query->where('act.IdActividad', $regla->labor_id);
                    })
                    ->when($regla->actividad_id !== '0', function($query) use ($regla) {
                        $query->where('act.IdFamilia', $regla->actividad_id);
                    })
                    ->when($regla->cuartel_id !== '0', function($query) use ($regla) {
                        $query->where('c.IdCuartel', $regla->cuartel_id);
                    })
                    ->when(!is_null($regla->rut), function($query) use ($regla) {
                        $query->where('a.RutTrabajador', $regla->rut);
                    })
                    ->when($regla->ciclo, function($query) use ($regla) {
                        $query->where('a.Ciclo', $regla->ciclo);
                    })
                    ->when($regla->etapa, function($query) use ($regla) {
                        $query->where('a.ETAPA', $regla->etapa);
                    });
            });
        }

        $dataSinProcesar = $this->getResumen($bono->condicion, $sql->get());

        $pivotQuery = "
            asistencias.codigo,
            asistencias.rut,
            asistencias.empresa_id,
            asistencias.nombre_completo,
            asistencias.dia,
            asistencias.semana,
            asistencias.banco,
            asistencias.fecha_ingreso,
            asistencias.fecha_finiquito,
            [1] = case when asistencias.dia = 1 then CONVERT(float, asistencias.horas) end,
            [2] = case when asistencias.dia = 2 then CONVERT(float, asistencias.horas) end,
            [3] = case when asistencias.dia = 3 then CONVERT(float, asistencias.horas) end,
            [4] = case when asistencias.dia = 4 then CONVERT(float, asistencias.horas) end,
            [5] = case when asistencias.dia = 5 then CONVERT(float, asistencias.horas) end,
            [6] = case when asistencias.dia = 6 then CONVERT(float, asistencias.horas) end,
            [7] = case when asistencias.dia = 7 then CONVERT(float, asistencias.horas) end,
            [8] = case when asistencias.dia = 8 then CONVERT(float, asistencias.horas) end,
            [9] = case when asistencias.dia = 9 then CONVERT(float, asistencias.horas) end,
            [10] = case when asistencias.dia = 10 then CONVERT(float, asistencias.horas) end,
            [11] = case when asistencias.dia = 11 then CONVERT(float, asistencias.horas) end,
            [12] = case when asistencias.dia = 12 then CONVERT(float, asistencias.horas) end,
            [13] = case when asistencias.dia = 13 then CONVERT(float, asistencias.horas) end,
            [14] = case when asistencias.dia = 14 then CONVERT(float, asistencias.horas) end,
            [15] = case when asistencias.dia = 15 then CONVERT(float, asistencias.horas) end,
            [16] = case when asistencias.dia = 16 then CONVERT(float, asistencias.horas) end,
            [17] = case when asistencias.dia = 17 then CONVERT(float, asistencias.horas) end,
            [18] = case when asistencias.dia = 18 then CONVERT(float, asistencias.horas) end,
            [19] = case when asistencias.dia = 19 then CONVERT(float, asistencias.horas) end,
            [20] = case when asistencias.dia = 20 then CONVERT(float, asistencias.horas) end,
            [21] = case when asistencias.dia = 21 then CONVERT(float, asistencias.horas) end,
            [22] = case when asistencias.dia = 22 then CONVERT(float, asistencias.horas) end,
            [23] = case when asistencias.dia = 23 then CONVERT(float, asistencias.horas) end,
            [24] = case when asistencias.dia = 24 then CONVERT(float, asistencias.horas) end,
            [25] = case when asistencias.dia = 25 then CONVERT(float, asistencias.horas) end,
            [26] = case when asistencias.dia = 26 then CONVERT(float, asistencias.horas) end,
            [27] = case when asistencias.dia = 27 then CONVERT(float, asistencias.horas) end,
            [28] = case when asistencias.dia = 28 then CONVERT(float, asistencias.horas) end,
            [29] = case when asistencias.dia = 29 then CONVERT(float, asistencias.horas) end,
            [30] = case when asistencias.dia = 30 then CONVERT(float, asistencias.horas) end,
            [31] = case when asistencias.dia = 31 then CONVERT(float, asistencias.horas) end
        ";

        $pivotTable = DB::connection('sqlsrv')->table('dbo.Trabajador as t')
            ->selectRaw($pivotQuery)
            ->joinSub($sql, 'asistencias', function($join) {
                $join->on([
                    'asistencias.codigo' => 't.idTrabajador',
                    'asistencias.empresa_id' => 't.idEmpresa'
                ]);
            })->get();

        $pivot = function ($query) use ($sql, $pivotQuery) {
            $query->selectRaw($pivotQuery)
                ->from('dbo.Trabajador as t')
                ->joinSub($sql, 'asistencias', function($join) {
                    $join->on([
                        'asistencias.codigo' => 't.idTrabajador',
                        'asistencias.empresa_id' => 't.idEmpresa'
                    ]);
                });
        };

        $result = DB::connection('sqlsrv')->table($pivot, 'p')
            ->select(
                'codigo',
                'rut',
                'nombre_completo',
                'fecha_ingreso',
                DB::raw("MAX(fecha_finiquito) as fecha_finiquito"),
                'banco'
            )
            ->groupBy('codigo', 'rut', 'nombre_completo', 'banco', 'fecha_ingreso')
            ->orderBy('nombre_completo', 'ASC');

        $ruts = $result->pluck('rut')->toArray();

        $inasistencias = $this->getPermisosInasistencias($bono, $desde, $hasta, $ruts);

        $result = $result->get();

        /**
         * Obteniendo la fechas de la tarja asi como las fechas de los recuentos dependiendo de las condiciones
         */
        [$fechas, $recuentos] = $this->getInfoFechas($periodo, $bono->condicion);

        $result->transform(function($item) use ($pivotTable, $bono, $fechas, $recuentos, $inasistencias, $desde, $hasta) {
            $dias = array_values($pivotTable->where('codigo', $item->codigo)->toArray());
            $inasistencias = array_values($inasistencias->where('codigo', $item->codigo)->toArray());

            $item->fechas = clone $fechas;
            $item->inasistencias = [];

            foreach ($dias as $dia) {
                $item->fechas->{$dia->dia} = (double) $dia->{$dia->dia};
            }

            foreach ($fechas as $fecha => $valor) {
                $permisoInasistencia = array_search($fecha, array_column($inasistencias, 'dia'));
                if (!is_bool($permisoInasistencia)) {
                    $motivo = $this->getSiglaMotivo($inasistencias[$permisoInasistencia]->motivo);
                    $item->fechas->{$fecha} = $item->fechas->{$fecha} != 0 ? $item->fechas->{$fecha} . '/' . $motivo : $motivo;
                } else {
                    if ($item->fechas->{$fecha} == 0) {
                        // dd($item->fechas);
                        $item->fechas->{$fecha} = 'A';
                    }
                }
            }

            $item->resultado = $this->getResultados($item->fechas, $bono->condicion, $recuentos, []);

            return $item;
        });

        return [
            'info' => [
                'columnas' => [
                    'actividades'   => $this->getColumnsFromDates($fechas, $recuentos, 'actividades'),
                    'resultados'    => $this->getColumnsFromDates($fechas, $recuentos, 'resultados')
                ],
                'recuentos' => $recuentos
            ],
            'output'    => $result,
            'rows'      => $dataSinProcesar,
        ];
    }

    public function getSiglaMotivo($motivoPalabra) {
        $motivo = '';
        switch ($motivoPalabra) {
            case 'PERMISO CON':
                $motivo = 'PC';
                break;

            case 'LICENCIA':
                $motivo = 'L';
                break;

            case 'PERMISO':
                $motivo = 'PS';
                break;

            case 'PERSONAL SUSPENDIDOS':
                $motivo = 'S';
                break;

            case 'PERSONAL CON S.P.L':
                $motivo = 'SPL';
                break;

            case 'FALTA JUSTIFICADA';
                $motivo = 'FJ';
                break;

            case 'FALTA';
                $motivo = 'F';
                break;

            default:
                $motivo = 'A';
                break;
        }

        return $motivo;
    }
}
