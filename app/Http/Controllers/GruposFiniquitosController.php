<?php

namespace App\Http\Controllers;

use App\Http\Requests\GruposFiniquitosPost;
use App\Services\GruposFiniquitosService;
use Illuminate\Http\Request;

class GruposFiniquitosController extends Controller
{
    public GruposFiniquitosService $gruposFiniquitosService;

    public function __construct()
    {
        $this->gruposFiniquitosService = new GruposFiniquitosService();
    }

    public function create(GruposFiniquitosPost $request)
    {
        $result = $this->gruposFiniquitosService->create(
            $request->usuario_id,
            $request->fecha_finiquito,
            $request->zona_labor,
            $request->ruta,
            $request->codigo_bus
        );

        return response()->json([
            'message' => 'Grupo creado correctamente',
            'data' => $result
        ]);
    }

    public function get(Request $request)
    {
        $usuarioId = $request->query('usuario_id');

        $result = $this->gruposFiniquitosService->get($usuarioId);

        return response()->json([
            'message' => 'Grupos obtenidos correctamente',
            'data' => $result
        ]);
    }
}
