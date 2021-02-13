<?php

namespace App\Http\Controllers\Sqlsrv;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RetornosController extends Controller
{
    public function programacionVacaciones(Request $request)
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

    public function programacionSPL(Request $request)
    {
        $empresaId = $request->get('empresa_id');
        $desde = Carbon::parse($request->get('desde'));
        $hasta = Carbon::parse($request->get('hasta'));

        $registros = DB::connection('sqlsrv')
            ->table('dbo.PermisosInasistencias as sus')
            ->select(
                'sus.IdTrabajador',
                'sus.IdEmpresa',
                'sus.USUARIO',
                'sus.RutTrabajador',
                'sus.FechaDigitacion',
                't.ApellidoPaterno',
                't.ApellidoMaterno',
                't.Nombre',
                'z.Nombre as ZonaLabor',
                'r.Descripcion as Regimen',
                'e.Nombre as Empresa',
                'o.Descripcion as Oficio',
            )
            ->join('dbo.Empresa as e', 'e.IdEmpresa', '=', 'sus.IdEmpresa')
            ->join('dbo.Trabajador as t ', [
                't.IdEmpresa' => 'sus.IdEmpresa',
                't.IdTrabajador' => 'sus.IdTrabajador'
            ])
            ->join('dbo.Contratos as c', [
                'c.IdEmpresa' => 'sus.IdEmpresa',
                'c.IdTrabajador' => 'sus.IdTrabajador'
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
            ->where('sus.IdEmpresa', $empresaId)
            ->where('c.IndicadorVigencia', true)
            ->whereDate('sus.FechaInicio', '>=', $desde)
            ->whereDate('sus.FechaInicio', '<=', $hasta)
            ->where('sus.MotivoAusencia', 'like', '%S.P.L%')
            ->groupBy(
                'sus.IdTrabajador', 'sus.IdEmpresa', 'sus.USUARIO', 'sus.FechaDigitacion', 'sus.RutTrabajador',
                'z.Nombre', 'r.Descripcion', 'e.Nombre', 'o.Descripcion', 't.ApellidoPaterno', 't.ApellidoMaterno', 't.Nombre'
            )
            ->get();


        $suspenciones = [];

        foreach ($registros as $registro) {
            $rangos = DB::connection('sqlsrv')
                ->table('dbo.PermisosInasistencias as sus')
                ->select(
                    DB::raw("MIN(sus.FechaInicio) as FechaInicio"),
                    DB::raw("MAX(sus.FechaInicio) as FechaFinal")
                )
                ->where([
                    'sus.IdEmpresa' => $registro->IdEmpresa,
                    'sus.IdTrabajador' => $registro->IdTrabajador,
                    // 'sus.USUARIO' => $registro->USUARIO,
                ])
                ->whereDate('sus.FechaDigitacion', '=', $registro->FechaDigitacion)
                ->where('sus.MotivoAusencia', 'like', '%S.P.L%')
                ->get();

            $new = $rangos[0];

            $new->RutTrabajador = $registro->RutTrabajador;
            $new->Empresa = $registro->Empresa;
            $new->ZonaLabor = $registro->ZonaLabor;
            $new->Regimen = $registro->Regimen;
            $new->Oficio = $registro->Oficio;
            $new->Trabajador = $registro->ApellidoPaterno . ' ' . $registro->ApellidoMaterno . ' ' . $registro->Nombre;

            $fechaFinal = Carbon::parse($new->FechaFinal);
            $fechaRetorno = $fechaFinal->dayOfWeek === 6 ? (clone $fechaFinal)->addDays(2) : (clone $fechaFinal)->addDay();

            $new->FechaRetorno = ($fechaRetorno)->toDateString();
            $new->FechaInicio = Carbon::parse($new->FechaInicio)->toDateString();
            $new->FechaFinal = Carbon::parse($new->FechaFinal)->toDateString();

            if (($fechaRetorno)->between($desde, $hasta)) {
                array_push($suspenciones, $new);
            }
        }

        return response()->json([
            'message' => 'Programación obtenida correctamente',
            'data' => $suspenciones
        ]);
    }
}
