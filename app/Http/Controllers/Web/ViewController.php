<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Contrato;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViewController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->has('usuario'))
            return redirect('/login');

        $usuario = $request->session()->get('usuario');
        $data = [
            'usuario' => $usuario
        ];
        return view('pages.home', compact('data'));
    }

    public function login(Request $request)
    {
        if ($request->session()->has('usuario'))
            return redirect('/');

        $usuario = $request->session()->get('usuario');
        return view('pages.login');
    }

    public function usuarios(Request $request)
    {
        if (!$request->session()->has('usuario'))
            return redirect('/login');
        $usuario = $request->session()->get('usuario');

        if ($usuario->rol !== 'admin') {
            return redirect('/');
        }
        $data = [
            'usuario' => $usuario
        ];
        return view('pages.usuarios', compact('data'));
    }

    public function trabajadores(Request $request)
    {
        if (!$request->session()->has('usuario'))
            return redirect('/login');
        $usuario = $request->session()->get('usuario');
        $data = [
            'usuario' => $usuario
        ];
        return view('pages.trabajadores', compact('data'));
    }

    public function registroIndividual(Request $request)
    {
        if (!$request->session()->has('usuario'))
            return redirect('/login');
        $usuario = $request->session()->get('usuario');
        $data = [
            'usuario' => $usuario
        ];
        return view('pages.registro-individual', compact('data'));
    }

    public function registorMasivo(Request $request)
    {
        if (!$request->session()->has('usuario'))
            return redirect('/login');
        $usuario = $request->session()->get('usuario');
        $data = [
            'usuario' => $usuario
        ];
        return view('pages.registro-masivo', compact('data'));
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
        ];

        return view('pages.registro-individual', compact('data'));
    }

    public function cuentas(Request $request)
    {
        if (!$request->session()->has('usuario'))
            return redirect('/login');
        $usuario = $request->session()->get('usuario');

        $empresas = DB::table('empresas')->get();

        $data = [
            'usuario' => $usuario,
            'empresas' => $empresas,
            'cuentas' => []
        ];
        return view('pages.cuentas', compact('data'));
    }
}
