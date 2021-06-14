<?php

namespace App\Http\Controllers;

use App\Models\ProcesoContrato;
use Illuminate\Http\Request;

class ProcesosContratosController extends Controller
{
    public function get(Request $request)
    {
        $user = $request->get('user');

        $procesos = ProcesoContrato::where('usuario_id', $user->id)->get();

        return response()->json([
            'data' => $procesos,
        ]);
    }

    public function create(Request $request)
    {
        $user = $request->get('user');

        [ 'datos_reniec' => $datosReniec, 'contrato' => $contratoInfo ] = $request->all();

        try {
            $proceso = new ProcesoContrato();
            $proceso->usuario_id = $user->id;
            $proceso->datos_reniec = $datosReniec;
            $proceso->contrato_info = json_encode($contratoInfo);
            $proceso->save();

            return response()->json([
                'message' => 'Proceso creado correctamente',
                'proceso' => $proceso,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
