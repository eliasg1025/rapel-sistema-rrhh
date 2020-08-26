<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SctrController extends Controller
{
    public function consultas(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->sctr == 0 ) {
            $nombre_modulo = 'sctr';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'submodule' => 'consulta'
        ];

        return view('pages.sctr', compact('data'));
    }

    public function habilitar(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->sctr == 0 ) {
            $nombre_modulo = 'sctr';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'submodule' => 'habilitar'
        ];

        return view('pages.sctr', compact('data'));
    }

    public function reportes(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->sctr == 0 ) {
            $nombre_modulo = 'sctr';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'submodule' => 'reportes'
        ];

        return view('pages.sctr', compact('data'));
    }
}
