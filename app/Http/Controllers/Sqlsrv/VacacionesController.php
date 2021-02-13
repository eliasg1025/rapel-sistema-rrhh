<?php

namespace App\Http\Controllers\Sqlsrv;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VacacionesController extends Controller
{
    public function programacionRetornos(Request $request)
    {
        $empresaId = $request->get('empresa_id');
        $desde = Carbon::parse($request->get('desde'));
        $hasta = Carbon::parse($request->get('hasta'));

        $registrosVacaciones = DB::connection('sqlsrv')
            ->table('dbo.Vacaciones as v')
            ->select(
                'v.IdVacacion',
                DB::raw("CAST(v.FechaInicio as date) FechaInicio"),
                DB::raw("CAST(v.FechaFinal as date) FechaFinal"),
                DB::raw("
                    CASE
                        WHEN DATEPART(dw, DATEADD(day, 1, CAST(v.FechaFinal as date))) = 7
                            THEN DATEADD(day, 2, CAST(v.FechaFinal as date))
                        ELSE
                            DATEADD(day, 1, CAST(v.FechaFinal as date))
                    END AS FechaRetorno
                "),
                DB::raw('(DATEDIFF(DAY, v.FechaInicio, v.FechaFinal) + 1) as Dias'),
                'e.Nombre as Empresa',
                'o.Descripcion as Oficio',
                DB::raw("
                    CASE
                        WHEN t.IdTipoDctoIden = 1
                            THEN RIGHT('000000' + CAST(t.RutTrabajador as varchar), 8)
                        ELSE
                            RIGHT('000000' + CAST(t.RutTrabajador as varchar), 9)
                    END AS RutTrabajador
                "),
                DB::raw("(t.ApellidoPaterno + ' ' + t.ApellidoMaterno + ' ' + t.Nombre) as Trabajador"),
                'z.Nombre as ZonaLabor',
                'r.Descripcion as Regimen'
            )
            ->join('dbo.Empresa as e', 'e.IdEmpresa', '=', 'v.IdEmpresa')
            ->join('dbo.Trabajador as t ', [
                't.IdEmpresa' => 'v.IdEmpresa',
                't.IdTrabajador' => 'v.IdTrabajador'
            ])
            ->join('dbo.Contratos as c', [
                'c.IdEmpresa' => 'v.IdEmpresa',
                'c.IdTrabajador' => 'v.IdTrabajador'
            ])
            ->join('dbo.Oficio as o', [
                'o.IdEmpresa' => 'c.IdEmpresa',
                'o.IdOficio' => 'c.IdOficio'
            ])
            ->join('dbo.Zona as z', [
                'z.IdEmpresa' => 't.IdEmpresa',
                'z.IdZona' => 't.IdZonaLabores'
            ])
            ->join('dbo.TipoRegimen as r', [
                'r.IdTipo' => 'c.IdRegimen'
            ])
            ->where('c.IndicadorVigencia', true)
            ->whereDate('v.FechaFinal', '>=', $desde)
            ->whereDate('v.FechaFinal', '<=', $hasta)
            ->when($empresaId != 0, function($query) use ($empresaId) {
                $query->where('v.IdEmpresa', $empresaId);
            })
            ->when($empresaId == 0, function($query) {
                $query->whereIn('v.IdEmpresa', [9, 14]);
            })
            ->orderBy('v.FechaFinal', 'ASC')
            ->orderBy('z.Nombre', 'ASC')
            ->orderBy('r.IdTipo', 'ASC')
            ->orderBy('o.Descripcion', 'ASC')
            ->orderBy('t.ApellidoPaterno', 'ASC')
            ->get();

        return response()->json([
            'message' => 'Programacion obtenida correctamente',
            'data' => $registrosVacaciones
        ]);
    }
}
