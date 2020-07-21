<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use Illuminate\Http\Request;

class CuentasController extends Controller
{
    public function create(Request $request)
    {
        $result = Cuenta::_create($request->all());
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
