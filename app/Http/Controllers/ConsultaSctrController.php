<?php

namespace App\Http\Controllers;

use App\Models\ConsultaSctr;
use Illuminate\Http\Request;

class ConsultaSctrController extends Controller
{
    public function create(Request $request)
    {
        $result = ConsultaSctr::_create($request->all());

        if ( isset($result['error']) ) {
            return response()->json([
                'message' => $result['error']
            ], 400);
        }

        return response()->json($result);
    }

    public function get($usuario_id)
    {
        $result = ConsultaSctr::_get($usuario_id);

        return response()->json($result);
    }
}
