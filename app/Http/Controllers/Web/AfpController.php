<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AfpController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        $data = [
            'usuario' => $usuario,
            'submodule' => 'main'
        ];

        switch ($usuario->afp) {
            case 1:
            case 2:
                return view('pages.afp', compact('data'));
            default:
                $nombre_modulo = 'elección de afp';
                return view('pages.no-acceso', compact('nombre_modulo'));
        }

        return view('pages.afp', compact('data'));
    }
}
