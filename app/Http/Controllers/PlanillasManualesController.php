<?php

namespace App\Http\Controllers;

use App\Models\PlanillaManual;
use Illuminate\Http\Request;

class PlanillasManualesController extends Controller
{
    public function get(Request $request)
    {
        $tipoEntidad = $request->get('tipo');
        $empresaId = $request->get('empresa_id');

        $planillas = PlanillaManual::with('trabajador', 'usuario.trabajador')->where([
            'tipo_entidad' => $tipoEntidad,
            'empresa_id' => $empresaId,
        ])->get();

        return response()->json([
            'message' => 'Data obtenida correctamente',
            'data' => $planillas,
        ]);
    }
}
