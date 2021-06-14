<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Contrato;
use App\Services\JwtAuthService;
use Illuminate\Http\Request;

class IngresosController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->has('usuario'))
            return redirect('/login');

        $usuario = $request->session()->get('usuario');
        $data = [
            'usuario' => $usuario
        ];

        switch ($usuario->ingresos) {
            case 2:
            case 1:
                $data = [
                    'usuario'  => $usuario,
                    'submodule' => 'home'
                ];

                return view('pages.ingresos', compact('data'));
            default:
                $nombre_modulo = 'ingresos';
                return view('pages.no-acceso', compact('nombre_modulo'));
        }
    }

    public function trabajadores(Request $request)
    {
        if (!$request->session()->has('usuario'))
            return redirect('/login');
        $usuario = $request->session()->get('usuario');
        $data = [
            'usuario' => $usuario,
            'submodule' => 'trabajadores'
        ];
        return view('pages.ingresos', compact('data'));
    }

    public function registroIndividual(Request $request)
    {
        if (!$request->session()->has('usuario'))
            return redirect('/login');
        $usuario = $request->session()->get('usuario');
        $data = [
            'usuario' => $usuario,
            'submodule' => 'registro-individual',
        ];
        return view('pages.ingresos', compact('data'));
    }

    public function registorMasivo(Request $request)
    {
        if (!$request->session()->has('usuario'))
            return redirect('/login');
        $usuario = $request->session()->get('usuario');
        $jwt = JwtAuthService::getToken($usuario);

        $data = [
            'usuario' => $usuario,
            'submodule' => 'registro-masivo',
            'token' => $jwt,
        ];
        return view('pages.ingresos', compact('data'));
    }

    public function editarRegistroIndividual($id, Request $request)
    {
        if (!$request->session()->has('usuario'))
            return redirect('/login');
        $usuario = $request->session()->get('usuario');
        $contrato = Contrato::_show($id);
        $data = [
            'usuario' => $usuario,
            'contrato' => $contrato['contrato'],
            'trabajador' => $contrato['trabajador'],
            'submodule' => 'registro-individual',
        ];

        return view('pages.ingresos', compact('data'));
    }
}
