<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BonosService
{
    public function queryResult($empresaId, $desde, $hasta, $zonasIds, $laboresIds, $cuartelesIds)
    {
        $desde = Carbon::parse($desde)->format('Ymd h:i:s');
        $hasta = Carbon::parse($hasta)->format('Ymd h:i:s');

        $asistencias = DB::connection('sqlsrv')->table('dbo.ActividadTrabajador as a')
            ->select(
                DB::raw('DATEPART(DAY, a.fechaActividad) as dia'),
                DB::raw('DATEPART(WEEK, a.fechaActividad) as semana'),
                DB::raw("(t.ApellidoPaterno + ' ' + t.ApellidoMaterno + ' ' + t.Nombre) as nombre_completo"),
                't.RutTrabajador as rut',
                't.IdTrabajador as codigo',
                'a.idEmpresa as empresa_id',
                'c.FechaTermino as fecha_finiquito',
                'act.IdActividad as labor_id',
                'act.Nombre as labor',
                'cu.IdCuartel as cuartel_id',
                'cu.Nombre as cuartel',
                'a.HoraNormales as horas'
            )
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
            ->when(sizeof($zonasIds) !== 0, function($query) use ($zonasIds) {
                $query->whereIn('a.IdZona', $zonasIds);
            })
            ->when(sizeof($laboresIds) !== 0, function($query) use ($laboresIds) {
                $query->whereIn('act.IdActividad', $laboresIds);
            })
            ->when(sizeof($cuartelesIds) !== 0, function($query) use ($cuartelesIds) {
                $query->whereIn('c.IdCuartel', $cuartelesIds);
            })
            ->whereBetween('a.FechaActividad', [$desde, $hasta])
            ->where([
                'a.idEmpresa' => $empresaId,
            ]);


        $pivotQuery = "
            asistencias.codigo,
            asistencias.rut,
            asistencias.empresa_id,
            asistencias.nombre_completo,
            asistencias.dia,
            asistencias.semana,
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
            ->joinSub($asistencias, 'asistencias', function($join) {
                $join->on([
                    'asistencias.codigo' => 't.idTrabajador',
                    'asistencias.empresa_id' => 't.idEmpresa'
                ]);
            })->get();


        $pivot = function ($query) use ($asistencias, $pivotQuery) {
            $query->selectRaw($pivotQuery)
                ->from('dbo.Trabajador as t')
                ->joinSub($asistencias, 'asistencias', function($join) {
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
                'fecha_finiquito'
            )
            ->groupBy('codigo', 'rut', 'nombre_completo', 'fecha_finiquito')
            ->orderBy('nombre_completo', 'ASC')
            ->get();

        $result->transform(function($item) use ($pivotTable) {
            $dias = array_values($pivotTable->where('codigo', $item->codigo)->toArray());

            foreach ($dias as $dia) {
                $item->{$dia->dia} = $dia->{$dia->dia};
            }
            //$item->subquery = $data;
            return $item;
        });

        return $result;
    }
}
