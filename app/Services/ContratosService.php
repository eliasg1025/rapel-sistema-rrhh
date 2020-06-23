<?php


namespace App\Services;


use App\Jobs\ContratoGenerarPdfJob;
use App\Jobs\ContratoGenerarZipJob;
use App\Models\Contrato;
use Carbon\Carbon;

class ContratosService
{
    public function generate_pdf(array $data=[])
    {
        try {
            $fecha_actual = Carbon::parse(Carbon::now())->format('Y-m-d');
            foreach ($data as $d) {
                $contrato = Contrato::find($d['contrato_id']);
                dispatch(new ContratoGenerarPdfJob($contrato));
            }
            dispatch(new ContratoGenerarZipJob($fecha_actual));
            return $fecha_actual;
        } catch (\Exception $e) {
            return false;
        }
    }
}
