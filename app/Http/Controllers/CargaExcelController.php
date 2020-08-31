<?php

namespace App\Http\Controllers;

use App\Models\CargaExcel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CargaExcelController extends Controller
{
    public function get()
    {
        $cargas = DB::table('carga_excels as xls')
            ->select('xls.id', 'xls.fecha_hora', 'xls.link', 'u.username', 'e.shortname as empresa')
            ->join('usuarios as u', 'u.id', '=', 'xls.usuario_id')
            ->join('empresas as e', 'e.id', '=', 'xls.empresa_id')
            ->orderBy('xls.fecha_hora', 'DESC')
            ->limit(30)->get();
        return response()->json($cargas);
    }
}
