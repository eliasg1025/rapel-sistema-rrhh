<?php

namespace App\Http\Controllers;

use App\Models\ConsultaTrabajador;
use Illuminate\Http\Request;

class ConsultaTrabajadorController extends Controller
{
    public function create(Request $request)
    {
        $result = ConsultaTrabajador::_create($request->all());

        if ( isset($result['error']) ) {
            return response()->json([
                'message' => $result['error']
            ], 400);
        }

        return response()->json($result);
    }

    public function get()
    {
        $result = ConsultaTrabajador::_get();

        return response()->json($result);
    }
}
