<?php

namespace App\Jobs;

use App\Models\DocumentoTuRecibo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessStoreManyFinquitos implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $usuario_id;
    protected $empresa_id;
    protected $tipo_documento_turecibo_id;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($usuario_id, $empresa_id, $tipo_documento_turecibo_id, $data)
    {
        $this->usuario_id = $usuario_id;
        $this->empresa_id = $empresa_id;
        $this->tipo_documento_turecibo_id = $tipo_documento_turecibo_id;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DocumentoTuRecibo::massiveCreate($this->usuario_id, $this->empresa_id, $this->tipo_documento_turecibo_id, $this->data);
    }
}
