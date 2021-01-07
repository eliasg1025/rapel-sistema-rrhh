<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AtencionReseteoClaveController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->reseteo_clave == 0 ) {
            $nombre_modulo = 'atencion de cambio de clave';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'submodule' => 'main',
        ];

        return view('pages.atencion-reseteo-clave', compact('data'));
    }

    public function reportes(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->reseteo_clave == 0 ) {
            $nombre_modulo = 'atencion de cambio de clave';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'submodule' => 'reportes',
        ];

        return view('pages.atencion-reseteo-clave', compact('data'));
    }
}
