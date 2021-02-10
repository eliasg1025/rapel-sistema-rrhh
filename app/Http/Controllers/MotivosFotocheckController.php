<?php

namespace App\Http\Controllers;

use App\Models\MotivoFotocheck;
use Illuminate\Http\Request;

class MotivosFotocheckController extends Controller
{
    public function get()
    {
        $data = MotivoFotocheck::all();

        return response()->json([
            'data' => $data
        ]);
    }
}
