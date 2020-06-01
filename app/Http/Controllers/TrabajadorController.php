<?php

namespace App\Http\Controllers;

use App\Models\Trabajador;
use Illuminate\Http\Request;

class TrabajadorController extends Controller
{
    public function create(Request $request)
    {
        $trabajador = Trabajador::_create($request->all());
        return response()->json($trabajador);
    }
}
