<?php

namespace App\Http\Controllers;

use App\Models\CorteSctr;
use App\Models\RegistroSctr;
use Illuminate\Http\Request;

class CorteSctrController extends Controller
{
    public function create(Request $request)
    {
        $asegurados = $request->get('asegurados');

        $corte_sctr_id = CorteSctr::_create([
            'usuario_id' => $request->get('usuario_id'),
            'empresa_id' => $request->get('empresa_id'),
            'mes' => $request->get('mes'),
            'ano' => $request->get('ano')
        ]);

        $result = RegistroSctr::massiveCreate($asegurados, $corte_sctr_id);

        return response()->json($result);
    }
}
