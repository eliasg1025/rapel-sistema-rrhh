<?php

namespace App\Services;

use App\Models\Empresa;
use App\Models\EstadoDocumentoTuRecibo;
use App\Models\Regimen;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;

class DocumentosTuReciboService
{
    public UploadedFile $file;
    public int $empresaId;
    public int $tipoDocumentoId;

    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
        $name = $this->file->getClientOriginalName();
        $exploded_str = explode("-", $name);

        $this->empresaId = Empresa::where('shortname', $exploded_str[sizeof($exploded_str) - 2])->first()->id;
        $this->tipoDocumentoId = $exploded_str[sizeof($exploded_str) - 1] === 'BOLETAS' ? 2 : 1;
    }

    public function import()
    {
        $name = '/documentos-turecibo/' . now()->unix() . '.' . $this->file->getClientOriginalExtension();

        if (!\Storage::disk('public')->put($name, \File::get($this->file))) {
            return [
                'message' => 'Error al guardar el archivo',
                'error' => 'Error al guardar el archivo',
            ];
        }

        $correctos = 0;
        $errores = [];

        try {
            (new FastExcel)
                ->import(storage_path('app/public') . $name, function($line) use ($correctos, $errores) {
                    $text = explode('_', $line['Archivo']);
                    try {
                        DB::table('documentos_turecibo')->updateOrInsert(
                            [
                                'rut' => (string) trim($text[0]),
                                'mes' => (int) trim($text[2]),
                                'ano' => (int) trim($text[1]),
                                'empresa_id' => $this->empresaId
                            ],
                            [
                                'estado_id' => EstadoDocumentoTuRecibo::where('name', $line['Firmado'])->first()->id,
                                'email' => $line['Mail'],
                                'regimen_id' => Regimen::where('name', $line['Sector'])->first()->id,
                                'fecha_carga' => Carbon::parse($line['Fecha Carga']),
                                'fecha_firma' => Carbon::parse($line['Fecha Firma']),
                            ]
                        );

                        $correctos++;
                        return true;
                    } catch (\Exception $e) {
                        array_push($errores, [
                            'rut' => (string) trim($text[0]),
                            'error' => $e->getMessage() . ' -- ' . $e->getLine()
                        ]);
                        return false;
                    }
                });

            return [
                'message' => 'Importación completada',
                'correctos' => $correctos,
                'errores' => $errores
            ];
        } catch (\Exception $e) {
            return [
                'message' => 'Error al importar',
                'error' => $e->getMessage()
            ];
        }
    }
}
