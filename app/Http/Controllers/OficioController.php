<?php

namespace App\Http\Controllers;

use App\Models\Oficio;
use Illuminate\Http\Request;

class OficioController extends Controller
{
    public function create(Request $request)
    {
        $oficio = Oficio::findOrCreate($request->all());

        if (is_numeric($oficio)) {
            return response()->json([
                'message' => 'Agregado correctamente',
                'oficio_id' => $oficio
            ]);
        } else {
            return response()->json([
                'message' => 'Error al crear oficio',
                'error' => $oficio
            ], 400);
        }
    }

    public function getWithSctr()
    {
        $oficios = Oficio::getWithSctr();

        return response()->json($oficios);
    }

    public function disableSctr($id)
    {
        $oficio = Oficio::disableSctr($id);
        if (is_numeric($oficio)) {
            return response()->json([
                'message' => 'Deshabilitado correctamente',
                'oficio_id' => $oficio
            ]);
        } else {
            return response()->json([
                'message' => 'Error al deshabilitar oficio',
                'error' => $oficio
            ], 400);
        }
    }
}
