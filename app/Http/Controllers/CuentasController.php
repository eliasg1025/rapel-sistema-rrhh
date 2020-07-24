<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use App\Models\Usuario;
use Illuminate\Http\Request;

class CuentasController extends Controller
{
    public function create(Request $request)
    {
        $result = Cuenta::_create($request->all());

        if (!$result['error']) {
            return response()->json($result);
        }

        return response()->json($result, 400);
    }

    public function getAll(Request $request)
    {
        $usuario_id = $request->usuario_id;
        $fechas = [
            'desde' => $request->desde,
            'hasta' => $request->hasta,
        ];

        $result = Cuenta::_getAll($usuario_id, $fechas);

        if (isset($result['error'])) {
            return response()->json([
                'message' => $result['message']
            ]);
        }

        return response()->json($result);
    }

    public function delete($id)
    {
        $cuenta = Cuenta::find($id);
        if ($cuenta->delete()) {
            return response()->json([
                'message' => 'Cuenta borrada correctamente'
            ]);
        }

        return response()->json([
            'message' => 'Error al borrar la cuenta'
        ], 400);
    }

    public function verFichaCuenta(Cuenta $cuenta)
    {
        try {
            if ($cuenta->empresa_id === 9) {
                $view = 'documents.cambio-cuenta.rapel';
            } else if ($cuenta->empresa_id === 14) {
                $view = 'documents.cambio-cuenta.verfrut';
            } else {
                throw new \Exception();
            }

            $data = [
                'cuenta' => $cuenta
            ];

            $pdf = \PDF::setOptions([
                'images' => true
            ])->loadView($view, $data);

            $filename = $cuenta->trabajador->apellido_paterno . '-' . $cuenta->trabajador->apellido_materno . '-' . $cuenta->trabajador->rut . '-' . $cuenta->empresa->nombre_corto . '-CAMBIO-CUENTA.pdf';

            return $pdf->stream($filename);
        } catch(\Exception $e) {

        }
    }
}
