<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Services\ContratosService;
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
                $data = [
                    'trabajador' => $trabajador,
                    'contrato' => $contrato
                ];

                $pdf = \PDF::setOptions([
                    'images' => true
                ])->loadView('fichas-ingresos-obreros.rapel.contrato', $data);

                $filename = $trabajador->apellido_paterno . '-' . $trabajador->apellido_materno . '-' . $trabajador->rut . '-FICHA.pdf';

                return $pdf->stream($filename);
            } else {
                throw new \Exception();
            }

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function generarPdf(Request $request)
    {
        $result = (new ContratosService())->generarPdfMasivo($request->all());
        return response()->json($result, 200);
    }

    public function registroMasivo(Request $request)
    {
        $result = Contrato::massive_record($request->all());
        return response()->json($result);
    }

    public function registroIndividual(Request $request)
    {
        $result = Contrato::record($request->all());
        return response()->json($result, $result['error'] ? 400 : 200);
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
        $fecha_actual = Carbon::parse(Carbon::now())->format('Y-m-d');

        $files = \Storage::disk('public')->files($fecha_actual);
        $path = storage_path() . '/app/public';

        $f = [];
        foreach ($files as $file) {
            array_push($f, $path . '/' . $file);
        }

        $merger = new Merger();

        foreach ($f as $file) {
            $merger->addFile($file);
        }
        $createdPdf = $merger->merge();
        $filename = 'carga-pdf/' . $fecha_actual . '.pdf';

        if (\Storage::disk('public')->put($filename, $createdPdf)) {
            return true;
        }

        return false;
    }
}
