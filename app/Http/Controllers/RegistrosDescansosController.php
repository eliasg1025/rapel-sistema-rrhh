<?php

namespace App\Http\Controllers;

use App\Models\RegistroDescanso;
use App\Models\Trabajador;
use App\Models\ZonaLabor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrosDescansosController extends Controller
{
    public function store(Request $request)
    {
        if ($request->get('trabajador_id')) {
            $trabajadorId = $request->get('trabajador_id');
        } else {
            $trabajadorId = Trabajador::findOrCreate($request->get('trabajador'));
        }

        $fechaInicio = Carbon::parse($request->get('fecha_inicio'));
        $fechaFin = Carbon::parse($request->get('fecha_fin'));
        $empresaId = $request->get('empresa_id');
        $observacion = $request->get('observacion');
        $tipoLicenciaId = $request->get('tipo_licencia_medica_id');
        $zonaLabor = ZonaLabor::where([
            'code' => $request->get('zona_labor_id'),
            'empresa_id' => $request->get('empresa_id')
        ])->first();
        $usuarioId = $request->get('usuario_id');
        $infomeMedicoId = $request->get('informe_id');

        if ($fechaFin->lessThan($fechaInicio)) {
            return response()->json([
                'message' => 'La fecha de regreso es menor que la fecha de salida'
            ], 400);
        }

        $observaciones = [
            'permisos' => [],
            'asistencias' => [],
        ];

        $permisosInasistencias = DB::connection('sqlsrv')
            ->table('dbo.PermisosInasistencias as p')
            ->where([
                'p.RutTrabajador' => $request->get('trabajador')['rut']
            ])
            ->whereDate('p.FechaInicio', '>=', $fechaInicio)
            ->whereDate('p.FechaInicio', '<=', $fechaFin)
            ->get();

        $asistencias = DB::connection('sqlsrv')
            ->table('dbo.ActividadTrabajador as a')
            ->where([
                'a.RutTrabajador' => $request->get('trabajador')['rut']
            ])
            ->whereDate('a.FechaActividad', '>=', $fechaInicio)
            ->whereDate('a.FechaActividad', '<=', $fechaFin)
            ->get();

        foreach ($permisosInasistencias as $permiso) {
            array_push($observaciones['permisos'], 'El trabajador tiene ' . $permiso->MotivoAusencia . ' el dia ' . Carbon::parse($permiso->FechaInicio)->format('d/m/Y'));
        }

        foreach ($asistencias as $asistencia) {
            array_push($observaciones['asistencias'], 'El trabajador tiene ASISTENCIA el dia ' . Carbon::parse($asistencia->FechaActividad)->format('d/m/Y'));
        }

        if (!$request->get('id')) {
            $registroDescanso = new RegistroDescanso();
        } else {
            $registroDescanso = RegistroDescanso::find($request->get('id'));
        }
        $registroDescanso->trabajador_id = $trabajadorId;
        $registroDescanso->fecha_inicio = $fechaInicio;
        $registroDescanso->fecha_fin = $fechaFin;
        $registroDescanso->observacion = $observacion;
        $registroDescanso->tipo_licencia_medica_id = $tipoLicenciaId;
        $registroDescanso->informe_descanso_medico_id = $infomeMedicoId;
        $registroDescanso->zona_labor_id = $zonaLabor->id;
        $registroDescanso->usuario_id = $usuarioId;

        $registroDescanso->save();

        return response()->json([
            'message' => 'Registro creado correctamente',
            'observaciones' => $observaciones
        ]);
    }

    public function delete($id)
    {
        $registro = RegistroDescanso::find($id);

        $registro->delete();

        return response()->json([
            'message' => 'Registro borrado correctamente'
        ]);
    }
}
