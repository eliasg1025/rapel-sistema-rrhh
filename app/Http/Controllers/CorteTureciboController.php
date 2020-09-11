<?php

namespace App\Http\Controllers;

use App\Models\CorteDocumentoTurecibo;
use Illuminate\Http\Request;

class CorteTureciboController extends Controller
{
    public function getLast()
    {
        $result = CorteDocumentoTurecibo::getLast();

        return response()->json($result);
    }
}
