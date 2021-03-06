<?php

namespace App\Http\Controllers\Sqlsrv;

use App\Http\Controllers\Controller;
use App\Models\SqlSrv\Trabajador;
use Illuminate\Http\Request;

class TrabajadoresController extends Controller
{
    public function getParaFiniquito(Request $request, $rut)
    {
        $fechaFiniquito = $request->query('fecha_finiquito');
        $access = $request->query('access') == 1 ? true : false;

        $result = Trabajador::getTrabajadorParaFiniquito($rut, $fechaFiniquito, false, $access);

        if (isset($result['error'])) {
            return response()->json([
                'message'   => $result['message'],
                'data'      => $result['error']
            ], 400);
        }

        return response()->json($result);
    }
}
