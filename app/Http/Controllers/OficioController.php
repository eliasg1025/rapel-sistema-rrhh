<?php

namespace App\Http\Controllers;

use App\Exports\OficiosSctrExport;
use App\Models\Oficio;
use Illuminate\Http\Request;

class OficioController extends Controller
{
    public function create(Request $request)
    {
        try {
            $data = $request->all();

            $isNew = false;
            $oficio = Oficio::where([
                'code' => $data['id'],
                'empresa_id' => $data['empresa_id']
            ])->first();

            if (!$oficio) {
                $isNew = true;
                $oficio = new Oficio();
            }

            $oficio->code = $data['id'];
            $oficio->empresa_id = $data['empresa_id'];
            $oficio->cod_equ = $data['cod_equ'] ?? null;
            $oficio->name = $data['name'];
            if (isset($data['sctr'])) {
                $oficio->sctr = $data['sctr'];
            }
            $oficio->save();

            return response()->json([
                'message' => $isNew ? 'Agregado correctamente' : 'El oficio ya habia sido agregado anteriormente',
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message'   => 'Error al crear oficio',
                'error'     => $e->getMessage()
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
                'code' => $oficio->code,
                'codigo' => $oficio->code,
                'empresa_id' => $oficio->empresa_id,
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
