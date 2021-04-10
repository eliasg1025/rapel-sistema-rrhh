<?php

namespace App\Http\Controllers\Sqlsrv;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarcacionesAndroidController extends Controller
{
    public function get(Request $request)
    {
        $fecha = $request->get('fecha');

        return response()->json([
            'message' => 'Resultados obtenidos correctamente',
            'data' => $fecha
        ]);
    }
}
