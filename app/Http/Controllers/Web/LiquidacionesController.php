<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LiquidacionesController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->liquidaciones === 0 ) {
            $nombre_modulo = 'pagos';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        if ( $usuario->liquidaciones == 1 || $usuario->liquidaciones === 3 ) {
            return redirect('/liquidaciones-utilidades/consulta');
        }

        $data = [
            'usuario' => $usuario,
            'submodule' => 'main'
        ];

        return view('pages.liquidaciones', compact('data'));
    }

    public function consulta(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->liquidaciones === 0 ) {
            $nombre_modulo = 'pagos';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'submodule' => 'consulta'
        ];

        return view('pages.liquidaciones', compact('data'));
    }

    /*
    * Liquidaciones
    */

    public function liquidaciones(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->liquidaciones === 0 ) {
            $nombre_modulo = 'pagos';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        if ( $usuario->liquidaciones == 1 || $usuario->liquidaciones === 3 ) {
            return redirect('/liquidaciones-utilidades/l/pagados');
        }

        $data = [
            'usuario' => $usuario,
            'submenu' => 'sub1',
            'submodule' => 'l',
            'tipo_pago_id' => 1
        ];

        return view('pages.liquidaciones', compact('data'));
    }

    public function liquidacionesPagados(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->liquidaciones === 0 ) {
            $nombre_modulo = 'pagos';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'submenu' => 'sub1',
            'submodule' => 'l-pagados',
            'tipo_pago_id' => 1
        ];

        return view('pages.liquidaciones', compact('data'));
    }

    public function liquidacionesRechazos(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->liquidaciones === 0 ) {
            $nombre_modulo = 'pagos';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'submenu' => 'sub1',
            'submodule' => 'l-rechazos',
            'tipo_pago_id' => 1
        ];

        return view('pages.liquidaciones', compact('data'));
    }
}
