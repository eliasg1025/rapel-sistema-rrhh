<?php

namespace App\Http\Controllers;

use App\Services\ArchivosBancoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ArchivosBancoController extends Controller
{
    public function descargar(Request $request)
    {
        //$files = Storage::disk('public')->files($request->get('link'));

        $zip_files = 'archivos-banco.zip';
        $zip = new ZipArchive();
        $zip->open($zip_files, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $path = storage_path('app/public') . '/' . $request->get('link');
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath     = $file->getRealPath();

                // extracting filename with substr/strlen
                $relativePath = substr($filePath, strlen($path) + 1);

                $zip->addFile($filePath, $relativePath);
            }
        }

        $zip->close();

        return response()->download($zip_files);
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
