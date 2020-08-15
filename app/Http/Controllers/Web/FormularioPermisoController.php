<?php

namespace App\Http\Controllers\Web;

use App\Exports\FormulariosPermisoExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FormularioPermisoController extends Controller
{
    public function descargar(Request $request)
    {
        $headings = $request->get('headings');
        $data = $request->get('data');
        return (new FormulariosPermisoExport($headings, $data))->download('EXPORT.xlsx');
    }
}
