<?php


namespace App\Services;


use App\Jobs\ContratoGenerarPdfJob;
use App\Jobs\ContratoGenerarZipJob;
use App\Models\CargaPdf;
use App\Models\Contrato;
use Carbon\Carbon;
use iio\libmergepdf\Merger;

class ContratosService
{
    public function generarPdfMasivo($empresa_id, $usuario, array $data=[])
    {
        $generados = [];
        $errores = [];

        try {
            $fecha_actual = Carbon::parse(Carbon::now())->format('Y-m-d');
            foreach ($data as $d) {
                $contrato = Contrato::find($d['contrato_id']);
                $result = $this->generarPdfIndividual($contrato);

                if ($result['error']) {
                    array_push($errores, [
                        'contrato' => $contrato,
                        'error' => $result['error']
                    ]);
                } else {
                    array_push($generados, [
                        'contrato' => $contrato,
                        'filename' => $result['filename']
                    ]);
                }
            }

            $result = $this->unirPdfs($fecha_actual, $generados);
            if ($result['error']) {
                return [
                    'error' => $result['error']
                ];
            }
            $carga_pdf = new CargaPdf();
            $carga_pdf->fecha_hora = now()->toDateTimeString();
            $carga_pdf->link = $result['link'];
            $carga_pdf->usuario_id = $usuario['id'];
            $carga_pdf->empresa_id = $empresa_id;
            if ($carga_pdf->save()) {
                return [
                    'generados' => $generados,
                    'errores' => $errores,
                    'carga_pdf' => $carga_pdf
                ];
            }

            return [
                'generados' => $generados,
                'errores' => $errores,
                'carga_pdf' => 'No se guardo el registro de la carga pdf'
            ];
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage() . ' -- ' . $e->getLine()
            ];
        }
    }

    public function generarPdfIndividual(Contrato $contrato)
    {
        try {
            $trabajador = $contrato->trabajador;

            if ($contrato->empresa_id === 9) {
                $view = 'fichas-ingresos-obreros.rapel.contrato';
            } else if ($contrato->empresa_id === 14) {
                $view = 'fichas-ingresos-obreros.verfrut.contrato';
            } else {
                throw new \Exception();
            }

            $data = [
                'trabajador' => $trabajador,
                'contrato' => $contrato,
                'codigo' => 5 . '@' . $contrato->id
            ];

            $content = \PDF::setOptions([
                'images' => true,
                'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true ,'chroot' => public_path()
            ])->loadView($view, $data)->output();

            $filename = $contrato->fecha_inicio . '/' . time() . '-' . $trabajador->nombre_archivo  .'-CONTRATO.pdf';
            \Storage::disk('public')->put($filename, $content);

            return [
                'filename' => $filename,
                'error' => false
            ];
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage() . ' -- ' .$e->getLine()
            ];
        }
    }

    public function unirPdfs(string $fecha_actual, array $generados)
    {
        try {
            $path = storage_path() . '/app/public';

            $f = [];
            foreach ($generados as $file) {
                array_push($f, $path . '/' . $file['filename']);
            }

            $merger = new Merger();

            foreach ($f as $file) {
                $merger->addFile($file);
            }
            $createdPdf = $merger->merge();
            $filename = 'carga-pdf/' . $fecha_actual . '/' . time() .'.pdf';

            \Storage::disk('public')->put($filename, $createdPdf);

            return [
                'error' => false,
                'link' => 'carga-pdf/' . $fecha_actual . '/' . time() .'.pdf'
            ];
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage() . ' -- ' .$e->getLine()
            ];
        }
    }
}
