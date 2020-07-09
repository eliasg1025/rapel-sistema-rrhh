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
        return view('pages.home');
    }

    public function login(Request $request)
    {
        if ($request->session()->has('usuario'))
            return redirect('/');

        $usuario = $request->session()->get('usuario');
        return view('pages.login');
    }
}
