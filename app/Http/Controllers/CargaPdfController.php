<?php

namespace App\Http\Controllers;

use App\Models\CargaPdf;
use Illuminate\Http\Request;

class CargaPdfController extends Controller
{
    public function get()
    {
        $cargas = CargaPdf::orderBy('fecha_hora', 'DESC')->limit(30)->get();
        return response()->json($cargas);
    }
}
