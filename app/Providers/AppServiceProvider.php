<?php

namespace App\Providers;

use App\Models\DocumentoTuRecibo;
use App\Models\Finiquito;
use App\Models\GrupoFiniquito;
use App\Observers\FiniquitoObserver;
use App\Observers\GrupoFiniquitoObserver;
use App\Observers\DocumentoTuReciboObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        GrupoFiniquito::observe(GrupoFiniquitoObserver::class);
        Finiquito::observe(FiniquitoObserver::class);
        DocumentoTuRecibo::observe(DocumentoTuReciboObserver::class);
    }
}
