<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use Illuminate\Http\Request;

class BancosController extends Controller
{
    public function get(int $empresa_id)
    {
        $result = Banco::where('empresa_id', $empresa_id)->get();

        return response()->json($result);
    }
}
