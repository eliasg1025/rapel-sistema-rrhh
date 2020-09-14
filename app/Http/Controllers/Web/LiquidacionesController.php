<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LiquidacionesController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        $data = [
            'usuario' => $usuario,
            'submodule' => 'main'
        ];

        return view('pages.liquidaciones', compact('data'));
    }

    public function consulta(Request $request)
    {
        $usuario = $request->session()->get('usuario');

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

        $data = [
            'usuario' => $usuario,
            'submenu' => 'sub1',
            'submodule' => 'l'
        ];

        return view('pages.liquidaciones', compact('data'));
    }

    public function liquidacionesPagados(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        $data = [
            'usuario' => $usuario,
            'submenu' => 'sub1',
            'submodule' => 'l-pagados'
        ];

        return view('pages.liquidaciones', compact('data'));
    }

    public function liquidacionesRechazos(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        $data = [
            'usuario' => $usuario,
            'submenu' => 'sub1',
            'submodule' => 'l-rechazos'
        ];

        return view('pages.liquidaciones', compact('data'));
    }

    /*
    * Utilidades
    */

    public function utilidades(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        $data = [
            'usuario' => $usuario,
            'submenu' => 'sub2',
            'submodule' => 'u'
        ];

        return view('pages.liquidaciones', compact('data'));
    }

    public function utilidadesPagados(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        $data = [
            'usuario' => $usuario,
            'submenu' => 'sub2',
            'submodule' => 'u-pagados'
        ];

        return view('pages.liquidaciones', compact('data'));
    }

    public function utilidadesRechazos(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        $data = [
            'usuario' => $usuario,
            'submenu' => 'sub2',
            'submodule' => 'u-rechazos'
        ];

        return view('pages.liquidaciones', compact('data'));
    }
}
