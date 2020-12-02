<?php

namespace App\Helpers;

use iio\libmergepdf\Merger;

class PdfUtils
{
    public static function unirPdfs(string $path, string $name, array $generados)
    {
        try {
            $basePath = storage_path() . '/app/public';

            $f = [];
            foreach ($generados as $file) {
                array_push($f, $basePath . '/' . $file['filename']);
            }

            $merger = new Merger();

            foreach ($f as $file) {
                $merger->addFile($file);
            }
            $createdPdf = $merger->merge();
            $filename = $path . '/' . $name  .'.pdf';

            \Storage::disk('public')->put($filename, $createdPdf);

            return [
                'error' => false,
                'link' => $path . '/' . $name  .'.pdf'
            ];
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage() . ' -- ' .$e->getLine()
            ];
        }
    }
}
