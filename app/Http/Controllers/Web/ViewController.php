<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
