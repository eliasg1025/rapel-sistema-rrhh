<?php

namespace App\Http\Controllers;

use App\Models\Cuartel;
use App\Models\ZonaLabor;
use Illuminate\Http\Request;

class CuartelController extends Controller
{
    public function create(Request $request)
    {
        $zona_labor_id = ZonaLabor::findOrCreate($request->get('zona_labor'));
        $cuartel_id = Cuartel::findOrCreate($request->get('cuartel'), $zona_labor_id);

        if (is_numeric($cuartel_id)) {
            return response()->json([
                'message' => 'Agregado correctamente',
                'oficio_id' => $cuartel_id
            ]);
        } else {
            return response()->json([
                'message' => 'Error al crear cuartel',
                'error' => $cuartel_id
            ], 400);
        }
    }

    public function getWithSctr()
    {
        $cuarteles = Cuartel::getWithSctr();

        return response()->json($cuarteles);
    }

    public function disableSctr($id)
    {
        $cuartel_id = Cuartel::disableSctr($id);
        if (is_numeric($cuartel_id)) {
            return response()->json([
                'message' => 'Deshabilitado correctamente',
                'oficio_id' => $cuartel_id
            ]);
        } else {
            return response()->json([
                'message' => 'Error al deshabilitar cuartel',
                'error' => $cuartel_id
            ], 400);
        }
    }
}
