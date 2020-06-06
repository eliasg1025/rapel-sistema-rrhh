<?php

namespace App\Http\Controllers;

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

    public function get()
    {
        $trabajadores = Trabajador::_get();
        return response()->json([
            'message' => 'Trabajadores obtenidos',
            'data' => $trabajadores
        ], 200);
    }
}
