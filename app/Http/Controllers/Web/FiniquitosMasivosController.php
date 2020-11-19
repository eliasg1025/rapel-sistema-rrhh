<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Modulo;
use Illuminate\Http\Request;
use App\Services\UserService;

class FiniquitosMasivosController extends Controller
{
    public UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function index(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        $data = [
            'usuario' => $usuario,
            'submodule' => 'main'
        ];

        return view('pages.finiquitos', compact('data'));
    }
}
