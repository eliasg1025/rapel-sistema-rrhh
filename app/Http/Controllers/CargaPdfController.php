<?php

namespace App\Http\Controllers;

use App\Models\CargaPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CargaPdfController extends Controller
{
    public function get()
    {
        $cargas = DB::table('carga_pdfs as pdf')
            ->select('pdf.id', 'pdf.fecha_hora', 'pdf.link', 'u.username')
            ->join('usuarios as u', 'u.id', '=', 'pdf.usuario_id')
            ->orderBy('pdf.fecha_hora', 'DESC')
            ->limit(30)->get();
        return response()->json($cargas);
    }
}
