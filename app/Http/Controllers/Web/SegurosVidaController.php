<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class SegurosVidaController extends Controller
{
    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function index(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        $data = [
            'usuario'   => $usuario,
            'submodule' => 'main',
            'editar'    => 0
        ];

        return view('pages.seguros-vida', compact('data'));
    }
}
