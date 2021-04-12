<?php

namespace App\Http\Controllers\Sqlsrv;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarcacionesAndroidController extends Controller
{
    public function get(Request $request)
    {
        $fecha = $request->get('fecha');
        $empresaId = $request->get('empresa_id');
        $rut = $request->get('rut');

        if (!$fecha) {
            return response()->json([
                'message' => 'Falta asignar una fecha',
            ], 400);
        }

        $result = DB::connection('sqlsrv2')->select("SPC_Marcacion_Android_Trab @IdEmpresa = $empresaId, @Desde = '$fecha', @Hasta = '$fecha', @RutTrabajador = $rut");

        return response()->json([
            'message' => 'Resultados obtenidos correctamente',
            'data' => $result
        ]);
    }
}
