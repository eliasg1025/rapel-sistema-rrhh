<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Contrato;
use App\Models\Cuenta;
use App\Models\EleccionAfp;
use App\Models\Empresa;
use App\Models\FormularioPermiso;
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

    public function perfil(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        $data = [
            'usuario' => $usuario
        ];

        return view('pages.perfil', compact('data'));
    }

    public function liquidaciones(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        $data = [
            'usuario' => $usuario,
            'submodule' => 'main'
        ];

        return view('pages.liquidaciones', compact('data'));
    }

    public function liquidacionesImportacion(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        $data = [
            'usuario' => $usuario,
            'submodule' => 'importacion'
        ];

        return view('pages.liquidaciones', compact('data'));
    }

    public function liquidacionesConsulta(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        $data = [
            'usuario' => $usuario,
            'submodule' => 'consulta'
        ];

        return view('pages.liquidaciones', compact('data'));
    }

    public function liquidacionesL(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        $data = [
            'usuario' => $usuario,
            'submodule' => 'l'
        ];

        return view('pages.liquidaciones', compact('data'));
    }

    public function liquidacionesU(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        $data = [
            'usuario' => $usuario,
            'submodule' => 'u'
        ];

        return view('pages.liquidaciones', compact('data'));
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
        $usuario = $request->session()->get('usuario');

        $empresas = DB::table('empresas')->get();

        switch ($usuario->cuentas) {
            case 1:
                $cuentas = Cuenta::_getByUsuario($usuario->id);

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

    public function editarCuenta(Request $request, int $id)
    {
        $usuario = $request->session()->get('usuario');

        $empresas = DB::table('empresas')->get();

        $cuenta = Cuenta::_get($id);
        switch ($usuario->cuentas) {
            case 1:
                $data = [
                    'usuario'  => $usuario,
                    'empresas' => $empresas,
                    'cuenta'   => $cuenta,
                ];

                return view('pages.cuentas.user', compact('data'));
            case 2:
                $data = [
                    'usuario'  => $usuario,
                    'empresas' => $empresas,
                    'cuenta'   => $cuenta
                ];

                return view('pages.cuentas.admin', compact('data'));
            default:
                $nombre_modulo = 'cuentas';
                return view('pages.no-acceso', compact('nombre_modulo'));
        }
    }

    public function afp(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        $data = [
            'usuario' => $usuario
        ];

        switch ($usuario->afp) {
            case 1:
            case 2:
                return view('pages.afp', compact('data'));
            default:
                $nombre_modulo = 'elección de afp';
                return view('pages.no-acceso', compact('nombre_modulo'));
        }

        return view('pages.afp', compact('data'));
    }

    public function permisos(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->permisos == 0 ) {
            $nombre_modulo = 'formularios de permiso';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'editar' => 0
        ];

        return view('pages.permisos', compact('data'));
    }

    public function editarPermiso(Request $request, int $id)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->permisos == 0 ) {
            $nombre_modulo = 'formularios de permiso';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'editar' => $id
        ];

        return view('pages.permisos', compact('data'));
    }

    public function atencionReseteoClave(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->reseteo_clave == 0 ) {
            $nombre_modulo = 'atencion de cambio de clave';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario
        ];

        return view('pages.atencion-reseteo-clave', compact('data'));
    }

    public function sanciones(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->sanciones == 0 ) {
            $nombre_modulo = 'sanciones';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'editar' => 0,
            'submodule' => 'sanciones',
        ];

        return view('pages.sanciones', compact('data'));
    }

    public function editarSancion(Request $request, int $id)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->sanciones == 0 ) {
            $nombre_modulo = 'sanciones';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'editar' => $id,
            'submodule' => 'sanciones'
        ];

        return view('pages.sanciones', compact('data'));
    }

    public function sancionesReportes(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->sanciones == 0 ) {
            $nombre_modulo = 'sanciones';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'editar' => 0,
            'submodule' => 'reportes',
        ];

        return view('pages.sanciones', compact('data'));
    }

    public function sancionesDesvinculaciones(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->sanciones == 0 ) {
            $nombre_modulo = 'sanciones';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'editar' => 0,
            'submodule' => 'desvinculaciones',
        ];

        return view('pages.sanciones', compact('data'));
    }

    public function usuarios(Request $request)
    {
        if (!$request->session()->has('usuario'))
            return redirect('/login');
        $usuario = $request->session()->get('usuario');

        if ($usuario->rol !== 'admin' || $usuario->usuarios == 0) {
            $nombre_modulo = 'usuarios';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }
        $data = [
            'usuario' => $usuario
        ];
        return view('pages.usuarios', compact('data'));
    }

    public function consultaTrabajadores(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->consultas_trabajadores == 0 ) {
            $nombre_modulo = 'consultas de trabajadores';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'submodule' => 'consulta'
        ];

        return view('pages.consultas-trabajadores', compact('data'));
    }

    public function historialConsultaTrabajadores(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        if ( $usuario->consultas_trabajadores == 0 ) {
            $nombre_modulo = 'consultas de trabajadores';
            return view('pages.no-acceso', compact('nombre_modulo'));
        }

        $data = [
            'usuario' => $usuario,
            'submodule' => 'historial-busqueda'
        ];

        return view('pages.consultas-trabajadores', compact('data'));
    }

    public function panel(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        $data = [
            'usuario' => $usuario
        ];
        return view('pages.panel', compact('data'));
    }
}
