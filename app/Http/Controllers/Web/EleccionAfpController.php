<?php

namespace App\Http\Controllers\Web;

use App\Exports\EleccionAfpExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EleccionAfpController extends Controller
{
    public function descargarEleccionesAfp(Request $request)
    {
        $data = $request->get('data');
        return (new EleccionAfpExport($data))->download('CUENTAS.xlsx');
    }
}
