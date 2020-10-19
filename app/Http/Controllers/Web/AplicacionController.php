<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AplicacionController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->aplicacion == 0 ) {
            $nombre_modulo = 'aplicacion';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'submodule' => 'aplicacion',
            '_token' => $request->session()->token(),
            'editar' => 0
        ];

        return view('pages.aplicacion', compact('data'));
    }
}
