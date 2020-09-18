<?php

namespace App\Services;

use App\Models\Empresa;
use App\Models\Liquidaciones;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class ArchivosAprobacionService
{
    public $fecha_pago;

    public function __construct($fecha_pago)
    {
        $this->fecha_pago = $fecha_pago;
    }

    public function generate()
    {
        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path('app/public') . '/formato-aprobacion/base/FORMATO-APROBACION.xlsx');
            $worksheet = $spreadsheet->getActiveSheet();

            $resumen = Liquidaciones::getResumenPorFechaPago($this->fecha_pago);

            //

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $path = storage_path('app/public') . '/formato-aprobacion/generados/FORMATO-APROBACION-' . $this->fecha_pago . '.xlsx';
            $writer->save($path);

            return [
                'message' => 'Archivo generado correctamente',
                'ruta' => $path
            ];
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
                'message' => 'Error al generar el archivo'
            ];
        }
    }
}
