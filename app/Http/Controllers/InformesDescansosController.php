<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\InformeDescanso;
use App\Models\RegistroDescanso;
use App\Models\SqlSrv\Trabajador as SqlSrvTrabajador;
use App\Models\Trabajador;
use App\Models\Usuario;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;

class InformesDescansosController extends Controller
{
    public function get (Request $request)
    {
        //RAPEL: 187
        //VERFRUT: 192
        $usuario = Usuario::find($request->get('usuarioId'));

        $registros = DB::table('registros_descansos_medicos as rdm')
            ->select(
                'rdm.informe_descanso_medico_id as id',
                DB::raw('COUNT(*) as cantidad_registros')
            )
            ->groupBy('rdm.informe_descanso_medico_id');

        $results = DB::table('informes_descansos_medicos as idm')
            ->select(
                'idm.id',
                'idm.empresa_id',
                'e.shortname as empresa',
                'registros.cantidad_registros',
                'idm.fecha_inicio',
                'idm.estado',
                DB::raw('CONCAT(t.nombre, " ", t.apellido_paterno, " ", t.apellido_materno) as nombre_completo_usuario')
            )
            ->join('empresas as e', 'e.id', '=', 'idm.empresa_id')
            ->join('usuarios as u', 'u.id', '=', 'idm.usuario_id')
            ->join('trabajadores as t', 't.id', '=', 'u.trabajador_id')
            ->leftJoinSub($registros, 'registros', function ($join) {
                $join->on('registros.id', '=', 'idm.id');
            })
            ->orderBy('idm.estado', 'ASC')
            ->orderBy('idm.id', 'DESC')
            /*
            ->when($usuario->descansos_medicos !== 2, function ($query) use ($usuario) {
                $query->where('idm.usuario_id', $usuario->id);
            })*/
            ->get();

        $results->transform(function ($item) {
            $item->informe = InformeDescanso::obtenerCorrelativo(
                $item->id,
                $item->empresa_id,
                $item->fecha_inicio
            );
            return $item;
        });

        return response()->json($results);
    }

    public function store (Request $request)
    {
        $usuarioId = $request->get('usuarioId');
        $fechaInicio = $request->get('fechaInicio');
        $empresaId = $request->get('empresaId');

        $empresa = Empresa::find($empresaId);

        $r = InformeDescanso::where([
            'empresa_id' => $empresaId,
            'estado' => 0
        ])->first();

        if ($r) {
            return response()->json([
                'message' => 'Informe de ' . $empresa->shortname . ' aún pendiente'
            ], 400);
        }

        try {
            $result = InformeDescanso::create([
                'usuario_id' => $usuarioId,
                'fecha_inicio' => $fechaInicio,
                'empresa_id' => $empresaId
            ]);

            return response()->json([
                'message' => 'Informe creado correctamente',
            ], 201);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Faltan parámetros'
            ], 400);
        }
    }

    public function show(Request $request, $id)
    {
        $informe = InformeDescanso::find($id);
        $empresa = Empresa::find($informe->empresa_id)->shortname;
        $trabajador = DB::table('usuarios as u')
            ->select(
                DB::raw("CONCAT(t.nombre, ' ', t.apellido_paterno, ' ', t.apellido_materno) as nombre_completo")
            )
            ->join('trabajadores as t', 't.id', '=', 'u.trabajador_id')
            ->where('u.id', $informe->usuario_id)
            ->first();

        $informe->empresa = $empresa;
        $informe->trabajador = $trabajador->nombre_completo;
        $informe->informe  = InformeDescanso::obtenerCorrelativo(
            $informe->id,
            $informe->empresa_id,
            $informe->fecha_incio
        );
        $informe->registros = RegistroDescanso::getByInforme($id);

        return $informe;
    }

    public function getTrabajador($rut, $empresaId)
    {
        $result = SqlSrvTrabajador::getObtenerTrabajador($rut, $empresaId);

        if (isset($result['error'])) {
            return response()->json([
                'message' => $result['error']
            ], 404);
        }

        return response()->json($result);
    }

    public function update(Request $request, $id)
    {
        $estado = $request->get('estado');
        $informe = InformeDescanso::find($id);
        $informe->estado = $estado;

        $registros = RegistroDescanso::getByInforme($id);

        if (sizeof($registros) === 0) {
            return response()->json([
                'message' => 'No tiene registros en este informe'
            ], 400);
        }

        $informe->save();

        return response()->json([
            'message' => $estado ? 'Informe Terminado' : 'Informe Pendiente'
        ]);
    }

    public function export($id)
    {
        $informe = InformeDescanso::find($id);
        $informe->informe  = InformeDescanso::obtenerCorrelativo(
            $informe->id,
            $informe->empresa_id,
            $informe->fecha_incio
        );
        $registros = RegistroDescanso::getByInforme($id);

        return (new FastExcel($registros))->download($informe->informe . '.xlsx', function ($registro) {
            return [
                'CODIGO' => $registro->code,
                'DNI' => $registro->rut,
                'APELLIDOS Y NOMBRES' => $registro->nombre_completo_trabajador,
                'CONTINGENCIA' => $registro->contingencia,
                'FUNDO' => $registro->zona_labor,
                'DEL' => $registro->fecha_inicio,
                'AL' => $registro->fecha_fin,
                'TOTAL' => $registro->total_dias,
                'OBSERVACION(ES)' => $registro->observacion,
                'N° REGISTRO' => $registro->numero_registro,
                'FECHA EMISION' => $registro->fecha_emision,
            ];
        });
    }

    public function verFicha(InformeDescanso $informe)
    {
        $empresa = Empresa::find($informe->empresa_id)->shortname;
        $trabajador = DB::table('usuarios as u')
            ->select(
                DB::raw("CONCAT(t.nombre, ' ', t.apellido_paterno, ' ', t.apellido_materno) as nombre_completo")
            )
            ->join('trabajadores as t', 't.id', '=', 'u.trabajador_id')
            ->where('u.id', $informe->usuario_id)
            ->first();

        $informe->empresa = $empresa;
        $informe->trabajador = $trabajador->nombre_completo;
        $informe->informe  = InformeDescanso::obtenerCorrelativo(
            $informe->id,
            $informe->empresa_id,
            $informe->fecha_incio
        );
        $informe->registros = RegistroDescanso::getByInforme($informe->id);

        try {
            $data = [
                'informe' => $informe,
                'codigo' => 6 . '@' . $informe->id
            ];

            $pdf = \PDF::setOptions([
                'images' => true
            ])->loadView('documents.descanso-medico.index', $data);

            $filename = $informe->informe . '.pdf';

            return $pdf->stream($filename);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
