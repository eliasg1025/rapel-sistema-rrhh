<?php

namespace App\Http\Controllers;

use App\Models\Bono;
use App\Services\BonosService;
use Illuminate\Http\Request;

class BonosController extends Controller
{
    private $bonosService;

    public function __construct()
    {
        $this->bonosService = new BonosService();
    }

    public function get()
    {
        $bonos = Bono::with('usuario')->get();

        return response()->json([
            'message' => 'Bonos obtenidos',
            'data' => $bonos
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
        ]);
    }

    public function getPlanillaBono(Request $request)
    {
        $empresaId = $request->get('empresaId');
        $desde = $request->get('desde');
        $hasta = $request->get('hasta');
        $zonasIds = $request->get('zonasIds');
        $laboresIds = $request->get('laboresIds');
        $cuartelesIds = $request->get('cuartelesIds');

        $data = $this->bonosService->queryResult(
            $empresaId,
            $desde,
            $hasta,
            $zonasIds,
            $laboresIds,
            $cuartelesIds
        );

        return response()->json([
            'message' => 'Planilla de bonos obtenida correctamente',
            'data' => $data
        ]);
    }
}
