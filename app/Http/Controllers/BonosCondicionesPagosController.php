<?php

namespace App\Http\Controllers;

use App\Models\BonoCondicionPago;
use Illuminate\Http\Request;

class BonosCondicionesPagosController extends Controller
{
    public function create(Request $request)
    {
        $condicion = new BonoCondicionPago();
        $condicion->condicion = $request->condicion;
        $condicion->recuento = $request->recuento;
        $condicion->variable_utilizada = $request->variableUtilizada;
        $condicion->valor_bono = $request->valorBono;
        $condicion->valor_descuento = $request->valorDescuento;
        $condicion->valor_meta = $request->valorMeta;
        $condicion->bono_id = $request->bonoId;
        $condicion->save();

        return response()->json([
            'message' => 'Condicion de bono creada correctamente',
            'data' => $condicion,
        ]);
    }

    public function getLastByBono($id)
    {
        $data = BonoCondicionPago::where('bono_id', $id)
            ->orderBy('created_at', 'DESC')
            ->first();

        return response()->json([
            'message' => 'Condicion de bono obtenido',
            'data' => $data,
        ]);
    }
}
