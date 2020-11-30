<?php

namespace App\Http\Controllers;

use App\Models\CargaBono;
use Illuminate\Http\Request;

class CargasBonosController extends Controller
{
    public function get(Request $request)
    {
        $bonoId = $request->query('bono_id');

        $result = CargaBono::where('bono_id', $bonoId)->orderBy('updated_at', 'DESC')->get();

        return [
            'message' => 'ok',
            'data' => $result
        ];
    }
}
