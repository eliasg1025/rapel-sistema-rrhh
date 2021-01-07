<?php

namespace App\Http\Controllers;

use App\Models\AtencionReseteoClave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AtencionReseteoClaveController extends Controller
{
    public function create(Request $request)
    {
        $result = AtencionReseteoClave::_create($request->all());
        if (!$result['error']) {
            return response()->json($result);
        }

        return response()->json($result, 400);
    }

    public function getAll(Request $request)
    {
        $usuario_id = $request->usuario_id;
        $fechas = [
            'desde' => $request->desde,
            'hasta' => $request->hasta
        ];
        $estado = $request->estado;
        $usuario_carga_id = $request->usuario_carga_id;
        $rut = $request->rut;
        $tipo = $request->tipo;

        $result = AtencionReseteoClave::_getAll($usuario_id, $fechas, $estado, $usuario_carga_id, $rut, $tipo);

        if (isset($result['error'])) {
            return response()->json([
                'message' => $result['message']
            ], 400);
        }

        return response()->json($result);
    }

    public function getUsuariosCarga(Request $request)
    {
        $fechas = [
            'desde' => $request->desde,
            'hasta' => $request->hasta
        ];
        $estado = $request->estado;

        $result = AtencionReseteoClave::_getUsuariosCarga($fechas, $estado);

        return response()->json($result);
    }

    public function resolver(Request $request, $id)
    {
        $usuario_id = $request->usuario_id;
        $result = AtencionReseteoClave::resolver($usuario_id, $id);

        if (isset($result['error'])) {
            return response()->json([
                'message' => $result['message']
            ], 400);
        }

        return response()->json($result);
    }

    public function delete($id)
    {
        $atencion = AtencionReseteoClave::find($id);
        if ($atencion->delete()) {
            return response()->json([
                'message' => 'Registro borrado correctamente'
            ]);
        }

        return response()->json([
            'message' => 'Error al borrar el registro'
        ], 400);
    }

    public function getDataResumen()
    {
        $result = DB::select("
            select
                a.id,
                a.fecha_solicitud,
                e.shortname as empresa,
                t.rut,
                CONCAT(t.apellido_paterno,  ' ', t.apellido_materno, ' ', t.nombre) as trabajador,
                CONCAT(t_usuario.apellido_paterno,  ' ', t_usuario.apellido_materno, ' ', t_usuario.nombre) as enviado_por,
                concat(t_usuario2.apellido_paterno, ' ', t_usuario2.apellido_materno, ' ', t_usuario2.nombre) as atendido_por
            from atenciones_reseteo_clave as a
            inner join trabajadores t on a.trabajador_id = t.id
            inner join usuarios u on a.usuario_id = u.id
            inner join usuarios u2 on a.usuario2_id = u2.id
            inner join trabajadores t_usuario on t_usuario.id = u.trabajador_id
            inner join trabajadores t_usuario2 on t_usuario2.id = u2.trabajador_id
            inner join empresas e on a.empresa_id = e.id
        ");

        dd($result);
    }

    public function getResumen($filtros)
    {

    }
}
