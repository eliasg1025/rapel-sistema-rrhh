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

        $result = AtencionReseteoClave::_getAll($usuario_id, $fechas);

        if (isset($result['error'])) {
            return response()->json([
                'message' => $result['message']
            ]);
        }

        return response()->json($result);
    }
}
