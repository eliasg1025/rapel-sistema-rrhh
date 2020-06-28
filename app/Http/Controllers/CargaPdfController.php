<?php

namespace App\Http\Controllers;

use App\Models\CargaPdf;
use Illuminate\Http\Request;

class CargaPdfController extends Controller
{
    public function get()
    {
        $cargas = CargaPdf::all();
        return response()->json($cargas);
    }
}
