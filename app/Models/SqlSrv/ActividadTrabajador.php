<?php

namespace App\Models\Sqlsrv;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ActividadTrabajador extends Model
{
    public static function getUltimaByTrabajador($rut)
    {
        $activo = DB::connection('sqlsrv')
            ->table('dbo.Contratos as c')
            ->where('c.IndicadorVigencia', true)
            ->where('c.Jornal', true)
            ->where('c.RutTrabajador', $rut)
            ->first();

        if (!$activo) {
            return [
                'data' => null,
                'error' => true,
                'message' => 'Trabajador no activo o sin digitación'
            ];
        }

        $ultimaActividad = DB::connection('sqlsrv')
            ->table('dbo.ActividadTrabajador as at')
            ->select(
                'at.RutTrabajador as rut',
                //'at.FechaActividad as fecha_actividad',
                DB::raw("(t.ApellidoPaterno + ' ' + t.ApellidoMaterno + ' ' + t.Nombre) as nombre_completo"),
                DB::raw("CAST(at.FechaActividad as date) fecha_actividad"),
                'z.Nombre as zona_labor',
                'c.Nombre as cuartel',
                'at.HoraNormales as horas',
                'a.Nombre as labor',
                'e.Nombre as empresa'
            )
            ->join('dbo.Trabajador as t', [
                'at.IdEmpresa' => 't.IdEmpresa',
                'at.IdTrabajador' => 't.IdTrabajador'
            ])
            ->join('dbo.Zona as z', [
                'z.IdEmpresa' => 'at.IdEmpresa',
                'z.IdZona' => 'at.IdZona'
            ])
            ->join('dbo.Cuartel as c', [
                'at.IdEmpresa' => 'c.IdEmpresa',
                'at.IdZona' => 'c.IdZona',
                'at.IdCuartel' => 'c.IdCuartel'
            ])
            ->join('dbo.Actividades as a', [
                'a.IdEmpresa' => 'at.IdEmpresa',
                'a.IdFamilia' => 'at.IdFamilia',
                'a.IdActividad' => 'at.IdActividad'
            ])
            ->join('dbo.Empresa as e', [
                'e.IdEmpresa' => 'at.IdEmpresa'
            ])
            ->where('at.RutTrabajador', $rut)
            ->whereIn('t.IdEmpresa', [9, 14])
            ->orderBy('at.FechaActividad', 'DESC')
            ->first();

        return [
            'data' => $ultimaActividad,
            'error' => false,
            'message' => 'Ultima actividad correctamente'
        ];
    }
}
