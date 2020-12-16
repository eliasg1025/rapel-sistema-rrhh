<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Finiquito;
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
            'usuario'   => $usuario,
            'submodule' => 'main',
            'editar'    => 0
        ];

        return view('pages.finiquitos', compact('data'));
    }

    public function editar(Request $request, int $id)
    {
        $usuario = $request->session()->get('usuario');

        $data = [
            'usuario'   => $usuario,
            'submodule' => 'main',
            'editar'    => $id
        ];

        return view('pages.finiquitos', compact('data'));
    }

    public function registroIndividual(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        $data = [
            'usuario'   => $usuario,
            'submodule' => 'registro-individual'
        ];

        return view('pages.finiquitos', compact('data'));
    }

    public function registroAnalistas(Request $request)
    {
        $usuario = $request->session()->get('usuario');

        $data = [
            'usuario'   => $usuario,
            'submodule' => 'registro-analistas'
        ];

        return view('pages.finiquitos', compact('data'));
    }

    public function verFicha(Finiquito $finiquito)
    {
        try {
            $data = [
                'finiquito'     => $finiquito,
                'trabajador'     => $finiquito->trabajador,
                'codigo'         => 6 . '@' . $finiquito->id,
            ];

            $pdf = \PDF::setOptions([
                'images' => true
            ])->loadView('documents.' . $finiquito->tipoCese->sigla . '.index', $data);

            $filename = $finiquito->persona->apellido_paterno . '-' .
                $finiquito->persona->apellido_materno . '-' .
                $finiquito->persona->rut . '-' .
                $finiquito->empresa->nombre_corto . '-' .
                $finiquito->tipoCese->sigla . '.pdf';

            return $pdf->stream($filename);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage() . ' -- ' . $e->getLine()
            ]);
        }
    }
}
