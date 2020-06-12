<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Trabajador;
use Illuminate\Http\Request;

class TrabajadorController extends Controller
{
    public function create(Request $request)
    {
        $is_save = Trabajador::_save($request->all());

        if ($is_save) {
            return response()->json([
                'message' => 'Trabajador creado correctamente'
            ], 201);
        } else {
            return response()->json([
                'message' => 'No se creo trabajador'
            ], 400);
        }
    }

    public function get(Request $request)
    {
        $filtro = $request->all();

        $trabajadores = Trabajador::_get($filtro);
        $cantidad = sizeof($trabajadores);

        return response()->json([
            'message' => $cantidad !== 1 ? "{$cantidad} coincidencias encontradas" : "{$cantidad} coincidencia encontrada",
            'data' => $trabajadores
        ], 200);
    }
}
