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

            // Definir encabezado
            $worksheet->getCell('C4')->setValue(Carbon::parse($this->fecha_pago)->format('d/m/Y'));
            $worksheet->getCell('C5')->setValue(Carbon::parse($this->fecha_pago)->format('m-Y'));

            // Obtener data
            $resumen = Liquidaciones::getResumenPorFechaPago($this->fecha_pago);

            $rapel = $resumen['rapel'];
            $verfrut = $resumen['verfrut'];

            // RAPEL
            foreach ($rapel as $value) {
                switch ($value->banco) {
                    case 'BANCO DE CREDITO':
                        $worksheet->getCell('C19')->setValue($value->cantidad_personas);
                        $worksheet->getCell('D19')->setValue($value->monto);
                        break;

                    case 'INTERBANK':
                        $worksheet->getCell('C24')->setValue($value->cantidad_personas);
                        $worksheet->getCell('D24')->setValue($value->monto);
                        break;

                    case 'BBVA BANCO CONTINENTAL':
                        $worksheet->getCell('C29')->setValue($value->cantidad_personas);
                        $worksheet->getCell('D29')->setValue($value->monto);
                        break;

                    case 'SCOTIABANK PERU':
                        $worksheet->getCell('C34')->setValue($value->cantidad_personas);
                        $worksheet->getCell('D34')->setValue($value->monto);
                        break;

                    case 'INTERAMERICANO FINANZAS':
                        $worksheet->getCell('C39')->setValue($value->cantidad_personas);
                        $worksheet->getCell('D39')->setValue($value->monto);
                        break;
                }
            }

            //VERFUT
            foreach ($verfrut as $value) {
                switch ($value->banco) {
                    case 'BANCO DE CREDITO':
                        $worksheet->getCell('I19')->setValue($value->cantidad_personas);
                        $worksheet->getCell('I19')->setValue($value->monto);
                        break;

                    case 'INTERBANK':
                        $worksheet->getCell('I24')->setValue($value->cantidad_personas);
                        $worksheet->getCell('J24')->setValue($value->monto);
                        break;

                    case 'BBVA BANCO CONTINENTAL':
                        $worksheet->getCell('I29')->setValue($value->cantidad_personas);
                        $worksheet->getCell('J29')->setValue($value->monto);
                        break;
                }
            }

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
