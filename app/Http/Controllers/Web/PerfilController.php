<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        $data = [
            'usuario' => $usuario,
            '_token' => $request->session()->token(),
            'submodule' => 'perfil',
        ];

        return view('pages.perfil', compact('data'));
    }

    public function changePassword(Request $request)
    {
        $usuarioId       = $request->get('usuarioId');
        $password        = $request->get('password');
        $confirmPassword = $request->get('confirmPassword');

        if ($password !== $confirmPassword) {
            return response()->json([
                'message' => 'Las contraseñas deben ser iguales'
            ]);
        }

        $usuario = Usuario::find($usuarioId);
        $usuario->password = md5(sha1($password));

        if ($usuario->save()) {
            return response()->json([
                'message' => 'Contraseña cambiada correctamente'
            ]);
        }

        return response()->json([
            'message' => 'Error al cambiar la contraseña'
        ]);
    }
}
