<?php

namespace App\Http\Controllers;

use App\Models\SeguroVida;
use App\Models\Trabajador;
use Illuminate\Http\Request;

class SegurosVidaController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->all();
        $trabajadorId = Trabajador::findOrCreate($data['trabajador']);

        $seguro = new SeguroVida();
        $seguro->empresa_id = $data['empresa_id'];
        $seguro->trabajador_id = $trabajadorId;
        $seguro->usuario_id = $data['usuario_id'];
        $seguro->save();

        return response()->json([
            'message' => 'Guardado correctamente',
            'data' => $trabajadorId,
        ]);
    }

    public function get(Request $request)
    {
        $usuarioId = $request->get('usuario_id');

        $seguros = SeguroVida::where('usuario_id', $usuarioId)
            ->get();

        return response()->json([
            'message' => 'Data obtenida correctamente',
            'data' => $seguros
        ]);
    }
}
