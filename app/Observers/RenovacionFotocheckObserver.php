<?php

namespace App\Observers;

use App\Models\RenovacionFotocheck;
use Illuminate\Support\Facades\DB;

class RenovacionFotocheckObserver
{
    /**
     * Handle the renovacion fotocheck "created" event.
     *
     * @param  \App\RenovacionFotocheck  $renovacionFotocheck
     * @return void
     */
    public function created(RenovacionFotocheck $renovacionFotocheck)
    {
        DB::table('entidades_estados')->updateOrInsert(
            [
                'estado_id' => 1,
                'tipo_estado_id' => 3,
                'entidad_id' => $renovacionFotocheck->id
            ],
            [
                'estado_id' => 1,
                'tipo_estado_id' => 3,
                'entidad_id' => $renovacionFotocheck->id,
                'created_at' => now()
            ]
        );
    }

    /**
     * Handle the renovacion fotocheck "updated" event.
     *
     * @param  \App\RenovacionFotocheck  $renovacionFotocheck
     * @return void
     */
    public function updated(RenovacionFotocheck $renovacionFotocheck)
    {
        //
    }

    /**
     * Handle the renovacion fotocheck "deleted" event.
     *
     * @param  \App\RenovacionFotocheck  $renovacionFotocheck
     * @return void
     */
    public function deleted(RenovacionFotocheck $renovacionFotocheck)
    {
        //
    }

    /**
     * Handle the renovacion fotocheck "restored" event.
     *
     * @param  \App\RenovacionFotocheck  $renovacionFotocheck
     * @return void
     */
    public function restored(RenovacionFotocheck $renovacionFotocheck)
    {
        //
    }

    /**
     * Handle the renovacion fotocheck "force deleted" event.
     *
     * @param  \App\RenovacionFotocheck  $renovacionFotocheck
     * @return void
     */
    public function forceDeleted(RenovacionFotocheck $renovacionFotocheck)
    {
        //
    }
}
