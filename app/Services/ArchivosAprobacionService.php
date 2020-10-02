<?php

namespace App\Services;

use App\Models\Pago;
use Carbon\Carbon;

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
            $resumen = Pago::getResumenPorFechaPago($this->fecha_pago);

            $rapel = $resumen['liquidaciones']['rapel'];
            $verfrut = $resumen['liquidaciones']['verfrut'];

            // RAPEL
            foreach ($rapel as $value) {
                switch ($value->banco) {
                    case 'BANCO DE CREDITO':
                        $worksheet->getCell('C19')->setValue($value->cantidad);
                        $worksheet->getCell('D19')->setValue($value->monto);
                        break;

                    case 'INTERBANK':
                        $worksheet->getCell('C24')->setValue($value->cantidad);
                        $worksheet->getCell('D24')->setValue($value->monto);
                        break;

                    case 'BBVA BANCO CONTINENTAL':
                        $worksheet->getCell('C29')->setValue($value->cantidad);
                        $worksheet->getCell('D29')->setValue($value->monto);
                        break;

                    case 'SCOTIABANK PERU':
                        $worksheet->getCell('C34')->setValue($value->cantidad);
                        $worksheet->getCell('D34')->setValue($value->monto);
                        break;

                    case 'INTERAMERICANO FINANZAS':
                        $worksheet->getCell('C39')->setValue($value->cantidad);
                        $worksheet->getCell('D39')->setValue($value->monto);
                        break;
                }
            }

            //VERFUT
            foreach ($verfrut as $value) {
                switch ($value->banco) {
                    case 'BANCO DE CREDITO':
                        $worksheet->getCell('I19')->setValue($value->cantidad);
                        $worksheet->getCell('J19')->setValue($value->monto);
                        break;

                    case 'INTERBANK':
                        $worksheet->getCell('I24')->setValue($value->cantidad);
                        $worksheet->getCell('J24')->setValue($value->monto);
                        break;

                    case 'BBVA BANCO CONTINENTAL':
                        $worksheet->getCell('I29')->setValue($value->cantidad);
                        $worksheet->getCell('J29')->setValue($value->monto);
                        break;
                }
            }

            $rapel1 = $resumen['utilidades']['rapel'];

            // RAPEL
            foreach ($rapel1 as $value) {
                switch ($value->banco) {
                    case 'BANCO DE CREDITO':
                        $worksheet->getCell('C20')->setValue($value->cantidad);
                        $worksheet->getCell('D20')->setValue($value->monto);
                        break;

                    case 'INTERBANK':
                        $worksheet->getCell('C25')->setValue($value->cantidad);
                        $worksheet->getCell('D25')->setValue($value->monto);
                        break;

                    case 'BBVA BANCO CONTINENTAL':
                        $worksheet->getCell('C30')->setValue($value->cantidad);
                        $worksheet->getCell('D30')->setValue($value->monto);
                        break;

                    case 'SCOTIABANK PERU':
                        $worksheet->getCell('C35')->setValue($value->cantidad);
                        $worksheet->getCell('D35')->setValue($value->monto);
                        break;

                    case 'INTERAMERICANO FINANZAS':
                        $worksheet->getCell('C40')->setValue($value->cantidad);
                        $worksheet->getCell('D40')->setValue($value->monto);
                        break;
                }
            }

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $path = storage_path('app/public') . '/formato-aprobacion/generados/FORMATO-APROBACION_' . $this->fecha_pago . '.xlsx';
            $writer->save($path);

            return [
                'message' => 'Archivo generado correctamente',
                'ruta' => $path
            ];
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage() . ' -- ' . $e->getLine(),
                'message' => 'Error al generar el archivo'
            ];
        }
    }
}
