<?php

namespace App\Http\Controllers;

use App\Exports\ContratosExport;
use App\Models\Contrato;
use App\Services\{ContratosService, FichasExcelService};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use iio\libmergepdf\Merger;

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
                'contrato' => $contrato
            ];

            $pdf = \PDF::setOptions([
                'images' => true
            ])->loadView($view, $data);

            $filename = $trabajador->apellido_paterno . '-' . $trabajador->apellido_materno . '-' . $trabajador->rut . '-FICHA.pdf';

            return $pdf->stream($filename);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function generarPdf(Request $request)
    {
        $data = $request->get('data');
        $usuario = $request->get('usuario');
        $result = (new ContratosService())->generarPdfMasivo($usuario, $data);
        return response()->json($result, 200);
    }

    public function generarFichaExcel(Request $request)
    {
        $data = $request->get('data');
        $usuario = $request->get('usuario');
        $result = (new FichasExcelService())->generarExcel($usuario, $data);
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

    public function test(Request $request)
    {
        //return (new ContratosExport(2))->download('test.xlsx');
    }
}
