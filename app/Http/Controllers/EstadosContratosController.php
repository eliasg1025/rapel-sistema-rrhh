<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstadosContratosController extends Controller
{
    public function get(Request $request)
    {
        $estados = DB::table('estados_contratos')->get();

        return response()->json([
            'message'   => 'Data obtenida correctamente',
            'data'      => $estados
        ]);
    }

    public function attach(Request $request)
    {
        $contrato_id = $request->get('contrato_id');
        $estado_id = $request->get('estado_id');

        DB::table('contratos_has_estados')->insert([
            'created_at'    => now(),
            'updated_at'    => now(),
            'estado_id'     => $estado_id,
            'contrato_id'   => $contrato_id,
        ]);

        return response()->json([
            'message' => 'Estado asignado correctamente'
        ]);
    }
}
