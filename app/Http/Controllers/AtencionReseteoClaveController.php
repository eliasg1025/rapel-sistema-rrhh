<?php

namespace App\Http\Controllers;

use App\Models\AtencionReseteoClave;
use Illuminate\Http\Request;

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
}
