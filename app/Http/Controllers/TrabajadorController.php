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
                'message' => $crear_trabajador  ? 'Trabajador creado correctamente' : 'No se creo trabajador'
            ], $crear_trabajador ? 200 : 400);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage() . ' ' . $e->getTraceAsString()
            ], 400);
        }
    }

    public function get()
    {
        try {
            $trabajadores = Trabajador::_get();
            return response()->json([
                'message' => 'Trabajadores obtenidos',
                'data' => $trabajadores
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
