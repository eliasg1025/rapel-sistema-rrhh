<?php

namespace App\Http\Controllers;

use App\Models\MotivoPlanillaManual;
use Illuminate\Http\Request;

class MotivosPlanillasManualesController extends Controller
{
    public function get()
    {
        $data = MotivoPlanillaManual::all();

        return response()->json([
            'data' => $data
        ]);
    }
}
