<?php

namespace App\Http\Controllers;

use App\Exports\OficiosSctrExport;
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

    public function exportarSctr()
    {
        $oficios = Oficio::getWithSctr();

        $data = [];

        foreach ($oficios as $oficio) {
            array_push($data, [
                'empresa' => $oficio->empresa,
                'oficio' => $oficio->oficio,
                'codigo' => $oficio->code
            ]);
        }

        return (new OficiosSctrExport($data))->download('EXPORT.xlsx');
    }

    public function getWithSctr()
    {
        $oficios = Oficio::getWithSctr();

        return response()->json($oficios);
    }

    public function getIndexesWithSctr($empresa_id)
    {
        $oficios = Oficio::getIndexesWithSctr($empresa_id);
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
