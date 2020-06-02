<?php

namespace App\Http\Controllers;

use App\Models\Trabajador;
use Illuminate\Http\Request;

class TrabajadorController extends Controller
{
    public function create(Request $request)
    {
        try {
            $crear_trabajador = Trabajador::_create($request->all());

            return response()->json([
                'message' => $crear_trabajador ? 'Trabajador creado correctamente' : 'El trabajador ya existe fue actualizado'
            ], $crear_trabajador ? 201 :200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage() . ' ' . $e->getTraceAsString()
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
