<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BonosController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->bonos == 0 ) {
            $nombre_modulo = 'bonos';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'submodule' => 'main'
        ];

        return view('pages.bonos', compact('data'));
    }

    public function editar(int $id, Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->bonos == 0 ) {
            $nombre_modulo = 'bonos';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario'   => $usuario,
            'submodule' => 'editar',
            'editar'    => $id
        ];

        return view('pages.bonos', compact('data'));
    }
}
