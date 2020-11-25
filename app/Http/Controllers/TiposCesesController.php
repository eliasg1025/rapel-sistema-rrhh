<?php

namespace App\Http\Controllers;

use App\Models\TipoCese;
use Illuminate\Http\Request;

class TiposCesesController extends Controller
{
    public function get()
    {
        $result = TipoCese::all();

        return response()->json([
            'message' => 'Data Obtenida',
            'data' => $result
        ]);
    }
}
