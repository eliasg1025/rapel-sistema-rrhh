<?php

namespace App\Services;

use App\Models\Empresa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class ArchivosBancoService
{
    public $fecha_pago;
    public $data;
    public $directory;
    public $empresa;
    public $tipo;

    public function __construct($tipo, Empresa $empresa, $fecha_pago, $data)
    {
        $this->fecha_pago = $fecha_pago;
        $this->empresa = $empresa;
        $this->data = $data;
        $this->tipo = $tipo;
        $this->directory =  '/archivos-banco/generados/' . $tipo . '/' . $this->empresa->shortname . '_' . $this->fecha_pago;
        $this->initDirectory();
    }

    private function initDirectory()
    {
        Storage::disk('public')->makeDirectory($this->directory);
    }

    public function archivosBcp()
    {
        try {
            $bcp = $this->data['bcp'];

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path('app/public') . '/archivos-banco/base/BCP.xlsm');
            $worksheet = $spreadsheet->getActiveSheet();


            $cantidad_abonos = '000000' . ((string) sizeof($bcp));
            $cantidad_abonos = substr($cantidad_abonos, -6);
            $fecha_proceso = Carbon::parse($this->fecha_pago)->format('Ymd');
            $monto_total = array_reduce($bcp, function($accumulator, $item) {
                return $accumulator + $item['monto'];
            }, 0);

            $worksheet->getStyle('B7')->getNumberFormat()->setFormatCode('@');
            $worksheet->getCell('B7')->setValue($cantidad_abonos);

            $worksheet->getStyle('C7')->getNumberFormat()->setFormatCode('@');
            $worksheet->getCell('C7')->setValueExplicit($fecha_proceso, DataType::TYPE_STRING);

            $worksheet->getCell('G7')->setValue($monto_total);
            $worksheet->getCell('H7')->setValue('FINIQUITOS ' . Carbon::parse($this->fecha_pago)->format('Y') );

            for ($i = 0; $i < sizeof($bcp); $i++) {
                $numero_celda = $i + 11;
                $nombre_completo = $bcp[$i]['apellido_paterno'] . ' ' .$bcp[$i]['apellido_materno'] . ' ' . $bcp[$i]['nombre'];
                $tipo_documento = strlen($bcp[$i]['rut']) === 8 ? '1' : '3';

                $worksheet->getCell('A' . $numero_celda)->setValue('A');
                $worksheet->getCell('B' . $numero_celda)->setValue('A');

                $worksheet->getCell('C' . $numero_celda)->setValueExplicit($bcp[$i]['numero_cuenta'], DataType::TYPE_STRING);

                $worksheet->getCell('D' . $numero_celda)->setValueExplicit($tipo_documento, DataType::TYPE_STRING);

                $worksheet->getCell('E' . $numero_celda)->setValueExplicit($bcp[$i]['rut'], DataType::TYPE_STRING);

                $worksheet->getCell('F' . $numero_celda)->setValue($nombre_completo);

                $worksheet->getCell('G' . $numero_celda)->setValue('S');

                $worksheet->getCell('H' . $numero_celda)->setValue($bcp[$i]['monto']);

                $worksheet->getCell('I' . $numero_celda)->setValue('S');
            }

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save(storage_path('app/public') . $this->directory . '/BCP.xlsm');

            return [
                'message' => 'Archivo generado correctamente'
            ];
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
                'message' => 'Error al generar el archivo del BCP'
            ];
        }
    }

    public function archivosBanbif()
    {
        try {
            $banbif = $this->data['banbif'];

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path('app/public') . '/archivos-banco/base/BANBIF.xlsm');
            $worksheet = $spreadsheet->getActiveSheet();

            $cantidad_abonos = sizeof($banbif);
            $monto_total = array_reduce($banbif, function($accumulator, $item) {
                return $accumulator + $item['monto'];
            }, 0);

            $worksheet->getCell('I6')->setValue($cantidad_abonos);
            $worksheet->getCell('I7')->setValue($monto_total);

            for ($i = 0; $i < sizeof($banbif); $i++) {
                $numero_celda = $i + 12;

                $tipo_documento = strlen($banbif[$i]['rut']) === 8 ? '1 - DNI' : '3 - Carne de Extranjería';

                $worksheet->getCell('B' . $numero_celda)->setValue($i + 1);
                $worksheet->getCell('C' . $numero_celda)->setValueExplicit($tipo_documento, DataType::TYPE_STRING);
                $worksheet->getCell('D' . $numero_celda)->setValueExplicit($banbif[$i]['rut'], DataType::TYPE_STRING);
                $worksheet->getCell('E' . $numero_celda)->setValueExplicit($banbif[$i]['apellido_paterno'], DataType::TYPE_STRING);
                $worksheet->getCell('F' . $numero_celda)->setValueExplicit($banbif[$i]['apellido_materno'], DataType::TYPE_STRING);
                $worksheet->getCell('G' . $numero_celda)->setValueExplicit($banbif[$i]['nombre'], DataType::TYPE_STRING);
                $worksheet->getCell('H' . $numero_celda)->setValue('H - Haberes');
                $worksheet->getCell('I' . $numero_celda)->setValue('038 - BIF');
                $worksheet->getCell('J' . $numero_celda)->setValueExplicit($banbif[$i]['numero_cuenta'], DataType::TYPE_STRING);
                $worksheet->getCell('K' . $numero_celda)->setValue('1 - Soles');
                $worksheet->getCell('L' . $numero_celda)->setValue($banbif[$i]['monto']);
                $worksheet->getCell('M' . $numero_celda)->setValue('5 = Haberes Quinta Categoria');
            }

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save(storage_path('app/public') . $this->directory . '/BANBIF.xlsm');

            return [
                'message' => 'Archivo generado correctamente'
            ];
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
                'message' => 'Error al generar el archivo del BANBIF'
            ];
        }
    }

    public function archivosScotiabank()
    {
        try {
            $scotiabank = $this->data['scotiabank'];
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path('app/public') . '/archivos-banco/base/SCOTIABANK.xlsm');
            $worksheet = $spreadsheet->getActiveSheet();

            for ($i = 0; $i < sizeof($scotiabank); $i++) {
                $numero_celda = $i + 8;
                $nombre_completo = $scotiabank[$i]['apellido_paterno'] . ' ' .$scotiabank[$i]['apellido_materno'] . ' ' . $scotiabank[$i]['nombre'];

                $worksheet->getCell('A' . $numero_celda)->setValue($i + 1);
                $worksheet->getCell('B' . $numero_celda)->setValue($nombre_completo);
                $worksheet->getCell('C' . $numero_celda)->setValue('REMUNERACIONES');
                $worksheet->getCell('D' . $numero_celda)->setValue(Carbon::parse($this->fecha_pago)->format('Y-m-d'));
                $worksheet->getCell('E' . $numero_celda)->setValue($scotiabank[$i]['monto']);
                $worksheet->getCell('F' . $numero_celda)->setValueExplicit('3', DataType::TYPE_STRING);
                $worksheet->getCell('G' . $numero_celda)->setValueExplicit(substr($scotiabank[$i]['numero_cuenta'], 0, 3), DataType::TYPE_STRING);
                $worksheet->getCell('H' . $numero_celda)->setValueExplicit(substr($scotiabank[$i]['numero_cuenta'], 3), DataType::TYPE_STRING);
                $worksheet->getCell('J' . $numero_celda)->setValueExplicit($scotiabank[$i]['rut'], DataType::TYPE_STRING);
            }

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save(storage_path('app/public') . $this->directory . '/SCOTIABANK.xlsm');

            return [
                'message' => 'Archivo generado correctamente'
            ];
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
                'message' => 'Error al generar el archivo del SCOTIABANK'
            ];
        }
    }

    public function archivosBbva()
    {
        try {
            $data = $this->data['bbva'];
            $content = '';

            foreach ($data as $row) {
                $nombre_completo = $row['apellido_paterno'] . ' ' .$row['apellido_materno'] . ' ' . $row['nombre'];

                $content .= '|' . (strlen($row['rut']) === 8 ? 'L' : 'E');
                $content .= '|' . $row['rut'] . '|P';
                $content .= '|' . $row['numero_cuenta'];
                $content .= '|' . $nombre_completo;
                $content .= '|' . $row['monto'];
                $content .= "\n";
            }
            Storage::disk('public')->put($this->directory . '/BBVA.txt', $content);

            return [
                'message' => 'Archivo generado correctamente'
            ];
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
                'message' => 'Error al generar el archivo del BBVA'
            ];
        }
    }

    public function archivosInterbank()
    {
        try {
            $data = $this->data['interbank'];
            $content = '';

            foreach ($data as $row) {
                $content .= '|' . $row['rut'] . '|01';
                $content .= '|' . $row['monto'] . '|';
                $content .= '|09|002|01';
                $content .= '|' . substr($row['numero_cuenta'], 0, 3) . '|' . substr($row['numero_cuenta'], 3) . '|P';
                $content .= '|' . (strlen($row['rut']) === 8 ? '01' : '03');
                $content .= '|' . $row['rut'];
                $content .= '|' . $row['apellido_paterno'] . ';' . $row['apellido_materno'] . ';' . $row['nombre'];
                $content .= "\n";
            }

            Storage::disk('public')->put($this->directory . '/INTERBANK.txt', $content);

            return [
                'message' => 'Archivo generado correctamente'
            ];
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
                'message' => 'Error al generar el archivo del INTERBANK'
            ];
        }
    }
}
