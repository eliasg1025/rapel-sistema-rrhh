<?php

namespace App\Http\Controllers;

use App\Models\ZonaLabor;
use Illuminate\Http\Request;

class ZonaLaborController extends Controller
{
    public function get($empresa_id, Request $request)
    {
        $result = ZonaLabor::get($empresa_id, $request->query('habilitado'));

        return response()->json($result);
    }

    public function getAll()
    {
        $result = ZonaLabor::getAll();
        return response()->json($result);
    }
}
