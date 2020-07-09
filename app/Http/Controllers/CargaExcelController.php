<?php

namespace App\Http\Controllers;

use App\Models\CargaExcel;
use Illuminate\Http\Request;

class CargaExcelController extends Controller
{
    public function get()
    {
        $cargas = CargaExcel::orderBy('fecha_hora', 'DESC')->get();
        return response()->json($cargas);
    }
}
