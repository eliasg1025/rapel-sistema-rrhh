<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;

class ImportarPagosService
{
    public string $path;
    public int $tipo_pago_id;

    public function __construct(string $path, $tipo_pago_id)
    {
        $this->path = storage_path('app/public') . $path;
        $this->tipo_pago_id = $tipo_pago_id;
    }

    public function execute()
    {
        try {
            (new FastExcel)
                ->import($this->path, function($line) {
                    return DB::table('pagos')->updateOrInsert(
                        [
                            'id' => $line['IdLiquidacion']
                        ],
                        [
                            'finiquito_id' => $line['IdFiniquito'],
                            'rut' => $line['RutTrabajador'],
                            'ano' => $line['Ano'],
                            'mes' => $line['Mes'],
                            'monto' => $line['MontoAPagar'],
                            'empresa_id' => $line['IdEmpresa'],
                            'fecha_emision' => date($line['FechaEmision']),
                            'banco' => $line['Banco'],
                            'numero_cuenta' => $line['NumeroCuentaBancaria']
                        ]
                    );
                });

            return [
                'message' => 'Importación completada existosamente'
            ];
        } catch (\Exception $e) {
            return [
                'message' => 'Error al importar',
                'error' => $e->getMessage()
            ];
        }
    }
}
