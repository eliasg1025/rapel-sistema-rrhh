<?php

namespace App\Http\Controllers;

use App\Models\Bono;
use App\Services\BonosService;
use Box\Spout\Writer\Style\StyleBuilder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;

class BonosController extends Controller
{
    private $bonosService;

    public function __construct()
    {
        $this->bonosService = new BonosService();
    }

    public function get()
    {
        $bonos = Bono::with('usuario')->where('activo', 1)->get();

        return response()->json([
            'message' => 'Bonos obtenidos',
            'data' => $bonos
        ]);
    }

    public function show(int $id)
    {
        $bono = Bono::with('usuario', 'empresa')->where('id', $id)->first();

        return response()->json([
            'message' => 'Bono obtenidos',
            'data' => $bono
        ]);
    }

    public function create(Request $request)
    {
        $bono = new Bono();
        $bono->usuario_id   = $request->get('usuarioId');
        $bono->name         = $request->get('name');
        $bono->descripcion  = $request->get('descripcion');
        $bono->empresa_id   = $request->get('empresaId');
        $bono->save();

        return response()->json([
            'message' => 'Bono creado correctamente',
            'data' => $bono
        ], 201);
    }

    public function delete(int $id)
    {
        $bono = Bono::find($id);
        $bono->activo = 0;
        $bono->save();

        return response()->json([
            'message' => 'Bono borrado correctamente',
            'data' => $id
        ]);
    }

    public function getPlanillaBono(Bono $bono, Request $request)
    {
        $desde = $request->query('desde');
        $hasta = $request->query('hasta');

        $data = $this->bonosService->getPlanilla($bono, $desde, $hasta);

        return response()->json([
            'message' => 'Planilla de bonos obtenida correctamente',
            'data' => $data
        ]);
    }

    public function update($id)
    {
        $data = Bono::where('id', $id)->update([
            'listo_para_usar' => 1
        ]);

        return response()->json([
            'message' => 'Estado actualizado correctamente',
            'data' => $id
        ]);
    }

    public function export(Request $request)
    {
        $actividades = $request->get('actividades') ?? [];
        $resultados = $request->get('resultados') ?? [];

        $listActividades = collect($actividades);
        $listResultados = collect($resultados);

        $headerStyle = (new StyleBuilder())->setFontBold()->build();

        $rowsStyle = (new StyleBuilder())
            ->setFontSize(15)
            ->setShouldWrapText()
            ->setBackgroundColor("EDEDED")
            ->build();

        $sheets = new SheetCollection([
            'Actividades' => $listActividades,
            'Reporte Publicar' => $listResultados
        ]);

        return (new FastExcel($sheets))
            ->headerStyle($headerStyle)
            ->download('file.xlsx');
    }
}
