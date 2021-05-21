<?php

namespace App\Http\Controllers;

use App\Models\InformeDescanso;
use App\Models\RegistroDescanso;
use App\Models\Trabajador;
use App\Models\ZonaLabor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;

class RegistrosDescansosController extends Controller
{
    public function store(Request $request)
    {
        if ($request->get('trabajador_id')) {
            $trabajadorId = $request->get('trabajador_id');
        } else {
            $trabajadorId = Trabajador::findOrCreate($request->get('trabajador'));
        }

        $rut = $request->get('rut');
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
        $numeroRegistro = $request->get('numero_registro');
        $fechaEmision = Carbon::parse($request->get('fecha_emision'));

        if ($fechaFin->lessThan($fechaInicio)) {
            return response()->json([
                'message' => 'La fecha de regreso es menor que la fecha de salida'
            ], 400);
        }

        $tipoLicencia = DB::connection('mysql')
            ->table('tipo_licencias_medicas')
            ->where([
                'id' => $tipoLicenciaId,
                'empresa_id' => $empresaId
            ])->first();

        if (!$tipoLicencia->permiso) {
            if (!$numeroRegistro || !$fechaEmision) {
                return response()->json([
                    'message' => 'Este tipo de licencia require N° REGISTRO y FECHA DE EMISIÓN'
                ], 400);
            }
        }

        $estaDeVacaciones = DB::connection('sqlsrv')
            ->table('Vacaciones as v')
            ->where(function ($query) use ($fechaInicio, $rut, $empresaId) {
                $query->where('v.RutTrabajador', $rut);
                $query->where('v.IdEmpresa', $empresaId);
                $query->whereDate('v.FechaInicio', '<=', $fechaInicio);
                $query->whereDate('v.FechaFinal', '>=', $fechaInicio);
            })
            ->orWhere(function ($query) use ($fechaFin, $rut, $empresaId) {
                $query->where('v.RutTrabajador', $rut);
                $query->where('v.IdEmpresa', $empresaId);
                $query->whereDate('v.FechaInicio', '<=', $fechaFin);
                $query->whereDate('v.FechaFinal', '>=', $fechaFin);
            })
            ->orderBy('v.FechaInicio', 'DESC')
            ->first();

        //dd($estaDeVacaciones);

        if ($estaDeVacaciones) {
            return response()->json([
                'message' => 'El trabajador esta de VACACIONES en desde ' . Carbon::parse($estaDeVacaciones->FechaInicio)->format('d/m/Y') . ' hasta el ' . Carbon::parse($estaDeVacaciones->FechaFinal)->format('d/m/Y')
            ], 400);
        }

        $observaciones = [
            'permisos' => [],
            'asistencias' => [],
            'registros_medicos' => [],
        ];

        $permisosInasistencias = DB::connection('sqlsrv')
            ->table('dbo.PermisosInasistencias as p')
            ->where([
                'p.RutTrabajador' => $rut
            ])
            ->whereDate('p.FechaInicio', '>=', $fechaInicio)
            ->whereDate('p.FechaTermino', '<=', $fechaFin)
            ->get();

        $asistencias = DB::connection('sqlsrv')
            ->table('dbo.ActividadTrabajador as a')
            ->where([
                'a.RutTrabajador' => $rut
            ])
            ->whereDate('a.FechaActividad', '>=', $fechaInicio)
            ->whereDate('a.FechaActividad', '<=', $fechaFin)
            ->get();

        $registrosMedicos = DB::connection('sqlsrv')
            ->table('dbo.PermisosInasistencias as p')
            ->select(
                'AutorizadoPor as tipo',
                DB::raw('COUNT(IdPermiso) as dias')
            )
            ->where('IdEmpresa', $empresaId)
            ->where('RutTrabajador', $rut)
            ->whereYear('FechaInicio', now()->year)
            ->whereIn('AutorizadoPor', ['CMP', 'ESSALUD'])
            ->groupBy('AutorizadoPor')
            ->get();

        foreach ($permisosInasistencias as $permiso) {
            array_push($observaciones['permisos'], 'El trabajador tiene ' . $permiso->MotivoAusencia . ' el dia ' . Carbon::parse($permiso->FechaInicio)->format('d/m/Y'));
        }

        foreach ($asistencias as $asistencia) {
            array_push($observaciones['asistencias'], 'El trabajador tiene ASISTENCIA el dia ' . Carbon::parse($asistencia->FechaActividad)->format('d/m/Y'));
        }

        foreach ($registrosMedicos as $registroMedico) {
            array_push($observaciones['registros_medicos'], "El trabajador tiene {$registroMedico->dias} dias registrados en {$registroMedico->tipo} en el año " . now()->year);
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
        $registroDescanso->numero_registro = !$tipoLicencia->permiso ? $numeroRegistro : null;
        $registroDescanso->fecha_emision = !$tipoLicencia->permiso ? $fechaEmision : null;
        if (
            sizeof($observaciones['permisos']) > 0 ||
            sizeof($observaciones['asistencias']) > 0 ||
            sizeof($observaciones['registros_medicos']) > 0
        ) {
            $registroDescanso->consideracion = json_encode($observaciones);
        } else {
            $registroDescanso->consideracion = null;
        }
        $registroDescanso->save();

        return response()->json([
            'message' => 'Registro creado correctamente',
            'observaciones' => (
                sizeof($observaciones['permisos']) > 0 ||
                sizeof($observaciones['asistencias']) > 0 ||
                sizeof($observaciones['registros_medicos']) > 0
            ) ? $observaciones : null
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

    public function export(Request $request)
    {
        $desde = $request->get('desde');
        $hasta = $request->get('hasta');

        $result = DB::table('registros_descansos_medicos', 'r')
            ->select(
                't.code',
                't.rut',
                DB::raw("CONCAT(t.apellido_paterno, ' ', t.apellido_materno, ' ', t.nombre) as trabajador"),
                'tlm.name as contingencia',
                'zl.name as zona_labor',
                'r.fecha_inicio as fecha_inicio',
                'r.fecha_fin as fecha_fin',
                DB::raw("DATEDIFF(r.fecha_fin, r.fecha_inicio) + 1 as total_dias"),
                'r.observacion',
                'r.numero_registro',
                'r.fecha_emision',
                'e.shortname as empresa',
                'idm.empresa_id as empresa_id',
                'idm.id as informe_id',
                'idm.fecha_inicio as fecha_informe'
            )
            ->join('informes_descansos_medicos as idm', 'r.informe_descanso_medico_id', '=', 'idm.id')
            ->join('trabajadores as t', 'r.trabajador_id', '=', 't.id')
            ->join('tipo_licencias_medicas as tlm', [
                'r.tipo_licencia_medica_id' => 'tlm.id',
                'idm.empresa_id' => 'tlm.empresa_id'
            ])
            ->join('zona_labores as zl', 'r.zona_labor_id', '=', 'zl.id')
            ->join('empresas as e', 'e.id', '=', 'idm.empresa_id')
            ->whereBetween('idm.fecha_inicio', [$desde, $hasta])
            ->get();

        return (new FastExcel($result))->download('INFORMES_' . $desde . '_' . $hasta . '.xlsx', function ($registro) {
            return [
                'CODIGO' => $registro->code,
                'DNI' => $registro->rut,
                'APELLIDOS Y NOMBRES' => $registro->trabajador,
                'CONTINGENCIA' => $registro->contingencia,
                'FUNDO' => $registro->zona_labor,
                'DEL' => $registro->fecha_inicio,
                'AL' => $registro->fecha_fin,
                'TOTAL' => $registro->total_dias,
                'OBSERVACION(ES)' => $registro->observacion,
                'N° REGISTRO' => $registro->numero_registro,
                'FECHA EMISION' => $registro->fecha_emision,
                'EMPRESA' => $registro->empresa,
                'N° INFORME' => InformeDescanso::obtenerCorrelativo($registro->informe_id, $registro->empresa_id, $registro->fecha_informe),
                'FECHA INFORME' => $registro->fecha_informe
            ];
        });
    }
}
