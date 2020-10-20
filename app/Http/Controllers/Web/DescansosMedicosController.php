<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DescansosMedicosController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->descansos_medicos == 0 ) {
            $nombre_modulo = 'descansos medicos';
            return view('pages.descansos-medicos', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'submodule' => 'main',
            'editar' => 0
        ];

        return view('pages.descansos-medicos', compact('data'));
    }

    public function registrarInformes(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->descansos_medicos == 0 ) {
            $nombre_modulo = 'descansos medicos';
            return view('pages.descansos-medicos', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'submodule' => 'registrar-informes',
            'editar' => 0
        ];

        return view('pages.descansos-medicos', compact('data'));
    }
}
