<?php

namespace App\Http\Controllers;

use App\Services\ArchivosBancoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchivosBancoController extends Controller
{
    public function descargar(Request $request)
    {
        $files = Storage::disk('public')->files($request->get('link'));
        return response()->json($files);
    }

    public function liquidaciones(Request $request)
    {
        $path = '/archivos-banco/generados/finiquitos';

        $directories = Storage::disk('public')->directories($path);

        $directories = array_map(function($v) {
            $arr = explode("/", $v);
            $file = $arr[sizeof($arr) - 1];
            $exploded_str = explode("_", $file);
            return [
                'key' => $v,
                'empresa' => $exploded_str[0],
                'fecha_pago' => $exploded_str[1],
                'link' => $v
            ];
        }, $directories);

        return response()->json($directories);
    }
}
