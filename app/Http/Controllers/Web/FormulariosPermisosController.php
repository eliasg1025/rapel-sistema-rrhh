<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FormulariosPermisosController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->permisos == 0 ) {
            $nombre_modulo = 'formularios de permiso';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'submodule' => 'main',
            'editar' => 0,
        ];

        return view('pages.permisos', compact('data'));
    }

    public function editar(Request $request, int $id)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->permisos == 0 ) {
            $nombre_modulo = 'formularios de permiso';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'submodule' => 'main',
            'editar' => $id,
        ];

        return view('pages.permisos', compact('data'));
    }
}
