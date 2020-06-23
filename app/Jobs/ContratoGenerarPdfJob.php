<?php

namespace App\Jobs;

use App\Models\Contrato;
use App\Services\ContratosService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ContratoGenerarPdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Contrato
     */
    private $contrato;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Contrato $contrato)
    {

        $this->contrato = $contrato;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $fecha_actual = Carbon::parse(Carbon::now())->format('Y-m-d');
        $trabajador = $this->contrato->trabajador;

        $data = [
            'trabajador' => $trabajador,
            'contrato' => $this->contrato
        ];

        $content = \PDF::setOptions([
            'images' => true
        ])->loadView('fichas-ingresos-obreros.rapel.contrato', $data)->output();

        $filename = $fecha_actual . '/' . time() . '-' .$trabajador->apellido_paterno . '_' . $trabajador->nombre  .'-CONTRATO.pdf';
        \Storage::disk('public')->put($filename, $content);
    }
}
