<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $usuario = Usuario::verifyWeb($request->all());

        if (!$usuario) {
            $request->session()->flash('message', 'Error al verificar el usuario, inténtelo nuevamente');
            return redirect('/login');
        }

        $request->session()->put('usuario', $usuario);
        return redirect('/');
    }

    public function logout()
    {
    }
}
