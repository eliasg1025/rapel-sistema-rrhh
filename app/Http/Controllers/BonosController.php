<?php

namespace App\Http\Controllers;

use App\Exports\BonosExport;
use App\Models\Bono;
use App\Models\CargaBono;
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
        $bonos = Bono::with('usuario')
            ->where('activo', 1)
            ->get();

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
        $data = $request->all();
        $actividades = [];
        $resultados = [];

        foreach ($data['output'] as $row) {

            $trabajadorData = [
                'Apellidos Y Nombres' => $row['nombre_completo'],
                'DNI' => $row['rut'],
                'Cod.' => $row['codigo'],
                'Banco' => $row['banco'],
                'Fecha Ingreso' => $row['fecha_ingreso'],
                'Fecha Finiquito' => $row['fecha_finiquito']
            ];

            $dataActividades = $trabajadorData;
            $dataResultados = $trabajadorData;

            foreach ($row['fechas'] as $key => $value) {
                $dataActividades[$key] = $value;
            }

            foreach ($row['resultado'] as $key => $value) {
                $dataResultados[$key] = $value;
            }

            array_push($actividades, $dataActividades);
            array_push($resultados, $dataResultados);
        }

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

        $path = '/cargas-bonos/' . time() . '.xlsx';

        (new FastExcel($sheets))->export(storage_path() . '/app/public' . $path);

        $bono = Bono::find($data['bono_id']);
        $name = $bono->name . ' ' . $data['desde'] . ' ' . $data['hasta'];

        $cargaBonos = CargaBono::where([
            'bono_id' => $data['bono_id'],
            'name' => $name
        ])->first();

        if (!$cargaBonos)
        {
            $cargaBonos = new CargaBono();
        }
        $cargaBonos->name = $bono->name . ' ' . $data['desde'] . ' ' . $data['hasta'];
        $cargaBonos->bono_id = $data['bono_id'];
        $cargaBonos->link = $path;
        $cargaBonos->save();

        return (new FastExcel($sheets))
            ->headerStyle($headerStyle)
            ->download('file.xlsx');
    }
}
