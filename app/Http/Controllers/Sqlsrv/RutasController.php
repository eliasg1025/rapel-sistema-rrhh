<?php

namespace App\Http\Controllers\Sqlsrv;

use App\Http\Controllers\Controller;
use App\Models\Sqlsrv\Ruta;
use Illuminate\Http\Request;

class RutasController extends Controller
{
    public function getAll()
    {
        $result = Ruta::getAll();

        return response()->json($result);
    }
}
