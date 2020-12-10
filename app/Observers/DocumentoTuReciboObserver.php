<?php

namespace App\Observers;

use App\Models\DocumentoTuRecibo;
use Illuminate\Support\Facades\DB;

class DocumentoTuReciboObserver
{
    /**
     * Handle the documento tu recibo "created" event.
     *
     * @param  \App\DocumentoTuRecibo  $documentoTuRecibo
     * @return void
     */
    public function creating(DocumentoTuRecibo $documentoTuRecibo)
    {
        /* $tipoDocumentoId = $documentoTuRecibo->tipo_documento_turecibo_id;
        $estado = $documentoTuRecibo->estado;

        if ($tipoDocumentoId === 2) {
            if ($estado === 'FIRMADO CONFORME') {
                DB::table('documentos_turecibo')->where([
                    'rut' => $documentoTuRecibo->rut,
                    'empresa_id' => $documentoTuRecibo->empresa_id,
                    'estado' => 'NO FIRMADO',
                    'tipo_documento_turecibo_id' => $tipoDocumentoId,
                ])
                ->where('corte_turecibo_id', '<', $documentoTuRecibo->corte_turecibo_id)
                ->update([
                    'estado' => 'FIRMADO CONFORME'
                ]);
            }
        } */
    }

    /**
     * Handle the documento tu recibo "updated" event.
     *
     * @param  \App\DocumentoTuRecibo  $documentoTuRecibo
     * @return void
     */
    public function updating(DocumentoTuRecibo $documentoTuRecibo)
    {
        /* if ($documentoTuRecibo->tipo_documento_turecibo_id === 2) {
            if ($documentoTuRecibo->estado === 'FIRMADO CONFORME') {
                DB::table('documentos_turecibo')->where([
                    'rut' => $documentoTuRecibo->rut,
                    'empresa_id' => $documentoTuRecibo->empresa_id,
                    'estado' => 'NO FIRMADO',
                    'tipo_documento_turecibo_id' => $documentoTuRecibo->tipo_documento_turecibo_id,
                ])
                ->whereDate('fecha_carga', '<', $documentoTuRecibo->fecha_carga)
                ->update([
                    'estado' => 'FIRMADO CONFORME'
                ]);
            }
        } */
    }

    /**
     * Handle the documento tu recibo "deleted" event.
     *
     * @param  \App\DocumentoTuRecibo  $documentoTuRecibo
     * @return void
     */
    public function deleted(DocumentoTuRecibo $documentoTuRecibo)
    {
        //
    }

    /**
     * Handle the documento tu recibo "restored" event.
     *
     * @param  \App\DocumentoTuRecibo  $documentoTuRecibo
     * @return void
     */
    public function restored(DocumentoTuRecibo $documentoTuRecibo)
    {
        //
    }

    /**
     * Handle the documento tu recibo "force deleted" event.
     *
     * @param  \App\DocumentoTuRecibo  $documentoTuRecibo
     * @return void
     */
    public function forceDeleted(DocumentoTuRecibo $documentoTuRecibo)
    {
        //
    }
}
