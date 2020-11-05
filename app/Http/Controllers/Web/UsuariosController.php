<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->has('usuario'))
            return redirect('/login');
        $usuario = $request->session()->get('usuario');

        if ($usuario->rol !== 'admin' || $usuario->usuarios == 0) {
            $nombre_modulo = 'usuarios';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }
        $data = [
            'usuario' => $usuario,
            'submodule' => 'main'
        ];
        return view('pages.usuarios', compact('data'));
    }

    public function roles(Request $request)
    {
        if (!$request->session()->has('usuario'))
            return redirect('/login');
        $usuario = $request->session()->get('usuario');

        if ($usuario->rol !== 'admin' || $usuario->usuarios == 0) {
            $nombre_modulo = 'usuarios';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }
        $data = [
            'usuario' => $usuario,
            'submodule' => 'roles'
        ];
        return view('pages.usuarios', compact('data'));
    }
}
