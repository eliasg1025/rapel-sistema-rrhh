<?php

namespace App\Http\Controllers;

use App\Models\SancionEpp;
use Illuminate\Http\Request;

class SancionesEppsController extends Controller
{
    public function get(Request $request)
    {
        $usuario_id = $request->usuario_id;
        $fechas = [
            'desde' => $request->desde,
            'hasta' => $request->hasta
        ];

        $result = SancionEpp::_get($usuario_id, $fechas);

        if (isset($result['error'])) {
            return response()->json([
                'message' => $result['message']
            ], 400);
        }

        return response()->json($result);
    }

    public function delete($id)
    {
        $form = SancionEpp::find($id);

        if ($form->delete()) {
            return response()->json([
                'message' => 'Registro borrado correctamente'
            ]);
        }
        return response()->json([
            'message' => 'Error al borrar el registro'
        ], 400);
    }

    public function create(Request $request)
    {
        $result = SancionEpp::_create($request->all());
        if (!$result['error']) {
            return response()->json($result);
        }

        return response()->json($result, 400);
    }

    public function generarSancion($id, Request $request)
    {
        $result = SancionEpp::_generarSancion($id, $request->all());
        if (!$result['error']) {
            return response()->json($result);
        }

        return response()->json($result, 400);
    }
}
