<?php

namespace App\Http\Controllers;

use App\Models\ColorFotocheck;
use Illuminate\Http\Request;

class ColoresFotocheckController extends Controller
{
    public function get()
    {
        $data = ColorFotocheck::all();

        return response()->json([
            'data' => $data
        ]);
    }
}
