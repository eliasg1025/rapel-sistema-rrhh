<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Contrato;
use App\Models\Cuenta;
use App\Models\Empresa;
use Carbon\Carbon;
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

        switch ($usuario->ingresos) {
            case 2:
            case 1:
                $data = [
                    'usuario'  => $usuario
                ];

                return view('pages.home', compact('data'));
            default:
                $nombre_modulo = 'ingresos';
                return view('pages.no-acceso', compact('nombre_modulo'));
        }
    }

    public function login(Request $request)
    {
        if ($request->session()->has('usuario'))
            return redirect('/');
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

        switch ($usuario->cuentas) {
            case 1:
                $cuentas = DB::table('cuentas as c')
                    ->select(
                        'c.id as id',
                        'c.fecha_solicitud',
                        't.rut',
                        DB::raw('CONCAT(t.nombre, " ", t.apellido_paterno, " ", t.apellido_materno) as nombre_completo'),
                        'b.name as banco_name',
                        'c.numero_cuenta',
                        'c.empresa_id as empresa'
                    )
                    ->join('trabajadores as t', 't.id', '=', 'c.trabajador_id')
                    ->join('bancos as b', 'b.id', '=', 'c.banco_id')
                    ->where([
                        'c.fecha_solicitud' => Carbon::now()->format('Y-m-d'),
                        'c.usuario_id' => $usuario->id
                    ])
                    ->get();

                $data = [
                    'usuario'  => $usuario,
                    'empresas' => $empresas,
                    'cuentas'  => $cuentas,
                ];

                return view('pages.cuentas.user', compact('data'));
            case 2:
                $data = [
                    'usuario'  => $usuario,
                    'empresas' => $empresas,
                ];

                return view('pages.cuentas.admin', compact('data'));
            default:
                $nombre_modulo = 'cuentas';
                return view('pages.no-acceso', compact('nombre_modulo'));
        }
    }

    public function panel(Request $request)
    {
        if (!$request->session()->has('usuario'))
            return redirect('/login');
        $usuario = $request->session()->get('usuario');

        $data = [
            'usuario' => $usuario
        ];
        return view('pages.panel', compact('data'));
    }
}
