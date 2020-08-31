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
            ->select('pdf.id', 'pdf.fecha_hora', 'pdf.link', 'u.username', 'e.shortname as empresa')
            ->join('usuarios as u', 'u.id', '=', 'pdf.usuario_id')
            ->join('empresas as e', 'e.id', '=', 'pdf.empresa_id')
            ->orderBy('pdf.fecha_hora', 'DESC')
            ->limit(30)->get();
        return response()->json($cargas);
    }
}
