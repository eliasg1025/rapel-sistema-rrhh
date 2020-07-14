<?php

namespace App\Http\Controllers\Web;

use App\Exports\TrabajadoresObservadosExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TrabajadorController extends Controller
{
    public function descargarObservado(Request $request)
    {
        $data = $request->get('data');
        return (new TrabajadoresObservadosExport($data))->download('OBSERVADOS.xlsx');
    }
}
