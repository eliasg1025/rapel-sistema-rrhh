<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use Illuminate\Http\Request;

class IncidenciaController extends Controller
{
    public function all()
    {
        $incidencias = Incidencia::all();

        return response()->json($incidencias, 200);
    }
}
