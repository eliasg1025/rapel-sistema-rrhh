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
}
