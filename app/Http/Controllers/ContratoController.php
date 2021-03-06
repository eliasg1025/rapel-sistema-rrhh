<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Services\{ContratosService, FichasExcelService};
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    public function show($id)
    {
        $contrato = Contrato::_show($id);

        if ($contrato) {
            return response()->json([
                'message' => 'Contrato obtenido correctamente',
                'data' => $contrato
            ], 200);
        }

        return response()->json([
            'message' => 'Contrato no encontrado'
        ], 404);
    }

    public function verFichaIngreso(Contrato $contrato)
    {
        try {
            $trabajador = $contrato->trabajador;
            if ($contrato->empresa_id === 9) {
                $view = 'fichas-ingresos-obreros.rapel.contrato';
            } else if ($contrato->empresa_id === 14) {
                $view = 'fichas-ingresos-obreros.verfrut.contrato';
            } else {
                throw new \Exception();
            }

            $data = [
                'trabajador' => $trabajador,
                'contrato' => $contrato,
                'codigo' => 5 . '@' . $contrato->id
            ];

            $pdf = \PDF::setOptions([
                'images' => true,
                'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true ,'chroot' => public_path()
            ])->loadView($view, $data);

            $filename = $trabajador->apellido_paterno . '-' . $trabajador->apellido_materno . '-' . $trabajador->rut . '-FICHA.pdf';

            return $pdf->stream($filename);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage() . ' - ' . $e->getLine(),
            ]);
        }
    }

    public function generarPdf(Request $request)
    {
        $data = $request->get('data');
        $usuario = $request->get('usuario');
        $empresa_id = $request->get('empresa_id');
        $result = (new ContratosService())->generarPdfMasivo($empresa_id, $usuario, $data);

        if ( isset($result['error']) ) {
            return response()->json($result, 400);
        }
        return response()->json($result, 200);
    }

    public function generarFichaExcel(Request $request)
    {
        $data = $request->get('data');
        $usuario = $request->get('usuario');
        $empresa_id = $request->get('empresa_id');
        $result = (new FichasExcelService())->generarExcel($empresa_id, $usuario, $data);

        if ( isset($result['error']) ) {
            return response()->json($result, 400);
        }
        return response()->json($result);
    }

    public function registroMasivo(Request $request)
    {
        $result = Contrato::massiveRecord($request->all());
        return response()->json($result);
    }

    public function registroIndividual(Request $request)
    {
        $result = Contrato::record($request->all());
        return response()->json($result, $result['error'] ? 400 : 200);
    }

    public function registroIndividualReniec(Request $request)
    {
        ['contrato' => $contrato, 'dni' => $dni] = $request->all();

        $result = Contrato::recordReniec($contrato, $dni);
        return response()->json($result, $result['error'] ? 400 : 200);
    }

    public function editarMasivo(Request $request)
    {
        $contratos = $request->get('contratos');
        $datos_contrato = $request->get('datos_contrato');
        $result = Contrato::massiveEdit($contratos, $datos_contrato);
        return response()->json($result);
    }

    public function delete($id)
    {
        try {
            $contrato = Contrato::findOrFail($id);
            if ($contrato->delete()) {
                return response()->json([
                    'message' => 'Contrato eliminado correctamente'
                ], 200);
            }
            return response()->json([
                'message' => 'Error al eliminar contrato, inténtelo más tarde.'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Contrato no encontrado'
            ], 404);
        }
    }

    public function test(Contrato $contrato)
    {
        return Contrato::getZonaLaborContrato($contrato);
    }
}
