<?php

namespace App\Http\Controllers\Web;

use App\Exports\CuentasExport;
use App\Http\Controllers\Controller;
use App\Models\Cuenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CuentasController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->cuentas == 0 ) {
            $nombre_modulo = 'cuentas';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'submodule' => 'cuentas',
            'editar' => 0
        ];

        return view('pages.cuentas', compact('data'));
    }

    public function editarCuenta(Request $request, int $id)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->cuentas == 0 ) {
            $nombre_modulo = 'cuentas';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'submodule' => 'cuentas',
            'editar' => $id
        ];

        return view('pages.cuentas', compact('data'));
    }

    public function descargarCuentas(Request $request)
    {
        $data = $request->get('data');
        return (new CuentasExport($data))->download('CUENTAS.xlsx');
    }
}
