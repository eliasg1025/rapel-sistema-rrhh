<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoLicenciaController extends Controller
{
    public function get($empresaId)
    {
        $tiposLicencias = DB::table('tipo_licencias_medicas')->where('empresa_id', $empresaId)->get();
        return response()->json($tiposLicencias);
    }
}
