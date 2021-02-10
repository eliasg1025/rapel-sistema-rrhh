<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\RenovacionFotocheck;
use App\Services\UserService;
use Illuminate\Http\Request;

class RegistroFotocheckController extends Controller
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

        return view('pages.registro-fotocheck', compact('data'));
    }

    public function verFicha(RenovacionFotocheck $renovacion)
    {
        try {
            $data = [
                'renovacion'     => $renovacion,
                'trabajador'     => $renovacion->trabajador,
                'codigo'         => 9 . '@' . $renovacion->id,
            ];

            $pdf = \PDF::setOptions([
                'images' => true
            ])->loadView('documents.carta-descuento.index', $data);

            $filename = $renovacion->trabajador->apellido_paterno . '-' .
                $renovacion->trabajador->apellido_materno . '-' .
                $renovacion->trabajador->rut . '-' .
                $renovacion->trabajador->nombre_corto . '-' .
                'CARTA-DESCUENTO' . '.pdf';

            return $pdf->stream($filename);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage() . ' -- ' . $e->getLine()
            ]);
        }
    }
}
