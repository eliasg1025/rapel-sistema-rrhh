<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresasController extends Controller
{
    public function all()
    {
        $empresas = Empresa::all();

        return response()->json($empresas, 200);
    }
}
