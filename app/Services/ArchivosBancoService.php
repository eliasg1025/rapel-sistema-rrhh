<?php

namespace App\Services;

use App\Models\Empresa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Ramsey\Collection\Set;

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
        $bcp = $this->data['bcp'];

        if (sizeof($bcp) === 0) {
            return [
                'message' => 'No hay registros para este banco'
            ];
        }

        try {

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path('app/public') . '/archivos-banco/base/BCP.xlsm');
            $worksheet = $spreadsheet->getActiveSheet();

            $numero_cuenta = $this->empresa->id === 9 ? '4752274893094' : '4752467084018';
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

            $worksheet->getCell('F7')->setValueExplicit($numero_cuenta, DataType::TYPE_STRING);
            $worksheet->getCell('G7')->setValue($monto_total);
            $worksheet->getCell('H7')->setValue('FINIQUITOS ' . Carbon::parse($this->fecha_pago)->format('m-Y') );

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
            $writer->save(storage_path('app/public') . $this->directory . '/' . $this->empresa->shortname . '_BCP_' . $this->fecha_pago . '.xlsm');

            /*
            copy(
                storage_path('app/public') . '/archivos-banco/base/BCP.xlsm',
                storage_path('app/public') . $this->directory . '/' . $this->empresa->shortname . '_BCP_' . $this->fecha_pago . '.xlsm'
            );
            */
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
        $banbif = $this->data['banbif'];

        if (sizeof($banbif) === 0) {
            return [
                'message' => 'No hay registros para este banco'
            ];
        }
        try {

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
            $writer->save(storage_path('app/public') . $this->directory . '/' . $this->empresa->shortname . '_BANBIF_' . $this->fecha_pago . '.xlsm');

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
        $scotiabank = $this->data['scotiabank'];
        if (sizeof($scotiabank) === 0) {
            return [
                'message' => 'No hay registros para este banco'
            ];
        }
        try {
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
            $writer->save(storage_path('app/public') . $this->directory . '/' . $this->empresa->shortname . '_SCOTIABANK_' . $this->fecha_pago . '.xlsm');

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
        $data = $this->data['bbva'];
        if (sizeof($data) === 0) {
            return [
                'message' => 'No hay registros para este banco'
            ];
        }
        try {
            $numero_cuenta = $this->empresa->id === 9 ? '00110245880100004456' : '00110278000100019135';

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path('app/public') . '/archivos-banco/base/blank.xlsx');
            $worksheet = $spreadsheet->getActiveSheet();

            $worksheet->getCell('A1')->setValue($numero_cuenta, DataType::TYPE_STRING);
            $worksheet->getCell('B1')->setValue('PEN');
            $worksheet->getCell('C1')->setValue('A');
            $worksheet->getCell('D1')->setValue(now()->format('m-Y'));
            $worksheet->getCell('E1')->setValue('N');

            foreach ($data as $key => $row) {
                $i = $key + 2;

                $nombre_completo = $row['apellido_paterno'] . ' ' .$row['apellido_materno'] . ' ' . $row['nombre'];

                $worksheet->getCell('A' . $i)->setValue(strlen($row['rut']) === 8 ? 'L' : 'E');
                $worksheet->getCell('B' . $i)->setValueExplicit($row['rut'], DataType::TYPE_STRING);
                $worksheet->getCell('C' . $i)->setValue('P');
                $worksheet->getCell('D' . $i)->setValueExplicit($row['numero_cuenta'], DataType::TYPE_STRING);
                $worksheet->getCell('E' . $i)->setValue($nombre_completo);
                $worksheet->getCell('F' . $i)->setValue($row['monto']);
            }

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save(storage_path('app/public') . $this->directory . '/' . $this->empresa->shortname . '_BBVA_' . $this->fecha_pago . '.xlsx');

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
        $data = $this->data['interbank'];
        if (sizeof($data) === 0) {
            return [
                'message' => 'No hay registros para este banco'
            ];
        }
        try {
            $content = '';

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path('app/public') . '/archivos-banco/base/blank.xlsx');
            $worksheet = $spreadsheet->getActiveSheet();

            $ruts = array_unique(
                array_map(function($item) {
                    return $item['rut'];
                }, $data)
            );

            $arr = array_map(function($rut) use ($data) {

                $liquidaciones = array_filter($data, function($liq) use ($rut) {
                    return $liq['rut'] !== $rut;
                });

                $curr = current($liquidaciones);
                $monto = array_reduce($liquidaciones, function($acc, $item) {
                    $acc = $acc + $item['monto'];
                    return $acc;
                }, 0);

                return [
                    'rut' => $curr['rut'],
                    'apellido_paterno' => $curr['apellido_paterno'],
                    'apellido_materno' => $curr['apellido_materno'],
                    'nombre' => $curr['nombre'],
                    'numero_cuenta' => $curr['numero_cuenta'],
                    'monto' => round($monto, 2)
                ];

            }, $ruts);

            foreach ($arr as $key => $row) {
                $i = $key + 1;

                $worksheet->getCell('B' . $i)->setValueExplicit( $row['rut'], DataType::TYPE_STRING );
                $worksheet->getCell('C' . $i)->setValue( '1' );
                $worksheet->getCell('D' . $i)->setValue( $row['monto'] );
                $worksheet->getCell('H' . $i)->setValue( '09' );
                $worksheet->getCell('I' . $i)->setValue( '002' );
                $worksheet->getCell('J' . $i)->setValue( '01' );
                $worksheet->getCell('K' . $i)->setValueExplicit( substr($row['numero_cuenta'], 0, 3), DataType::TYPE_STRING );
                $worksheet->getCell('L' . $i)->setValueExplicit( substr($row['numero_cuenta'], 3), DataType::TYPE_STRING );
                $worksheet->getCell('M' . $i)->setValue( 'P' );
                $worksheet->getCell('N' . $i)->setValue( strlen($row['rut']) === 8 ? '01' : '03' );
                $worksheet->getCell('O' . $i)->setValue( $row['rut'] );
                $worksheet->getCell('P' . $i)->setValue( $row['apellido_paterno'] . ';' . $row['apellido_materno'] . ';' . $row['nombre'] );
            }
            /*
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

            Storage::disk('public')->put($this->directory . '/INTERBANK' . '.txt', $content);
            */

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save(storage_path('app/public') . $this->directory . '/' . $this->empresa->shortname . '_INTERBANK_' . $this->fecha_pago . '.xlsx');

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
