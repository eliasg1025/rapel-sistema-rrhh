<?php

namespace App\Http\Controllers\Web;

use App\Exports\CuentasExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CuentasController extends Controller
{
    public function descargarCuentas(Request $request)
    {
        $data = $request->get('data');
        return (new CuentasExport($data))->download('CUENTAS.xlsx');
    }
}
